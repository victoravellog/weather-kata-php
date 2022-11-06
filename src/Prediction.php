<?php

namespace WeatherKata;

//Prediction DTO
class Prediction
{
    public function __construct(public string $applicableDate, public float $windSpeed, public string $weatherStateName)
    {
    }
}