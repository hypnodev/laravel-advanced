<?php

namespace App\Services\Geocoding;

use App\Contracts\GeocodingService;

class GoogleMaps implements GeocodingService
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function findByStreetName(string $streetName)
    {
        return 'Indirizzo recuperato da GoogleMaps con apiKey: ' . $this->apiKey;
    }
}
