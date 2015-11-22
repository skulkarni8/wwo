<?php 
session_start(); // Start session first thing in script
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "storescripts/connect_to_mysql.php"; 
?>

<?php 

$sid = $_POST['sid'];
$account_id = $_POST['account_id'];
$order_id = $_POST['order_id'];
$delivery = $_POST['delivery'];

$sql = "UPDATE orders set delivery='$delivery' where order_id = '$order_id'";
$result = $con->query($sql);

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
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
	// Start PayPal Checkout Button
	
	// Start the For Each loop
	
	
	$i = 0; 
	  foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = "SELECT * FROM products WHERE id='$item_id' LIMIT 1";
		$result = $con->query($sql);
		while ($row = $result->fetch_array()) {
			$product_name = $row["product_name"];
			$price = $row["price"];
			$price = number_format($price, 2);
			$details = $row["details"];
			
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
		
		$i++;
		
		}
		// Dynamic table row assembly
		
		$cartOutput .= '<table class="table">
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
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->
    <link href="css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="css/custom.css" rel="stylesheet">

    <script src="js/respond.min.js"></script>

    <link rel="shortcut icon" href="img/logo4.png">



</head>

<body>

    <?php include_once("header_topbar.php");?>

    <?php include_once("header_navbar.php");?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">Home</a>
                        </li>
                        <li>Finalise Order - Payment method</li>
                    </ul>
                </div>

                <div class="col-md-9" id="checkout">

                    <div class="box payment-method">
                        <form method="post" action="checkout4.php">
						<input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
						<input type="hidden" name="account_id" value="<?php echo $account_id ?>" />
						<input type="hidden" name="sid" value="<?php echo $sid ?>" />
                            <h1>Finalise Order - Payment method</h1>
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="checkout1.php"><i class="fa fa-map-marker"></i><br>Address</a>
                                </li>
                                <li><a href="checkout2.php"><i class="fa fa-truck"></i><br>Delivery Method</a>
                                </li>
                                <li class="active"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a>
                                </li>
                                <li class="disabled"><a href="checkout4.php"><i class="fa fa-eye"></i><br>Order Review</a>
                                </li>
                            </ul>

                            <div class="content">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="box payment-method">

                                            <h4>Paypal</h4>

                                            <p>We like it all.</p>

                                            <div class="box-footer text-center">

                                                <input type="radio" name="payment" value="paypal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="box payment-method">

                                            <h4>Payment gateway</h4>

                                            <p>VISA and Mastercard only.</p>

                                            <div class="box-footer text-center">

                                                <input type="radio" name="payment" value="payment_gateway">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.content -->

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="checkout2.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Shipping method</a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Continue to Order review<i class="fa fa-chevron-right"></i>
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
                            <?php echo $cartOutput ?>
                        </div>

                    </div>

                </div>
                <!-- /.col-md-3 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
		<?php include_once("footer.php");?>
 
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






</body>

</html>