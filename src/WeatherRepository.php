<?php

interface WeatherRepository{
    public function getId(string $city) : string;
    public function getPredictions(string $id): array;
}