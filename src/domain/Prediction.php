<?php

namespace WeatherKata\domain;

//Prediction DTO
class Prediction {
    public function __construct(public string $applicableDate, public float $windSpeed, public string $weatherStateName){
    
    }
 }