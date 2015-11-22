
    <div class="container hometop">

    <div id="top">
		    <div class="col-md-2 offer" data-animate="fadeInDown">
				<a href="whywewant_homepage.php"><img src="../img/Organic.png" alt="" class="brandlogo hidden-xs" height="155" width="155"></a>
			</div>

			  <div class="col-md-10" data-animate="fadeInDown" >
				<ul class="menu">
        <!--<li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>-->

				<?php  if(!isset($_SESSION['User'])) { ?>
					<li ><a href="loginpage.php" ><font >Login</font></a>|</li>
				<?php } ?>

				<li ><a href="register.php"><font >Register</font></a>|</li>
				<li ><a href="register.php"><font >Track Order</font></a>|</li>
				<li ><a href="whywewant_Contact.php"><font >24/7 Customer Service </font></a>|</li>
				
				<?php  if(!isset($_SESSION['User'])) { ?>
					<li style="margin-left: -20px;"><a id="fbid" href="https://www.linkedin.com/company/whywewant-innovation-technologies-private-limited" target="_blank">
							<span class="fa-stack fa-sm">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
							</span>
						</a>
					</li>
					<li style="margin-left: -20px;"><a id="lnid" href="https://www.linkedin.com/company/whywewant-innovation-technologies-private-limited" target="_blank">
							<span class="fa-stack fa-sm">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
							</span>
						</a>
					</li>
				<?php } ?>

				<?php  if(isset($_SESSION['User'])) { ?>
					<li>
						<div class="dropdown" id="headerdropdown">
						<?php  echo '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'.'Hi '.$User->User_Data["User_Name"].'!' ?>
						 <span class="caret"></span></button>
						 <ul class="dropdown-menu">
						   <li><a href="whywewant_Logout.php" title="Logout"><font color="blue">Order</font></a></li>
						   <li><a href="whywewant_Logout.php" title="Logout"><font color="blue">Wishlist</font></a></li>
						   <li><a href="whywewant_Logout.php" title="Logout"><font color="blue">Account</font></a></li>
						   <li><a href="whywewant_Logout.php" title="Logout"><font color="blue">Logout</font></a></li>
						 </ul>
						</div>
					</li>
				<?php } ?>

				</ul>
				<p align="right"><i> 21<sup>st</sup> Century Fashion <font color="red">+ </font> Stress <font color="red"> + </font> life management: Eat Organic, <font color="red"> Live Organic </font>, Enjoy Organic.</i></p>
			  </div>


    </div>

		<!-- When customer clicks on login this overlay pops up for login-->

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
	</div>


   <!-- *** TOP BAR END *** -->
