<?php

use WeatherKata\Http\Client;

class APIWeatherImpl implements WeatherRepository{
    public function __construct(private Client $client){

    }
    public function getId(string $city) : string{
      return $client->get("https://www.metaweather.com/api/location/search/?query=$city");
    }
    public function getPredictions(string $id) : array{
      $results = $client->get("https://www.metaweather.com/api/location/$id");
      return $results;
    }

    public function getPredictionsByCity(string $city): array {
      $cityId = this.getId($city);
      return this.getPredictions($cityId)
    }
}
