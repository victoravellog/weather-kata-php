<?php

namespace WeatherKata\Prediction;

interface PredictionParser{
    public function parseArray($rawPrediction): array
    public function parse($rawPrediction): Prediction
}
