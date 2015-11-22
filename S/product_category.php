<?php 
if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
	} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
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
    <!-- styles -->
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/owl.theme.css" rel="stylesheet">
    <link href="../css/DJ_Theme.css" rel="stylesheet">
    <link href="../css/ihover.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- theme stylesheet -->
    <link href="../css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="../css/custom.css" rel="stylesheet">


    <script src="../js/respond.min.js"></script>

    <!--<link rel="shortcut icon" href="favicon.png">-->
	  <link rel="shortcut icon" href="../img/logo4.png">



</head>

<body>
	
    <?php include_once("header_topbar.php");?>	
    <?php include_once("header_navbar.php");?>

       <section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<?php include_once("shop_television_side_menu.php");?>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
								
					</div><!--features_items-->
						
						
				</div>
			</div>
		</div>
	</section>
     
		<?php include_once("footer.php");?>



    

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
   

	<script>
      
	  var sort_by = '';
      function myFunction() {
			var sort_by = document.getElementById("mySelect").value;
			if(sort_by){ 
				//alert(sort_by);
			}
			
			var opts = getProductFilterOptions();
			//alert(opts);
        updateProducts(opts[0], opts[1], opts[2], sort_by);
			
			//document.getElementById("demo").innerHTML = "You selected: " + x;
		} 

      function getProductFilterOptions(){
        var opts = [];
		var secondopts = [];
		var thirdopts = [];
		var checkboxbuttun;
       
		
		$('input.first').each(function(){
          if($(this).prop('checked')){
            opts.push($(this).attr('name'));
			//alert(opts);
			}
		});

        $('input.second').each(function(){
          if($(this).prop('checked')){
            secondopts.push($(this).attr('name'));
			//alert(secondopts);
			}
		});
		
		 $('input.third').each(function(){
          if($(this).prop('checked')){
            thirdopts.push($(this).attr('name'));
			//alert(thirdopts);
			}
		});
		
		
        return [opts, secondopts, thirdopts];
		
      }

	// post checkes selected, page number and number of checkboxes selected  
      function updateProducts(opts, ftype, prange, sort_by){
		var pn = '<?php echo($pn); ?>';
		if(opts){
			var checkboxselected = opts.length;
		}
		if(ftype){
			var fselected = ftype.length;
		}
		if(prange){
			var priceselected = prange.length;
		}
		$.ajax({
          type: "POST",
          url: "submit3_pagination.php",
          dataType : 'html',
          cache: false,
          data: {filterOpts: opts, featuretype: ftype , price: prange, page: pn, brandcheckboxes : checkboxselected, features : fselected, pricerange: priceselected, sort_page: sort_by },
          success: function(data){
		//	alert(opts);	
		     
			  $('.title.text-center').html(data);
          }
        });
      }

      var $checkboxes = $("input:checkbox");
      $checkboxes.on("change", function(){
        var opts = getProductFilterOptions();
        updateProducts(opts[0], opts[1], opts[2]);
      });

      updateProducts();
    </script>	

    <!--<script>
		$(document).ready(function(){
   $(':checkbox').attr('checked',true);
});
	</script>-->


</body>

</html>
