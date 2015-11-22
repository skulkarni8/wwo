<?php
$Current_Page="Mcd_Placement_CompanyList.php";

require("../C/whywewant_Class_StoreCart.php");

require("whywewant_Initialization.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
$_SESSION['Page']=$Page;


$SubCategory =array();

$Cart_Items=new Cart_Items();
$Cart_Items->getSubCaterogy('');
$SubCategory=$Cart_Items->SubCategory;
?>

<!DOCTYPE html>
<html>
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

    <!-- theme stylesheet -->
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../T/newmenu.css" rel="stylesheet">

    <script src="../js/respond.min.js"></script>

<script type="text/javascript">

function createRequest() {

  try {
    request = new XMLHttpRequest();
  } catch (trymicrosoft) {
    try {
      request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (othermicrosoft) {
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (failed) {
        request = false;
      }
    }
  }
  if (!request)
   { alert("Error initializing XMLHttpRequest!");}
   else
   { return request;   }
}

function getProductCatList(Cat_Id)
{

  var newreq=createRequest();
  var url=("User_BuildProdCatList.php?Cat_Id="+Cat_Id);
  newreq.onreadystatechange=function()
  {
    if (newreq.readyState==4 && newreq.status==200)
    {//alert(newreq.responseText);
      if (newreq.responseText=='')
      { document.getElementById("div_ProdCatList").style.visibility = "hidden";   }
      else
      {

        document.getElementById("div_ProdCatList").style.visibility = "visible";
        document.getElementById("div_ProdCatList").innerHTML=newreq.responseText;
      }
    }
  }
  newreq.open("GET",url,false);
  newreq.send();
}

function ChangeActive(val,Total)
{
  for(var i=1;i<Total;i++)
  {
    if(i==val)
    {
      document.getElementById('Cat_'+val).className = "list-group-item active"; }
    else
    {  document.getElementById('Cat_'+i).className = "list-group-item";  }
  }
}

function PageLoader()
{
  var y=document.getElementById("RowsPerPage");
  if (y!=null)
  {
    if (y.length==0)
    { rowsperpage=25; }
    else
    { rowsperpage=y.value }
  }
  else
  { rowsperpage=25; }
   getProductCatList(1);

}

</script>
</head>
  <body  onload="PageLoader();" style="background-color: #f8f8f8;">

   <body>

     <?php include_once("analyticstracking.php") ?>
     <?php include_once("header_topbar.php");?>

     <?php include_once("header_navbar.php"); ?>

    <?php //include_once("header_topbar.php");?>

    <?php //include_once("headernew_navbar.php");?>

    <div class="container outboxshad" style="padding:0px;">
      <div class="row">
        <div class="col-md-12">
          <?php
            if (isset($_SESSION["DBErrors"]))
              {
                  echo ('<DIV class="alert alert-info" style="margin:10px;">');
                  $tmp=$_SESSION["DBErrors"][0];
                  if (array_key_exists($tmp, $PageErrors))
                  {   echo $PageErrors[$tmp][1];  }

                  {   echo ('Error code '.$tmp.' is not defined for the page. Please contact your System Administrator'); }
                  if (isset($_SESSION["DBErrors"][1]))
                  {
                  echo ('<br>');
                  $tmp=$_SESSION["DBErrors"][1];
                  if (array_key_exists($tmp, $PageErrors))
                  {   echo $PageErrors[$tmp][1];  }
                  else
                  {
                    echo ('Error code '.$tmp.' is not defined for the page. Please contact your System Administrator'); }
                  }
                  echo ('</DIV>');
                  unset($_SESSION["DBErrors"]);
              }
			 echo ('<div class="panel panel-default" style="margin-bottom:0px; border:1px solid #ddd;margin-top:5px;">');

          ?>


          <div  class="col-md-2" style="padding-right:0px; padding-left:0px; height:400px; overflow-y:auto;">
           <?php
				 $i=1;
                  $CountList=Count($SubCategory);
                  echo '<div class="list-group" id="com">';
                  foreach ($SubCategory as $key => $value)
                    {
                        if($i==1)
                        {  $Cls= "list-group-item active";  }
                        else
						{  $Cls="list-group-item";   }

						  echo '<a href="#" id="Cat_'.$i.'" onclick="getProductCatList('.$key.');ChangeActive('.$i.','.$CountList.');"  Class="'.$Cls.'" style="padding:7px 10px; border-top-right-radius: 0px; border-top-left-radius: 0px;">'.$value['Category_Name'].'</a> ';
						 $i++;
					}

               ?>
				</div>
			</div>

	<div id="div_ProdCatList" class="col-md-10" style="padding-bottom:10px;" > </div>

   </div>
  </div>
</div>
</div>


<?php include_once("footer_links.php");?>
  <?php //include_once("footer.php");?>
<?php include_once("final_footer.php");?>

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
