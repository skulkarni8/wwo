<?php
require("whywewant_Initialization.php");
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the mysqli database
include "../storescripts/connect_to_mysql.php";
?>

<?php


$productorder_Item = array();

$cartOutput = "";
$cartTotal = "";
$cartsubTotal = "";
$tax = "";

$pp_checkout_btn = '';
$product_id_array = '';

		$sql = "SELECT A.Order_Id, A.Customer_Id, A.Order_Amount, B.Product_Id, C.Product_Title  FROM user_order A,user_orderitems B, user_storeproducts C WHERE A.Order_Id=B.Order_Id AND B.Product_Id=C.Product_Id AND A.Rec_Status ='A'AND B.Rec_Status ='A'AND C.Rec_Status ='A' ";
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


		$productorder_Item[$Order_Id]= array("Product_Id"=>$Product_Id, "Order_Amount"=>$Order_Amount, "C_FName"=>$C_FName, "C_LName"=>$C_LName, "C_Email"=>$C_Email, "C_Email"=>$C_Email, "Address_Line1"=>$Address_Line1, "Address_Line2"=>$Address_Line2, "City"=>$City, "Phone_Number"=>$Phone_Number, "Order_Date"=>$Order_Date);


		}

			$cartOutputmain = '<div style="clear:both; padding:0px 5px 5px 5px;">
				<table class="table table-bordered table-hover ">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="name">Customer Name</td>
							<td class="price">Price (Rs)</td>
							<td class="quantity">Phone number</td>
							<td class="total">Order Date</td>

						</tr>
					</thead>
					<tbody>';
		foreach($productorder_Item as $key=>$value)
		{
			$Product_Id = $value["Product_Id"];
			$Order_Amount = $value["Order_Amount"];
			$Phone_Number = $value["Phone_Number"];
			$C_FName = $value["C_FName"];



			// Start the For Each loop


					$cartOutput .= '<tr>
							<td class="cart_product">
								<a href="Adminorderdetails.php?Order_Id=' . $key . '" title="order details"><img src="inventory_images/1.jpg" alt="">' . $key . '</a>
							</td>
							<td class="cart_description">
								<h4><a href=""></a>' . $C_FName . '</h4>
							</td>
							<td class="cart_price">
								<p>' . $Order_Amount . '</p>
							</td>
							<td class="cart_phone">
								<p>' . $Phone_Number . '</p>
							</td>

							<td class="cart_total">
								<p class="cart_total_price">' . $Order_Date . '</p>
							</td>

						</tr>';







	setlocale(LC_MONETARY, "en_US");



}

	$cartOutputdown= '</tbody>
				</table>


			</div>';

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

    <link rel="../shortcut icon" href="img/logo4.png">



</head>

<body>

    <?php include_once("headernew_navbar.php");?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-9">
					<div class="container-fluid breadcrumbBox text-center">
						<ol class="breadcrumb">
							<li class="active" ><a href="#">User</a></li>
							<li><a href="#">Order List</a></li>
						</ol>
					</div>
                </div>

                <div class="col-md-9" id="basket">

                    <div class="box basket">

					    <?php

						echo $cartOutputmain ;
						echo $cartOutput ;
						echo $cartOutputdown ;

						?>
					</div>
                    <!-- /.box -->

                    <div class="box cart_final">
                            <form method="POST" action="checkout1.php" >
                            </form>
                    </div>


                <!-- /.col-md-3 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->



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
    <script type="text/javascript">

  function checkForm(form)
  {


    if(!form.captcha.value.match(/^\d{5}$/)) {
      alert('Please enter digits in the box provided');
      form.captcha.focus();
      return false;
    }



    return true;
  }

</script>


</body>

</html>
