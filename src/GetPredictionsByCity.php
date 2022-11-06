<?php

namespace WeatherKata;

class GetPredictionsByCity
{
    const MAXIMUM_DAYS_AFTER_DATETIME_FORMATTED = "+6 days 00:00:00";

    public function __construct(private WeatherRepository $weatherRepository)
    {
    }

    public function predict(string &$city, \DateTime $datetime = null, bool $wind = false): string
    {
        if ($datetime && $datetime >= new \DateTime(self::MAXIMUM_DAYS_AFTER_DATETIME_FORMATTED)) {
            return "";
        }

        // When date is not provided we look for the current prediction
        if (!$datetime) {
            $datetime = new \DateTime();
        }

        // Find the exact prediction for the city
        $city = $this->weatherRepository->getId($city);
        //var_dump(">>>> ID: ".$city);
        $prediction = $this->weatherRepository->getPrediction($city, $datetime->format('Y-m-d'));
        //var_dump(">>>> PREDICTION: ".$prediction);

        if (empty($prediction)) {
            return "";
        }

        return empty($prediction) ? "" : $this->getPredictionByWind($prediction, $wind);
    }

    private function getPredictionByWind($prediction, $wind): string
    {
        if ($wind) {
            return $prediction->windSpeed;
        } else {
            return $prediction->weatherStateName;
        }
    }

}