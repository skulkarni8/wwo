<?php 
session_start();

  // DB Connection
include "../storescripts/connect_to_mysql.php"; 
$dynamicList = "";
$prod_id = array();
$prod_name = array();
$prod_price = array();
$prod_brand = array();
$tmp = array();
$opts = array();
$size = array();
$pricetype = array();




#set price rage counter to zero
$pricecounter = 0;

#set feature type counter to zero
$typecounter = 0;

$test = 1;
$testsession = 0;  



  
 // start building sql query where subcatory is Basmati Rice 
 
  $select = 'SELECT B.Product_Id, B.Product_Title, B.Product_Price, B.Brand';
  $from = ' from ( user_productscategory A join user_storeproducts B) ';
  $where = " WHERE SubCategory_Id = 5 and (A.Product_Id = B.Product_Id) ";
  
###############################################################################################  
##########  Read all checkboxes selected and store them in session  ###########################  
###############################################################################################  
// filterOpts are nil in case we change the page or no checkbox is selected 
// if any check box is selected we post it, store that in session  
  if (isset($_POST['filterOpts'])) {
	$opts = $_POST['filterOpts'];
	$_SESSION["opts"] = $opts;
  }
  
  if(isset($_POST['sizetype'])){
	$size = $_POST['sizetype'];
	$_SESSION["sizetype"] = $size;
  }

  if(isset($_POST['price'])){
	$pricetype = $_POST['price'];
	$_SESSION["price"] = $pricetype;
  }
  

##############################################################################################
########## If no checkbox selected delete all sessions for that box  #########################
##############################################################################################
  
  
// In case no checkbox is selected brandcheckboxes will be equal to 0
// clear all sessions   
  if(isset($_POST["brandcheckboxes"])){
	$mychecks = $_POST["brandcheckboxes"] ;
		if ($mychecks == 0) {	
			//unset($_SESSION["opts"]);
			//unset($_SESSION["conscious_food"]);
			//unset($_SESSION["sattvic"]);
			//unset($_SESSION["vision_fresh"]);
			//unset($_SESSION["organic_tattva"]);
			//unset($_SESSION["down_to_earth"]);
		}
	}

// In case no checkbox is selected feature type will be equal to 0
// clear all sessions   
  if(isset($_POST["sizes"])){
	$mychecks1 = $_POST["sizes"] ;
		if ($mychecks1 == 0) {	
			//unset($_SESSION["sizetype"]);
			//unset($_SESSION["13s"]);
			//unset($_SESSION["15s"]);
		}
	}

// In case no checkbox is selected price range will be equal to 0
// clear all sessions   
  if(isset($_POST["pricerange"])){
	$mychecks2 = $_POST["pricerange"] ;
		if ($mychecks2 == 0) {	
			//unset($_SESSION["price"]);
			//unset($_SESSION["cheap"]);
			//unset($_SESSION["medium"]);
		    //unset($_SESSION["expensive"]);
		}
	}



##############################################################################################
########## If checkbox unchecked delete corresponding sessions for that box  #################
##############################################################################################
	
  
// if checkbox is unckeched, delete its session for brand  
  
 if(isset($_SESSION["opts"])){
 
	if (!in_array("sattvic", $_SESSION["opts"])){
			if(isset($_SESSION["sattvic"])){
			unset($_SESSION["sattvic"]);
		}
	}
	
	if (!in_array("conscious_food", $_SESSION["opts"])){
			if(isset($_SESSION["conscious_food"])){
			unset($_SESSION["conscious_food"]);
		}	
	}
	
	if (!in_array("vision_fresh", $_SESSION["opts"])){
			if(isset($_SESSION["vision_fresh"])){
			unset($_SESSION["vision_fresh"]);
		}
	}
	
	if (!in_array("organic_tattva", $_SESSION["opts"])){
			if(isset($_SESSION["organic_tattva"])){
			unset($_SESSION["organic_tattva"]);
		}
	}
	
	if (!in_array("down_to_earth", $_SESSION["opts"])){
			if(isset($_SESSION["down_to_earth"])){
			unset($_SESSION["down_to_earth"]);
		}
	}
}

