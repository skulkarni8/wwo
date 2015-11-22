<?php 
require_once("../S/whwewant_Class_DBConnect.php");
class User extends ConnObject
{
	Public $User_Data=array();
	Public $Error_Msg='';
	Public $User_details=array();

	
	public function getUserProfile($User_Id)
	{
			$con=$this->getConnObject();
			$this->User_Data=array();		
			$this->User_Data["Restaurant_Id"]=0;
			
			$getUser=mysqli_fetch_array(mysqli_query($con, "SELECT A.* FROM whywewant_userdetails A WHERE A.User_Id=$User_Id AND A.Rec_Status='A' AND A.User_Status='A' "));
			if (!$getUser)
			{
				$this->Error_Msg="Error in User Data. Please contact your System Administrator.";
				return;
			}
		
			$getUser_Handle=mysqli_fetch_array(mysqli_query($con, "SELECT A.User_Handle FROM whywewant_user A WHERE A.User_Id=$User_Id AND A.Rec_Status='A' AND A.User_Status='A' "));
		
			$this->User_Data["User_Id"]=$User_Id;
			$this->User_Data["User_Type"]=$getUser["User_Type"];
			$this->User_Data["User_Handle"]=$getUser_Handle["User_Handle"];
	
			$this->User_Data["Customer_Id"]=$getUser["Customer_Id"];
			

			$this->User_Data["User_Title"]=$getUser["User_Title"];
			$this->User_Data["User_FName"]=$getUser["User_FirstName"];
			$this->User_Data["User_MName"]=$getUser["User_MiddleInitial"];
			$this->User_Data["User_LName"]=$getUser["User_LastName"];
			
			$User_Name=$this->User_Data["User_FName"];
			if ($this->User_Data["User_MName"]!='')
			{	$User_Name=$User_Name.' '.$this->User_Data["User_MName"];	}
			$User_Name=$User_Name.' '.$this->User_Data["User_LName"];
			
			$this->User_Data["User_Name"]=$User_Name;
			
			$this->User_Data["User_SubType"]=$getUser["User_SubType"];

	}

	Public function getUserDetails($User_Id, $old_password)
	{	
		$con=$this->getConnObject();
		$this->User_details=array();
		$OldPassword='';
		if(!empty($old_password))
		{	$OldPassword=" AND User_Password=MD5('$old_password') ";	}
		$get_User=mysqli_fetch_array(mysqli_query($con, "select User_Id, Rec_Seq, User_Handle,  User_Email from  restaurant_user where User_Id=$User_Id $OldPassword AND Rec_Status='A'"));
			
		if($get_User)
		{
		   $this->User_details['User_Id']=$get_User["User_Id"];
		   $this->User_details['Rec_Seq']=$get_User["Rec_Seq"]+1;
		   $this->User_details['User_Handle']=$get_User["User_Handle"]; 
		   $this->User_details['User_Email']=$get_User["User_Email"]; 

		}	
		
	}
}
?>
