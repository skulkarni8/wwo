<?php
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
if (isset($_GET['id'])) {
	// Connect to the MySQL database
    include "../storescripts/connect_to_mysql.php";
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']);
	// Use this var to check to see if this ID exists, if yes then get the product
	// details, if no then exit this script and give message why
	$sql = "SELECT * FROM user_storeproducts WHERE Product_Id='$id' LIMIT 1";
	$result = $con->query($sql);
	$productCount = $result->num_rows; // count the output amount
    if ($productCount > 0) {
		// get all the product details
		//while($row = mysql_fetch_array($sql)){
        while($row = $result->fetch_array()){
			 $product_name = $row["Product_Title"];
			 $price = $row["Product_Price"];
			 $ourprice = $price - 10.00;
			 $ourprice = sprintf('%0.2f', $ourprice); 
			 $saving = ( 100 * $ourprice) / $price ;
			 $saved = 100 - $saving ;
			 $saved = sprintf('%0.2f', $saved); 
			 $details = $row["Product_Description"];
			 //$category = $row["category"];
			 //$subcategory = $row["subcategory"];
			 $brand = $row["Brand"];
			 if ( $row["Product_InStock"] = 'Y') {
			 $availability = 'In Stock'  ;} 
			 else {
				 $availability = 'Out of Stock'  ; 
			 }
			 //$availability = strtoupper($availability);
			 if ( $row["condition"] = "A") {
			 $condition = "New";}
			 else {
				 $condition = "Refurbished"; 
			 }
			//$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
         }

	} else {
		echo "That item does not exist.";
	    exit();
	}

} else {
	header("Location: whywewant_homepage.php");
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



</head>

<body>

    <?php include_once("analyticstracking.php") ?>
    <?php include_once("header_topbar.php"); ?>

    <?php include_once("header_navbar.php"); ?>

    
            <div class="container productdetails">

                <!--<div class="col-md-3">
                    <!-- *** MENUS AND FILTERS on left ***
 _________________________________________________________ ->
                </div> -->




                <div class="col-md-12">

                    <div class="row" id="productMain">
                        <div class="col-sm-3">
							<div class="row">
							    
								<!--<a class="thumbnail" href="#thumb">
								<img id="ima" src="../inventory_images/<?php echo $id; ?>.jpg"  border="0" /><span><img src="../inventory_images/90.jpg" />
								<br /><?php echo $product_name; ?></span></a>-->
								
								
								<div id="mainImage">
									<img id="ima" onmouseover="bigImg(this)" onmouseout="normalImg(this)" border="0" src="../inventory_images/<?php echo $id; ?>.jpg" alt="" width="300" height="300">
								</div>

								<div class="ribbon sale">
									<div class="theribbon">SALE</div>
									<div class="ribbon-background"></div>
								</div>
								<!-- /.ribbon -->

								<div class="ribbon new">
									<div class="theribbon">NEW</div>
									<div class="ribbon-background"></div>
								</div>
								<!-- /.ribbon -->
								</hr>
								</hr>
							
							</div>
							
							<br />
						
							 <div class="row" id="thumbs">
                                <div class="col-xs-4">
                                    <a href="" onmouseover="showT( '../inventory_images/13.jpg')" class="thumb">
                                        <img src="../inventory_images/13.1.jpg" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="" onmouseover="showT( '../inventory_images/18.jpg')" class="thumb">
                                        <img src="../inventory_images/18.jpg" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="" onmouseover="showT( '../inventory_images/19.jpg')" class="thumb">
                                        <img src="../inventory_images/19.jpg" alt="" class="img-responsive">
                                    </a>
                                </div>
                            </div>	
							
							</br>
						
							<div class="row">
								<div class="social">
									<h4>Show it to your friends</h4>
										<p>
											<a href="#" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
											<a href="#" class="external gplus" data-animate-hover="pulse"><i class="fa fa-google-plus"></i></a>
											<a href="#" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
											<a href="#" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
										</p>
								</div>
							</div>	
                        </div>
						
                        <div class="col-sm-7" id="product_details">
                            <div class="box_detail">
                                <h1 class="text-center"><?php echo $product_name; ?></h1>
								<span>
								<a style="font-size: 25px; text-decoration: none;"><font color="orange">&#9733;&#9733;&#9733;&#9733;&#9733; </font> </a>
								<a style="font-size: 16px; text-decoration: none; color: #757575;"> | 100 customer reviews </a>
								</span> 
								<hr>
								<div class="row">
								    <div class="col-sm-6"> 
										<p class="price">List Price: <s><b>&#x20B9 <?php echo $price; ?></b></s></p>
										<p class="ourprice">Our Price: <b>&#x20B9 <?php echo $ourprice ; ?></b></p>
										<p class="saved">You Saved: <b> <?php echo $saved ; ?> %</b></p>
									</div>
									<div class="col-sm-6" style="text-align: right;">
										<span>
										<p>
											<label><b>Quantity:</b></label>
											<input type="text" value="1" name="quantity" id="quantity"/>
										</p>
										
										<form id="form1" name="form1" method="GET" action="basket.php">
											<input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>" />
											<input type="hidden" name="quantity" id="quantity" value="<?php echo $quantity; ?>" />
											
											<button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">
												<i class="fa fa-shopping-cart"></i>
												Add to cart
											</button>
											
										
										</form>
										
 
										</span>
										<span style="margin-top: 5px;">
										<a id="wishlist"><i class="fa fa-heart"></i>Add to Wishlist</a>
										<a id="share"><i class="fa fa-thumbs-up"></i>Share</a>
										</span>
									</div>
								</div>
								
								<p><?php echo ($details) ; ?></p>
									
								<p style="font-size: 16px; margin-bottom: 0px;"><b><font color="green"><i class="fa fa-check-circle"></i>&nbsp;<?php echo ($availability) ; ?> </b></font></p>
								<p>Ships in 1 - 5 Days.</p>
								<!--<p><b>Brand: </b> <?php echo ($brand) ; ?></p>-->
                            </div>

                           
                        </div>

                   

						<div class="col-sm-2" id="prod_additional_info">
						    <img src="../img/3.png" alt="" class="img-responsive">
						    <hr>
						    <h4><p style="text-align: center;">Additional Info</p></h4>
						    <hr>
						    <ul style="list-style: none;">
								<li>100% Organic Certified</li>
								<li>INDIA Organic </li>
								<li>USDA Organic </li>
							
								
							</ul>
							<hr>
							<h4><p style="text-align: center;">Frequently Bought Together</p></h4>
							<hr>
							<img src="../inventory_images/72.jpg" alt="" class="img-responsive">	
						</div>
					
					</div>
					<hr>
				</div>
				
				<div class="col-md-12">
					<div class="row">
						<div class="box_detail" id="porduct_extra_details">
								<p>
									<h4>Product details</h4>
									<p>Organic Tattva’s Brown rice not just ensures you get the lowest possible starch content but also gives you the most sumptuous tastes and the Organic guarantee that no one else gives like Organic Tattva. It has a mild, nutty flavor, and is chewier and more nutritious than white rice. </p>
									<h4>Nutrition Facts</h4>
									<ul>
										<li>Brown Rice contains magnesium</li>
										<li>Rich in Fiber and Selenium</li>
										<li>Lower Cholesterol with Whole Brown Rice</li>
									</ul>
									<h4>Health Benefits</h4>
									<ul>
										<li>Protective against Childhood Asthma</li>
										<li>Help Prevent Gallstones</li>
										<li>Protective against Breast Cancer</li>
									</ul>

							</div>
					</div>
					<hr>
				</div>
			
				<div class="col-md-12">
					
					<div class="row">
					    <h4 style="margin-left: 15px;"> Similar Producst </h4>
						<br />
						<div class="col-md-3">
						
							<img src="../inventory_images/20.jpg" alt="" class="img-responsive">
						</div>
						<div class="col-md-3">
							<img src="../inventory_images/21.jpg" alt="" class="img-responsive">
						</div>
						<div class="col-md-3">
							<img src="../inventory_images/12.jpg" alt="" class="img-responsive">
						</div>
						<div class="col-md-3">
							<img src="../inventory_images/20.jpg" alt="" class="img-responsive">
						</div>
					</div>
				</div>	
				
				<div class="col-md-12" style="margin-top:25px;">
					<div class="row">
					    <hr>
						<h4 style="margin-left: 15px;">Reviews</h4>
						<button class="btn btn-primary" style="margin-left: 15px;" >Write a Review</button>
											
					</div>
				</div>
				
            </div>
            <!-- /.container -->
       

        <?php include_once("footer_links.php");?>
          <?php //include_once("footer.php");?>
    	  <?php include_once("final_footer.php");?>





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
	
	<script type="text/javascript">
    function showT( image )
    {
         document.getElementById( 'ima' ).setAttribute('src',image ) 
    }
</script>

<style type="text/css">

.thumbnail{
position: relative;
z-index: 0;
}

.thumbnail:hover{
background-color: transparent;
z-index: 50;
}

.thumbnail span{ /*CSS for enlarged image*/
position: absolute;
background-color: #fff;
padding: 5px;
left: -1000px;
border: 1px solid gray;
visibility: hidden;
color: black;
text-decoration: none;
}

.thumbnail span img{ /*CSS for enlarged image*/
border-width: 0;
padding: 2px;
}

.thumbnail:hover span{ /*CSS for enlarged image on hover*/
visibility: visible;
top: 0;
left: 100px; /*position where enlarged image should offset horizontally */

}

</style>

</body>

</html>
