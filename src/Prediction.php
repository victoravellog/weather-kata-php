<?php

namespace WeatherKata\Prediction;

class Prediction {
    public function __construct(public string $applicableDate, public float $windSpeed, public string $weatherStateName){

    

 }