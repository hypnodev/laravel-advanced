<?php

use App\Models\User;
use App\Notifications\Newsletter;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment('Ciao Laravel Advanced');
})->purpose('Display an inspiring quote');

Artisan::command('mass-user', function ($email) {
    $users = User::all();
//    if ($users->count() < 100) {
//        $this->error('Numero minimo di utenti: 100');
//        return 1;
//    }

    $users->each(function (User $user) {
        $user->notify(new Newsletter());
    });
    $this->info('Newsletter inviata');

    return 0;
})->purpose('Inviare email a tutti gli utenti');
