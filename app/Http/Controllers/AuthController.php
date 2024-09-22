<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;

class AuthController extends Controller
{
    use ApiResponses;

    public function login()
    {
        return $this->ok('Hello, Login!', 200);
        // return response()->json([
        //     'name' => config('app.name'),
        //     'message' => 'Hello, Login!',
        // ], 200);
    }
}
