<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VacationCadry;
use App\Http\Resources\VacCadCollection;

class CadryVacationController extends Controller
{
    public function vacation_cadry_create($cadry_id, Request $request)
    {
        $item = new VacationCadry();
        $item->railway_id = auth()->user()->userorganization->railway_id;
        $item->organization_id = auth()->user()->userorganization->organization_id;
        $item->cadry_id = $cadry_id;
        $item->period1 = $request->period1;
        $item->period2 = $request->period2;
        $item->date1 = $request->date1;
        $item->save();

        return response()->json([
            'message' => 'successfully created'
        ]);
    }

    public function vacation_cadries($cadry_id)
    {
        $vacation_cadries = VacationCadry::where('cadry_id', $cadry_id)->get();

        return response()->json([
            'vacation_cadries' => $vacation_cadries
        ]);
    }

    public function vacation_cadries_all()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $vacation_cadries = VacationCadry::with('cadry')->where('organization_id', auth()->user()->userorganization->organization_id)->paginate($per_page);

        return response()->json([
            'vacation_cadries' => new VacCadCollection($vacation_cadries)
        ]);
    }
}
