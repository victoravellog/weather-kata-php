<?php

namespace Tests\WeatherKata;

use WeatherKata\infrastructure\Http\MockClient;
use PHPUnit\Framework\TestCase;
use WeatherKata\infrastructure\APIPredictionImpl;
use WeatherKata\application\GetWeatherByCity;
use WeatherKata\application\GetWindByCity;

class WeatherTest extends TestCase
{
    private APIPredictionImpl $APIPredictionImpl;

    protected function setUp() : void{
        $this->APIPredictionImpl = new APIPredictionImpl(new MockClient());   
    }
    
    /** @test */
    public function find_the_weather_of_today()
    {
        $getWeatherByCity = new GetWeatherByCity($this->APIPredictionImpl);
        $city     = "Madrid";

        $weather = $getWeatherByCity->invoke($city);

        $this->assertEquals('sunny', $weather);
    }

    /** @test */
    public function find_the_weather_of_any_day()
    {
        $getWeatherByCity = new GetWeatherByCity($this->APIPredictionImpl);       
        $city     = "Madrid";

        $weather = $getWeatherByCity->invoke($city, new \DateTime('+2 days'));

        $this->assertEquals('sunny', $weather);
    }

    /** @test */
    public function find_the_wind_of_any_day()
    {
        $getWindByCity = new GetWindByCity($this->APIPredictionImpl);
        $city = "Madrid";
        
        $wind = $getWindByCity->invoke($city, null);

        $this->assertEquals(60.0, $wind);
    }

    /** @test */
    public function change_the_city_to_woeid()
    {
        $getWeatherByCity = new GetWeatherByCity($this->APIPredictionImpl);        
        $city = "Madrid";

        $getWeatherByCity->invoke($city, null);

        $this->assertEquals("766273", $city);
    }

    /** @test */
    public function there_is_no_weather_prediction_for_more_than_5_days()
    {
        $getWeatherByCity = new GetWeatherByCity($this->APIPredictionImpl);        
        $city = "Madrid";

        $prediction = $getWeatherByCity->invoke($city, new \DateTime('+6 days'));

        $this->assertEquals(null, $prediction);
    }

    /** @test */
    public function there_is_no_wind_prediction_for_more_than_5_days()
    {
        $getWindByCity = new GetWindByCity($this->APIPredictionImpl);        
        $city = "Madrid";

        $prediction = $getWindByCity->invoke($city, new \DateTime('+6 days'));

        $this->assertEquals(null, $prediction);
    }
}