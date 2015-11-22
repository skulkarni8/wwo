<?php
require("whywewant_Initialization.php");

if(isset($_SESSION['User']))
{
	$User=clone $_SESSION["User"];
    $Welocome="Welcome,";
}
else
{
	$Welocome="";
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
    <link href="../css/DJ_Theme.css" rel="stylesheet">
    <link href="../css/ihover.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- theme stylesheet -->
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="../css/custom.css" rel="stylesheet">


    <script src="../js/respond.min.js"></script>

    <!--<link rel="shortcut icon" href="favicon.png">-->
	  <link rel="shortcut icon" href="../img/logo4.png">

</head>

<body>

			<?php include_once("analyticstracking.php") ?>

    	<?php include_once("header_topbar.php"); ?>

    	<?php include_once("header_navbar.php"); ?>

      <div id="all">

      <div id="content">

      <?php include_once("header_slider.php");?>

     	<?php include_once("hot_this_week.php");?>

			<?php include_once("feature_items.php");?>

			<?php include_once("products.php"); ?>

      <?php include_once("get_inspired.php");?>

			<?php //include_once("blog_home.php");?>


      </div>
      <!-- /#content -->

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
