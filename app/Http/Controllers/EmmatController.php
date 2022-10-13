<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Http\Resources\OrganizationCadryResource;

class EmmatController extends Controller
{
     public function emmat_cadries()
     {

        $cadries = Cadry::ApiOrgFilter()
        ->with(['vacation','allStaffs','department'])->get();
    
        return response()->json([
            'cadries' =>  OrganizationCadryResource::collection($cadries)
        ]);
     }
}
