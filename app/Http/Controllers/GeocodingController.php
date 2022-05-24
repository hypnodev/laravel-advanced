<?php

namespace App\Http\Controllers;

use App\Contracts\GeocodingService;
use App\Services\Geocoding\GoogleMaps;
use Illuminate\Http\Request;

class GeocodingController extends Controller
{
    public function __construct(
        private GeocodingService $geocodingService
    ) {
        //
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
