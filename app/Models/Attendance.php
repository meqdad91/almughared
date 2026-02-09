<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'trainee_id', 'status'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}
