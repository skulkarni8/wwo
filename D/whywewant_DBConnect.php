<?php

//$con = mysql_connect("localhost","root","passw0rd");
$con = mysql_connect("localhost","admin","password");

if (!$con) {die('Could not connect: ' . mysql_error());}
//$dbconnect=mysql_select_db("mycampusdays", $con); 
$dbconnect=mysql_select_db("ourstore", $con); 
if (!$dbconnect) {die('Could not connect: '. mysql_error());}

?>
