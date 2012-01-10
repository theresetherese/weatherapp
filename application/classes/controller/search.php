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
		else if($this->request->param('city'))
		{
			$this->search_query();
		}
		else{
			$this->response->status(400);
			$this->response->body('En sökning måste innehålla koordinater eller sökterm.');
		}
	}	
	
	public function search_query()
	{		
		$templocation = new Location();
		$templocation->setCity($this->request->param('city'));
		
		$searchhandler = Model::factory('searchhandler');
		$xml = $searchhandler->get_location($templocation);
		
		if($locations = $searchhandler->create_location_object_from_query($xml))
		{
			$view = View::factory('search/results');
			$view->locations = $locations;
			
			$this->response->status(200);
			$this->response->body($view);
		}
		else{
			$this->response->status(400);
			$this->response->body('Stad kunde inte hittas');
		}
	}
	
	public function search_geo()
	{
		$templocation = new Location();	
		$templocation->setLat($this->request->query('lat'));
		$templocation->setLong($this->request->query('long'));

		$searchhandler = Model::factory('searchhandler');
		$xml = $searchhandler->get_location($templocation);

		$location = $searchhandler->create_location_object_from_coords($xml);
		$city = $location->getCity();
		$region = $location->getRegion();
		$country = $location->getCountry();
		
		$this->response->status(200);
		$this->response->body("$country/$region/$city");
	}

}