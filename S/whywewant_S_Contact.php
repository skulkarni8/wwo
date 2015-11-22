<?php
$Current_Page='whywewant_Contact.php';
require("whywewant_Initialization.php");

$_SESSION["FormVars"]=$FormVars;
$FormVars=$_POST;

//print_r($_POST); 
$_SESSION["Errors"]=array();


$name='';
$email='';
$phone='';
$comments='';


//print_r($FormVars); exit;
if(array_key_exists("name",$FormVars))
{	 $name=$FormVars["name"];   	}

if(array_key_exists("email",$FormVars))
{	$email=$FormVars["email"];	}

if(array_key_exists("phone",$FormVars))
{	$phone=$FormVars["phone"];	}

if(array_key_exists("comments",$FormVars))
{	$comments=$FormVars["comments"];	}


if (($email=='') || is_null($email))
{	$Errors["email"]=6010;	}


if (count($Errors)!=0)
{

	//print_r($Errors); die;
	$_SESSION["Errors"]=$Errors;
	$_SESSION["FormVars"]=$FormVars;

	header("Location:whywewant_Contact.php");
	exit;
}


//GOTO ExitProcessing;

//ExitProcessing:

//ini_set("SMTP","10.9.46.249");

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .='From: whywewant-Contact <'.$email.">\r\n";

$to = "rjnkmr04@gmail.com";


 $subject = "whywewant Contact";
echo $message = '<html>
<body>
Dear Sir, <p><br>Kindly find the Contact Person details:</br><p>

<p>Email id: '.$email.'</p>
<p>Phone: '.$phone.'</p>
<p>Comments: '.$comments.' </p>
<p>This message is from: '.$name.'<p>
</body>
</html>';

//$from = $name;
//$headers = "From:" . $from;
//mail($to,$subject,$message,$headers);
echo "Mail Sent.";  
exit;
//$msg="Thank you for your interest. We will get back to you soon.";
$_SESSION['DBErrors'][0]=6033;
header("Location: whywewant_Contact.php");
exit;

/* ErrorProcessing:

$Commit= "rollback";
mysql_query($Commit, $con);

$DBerror = new ErrorLog();
$_SESSION['DBErrors'][1]=$DBerror->logError($Error_Query,$Page_Id,$User_Id,$errno, $error);

header("Location: Am_Signup.php");
exit; */

?>