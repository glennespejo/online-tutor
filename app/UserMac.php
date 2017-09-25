<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMac extends Model
{
    
    protected $fillable = [
        'mac_address', 'lat', 'lng', 'agreement',
    ];
}
