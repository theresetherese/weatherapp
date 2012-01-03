<?php defined('SYSPATH') or die('No direct script access.');

class Forecast_Hourly extends Forecast_Default
{
    private $precipitation = NULL;
	private $windDirection = NULL;
	private $windSpeed = NULL;
	private $temperature = NULL;
	private $pressure = NULL;
}