<?php 


$sattviccheckbox = '';
$vision_freshcheckbox = '';
$conscious_foodcheckbox = '';
$organic_tattvacheckbox = '';
$down_to_earthcheckbox = '';
$smartcheckbox = '';
$checkbox3d = '';
$cheapcheckbox = '';
$mediumcheckbox = '';
$expensivecheckbox = '';

echo "yes session outside";

#### checkboxes for brands
if (isset($_SESSION["sattvic"])){
	echo "yes session";
	$sattviccheckbox = 'checked' ;
}
if (isset($_SESSION["vision_fresh"])){
	$vision_freshcheckbox = 'checked' ;
}
if (isset($_SESSION["down_to_earth"])){
	$down_to_earthcheckbox = 'checked' ;
}
if (isset($_SESSION["conscious_food"])){
	$conscious_foodcheckbox = 'checked' ;
}
if (isset($_SESSION["organic_tattva"])){
	$organic_tattvacheckbox = 'checked' ;
}

### checkboxes for feature type
if (isset($_SESSION["smart"])){
	$smartcheckbox = 'checked' ;
}
if (isset($_SESSION["3D"])){
	$checkbox3d = 'checked' ;
}


# checkboxes for price range
if (isset($_SESSION["cheap"])){
	$cheapcheckbox = 'checked' ;
}
if (isset($_SESSION["medium"])){
	$mediumcheckbox = 'checked' ;
}
if (isset($_SESSION["expensive"])){
	$expensivecheckbox = 'checked' ;
}

?>

<div class="left-sidebar">
						
							
						 <div id="filter">
							 <h2>Brand</h2>
							 <div>
								<!--<input type="checkbox" class="first" id="sattvic" name="sattvic" <?php echo $sattviccheckbox ?>>-->
								<input type="checkbox" class="first" id="sattvic" name="sattvic" 'checked'">
								<label for="sattvic">Sattvic</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="vision_fresh" name="vision_fresh" <?php echo $vision_freshcheckbox ?>>
								<label for="vision_fresh">Vision Fresh</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="conscious_food" name="conscious_food" <?php echo $conscious_foodcheckbox ?>>
								<label for="conscious_food">Conscious Foods</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="organic_tattva" name="organic_tattva" <?php echo $organic_tattvacheckbox ?>>
								<label for="organic_tattva">Organic Tattva</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="down_to_earth" name="down_to_earth" <?php echo $down_to_earthcheckbox ?>>
								<label for="down_to_earth">Down to Earth</label>
							  </div>
							  </br>	
							  <h2>Price Range</h2>
							  <div>
								<input type="checkbox" class="third" id="cheap" name="cheap"<?php echo $cheapcheckbox ?>>
								<label for="cheap">Rs.50 - Rs.100</label>
							  </div>
							  <div>
								<input type="checkbox" class="third" id="medium-priced" name="medium-priced" <?php echo $mediumcheckbox ?>>
								<label for="medium-priced">Rs.100 - Rs.200</label>
							  </div>
							  <div>
								<input type="checkbox" class="third" id="expensive" name="expensive" <?php echo $expensivecheckbox ?>>
								<label for="expensive">Rs.200 - Rs.500</label>
							  </div>
							  </br>
							  <h2>Weight</h2>
							  <div>
								<input type="checkbox" class="second" id="smart" name="smart" <?php echo $smartcheckbox ?>>
								<label for="smart">1kg - 2kg</label>
							  </div>
							  <div>
								<input type="checkbox" class="second" id="3D" name="3D" <?php echo $checkbox3d ?>>
								<label for="3D">3kg - 5kg</label>
							  </div>
							</div>
						
						
						
							
							 
							
					
</div>