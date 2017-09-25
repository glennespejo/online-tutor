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

        $bus = new Bus;
        $bus->seat_capacity = 'vacant';
        $bus->plate_number = "KFC 099";
        $bus->bus_number = 44;
        $bus->coordinates = "15.0594, 120.6567";
        $bus->route_id = 1;
        $bus->save();

        $bus = new Bus;
        $bus->seat_capacity = 'vacant';;
        $bus->bus_number = 45;
        $bus->plate_number = "UFC 017";
        $bus->coordinates = "15.0390, 120.6809";
        $bus->route_id = 2;
        $bus->save();

        $bus = new Bus;
        $bus->seat_capacity = 'vacant';;
        $bus->bus_number = 46;
        $bus->plate_number = "UPD 998";
        $bus->coordinates = "10.0390, 121.6809";
        $bus->route_id = 1;
        $bus->save();

        $route = new Route;
        $route->starting_position = "San Fernando, Pampanga";
        $route->starting_coordinates = "15.0390, 120.6809";
        $route->ending_position = "Angeles, Pampanga";
        $route->ending_coordinates = "15.1674, 120.5745";
        $route->color = "#f442f4";
        $route->save();

        $route = new Route;
        $route->starting_position = "San Fernando, Pampanga";
        $route->starting_coordinates = "15.0594, 120.6567";
        $route->ending_position = "Baguio City";
        $route->ending_coordinates = "16.4023, 120.5960";
        $route->color = "#1fef5d";
        $route->save();

        $route = new RouteStop;
        $route->route_id = 2;
        $route->order = 0;
        $route->route_stop_name = "Shell Gas Station";
        $route->coordinates = "15.1574, 120.5745";
        $route->save();

        $route = new RouteStop;
        $route->route_id = 2;
        $route->order = 1;
        $route->route_stop_name = "Caltex Gas Station";
        $route->coordinates = "15.1584, 120.6745";
        $route->save();

        $route = new RouteStop;
        $route->route_id = 2;
        $route->order = 2;
        $route->route_stop_name = "PTT Gas Station";
        $route->coordinates = "15.1544, 120.6745";
        $route->save();

        $route = new UserMac;
        $route->mac_address = "70:4d:7b:07:e4:61";
        $route->lat = "15.1544";
        $route->lng = "120.6445";
        $route->save();

    }
}
