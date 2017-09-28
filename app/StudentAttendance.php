<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $fillable = [
        'section_code',
        'student_id',
        'date',
    ];

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }
}
