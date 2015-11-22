<?php

require_once("../S/whwewant_Class_DBConnect.php");
class MasterData extends ConnObject
{
	Public $getLocation_Codes=array();
	Public $getDelivery_Boy=array();

	public function getLocationCodes()
	{
		$this->getLocation_Codes=array(); 
		$con=$this->getConnObject();
		
		$getLocaCodes=mysqli_query($con,"SELECT A.* FROM whywewant_city A ");

		while ($row=mysqli_fetch_array($getLocaCodes))
		{
			$this->getLocation_Codes[]=array("City_Id"=>$row["City_Id"], 
									"State_Id"=>$row["State_Id"],
									"City"=>$row["City"]);
		}
	}	
	
}
?>