<?php
$Current_Page='loginpage.php';
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
  $FormVars["email"]='';
  $FormVars["password"]='';
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
    var js_pageerrors= new Array();

    <?php
        $i=0;
        foreach($PageErrors as $key => $value)
        {
                if ($value[0]=='UI')
                {
                        $msg=$value[1];
                        echo "js_pageerrors[$i]=new Array({$key},'{$msg}');\n" ;
                        $i++;
                }
        }
    ?>

var disabledDays = new Array();
var disabledDays_Name = new Array();
function getErrorMsg(Id)
{
        i=0;
        var totalpageerrors=js_pageerrors.length;
        while (i < totalpageerrors)
        {
                if (js_pageerrors[i][0]==Id)
                {       return js_pageerrors[i][1];     }
                i++;
        }
        return ('The error code '+Id+' is not defined in the system. Please contact your System Administrator.');
}

	function validateUser_Name(value)
	{
		var Name='';
		Name=value;

		var x=document.getElementById("email");

		if (Name=='')
		{
			x.style.border = '1px solid red';
			document.getElementById("div_User_NameError").innerHTML="User Name should not be blank";
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

		var x=document.getElementById("password");

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



	function validateForm(formName)
	{
		var ok=true;


		if (!validateUser_Name(document.log_in.email.value))
		{ ok=false; }

		if (!validateUser_Pass(document.log_in.password.value))
		{ ok=false; }


		return ok;
	}



</script>
    <link rel="shortcut icon" href="img/logo4.png">

<?php include_once("header_topbar.php");?>
<hr>
<?php //include_once("header_navbar.php");
//include_once("headernew_navbar.php");
?>
</head>

<body>

    <?php include_once("analyticstracking.php") ?>
    
    <?php //include_once("headernew_navbar.php");?>

         <?php
                    if (isset($_SESSION["DBErrors"]))
                    {
                            echo ('<DIV class="alert alert-info" style="margin:10px;">');
                            $tmp=$_SESSION["DBErrors"][0];
                            if (array_key_exists($tmp, $PageErrors))
                            {       echo $PageErrors[$tmp][1];      }
                            else
                            {       echo (''.$tmp.'');     }
                            if (isset($_SESSION["DBErrors"][1]))
                            {
                            echo ('<br>');
                            $tmp=$_SESSION["DBErrors"][1];
                            if (array_key_exists($tmp, $PageErrors))
                            {       echo $PageErrors[$tmp][0];      }
                            else
                            {       echo (''.$tmp.'');     }
                            }
                            echo ('</DIV>');
                            unset($_SESSION["DBErrors"]);
                    }
            ?>

    <div id="all">

        <div id="content">
            <div class="container login">
			    <div class="row">
					<div class="col-md-2">
					</div>
                    <div class="col-md-8" >
					    <div class="row">
						    <!--<div class="col-md-5" >
							    <img style="margin-left: 0px;" src="../img/c2.jpg" alt="">
							</div>-->
						    
								<div class="box register">
									<h1>Login</h1>

									<hr>
									<!--<form action="user-man.php" method="post">-->
									<form name="log_in" class="form-actions" action="whywewant_UserSetup.php" method="POST" onSubmit="return validateForm(this);">
										<input type="hidden" name="op" value="login">
										<div class="form-group">
											<label for="name">Email</label>
											<input type="text" class="form-control" id="email" name="email" placeholder="Email">
											<code id="div_User_NameError">
											  <?php
											  if (array_key_exists('email', $Errors))
											  {
												$tmp=$Errors['email'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
										</div>
									
										<div class="form-group">
											<label for="password">Password</label>
											<label id="forgotpasswd"> Forgot Password? </label>
											<input type="password" class="form-control" id="password" name="password" placeholder="Password">
											<code id="div_User_PassError">
											  <?php
											  if (array_key_exists('password', $Errors))
											  {
												$tmp=$Errors['password'];
												echo $PageErrors[$tmp][1];
											  }?>
											  </code>
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-primary login"><i class="fa fa-sign-in"></i> Log in</button>
										</div>
									</form>
									<br>
									<br>

									<div class="newtosite">
									<p> New to WhyWeWant Organic? &nbsp;<a href="register.php"><b>Register</b></p>
									</div>
								</div>
                           
							
						</div>
					</div>
					<div class="col-md-2">
					</div>


				</div>

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

        <?php include_once("footer_links.php");?>
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
