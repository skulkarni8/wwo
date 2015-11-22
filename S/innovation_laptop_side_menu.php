<?php 

$sattviccheckbox = '';
$vision_freshcheckbox = '';
$organic_tattvacheckbox = '';
$down_to_earthcheckbox = '';
$conscious_foodcheckbox = '';
$checkbox15 = '';
$checkbox13 = '';
$cheapcheckbox = '';
$mediumcheckbox = '';
$expensivecheckbox = '';

#### checkboxes for brands
if (isset($_SESSION["sattvic"])){
	$sattviccheckbox = 'checked' ;
}
if (isset($_SESSION["vision_fresh"])){
	$vision_freshcheckbox = 'checked' ;
}
if (isset($_SESSION["organic_tattva"])){
	$organic_tattvacheckbox = 'checked' ;
}
if (isset($_SESSION["down_to_earth"])){
	$down_to_earthcheckbox = 'checked' ;
}
if (isset($_SESSION["conscious_food"])){
	$conscious_foodcheckbox = 'checked' ;
}

### checkboxes for Weight type
if (isset($_SESSION["13s"])){
	$checkbox13 = 'checked' ;
}
if (isset($_SESSION["15s"])){
	$checkbox15 = 'checked' ;
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
								<input type="checkbox" class="first" id="sattvic" name="sattvic" <?php echo $sattviccheckbox ?>>
								<label for="sattvic">Sattvic</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="vision_fresh" name="vision_fresh" <?php echo $vision_freshcheckbox ?>>
								<label for="vision_fresh">Vision Fresh</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="organic_tattva" name="organic_tattva" <?php echo $organic_tattvacheckbox ?>>
								<label for="organic_tattva">Organic Tattva</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="down_to_earth" name="down_to_earth" <?php echo $down_to_earthcheckbox ?>>
								<label for="down_to_earth">Down to Earth</label>
							  </div>
							  <div>
								<input type="checkbox" class="first" id="conscious_food" name="conscious_food" <?php echo $conscious_foodcheckbox ?>>
								<label for="conscious_food">Conscious Food</label>
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
								<input type="checkbox" class="second" id="13" name="13" <?php echo $checkbox13 ?>>
								<label for="13">1kg - 2kg </label>
							  </div>
							  <div>
								<input type="checkbox" class="second" id="15" name="15" <?php echo $checkbox15 ?>>
								<label for="15">3kg - 5kg</label>
							  </div>
							</div>
						
</div>