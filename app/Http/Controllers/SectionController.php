<?php

namespace App\Http\Controllers;

use App\Section;
use App\TeacherData;
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

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $section = Section::where('section_code', $request->section_code)->first();
            $data = [
                'file_name' => str_slug($name),
                'file_destination' => ("/uploads/" . $section->section_code . '/' . $name),
            ];
            $in = [
                'section_id' => $section->id,
                'key' => 'files',
                'value' => json_encode($data),
            ];
            $td = new TeacherData;
            $td->fill($in)->save();
            $file->move("uploads/" . $section->section_code, $file->getClientOriginalName());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function storeExam(Request $request)
    {
        try {
            \DB::beginTransaction();
            $data = $request->all();
            $teacher_data = [];
            $teacher_data['section_id'] = $data['section_id']; 
            
            unset($data['section_id']); 
            $teacher_data['value'] = json_encode($data);
            $teacher_data['key']    = 'exams';
            TeacherData::create($teacher_data);
            \DB::commit();
            $msg = 'Add Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }
        return compact('msg', 'error_message');
    }

    public function showExam($id)
    {
        $exam = TeacherData::find($id);
        $exam = json_decode($exam->value);
        return compact('exam');
    }
}
