<?php
// Run a select query to get my letest 6 items
// Connect to the MySQL database
include "../storescripts/connect_to_mysql.php";
//$con = mysqli_connect("localhost","admin","passw0rd","ourstore");
$dynamicList = "";
$result = "";
$totalcategory = "";
$array = array();
$prod_id = array();
$prod_name = array();
$prod_price = array();

//$totalcategory = mysql_query("SELECT COUNT(DISTINCT category) FROM products");
$sql = "SELECT COUNT(DISTINCT Product_Title) FROM user_storeproducts";
$totalcategory = $con->query($sql);


$i = 1;
// make query dynamic for product type, currently its hard coded
//$sql = mysql_query("SELECT * FROM products WHERE category = 'electronics' ORDER BY date_added DESC limit 12");
//$sql = ("SELECT * FROM products WHERE feature_item = 'Y' order by id desc limit 6 " );
$sql = ("SELECT Product_Id,Product_Title,Product_Price FROM user_storeproducts where Product_Id > 11 limit 6 " );
$result = $con->query($sql);

$productCount = $result->num_rows; // count the output amount

if ($productCount > 0) {

	for ($i = 0; $i < $productCount  ; $i++) {

	$result->data_seek($i);
    $row = $result->fetch_row();
	array_push($prod_id, $row[0]);
	array_push($prod_name, $row[1]);
	array_push($prod_price, $row[2]);


	$dynamicList .= '<div class="item">
                            <div class="product">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.php?id=' . $prod_id[$i] . '">
                                                <img src="../inventory_images/' . $prod_id[$i] . '.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.php?id=' . $prod_id[$i] . '">
                                                <img src="../inventory_images/' . $prod_id[$i] . '.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.html" class="invisible">
                                    <img src="../inventory_images/' . $prod_id[$i] . '.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3><a href="detail.php?id=' . $prod_id[$i] . '">' . $prod_name[$i] . '</a></h3>
                                    <p class="price">Rs ' . $prod_price[$i] . '</p>
									<p class="buttons">
                                       <a href="basket.php?pid=' . $prod_id[$i] . '" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </p>
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->
                        </div>';

    					}
			}

?>


			<!-- *** Feature items SLIDESHOW ***
			_________________________________________________________ -->
            <div id="hot">

                <div class="box feature">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>Feature Items</h2>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="product-slider">
                        <?php echo $dynamicList ?>
                    </div>
                    <!-- /.product-slider -->
                </div>
                <!-- /.container -->

            </div>
            <!-- /#hot -->

            <!-- *** feature item end *** -->
