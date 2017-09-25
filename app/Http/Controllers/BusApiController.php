<?php

namespace App\Http\Controllers;

use App\Bus;
use App\UserMac;
use Illuminate\Http\Request;

class BusApiController extends Controller
{

    public function __construct()
    {
        $this->driver = env('DB_CONNECTION');
        $this->icons = [
            'bus' => 'http://maps.google.com/mapfiles/ms/icons/bus.png',
            'user' => 'http://maps.google.com/mapfiles/ms/micons/man.png',
        ];
    }

    public function getBuses(Request $request)
    {
        if ($this->driver == "pgsql") {
            $like = "ilike";
        } else {
            $like = "like";
        }
        if (!isset($request->user_mac)) {
            return response()->json([
                'error' => 'user_is_required.',
                'message' => 'Incomplete data passed.',
            ], 401);
        }

        $user = UserMac::where('mac_address', $request->user_mac)->first();

        if (empty($user)) {
            return response()->json([
                'error' => 'user_not_found.',
                'message' => 'User not found.',
            ], 401);
        }

        if (isset($request->lat) && isset($request->lng)) {
            $user = UserMac::find($user->id);
            $user->lat = $request->lat;
            $user->lng = $request->lng;
            $user->update();
        }

        $buses = Bus::get();
        $data = [];

        foreach ($buses as $bus) {
            $data[] = $this->transform($bus, $user);
        }
        $data[] = [
            'free_text' => "You're here.",
            'icon' => [
                'url' => $this->icons['user'],
            ],
            'position' => [
                'lat' => $user->lat,
                'lng' => $user->lng,
            ],
        ];
        return response()->json($data);
    }

    public function busCurrent(Request $request)
    {
        if (!isset($request->plate_number)) {
            return response()->json([
                'error' => 'provide_bus_number.',
                'message' => 'Must provide bus number.',
            ], 401);
        }
        $bus = Bus::where('plate_number', $request->plate_number)->first();
        if (empty($bus)) {
            return response()->json([
                'error' => 'bus_doesnt_exist.',
                'message' => 'Bus plate number does not exist in our database.',
            ], 401);
        }

        if (!isset($request->lat) || !isset($request->lng)) {
            return response()->json([
                'error' => 'provide_lat_lng.',
                'message' => 'Must provide latitude or longitude.',
            ], 401);
        }
        $lat = $request->lat;
        $lng = $request->lng;
        $data = [
            'coordinates' => $lat . ", " . $lng,
        ];
        $bus = Bus::find($bus->id);
        $bus->fill($data)->save();
        return $bus;
    }

    public function transform($data, $user)
    {
        $color = "";
        $cur_lat = "";
        $cur_lng = "";
        $r_star = "";
        $r_star_lat = "";
        $r_star_lng = "";
        $r_end = "";
        $r_end_lat = "";
        $r_end_lng = "";
        $rts = [];
        if ($data->routes()->first()) {
            $color = $data->routes()->first()->color;
            $route = $data->routes()->first();
            $coor = explode(", ", $route->starting_coordinates);
            $r_star_lat = $coor[0];
            $r_star_lng = $coor[1];
            $coor = explode(", ", $route->ending_coordinates);
            $r_end_lat = $coor[0];
            $r_end_lng = $coor[1];
            $r_star = $route->starting_position;
            $r_end = $route->ending_position;
            $route_stops = $route->route_stops()->orderBy('order')->get();
            if ($route_stops) {
                foreach ($route_stops as $rt) {

                    $coor = explode(", ", $rt->coordinates);
                    $rts_lat = $coor[0];
                    $rts_lng = $coor[1];

                    $rts[] = [
                        'stop_name' => $rt->route_stop_name,
                    ];
                }
            }
        }
        if ($data->coordinates) {
            $coor = explode(", ", $data->coordinates);
            $cur_lat = (float) $coor[0];
            $cur_lng = (float) $coor[1];
            $cur_lat = round($cur_lat, 6);
            $cur_lng = round($cur_lng, 6);
        }
        if ($data->seat_capacity == 0) {
            $seat_capacity = "Vacant";
        } else {
            $seat_capacity = "Full";
        }
        $distance = $this->getDistance($cur_lat, $cur_lng, $user->lat, $user->lng);
        $data = [
            'free_text' => "Bus No.:" . $data->bus_number,
            'bus_number' => $data->bus_number,
            'seat' => $seat_capacity,
            'plate_number' => $data->plate_number,
            'distance' => round($distance, 2) . " km",
            'position' => array(
                'lat' => (float) $cur_lat,
                'lng' => (float) $cur_lng,
            ),

        ];

        $data['route']['start'] = [
            'position' => $r_star,
        ];
        $data['route']['end'] = [
            'position' => $r_end,
        ];
        $data['icon'] = [
            'url' => $this->icons['bus'],
        ];
        $data['route_stops'] = $rts;
        return $data;
    }

    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $radius = 6371; //For Earth, the mean radius is 6,371.009 km

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * asin(sqrt($a));

