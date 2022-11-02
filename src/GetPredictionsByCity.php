<?php

namespace WeatherKata;

use WeatherKata\Http\Client;
use WeatherRepository;

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

        // If there are predictions
        if ($datetime >= new \DateTime("+6 days 00:00:00")) {
            return ""
        }
        
        // Find the id of the city on metawheather
        //$woeid = $client->get("https://www.metaweather.com/api/location/search/?query=$city");
        //$city = $woeid;
        $city = $weatherRepository->getId($city);

        // Find the predictions for the city
        //$results = $client->get("https://www.metaweather.com/api/location/$woeid");
        $results = $weatherRepository->getPredictions($city);

        foreach ($results as $result) {
            // When the date is the expected

            if ($result["applicable_date"] == $datetime->format('Y-m-d') {
                if($wind){
                    return $result['wind_speed'];
                }
                return $result['weather_state_name'];
            }
        }

        return "";
    }
}