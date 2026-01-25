<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Qa extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guard = 'qa';
    protected $fillable = ['name', 'email', 'password', 'gender', 'birthdate', 'avatar', 'phone'];

    public function sentMessages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'receiver');
    }
}
