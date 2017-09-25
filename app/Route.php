<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'starting_position',
        'starting_coordinates',
        'ending_position',
        'ending_coordinates',
        'color',
    ];

    public function routeConfig()
    {
        return json_encode([
            'update' => route('route.update', '@id'),
            'store' => route('route.store'),
            'destroy' => route('route.destroy', '@id'),
            'index' => route('route.index'),
            'show'  => route('route.show', '@id')
        ]);
    }

    public function route_stops()
    {
        return $this->hasMany('App\RouteStop', 'route_id');    
    }
    
}
