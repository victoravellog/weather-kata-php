<?php

namespace WeatherKata\infrastructure;

use WeatherKata\infrastructure\Http\MockClient;
use WeatherKata\domain\Prediction;
use WeatherKata\domain\PredictionRepository;

class APIPredictionImpl implements PredictionRepository{
    
    public function __construct(private MockClient $client) {

    }

    private function getId(string &$city) : string {
      $city = $this->client->get("https://www.metaweather.com/api/location/search/?query=$city");
      return $city;
    }
    
    private function getPrediction(string $id, string $date) : ?Prediction{
      //var_dump($date);
      $rawPredictions = $this->client->get("https://www.metaweather.com/api/location/$id");

      $rawPredictions = array_filter($rawPredictions, function($prediction) use ($date){
        return $prediction['applicable_date'] == $date;
      });
      //var_dump(count($rawPredictions));
      //var_dump($rawPredictions);
      if (count($rawPredictions) > 0){
        return $this->parsePrediction(current($rawPredictions));
      }
      return null;
    }

    public function getWind(string &$city, string $date) : ?float{
      $id = $this->getId($city);
      $prediction = $this->getPrediction($id, $date);
      if (!$prediction) {
        return null;
      }
      return $prediction->windSpeed;
    }

    public function getWeather(string &$city, string $date) : ?string{
      $id = $this->getId($city);
      $prediction = $this->getPrediction($id, $date);
      if (!$prediction) {
        return null;
      }
      return $prediction->weatherStateName;
    }

    private function parsePrediction($prediction) : Prediction{
      return new Prediction(
        $prediction['applicable_date'],
        $prediction['wind_speed'],
        $prediction['weather_state_name'],
      );
    }
}
