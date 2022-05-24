<?php

namespace App\Services\Geocoding;

use App\Contracts\GeocodingService;

class OpenStreetMap implements GeocodingService
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function findByStreetName(string $streetName)
    {
        return 'Indirizzo recuperato da OpenStreetMap con apiKey: ' . $this->apiKey;
    }
}
