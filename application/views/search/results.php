<ol>
	<?php
	
		foreach ($locations as $location) {
			$city = $location->getCity();
			$region = $location->getRegion();
			$country = $location->getCountry();
			
			echo "<li><a href='#' class='chooseLocationLink' id='$country/$region/$city'>$city, $region, $country</a>";
		}
	?>
</ol>