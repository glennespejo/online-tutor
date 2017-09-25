<?php

namespace App\Http\Controllers;

use App\Bus;
use Illuminate\Http\Request;
use App\Route;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bus = new Bus();
        $routes = Route::all();
        return view('bus.index', compact('bus','routes'));
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

            $exist = $this->checkBusIfExists($request);

            if ($exist->count() > 0) {
                return response(json_encode(['exist' => ['Bus is already exist!']]), 422)
                  ->header('Content-Type', 'application/json');    
            }

            \DB::beginTransaction();

            $bus_data = $request->all();
            Bus::create($bus_data);
            \DB::commit();
            $msg = 'Add Bus Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $bus)
    {
        return $bus;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $bus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bus $bus)
    {
        try {

            $exist = $this->checkBusIfExists($request);

            if ($exist->count() < 0) {
                if ($exist->id != $bus->id) {
                    return response(json_encode(['exist' => ['Bus is already exist!']]), 422)
                  ->header('Content-Type', 'application/json');   
                }
                 
            }

            \DB::beginTransaction();
            $bus->update($request->all());
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
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus $bus)
    {
        try {

            \DB::beginTransaction();
            $bus->delete();
            \DB::commit();
            $msg = 'Delete Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }

    /**
     * Check if bus exists
     *
     * @param array $request
     * @return Response
     */
    private function checkBusIfExists($request)
    {
        return Bus::where('bus_number', $request->bus_number)->orWhere('plate_number', $request->plate_number)->get();
        
    }
}
