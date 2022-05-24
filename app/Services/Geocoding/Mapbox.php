<?php

namespace App\Services\Geocoding;

use App\Contracts\GeocodingService;

class Mapbox implements GeocodingService
{

    public function findByStreetName(string $streetName)
    {
        return 'Indirizzo recuperato da MapBox.';
    }
}
