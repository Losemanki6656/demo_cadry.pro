<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;

class PereviewStatisticController extends Controller
{
    public function pereview_retireds(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

       if($request->sex)
       {
            $cadries = Cadry::ApiFilter()
                ->when(\Request::input('sex'),function($query,$sex){
                    $query->where(function ($query) use ($sex) {
                        if($sex == true)
                            return $query->where('sex', true)->where('birht_date','<=','1957-01-01');
                        else 
                            return $query->where('sex', false)->where('birht_date','<=','1967-01-01');
                    
                    });
                });
       } else {

            $cadries = Cadry::ApiFilter()
                ->where(function ($query) {
                    $query->Where('sex', 1)->where('birht_date','<=','1957-01-01');
                })
                ->orwhere(function ($query) {
                    $query->Where('sex', 0)->where('birht_date','<=','1967-01-01');
                });

       }

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }
}
