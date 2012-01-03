<?php defined('SYSPATH') or die('No direct script access.');

class Model_Forecasthandler extends Model
{
    public function get_xml()
    {
     	//Create instance of forecastmodel
     	$forecastmodel = Model::factory('forecastmodel');
		
		//Get xml from model
		$forecastXML = $forecastmodel->get_xml();
		
		//Return false or xml
		if($forecastXML === false)
		{
			return false;
		} 
		else
		{
			return $forecastXML;
		}
    }
	
	public function get_default_forecast_objects($xml)
	{
		$simplexml = simplexml_load_string($xml);
		$forecasts = $simplexml->xpath('//time');
		
		//The date five days from now
		$fivedays = date('Y-m-d', strtotime('+5 days'));
		
		//Loop through all time entries
		foreach($forecasts as $f)
		{
			$time = strtotime($f['from']);
			
			//Proceed if time is within five days
			if($time < strtotime($fivedays))
			{
				echo date('Y-m-d', $time) . ' / ' . $f->temperature['value'] . '<br />';
			}
		}
	}
}