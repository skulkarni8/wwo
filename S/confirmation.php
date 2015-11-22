<?php

include "storescripts/connect_to_mysql.php";

// Passkey that got from link
$passkey=$_GET['passkey'];

$tbl_name1="temp_members";

// Retrieve data from table where row that match this passkey
$sql1="SELECT * FROM $tbl_name1 WHERE confirm_code ='$passkey'";
$result1 = $con->query($sql1);

// If successfully queried
if($result1){

// Count how many row has this passkey
$count=$result1->num_rows;

// if found this passkey in our database, retrieve data from table "temp_members_db"
if($count==1){

$rows=$result1->fetch_array();
$firstname=$rows['firstname'];
$lastname=$rows['lastname'];
$email=$rows['email'];
$password=$rows['password'];
$phone=$rows['phone'];

$tbl_name2="registered_members";

// Insert data that retrieves from "temp_members_db" into table "registered_members"
$sql2="INSERT INTO $tbl_name2 (firstname, lastname, email, password, phone)VALUES('$firstname', '$lastname','$email', '$password', '$phone')";
$result2=$con->query($sql2);
}

// if not found passkey, display message "Wrong Confirmation code"
else {
echo "Wrong Confirmation code";
}

// if successfully moved data from table"temp_members_db" to table "registered_members" displays message "Your account has been activated" and don't forget to delete confirmation code from table "temp_members_db"
if($result2){

echo "Your account has been activated";

// Delete information of this user from table "temp_members_db" that has this passkey
$sql3="DELETE FROM $tbl_name1 WHERE confirm_code = '$passkey'";
$result3=$con->query($sql3);

}

}
?>