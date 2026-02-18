<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Session extends Model
{
    protected $fillable = ['title', 'time_from', 'time_to', 'days', 'link', 'capacity', 'trainer_id'];
    protected $casts = [
        'days' => 'array',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'session_trainee');
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function weeklyPlans()
    {
        return $this->hasMany(WeeklyPlan::class);
    }
}