// if checkbox is unckeched, delete its session for feature type

if(isset($_SESSION["sizetype"])){
 
	if (!in_array("13", $_SESSION["sizetype"])){
			if(isset($_SESSION["13s"])){
			unset($_SESSION["13s"]);
		}
	}
	
	if (!in_array("15", $_SESSION["sizetype"])){
			if(isset($_SESSION["15s"])){
			unset($_SESSION["15s"]);
		}	
	}
}	
	
// if checkbox is unckeched, delete its session for price range type

if(isset($_SESSION["price"])){
 
	if (!in_array("cheap", $_SESSION["price"])){
			if(isset($_SESSION["cheap"])){
			unset($_SESSION["cheap"]);
		}
	}
	
	if (!in_array("medium", $_SESSION["price"])){
			if(isset($_SESSION["medium"])){
			unset($_SESSION["medium"]);
		}	
	}
	
	if (!in_array("expensive", $_SESSION["price"])){
			if(isset($_SESSION["expensive"])){
			unset($_SESSION["expensive"]);
		}	
	}
}	
	
	
 
 
 # Copy checkbox stored in session to opts array. This is used during pagination	
  if(isset($_SESSION["opts"])){
	$opts = $_SESSION["opts"];
  }
 
 # Copy checkbox stored in session to ftype array. This is used during pagination	
  if(isset($_SESSION["sizetype"])){
	$size = $_SESSION["sizetype"];
  }
  
  # Copy checkbox stored in session to pricetype array. This is used during pagination
  if(isset($_SESSION["price"])){
	$pricetype = $_SESSION["price"];
  }
 
 
 
 
 
 
 
 
###############################################################################################
########## if no checkbox selected or filter applied  #########################################
###############################################################################################
 
  if (empty($opts) AND empty($size) AND empty($pricetype)){
    $where .= ' AND TRUE';
  } 
  
  
##############################################################################################
######### if only brand selected  ############################################################  
##############################################################################################
  
  if(!empty($opts) AND empty($size) AND empty($pricetype)){
	foreach ($opts as $opt) {
		if ($opt == 'sattvic' OR $opt == 'conscious_food' OR $opt == 'organic_tattva' OR $opt == 'down_to_earth' OR $opt == 'vision_fresh' ) {
     	$tmp[] = '"'.$opt.'"';
		$_SESSION[$opt] = $opt;
		}
	}
	
	
	if (count($tmp) == 0) {
		$where .= ' AND TRUE'; 
  	}
	else {
		$where .= ' AND brand IN ('.implode(",", $tmp).')'; 
	}
}

  
##############################################################################################
######### if only feature type selected  #####################################################
##############################################################################################
  
  if(empty($opts) AND !empty($size) AND empty($pricetype)){
	if (in_array("13", $size)){
		$typecounter = $typecounter + 1;
	}
	
	if (in_array("15", $size)){
		$typecounter = $typecounter + 1;
	}
	
	if($typecounter == 1) {
		if (in_array("13", $size)){
				$where .= " AND Weight <= 2";
				$_SESSION["13s"] = "13" ;
		}
		else {
			if (isset($_SESSION["13s"])){
				unset($_SESSION["13s"]);
			}
		}	
		
		if (in_array("15", $size)){
				$where .= " AND Weight > 2";
				$_SESSION["15s"] = "15" ;
		}
		else{
			if(isset($_SESSION["15s"])){
				unset($_SESSION["15s"]);
			}
		}	
	}
	
	if($typecounter == 2) {
		$where .= " AND (Weight <= 2 OR Weight > 2 )" ;
		$_SESSION["13s"] = "13" ;
		$_SESSION["15s"] = "15" ;
	}
	
	if($typecounter == 0){
		if (isset($_SESSION["13s"])){
			unset($_SESSION["13s"]);
		}
		if(isset($_SESSION["15s"])){
			unset($_SESSION["15s"]);
		}
	}
 } 
  

