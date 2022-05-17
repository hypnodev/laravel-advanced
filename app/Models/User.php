<?php

namespace App\Models;

use App\Events\UserCreated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // updated, deleted, saved, created
    // protected $dispatchesEvents = [
    //    'created' => UserCreated::class
    // ];

//    protected static function booted()
//    {
//        static::created(function (User $user) {
//            $user->auditLogs()->create([
//                'log' => 'utente creato'
//            ]);
//        });
//    }
}
