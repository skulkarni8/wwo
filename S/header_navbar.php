<?php 

/* if (session_status() == PHP_SESSION_NONE) 
{	session_start();} */

// Script Error Reporting

error_reporting(E_ALL);
ini_set('display_errors', '1'); 
$numberofproducts = '';

if (!isset($_SESSION["cart_array"])) 
{	$numberofproducts = "No items in Cart";	} 
else 
{
	$i = 0; 
	foreach ($_SESSION["cart_array"] as $each_item) 
	{ $i++;	}
	$numberofproducts = "$i items in cart";
}

include "../storescripts/connect_to_mysql.php";

require_once("../C/Class_ProcessMenu.php");
$User_SubType='';
$MenuOptions = array();

$User_Id=0;
$User_Type='U';
$User_SubType='';
$ShowInTheList='';
$Customer_Id=0;
$UserDept_Code='';
$UserDept_Role='';
$HomeURL='';


$ShowInTheList_str = '';

if($ShowInTheList == 'Y')
{	$ShowInTheList_str = " AND A.ShowInTheList='Y' ";	}

// code for creating header data dynamically

$menu_qrystmt="SELECT A.* FROM processmenu_v A WHERE  User_Type='{$User_Type}' AND User_SubType IN ('', '{$User_SubType}') AND User_Deptcode IN ('', '{$UserDept_Code}') AND User_DeptRole IN ('', '{$UserDept_Role}') ".$ShowInTheList_str." ORDER BY A.ProcessGroup_DisplaySeq, A.Display_Seq";

$result = $con->query($menu_qrystmt);
while ($row = $result->fetch_array())
{
	$Process_Group[$row["ProcessGroup_Id"]]=$row["ProcessGroup_Name"];

	$MenuOptions[$row["ProcessGroup_Id"]][$row["ProcessSub_Id"]]=array("ProcessMenu_Name"  => $row["ProcessMenu_Name"],
													"Page_URL"      => $row["Page_URL"], "Page_Id"=> $row["Page_Id"], "Category_Id"=> $row["Category_Id"]);

	$MenuSubOptions[$row["ProcessGroup_Id"]][$row["ProcessSub_Id"]][$row["Process_Id"]]=array("Process_Name"  => $row["Process_Name"],
													"Page_URL"      => $row["Page_URL"], "Page_Id"=> $row["Page_Id"], "Category_Id"=> $row["Category_Id"], "SubCategory_Id"=> $row["SubCategory_Id"]);
}

//echo '<pre>';print_r($Process_Group);echo '</pre>';
//echo '<pre>';print_r($MenuOptions);echo '</pre>';
//echo '<pre>';print_r($MenuSubOptions);echo '</pre>';exit;

?>

<!-- *** NAVBAR ***
 _________________________________________________________ -->
    <hr>
    <div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-buttons">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-align-justify"></i>
                    </button>
                   
                </div>
            </div>
            <!--/.navbar-header -->
            
			
			<!-- Header Menu -->
            <div class="navbar-collapse collapse" id="navigation">

                <ul class="nav navbar-nav navbar-left">
                    <li><a href="whywewant_homepage.php">Home</a>
                    </li>
					<?php
					foreach($Process_Group AS $key =>$value)
					{ ?>
                    <li class="dropdown yamm-fw">
                        <a href="index.php" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200"><?php echo $value;?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
								<?php

								foreach($MenuOptions[$key] AS $key1=>$value1)
								{ 
                                    echo '<div class="row">';
                                        echo '<div class="col-sm-3">';
                                           echo '<h5><a href="'.$value1["Page_URL"].'?Category_Id='.$value1["Category_Id"].'"><font color=rgb(0,200,0) size="2">'.$value1["ProcessMenu_Name"].'</font></a></h5>'; 
                                            echo'<ul>';
                                               	foreach($MenuSubOptions[$key][$key1] AS $key2=>$value2)
												{
													echo'<li><a href="'.$value2["Page_URL"].'?SubCategory_Id='.$value2["SubCategory_Id"].'"><font color=rgb(0,200,0) size="2">'.$value2["Process_Name"].'</font></a></li>';
												}
                                            echo'</ul>';
                                        echo'</div>';
								}?>    
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
			<?php } ?>     
                </ul>

            </div> <!--  End Home Menu --> 
            <!--/.nav-collapse -->

            <div class="navbar-buttons">

                <!--<div class="navbar-collapse collapse right" id="basket-overview">
                    <a href="basket.php" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm"><?php echo $numberofproducts ?></span></a>
                </div>
                

                <div class="navbar-collapse collapse right" id="search-not-mobile">
                    <button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                </div>-->

            </div>
            
			
			<!-- search  on top -->
            <div class="collapse clearfix" id="search">

                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-btn">

							<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>

		    <			/span>
                    </div>
                </form>

            </div> <!-- end earch -->
            <!--/.nav-collapse -->

        </div>
        <!-- /.container -->
    </div>
    <!-- /#navbar -->
	

    <!-- *** NAVBAR END *** -->
