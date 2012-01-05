<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Calls forecasthandler for xml-data based on request parameters.
 * Responds with detailed or default view for forecasts.
 */

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
		
		//Control that city, region and country is returned correctly.
		if(!is_null($city) AND !is_null($region) AND !is_null($country))
		{
			//Check if data is cached, else request new data and cache it
			$xml = $this->get_xml($country, $region, $city);
			
			//Check if data was retrieved
			if($xml !== false)
			{
				//If date and period is set, then call for a detailed forecast object
				if(!is_null($date) AND !is_null($period))
				{
					//Send xml to handler and create objects
					$fObjects = $fHandler->get_detailed_forecast_object($xml, $date, $period);
					/*
					 * TODO Check if fObject really contains the right objects
					 */
					
					//Create view
					$view = View::factory('forecast/detailedtable');
				}
				//If only date or period is set, send error message 
				else if(!is_null($date) AND is_null($period) OR !is_null($period) AND is_null($date))
				{
					$this->response->status(400);
					$this->response->body('Can not find valid date and period in the url. Valid example: http://thisapp.com/sweden/kalmar/hultsfred/20120105/3');
					return;
				}
				//Call for a fiveday-forecast
				else
				{
					//Send xml to handler and create objects
					$fObjects = $fHandler->get_default_forecast_objects($xml);
					/*
					 * TODO Check if fObjects really contains the right objects
					 */
						
					//Create view
					$view = View::factory('forecast/defaulttable');
				}
				
				//Bind forecastobjects and location to the view
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
				$this->response->status(500);
				$this->response->body('Could not retrieve data.' );
	
			}
		}
		//Country, region or city is == null
		else
		{
			$this->response->status(400);
			$this->response->body('Can not find valid country, region and city in the url. Valid example: http://thisapp.com/sweden/kalmar/hultsfred/' );
		}
	}


	public function get_xml($country, $region, $city)
	{
		// Check for the existance of the cache driver
		if(isset(Cache::$instances['sqlite']))
		{
		     // Get the existing cache instance
		     $memcache = Cache::$instances['sqlite'];
		}
		else
		{
		     // Get the cache driver instance
		     $memcache = Cache::instance('sqlite');
		}
		
		//Check for cached xml
		if ($xml = Cache::instance('sqlite')->get("$country/$region/$city", FALSE))
		{
			echo "hej";			
		    return $xml;
		}
		else
		{
		     $fHandler = Model::factory('forecasthandler');
			 $xml = $fHandler->get_xml($country, $region, $city);
			 
			 //Find out how many seconds until midnigt
			 $tomorrowMidnight = mktime(0, 0, 0, date('n'), date('j') + 1);
			 $now = time();
			 $seconds = $tomorrowMidnight - $now;
			 
			 Cache::instance('sqlite')->set("$country/$region/$city", $xml, $seconds);
			 return $xml;
		}
	}

}// End Welcome
