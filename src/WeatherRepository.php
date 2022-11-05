<?php

namespace WeatherKata;

interface WeatherRepository{
    public function getId(string &$city) : string;
    public function getPrediction(string $id, string $date): Prediction;
}