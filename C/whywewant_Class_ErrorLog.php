<?php
// Basic Class definition for Employee Object
require("../D/OC_DBConnect.php");

class ErrorLog
{
	public $emsg='';

	// get the basic details of the employee
	public function logError($Stmt,$Page,$User,$errno,$error)
	{
		$Campus_Id='';
		$Campus_Name='';
		$User_Name='';
		$ServerName=gethostname();
		$QryStmt=mysql_real_escape_string($Stmt);
		$error_msg=mysql_real_escape_string($error);
		
		$insertErrorLog="INSERT INTO mcd_admin_errorlog(User_Id, Page_Id, QueryStatement, Error_Code, Error_Message) VALUES($User, $Page, ('{$QryStmt}'), '{$errno}','{$error_msg}')"; 
		
		if (!@ mysql_query($insertErrorLog)) 
		{
			$emsg=76;
			return $emsg;
			//return $insertErrorLog;
		}
		
		$AdminTo="pramendra.raghuwanshi@optimusprimesolutions.co.in,rajesh.kumar@optimusprimesolutions.co.in,rajankumar.mishra@optimusprimesolutions.co.in,preeti.pandey@optimusprimesolutions.co.in";
		$EmailSubject = "MCD Server - Error on - ".date('d-M-Y H:i:s A');
		$Common_Headers = 'From: MCD Admin <narendra.gupta@optimusprimesolutions.co.in>'."\r\n";
		$Common_Headers=$Common_Headers.'Bcc: shahid.jamal@optimusprimesolutions.co.in,gireesh.shivapurmath@optimusprimesolutions.co.in'."\r\n";
		$BodyText = "";
		$Page_URL="";
		
		$getUserDetails=mysql_fetch_array(mysql_query("SELECT User_FName, User_MName, User_LName, Campus_Id FROM mcd_user_details WHERE User_Id=$User AND Rec_Status='A' AND User_Status='A'"));

		if($getUserDetails)
		{
			$User_Name=$getUserDetails["User_FName"].' '.$getUserDetails["User_MName"].' '.$getUserDetails["User_LName"];
			$Campus_Id=$getUserDetails["Campus_Id"];
			
			if($Campus_Id!=0)
			{
				$getCampus=mysql_fetch_array(mysql_query("SELECT Campus_Name FROM mcd_campuses WHERE Campus_Id=$Campus_Id AND Rec_Status='A' "));
				
				$Campus_Name=$getCampus["Campus_Name"];
			}
			else
			{
				$Campus_Name='Admin Person';
				$Campus_Id=' NA ';
			}
		}
		else 
		{
			$User_Name='Condition not match';
			$Campus_Id='Condition not match';
			$Campus_Name='Condition not match';
		}

		$getPageUrl=mysql_fetch_array(mysql_query("SELECT A.Page_URL FROM mcd_admin_pages A WHERE A.Page_Id=$Page "));
		
		if($getPageUrl)
		{	$Page_URL=$getPageUrl['Page_URL'];		}
		else
		{	$Page_URL='No Page Found - '.$Page;		}
	
		$BodyText=$BodyText.$ServerName." MCD- MyCampusDays Source \n Error in Page Number: ".$Page." Page URL: ".$Page_URL."\n\nTo User ".$User_Name." - of Campus ".$Campus_Name." and Campus Id ".$Campus_Id."\n\nFor query ".$Stmt."\n\nError number is: ".$errno." - And Msg:".$error_msg."\n\n".date('d-M-Y H:i:s A');

		//mail($AdminTo,$EmailSubject,$BodyText,$Common_Headers);
	}
}
?>