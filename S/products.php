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

//$totalcategory = mysql_query("SELECT COUNT(DISTINCT category) FROM products");
$sql = "SELECT COUNT(DISTINCT Product_Title) FROM user_storeproducts";
$totalcategory = $con->query($sql);
$i = 1;
// make query dynamic for product type, currently its hard coded
//$sql = mysql_query("SELECT * FROM products WHERE category = 'electronics' ORDER BY date_added DESC limit 12");
$sql = ("SELECT Product_Id,Product_Title,Product_Price FROM user_storeproducts order by Product_Id desc limit 4  " );
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
                                        <!--<a href="detail.php?id=' . $Product_Id[$i] . '" class="btn btn-default">View detail</a>-->
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

    <div id="latest_additions">

		<div class="box products">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>Latest Additions</h2>
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