##############################################################################################
######### if only price range selected  #####################################################
##############################################################################################

 if (empty($opts) AND empty($size) AND !empty($pricetype)) {
	if (in_array("cheap", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("medium-priced", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("expensive", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}
	
	if($pricecounter == 1)
	{
			if (in_array("cheap", $pricetype)){
				$where .= " AND Product_Price > 10 AND Product_Price <= 100";
				$_SESSION["cheap"] = "cheap" ;
			}
			else {
				if(isset($_SESSION["cheap"])){
					unset($_SESSION["cheap"]);
				}
			}

			if (in_array("medium-priced", $pricetype)){
				$where .= " AND Product_Price > 100 AND Product_Price <= 200";
				$_SESSION["medium"] = "medium";
			}
			else{
				if(isset($_SESSION["medium"])){
					unset($_SESSION["medium"]);
				}
			}

			if (in_array("expensive", $pricetype)){
				$where .= " AND Product_Price > 200 AND Product_Price <= 500";
				$_SESSION["expensive"] = "expensive" ;
			}
			else{
				if(isset($_SESSION["expensive"])){
					unset($_SESSION["expensive"]);
				}
			}
	}
	
	if($pricecounter == 2)
	{	
		if ((in_array("cheap", $pricetype)) AND (in_array("medium-priced", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ))";
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(isset($_SESSION["expensive"])){
				unset($_SESSION["expensive"]);
			}
		}
			
		if ((in_array("cheap", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 200 AND Product_Price <= 500 ))"; 
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(isset($_SESSION["medium"])){
				unset($_SESSION["medium"]);
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}
		}

		if ((in_array("medium-priced", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 100 AND Product_Price <= 200) OR (Product_Price > 200 AND Product_Price <= 500 ))";
			if(isset($_SESSION["cheap"])){
				unset($_SESSION["cheap"]);
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}	
		}

		
	}

	if($pricecounter == 3)
	{	
		$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ) OR (Product_Price > 200 AND Product_Price <= 500))";
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}	
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}	
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
	}	
  	
}


##############################################################################################
######### if brand and price range selected  ################################################
##############################################################################################

