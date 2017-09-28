<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'raw_password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function routeConfig()
    {
        return json_encode([
            'update' => route('users.update', '@id'),
            'store' => route('users.store'),
            'destroy' => route('users.destroy', '@id'),
            'index' => route('users.index'),
            'show' => route('users.show', '@id'),
            'hide_edit' => true,
        ]);
    }
}
