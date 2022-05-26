<?php

namespace Tests\Feature;

use App\Jobs\JobTest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_anyone_can_register()
    {
        $this->artisan('passport:install --force');

        $data = [
            'name' => 'Cristian',
            'email' => 'me+test@cristiancosenza.com',
            'password' => '12345678'
        ];

        $this->postJson('/api/en/register', $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'token', 'user'
            ]);
    }

    public function test_cannot_register_with_name_and_surname()
    {
        $this->artisan('passport:install --force');

        $data = [
            'name' => 'Cristian Cosenza',
            'email' => 'me+test@cristiancosenza.com',
            'password' => '12345678'
        ];

        $response = $this->postJson('/api/en/register', $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors'
            ]);
            //->assertJsonPath('message', 'The name must only contain letters.');

        $errors = $response->json('errors');
        $this->assertNotNull($errors['name'] ?? null);
    }

    public function test_cannot_register_with_existent_email()
    {
        $this->artisan('passport:install --force');

        $user = User::factory()->create();

        $data = [
            'name' => 'Cristian',
            'email' => $user->email,
            'password' => '12345678'
        ];

        $response = $this->postJson('/api/en/register', $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors'
            ]);

        $errors = $response->json('errors');
        $this->assertNotNull($errors['email'] ?? null);
    }

    public function test_cannot_register_with_4_chars_psw()
    {
        $this->artisan('passport:install --force');

        $data = [
            'name' => 'Cristian Cosenza',
            'email' => 'me+test@cristiancosenza.com',
            'password' => $this->faker->password(1, 4)
        ];

        $response = $this->postJson('/api/en/register', $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors'
            ]);

        $errors = $response->json('errors');
        $this->assertNotNull($errors['password'] ?? null);
    }

    public function test_user_can_login()
    {
        $this->artisan('passport:install --force');

        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->postJson('/api/en/login', $data)
            ->assertJsonStructure([
                'token', 'user'
            ])
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.email', $user->email);
    }

    public function test_user_cannot_login_with_username()
    {
        $this->artisan('passport:install --force');

        User::factory()->create();

        $data = [
            'email' => $this->faker->word,
            'password' => 'password'
        ];

        $response = $this->postJson('/api/en/login', $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message', 'errors'
            ]);

        $errors = $response->json('errors');
        $this->assertNotNull($errors['email'] ?? null);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $this->artisan('passport:install --force');

        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => $this->faker->password(8)
        ];

        $this->postJson('/api/en/login', $data)
            ->assertUnauthorized();
    }

    public function test_user_can_login_and_job_ran()
    {
        Bus::fake();

        $this->artisan('passport:install --force');

        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->postJson('/api/en/login', $data)
            ->assertJsonStructure([
                'token', 'user'
            ])
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.email', $user->email);

        Bus::assertDispatched(function (JobTest $job) use ($user) {
            return $job->user->id === $user->id;
        });
    }

    public function test_user_can_call_me_with_token()
    {
        $this->artisan('passport:install --force');

        $user = User::factory()->create();
        $token = $user->createToken('laravel-advanced')->accessToken;

        $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/en/me')
            ->assertSuccessful();
    }

    public function test_user_can_call_me_without_token()
    {
        $this->getJson('/api/en/me')
            ->assertUnauthorized();
    }

    public function test_user_can_call_me_acting_as_user()
    {
        $this->artisan('passport:install --force');

        $user = User::factory()->create();
        Passport::actingAs($user);

        $this->getJson('/api/en/me')
            ->assertSuccessful();
    }
}
