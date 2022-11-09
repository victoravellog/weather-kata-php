<?php

namespace WeatherKata\application;

use WeatherKata\domain\PredictionRepository;

class GetWindByCity
{
  public function __construct(private PredictionRepository $predictionRepository){

  }

  public function invoke(string &$city, \DateTime $datetime = null): ?float
  {
    // When date is not provided we look for the current prediction
    if (!$datetime) {
      $datetime = new \DateTime();
    }

    if ($datetime >= new \DateTime("+6 days 00:00:00")) {
      return null;
    }

    // Find the exact wind for the city
    $wind = $this->predictionRepository->getWind($city, $datetime->format('Y-m-d'));

    return $wind;
  }

}