<?php

namespace App\Http\Controllers;

use App\Section;
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
        $sections = Section::all();
        $data = [];
        $datas = [];
        foreach ($sections as $key => $section) {
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

        if (isset($request->date) && isset($request->section_code) && isset($request->id)) {
            $fromdate = new \DateTime($request->date . '00:00:00');
            $todate = new \DateTime($request->date . '23:59:59');
            $attendance = StudentAttendance::where('section_code', $request->subject_code)
                ->where('teacher_id', $request->id)
                ->where('date', $request->date)
                ->get();
            $attendances = [];
            foreach ($attendance as $key => $value) {
                $attendances[] = $value->student_id;
            }
            $datas = [];
            $data = [];
            $class = StudentSubject::where('section_code', $request->section_code)->where('teacher_id', $request->id)->first();
            $results = $class->student()->get();
            foreach ($results as $key => $value) {
                $data['id'] = $value->id;
                $data['student_name'] = $value->first_name . " " . $value->last_name;
                if (in_array($value->id, $attendances)) {
                    $data['status'] = 'absent';
                    $data['absent'] = true;
                } else {
                    $data['status'] = 'present';
                    $data['absent'] = false;
                }
                $datas[] = $data;
            }
            return response()->json($datas);
        }
        if (empty($request->all()) || !isset($request->section_code) || !isset($request->student_id) || !isset($request->teacher_id)) {
            return response()->json([
                'error' => 'Oops!',
                'message' => 'Your request is empty.',
            ], 400);
        }

        $fromdate = new \DateTime($request->date . '00:00:00');
        $todate = new \DateTime($request->date . '23:59:59');

        $attendance = StudentAttendance::where('section_code', $request->section_code)
            ->where('teacher_id', $request->teacher_id)
            ->where('student_id', $request->student_id)
            ->where('date', $request->date)
            ->first();

        if ($attendance) {
            StudentAttendance::find($attendance->id)->delete();

            $attendance = StudentAttendance::where('section_code', $request->section_code)
                ->where('teacher_id', $request->teacher_id)
                ->where('date', $request->date)
                ->get();
            $attendances = [];
            foreach ($attendance as $key => $value) {
                $attendances[] = $value->student_id;
            }
            $datas = [];
            $data = [];
            $class = StudentSubject::where('section_code', $request->section_code)->where('teacher_id', $request->teacher_id)->first();
            $results = $class->student()->get();
            foreach ($results as $key => $value) {
                $data['id'] = $value->id;
                $data['student_name'] = $value->first_name . " " . $value->last_name;
                if (in_array($value->id, $attendances)) {
                    $data['status'] = 'absent';
                    $data['absent'] = true;
                } else {
                    $data['status'] = 'present';
                    $data['absent'] = false;
                }
                $datas[] = $data;
            }
            return response()->json($datas);
        }

        $student = new StudentAttendance;
        $student->fill($request->all())->save();

        $attendance = StudentAttendance::where('section_code', $request->section_code)
            ->where('teacher_id', $request->teacher_id)
            ->where('date', $request->date)
            ->get();
        $attendances = [];
        foreach ($attendance as $key => $value) {
            $attendances[] = $value->student_id;
        }
        $datas = [];
        $data = [];
        $class = StudentSubject::where('section_code', $request->section_code)->where('teacher_id', $request->teacher_id)->first();
        $results = $class->student()->get();
        foreach ($results as $key => $value) {
            $data['id'] = $value->id;
            $data['student_name'] = $value->first_name . " " . $value->last_name;
            if (in_array($value->id, $attendances)) {
                $data['status'] = 'absent';
                $data['absent'] = true;
            } else {
                $data['status'] = 'present';
                $data['absent'] = false;
            }
            $datas[] = $data;
        }
        return response()->json($datas);

    }
}
