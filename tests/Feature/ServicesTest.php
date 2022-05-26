<?php

namespace Tests\Feature;

use App\Services\Geocoding\OpenStreetMap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    use WithFaker;

    public function test_use_openstreetmap_service_with_different_token()
    {
        Cache::spy()->shouldAllowMockingProtectedMethods()
            ->shouldReceive('get')
            ->andReturn('token-da-test');

        $openStreetMap = new OpenStreetMap($this->faker->word);

        $this->assertEquals(
            'token-da-test',
            Cache::get('openstreetmap-token')
        );
    }

    public function test_openstreetmap_token_mocked()
    {
        Cache::spy()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('get')
            ->with('openstreetmap-token')
            ->andReturn('token-da-test');

        $openStreetMap = new OpenStreetMap($this->faker->word);

        $this->assertEquals(
            'token-da-test',
            Cache::get('openstreetmap-token')
        );

        $this->assertNull(
            Cache::get('key-not-mocked')
        );
    }
}
