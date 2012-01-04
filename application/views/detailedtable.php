<h1><?php echo Text::ucfirst($city); ?></h1>

<table>
	
	<?php 
			$date = date('l', $forecasts->getFromTime());
			$fromTime = date('H:i', $forecasts->getFromTime());
			$toTime = date('H:i', $forecasts->getToTime());
			$period = $forecasts->getPeriod();
			$symbol = $forecasts->getSymbol();
			$newsymbol = $symbol;
			$symbolName = $forecasts->getSymbolName();
			$temperature = $forecasts->getTemperature();
			$precipitation = $forecasts->getPrecipitation();
			$pressure = $forecasts->getPressure();
			$windDirectionDeg = $forecasts->getWindDirectionDeg();
			$windDirection = $forecasts->getWindDirection();
			$windSpeed = $forecasts->getWindSpeed();

			if($symbol < 10)
			{
				$newsymbol = '0' . $symbol;
			}
			
			if($symbol < 4 OR $symbol > 4 AND $symbol < 8)
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
			
			
			echo "
				<tr>
					<td>$date $fromTime - $toTime</td>
				</tr>
				<tr>
					<td><img src='" . URL::base('http') . "media/icons/$symbol.png' alt='$symbolName' /></td>
					<td>$temperature &deg; C</td>
				</tr>
				<tr>
					<td>$precipitation</td>
				</tr>
				<tr>
					<td>$pressure</td>
				</tr>
				<tr>
					<td>$windSpeed mps, $windDirectionDeg &deg; $windDirection</td>
				</tr>
			";
	?>
</table>
