<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\BioCadry;
use App\Http\Resources\EmmatCadry;

class EmmatController extends Controller
{
     public function emmat_cadries()
     {

        $emmat_department = auth()->user()->emmat_department->emmat_department_id;

        $cadries = BioCadry::where('emmat_department_id', $emmat_department)->with('cadry.allStaffs')->get();

        return response()->json([
            'cadries' =>  EmmatCadry::collection($cadries)
        ]);
     }

     public function add_token_to_cadry($emmat_cadry_id, Request $request)
     {
        $cadry = BioCadry::find($emmat_cadry_id);
        $cadry->token_bio = $request->token_bio;
        $cadry->save();

        return response()->json([
            'message' =>  "Muvaffaqqiyatli!"
        ], 200);
     }
}
