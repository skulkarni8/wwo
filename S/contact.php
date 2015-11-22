<?php
include "password.php"; 
include "send_email_index.php"

?>

<!-- === BEGIN HEADER === -->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
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
	  <!-- styles -->
	<link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
	<link rel="shortcut icon" href="../img/logo4.png">
	
	
       
    </head>
    <body>
	
	     <?php include_once("header_topbar.php"); ?>

    	
		<hr>
		
       
     
        <!-- === BEGIN CONTENT === -->
        <div id="content ">
            <div class="container contactus">
                <div class="row margin-vert-30">
                    <!-- Main Column -->
					
					 <div class="col-md-2">
					 </div>
					
                    <div class="col-md-6" style="box-shadow: 0px 0px 10px rgb(136, 136, 136); padding:35px ;">
                        <!-- Main Content -->
                        <div class="headline">
                            <h2 ><p style="text-align: center;"> Contact Us </p></h2>
                        </div>
                      
						
                        <br>
						
						<form class="ourform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return checkForm(this);">
								    <?php
										if (isset($success)){ echo "<div>" . $success . "</div>";}
									?>
                                    <div class="form-group">
									    <p>Name* </p>
										<input type="text" class="form-control" placeholder='' name="custname" value="<?php echo $custname;?>" required>
									    <!--<span class="error"><?php echo $postmsg;?></span> -->
										<span class="error"><?php echo $nameErr;?></span>
										<br>
									</div>
                                    <div class="form-group">
									    <p>Email* </p>
										<input type="email" class="form-control" placeholder='' name="email" value="<?php echo $email; ?>" required>		
										<span class="error"><?php echo $emailErr;?></span>
										<br>
                                    </div>
									<div class="form-group">
									    <p>Phone Number (Please include country code) </p>
										<input type="text" class="form-control" placeholder='' name="phone" value="<?php echo $phone; ?>">		
										<span class="error"><?php echo $phoneErr;?></span>
										<br>
                                    </div>
									<div class="form-group">
										<p>Country*</p>
									    <div class="container contactusdropmenuindex" style="margin-left: -10%; margin-top: -25px; ">
											<div class="col-md-6">
												<div class="input-group">                                            
													<input type="TextBox" ID="country" Class="form-control" name="country" value="<?php echo $country; ?>" required></input>
													<div class="input-group-btn">
														<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
															<span class="caret"></span>
														</button>
														<ul id="demolist" class="dropdown-menu">
															<li><a >India</a></li>
															<li><a >USA</a></li>
															<li><a >UK</a></li>
															<li><a >Canada</a></li>
															<li><a >Singapore</a></li>
															<li><a >France</a></li>
															<li><a >Germany</a></li>
															<li><a >Italy</a></li>
															<li><a >Japan</a></li>
															<li><a >Spain</a></li>
															<li><a >Mexico </a></li>
															<li><a >China</a></li>
															<li><a >Russia </a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<span class="error"><?php echo $countryErr; ?></span>
										<br>
                                    </div>
									<div class="form-group" style="margin-top: -25px; ">
									    <p>Message* </p>
                                        <textarea cols="30" rows="5" class="form-control" placeholder="" name="comment"><?php echo $comment;?></textarea>
                                    </div>
									<p><img id="captcha" src="capcha.php" width="160" height="45" border="1" alt="CAPTCHA">
									<div class="capcharefresh">
									<small><a href="#" onclick="
										document.getElementById('captcha').src = 'capcha.php?' + Math.random();
										document.getElementById('captcha_code').value = '';
										return false;
										">Change Numbers</a></small></div></p>
										<p><input id="captcha_code" type="text" name="captcha" size="6" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]+/g, '');" required> 
										<small>Please enter digits in the box provided</small></p>
                                    <button type="submit" class="btn btn-primary btn-lg" name="submit" value="Submit">Submit</button>
                                </form>
								
						
						
                        <!-- Contact Form 
                        <form>
                            <label>Name</label>
                            <div class="row margin-bottom-20">
                                <div class="col-md-6 col-md-offset-0">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <label>Email
                                <span class="color-red">*</span>
                            </label>
                            <div class="row margin-bottom-20">
                                <div class="col-md-6 col-md-offset-0">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
							<label>Phone</label>
                            <div class="row margin-bottom-20">
                                <div class="col-md-6 col-md-offset-0">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <label>Message</label>
                            <div class="row margin-bottom-20">
                                <div class="col-md-8 col-md-offset-0">
                                    <textarea rows="8" class="form-control"></textarea>
                                </div>
                            </div>
                            <p>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </p>
                        </form> -->
						
						
						
                        <!-- End Contact Form -->
                        <!-- End Main Content -->
                    </div>
                    <!-- End Main Column -->
                    <!-- Side Column -->
					
					 <div class="col-md-1">
					 </div>
                    <div class="col-md-3">
                        <!-- Recent Posts -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Contact Info</h3>
                            </div>
                            <div class="panel-body">
							<ul class="list-unstyled">
                                <li>WhyWeWant Organic Foods </li>
								<li>No.18, 3<sup>rd</sup>  Floor,  16<sup>th</sup>  'C' Main</li>
								<li>HAL 2<sup>nd</sup> Stage, Indiranagar</li>
								<li>Bangalore-560008</li>
								<li>Karnataka, India</li>
							</ul>	
                                <ul class="list-unstyled">
                                    <li>
                                        <i class="fa fa-phone color-primary">&nbsp;&nbsp;</i>India: +91-9900233694</li>
									 <li>
                                        <i class="fa fa-phone color-primary">&nbsp;&nbsp;</i>USA: +1-(312)-6129813</li>	
									<br>	
                                    <li>
                                        <i class="fa fa-envelope color-primary">&nbsp;&nbsp;</i>whywewantorganic@gmail.com</li>
                                    <li>
                                        <i class="fa fa-home color-primary"></i>&nbsp;&nbsp;http://www.whywewantorganic.com</li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li>
                                        <strong class="color-primary">Monday-Friday:</strong>&nbsp;8am to 11pm</li>
                                    <li>
                                        <strong class="color-primary">Saturday:</strong>&nbsp;9am to 10pm</li>
                                    <li>
                                        <strong class="color-primary">Sunday:</strong>&nbsp;9am to 11pm</li>
                                </ul>
                            </div>
                        </div>
                        <!-- End recent Posts -->
                        <!-- About -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">About</h3>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
									<li>- Quick responses within 24 hrs.</li>
									<li>- Assistance at your finger tips.</li>
									<li>- We would love to hear from you.</li>
								</ul>
                            </div>
                        </div>
                        <!-- End About -->
                    </div>
                    <!-- End Side Column -->
                </div>
            </div>
        </div>
        <!-- === END CONTENT === -->
        <!-- === BEGIN FOOTER === -->
       
        <!-- Footer -->
         <?php include_once("footer_links.php");?>
     
	  <?php include_once("final_footer.php");?>

	<!-- *** SCRIPTS TO INCLUDE ***
 _________________________________________________________ -->
   
    <script src="../js/jquery.cookie.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/modernizr.js"></script>
    <script src="../js/bootstrap-hover-dropdown.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/front.js"></script>  
	<script src="../js/jquery-1.11.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
	<script src="../js/respond.min.js"></script>
	
	<script>
		$('#demolist li').on('click', function(){
		$('#country').val($(this).text());
	});
	</script>
    
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
<!-- === END FOOTER === -->