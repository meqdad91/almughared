<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'title', 'description', 'date', 'status', 'rejection_reason'];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function subject_reviews()
    {
        return $this->hasMany(SubjectReview::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
