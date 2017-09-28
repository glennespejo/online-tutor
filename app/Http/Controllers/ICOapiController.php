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
}
