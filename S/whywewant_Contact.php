<?php
$Current_Page='whywewant_Contact.php';
require("whywewant_Initialization.php");

$_SESSION["FormVars"]=$FormVars;
$FormVars=$_POST;


$_SESSION["Errors"]=array();

$name=' ';



?>
<!DOCTYPE html>
<html>
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

function getErrorMsg(Id)
{
	i=0;
	var totalpageerrors=js_pageerrors.length;
	while (i < totalpageerrors)
	{
		if (js_pageerrors[i][0]==Id)
		{	return js_pageerrors[i][1];	}
		i++;
	}
	return ('The error code '+Id+' is not defined in the system. Please contact your System Administrator.');
}
</script>

<script type="text/javascript">

function validateForm(formName)
{

	//alert("inside validateForm");
	var ok=true;

	if(noChanges(formName))
	{	return false;	}

	if(!validateName(document.contact.name.value))
	{ ok=false;	 }

	//alert(ok);
	if(!validateEmail(document.contact.email.value))
	{ ok=false;	 }

	if(!validatePhoneNo(document.contact.phone.value))
	{ ok=false;	 }

	if(!validateComment(document.contact.comments.value))
	{ ok=false;	 }

	return ok;

}

//User FirstName
function validateName(value)
{
	var name='';
	name=value;

	var x=document.getElementById("name");

	if (name=='')
	{
		document.contact.name.focus();
		x.style.border = '1px solid #000000';
		document.getElementById("div_NameError").innerHTML=getErrorMsg(6031);
		document.getElementById("div_NameError").style.display = "";
		return false;
	}
	else
	{
		x.style.border = '1px solid #d3dbe3';
		document.getElementById("div_NameError").innerHTML='';
		document.getElementById("div_NameError").style.display = "none";
		return true;
	}

}


//Email
function validateEmail(value)
{
	var name='';
	name=value;
	var error_id=0;
	var x=document.getElementById("email");

	if (name=='')
	{	error_id=506;		}

	else if(name!='')
	{
		var email = document.getElementById('email');
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(email.value))
		{	error_id=506;	}
	}

	if (error_id!=0)
	{
		document.contact.email.focus();
		x.style.border = '1px solid #000000';
		document.getElementById("div_EmailError").innerHTML=getErrorMsg(error_id);
		document.getElementById("div_EmailError").style.display = "";
		return false;
	}
	else
	{
		x.style.border = '1px solid #d3dbe3';
		document.getElementById("div_EmailError").innerHTML='';
		document.getElementById("div_EmailError").style.display = "none";
		return true;
	}
}


//validation of phoneno
function validatePhoneNo(value)
{

	var name='';
	name=value;
	var x=document.getElementById("phone");
	//alert(name);
	if (name=='' || name==0 )
	{
		document.contact.phone.focus();
		x.style.border = '1px solid #000000';
		document.getElementById("div_PhoneError").innerHTML='Mobile Number cannot be blank. ';
		document.getElementById("div_PhoneError").style.visibility = "visible";
		return false;
	}
	else if(name!='')
	{

		if(isNaN(name))
		{
			document.contact.phone.focus();
			x.style.border = '1px solid #000000';
			document.getElementById("div_PhoneError").innerHTML='Mobile Number Should be numeric.';
			document.getElementById("div_PhoneError").style.visibility ="visible";
			return false;
		}
		else
		{
			x.style.border = '1px solid #d3dbe3';
			document.getElementById("div_PhoneError").innerHTML='';
			document.getElementById("div_PhoneError").style.visibility ="hidden";
			return true;

		}
	}
}


//User comments
function validateComment(value)
{
	var name='';
	name=value;

	var x=document.getElementById("comments");

	if (name=='')
	{
		document.contact.comments.focus();
		x.style.border = '1px solid #000000';
		document.getElementById("div_CommentError").innerHTML=getErrorMsg(6032);
		document.getElementById("div_CommentError").style.display = "";
		return false;
	}
	else
	{
		x.style.border = '1px solid #d3dbe3';
		document.getElementById("div_CommentError").innerHTML='';
		document.getElementById("div_CommentError").style.display = "none";
		return true;
	}

}

</script>
 <style type="text/css">
