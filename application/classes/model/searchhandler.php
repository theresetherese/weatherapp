<?php defined('SYSPATH') or die('No direct script access.');

class Model_Searchhandler extends Model
{
	/*
	 * Call forecastmodel to collect xml
	 * Return xml or false
	 */
	
    public function get_location($location)
    {
     	//Create instance of forecastmodel
     	$searchmodel = Model::factory('searchmodel');
		
		//Get xml from model
		$searchXML = $searchmodel->get_location($location);
		
		//Return false or xml
		if($searchXML === false)
		{
			return false;
		} 
		else
		{
			return $searchXML;
		}
    }
	
	public function create_location_object($xml)
	{
		$simplexml = simplexml_load_string($xml);

		$object = $simplexml->xpath('//geoname');
		
		$location = new Location();
		$location->setCity($object[0]->name);
		$location->setRegion($object[0]->adminName1);
		$location->setCountry($object[0]->countryName);
		
		return $location;
	}
}