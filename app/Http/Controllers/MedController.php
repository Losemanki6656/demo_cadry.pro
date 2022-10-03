<?php

namespace App\Http\Controllers;
use App\Models\Cadry;

use Illuminate\Http\Request;
use App\Http\Resources\MedCollection;

class MedController extends Controller
{
    public function meds()
   {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

         $cadries = Cadry::SeFilter()
            ->select(['cadries.*', 'medical_examinations.*'])
            ->where('cadries.status',true)
            ->where('medical_examinations.status',true)
            ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
            ->orderBy('medical_examinations.date2')
            ->paginate($per_page);
         
      return response()->json([
         'cadries' => new MedCollection($cadries)
      ]);
   }
}
