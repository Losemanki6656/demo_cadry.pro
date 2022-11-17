<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    
    public function find_cadry(Request $request)
    {

        return response()->json([
            'data' => $request->all()
        ]);
    }
}
