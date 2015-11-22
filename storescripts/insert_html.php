<?php

require "connect_to_mysql.php";  
$html = '<p style="text-align: justify;">Organic Tattva Brown rice not just ensures you get the lowest possible starch content but also gives you the most sumptuous tastes and the Organic guarantee that no one else gives like Organic Tattva.</p><p><b>Key Featues</b></p><ul><li>PACKING: Plastic pouch</li><li>Lot of Fibre</li></ul><p><i>Note: Store in dry conditions</i></p>';
$myString = ($html);
$id  = 13;

$insertDB = $con->prepare("UPDATE user_storeproducts SET Product_Description = ? WHERE Product_Id = ?");
$insertDB->bind_param('si', $myString, $id); //bind data, type string and int 'si'
$insertDB->execute(); //execute your query
$con->close(); //close connection

echo "<h1>Success in database connection! Happy Coding!</h1>";   
// if no success the script would have died before this success message 
?>