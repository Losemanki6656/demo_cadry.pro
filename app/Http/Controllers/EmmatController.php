<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Http\Resources\EmmatCadryCollection;
use App\Http\Resources\EmmatCadryViewResource;

class EmmatController extends Controller
{
     public function emmat_cadries()
     {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $user_org = auth()->user()->userorganization;

        $cadries = Cadry::where('organization_id', $user_org->organization_id)->with('allStaffs')->where('status',true)->paginate($per_page);

        return response()->json([
            'cadries' =>  new EmmatCadryCollection($cadries)
        ]);
     }

     public function cadry_view($cadry_id)
     {
        $cadry = Cadry::with('allstaffs')->find($cadry_id);

        return response()->json([
            'cadry' =>  new EmmatCadryViewResource($cadry)
        ], 200);
     }
}
