<?php

namespace App\Providers;

use App\Contracts\GeocodingService;
use App\Repositories\Interfaces\UserRepository;
use App\Services\Geocoding\GoogleMaps;
use App\Services\Geocoding\Mapbox;
use App\Services\Geocoding\OpenStreetMap;
use Illuminate\Support\ServiceProvider;

class ContainerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            UserRepository::class,
            \App\Repositories\UserRepository::class
        );

//        $this->app->bind(
//            GeocodingService::class,
//            OpenStreetMap::class
//        );

        $this->app->bind(
            GeocodingService::class,
            function () {
                $service = config('services.geocoding.service');

                switch ($service) {
                    case 'openstreetmap':
                        return new OpenStreetMap(config('services.geocoding.openstreetmap.apikey'));
                    case 'google-maps':
                        return new GoogleMaps(config('services.geocoding.openstreetmap.apikey'));
                    case 'mapbox':
                        return new Mapbox();
                    default:
                        throw new \Exception('Service ' . $service . ' notfound.');
                }
            }
        );

//        $this->app->singleton(
//            GoogleMaps::class,
//            function () {
//                return new GoogleMaps(config('services.geocoding.googlemaps.apikey'));
//            }
//        );

        $this->app->instance(GoogleMaps::class, new GoogleMaps(config('services.geocoding.googlemaps.apikey')));
    }
}
