<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Calls forecasthandler for xml-data based on request parameters.
 * Responds with detailed or default view for forecasts.
 */

class Controller_Search extends Controller {
		
	public function action_index()
	{
		if($this->request->query('lat') AND $this->request->query('long'))
		{
			$this->search_geo();
		}
	}	
	
	public function search_query()
	{		
		$this->response->body('SÖKNING');
	}
	
	public function search_geo()
	{
		$templocation = new Location();	
		$templocation->setLat($this->request->query('lat'));
		$templocation->setLong($this->request->query('long'));

		$searchhandler = Model::factory('searchhandler');
		$xml = $searchhandler->get_location($templocation);
		
		$location = $searchhandler->create_location_object($xml);
		$city = $location->getCity();
		$region = $location->getRegion();
		$country = $location->getCountry();
		
		$this->response->status(200);
		$this->response->body("$country/$region/$city");
	}

}