<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ProgressBarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:progress-bar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        $users->each(function (User $user) use ($bar) {
            // $this->info("> Id: $user->id | $user->email");
            sleep(0.5);
            $bar->advance();
        });

        $bar->finish();

        return 0;
    }
}
