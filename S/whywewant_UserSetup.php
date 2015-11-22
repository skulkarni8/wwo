<?php
$Current_Page='whywewant_UserSetUp.php';

require("../C/whywewant_Class_User.php");

session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
function ipCheck()
{
	$ip='';
	if (isset($_SERVER["HTTP_CLIENT_IP"])) 
	{	$ip=$_SERVER["HTTP_CLIENT_IP"];				}
	elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) 
	{	$ip=$_SERVER["HTTP_X_FORWARDED_FOR"]; 		}
	elseif (isset($_SERVER["HTTP_X_FORWARDED"])) 
	{	$ip=$_SERVER["HTTP_X_FORWARDED"];   		}
	elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) 
	{	$ip=$_SERVER["HTTP_FORWARDED_FOR"];  		}
	elseif (isset($_SERVER["HTTP_FORWARDED"])) 
	{	$ip=$_SERVER["HTTP_FORWARDED"];	 			}

	$Pub_IP=$_SERVER['REMOTE_ADDR'];
	$ChannelType=$_SERVER["HTTP_USER_AGENT"];//To get channel type
	
	$i=array("Public"=>$Pub_IP, "Proxy"=>$ip, "Channel"=>$ChannelType);
	return $i;
}	

$InvalidAttempts=0;
$MaxInvalidAttempts=3;

$User_IPAddress=array();

$User_Id=0;

$User_Type='';
$UAdminRole='';
$User_Id=0;
$PassedCustomer_Id=0;



$FirstTimeLogin='F';
//print_r('Till this line.');


//print_r($_POST);exit;
//ID And Password Validation
if(isset($_POST['email']) && isset($_POST['password']))
{
	$User_Handle=($_POST["email"]);
	$Password=($_POST["password"]);

	if($User_Handle=="" && $Password=="")
	{
		$msg="<strong>Email and Password Cannot be empty</strong>";
		GOTO ErrorProcessing;
	}
	elseif($User_Handle=="")
	{
		$msg="<strong>Email Cannot be empty</strong>";
		GOTO ErrorProcessing;
	}
	elseif($Password=="")
	{
		$msg="<strong>Password Cannot be empty</strong>";
		GOTO ErrorProcessing;
	}
}
elseif(!isset($_POST['email']))
{	
	$msg="<strong>User ID Cannot be empty</strong>";
	GOTO ErrorProcessing;
}
elseif(!isset($_POST['password']))
{
	$msg="<strong>Password cannot be empty</strong>";
	GOTO ErrorProcessing;
}	

require("whywewant_ApplicationData.php");
//require("../C/whywewant_Class_ProcessMenu.php");
require("../storescripts/connect_to_mysql.php");

if (isset($_SESSION["Authentication"]["InvalidAttempts"]))
{ $InvalidAttempts=$_SESSION["Authentication"]["InvalidAttempts"];	}


$_SESSION=array();

$User_Handle=mysqli_real_escape_string($con,$User_Handle);	
$Password_Ins=mysqli_real_escape_string($con,$Password);	

$User_IPAddress=ipCheck();
$User_ProxyIP=$User_IPAddress["Proxy"];
$User_PublicIP=$User_IPAddress["Public"];
$User_ChannelType='';//$User_IPAddress["Channel"];

// get the current time for timestamp  
$CurTime=time();
$Cur_Date=date('Y-m-d');
list($Cur_Year, $Cur_Month, $Cur_Day)=explode("-",$Cur_Date);


$chkUser=mysqli_fetch_array(mysqli_query($con, "SELECT A.* FROM whywewant_user A WHERE A.User_Handle=('{$User_Handle}') AND A.Rec_Status='A'  "));

if (!$chkUser)
{
	/* $insertInvalidUser= "INSERT INTO mcd_admin_loginattempts (User_Handle, WrongHandle, User_Password, User_PublicIP, User_ProxyIP, Channel_Type, AttemptSuccessful) VALUES ('{$User_Handle}', '{$Yes}', '{$Password_Ins}', '{$User_PublicIP}', '{$User_ProxyIP}', '{$User_ChannelType}', '{$No}')";
	
	if (!@ mysqli_query($insertInvalidUser, $con)) 
	{
		$msg="Admin Error Logging -: insertInvalidUser ". mysqli_error();
		GOTO ErrorProcessing;
	} */
	
	$msg="ID entered is incorrect. Please try again ";
	GOTO ErrorProcessing;
}

