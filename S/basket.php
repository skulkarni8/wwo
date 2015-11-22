<?php
require("whywewant_Initialization.php");
/* if (session_status() == PHP_SESSION_NONE) {

} // Start session first thing in script */
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database
include "../storescripts/connect_to_mysql.php";
?>

<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1 (if user attempts to add something to the cart from the product page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
	$wasFound = false;
	$i = 0;
	// If the cart session variable is not set or cart array is empty
	if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
	    // RUN IF THE CART IS EMPTY OR NOT SET
		$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
	} else {
		// RUN IF THE CART HAS AT LEAST ONE ITEM IN IT
		foreach ($_SESSION["cart_array"] as $each_item) {
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $pid) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
					  $wasFound = true;
				  } // close if condition
		      } // close while loop
	       } // close foreach loop
		   if ($wasFound == false) {
			   array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
		   }
	}
	header("location: basket.php");
    exit();
}
?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 2 (if user chooses to empty their shopping cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}
?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (if user chooses to adjust item quantity)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    // execute some code
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) {
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $item_to_adjust) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				  } // close if condition
		      } // close while loop
	} // close foreach loop
}
?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 4 (if user wants to remove an item from cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['index_to_remove']) && $_GET['index_to_remove'] != "") {
    // Access the array and run code to remove that array index
 	$key_to_remove = $_GET['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}
?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5  (render the cart for the user to view on the page)
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
	$cartOutput .= '<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="name">Name</td>
							<td class="price">Price (Rs)</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total (Rs)</td>
							<td class="Remove">Remove</td>
						</tr>
					</thead>
					<tbody>';

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
							<td class="cart_product">
								<a href=""><img src="inventory_images/' . $item_id . '.jpg" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href=""></a>' . $product_name . '</h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>' . $price . '</p>
							</td>
							<td class="cart_quantity">
								<form class="form-inline" action="basket.php" method="post">
								  <div class="form-group">
										<div class="input-group">
											<input name="quantity" type="text" class="form-control" value="' . $each_item['quantity'] . '" size="1">
											<input name="item_to_adjust" type="hidden" value="' . $item_id . '" >
									  	</div>
								  </div>
								  <input class="btn btn-primary-cart" name="adjustBtn' . $item_id . '" type="submit" value="Change">
								</form>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">' . $pricetotal . '</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="basket.php?index_to_remove=' . $i . '"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>';
		$i++;
    }

	$cartOutput .= '</tbody>
				</table>


			</div>
			<table>
					<tr>
						<div class="row totals">
							<a class="btn btn-primary pull-right" href="basket.php?cmd=emptycart"><h6>Empty whole Shopping Cart</h6></a>
						</div>
					</tr>
			</table>';


	setlocale(LC_MONETARY, "en_US");
 //   $cartTotal = money_format("%10.2n", $cartTotal);
	//$cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : ".$cartTotal." USD</div>";
    // Finish the Paypal Checkout Btn

}

?>

<?PHP
 // if($_POST) {
    //session_start();
   // if($_POST['captcha'] != $_SESSION['digit']) die("Sorry, the CAPTCHA code entered was incorrect!");
    //session_destroy();
//}
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
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/owl.theme.css" rel="stylesheet">
    <link href="../css/DJ_Theme.css" rel="stylesheet">
    <!-- theme stylesheet -->
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="../css/custom.css" rel="stylesheet">

    <script src="../js/respond.min.js"></script>

    <link rel="../shortcut icon" href="img/logo4.png">



</head>

<body>

  <?php include_once("analyticstracking.php") ?>
  
  <?php include_once("header_topbar.php");?>

  <?php include_once("header_navbar.php"); ?>

    <?php //include_once("header_topbar.php");?>

    <?php //include_once("headernew_navbar.php");?>



    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
					<div class="container-fluid breadcrumbBox text-center">
						<ol class="breadcrumb">
							<li class="active" ><a href="#">Review</a></li>
							<li><a href="#">Order</a></li>
							<li><a href="#">Payment</a></li>
						</ol>
					</div>
                </div>

                <div class="col-md-9" id="basket">

                    <div class="box basket">

					    <?php echo $cartOutput ?>
					</div>
                    <!-- /.box -->

                    <div class="box cart_final">
                            <form method="POST" action="checkout1.php" onsubmit="return checkForm(this);">
								<p><img id="captcha" src="capcha.php" width="160" height="45" border="1" alt="CAPTCHA">
								<small><a href="#" onclick="
								  document.getElementById('captcha').src = 'capcha.php?' + Math.random();
								  document.getElementById('captcha_code').value = '';
								  return false;
								">Change Numbers</a></small></p>
								<p><input id="captcha_code" type="text" name="captcha" size="6" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]+/g, '');">
								<small>Please enter digits in the box provided</small></p>

								<button type="submit" class="btn btn-primary">Finalise Order</button>
                            </form>
                    </div>

                    <div class="row same-height-row">
                        <div class="col-md-3 col-sm-6">
                            <div class="box same-height">
                                <h3>You may also like these products</h3>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="product same-height">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.html">
                                                <img src="img/product2.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.html">
                                                <img src="img/product2_2.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.html" class="invisible">
                                    <img src="img/product2.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3>Fur coat</h3>
                                    <p class="price">Rs 443</p>
                                </div>
                            </div>
                            <!-- /.product -->
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="product same-height">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.html">
                                                <img src="img/product1.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.html">
                                                <img src="img/product1_2.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.html" class="invisible">
                                    <img src="img/product1.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3>Fur coat</h3>
                                    <p class="price">Rs 99 </p>
                                </div>
                            </div>
                            <!-- /.product -->
                        </div>


                        <div class="col-md-3 col-sm-6">
                            <div class="product same-height">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.html">
                                                <img src="img/product3.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.html">
                                                <img src="img/product3_2.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.html" class="invisible">
                                    <img src="img/product3.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3>Fur coat</h3>
                                    <p class="price">Rs 143</p>

                                </div>
                            </div>
                            <!-- /.product -->
                        </div>

                    </div>


                </div>
                <!-- /.col-md-9 -->

                <div class="col-md-3">
                    <div class="box box_cart_summary" id="order-summary">
                        <div class="box-header">
                            <h3>Order Summary</h3>
                        </div>
                        <p class="text-muted">Shipping and additional costs.</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Order subtotal</td>
                                        <th><?php echo $cartsubTotal ?></th>
                                    </tr>
                                    <tr>
                                        <td>Shipping Cost</td>
                                        <th><?php echo $shiping_cost ?></th>
                                    </tr>
                                    <tr>
                                        <td>Tax (Rs)</td>
                                        <th><?php echo $tax ?></th>
                                    </tr>
                                    <tr class="total">
                                        <td>Total (Rs)</td>
                                        <th><?php echo $cartTotal ?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="box">
                        <div class="box-header">
                            <h4>Coupon code</h4>
                        </div>
                        <p class="text-muted">If you have a coupon code, please enter it in the box below.</p>
                        <form>
                            <div class="input-group">

                                <input type="text" class="form-control">

                                <span class="input-group-btn">

					<button class="btn btn-primary" type="button"><i class="fa fa-gift"></i></button>

				    </span>
                            </div>
                            <!-- /input-group -->
                        </form>
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
