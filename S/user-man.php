<?php

require 'PasswordHash.php';
require 'pwqcheck.php';

// In a real application, these should be in a config file instead
// sometimes looks like this: >>      ???mysql??.someserver.net 
$db_host = "localhost"; 
// Place the username for the MySQL database here 
$db_username = "root";  
// Place the password for the MySQL database here 
$db_pass = "";  
// Place the name for the MySQL database here 
$db_name = "ourstore"; 

##########################################################
// Do we have the pwqcheck(1) program from the passwdqc package?
$use_pwqcheck = FALSE;
// We can override the default password policy
$pwqcheck_args = '';
#$pwqcheck_args = 'config=/etc/passwdqc.conf';

// Base-2 logarithm of the iteration count used for password stretching
$hash_cost_log2 = 8;
// Do we require the hashes to be portable to older systems (less secure)?
$hash_portable = FALSE;

/* Dummy salt to waste CPU time on when a non-existent username is requested.
 * This should use the same hash type and cost parameter as we're using for
 * real/new hashes.  The intent is to mitigate timing attacks (probing for
 * valid usernames).  This is optional - the line may be commented out if you
 * don't care about timing attacks enough to spend CPU time on mitigating them
 * or if you can't easily determine what salt string would be appropriate. */
$dummy_salt = '$2a$08$1234567890123491089012';


// Are we debugging this code?  If enabled, OK to leak server setup details.
$debug = TRUE;

function fail($pub, $pvt = '')
{
	global $debug;
	$msg = $pub;
	if ($debug && $pvt !== '')
		$msg .= ": $pvt";
/* The $pvt debugging messages may contain characters that would need to be
 * quoted if we were producing HTML output, like we would be in a real app,
 * but we're using text/plain here.  Also, $debug is meant to be disabled on
 * a "production install" to avoid leaking server setup details. */
	exit("An error occurred ($msg).\n");
}


function my_pwqcheck($newpass, $oldpass = '', $user = '')
{
	global $use_pwqcheck, $pwqcheck_args;
	if ($use_pwqcheck)
		return pwqcheck($newpass, $oldpass, $user, '', $pwqcheck_args);

/* Some really trivial and obviously-insufficient password strength checks -
 * we ought to use the pwqcheck(1) program instead. */
	$check = '';
	if (strlen($newpass) < 7)
		$check = 'way too short';
	else if (stristr($oldpass, $newpass) ||
	    (strlen($oldpass) >= 4 && stristr($newpass, $oldpass)))
		$check = 'is based on the old one';
	else if (stristr($user, $newpass) ||
	    (strlen($user) >= 4 && stristr($newpass, $user)))
		$check = 'is based on the username';
	if ($check)
		return "Bad password ($check)";
	return 'OK';
}


function get_post_var($var)
{
	$val = $_POST[$var];
	if (get_magic_quotes_gpc())
		$val = stripslashes($val);
	return $val;
}


header('Content-Type: text/plain');

$op = $_POST['op'];
if ($op !== 'new' && $op !== 'login' && $op !== 'change')
	fail('Unknown request');

	
$user = get_post_var('user');
/* Sanity-check the username, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $user))
	fail('Invalid username');

$pass = get_post_var('pass');

/* Don't let them spend more of our CPU time than we were willing to.
 * Besides, bcrypt happens to use the first 72 characters only anyway. */
if (strlen($pass) > 72)
	fail('The supplied password is too long');



#$user = $_POST['user'];
#$pass = $_POST['pass'];



$db = new mysqli($db_host, $db_username, $db_pass, $db_name);
if (mysqli_connect_errno())
	fail('MySQL connect', mysqli_connect_error()); 


// Should validate the username length and syntax here

$hasher = new PasswordHash($hash_cost_log2, $hash_portable);

if ($op === 'new') {
    $email = $_POST['email'];
    if (($check = my_pwqcheck($pass, '', $user)) !== 'OK')
		fail($check);
		
	$hash = $hasher->HashPassword($pass);
	if (strlen($hash) < 20)
		fail('Failed to hash new password');
	unset($hasher);

	($stmt = $db->prepare('insert into users (user_name, user_password, user_email) values (?, ?, ?)'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('sss', $user, $hash, $email)
		|| fail('MySQL bind_param', $db->error);
	if (!$stmt->execute()) {
/* Figure out why this failed - maybe the username is already taken?
 * It could be more reliable/portable to issue a SELECT query here.  We would
 * definitely need to do that (or at least include code to do it) if we were
 * supporting multiple kinds of database backends, not just MySQL.  However,
 * the prepared statements interface we're using is MySQL-specific anyway. */
		if ($db->errno === 1062 /* ER_DUP_ENTRY */)
			fail('This username is already taken');
		else
			fail('MySQL execute', $db->error);
	}

	$what = 'User created ';
	
} 

else {
	$hash = '*'; // In case the user is not found
	($stmt = $db->prepare('select user_password from users where user_name=?'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $user)
		|| fail('MySQL bind_param', $db->error);
	$stmt->execute()
		|| fail('MySQL execute', $db->error);
	$stmt->bind_result($hash)
		|| fail('MySQL bind_result', $db->error);
	if (!$stmt->fetch() && $db->errno)
		fail('MySQL fetch', $db->error);
    // Mitigate timing attacks (probing for valid usernames)
	if (isset($dummy_salt) && strlen($hash) < 20)
		$hash = $dummy_salt;
		
	if ($hasher->CheckPassword($pass, $hash)) {
		$what = 'Authentication succeeded';
	} else {
		$what = 'Authentication failed';
		$op = 'fail'; // Definitely not 'change'
	}
	
	if ($op === 'change') {
		$stmt->close();

		$newpass = get_post_var('newpass');
		if (strlen($newpass) > 72)
			fail('The new password is too long');
		if (($check = my_pwqcheck($newpass, $pass, $user)) !== 'OK')
			fail($check);	
		$hash = $hasher->HashPassword($newpass);
		if (strlen($hash) < 20)
			fail('Failed to hash new password');
		unset($hasher);

		($stmt = $db->prepare('update users set user_password=? where user_name=?'))
			|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ss', $hash, $user)
			|| fail('MySQL bind_param', $db->error);
		$stmt->execute()
			|| fail('MySQL execute', $db->error);

		$what = 'Password changed';
	}

	unset($hasher);
}





$stmt->close();
$db->close();
//$sql = mysql_query("insert into users (user_name, user_password, user_email) values ('$user', '$hash', '$email')") or die (mysql_error());

echo "$what\n";

?>
