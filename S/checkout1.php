<?php
require("whywewant_Initialization.php");
$sid = session_id();

// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database
include "../storescripts/connect_to_mysql.php";
?>

<?php
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
<?PHP
 // if($_POST) {
 //   if($_POST['captcha'] != $_SESSION['digit']) die("Sorry, the CAPTCHA code entered was incorrect!");
 //   session_destroy();
// }
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

    <!-- theme stylesheet -->
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="../css/custom.css" rel="stylesheet">

    <script src="../js/respond.min.js"></script>

    <link rel="shortcut icon" href="img/logo4.png">
    <script>
		function validateUser_Email(value)
		{
		  var name='';
		  name=value;
		  var error_id=0;
		  var x=document.getElementById("email");

		  name = name.replace(/ +(?= )/g,'');
		  if(name=='' || name==' ')
		  { error_id=120023;   }

		  else if(name!='')
		  {
			var email = document.getElementById('email');
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email.value))
			{ error_id=120023; }
		  }

		  if (error_id!=0)
		  {
			document.orderform.email.focus();
			x.style.border = '1px solid red';
			document.getElementById("div_User_EmailError").innerHTML="Email id should not be blank and it should be in correct format";
			document.getElementById("div_User_EmailError").style.display = "";
			return false;
		  }
		  else
		  {
			x.style.border = '1px solid #d3dbe3';
			document.getElementById("div_User_EmailError").innerHTML='';
			document.getElementById("div_User_EmailError").style.display = "none";
			return true;
		  }
		}
		function validateFields(obj,val,div,err)
		{
			var selected=val;
			if ((selected=='0') || (selected=='Select') || (selected==''))
			{
				obj.focus();
				obj.style.border='1px solid #ff6000';
				document.getElementById(div).innerHTML = err;
				document.getElementById(div).style.display = "";

				return false;
			}
			else
			{
				obj.style.border='1px solid #d3dbe3';
				document.getElementById(div).innerHTML = '';
				document.getElementById(div).style.display = "";

				return true;
			}
		}



		function validateForm(formName)
		{
			var ok=true;

		if (!validateFields(document.orderform.firstname,document.orderform.firstname.value,'div_firstnameError','First name should not be blank.'))
		{ ok=false;	}

			if (!validateFields(document.orderform.line1,document.orderform.line1.value,'div_line1Error','Streat 1  should not be blank.'))
			{ ok=false;	}

			if (!validateFields(document.orderform.city,document.orderform.city.value,'div_cityError','City should not be blank.'))
			{ ok=false;	}

			if (!validateFields(document.orderform.zip,document.orderform.zip.value,'div_zipError','Zip should not be blank.'))
			{ ok=false;	}

			if (!validateFields(document.orderform.phone,document.orderform.phone.value,'div_phoneError','Phone should not be blank.'))
			{ ok=false;	}

			if (!validateUser_Email(document.orderform.email.value))
			{ ok=false; }



			return ok;
		}

	</script>


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
                        <li>Finalise Order - Address</li>
                    </ul>
                </div>

                <div class="col-md-9" id="checkout">

                    <div class="box address">
                        <form name ="orderform" method="post" action="checkout2.php" onSubmit="return validateForm(this);">
						<input type="hidden" name="sid" value="<?php echo $sid ?>" />
                            <h1>Finalise Order</h1>
							<ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#"><i class="fa fa-map-marker"></i><br>Address</a>
                                </li>
                                <li class="disabled"><a href="#"><i class="fa fa-truck"></i><br>Delivery Method</a>
                                </li>
                                <li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a>
                                </li>
                                <li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Order Review</a>
                                </li>
                            </ul>

                            <div class="content">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="firstnamelable">First Name</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname">
											<code id="div_firstnameError">
											  <?php
											  if (array_key_exists('firstname', $Errors))
											  {
												$tmp=$Errors['firstname'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="company">Streat 1</label>
                                            <input type="text" class="form-control" id="line1" name="line1">
											<code id="div_line1Error">
											  <?php
											  if (array_key_exists('line1', $Errors))
											  {
												$tmp=$Errors['line1'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="street">Street 2</label>
                                            <input type="text" class="form-control" id="line2" name="line2">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="citylable">City</label>
                                            <input type="text" class="form-control" id="city" name="city">
											<code id="div_cityError">
											  <?php
											  if (array_key_exists('city', $Errors))
											  {
												$tmp=$Errors['city'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="zip">ZIP</label>
                                            <input type="text" class="form-control" id="zip" name="zip">
											<code id="div_zipError">
											  <?php
											  if (array_key_exists('zip', $Errors))
											  {
												$tmp=$Errors['zip'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <select class="form-control" id="state" name="state">
												<option value="Ka">Karnataka</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <select class="form-control" id="country" name="country">
												<option value="IN">India</option>
											</select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6" style="clear:both;">
                                        <div class="form-group">
                                            <label for="phone">Telephone</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
											<code  id="div_phoneError">
											  <?php
											  if (array_key_exists('phone', $Errors))
											  {
												$tmp=$Errors['phone'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email">
											<code  id="div_User_EmailError">
											  <?php
											  if (array_key_exists('email', $Errors))
											  {
												$tmp=$Errors['email'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.row -->
                            </div>

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="basket.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to basket</a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Continue to Delivery Method<i class="fa fa-chevron-right"></i>
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






</body>

</html>
