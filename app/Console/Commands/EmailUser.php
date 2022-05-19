<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\Newsletter;
use Illuminate\Console\Command;

class EmailUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inviare email ad un utente specifico';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $domain = $this->ask('Inserisci il dominio dell\'email');
        $emails = User::where('email', 'like', "%$domain%")->pluck('email')->toArray();

        $mail = $this->choice('Seleziona l\'email a cui inviare la notifica', $emails);
        $user = User::where('email', $mail)->first();
        if (!$user) {
            $this->error('Utente non trovato!');
            return 1;
        }

        $confirmation = $this->confirm('Sei sicuro di voler inviare la notifica a questo utente?', true);
        if ($confirmation) {
            $user->notify(new Newsletter());
            $this->info('Newsletter inviata a ' . $mail);
            return 0;
        }

        return 0;
    }
}
