<?php

namespace App\Http\Controllers;

use App\User;
use App\UserMac;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function loginApi(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return response()->json([
                'error' => 'invalid_credentials',
                'message' => 'The user credentials were incorrect.',
            ], 400);
        }

        if (!\Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'incorrect_password.',
                'message' => 'Incorrect password.',
            ], 400);
        }
        return $user;
    }

    public function registerApi(Request $request)
    {

        if (!$request->all()) {
            return response()->json([
                'error' => 'complete_form',
                'message' => 'Please fill up the form to complete the registration.',
            ], 422);
        }
        if (User::where('email', $request->email)->count()) {
            return response()->json([
                'error' => 'email_taken',
                'message' => 'Email already taken.',
            ], 422);
        }
        if ($request->password !== $request->password_confirm) {
            return response()->json([
                'error' => 'password_do_not_match',
                'message' => 'Password do not match.',
            ], 422);
        }
        $password = \Hash::make($request->password);
        $request->request->set('password', $password);
        $request->request->set('raw_password', $request->password_confirm);
        $user = new User;
        $user->fill($request->all())->save();
        return $user;
    }

    public function loginMac(Request $request)
    {
        if (!isset($request->mac_address)) {
            return response()->json([
                'error' => 'invalid_credentials',
                'message' => 'The user credentials were incorrect.',
            ], 400);
        }
        $user = UserMac::where('mac_address', $request->mac_address)->first();
        if (empty($user)) {
            $user = new UserMac;
            $user->mac_address = $request->mac_address;
            $user->lat = $request->lat;
            $user->lng = $request->lng;
            $user->save();
        }
        if (isset($request->agreement)) {
            $user = UserMac::find($user->id);
            $user->lat = $request->lat;
            $user->lng = $request->lng;
            $user->agreement = $request->agreement;
            $user->save();
        }
        return response()->json($user);
    }

}
