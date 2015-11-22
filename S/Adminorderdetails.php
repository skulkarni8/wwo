<?php 
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "../storescripts/connect_to_mysql.php"; 
$category='';
$subcategory='';
$brand='';
$availability='';
$condition='';
$date_added='';
$quantity='';
?>
<?php 
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['Order_Id'])) {
	$Order_Id=$_GET['Order_Id'];
	
	$sql = "SELECT A.Order_Id, A.Customer_Id, A.Order_Amount, B.Product_Id, C.Product_Title  FROM user_order A,user_orderitems B, user_storeproducts C WHERE A.Order_Id=B.Order_Id AND B.Product_Id=C.Product_Id AND A.Rec_Status ='A'AND B.Rec_Status ='A'AND C.Rec_Status ='A' AND A.Order_Id=$Order_Id ";
		$result = mysqli_query($con,$sql);
		while ($row = mysqli_fetch_array($result)) {
			$Order_Id = $row["Order_Id"];
			$Customer_Id = $row["Customer_Id"];
			$Order_Amount = $row["Order_Amount"];
			$Order_Amount = number_format($Order_Amount, 2);
			$Product_Id = $row["Product_Id"];
			$Product_Title = $row["Product_Title"];
			
			$getUserName_Info = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `user_orderaddresses` A  WHERE  A.Order_Id = $Order_Id AND A.`Rec_Status`='A'  "));
				
				if($getUserName_Info)
				{	
					$C_FName=$getUserName_Info["C_FName"];	
					$C_LName=$getUserName_Info["C_LName"];	
					$C_Email=$getUserName_Info["C_Email"];	
					$Address_Line1=$getUserName_Info["Address_Line1"];	
					$Address_Line2=$getUserName_Info["Address_Line2"];	
					$City=$getUserName_Info["City"];	
					$Phone_Number=$getUserName_Info["Phone_Number"];	
					$CreatedOn=$getUserName_Info["CreatedOn"];	
					$Order_Date=date('d-M-Y', strtotime($CreatedOn));
			
				}
		
	
		$productorder_Item[]= array("Product_Id"=>$Product_Id, "Order_Amount"=>$Order_Amount, "Product_Title"=>$Product_Title);

		
		}
}

?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="WhyWeWant Organic">
    <meta name="author" content="WhyWeWant Organic">
    <meta name="keywords" content="">

    <title>
        WhyWeWant Organic
    </title>

    <meta name="keywords" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>

    <!-- styles -->
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="../css/custom.css" rel="stylesheet">

    <script src="../js/respond.min.js"></script>

   <link rel="shortcut icon" href="img/logo4.png">



</head>

<body>

    <?php include_once("headernew_navbar.php");?>

    <div id="all">

        <div id="content">
            <div class="container">

                <!--<div class="col-md-3">
                    <!-- *** MENUS AND FILTERS on left ***
 _________________________________________________________ ->
                </div> -->

				
				
				
                <div class="col-md-12">

                    <div class="row" id="productMain">
                        <div class="col-md-3">
                       

                        
                        
							<div class="box_detail" id="details">
								<p>
									<h4>Order details</h4>
									<ul>
									<?php
									foreach($productorder_Item as $key=>$value)
									{
										echo '<li>';
										echo $value['Product_Title'];
										echo '</li>';
										
									}
									?>
									</ul>
							
							</div>
                        </div>

                    </div>


    </div>
    <!-- /#all -->


    

    <!-- *** SCRIPTS TO INCLUDE ***
 _________________________________________________________ -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/bootstrap-hover-dropdown.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/front.js"></script>
	<script>
function bigImg(x) {
    x.style.height = "340px";
    x.style.width = "340px";
}

function normalImg(x) {
    x.style.height = "300px";
    x.style.width = "300px";
}

	</script>

</body>

</html>