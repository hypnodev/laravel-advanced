<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\Newsletter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class ConsoleCommandTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_mass_mail_users_without_100_users()
    {
        $this->artisan('mail:mass-user')
            ->expectsOutput('Numero minimo di utenti: 100')
            ->assertExitCode(1);
    }

    public function test_mass_mail_100_users()
    {
        Notification::fake();
        User::factory()->count(100)->create();

        $this->artisan('mail:mass-user')
            ->expectsOutput('Newsletter inviata')
            ->assertExitCode(0);

        Notification::assertTimesSent(100, Newsletter::class);
    }

    public function test_send_mail_to_specific_user_using_mass_email()
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->artisan("mail:mass-user $user->email")
            ->expectsOutput('Newsletter inviata a ' . $user->email)
            ->assertExitCode(0);

        Notification::assertSentTo($user, Newsletter::class);
    }

    public function test_send_mail_to_non_existent_specific_user_using_mass_email()
    {
        $email = $this->faker->email;

        $this->artisan("mail:mass-user $email")
            ->expectsOutput('Utente non trovato!')
            ->assertExitCode(1);
    }

    public function test_send_email_to_specific_user()
    {
        Notification::fake();

        $user = User::factory()->create();
        $domain = Str::after($user->email, '@');

        $this->artisan('mail:user')
            ->expectsQuestion('Inserisci il dominio dell\'email', $domain)
            ->expectsQuestion('Seleziona l\'email a cui inviare la notifica', $user->email)
            ->expectsConfirmation('Sei sicuro di voler inviare la notifica a questo utente?', 'yes')
            ->expectsOutput('Newsletter inviata a ' . $user->email)
            ->assertExitCode(0);

        Notification::assertSentTo($user, Newsletter::class);
    }

}
