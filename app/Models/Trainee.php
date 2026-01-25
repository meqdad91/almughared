<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainee extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guard = 'trainee';

    protected $fillable = ['name', 'email', 'password', 'gender', 'birthdate', 'avatar', 'phone'];

    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_trainee');
    }

    public function sentMessages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'receiver');
    }
}
