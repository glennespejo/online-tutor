<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'section_code',
        'section_name'
    ];

    public function routeConfig()
    {
        return json_encode([
            'update' => route('section.update', '@id'),
            'store' => route('section.store'),
            'destroy' => route('section.destroy', '@id'),
            'index' => route('section.index'),
            'show' => route('section.show', '@id'),
            'teacher_section' => route('teacher.section', '@id'),
        ]);
    }

    public function teacher_id()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
