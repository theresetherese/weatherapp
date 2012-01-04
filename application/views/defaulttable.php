<h1><?php echo Text::ucfirst($city); ?></h1>

<table>
	
	<?php 
		foreach ($forecasts as $f)
		{
			$date = date('l', $f->getFromTime());
			$fromTime = date('H:i', $f->getFromTime());
			$toTime = date('H:i', $f->getToTime());
			$period = $f->getPeriod();
			$symbol = $f->getSymbol();
			$newsymbol = $symbol;

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
			
			$symbolName = $f->getSymbolName();
			$temperature = $f->getTemperature();
			echo "
				<tr>
					<td>$date</td>
					<td>$fromTime - $toTime</td>
					<td><img src='" . URL::base('http') . "media/icons/$symbol.png' alt='$symbolName' /></td>
					<td>$temperature &deg; C</td>
				</tr>
			";
		}
	?>
</table>
