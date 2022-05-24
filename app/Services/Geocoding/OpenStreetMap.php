<?php

namespace App\Services\Geocoding;

use App\Contracts\GeocodingService;
use Illuminate\Support\Facades\Cache;

class OpenStreetMap implements GeocodingService
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;

        $token = Cache::get('openstreetmap-token');
        if (is_null($token)) {
            // TODO: Richiamare endpoint per generare token
            // Cache::tags(['openstreetmap'])->add('openstreetmap-token', 'ciao-prova', now()->addHour());
            Cache::add('openstreetmap-token', 'ciao-prova', now()->addHour());
        }

        // TODO: utilizzare il token
    }

    public function findByStreetName(string $streetName)
    {
        return 'Indirizzo recuperato da OpenStreetMap con apiKey: ' . $this->apiKey;
    }
}
