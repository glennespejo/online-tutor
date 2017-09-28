<?php

namespace App\Http\Controllers;

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
}
