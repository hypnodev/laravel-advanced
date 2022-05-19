<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\Newsletter;
use Illuminate\Console\Command;

class MassEmailUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:mass-user {--mail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inviare email a tutti gli utenti';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->argument('mail') !== null) {
            $user = User::where('email', $this->argument('mail'))->first();
            if (!$user) {
                $this->error('Utente non trovato!');
                return 1;
            }

            $user->notify(new Newsletter());
            $this->info('Newsletter inviata a ' . $this->argument('mail'));
            return 0;
        }

        $users = User::all();
        if ($users->count() < 100) {
            $this->error('Numero minimo di utenti: 100');
            return 1;
        }

        $users->each(function (User $user) {
            $user->notify(new Newsletter());
        });
        $this->info('Newsletter inviata');

        return 0;
    }
}
