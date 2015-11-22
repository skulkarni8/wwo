<?php
session_start();

$Current_Page='PL_StoreProduct.php';

require("D/PL_DBConnect.php");
require("C/PL_Class_StoreCart.php");
require("S/PL_Config.php");

$Base_Url = $Config["Base_Url"];

$Store_Id=0;
$Imgkey=1;
$ImgThumbkey=1;
$Active_Store=0;

if (isset($_GET["Store_Id"]))
{ $Store_Id=$_GET["Store_Id"];  }

if (isset($_GET["Category_Id"]))
{ $Category_Id=$_GET["Category_Id"];  }

$Category_Name='';
if (isset($_GET["Category_Name"]))
{ $Category_Name=$_GET["Category_Name"];  }

if (isset($_GET["Product_Id"]))
{ $Product_Id=$_GET["Product_Id"];  }

if (isset($_GET["Product_Price"]))
{ $Product_Price=$_GET["Product_Price"];  }

if (isset($_GET["Images_Name"]))
{ $MainImages_Name=$_GET["Images_Name"];  }

$Store_Data = new Cart_Items;
$Store_active = $Store_Data->CheckStore($pro_con,$Store_Id);

foreach ($Store_active AS $key5=>$value5)
	{
		$Active_Store=$value5["Store_Status"];
		
	}

if($Active_Store == 'I' )
	{
		header ("location: /invalid");
	   	exit;
	}
	
/*$Procuct_URL = new Cart_Items;
$Procuct_Details = $Procuct_URL->getProductURL($pro_con,$Store_Id);
foreach($Procuct_Details as $value1)
{
	$Store_Name = $value1['Store_Name'];
}
$Display_Url = "http://".$Store_Name.".bizbaze.com";*/

// $domainarray = explode('.', $_SERVER['HTTP_HOST']);
// $index=count($domainarray)-1;
// $domainname= $domainarray[$index-1].".".$domainarray[$index];

// $subdomainname="";

// for($i=0;$i<$index-1;$i++)
// {
//     if($subdomainname=="")
//     {    $subdomainname=$domainarray[$i];    }
//     else
//     {    $subdomainname=$subdomainname.".".$domainarray[$i];        }
// }
$Display_Url = $Base_Url;


$Cart_Items = new Cart_Items;
$Product_Details = $Cart_Items->getCartItems($pro_con,$Product_Id,$Store_Id);
$Store_Currency = $Cart_Items->getCurrency($pro_con,$Store_Id);

foreach ($Store_Currency as $key => $value) 
{
	$Currency=$value["Key_Code"];
}	
if($Currency == 'USD') 
{	$CurrencyType = '$';	}
else if($Currency == 'EUR')
{ 	$CurrencyType = '€';	}
else if($Currency == 'RUP')
{ 	$CurrencyType = '₹';	}
else
{ 	$CurrencyType = '£';	}

$_SESSION["Store_Currency"]=$Currency;

$SupportingImages = new Cart_Items;
$Image_Details = $SupportingImages->getSupportingImages($pro_con,$Product_Id);
//echo "<pre>"; print_r($Image_Details);

$Item_Details = $Cart_Items->getItemsDetails($pro_con,$Product_Id,$Store_Id);

foreach ($Item_Details as $key => $value) 
{
	$Product_Title=$value["Product_Title"];
	$Product_Description=$value["Product_Description"];
	$Product_Price=$value["Product_Price"];
	$Product_SalePrice=$value["Product_SalePrice"];
}	

// echo '<pre>';
//echo "<pre>"; print_r($Product_Details); echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>bizbaze | My Store</title>

<!-- Bootstrap -->
<link href="<?php $Base_Url; ?>/css/store-main.css" rel="stylesheet">
<link href="<?php $Base_Url; ?>/css/store.default.css" rel="stylesheet">
<link href="<?php $Base_Url; ?>/css/bootstrap-magnify.min.css"  rel="stylesheet">


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<script type="text/javascript">
var js_varOptionAmount= new Array();
var c_type='<?php echo ($CurrencyType);?>';
var base_url='<?php echo $Display_Url; ?>';
<?php

$i=0;
foreach($Product_Details as $key => $value)
{
	foreach($value as $key1 => $value1)
	{ 
		$VO_Price=$value1["VarietyOption_Price"];
		echo "js_varOptionAmount[$i]=new Array('{$key}',{$key1},'{$VO_Price}');\n" ;
		$i++;
	}
}
?>

console.log(js_varOptionAmount);
// alert(js_varOptionAmount);
function getAmount(Id)
{
	i=0;
	var totaloptions=js_varOptionAmount.length;

	while (i < totaloptions)
	{
		if (js_varOptionAmount[i][1]==Id)
		{ return js_varOptionAmount[i][2]; }

		i++;
	}
	return 0;
}


