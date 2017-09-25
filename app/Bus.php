<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seat_capacity',
        'bus_number',
        'coordinates',
        'route_id',
        'plate_number',
    ];

    public function routeConfig()
    {
        return json_encode([
            'update' => route('bus.update', '@id'),
            'store' => route('bus.store'),
            'destroy' => route('bus.destroy', '@id'),
            'index' => route('bus.index'),
            'show' => route('bus.show', '@id'),
        ]);
    }

    public function routes()
    {
        return $this->belongsTo('App\Route', 'route_id');
    }

}
