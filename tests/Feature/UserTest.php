<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_search_user_by_his_email()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email
        ];

        $this->postJson('/api/en/search_users', $data)
            ->assertSuccessful()
            ->assertJsonPath('email', $data['email']);
    }

    public function test_throws_exception_if_user_doesnt_exists()
    {
        $data = [
            'email' => $this->faker->email
        ];

        $this->postJson('/api/en/search_users', $data)
            ->assertNotFound();
    }

    public function test_can_search_any_user()
    {
        $expectedEmail = 'laravel-advanced@gmail.com';

        $this->partialMock(UserRepository::class, function (MockInterface $mock) use ($expectedEmail) {
            $mock->shouldReceive('find')
                ->andReturn(new User([
                    'name' => $this->faker->name,
                    'email' => $expectedEmail,
                    'password' => Hash::make('password')
                ]));
        });

        $data = [
            'email' => $this->faker->email
        ];

        $this->postJson('/api/en/search_users', $data)
            ->assertSuccessful()
            ->assertJsonPath('email', $expectedEmail);
    }
}