function getProductAmount()
{
	j=0;
	var totaloptions=js_varOptionAmount.length;

	var idSelectBoxPre='';
	var idSelectBox='';
	var addAmount=0.00;
	while (j < totaloptions)
	{
		idSelectBox = document.getElementById(js_varOptionAmount[j][0]).value;

		if(idSelectBoxPre==idSelectBox)
		{
			j++;
			continue;
		}
		idSelectBoxPre=idSelectBox;
		
		var VO_Array = idSelectBox.split("_");
		addAmount+=parseFloat(getAmount(VO_Array[1]));
		j++;
	}
	
	var b_price = parseFloat(document.getElementById("Base_Price").value);
	var q_price = parseFloat(document.getElementById("Qty").value);
	var h_price = parseFloat(b_price+addAmount);
	var t_price = parseFloat((b_price+addAmount)*q_price);
	document.getElementById("price_hidden").value=h_price;
	$('#price').html(c_type+''+t_price.toFixed(2));
}
	
  	function addtocart()
		{   
			
		if(confirm('One item will be added cart'))
			{	
			    var str = $("form").serialize();
			    var url=(base_url+"/S/PL_BuildStoreProduct.php");
			   	//var url=("PL_BuildStoreProduct.php?"+str);  
			    var  formData = str;  //Name value Pair
			    
				$.ajax({
				    url : url,
				    type: "POST",
				    data : formData,
				    success: function(data, textStatus, jqXHR)
				    {
				       location.reload();
				    },
				    error: function (jqXHR, textStatus, errorThrown)
				    {
				 
				    }
				});  

			}	
		}
	
