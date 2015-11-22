<?php

//Start the session
session_start();
require("whywewant_ApplicationData.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');
// Check in SESSION for array has index('S', 'V' ,'User') or not. If not Logout user from system.
/* if(!array_key_exists('S', $_SESSION) && !array_key_exists('V', $_SESSION) && !array_key_exists('User', $_SESSION))
{
	$_SESSION["errormsg"]="Please log in to the system.";
	//header("Location: Logout.php"); 
	exit;
} */


// Check if the UserId is set as Session variable. If not, transfer the control to login screen
/* if ($_SESSION["S"]["Authenticated"]!=$Yes)
{
	$_SESSION["errormsg"]="Please log in to the system.";
	header("Location: Logout.php"); 
	exit;
} */

$Key=0;

require("../storescripts/connect_to_mysql.php");

if(isset($_SESSION["User"]))
{
	$User=clone $_SESSION["User"];
	
	$User_Id=$User->User_Data['User_Id'];
	$User_Title=$User->User_Data['User_Title'];
	$User_Name=$User->User_Data['User_Name'];

	$User_Type=$User->User_Data['User_Type'];
	$User_SubType=$User->User_Data['User_SubType'];

	
	$T=$_SESSION["V"]["T"];
	$I=$_SESSION["V"]["I"];
	$P=$_SESSION["V"]["P"];
	$S=$_SESSION["V"]["S"];
	$U=$_SESSION["V"]["U"];
	$M=$_SESSION["V"]["M"];


	if (isset($_GET["User_Id"]))
	{	
		$Tx_User_Id=$_GET["User_Id"];	
		$_SESSION["S"]["Tx_User_Id"]=$Tx_User_Id;
	}

	if (isset($_SESSION["S"]["Tx_User_Id"]))
	{	$Tx_User_Id=$_SESSION["S"]["Tx_User_Id"];	}

}


if (isset($_SESSION["FormVars"]))
{
	$FormVars=$_SESSION["FormVars"];
	unset($_SESSION["FormVars"]);
}

if (isset($_SESSION["Errors"]))
{
	$Errors=$_SESSION["Errors"];
	unset($_SESSION["Errors"]);
}

// this code we will use in future
/*$URLpage=mysqli_fetch_array(mysqli_query("SELECT * FROM admin_pages WHERE Page_URL=('{$Current_Page}')"));

if ($URLpage)
{
	$Page_Id=$URLpage['Page_Id'];
	$Page["Page_Id"]=$URLpage['Page_Id'];
	$Page["Process_Id"]=$URLpage['Process_Id'];
	$Page["Event_Id"]=$URLpage['Event_Id'];
	$Page["Page_Title"]=$URLpage['Page_Title'];
	$Page["Page_DisplayName"]=$URLpage['Page_DisplayName'];
	
	$PageErrors_qry=mysqli_query("SELECT * FROM admin_pageerrors_v WHERE Page_Id IN ($Page_Id, 0) ORDER BY Error_Type, Error_Id");
	
	$num=mysqli_numrows($PageErrors_qry);
	
	if ($num!==0) 
	{
		$i=0;
		while ($i < $num)
		{
			$EId=mysqli_result($PageErrors_qry,$i,"Error_Id");
			$EType=mysqli_result($PageErrors_qry,$i,"Error_Type");
			$EMsg=mysqli_result($PageErrors_qry,$i,"Error_Text");
			$PageErrors[$EId]= array($EType,$EMsg);
			$i++;
		}
	}
}
else
{	$Page_Id=0;	}
$DataValues='';
 $UpdtTrace="INSERT INTO admin_txtracer ( User_Id, Session_Id, Channel_Type, Page_Id, DataValues) VALUES ($User_Id, '{$S}', '', $Page_Id, '{$DataValues}')";
		//echo '<br>'.$UpdtTrace;
if (!@ mysql_query($UpdtTrace, $con))
{
	
	$_SESSION["errormsg"]="Tracing update error. Please contact your Administrator.";
	header("Location: Logout.php"); 
	exit;
}
 */

?>