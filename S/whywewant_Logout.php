<?php
$Current_Page='OC_Logout.php';
session_start();


$LogOutTime=time();
$Rec_Seq=1;
$LoginTime='';

if(array_key_exists('S', $_SESSION))
{	$LoginTime= $_SESSION["S"]["LogInTime"]; }

$SessionTime=0;
$CurDate=date('Y-m-d');
$Page_Id=0;
$User_Id=0;
$SessionTime=intval(($LogOutTime-$LoginTime)/60)+1;
$Logout_Status='';

if(isset($_GET['Logout_Status']))
{	$Logout_Status=	$_GET['Logout_Status'];	}



$msg='';
$tmp=0;

if(isset($_SESSION["errormsg"]))
{	$msg=$_SESSION["errormsg"];	}

if (isset($_SESSION["Authentication"]["InvalidAttempts"]))
{ $tmp=$_SESSION["Authentication"]["InvalidAttempts"];	}

// clear the session variables for the transaction after storing the invalid login attempts, if it is set.
$_SESSION=array();
unset($_SESSION);
session_destroy();
session_regenerate_id();
session_start();

if($msg!='')
{	$_SESSION["errormsg"]=$msg;	}

if (!isset($_SESSION['errormsg']))
{	$_SESSION['errormsg']="You successfully logged out from the portal.";	}

if ($tmp!=0)
{	$_SESSION["Authentication"]["InvalidAttempts"]=$tmp;	}

header("Location: whywewant_homepage.php"); 
exit;	
?>
