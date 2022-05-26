<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public User $user,
        public bool $condition,
    )
    {
        $this->queue = 'users';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger("Utente {$this->user->email} ha effettuato l'accesso.");
        // ESTRAPOLAZIONE AUDIO
        // ...
        // ...
    }
}
