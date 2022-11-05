<?php

namespace WeatherKata;

use WeatherKata\WeatherRepository;

class GetPredictionsByCity
{
  public function __construct(private WeatherRepository $weatherRepository){

  }

  public function predict(string &$city, \DateTime $datetime = null, bool $wind = false): string
  {
    // When date is not provided we look for the current prediction
    if (!$datetime) {
      $datetime = new \DateTime();
    }

    if ($datetime >= new \DateTime("+6 days 00:00:00")) {
      return "";
    }

    // Find the exact prediction for the city
    $city = $this->weatherRepository->getId($city);
    //var_dump(">>>> ID: ".$city);
    $prediction = $this->weatherRepository->getPrediction($city, $datetime->format('Y-m-d'));
    //var_dump(">>>> PREDICTION: ".$prediction);

    if (empty($prediction)){
      return "";
    }

    return $this->getPredictionByWind($prediction, $wind);
  }

  private function getPredictionByWind($prediction, $wind){
    if ($wind) {
      return $prediction->windSpeed;
    } else {
      return $prediction->weatherStateName;
    }
  }

}