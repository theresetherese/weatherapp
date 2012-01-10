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

<?php
	
	if ($pageNr >= 1)
	{
		echo '<a href="#" id="' . $query . '/' . ($pageNr - 1) . '" class="paginationLink">&laquo; Previous results</a> ';
	}
	if(count($locations) === 10)
	{
		echo '<a href="#" id="' . $query . '/' . ($pageNr + 1) . '" class="paginationLink">Next results &raquo;</a>';
	}
?>