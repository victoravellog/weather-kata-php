<?php

namespace WeatherKata\domain;

interface PredictionRepository{
    public function getWind(string &$city, string $date): ?float;
    public function getWeather(string &$city, string $date): ?string;
}