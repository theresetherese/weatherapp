<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller {

	public function action_index()
	{
		//Get location
		
		//Create forecastehandler
		$fHandler = Model::factory('forecasthandler');
		
		//Get xmldata with forecast
		$xml = $fHandler->get_xml();
		
		//Check if data was retrieved
		if($xml !== false)
		{
			//Send xml to handler and create objects
			$fHandler->get_default_forecast_objects($xml);
			
				
			//echo $forecastXML;
		}
		//Send error message that data could not be retrieved 
		else 
		{
			$this->response->body('Kunde inte hämta data.');
			
		}
		
		
	}

} // End Welcome
