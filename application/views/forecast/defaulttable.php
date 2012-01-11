<h1 id="forecastTitle"><?php echo Text::ucfirst($city) . ', ' . Text::ucfirst($region) . ', ' . Text::ucfirst($country); ?></h1>
<p class="addFavorite"><a href="#" class="addFavoriteLink" id="<?php echo "$country/$region/$city"; ?>">Add favorite</a></p>
<table>
	<thead>
		<th>Date</th>
		<th>Time</th>
		<th>Weather</th>
		<th>Temperature</th>
		<th>Details</th>
	</thead>
	<?php 
		foreach ($forecasts as $f)
		{
			$date = date('l', $f->getFromTime());
			$fulldate = date('Ymd', $f->getFromTime());
			$fromTime = date('H:i', $f->getFromTime());
			$toTime = date('H:i', $f->getToTime());
			$period = $f->getPeriod();
			$symbol = $f->getSymbol();
			$newsymbol = $symbol;

			if($symbol < 10)
			{
				$newsymbol = '0' . $symbol;
			}
			
			if($symbol < 4 OR $symbol > 4 AND $symbol < 9)
			{
				if($period === 3)
				{
					$newsymbol = $newsymbol . 'n';
				}
				else
				{
					$newsymbol = $newsymbol . 'd';	
				}
			}
			
			$symbol = $newsymbol;
			
			$symbolName = $f->getSymbolName();
			$temperature = $f->getTemperature();
			echo "
				<tr>
					<td>$date</td>
					<td>$fromTime - $toTime</td>
					<td><img src='" . URL::base('http') . "media/icons/$symbol.png' alt='$symbolName' /></td>
					<td>$temperature &deg; C</td>
					<td><a href='#' id='$country/$region/$city/$fulldate/$period' class='detailsLink'>Details</a></td>
				</tr>
			";
		}
	?>
</table>
