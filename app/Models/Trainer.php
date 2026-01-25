<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Trainer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guard = 'trainer';
    protected $fillable = ['name', 'email', 'password', 'gender', 'birthdate', 'avatar', 'phone'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
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
