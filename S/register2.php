<?php
$Current_Page='register.php';
require("whywewant_Initialization.php");
require("../C/whywewant_Class_MasterData.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');
$MasterData=new MasterData();
$MasterData->getLocationCodes();
$getLocation_Codes=$MasterData->getLocation_Codes;

//print_r($getLocation_Codes);

if (empty($FormVars))
{
  $FormVars["user"]='';
  $FormVars["pass"]='';
  $FormVars["email"]='';
  $FormVars["User_State"]='';
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

    <!--<link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>-->

    <!-- styles -->
	 <?php include("whywewant_CommonFiles.php"); ?>
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/owl.theme.css" rel="stylesheet">
    <link href="../css/DJ_Theme.css" rel="stylesheet">
    <!-- theme stylesheet -->
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="../css/custom.css" rel="stylesheet">

    <script src="../js/respond.min.js"></script>
	<script type="text/javascript">

	function validateUser_Name(value)
	{
		var Name='';
		Name=value;

		var x=document.getElementById("user");

		if (Name=='')
		{
			x.style.border = '1px solid red';
			document.getElementById("div_User_NameError").innerHTML="Name should not be blank";
			document.getElementById("div_User_NameError").style.display = "";
			return false;
		}
		else
		{
			x.style.border = '1px solid #d3dbe3';
			document.getElementById("div_User_NameError").innerHTML='';
			document.getElementById("div_User_NameError").style.display = "none";
			return true;
		}
	}

	function validateUser_Pass(value)
	{
		var Name='';
		Name=value;

		var x=document.getElementById("pass");

		if (Name=='')
		{
			x.style.border = '1px solid red';
			document.getElementById("div_User_PassError").innerHTML="Password should not be blank";
			document.getElementById("div_User_PassError").style.display = "";
			return false;
		}
		else
		{
			x.style.border = '1px solid #d3dbe3';
			document.getElementById("div_User_PassError").innerHTML='';
			document.getElementById("div_User_PassError").style.display = "none";
			return true;
		}
	}

	function validateResetPassword(value1, value2)
	{
	    var name='';
	    name=value2;
	    var x=document.getElementById("UserRePass");
	    if (name=='')
	    {
	        document.Sign_up.UserRePass.focus();
	        x.style.border = '1px solid red';
	        document.getElementById("div_UserRePassError").innerHTML="Confirm Password should not be blank.";
	        document.getElementById("div_UserRePassError").style.display = "";
	        return false;
	    }
	    else if(value1!==value2)
	    {
	        document.Sign_up.UserRePass.focus();
	        x.style.border = '1px solid red';
	        document.getElementById("div_UserRePassError").innerHTML="Confirm Password should be same as password.";
	        document.getElementById("div_UserRePassError").style.display = "";
	        return false;

	    }
	    else
	    {
	        x.style.border = '1px solid #d3dbe3';
	        document.getElementById("div_UserRePassError").innerHTML='';
	        document.getElementById("div_UserRePassError").style.display = "none";
	        return true;
	    }
	}

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
		document.Sign_up.email.focus();
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

	function validateStud_User_State(o)
	{
	  var selected=o.options[o.selectedIndex].value;
	  var x=document.getElementById("User_State");
	  if(selected=='')
	  {
		document.Sign_up.User_State.focus();
		x.style.border='1px solid #ff6000';
		document.getElementById("div_User_User_StateError").innerHTML="Location should not be blank";
		document.getElementById("div_User_User_StateError").style.display = "";

		return false;
	  }
	  else
	  {
		x.style.border='1px solid #d3dbe3';
		document.getElementById("div_User_User_StateError").innerHTML='';
		document.getElementById("div_User_User_StateError").style.display = "none";
		return true;
	  }
	}

	function validateStud_User_Cat(o)
	{
	  var selected=o.options[o.selectedIndex].value;
	  var x=document.getElementById("User_Cat");
	  if(selected=='')
	  {
		document.Sign_up.User_Cat.focus();
		x.style.border='1px solid #ff6000';
		document.getElementById("div_User_User_CateError").innerHTML="User Type should not be blank";
		document.getElementById("div_User_User_CateError").style.display = "";

		return false;
	  }
	  else
	  {
		x.style.border='1px solid #d3dbe3';
		document.getElementById("div_User_User_CateError").innerHTML='';
		document.getElementById("div_User_User_CateError").style.display = "none";
		return true;
	  }
	}

	function validateForm(formName)
	{
		var ok=true;


		if (!validateUser_Name(document.Sign_up.user.value))
		{ ok=false; }

		if (!validateUser_Pass(document.Sign_up.pass.value))
		{ ok=false; }

		if (!validateResetPassword(document.Sign_up.pass.value,document.Sign_up.UserRePass.value))
    	{ ok=false;    }

		if (!validateUser_Email(document.Sign_up.email.value))
		{ ok=false; }

		if (!validateStud_User_State(document.Sign_up.User_State))
		{ ok=false; }

		if (!validateStud_User_Cat(document.Sign_up.User_Cat))
		{ ok=false; }


		return ok;
	}


</script>

    <link rel="shortcut icon" href="../img/logo4.png">

</head>

<body>

  <?php include_once("header_topbar.php");?>

  <?php include_once("header_navbar.php"); ?>
    <?php //include_once("header_topbar.php");?>

    <?php //include_once("headernew_navbar.php");?>

    <div id="all">

        <div id="content">
            <div class="container custregister">
			<div class="row">
			    <div class="col-md-1">
				</div>
                <div class="col-md-5">
                    <div class="box register">
                        <h1>Register</h1>
                       
                        
                        <!--<form action="user-man.php" method="post">-->
                        <form name="Sign_up" class="form-actions" action="register_s.php" method="post" onSubmit="return validateForm(this);">
						    <input type="hidden" name="op" value="new">
                            <div class="form-group">
                                <!--<label for="name">User Name</label>-->
                                <input type="text" class="form-control" id="user" name="user" placeholder="User Name">
								<code id="div_User_NameError">
								  <?php
								  if (array_key_exists('user', $Errors))
								  {
									$tmp=$Errors['user'];
									echo $PageErrors[$tmp][1];
								  }?>
								  </code>
                            </div>
                            <div class="form-group">
                                <!--<label for="email">Email</label>-->
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
								<code id="div_User_EmailError">
								  <?php
								  if (array_key_exists('email', $Errors))
								  {
									$tmp=$Errors['email'];
									echo $PageErrors[$tmp][1];
								  }?>
								  </code>
                            </div>
                            <div class="form-group">
                                <!--<label for="password">Password</label>-->
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" onchange=''/>
								<code id="div_User_PassError">
								  <?php
								  if (array_key_exists('user', $Errors))
								  {
									$tmp=$Errors['user'];
									echo $PageErrors[$tmp][1];
								  }?>
								  </code>
                            </div>
                              <div class="form-group">
                                <!--<label for="password">Confirm Password</label>-->
                                <input type="password" class="form-control" id="UserRePass" name="UserRePass" placeholder="Confirm Password" onchange=''>

								<code id="div_UserRePassError">
								  <?php
								  if (array_key_exists('UserRePass', $Errors))
								  {
									$tmp=$Errors['UserRePass'];
									echo $PageErrors[$tmp][1];
								  }?>
								  </code>
                            </div>
							 <div  class="form-group ">
									<!--<label>Location</label>-->
									<span class="custom-dropdownSm custom-dropdown--emerald custom-dropdown--large">
										<select id="User_State" name="User_State" class=" custom-dropdown__select--emerald"  >
										 <option value="">Location</option>
										<?php
										  foreach($getLocation_Codes as $key=>$value)
										{
										  echo ('<option Value="'.$value['City_Id']);
										  if ($value['City_Id']==$FormVars["User_State"])
										  { echo ('" selected');  }
										  else
										  { echo ('"'); }
										  echo ('>'.$value['City'].'</option>');

										}
										?>
										</select>
										<code id="div_User_User_StateError">
										<?php
											if (array_key_exists('User_State', $Errors))
											{
											  $tmp=$Errors['User_State'];
											  echo $PageErrors[$tmp][1];
										}?>
										</code>
									</span>
							</div>
							 <div  class="form-group ">
									<label>I am a:</label>
									<span class="custom-dropdownSm custom-dropdown--emerald custom-dropdown--large">
										<select id="User_Cat" name="User_Cat" class=" custom-dropdown__select--emerald"  >
											 <option value="">select</option>
											 <option value="U">Buyer</option>
											 <option value="V">Supplier</option>
											 <option value="B">both</option>
										</select>
										<code id="div_User_User_CateError">
										<?php
											if (array_key_exists('User_Cat', $Errors))
											{
											  $tmp=$Errors['User_Cat'];
											  echo $PageErrors[$tmp][1];
										}?>
										</code>
									</span>
							</div>
                            <div class="text-center">
                                <button type="submit" name="submit_button" class="btn btn-primary" ><i class="fa fa-user-md"></i> Register</button>
                            </div>
                        </form>
						<br>
						<div class="newtosite">
							<p> Already have an account? &nbsp;<a href="loginpage.php"><b>Login</b></p>
						</div>
                    </div>
                </div>
               
				<div class="col-md-5">
					<img style="margin-left: 0px;" src="../img/join-now.jpg" alt="">
				</div>
				<div class="col-md-1">
				</div>
			</div>	
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->


        <?php// include_once("footer.php");?>

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
