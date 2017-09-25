<?php

namespace App\Http\Controllers;

use App\Route;
use App\RouteStop;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = new Route();
        return view('route.index', compact('route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $exist = $this->checkRouteIfExist($request);

            if ($exist->count() > 0) {
                return response(json_encode(['exist' => ['Route is already exist!']]), 422)
                  ->header('Content-Type', 'application/json');    
            }

            \DB::beginTransaction();

            $route_data             = $request->all();
            $route                  = Route::create($route_data);
            if (isset($route_data['route_stop_name'])) {

                $order = 1;
                foreach ($route_data['route_stop_name'] as $key => $route_stop) {
                    RouteStop::create([
                        'route_id'          => $route->id,
                        'order'             => $order,
                        'route_stop_name'   => $route_stop,
                        'coordinates'       => $route_data['coordinates'][$key]
                    ]);

                    $order++;
                }
            }
            \DB::commit();
            $msg = 'Add Route Success!';

        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        if ($route->route_stops->count() > 0) {
            $route_stops = [];
            foreach ($route->route_stops as $key => $value) {
                $route_stops[]['order']             = $value->order;
                $route_stops[]['route_stop_name']   = $value->route_stop_name;
                $route_stops[]['coordinates']       = $value->coordinates;
            }
            $route->route_stops = $route_stops;
        } 
        return $route;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        try {

            $exist = $this->checkRouteIfExist($request);

            if ($exist->count() > 0) {
                return response(json_encode(['exist' => ['Route is already exist!']]), 422)
                  ->header('Content-Type', 'application/json');    
            }

            \DB::beginTransaction();
            $route_data = $request->all();
            $route->update($route_data);
            RouteStop::where('route_id',$route->id)->delete();
            if (isset($route_data['route_stop_name'])) {

                $order = 1;
                foreach ($route_data['route_stop_name'] as $key => $route_stop) {
                    RouteStop::create([
                        'route_id'          => $route->id,
                        'order'             => $order,
                        'route_stop_name'   => $route_stop,
                        'coordinates'       => $route_data['coordinates'][$key]
                    ]);

                    $order++;
                }
            }
            \DB::commit();
            $msg = 'Update Bus Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }
        return compact('msg', 'error_message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        try {

            \DB::beginTransaction();
            RouteStop::where('route_id',$route->id)->delete();
            $route->delete();
            \DB::commit();
            $msg = 'Delete Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }

    private function checkRouteIfExist($request)
    {
        return Route::where('starting_position', $request->starting_position)->where('ending_position', $request->ending_position)->get();
    }
}
