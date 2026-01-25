<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'subject_id',  // <--- Add this line
        'rate',
        'review',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }
}