.conform textarea, .conform input[type="text"], .coonform input[type="password"]{border: 1px solid #cccccc;
-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
-webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
-moz-transition: border linear 0.2s, box-shadow linear 0.2s;
-o-transition: border linear 0.2s, box-shadow linear 0.2s;
transition: border linear 0.2s, box-shadow linear 0.2s;
background-color: #eee;
background: -webkit-gradient(linear, center top, center bottom, color-stop(0%, #fff), color-stop(100%, #efefef));
background: -moz-linear-gradient(top, #fff, #efefef); margin-bottom:10px;}


.conttxt h3, .conttxt p{
font-size: 1.1em;
color: #333;
line-height: 1.2em;
font-weight: normal;
}
.conttxt h3{font-size: 1.7em; color:#0095da;}
 </style>
</head>


<body style="background-color:#f8f8f8; padding-top:0px;">

	<div class="containerHeader" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <div id="logtxt" class="text-center">
             	<div class="col-md-12 pull-right" style="width: 100%; font:24px/24px 'HelveticaRoundedLTStdBdCn', 'helvetica neue', helvetica, sans-serif; text-shadow: 0 0 6px #951500;">
                </div>
           </div>
        </div>
    </div>

<div class="container outboxshad" style="clear:both; background-color:#fff; padding-bottom:10px; ">
	<div class="row">
             <div class="col-md-10" style="float:none; background-color:#fff; margin:auto auto; padding:0px;">

			<?php
				if (isset($_SESSION["DBErrors"]))
				{
					echo ('<DIV class="alert alert-info" style="margin:10px;">');
					$tmp=$_SESSION["DBErrors"][0];
					if (array_key_exists($tmp, $PageErrors))
					{	echo $PageErrors[$tmp][1];	}
					else
					{	echo ('Error code '.$tmp.' is not defined for the page. Please contact your System Administrator');		}

					if (isset($_SESSION["DBErrors"][1]))
					{
						echo ('<br>');
						$tmp=$_SESSION["DBErrors"][1];
						if (array_key_exists($tmp, $PageErrors))
						{	echo $PageErrors[$tmp][1];	}
						else
						{	echo ('Error code '.$tmp.' is not defined for the page. Please contact your System Administrator');		}
					}
					echo ('</DIV>');
					unset($_SESSION["DBErrors"]);
				}
				?>

            <div class="panel panel-default" style="margin-bottom:5px; border:0px solid #fff;">
        	<div class="panel-body">
            	<div class="conttxt col-md-6">
                    <h3 class="bluTxt">Contact Us</h3>
                    <br/>
                    <p style="margin-bottom:5%;">This website and it's content is copyright of <a href="http://www.whywewant.com" target="blank">why we want Organic</a></p>
                    <p style="margin-bottom:5%;">© whywewant.com 2015. All rights reserved.</p>
    				<p style="margin-bottom:5%;">Fill the form for more details and we'll get back to you shortly.</p>
                    <br/>
                 </div>

                 <div class="col-md-6" >
            	<br/>
            	<form id="contact" name="contact" action="whywewant_S_Contact.php" onSubmit="return validateForm(this);" method="POST">
					<div style="background-color:rgba(100,255,200,0.3); padding:20px;">
                   	<input class="form-control" type="text" id="name" name="name" placeholder="Name" style="margin-bottom:10px;"><div class="error" style="color:#ffffff;" id="div_NameError"></div>
                    <input class="form-control" type="text" id="email" name="email" placeholder="Email"  style="margin-bottom:10px;"><div class="error" style="color:#ffffff;" id="div_EmailError"></div>
                    <input class="form-control" type="text" id="phone" name="phone" placeholder="Phone number"  style="margin-bottom:10px;"><div class="error" style="color:#ffffff;" id="div_PhoneError"></div>
                    <textarea class="form-control" rows="3" name="comments" id="comments" placeholder="Your Comments...."></textarea><div class="error" style="color:#ffffff;" id="div_CommentError"  style="margin-bottom:10px;"></div>
                    </div>
                    <input class="btn btn-lg pull-right" type="submit" value="SUBMIT" style="margin-top:.8em;">
                </form>
				<?php
					if (isset($_SESSION['errormsg']))
					{

					$message=$_SESSION['errormsg'];
					echo $message."";
					unset ($_SESSION['errormsg']);
					}
					else
					{
					}
				?>

            	</div>
                 </div>
               </div>
               </div>
              </div>
</div>

</body>
</html>
