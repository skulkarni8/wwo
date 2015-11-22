<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "../storescripts/connect_to_mysql.php"; 
?>   

<?php
   	
	// Use me to generate ecryption
	//$input = "password_to_encrypt";
	//$encrypted = encryptIt( $input );
	//$decrypted = decryptIt( $encrypted) ;
	
	
	$sql = "SELECT * FROM admin WHERE id='1'";
	$result = $con->query($sql);
	
	while ($row = $result->fetch_array()) {
			$useremail = $row["username"];
			$encryptpassword = $row["password"];
		}
		
		$decrypted = decryptIt( $encryptpassword );
	
function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
} 
?>
