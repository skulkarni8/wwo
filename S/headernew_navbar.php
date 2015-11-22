<?php

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

$MenuOptions=array();
$Process_Group=array();
$MenuSubOptions=array();
 
$HomeURL = "whywewant_homepage.php";



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
													"Page_URL"      => $row["Page_URL"], "Page_Id"=> $row["Page_Id"], "Category_Id"=> $row["Category_Id"]);
}

//echo '<pre>';print_r($Process_Group);echo '</pre>';
//echo '<pre>';print_r($MenuOptions);echo '</pre>';
//echo '<pre>';print_r($MenuSubOptions);echo '</pre>';exit;

?>
<!-- *** NAVBAR ***
 _________________________________________________________ -->

    <div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
					<div id="top">

									<div class="col-md-2 offer" data-animate="fadeInDown">
										<a href="whywewant_homepage.php"><img src="../img/Organic_Logo2.jpg" alt="" class="hidden-xs" height="180" width="180"></a>
									</div>

									<div class="col-md-6 search" data-animate="fadeInDown">
								 		<div class="input-group">
								 		<input type="text" class="form-control" placeholder="Search for...">
								 		<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
								 		</span>
										</div><!-- /input-group -->
								  </div>

									<div class="col-md-4" data-animate="fadeInDown" opacity: 0; padding: 10px;>
											<ul class="menu">
													<li><a href="<?php echo $HomeURL; ?>" ><font color="Blue" size="3">Home</font></a></li>
													<li><a href="loginpage.php" ><font color="Blue" size="3">Login</font></a></li>
													<li><a href="register.php"><font color="Blue" size="3">Register</font></a></li>
													<li><a href="whywewant_Contact.php"><font color="Blue" size="3">Contact Us</font></a></li>
													<?php  if(isset($_SESSION['User'])) { ?>
														<li><a href="whywewant_Logout.php" title="Logout"><font color="Blue">logout</font></a></li>
													<?php } ?>
											</ul>
						 		 </div>

		<?php
		  if(isset($_SESSION['User']))
				{
				echo '<div class="pull-left" style="padding:0px 10px 0px 10px;"><h4 style="clear:both;">'.$User->User_Data["User_Name"].'</h4></div>';
				}
		?>

				<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
						<div class="modal-dialog modal-sm">

								<div class="modal-content">
									<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="Login">Customer login</h4>
									</div>
									<div class="modal-body">
											<!--<form action="customer-orders.html" method="post">-->
										 <form action="whywewant_UserSetup.php" method="post">
													<div class="form-group">
															<input type="text" class="form-control" id="email-modal" placeholder="email">
													</div>
													<div class="form-group">
															<input type="password" class="form-control" id="password-modal" placeholder="password">
													</div>

													<p class="text-center">
															<button  class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
													</p>

											</form>

											<p class="text-center text-muted">Not registered yet?</p>
											<p class="text-center text-muted"><a href="register.php"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>

									</div>
							</div>
					</div>
			</div>

		<div class="navbar-header">
				<div class="navbar-buttons">
						<a class="btn btn-default navbar-toggle" href="basket.php">
							<i class="fa fa-shopping-cart"></i>  <span class="hidden-xs"><?php echo $numberofproducts ?></span>
						</a>
				</div>
		</div>
<!--/.navbar-header -->

	</div>
<!-- Header Menu -->

			<div id="LowHead">

					<div class="navbar-collapse collapse" id="navigation">

						<ul class="nav navbar-nav navbar-left">

				<!---
				<li><a href="whywewant_homepage.php"><font color=rgb(0,200,0) size="2">Home</font></a>
				</li>
			-->
			<?php

			foreach($Process_Group AS $key =>$value)
				{
				echo '<li class="dropdown yamm-fw">';
					echo '<a href="whywewant_homepage.php" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200"><font color=rgb(0,200,0) size="2">'.$value.' </font><b class="caret"></b></a>';
				?>
				<ul class="dropdown-menu">
						<li>
								<div class="yamm-content">
										<div class="row">
			<?php

				foreach($MenuOptions[$key] AS $key1=>$value1)
				{
					echo'<div class="col-sm-3">';
					echo'<h5><a href="'.$value1["Page_URL"].'?Category_Id='.$value1["Category_Id"].'"><font color=rgb(0,200,0) size="2">'.$value1["ProcessMenu_Name"].'</font></a></h5>';
					echo'<ul>';
					foreach($MenuSubOptions[$key][$key1] AS $key2=>$value2)
					{
						echo'<li><a href="'.$value2["Page_URL"].'?Category_Id='.$value1["Category_Id"].'"><font color=rgb(0,200,0) size="2">'.$value2["Process_Name"].'</font></a></li>';
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


				<ul class="nav navbar-nav navbar-left">
            <li>
                <p class="navbar-btn">
									<div class="navbar-collapse collapse right" id="basket-overview">
											<a href="basket.php" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm"><?php echo $numberofproducts ?></span></a>
									</div>
                </p>
            </li>
        </ul>

				<ul class="nav navbar-nav navbar-left">
            <li>
                <p class="navbar-btn">
									<div class="navbar-collapse collapse right" id="search-not-mobile">
										<button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
												<span class="sr-only">Toggle search</span>
												<i class="fa fa-search"></i>
										</button>
									</div>
                </p>
            </li>
        </ul>

<!--
				<div class="navbar-buttons">

				<div class="navbar-collapse collapse right" id="basket-overview">
						<a href="basket.php" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm"><?php echo $numberofproducts ?></span></a>
				</div>

				<div class="navbar-collapse collapse right" id="search-not-mobile">
						<button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
								<span class="sr-only">Toggle search</span>
								<i class="fa fa-search"></i>
						</button>
				</div>

		</div>
-->

									<!-- search  on top -->
									<div class="collapse clearfix" id="search">

										<form class="navbar-form" role="search">
											<div class="input-group">
											<input type="text" class="form-control" placeholder="Search">
											<span class="input-group-btn">
											<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button> </span>
										</div>
									</form>

									</div>
									</ul>
						</div>

 <!-- end earch -->
											<!--/.nav-collapse -->


							<!-- /.container -->
					</div>
				</div>
</div>

