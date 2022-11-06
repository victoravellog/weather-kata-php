<?php

namespace Tests\WeatherKata;

use WeatherKata\Http\Client;
use PHPUnit\Framework\TestCase;
use WeatherKata\APIWeatherImpl;
use WeatherKata\GetPredictionsByCity;

class WeatherTest extends TestCase
{
    private APIWeatherImpl $apiWeatherImpl;

    protected function setUp(): void
    {
        $this->apiWeatherImpl = new APIWeatherImpl(new Client());
    }

    /** @test */
    public function find_the_weather_of_today()
    {
        $forecast = new GetPredictionsByCity($this->apiWeatherImpl);
        $city = "Madrid";

        $prediction = $forecast->predict($city);

        $this->assertEquals('sunny', $prediction);
    }

    /** @test */
    public function find_the_weather_of_any_day()
    {
        $forecast = new GetPredictionsByCity($this->apiWeatherImpl);
        $city = "Madrid";

        $prediction = $forecast->predict($city, new \DateTime('+2 days'));

        $this->assertEquals('sunny', $prediction);
    }

    /** @test */
    public function find_the_wind_of_any_day()
    {
        $forecast = new GetPredictionsByCity($this->apiWeatherImpl);
        $city = "Madrid";
        $prediction = $forecast->predict($city, null, true);

        $this->assertEquals(60.0, $prediction);
    }

    /** @test */
    public function change_the_city_to_woeid()
    {
        $forecast = new GetPredictionsByCity($this->apiWeatherImpl);
        $city = "Madrid";

        $forecast->predict($city, null, true);

        $this->assertEquals("766273", $city);
    }

    /** @test */
    public function there_is_no_prediction_for_more_than_5_days()
    {
        $forecast = new GetPredictionsByCity($this->apiWeatherImpl);
        $city = "Madrid";

        $prediction = $forecast->predict($city, new \DateTime('+6 days'));

        $this->assertEquals("", $prediction);
    }
}