<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'section_id'    
    ];

    public function section()
    {
        return $this->belongsTo('App\Section', 'section_id');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }

}
