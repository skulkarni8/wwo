<?php

// define variables and set to empty values
$nameErr = $emailErr = $error = $postmsg = $phone = $country = $countryErr = "";
$custname = $email = $comment = $posted = "";
$errName = $errEmail = $errMessage = $errHuman = $result  = $message = $phoneErr = "";

$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["custname"])) {
		 $nameErr = "Name is required";
		 $error = 1;
    } else {
		   $custname = test_input($_POST["custname"]);
		   // check if name only contains letters and whitespace
		   if (!preg_match("/^[a-zA-Z ]*$/",$custname)) {
		   $nameErr = "Only letters and white space allowed";
		   $error = 1;
		   }
	    }
   
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
	 $error = 1;
    } else {
     $email = test_input($_POST["email"]);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
		$error = 1;
      }
    }
	
	if (empty($_POST["phone"])) {
		 $phone = "Not Provided" ;
    } else {
		   $phone = test_input($_POST["phone"]);
		   // check if name only contains numbers
		   if (!preg_match("/^[0-9 ]*$/",$phone)) {
		   $phoneErr = "Only numbers allowed";
		   $error = 1;
		   }
	    }
	
	 if (empty($_POST["country"])) {
		 $countryErr = "Country is required";
		 $error = 1;
    } else {
		   $country = test_input($_POST["country"]);
		   // check if name only contains letters and whitespace
		   if (!preg_match("/^[a-zA-Z ]*$/",$country)) {
		   $countryErr = "Only letters and white space allowed";
		   $error = 1;
		   }
	    }  
		
	
    if (empty($_POST["comment"])) {
      $comment = "";
    } else {
      $comment = test_input($_POST["comment"]);
    }
}	
	
	function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * This shows settings to use when sending email via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that

 if (($_SERVER["REQUEST_METHOD"] == "POST") && (!empty($_POST["email"])) && (!empty($_POST["custname"])) && (!empty($_POST["country"])) && ($error != 1))  {
	 date_default_timezone_set('Etc/UTC');

	require 'PHPMailer/PHPMailerAutoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer;

	//Tell PHPMailer to use SMTP
	$mail->isSMTP();

	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	//$mail->SMTPDebug = 2;

	//Ask for HTML-friendly debug output
	//$mail->Debugoutput = 'html';

	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';

	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;

	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';

	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;

	//Username to use for SMTP authentication - use full email address for gmail
	//$mail->Username = "whywewantinnovation@gmail.com";
	$mail->Username = $useremail ;

	//Password to use for SMTP authentication
	//$mail->Password = "TYPEME";
	$mail->Password = $decrypted ;

	//Set who the message is to be sent from
	$mail->setFrom('whywewantinnovation@gmail.com', 'WhyWeWant Innovation');

	//Set an alternative reply-to address
	$mail->addReplyTo('whywewantinnovation@gmail.com', 'WhyWeWant Innovation');

	//Set who the message is to be sent to
	$mail->addAddress('whywewantinnovation@gmail.com', "whywewantinnovation");

	//Set the subject line
	$mail->Subject = 'WhyWeWant Innovation Inquiry';

	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

	$mail->IsHTML(true);
	//$mail->AddEmbeddedImage('logo.jpg', 'logoimg', 'logo.jpg'); // attach file logo.jpg, and later link to it using identfier logoimg
	$mail->Body = "<p> WhyWeWant Innovation received comment/Inquiry from: $custname </p> 
	               <p> Reply inquiry/comment to this email: $email <p> 
				    <p> Country: $country </p> 
				   <p> Contact number to give a call: $phone </p>
	               <p> comment: $comment </p>";

	//send the message, check for errors
	if (!$mail->send()) {
		// $posted = false;
		$posted = 2;
		 header( "Location:contactus.php?status=0" );
		//$success = "Oops..something went wrong, please try sending message again" ;
		
	} else {
		 //$posted = true;
		 $posted = 1;
		 header( "Location:contactus.php?status=1" );
		//$success = "Thank you for your interest. We will contact you as soon as possible!" ;
	}
} if ($error == 1) {
	 header( "Location:contactus.php?status=0" );
}
?>
