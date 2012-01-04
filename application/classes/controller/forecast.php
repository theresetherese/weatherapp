<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Forecast extends Controller {
	
	public function action_index()
	{		
		//Create forecastehandler
		$fHandler = Model::factory('forecasthandler');
		
		//Retrieve request params
		$country = $this->request->param('country');
		$region = $this->request->param('region');
		$city = $this->request->param('city');
		$date = $this->request->param('date');
		$period = $this->request->param('period');
		
		if(is_string($city) AND is_string($region) AND is_string($country))
		{
			//Get xmldata with forecast for the city
			$xml = $fHandler->get_xml($country, $region, $city);
			
			//Check if data was retrieved
			if($xml !== false)
			{
				
				if(is_string($date) AND is_string($period))
				{
					//Send xml to handler and create objects
					$fObjects = $fHandler->get_detailed_forecast_object($xml, $date, $period);
					/*
					 * TODO Check if fObject really contains the right objects
					 */
					
					//Create view
					$view = View::factory('detailedtable');
				}
				else
				{
					//Send xml to handler and create objects
					$fObjects = $fHandler->get_default_forecast_objects($xml);
					/*
					 * TODO Check if fObjects really contains the right objects
					 */
						
					//Create view
					$view = View::factory('defaulttable');
				}
				
				//Bind forecastobjects to the view
				$view->forecasts = $fObjects;
				$view->country = $country;
				$view->region = $region;
				$view->city = $city;
		
				//Add view to template
				$this->response->status(200);
				$this->response->body($view);
				
			}
			//Send error message that data could not be retrieved 
			else 
			{
				$this->response->status(404);
				$this->response->body('Kunde inte hämta data.' );
	
			}
		}

		else
		{
			$this->response->status(404);
			$this->response->body('Måste skicka stad som parameter.' );
		}
	}

}// End Welcome
