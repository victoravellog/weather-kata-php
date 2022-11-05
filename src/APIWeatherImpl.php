<?php

namespace WeatherKata;

use WeatherKata\Http\Client;
use WeatherKata\Prediction;
use WeatherKata\WeatherRepository;

class APIWeatherImpl implements WeatherRepository{
    public function __construct(private Client $client) {

    }

    public function getId(string &$city) : string {
      $city = $this->client->get("https://www.metaweather.com/api/location/search/?query=$city");
      return $city;
    }
    
    public function getPrediction(string $id, string $date) : Prediction{
      var_dump($date);
      $rawPredictions = $this->client->get("https://www.metaweather.com/api/location/$id");

      $rawPredictions = array_filter($rawPredictions, function($prediction) use ($date){
        return $prediction['applicable_date'] == $date;
      });

      if (count($rawPredictions) > 0){
        return $this->parsePrediction($rawPredictions[0]);
      }
      return "";
    }

    private function parsePrediction($prediction){
      return new Prediction(
        $prediction['applicable_date'],
        $prediction['wind_speed'],
        $prediction['weather_state_name'],
      );
    }
}
