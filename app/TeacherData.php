<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherData extends Model
{

    protected $fillable = [
        'section_id', 'key', 'value', 'parent_key',
    ];
}
