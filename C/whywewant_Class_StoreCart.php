<?php
require_once("../S/whwewant_Class_DBConnect.php");
Class Cart_Items extends ConnObject
{
	Public $Items=array();
	
	function getSubCaterogy($Category_Id='')
	{
		$con=$this->getConnObject();
		$this->SubCategory=array();
		

		$SupportCategory_Featured = mysqli_query($con,"SELECT Category_Id, Category_Name FROM  `user_store_category`  WHERE  Rec_Status='A'  ");
		
		while ($row=mysqli_fetch_array($SupportCategory_Featured))
		{	
			$Category_Id=$row["Category_Id"];
			$Category_Name=$row["Category_Name"];
			
			
			$this->SubCategory[$Category_Id]=array("Category_Name"=>$Category_Name);

		}	
		
	}

	function getCartItems($Product_Id,$Store_Id)
	{
		$con=$this->getConnObject();
		$this->Items=array();

		$getitems = mysqli_query($con,"SELECT `Variety_Id`,`Variety_Name` FROM `user_productvariations` WHERE `Product_Id`= $Product_Id AND `Rec_Status`='A' ");

		while ($row=mysqli_fetch_array($getitems))
		{	
			$Variety_Id=$row["Variety_Id"];
			$Variety_Name=$row["Variety_Name"];
			
			$getvarietyitems = mysqli_query($con,"SELECT `VarietyOption_Id`,`VarietyOption_Name`,`VarietyOption_Price` FROM `user_varietyoptions` WHERE `Variety_Id`=$Variety_Id");
			while ($row=mysqli_fetch_array($getvarietyitems))
			{
				
				$VarietyOption_Id=$row1["VarietyOption_Id"];
				$VarietyOption_Name=$row1["VarietyOption_Name"];
				$VarietyOption_Price=$row1["VarietyOption_Price"];
			
				$this->Items[$Variety_Name][$VarietyOption_Id]=array("VarietyOption_Name"=>$VarietyOption_Name, "VarietyOption_Price"=>$VarietyOption_Price);
				
			}	
			

		}	
	}
	
	function getItemsDetails($Catgory_ID='')
	{
		$con=$this->getConnObject();
		$this->Items_Detailinfo=array();
		

		$getItem_Info = mysqli_query($con,"SELECT A.`Product_Id`, A.`Product_Title`, A.`Product_Description`, A.`Product_Price`, A.`Product_SalePrice` , B.Category_Id FROM `user_storeproducts` A , `user_productscategory` B WHERE A.`Product_Id`= B.`Product_Id` AND B.Category_Id = $Catgory_ID AND A.`Rec_Status`='A' AND B.`Rec_Status`='A' ");

		while ($row=mysqli_fetch_array($getItem_Info))
			{
				$Product_Id=$row["Product_Id"];
				$Product_Title=$row["Product_Title"];
				$Product_Description=$row["Product_Description"];
				$Product_Price=$row["Product_Price"];
				$Product_SalePrice=$row["Product_SalePrice"];
				$Category_Id=$row["Category_Id"];
				
				$getItemimg_Info = mysqli_fetch_array($con,mysqli_query("SELECT B.Image_Name FROM `user_storeproducts` A , `user_storeproduct_images` B WHERE A.`Product_Id`= B.`Product_Id` AND B.Product_Id = $Product_Id AND A.`Rec_Status`='A' AND B.`Rec_Status`='A' "));
				
				if($getItemimg_Info)
				{	$Image_Name=$getItemimg_Info["Image_Name"];	}
			    else
				{	$Image_Name='';	}
				

				$this->Items_Detailinfo[]=array("Product_Title"=>$Product_Title,"Product_Description"=>$Product_Description,"Product_Price"=>$Product_Price,"Product_SalePrice"=>$Product_SalePrice,"Product_Id"=>$Product_Id,"Image_Name"=>$Image_Name);
				
			}
	
	}

    /* function getProductList($Category_Id=0)
	{
		$this->Items_Detailinfo=array();


		$getItem_Info = mysqli_query("SELECT `Product_Id`, `Product_Title`,`Product_Description`,`Product_Price`,`Product_SalePrice` FROM `user_storeproducts` C, `user_store_category` A, `user_productscategory` BWHERE `Product_Id`= $Product_Id AND `Store_Id`=$Store_Id AND `Rec_Status`='A' ");

		while ($row=mysqli_fetch_array($getItem_Info))
			{
				$Product_Id=$detailrow["Product_Id"];
				$Product_Title=$detailrow["Product_Title"];
				$Product_Description=$detailrow["Product_Description"];
				$Product_Price=$detailrow["Product_Price"];
				$Product_SalePrice=$detailrow["Product_SalePrice"];

				$this->Items_Detailinfo[$Product_Id]=array("Product_Title"=>$Product_Title,"Product_Description"=>$Product_Description,"Product_Price"=>$Product_Price,"Product_SalePrice"=>$Product_SalePrice);
				
			}
	} */
	
	
}

?>