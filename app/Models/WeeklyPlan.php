<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlan extends Model
{
    protected $fillable = [
        'session_id',
        'trainer_id',
        'file_path',
        'status',
        'decline_reason',
        'parsed_data',
        'reviewed_by_type',
        'reviewed_by_id',
        'reviewed_at',
    ];

    protected $casts = [
        'parsed_data' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function reviewedBy()
    {
        return $this->morphTo('reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
