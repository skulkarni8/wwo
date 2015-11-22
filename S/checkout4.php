<?php
require("whywewant_Initialization.php");
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database

if($User_Id==0)
{	$User_Id=0;	}
include "../storescripts/connect_to_mysql.php";
?>

<?php

$sid = $_POST['sid'];
$account_id = $_POST['account_id'];
$order_id = $_POST['order_id'];
$payment = $_POST['payment'];

$Commit= "COMMIT";
mysqli_query($con,"begin");

$sqlpayment = "UPDATE orders set payment='$payment' where order_id = '$order_id'";
if (!@ mysqli_query($con,$sqlpayment))
{
	$Error_Query=$sqlpayment;
	$errno=mysqli_errno($con);
	$error=mysqli_error($con);
	$_SESSION['DBErrors'][0]=41;
	GOTO ErrorProcessing;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1  (render the cart for the user to view on the page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$cartTotal = "";
$cartsubTotal = "";
$tax = "";
$shiping_cost = number_format(5, 2);
$pp_checkout_btn = '';
$product_id_array = '';
$orderSummary = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
	// Start PayPal Checkout Button

	// Start the For Each loop
	$cartOutput .= '<div class="content">
                                <div class="table-responsive final_summary_table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Product</th>
                                                <th>Unit price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            ';

	$i = 0;
	  foreach ($_SESSION["cart_array"] as $each_item) {
		$item_id = $each_item['item_id'];
		$sql = "SELECT * FROM user_storeproducts WHERE Product_Id='$item_id' LIMIT 1";
		$result = $con->query($sql);
		while ($row = $result->fetch_array()) {
			$product_name = $row["Product_Title"];
			$price = $row["Product_Price"];
			$price = number_format($price, 2);
			$details = $row["Product_Description"];

		}
		$pricetotal = $price * $each_item['quantity'];
		$cartsubTotal = $pricetotal + $cartsubTotal;
		// let's print the international format for the en_US locale
		$tax = $cartsubTotal * 0.1 ;
		$cartTotal = $cartsubTotal + $tax + $shiping_cost ;
		$tax = number_format($tax, 2);
		$cartsubTotal = number_format($cartsubTotal, 2);
		$pricetotal = number_format($pricetotal, 2);
		$cartTotal = number_format($cartTotal, 2);
		$x = $i + 1;
		// Create the product array variable
		$product_id_array .= "$item_id-".$each_item['quantity'].",";
		// Dynamic table row assembly

		$cartOutput .= '<tr>
                            <td>
                                <a href="#">
                                    <img src="inventory_images/' . $item_id . '.jpg" alt="">
                                </a>
                            </td>
                            <td><a href="detail.php?id=' . $item_id . '">' . $product_name . '</a>
                            </td>
                            <td>Rs ' . $price . '</td>
                            <td>' . $each_item['quantity'] . '</td>
                            <td>Rs ' . $pricetotal . '</td>
                        </tr>';
		$i++;
    }

	$cartOutput .= '</tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4">Total</th>
                                                <th>Rs ' . $cartsubTotal . '</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.content -->';

	$orderSummary .= '<table class="table">
                                <tbody>
                                    <tr>
                                        <td>Order subtotal (Rs)</td>
                                        <th>' . $cartsubTotal . '</th>
                                    </tr>
                                    <tr>
                                        <td>Shipping (Rs)</td>
                                        <th>' . $shiping_cost . '</th>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <th>' . $tax . '</th>
                                    </tr>
                                    <tr class="total">
                                        <td>Total</td>
                                        <th>' . $cartTotal . '</th>
                                    </tr>
                                </tbody>
                            </table>';

	setlocale(LC_MONETARY, "en_US");
 //   $cartTotal = money_format("%10.2n", $cartTotal);
	//$cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : ".$cartTotal." USD</div>";
    // Finish the Paypal Checkout Btn

}


@mysqli_query($con,$Commit);

GOTO ExitProcessing;

ErrorProcessing:
	$Commit='rollback';
	mysqli_query($Commit, $con);
	header("Location: checkout3.php");
	exit;

ExitProcessing:

	$_SESSION['DBErrors'][0]="Successfully created order.";
	//header("Location: checkout3.php");
	//exit;
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

    <link rel="shortcut icon" href="../img/logo4.png">



</head>

<body>


    <?php include_once("header_topbar.php");?>

    <?php //include_once("headernew_navbar.php");?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">Home</a>
                        </li>
                        <li>Finalise Order - Order review</li>
                    </ul>
                </div>

                <div class="col-md-9" id="checkout">

                    <div class="box final_summary">
                        <form method="post" action="send_email2.php">
						<input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
						<input type="hidden" name="account_id" value="<?php echo $account_id ?>" />
						<input type="hidden" name="sid" value="<?php echo $sid ?>" />
                            <h1>Confirm</h1>
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="checkout1.php"><i class="fa fa-map-marker"></i><br>Address</a>
                                </li>
                                <li><a href="checkout2.php"><i class="fa fa-truck"></i><br>Delivery Method</a>
                                </li>
                                <li><a href="checkout3.php"><i class="fa fa-money"></i><br>Payment Method</a>
                                </li>
                                <li class="active"><a href="#"><i class="fa fa-eye"></i><br>Confirm Order</a>
                                </li>
                            </ul>

                            <?php echo $cartOutput ?>

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="checkout3.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Payment method</a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Confirm<i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->


                </div>
                <!-- /.col-md-9 -->

                <div class="col-md-3">

                    <div class="box" id="order-summary">
                        <div class="box-header">
                            <h3>Order summary</h3>
                        </div>
                        <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>

                        <div class="table-responsive">
                            <?php echo $orderSummary ?>
                        </div>

                    </div>

                </div>
                <!-- /.col-md-3 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
		<?php //include_once("footer.php");?>

		<?php include_once("footer_links.php");?>
      <?php //include_once("footer.php");?>
	  <?php include_once("final_footer.php");?>

	</div>
    <!-- /#all -->




    <!-- *** SCRIPTS TO INCLUDE ***
 _________________________________________________________ -->
    <script src="../js/jquery-1.11.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/modernizr.js"></script>
    <script src="../js/bootstrap-hover-dropdown.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/front.js"></script>






</body>

</html>
