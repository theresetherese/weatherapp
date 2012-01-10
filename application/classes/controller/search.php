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
		$page = $this->request->param('page');
		
		$xml = $this->cache($templocation, $page);
		
		$searchhandler = Model::factory('searchhandler');
		if($locations = $searchhandler->create_location_object_from_query($xml))
		{
			$view = View::factory('search/results');
			$view->locations = $locations;
			$view->pageNr = $page;
			$view->query = $templocation->getCity();
			
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
		
		$xml = $this->cache($templocation);
		$searchhandler = Model::factory('searchhandler');
		
		if($location = $searchhandler->create_location_object_from_coords($xml))
		{
			$city = $location->getCity();
			$region = $location->getRegion();
			$country = $location->getCountry();
			
			$this->response->status(200);
			$this->response->body("$country/$region/$city");
		}
		else{
			$this->response->status(400);
			$this->response->body('Stad kunde inte hittas');
		}
	}
	
	public function cache(Location $location, $page = NULL)
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
		
		$lat = $location->getLat();
		$long = $location->getLong();
		$city = $location->getCity();

		if (is_array($page) OR is_null($page))
		{
			$page = 0;
		}

		//Check for cached xml
		if ($xml = Cache::instance('sqlite')->get($city . "_" . $page, FALSE))
		{			
		    return $xml;
		}
		else if($xml = Cache::instance('sqlite')->get("$lat,$long", FALSE))
		{
			return $xml;
		}
		else
		{
			$searchhandler = Model::factory('searchhandler');
			$xml = $searchhandler->get_location($location, $page);
			
			//Find out how many seconds until midnigt
			$week = strtotime('+1 week');
			
			if(!is_null($city))
			{
				Cache::instance('sqlite')->set($city . "_" . $page, $xml, $week);
			}
			else if(!is_null($lat) AND !is_null($long))
			{
				Cache::instance('sqlite')->set("$lat,$long", $xml, $week);
			}
			
			return $xml;
		}
	}

}