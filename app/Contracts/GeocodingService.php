<?php

namespace App\Contracts;

interface GeocodingService
{
    public function findByStreetName(string $streetName);
}
