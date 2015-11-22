<?php 
session_start(); // Start session first thing in script
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "../storescripts/connect_to_mysql.php"; 
?>

<?php
$sid = $_POST['sid'];
$account_id = $_POST['account_id'];
$order_id = $_POST['order_id'];

$sql = "select * from temp_members where id='$account_id'";
$result = $con->query($sql);
$obj = $result->fetch_object();
$email = $obj->email;
$fname = $obj->firstname;
$lname = $obj->lastname;
$password = $obj->password;
$confirm_code = $obj->confirm_code;

$sql = "select * from orders where order_id='$order_id'";
$result = $con->query($sql);
$obj = $result->fetch_object();
$payment = $obj->payment;
$delivery = $obj->delivery;

if ($delivery == "fast") {
	$delivery = "Express Delivery";
   } else { $delivery = "Next 3 to 5 business days" ;}


$sql = "select * from address where account_id='$account_id'";   
$result = $con->query($sql);
$obj = $result->fetch_object();
$line1 = $obj->line1;
$line2 = $obj->line2;
$city = $obj->city;
$state = $obj->state;
$zip = $obj->zip;
$address = "$line1, "."$line2, "."$city, "."$state, "."$zip.";

echo "accountid: $account_id";   
echo "email: $email";
echo "fname : $fname";
echo "lname : $lname";
echo "payment: $payment";
echo "delivery: $delivery";
echo "address: $address";

$cartOutput = "";
$cartTotal = "";
$cartsubTotal = "";
$tax = "";
$shiping_cost = number_format(5, 2);
$pp_checkout_btn = '';
$product_id_array = '';
$orderSummary = '';

$cartOutput .= "<p><b>Dear customer, $fname </b></p>
                <p> Your order id : $order_id </p>
                <div align=\"center\">
				<p>Please Confirm order and account by clicking following link</p>
				<p>URL: http://localhost/obaju/confirmation.php?passkey=$confirm_code</p>
				</div> 				
                <p><center><h2> Order Summary </h2></center></p>";

$cartOutput .= "<table border=\"1\" style=\"width:100%\">
  <tr>
    <td>Id</td> 
    <td>Product Name</td>
    <td>Quantity</td>
    <td>Total</td>
  </tr>";
	
	$i = 0; 
	  foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = "SELECT * FROM user_storeproducts WHERE Product_Id='$item_id' LIMIT 1";
		$result = $con->query($sql);
		while ($row = $result->fetch_array()) {
			$product_name = $row["Product_Title"];
			$price = $row["Product_Price"];
			$price = number_format($price, 2);
			$details = $row["Product_Description"];
			
		}
		$pricetotal = $price * $each_item['quantity'];
		$cartsubTotal = $pricetotal + $cartsubTotal;
		// let's print the international format for the en_US locale
		$tax = $cartsubTotal * 0.1 ;
		$cartTotal = $cartsubTotal + $tax + $shiping_cost ;
		$tax = number_format($tax, 2);
		$cartsubTotal = number_format($cartsubTotal, 2);
		$pricetotal = number_format($pricetotal, 2);
		$cartTotal = number_format($cartTotal, 2);
		$x = $i + 1;
		// Create the product array variable
		$product_id_array .= "$item_id-".$each_item['quantity'].","; 
		// Dynamic table row assembly
		
		$id = $i + 1;
		$cartOutput .= "<tr>
		                <td>$id</td>
                        <td>$product_name</td>
						<td>$each_item[quantity]</td>
						<td>$pricetotal</td>
						</tr>";
		$i++; 
    } 
	 
	$cartOutput .= "</table>
	                <br>
					<br>
					<p>Net Sale: Rs $cartsubTotal</p>
					<p>Tax: Rs $tax</p>
					<p><b>Total Order: Rs $cartTotal</b></p>
					<p>Order will ship to this address : $address</p>
					<p>Order will charge by this method: $payment</p>
					<p>Order will deliver by this method: $delivery</p>";
	
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "whywewantorgamic@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "password";

//Set who the message is to be sent from
$mail->setFrom('whywewantorgamic@gmail.com', 'WhyWeWantOrganic');

//Set an alternative reply-to address
$mail->addReplyTo('whywewantorgamic@gmail.com', 'WhyWeWantOrganic');

//Set who the message is to be sent to
$mail->addAddress($email, $fname);

//Set the subject line
$mail->Subject = 'WhyWeWantOrganic Account Confirmation';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

$mail->IsHTML(true);
//$mail->AddEmbeddedImage('logo.jpg', 'logoimg', 'logo.jpg'); // attach file logo.jpg, and later link to it using identfier logoimg
/*$mail->Body = "<h1>Order Confirmation</h1>
    <div align=\"center\">
		<a href=\"http://www.whywewant.com/\"><img src=\"img/test1.png\" height=\"45\" width=\"45\"></a>
	</div>"; */
  $mail->Body = "$cartOutput";	
	
	
	
$mail->AltBody="This is text only alternative body.";

//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');



//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}