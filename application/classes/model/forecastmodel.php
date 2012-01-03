<?php defined('SYSPATH') or die('No direct script access.');

class Model_Forecastmodel extends Model
{
    public function get_xml()
    {
     	$url = 'http://localhost:8888/weather/forecast.xml';   	

		try
		{
			//Create request instance	
			$request = Request::factory($url)
		    	->method('GET');
			
			//Execute request
			$response = $request->execute();
			
			//Return response if status === 200
			if($response->status() === 200)
			{
				return $response;
			}
			else 
			{
				return false;
			}
		}
		catch(Request_Exception $e)
		{
			return false;
		}
    }
}