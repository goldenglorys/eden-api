<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $response = [
            'success' => true,
            'message' => "Welcome to the Garden of Eden. A new day, another opportunity to be a step closer to 'Paradise'!",
        ];

        return response()->json($response, 200);
    }
}
