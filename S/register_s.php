<?php
session_start();
$s_id=session_id();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("../storescripts/connect_to_mysql.php");


$FormVars=$_POST;
$Errors=array();
$UserArray=array();

$Restaurant_Id=1000;
$User_Type='U';
$Estimated_EndDate="2099-12-31";
$Effective_FromDate=date('Y-m-d');
$TermsAgreed_Date="2099-12-31";
$Fee_date=date('Y-m-d');
$User_Title='';
$User_FirstName='';
$User_MiddleInitial='';
$User_LastName='';
$User_Email='';
$User_Mobile_No='';
$Address_Line1='';
$Address_Line2='';
$City='';
$Postal_Code='';
$User_SubType='';
$User_State='';
$User_Pass='';
$User_Cat='';
$Service_Type='';

//echo '<pre>'; print_r($FormVars);echo '</pre>';exit;


if (array_key_exists("user",$FormVars))
{   $User_Name=mysqli_real_escape_string($con,ltrim(rtrim($FormVars["user"])));	}

if (array_key_exists("email",$FormVars))
{   $User_Email=mysqli_real_escape_string($con,ltrim(rtrim($FormVars["email"])));	}

if (array_key_exists("pass",$FormVars))
{   $User_Pass=mysqli_real_escape_string($con,ltrim(rtrim($FormVars["pass"])));	}

if (array_key_exists("User_State",$FormVars))
{   $User_City=mysqli_real_escape_string($con,ltrim(rtrim($FormVars["User_State"])));	}

if (array_key_exists("User_Cat",$FormVars))
{   $User_Type=mysqli_real_escape_string($con,ltrim(rtrim($FormVars["User_Cat"])));	}



//validation  

if($User_Name=='' || is_null($User_Name))
{	$Errors["User_Name"]=120022;	}

if($User_Pass=='' || is_null($User_Pass))
{	$Errors["User_Pass"]=120026;	}


if($User_Email=='' || is_null($User_Email))
{	$Errors["User_Email"]=120023;	}

if($User_City=='' || is_null($User_City))
{	$Errors["User_City"]=120023;	}

if($User_Type=='' || is_null($User_Type))
{	$Errors["User_Type"]=120023;	}


$UserName=trim($User_Name);
$UserArray=explode(" ",$UserName);

$UserArrayCount=count($UserArray);
//echo $UserArrayCount.'<br>';
$UserMiddleInitial='';

foreach($UserArray as $keyName=>$valueName )
{
	if($UserArrayCount==1)
	{	
		$UserFirstName=$UserArray[$keyName];
		$UserMiddleInitial='';
		$UserLastName='';
	}
	elseif($UserArrayCount==2)
	{
		if($keyName==0)
		{	$UserFirstName=$UserArray[$keyName];	}
		if($keyName==1)
		{	$UserLastName=$UserArray[$keyName];	}
		$UserMiddleInitial='';
	}
	else
	{
		if($keyName==0)
		{	$UserFirstName=$UserArray[$keyName];	}
		elseif($keyName==($UserArrayCount-1))
		{	$UserLastName=$UserArray[$keyName];	}
		else
		{	$UserMiddleInitial.=$UserArray[$keyName].' ';}
	}
	
}



if (count($Errors)!=0)
{
	$_SESSION["Errors"]=$Errors;
	$_SESSION["FormVars"]=$FormVars;
	header("Location: register.php"); 
	exit;
}

$CurDate=time('Y-m-d');
$CurTime=time();

$Commit= "COMMIT";
mysqli_query($con,"begin");

$UserFirstName=mysqli_real_escape_string($con,trim($UserFirstName));
$UserMiddleInitial=mysqli_real_escape_string($con,trim($UserMiddleInitial));
$UserLastName=mysqli_real_escape_string($con,trim($UserLastName));
$Data_Gender='';
$EmailID=mysqli_real_escape_string($con,trim($User_Email));
$Gender='';




$insonetimepaasqry="INSERT INTO  `whywewant_userdetails` (`User_Id`,`Rec_Status`, `Rec_Seq`, `User_Title`, `User_FirstName`, `User_MiddleInitial`, `User_LastName`, `User_Email`, `User_Mobile_No`, `Address_Line1`, `Address_Line2`, `Address_Line3`, `City`, `Postal_Code`, `User_State`,`User_Type`, `User_SubType`, `User_Status`, `User_FromDate`, `ModifiedBy`, `ModifiedTime`) VALUES (NULL, 'A', '1', '{$User_Title}', '{$UserFirstName}', '{$UserMiddleInitial}', '{$UserLastName}', '{$User_Email}', '{$User_Mobile_No}', '{$Address_Line1}', '{$Address_Line2}', '', '{$User_City}', '{$Postal_Code}', '{$User_State}', '{$User_Type}', '{$Service_Type}', 'A', FROM_UNIXTIME('{$CurTime}'), '1', CURRENT_TIMESTAMP)";

if (!@ mysqli_query($con,$insonetimepaasqry))
{
	$Error_Query=$insonetimepaasqry;
	$errno=mysqli_errno($con);
	$error=mysqli_error($con);
	$_SESSION['DBErrors'][0]=41;
	GOTO ErrorProcessing;
}

$User_Id=mysqli_insert_id($con);

$InsertUserqry="INSERT INTO  `whywewant_user` (`User_Id`, `Rec_Status`, `Rec_Seq`, `User_Handle`, `User_Password`, `User_Type`, `User_SubType`, `User_PasswordChagedDate`, `Locked`, `Reset`, `CreatedBy`, `CreatedOn`, `ModifiedBy`, `ModifiedTime`) VALUES ($User_Id, 'A', '1', '{$User_Email}', md5('{$User_Pass}'), '{$User_Type}', '{$Service_Type}', FROM_UNIXTIME('{$CurTime}'), 'N', 'N', '1', FROM_UNIXTIME('{$CurTime}'), '1', CURRENT_TIMESTAMP)";

if (!@ mysqli_query($con,$InsertUserqry))
{
	$Error_Query=$InsertUserqry;
	$errno=mysqli_errno($con);
	$error=mysqli_error($con);
	$_SESSION['DBErrors'][0]=41;
	GOTO ErrorProcessing;
}


@mysqli_query($con,$Commit);
	
GOTO ExitProcessing;

ErrorProcessing:    
	$Commit='rollback';
	mysqli_query($Commit, $con);
	header("Location: register.php"); 
	exit;

ExitProcessing:

	$_SESSION['DBErrors'][0]="Successfully Registered on the portal,Please login.";    //print_r($_SESSION);  exit;
	header("Location: loginpage.php"); 
	exit; 
?>