/* if ($chkUser["User_Password"]!=md5($Password))
{
	$insertInvalidAttempt= "INSERT INTO mcd_admin_loginattempts (User_Handle, User_Password, User_PublicIP, User_ProxyIP, Channel_Type, AttemptSuccessful) VALUES ('{$User_Handle}', '{$Password_Ins}', '{$User_PublicIP}', '{$User_ProxyIP}',	'{$User_ChannelType}', ('{$No}'))";

	if (!@ mysqli_query($insertInvalidAttempt, $con)) 
	{
		$msg="Admin Error Logging -: insertInvalidAttempt ". mysqli_error();
		GOTO ErrorProcessing;
	}	
	
	$msg="Password is not correct. Please try again ";
	
	$InvalidAttempts++;
	
	if ($InvalidAttempts > $MaxInvalidAttempts)
	{
		$msg="Password is incorrect. Your Account is locked due to multiple attempts to login. Please contact your Admin. Thank you. ";
		$_SESSION['errormsg']=$msg;
		
		$LockUser="UPDATE mcd_users SET Locked=('{$Yes}'), ModifiedTime=FROM_UNIXTIME('{$CurTime}') WHERE User_Handle=('{$User_Handle}')";
		
		if (!@ mysqli_query($LockUser, $con)) 
		{
			$msg="Admin Error Logging -: LockUser ". mysqli_error();
			GOTO ErrorProcessing;
		}
		
		$InvalidAttempts=0;
	}
	
	$_SESSION["Authentication"]["InvalidAttempts"]=$InvalidAttempts;
	GOTO ErrorProcessing;
} */

// check if the account is locked due to previous attempts. If so, transfer the control back to the homepage with the appropriate message

if ($chkUser["Locked"]==$Yes)
{
	$msg="Your Account is locked due to multiple invalid attempts to login. Please contact your Admin. Thank you.";
	GOTO ErrorProcessing;
}

if ($chkUser["Reset"]!=$No)
{	$_SESSION["Reset"]=$chkUser["Reset"];	}

unset ($_SESSION["Authentication"]["InvalidAttempts"]);
$InvalidAttempts=0;

//Temperory Code	SS 5-6-2013
$User_ChannelType='';
//End

/* $insertLogin= "INSERT INTO mcd_admin_loginattempts (User_Handle, User_PublicIP, User_ProxyIP, Channel_Type, AttemptSuccessful, Attempt_Time) VALUES ('{$User_Handle}', '{$User_PublicIP}', '{$User_ProxyIP}', '{$User_ChannelType}', '{$Yes}', FROM_UNIXTIME('{$CurTime}'))";

if (!@ mysqli_query($insertLogin, $con)) 
{
	$msg="Admin Error Logging -: insertLogin ". mysqli_error();
	GOTO ErrorProcessing;
} */

$User_Id=$chkUser["User_Id"];
$User_Id=$chkUser["User_Id"];
$User_Type=$chkUser["User_Type"];


$User=new User;
$User->getUserProfile($User_Id);

if ($User->Error_Msg!='')
{
	$msg=$User->Error_Msg;
	GOTO ErrorProcessing;
}

$User_Data=$User->User_Data;


$User_Id=$User_Data["User_Id"];


$_SESSION["User"] = clone $User;
$_SESSION["S"]["Authenticated"]=$Yes;
$_SESSION["S"]["LogInTime"]=$CurTime;
$_SESSION["S"][$User_Id]["Welcome"]=$Yes;

$s_id=session_id();
$_SESSION["V"]["S"]=$s_id;
$_SESSION["V"]["P"]=$User_PublicIP;
$_SESSION["V"]["I"]=$User_ProxyIP;
$_SESSION["V"]["C"]=$User_ChannelType;
$_SESSION["V"]["T"]=$CurTime;
$_SESSION["V"]["U"]=$User_Id;//$User_Id
$_SESSION["V"]["M"]=$Restaurant_Id;

/* $Insrt="INSERT INTO tablewithnoname VALUES ('{$s_id}', '{$User_PublicIP}', '{$User_ProxyIP}',  FROM_UNIXTIME('{$CurTime}'), $Restaurant_Id, $User_Id, 'Y')";

if (!@ mysqli_query($Insrt, $con)) 
{
	$msg="Security logging error. Sorry for the inconvenience. Please contact your Administrator. ".mysqli_error();
	GOTO ErrorProcessing;
} */

$User_SubType='';


//Set the Process menu options for the User
/* $ProcessMenu=new ProcessMenu();
$ProcessMenu->buildMenu($User_Id, $Customer_Id, $User_Type, $User_SubType, 'Y');
$_Session["MenuOptions"]=$ProcessMenu->MenuOptions;
$_Session["Process_Group"]=$ProcessMenu->Process_Group; */

GOTO ExitProcessing;

ErrorProcessing:

	$_SESSION['errormsg']=$msg;
	header("Location: index.php"); 
	exit;	

ExitProcessing:
if($User_Type=='U')
{	header("Location: whywewant_homepage.php");	}
elseif($User_Type=='A')
{	header("Location: admin_userorderlist.php");	}



exit;

?>
