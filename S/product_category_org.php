<?php
// Run a select query to get my letest 6 items
// Connect to the MySQL database  


include "../storescripts/connect_to_mysql.php"; 
$dynamicList = "";
$result = "";
$totalcategory = "";
$array = array();
$Product_Id = array();
$Product_Title = array();
$Product_Price = array();
$Category_Id=0;
$IncludeTable='';
$CatID_Where='';
$SubCategory_Id=0;
$IncludeTable1='';
$SubCatID_Where='';

if (isset($_GET["Category_Id"]))
{	$Category_Id = $_GET["Category_Id"];	}

if (isset($_GET["SubCategory_Id"]))
{	$SubCategory_Id = $_GET["SubCategory_Id"];	}

if ($Category_Id!=0)
{
    $IncludeTable=',user_productscategory B';
	$CatID_Where=" WHERE A.`Product_Id`= B.`Product_Id` AND B.Category_Id = $Category_Id AND A.`Rec_Status`='A' AND B.`Rec_Status`='A' ";
}

if ($SubCategory_Id!=0)
{
    $IncludeTable=',user_productscategory C';
	$SubCatID_Where=" WHERE A.`Product_Id`= C.`Product_Id` AND C.SubCategory_Id = $SubCategory_Id AND A.`Rec_Status`='A' AND C.`Rec_Status`='A'  ";
}

//$totalcategory = mysql_query("SELECT COUNT(DISTINCT category) FROM products");
$sql = "SELECT COUNT(DISTINCT Product_Title) FROM user_storeproducts";
$totalcategory = $con->query($sql);
$i = 1;
// make query dynamic for product type, currently its hard coded
//$sql = mysql_query("SELECT * FROM products WHERE category = 'electronics' ORDER BY date_added DESC limit 12");
$sql = ("SELECT A.Product_Id,A.Product_Title,A.Product_Price FROM user_storeproducts A $IncludeTable $CatID_Where $SubCatID_Where  " );
$result = $con->query($sql);

$productCount = $result->num_rows; // count the output amount
if ($productCount > 0) {
	
	for ($i = 0; $i < $productCount  ; $i++) {

    $result->data_seek($i);
    $row = $result->fetch_row();

	array_push($Product_Id, $row[0]);
	array_push($Product_Title, $row[1]);
	array_push($Product_Price, $row[2]);
	
	
	$dynamicList .= '<div class="col-md-3 col-sm-4">
                            <div class="product">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.php?id=' . $Product_Id[$i] . '">
                                                <img src="../inventory_images/' . $Product_Id[$i] . '.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.php?id=' . $Product_Id[$i] . '">
                                                <img src="../inventory_images/' . $Product_Id[$i] . '.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.php?id=' . $Product_Id[$i] . '">
                                    <img src="../inventory_images/' . $Product_Id[$i] . '.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3><a href="detail.php?id=' . $Product_Id[$i] . '">' . $Product_Title[$i] . '</a></h3>
                                    <p class="price">Rs ' . $Product_Price[$i] . '</p>
                                    <p class="buttons">
                                        <a href="detail.php?id=' . $Product_Id[$i] . '" class="btn btn-default">View detail</a>
                                        <a href="basket.php?pid=' . $Product_Id[$i] . '" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </p>
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->
                        </div>';
	
	

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
	
    <?php include_once("header_topbar.php");?>	
    <?php include_once("header_navbar.php");?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">Product List</a>
                        </li>
                   
                    </ul>
                </div>


                <div class="col-md-9">

                        <div id="latest_additions">

		<div class="box products">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>Product</h2>
                        </div>
                    </div>
        </div>


		<div id="content">
			<div class="container">
                <div class="col-md-12">
					<div class="row products">
						  <?php echo $dynamicList ?>
                    </div>
                    <!-- /.products -->
				</div>
                <!-- /.col-md-12 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
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
