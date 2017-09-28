<?php

namespace App\Http\Controllers;

use App\Section;
use App\StudentAttendance;
use App\StudentSection;
use App\User;
use Illuminate\Http\Request;

class ICOapiController extends Controller
{
    public function checkIp(Request $request)
    {
        $ip = gethostbyname(getHostname());
        if ($request->ip_address === $ip) {
            return response()->json([
                'error' => 'ok',
            ], 200);
        }
        return response()->json([
            'error' => 'not',
        ], 400);
    }

    public function getSubj(Request $request)
    {

        $sections = StudentSection::where('student_id', $request->student_id)->get();
        $s = [];
        foreach ($sections as $key => $sec) {
            $s[] = Section::where('id', $sec->section_id)->first();
        }
        $data = [];
        $datas = [];
        foreach ($s as $key => $section) {
            $user = User::find($section->teacher_id);
            $data = [
                'id' => $section->id,
                'teacher_id' => $section->teacher_id,
                'teacher_name' => $user->name,
                'section_code' => $section->section_code,
                'section_name' => $section->section_name,
            ];
            $datas[] = $data;
        }
        return response()->json($datas);
    }

    public function attendance(Request $request)
    {

        if (!isset($request->student_id) || !isset($request->section_code)) {
            return response()->json([
                'error' => 'not',
            ], 400);
        }
        $date = date('Y-m-d');

        $exist = StudentAttendance::where('date', $date)
            ->where('section_code', $request->section_code)
            ->where('student_id', $request->student_id)->first();
        if ($exist) {
            return response()->json($exist);
        }
        $attendance = new StudentAttendance;
        $request->request->set('date', $date);
        $attendance->fill($request->all())->save();
        return response()->json($attendance);
    }

    public function enSect(Request $request)
    {
        if (!isset($request->subject_code) || !isset($request->student_id)) {
            return response()->json([
                'error' => 'not',
            ], 400);
        }
        $section = Section::where('section_code', $request->subject_code)->first();
        if (empty($section)) {
            return response()->json([
                'error' => 'section_not_exist',
                'message' => 'Section does not exist',
            ], 404);
        }
        $exist = StudentSection::where('student_id', $request->student_id)->where('section_id', $section->id)->first();
        if ($exist) {
            return response()->json([
                'error' => 'already_enrolled',
                'message' => 'Already enrolled',
            ], 400);
        }
        $add = new StudentSection;
        $add->student_id = $request->student_id;
        $add->section_id = $section->id;
        $add->save();

        $user = User::find($section->teacher_id);
        $data = [
            'id' => $section->id,
            'teacher_id' => $section->teacher_id,
            'teacher_name' => $user->name,
            'section_code' => $section->section_code,
            'section_name' => $section->section_name,
        ];

        return response()->json($data);
    }
}
