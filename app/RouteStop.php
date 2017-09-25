<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteStop extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'route_id',
        'order',
        'route_stop_name',
        'coordinates',
    ];
}