        $d = $radius * $c;

        return $d;
    }

    public function takeBus(Request $request)
    {
        if (!isset($request->plate_number)) {
            return response()->json([
                'error' => 'plate_number.',
                'message' => 'Must provide plate number.',
            ], 401);
        }
        $bus = Bus::where('plate_number', $request->plate_number)->first();
        if (empty($bus)) {
            return response()->json([
                'error' => 'plate_number.',
                'message' => 'No record found.',
            ], 404);
        }

        $data = [];
        $seat_capacity = "";

        if ($bus->seat_capacity == 0) {
            $seat_capacity = "Vacant";
        } elseif ($bus->seat_capacity == 1) {
            $seat_capacity = "Full";
        } else {
            $seat_capacity = "Standing";
        }

        $color = "";
        $cur_lat = "";
        $cur_lng = "";
        $r_star = "";
        $r_star_lat = "";
        $r_star_lng = "";
        $r_end = "";
        $r_end_lat = "";
        $r_end_lng = "";
        $stops = [];

        if ($bus->routes()->first()) {

            $color = $bus->routes()->first()->color;
            $route = $bus->routes()->first();

            $coor = explode(", ", $route->starting_coordinates);

            $r_star_lat = $coor[0];
            $r_star_lng = $coor[1];

            $coor = explode(", ", $route->ending_coordinates);
            $r_end_lat = $coor[0];
            $r_end_lng = $coor[1];

            $r_star = $route->starting_position;
            $r_end = $route->ending_position;

            $route_stops = $route->route_stops()->orderBy('order')->get();

            $marks = array();

            if ($route_stops) {
                foreach ($route_stops as $rt) {

                    $coor = explode(", ", $rt->coordinates);
                    $rts_lat = $coor[0];
                    $rts_lng = $coor[1];

                    $stops[] = $rt->route_stop_name;

                    $marks[] = [
                        'type' => 'stop',
                        'free_text' => $rt->route_stop_name,
                        'position' => [
                            'lat' => (float) $rts_lat,
                            'lng' => (float) $rts_lng,
                        ],
                        'icons' => [
                            'url' => 'https://maps.gstatic.com/intl/en_ALL/mapfiles/markers2/measle.png',
                        ],
                    ];
                }
            }
        }
        $data = array();
        if ($bus->coordinates) {
            $coor = explode(", ", $bus->coordinates);
            $cur_lat = $coor[0];
            $cur_lng = $coor[1];
        }
        $distance = $this->getDistance($cur_lat, $cur_lng, $r_end_lat, $r_end_lng);
        $seat_capacity = "";

        if ($bus->seat_capacity == 0) {
            $seat_capacity = "Vacant";
        } elseif ($bus->seat_capacity == 1) {
            $seat_capacity = "Full";
        } else {
            $seat_capacity = "Standing";
        }

        $marks[] = [
            'type' => 'bus',
            'free_text' => "Bus No." . $bus->bus_number . " - " . $bus->plate_number,
            'position' => [
                'lat' => (float) $cur_lat,
                'lng' => (float) $cur_lng,
            ],
            'icons' => [
                'url' => url('/img/bus.png'),
            ],
        ];
        $marks[] = [
            'type' => 'start',
            'free_text' => $route->starting_position,
            'position' => [
                'lat' => (float) $r_star_lat,
                'lng' => (float) $r_star_lng,
            ],
            'icons' => [
                'url' => url('/img/start.png'),
            ],
        ];
        $marks[] = [
            'type' => 'end',
            'free_text' => $route->ending_position,
            'position' => [
                'lat' => (float) $r_end_lat,
                'lng' => (float) $r_end_lng,
            ],
            'icons' => [
                'url' => url('/img/end.png'),
            ],
        ];

        $data = [
            'marks' => $marks,
            'color_path' => $color,
            'bus' => [
                'bus_number' => $bus->bus_number,
                'plate_number' => $bus->plate_number,
                'seat' => $seat_capacity,
                'distance' => round($distance, 2) . " km",
                'route' => [
                    'stops' => $stops,
                    'start' => $route->starting_position,
                    'end' => $route->ending_position,
                ],
            ],
        ];
        return response()->json($data);
    }
}
