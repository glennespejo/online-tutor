<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            \DB::beginTransaction();

            $section_data = $request->all();
            $section_data['teacher_id'] = \Auth::id();
            $section = Section::create($section_data);
            $section->section_code = strtoupper(str_random(3)) . '-000-' . $section->id;
            $section->save();
            \DB::commit();
            $msg = 'Add Section Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return $section;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        try {

            \DB::beginTransaction();
            $section->update($request->all());
            \DB::commit();
            $msg = 'Update Section Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }
        return compact('msg', 'error_message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
         try {

            \DB::beginTransaction();
            $section->delete();
            \DB::commit();
            $msg = 'Delete Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }
}