if (!empty($opts) AND empty($size) AND !empty($pricetype)){
	
	foreach ($opts as $opt) {
		if ($opt == 'sattvic' OR $opt == 'conscious_food' OR $opt == 'organic_tattva' OR $opt == 'down_to_earth' OR $opt == 'vision_fresh' ) {
     	$tmp[] = '"'.$opt.'"';
		$_SESSION[$opt] = $opt;
		}
	}
	
	$where .= ' AND brand IN ('.implode(",", $tmp).')'; 
	
	if (in_array("cheap", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("medium-priced", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("expensive", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}
	
	if($pricecounter == 1)
	{
			if (in_array("cheap", $pricetype)){
				$where .= " AND Product_Price > 10 AND Product_Price <= 100";
				$_SESSION["cheap"] = "cheap" ;
			}
			else {
				if(isset($_SESSION["cheap"])){
					unset($_SESSION["cheap"]);
				}
			}

			if (in_array("medium-priced", $pricetype)){
				$where .= " AND Product_Price > 100 AND Product_Price <= 200";
				$_SESSION["medium"] = "medium";
			}
			else{
				if(isset($_SESSION["medium"])){
					unset($_SESSION["medium"]);
				}
			}

			if (in_array("expensive", $pricetype)){
				$where .= " AND Product_Price > 200 AND Product_Price <= 500";
				$_SESSION["expensive"] = "expensive" ;
			}
			else{
				if(isset($_SESSION["expensive"])){
					unset($_SESSION["expensive"]);
				}
			}
	}
	
	if($pricecounter == 2)
	{	
		if ((in_array("cheap", $pricetype)) AND (in_array("medium-priced", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ))";
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(isset($_SESSION["expensive"])){
				unset($_SESSION["expensive"]);
			}
		}
			
		if ((in_array("cheap", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 200 AND Product_Price <= 500 ))"; 
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(isset($_SESSION["medium"])){
				unset($_SESSION["medium"]);
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}
		}

		if ((in_array("medium-priced", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 100 AND Product_Price <= 200) OR (Product_Price > 200 AND Product_Price <= 500 ))";
			if(isset($_SESSION["cheap"])){
				unset($_SESSION["cheap"]);
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}	
		}
	}
	
	if($pricecounter == 3)
	{	
		$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ) OR (Product_Price > 200 AND Product_Price <= 500))"; 
		if(!isset($_SESSION["cheap"])){
			$_SESSION["cheap"] = "cheap";
		}	
	
		if(!isset($_SESSION["medium"])){
			$_SESSION["medium"] = "medium";
		}	
		if(!isset($_SESSION["expensive"])){
			$_SESSION["expensive"] = "expensive";
		}	
	}
}	

##############################################################################################
######### if feature type and price range selected  ################################################
##############################################################################################
 if (empty($opts) AND !empty($size) AND !empty($pricetype)){
	if (in_array("cheap", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("medium-priced", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("expensive", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}
	
	
	if (in_array("13", $size)){
		$typecounter = $typecounter + 1;
	}
	
	if (in_array("15", $size)){
		$typecounter = $typecounter + 1;
	}

	if($pricecounter == 1)
	{
			if (in_array("cheap", $pricetype)){
				$where .= " AND Product_Price > 10 AND Product_Price <= 100";
				$_SESSION["cheap"] = "cheap" ;
			}
			else {
				if(isset($_SESSION["cheap"])){
					unset($_SESSION["cheap"]);
				}
			}

			if (in_array("medium-priced", $pricetype)){
				$where .= " AND Product_Price > 100 AND Product_Price <= 200";
				$_SESSION["medium"] = "medium";
			}
			else{
				if(isset($_SESSION["medium"])){
					unset($_SESSION["medium"]);
				}
			}

			if (in_array("expensive", $pricetype)){
				$where .= " AND Product_Price > 200 AND Product_Price <= 500";
				$_SESSION["expensive"] = "expensive" ;
			}
			else{
				if(isset($_SESSION["expensive"])){
					unset($_SESSION["expensive"]);
				}
			}
	}
	
	if($pricecounter == 2)
	{	
		if ((in_array("cheap", $pricetype)) AND (in_array("medium-priced", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ))";
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(isset($_SESSION["expensive"])){
				unset($_SESSION["expensive"]);
			}
		}
			
		if ((in_array("cheap", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 200 AND Product_Price <= 500 ))"; 
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(isset($_SESSION["medium"])){
				unset($_SESSION["medium"]);
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}
		}

		if ((in_array("medium-priced", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 100 AND Product_Price <= 200) OR (Product_Price > 200 AND Product_Price <= 500 ))";
			if(isset($_SESSION["cheap"])){
				unset($_SESSION["cheap"]);
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}	
		}	
  	}
	
	if($pricecounter == 3)
	{	
		$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ) OR (Product_Price > 200 AND Product_Price <= 500))"; 
		if(!isset($_SESSION["cheap"])){
			$_SESSION["cheap"] = "cheap";
		}	
	
		if(!isset($_SESSION["medium"])){
			$_SESSION["medium"] = "medium";
		}	
		if(!isset($_SESSION["expensive"])){
			$_SESSION["expensive"] = "expensive";
		}	
	}
	
	if($typecounter == 1) {
		if (in_array("13", $size)){
				$where .= " AND Weight <= 2";
				$_SESSION["13s"] = "13" ;
		}
		else {
			if (isset($_SESSION["13s"])){
				unset($_SESSION["13s"]);
			}
		}	
		
		if (in_array("15", $size)){
				$where .= " AND Weight > 2 ";
				$_SESSION["15s"] = "15" ;
		}
		else{
			if(isset($_SESSION["15s"])){
				unset($_SESSION["15s"]);
			}
		}	
	}
	
	if($typecounter == 2) {
		$where .= " AND (Weight <= 2 OR Weight > 2)" ;
		$_SESSION["13s"] = "13" ;
		$_SESSION["15s"] = "15" ;
	}
	
	if($typecounter == 0){
		if (isset($_SESSION["13s"])){
			unset($_SESSION["13s"]);
		}
		if(isset($_SESSION["15s"])){
			unset($_SESSION["15s"]);
		}
	}	
}


##############################################################################################
######### if only brand and feature type selected  ################################################
##############################################################################################
  if (!empty($opts) AND !empty($size) AND empty($pricetype)){
	foreach ($opts as $opt) {
		if ($opt == 'sattvic' OR $opt == 'conscious_food' OR $opt == 'organic_tattva' OR $opt == 'down_to_earth' OR $opt == 'vision_fresh' ) {
     	$tmp[] = '"'.$opt.'"';
		$_SESSION[$opt] = $opt;
		}
	}
	
	$where .= ' AND brand IN ('.implode(",", $tmp).')'; 
	
	if (in_array("13", $size)){
		$typecounter = $typecounter + 1;
	}
	
	if (in_array("15", $size)){
		$typecounter = $typecounter + 1;
	}
	
	if($typecounter == 1) {
		if (in_array("13", $size)){
				$where .= " AND Weight <= 2";
				$_SESSION["13s"] = "13" ;
		}
		else {
			if (isset($_SESSION["13s"])){
				unset($_SESSION["13s"]);
			}
		}	
		
		if (in_array("15", $size)){
				$where .= " AND Weight > 2";
				$_SESSION["15s"] = "15" ;
		}
		else{
			if(isset($_SESSION["15s"])){
				unset($_SESSION["15s"]);
			}
		}	
	}
	
	if($typecounter == 2) {
		$where .= " AND (Weight <= 2 OR Weight > 2)" ;
		$_SESSION["13s"] = "13" ;
		$_SESSION["15s"] = "15" ;
	}
}

  
##############################################################################################
######### if brand, price rang and feature type selected  ################################################
##############################################################################################
  
# If checkbox/filter selected, store that in session and build query based on filter/checkbox selected   
 elseif (!empty($opts) AND !empty($size) AND !empty($pricetype)) 
  {
	
	foreach ($opts as $opt) {
		if ($opt == 'sattvic' OR $opt == 'conscious_food' OR $opt == 'organic_tattva' OR $opt == 'down_to_earth' OR $opt == 'vision_fresh' ) {
     	$tmp[] = '"'.$opt.'"';
		$_SESSION[$opt] = $opt;
		}
	}
	
	
	if (count($tmp) == 0) {
		$where .= ' AND TRUE'; 
  	}
	else {
		$where .= ' AND brand IN ('.implode(",", $tmp).')'; 
	}
	
	if (in_array("cheap", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("medium-priced", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}

	if (in_array("expensive", $pricetype)){
		$pricecounter = $pricecounter + 1;
	}
	
	if (in_array("13", $size)){
		$typecounter = $typecounter + 1;
	}
	
	if (in_array("15", $size)){
		$typecounter = $typecounter + 1;
	}

	if($pricecounter == 1)
	{
			if (in_array("cheap", $pricetype)){
				$where .= " AND Product_Price > 10 AND Product_Price <= 100";
				$_SESSION["cheap"] = "cheap" ;
			}
			else {
				if(isset($_SESSION["cheap"])){
					unset($_SESSION["cheap"]);
				}
			}

			if (in_array("medium-priced", $pricetype)){
				$where .= " AND Product_Price > 100 AND Product_Price <= 200";
				$_SESSION["medium"] = "medium";
			}
			else{
				if(isset($_SESSION["medium"])){
					unset($_SESSION["medium"]);
				}
			}

			if (in_array("expensive", $pricetype)){
				$where .= " AND Product_Price > 200 AND Product_Price <= 500";
				$_SESSION["expensive"] = "expensive" ;
			}
			else{
				if(isset($_SESSION["expensive"])){
					unset($_SESSION["expensive"]);
				}
			}
	}
	
	if($pricecounter == 2)
	{	
		if ((in_array("cheap", $pricetype)) AND (in_array("medium-priced", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ))";
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(isset($_SESSION["expensive"])){
				unset($_SESSION["expensive"]);
			}
		}
			
		if ((in_array("cheap", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 200 AND Product_Price <= 500 ))"; 
			if(!isset($_SESSION["cheap"])){
				$_SESSION["cheap"] = "cheap";
			}
			if(isset($_SESSION["medium"])){
				unset($_SESSION["medium"]);
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}
		}

		if ((in_array("medium-priced", $pricetype)) AND (in_array("expensive", $pricetype))){
			$where .= " AND ((Product_Price > 100 AND Product_Price <= 200) OR (Product_Price > 200 AND Product_Price <= 500 ))";
			if(isset($_SESSION["cheap"])){
				unset($_SESSION["cheap"]);
			}
			if(!isset($_SESSION["medium"])){
				$_SESSION["medium"] = "medium";
			}	
			if(!isset($_SESSION["expensive"])){
				$_SESSION["expensive"] = "expensive";
			}	
		}	
  	}

	if($pricecounter == 3)
	{	
		$where .= " AND ((Product_Price > 10 AND Product_Price <= 100) OR (Product_Price > 100 AND Product_Price <= 200 ) OR (Product_Price > 200 AND Product_Price <= 500))"; 
		if(!isset($_SESSION["cheap"])){
			$_SESSION["cheap"] = "cheap";
		}	
	
		if(!isset($_SESSION["medium"])){
			$_SESSION["medium"] = "medium";
		}	
		if(!isset($_SESSION["expensive"])){
			$_SESSION["expensive"] = "expensive";
		}	
	}	
  	
	
	if($typecounter == 1) {
		if (in_array("13", $size)){
				$where .= " AND Weight <= 2";
				$_SESSION["13s"] = "13" ;
		}
		else {
			if (isset($_SESSION["13s"])){
				unset($_SESSION["13s"]);
			}
		}	
		
		if (in_array("15", $size)){
				$where .= " AND Weight > 2";
				$_SESSION["15s"] = "15" ;
		}
		else{
			if(isset($_SESSION["15s"])){
				unset($_SESSION["15s"]);
			}
		}	
	}
	
	if($typecounter == 2) {
		$where .= " AND (Weight <= 2 OR Weight > 2)" ;
		$_SESSION["13s"] = "13" ;
		$_SESSION["15s"] = "15" ;
	}
	
	if($typecounter == 0){
		if (isset($_SESSION["13s"])){
			unset($_SESSION["13s"]);
		}
		if(isset($_SESSION["15s"])){
			unset($_SESSION["15s"]);
		}
	}
}  
  
  $query = $select . $from . $where ;
  $sql = $con->query($query);
  
  //$sql = mysql_query($query);   <== I commented

  
  //////////////////////////////////// Pagination Logic ////////////////////////////////////////////////////////////////////////
  $nr = $sql->num_rows;
  //$nr = mysql_num_rows($sql); // Get total of Num rows from the database query    <== I commented
  
  
  
  
  if (isset($_POST['page'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_POST['page']); // filter everything but numbers for security(new)
	} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
  }
  
  $pnafterget = $pn;
  //This is where we set how many database items to show on each page
  $itemsPerPage = 6;
  // Get the value of the last page in the pagination result set
  $lastPage = ceil($nr / $itemsPerPage);
  // Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
  if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
   } else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
  }
	// This creates the numbers to click in between the next and back buttons
	// This section is explained well in the video that accompanies this script
	$centerPages = "";
	$sub1 = $pn - 1;
	$sub2 = $pn - 2;
	$add1 = $pn + 1;
	$add2 = $pn + 2;
	if ($pn == 1) {
		$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
	} else if ($pn == $lastPage) {
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
		$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
	} else if ($pn > 2 && $pn < ($lastPage - 1)) {
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
		$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
	} else if ($pn > 1 && $pn < $lastPage) {
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
		$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
		$centerPages .= '&nbsp; <a href="product_category.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
		
	}
	// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
	$limit = ' LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;
	// Now we are going to run the same query as above but this time add $limit onto the end of the SQL syntax
	// $sql2 is what we will use to fuel our while loop statement below
	$query = $query . $limit;
	//$sql2 = mysql_query($query);  <== I commented
	$sql2 = $con->query($query);
  
	
	
	
//////////////////////////////// END Pagination Logic ////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Pagination Display Setup /////////////////////////////////////////////////////////////////////
	$paginationDisplay = ""; // Initialize the pagination output variable
	// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
	if ($lastPage != "1"){
		// This shows the user what page they are on, and the total number of pages
		$paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
		// If we are not on page 1 we can place the Back button
		if ($pn != 1) {
			$previous = $pn - 1;
			$paginationDisplay .=  '&nbsp;  <a href="product_category.php?pn=' . $previous . '"> Back</a> ';
		}
		// Lay in the clickable numbers display here between the Back and Next links
		$paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
		// If we are not on the very last page we can place the Next button
		if ($pn != $lastPage) {
			$nextPage = $pn + 1;
			$paginationDisplay .=  '&nbsp;  <a href="product_category.php?pn=' . $nextPage . '"> Next</a> ';
		}
	}
	///////////////////////////////////// END Pagination Display Setup ///////////////////////////////////////////////////////////////////////////
	// Build the Output Section Here
  
//$productCount = mysql_num_rows($sql2); // count the output amount  <== I commented
$productCount = $sql2->num_rows;

if ($productCount > 0) {
	$dynamicList .= '<div style="margin-left:64px; margin-right:64px;">
						<h2>Total Items:' . $nr . '</h2>
					</div>
					<div style="margin-left:58px; margin-right:58px; padding:6px; background-color:#FFF; border:#999 1px solid;"><' . $paginationDisplay . '></div>'; 
					
	
	for ($i = 0; $i < $productCount  ; $i++) {

	//mysql_data_seek($sql2, $i);
	$sql2->data_seek($i);
    //$row = mysql_fetch_row($sql2);
	$row = $sql2->fetch_row();
	 
	array_push($prod_id, $row[0]);
	array_push($prod_name, $row[1]);
	array_push($prod_price, number_format($row[2]));
	array_push($prod_brand, $row[3]);
	
	$dynamicList .= '<div class="myitemsToFilter" data-type="' . $prod_brand[$i] . '">
						<div class="col-sm-4">
                        	<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">
										<img src="../inventory_images/' . $prod_id[$i] . '.jpg" alt="" />
										<h2>$' . $prod_price[$i] . '</h2>
										<p>' . $prod_name[$i] . '</p>
										<a href="shop_product-details.php?id=' . $prod_id[$i] . '" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
									</div>
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
										<li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>';
	
						
	}
}	

	else{
		$dynamicList = "<h3> No Products found <h3>";
	}
		
	
	
	//echo $hpsession;
	//echo $inpost;
	//echo $removehp;
	//echo $key;
	//echo serialize($opts);
	//echo sizeof($opts); 
	//echo $pnafterget;
	//echo $limit; 
	//echo $checkboxcounter;
	//echo serialize($size);
	//echo $query;
	//echo print_r($_SESSION);
	//echo $mychecks;
	//echo $pn;
	echo $dynamicList;
	
?>