<?php

use App\Bus;
use App\Route;
use App\RouteStop;
use App\User;
use App\UserMac;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Admin admin";
        $user->email = "admin@admin.com";
        $user->password = \Hash::make('admin');
        $user->role = 'admin';
        $user->save();
    }
}
