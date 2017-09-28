<?php

namespace App\Http\Controllers;

use App\User;
use App\Section;
use App\StudentSection;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new User();
        return view('teacher.index', compact('user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_student()
    {
        $user = new User();
        return view('teacher.index_students', compact('user'));
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

            $exist = $this->checkUserIfExists($request);

            if ($exist->count() > 0) {
                return response(json_encode(['exist' => ['Teacher is already exist!']]), 422)
                  ->header('Content-Type', 'application/json');    
            }

            \DB::beginTransaction();

            $user_data = $request->all();
            $user_data['raw_password'] = \Crypt::encrypt($user_data['password']);
            $user_data['password'] = bcrypt($user_data['password']);
            $user_data['role'] = 'teacher';
            User::create($user_data);
            \DB::commit();
            $msg = 'Add Teacher Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }

    public function store_student(Request $request)
    {
        try {

            $exist = $this->checkUserIfExists($request);

            if ($exist->count() > 0) {
                return response(json_encode(['exist' => ['Student is already exist!']]), 422)
                  ->header('Content-Type', 'application/json');    
            }

            \DB::beginTransaction();

            $user_data = $request->all();
            $user_data['raw_password'] = \Crypt::encrypt($user_data['password']);
            $user_data['password'] = bcrypt($user_data['password']);
            User::create($user_data);
            \DB::commit();
            $msg = 'Add student Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {

            $exist = $this->checkUserIfExists($request);

            if ($exist->count() < 0) {
                if ($exist->id != $user->id) {
                    return response(json_encode(['exist' => ['User is already exist!']]), 422)
                  ->header('Content-Type', 'application/json');   
                }
                 
            }

            \DB::beginTransaction();
            $user->update($request->all());
            \DB::commit();
            $msg = 'Update User Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }
        return compact('msg', 'error_message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {

            \DB::beginTransaction();
            $user->delete();
            \DB::commit();
            $msg = 'Delete Success!';
        } catch (\Exception $e) {
            \DB::rollBack();
            $error_message = $e->getMessage();
        }

        return compact('msg', 'error_message');
    }



    /**
     * Check if user exists
     *
     * @param array $request
     * @return Response
     */
    private function checkUserIfExists($request)
    {
        return User::where('email', $request->email)->get();
        
    }


    public function profile()
    {   
        $section = new Section;
        return view('teacher.profile', compact('section'));
    }

    public function teacherSection($id)
    {
        $sections = new Section;
        $section = $sections->find($id);
        $section_routeConfig = $sections->routeConfig();

        if ($section && $section->teacher_id !== \Auth::id())
            dd('Unauthorized! This is not your section.');

        $students = StudentSection::where('section_id',$id)->get();


        return view('teacher.section', compact('students','section', 'section_routeConfig'));
    }
}