function PageLoader()
{
    getProductAmount();
}
</script>
<body onload="PageLoader();">
 <?php  
    echo ('<div class="container sidestich">');
    	
    	// Header container
    		 include("PL_StoreHeader.php"); 
    		 $Images_Name = $MainImages_Name;
    	// Header container 

    echo ('<form method="post" name="form" action="" >');
		echo ('<nav class="bread-crumps">');
		  echo ('<ul style="margin-bottom: 0px;">');
		   echo (' <li><a href='.$Display_Url.'/storefront/'.$Store_Id.'/'.$User_Id.' ">Home</a></li>');
		   if($Category_Name!='Products' && $Category_Name!='Discount'  && $Category_Name!='Sale'  &&  $Category_Name!='Featured' ){
		   echo ('<li><a href="'.$Display_Url.'/store_category/'.$Category_Name.'/'.$selectedCat.'/'.$Store_Id.' ">'.$Category_Name.'</a></li>');
		   }else {
		   	 echo (' <li><a href='.$Display_Url.'/storefront/'.$Store_Id.'/'.$User_Id.' ">'.$Category_Name.'</a></li>');
		   	}
		    
		   echo (' <li>'.$Product_Title.'</li>');
		 echo (' </ul>');
		echo ('</nav>');

		echo ('<div class="row">');

			echo ('<div class="col-md-6">');

				echo ('<div id="prod1" class="heroimg">');
				$file = ''.$Base_Url.'/images/Profiles/Store/Store_'.$Store_Id.'/Product/Main/Thumbnail_90/'.$Images_Name.'';
				$file_headers = @get_headers($file);

					if($file_headers[0] != 'HTTP/1.0 404 Not Found' &&  $Images_Name !='default_Product.png' )
					{
						echo ('<img data-toggle="magnify" class="img-responsive" src="'.$Base_Url.'/images/Profiles/Store/Store_'.$Store_Id.'/Product/Main/Thumbnail_90/'.$Images_Name.' " alt="">');
					}else{

						echo ('<img data-toggle="magnify" class="img-responsive" src="'.$Base_Url.'/images/Profiles/Store/default_Product.png " alt="">');
					}
				echo ('</div>');
				

				foreach ($Image_Details as $key => $value) 
					{
						$Imgkey=$Imgkey+1;	
						echo ('<div id="prod'.$Imgkey.'" class="heroimgH">');
						echo ('<img data-toggle="magnify" class="img-responsive" src="'.$Base_Url.'/images/Profiles/Store/Store_'.$Store_Id.'/Product/Supporting/Thumbnail_90/'.$value['Image_Name'].' " alt="">');
						echo ('</div>');
					}
				
				echo ('<div class="heroicons">');
				if($file_headers[0] != 'HTTP/1.0 404 Not Found' && $Images_Name !='default_Product.png' )
					{
						echo ('<a href="#nogo" id="thumb1"><img src="'.$Base_Url.'/images/Profiles/Store/Store_'.$Store_Id.'/Product/Main/Thumbnail_30/'.$Images_Name.' " alt="..." class="img-thumbnail" height="66px" width="66px" ></a>  ');
					}else {
					
						echo ('<a href="#nogo" id="thumb1"><img src="'.$Base_Url.'/images/Profiles/Store/default_Product.png " alt="..." class="img-thumbnail" height="66px" width="66px" ></a>');
					}	
					
					foreach ($Image_Details as $key1 => $value1) 
					{
						$ImgThumbkey=$ImgThumbkey+1;
						echo ('<a href="#nogo" id="thumb'.$ImgThumbkey.'"><img src="'.$Base_Url.'/images/Profiles/Store/Store_'.$Store_Id.'/Product/Supporting/Thumbnail_30/'.$value1['Image_Name'].' " alt="..." class="img-thumbnail"></a>  ');
					}
					
					
				echo ('</div>');


			echo ('</div>');

			echo ('<div class="col-md-6">');
				echo ('<div class="prodtitle">');
					echo ('<h3><b>'.$Product_Title.'</b></h3>');
				echo ('</div>');
				echo ('<hr>');
				echo ('<div class="form-inline">');
					
					$i=0;
					foreach ($Product_Details as $key => $value) 
					{
						//echo "<pre>"; print_r($key);	
						echo ('<div class="form-group">');		
						echo ('<label for="color"><strong>'.$key.'</strong></label><br />');
						echo ('<select class="form-control" name="'.$i.'" id="'.$key.'" onchange="getProductAmount();">');	
						//echo (' <option>'.$key.'</option>');
						//echo ('<option value="">Choose:'.$key.'</option>');
						foreach ($value as $key1 => $value1) 
							{
								$V_Val=$value1["VarietyOption_Name"];
							?>
								<option value="<?php echo $key.'_'.$key1.'_'.$V_Val; ?>"><?php echo $V_Val; ?>
								</option>

							<?php	

							}	

							echo ('</select>');	
						//echo ('<input type="hidden" name="'.$key.'" value="'.$key.'">');
						
						//echo ('<label for="color"><strong>'.$value.'</strong></label><br />');
						echo ('</div>');
						$i++;
					}
					echo ('<div class="form-group">');
						echo ('<label for="quantity"><strong>Qty</strong></label><br />');
						echo ('<select class="form-control" name="Qty" id="Qty" onchange="getProductAmount();" >');
						  echo ('<option>1</option>');
						  echo ('<option>2</option>');
						  echo ('<option>3</option>');
						  echo ('<option>4</option>');
						  echo ('<option>5</option>');
						echo ('</select>');
					echo ('</div>');	

				echo ('</div>');
				echo ('<hr>');
				echo ('<div class="form-inline">');
				
				$Product_ActualPrice=$Product_Price;
				if($Product_SalePrice != '0.00' ) 
				{	$Product_ActualPrice=$Product_SalePrice;	}
				
				echo ('<div class="form-group"><div class="price" id="price" name="price" >'.$CurrencyType.''.$Product_ActualPrice.'</div></div>');
				
				echo ('<input type="hidden" name="Base_Price" id="Base_Price" value="'.$Product_ActualPrice.'">');
				
				echo ('<input type="hidden" name="Price" id="price_hidden" value="'.$Product_ActualPrice.'">');
				echo ('<input type="hidden" name="Product Id" value="'.$Product_Id.'">');
				echo ('<input type="hidden" name="Store id" value="'.$Store_Id.'">');
				echo ('<input type="hidden" name="Images Name" value="'.$Images_Name.'">');
				echo ('<input type="hidden" name="Product Title" value="'.$Product_Title.'">');
				echo ('<input type="hidden" name="Product Description" value="'.$Product_Description.'">');
				echo ('<input type="hidden" name="Product_SalePrice" value="'.$Product_SalePrice.'">');
				echo ('<input type="hidden" name="Store_Currency" value="'.$Currency.'">');

				echo ('<button type="button" class="btn btn-success" onclick="addtocart()"><i class="fa fa-shopping-cart addcart"></i> Add to Cart</button>');
				echo "</form>";
				

				echo ('</div>');
				echo ('<hr>');
				echo ('<div class="summaryhead">');
					echo ('<h4>Summary</h4>');
					echo ('<p>'.$Product_Description.'</p>');
				echo ('</div>');
			echo ('</div>');
		echo ('</div>');
	echo ('<form>');	
	?>
		<div>
	
		</div>
    </div> <!-- Main container -->

	 <!-- footer container -->
	 	<?php include("S/PL_StoreFooter.php"); ?>
	 <!-- footer container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $Base_Url; ?>/js/jquery-1.11.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $Base_Url; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $Base_Url; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $Base_Url; ?>/js/jquery.isotope.min.js"></script>
	<script src="<?php echo $Base_Url; ?>/js/jquery.pretty.photo.js"></script>
	<script src="<?php echo $Base_Url; ?>/js/store.js"></script>
	<script src="<?php echo $Base_Url; ?>/js/bootstrap-magnify.min.js"></script>
	<script src="<?php echo $Base_Url; ?>/J/PL_CommonFunctions.js"></script>
	<script>
		$(document).ready(function(){
			$("#thumb1").click(function(){
		    $("#prod1").show();
		    $("#prod2").hide();
		    $("#prod3").hide();
		    $("#prod4").hide();
			});

			$("#thumb2").click(function(){
		    $("#prod2").show();
		    $("#prod1").hide();
		    $("#prod3").hide();
		    $("#prod4").hide();
			});

			$("#thumb3").click(function(){
		    $("#prod3").show();
		    $("#prod1").hide();
		    $("#prod2").hide();
		    $("#prod4").hide();
			});

			$("#thumb4").click(function(){
		    $("#prod4").show();
		    $("#prod1").hide();
		    $("#prod2").hide();
		    $("#prod3").hide();
			});
		});
	</script>
  </body>
</html>
