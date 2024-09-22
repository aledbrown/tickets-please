<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        return response()->json([
            'name' => config('app.name'),
            'message' => 'Hello, Login!',
        ], 200);
    }
}
