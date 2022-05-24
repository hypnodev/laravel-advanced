<?php

namespace App\Http\Controllers;

use App\Contracts\GeocodingService;
use App\Services\Geocoding\GoogleMaps;
use Illuminate\Http\Request;

class GeocodingController extends Controller
{
    private GeocodingService $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    public function searchAddress(Request $request)
    {
        return response()->json([
            'address' => $this->geocodingService->findByStreetName($request->street)
        ]);
    }

    public function searchAddressUsingGoogleMaps(Request $request, GoogleMaps $googleMaps)
    {
        return response()->json([
            'address' => $googleMaps->findByStreetName($request->street)
        ]);
    }
}
