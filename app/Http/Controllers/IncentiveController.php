<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incentive;
use App\Models\Cadry;
use App\Models\DisciplinaryAction;

use App\Http\Resources\IncentiveCadryCollection; 
use App\Http\Resources\DiscipCadryCollection; 

class IncentiveController extends Controller
{
    public function incentives()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = Cadry::ApicadryFilter()->has('incentives')->paginate($per_page);


        return response()->json([
            'incentive_status' => [
                [
                    'id' => 0,
                    'name' => "Rag'batlantirish xodim ma'lumotnomasiga kiritilmaydi!"
                ],
                [
                    'id' => 1,
                    'name' => "Rag'batlantirish xodim ma'lumotnomasiga qo'shiladi!"
                ]
            ],
            'cadries' => new IncentiveCadryCollection($cadries),
        ]);

    }

    public function disciplinary_actions()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = Cadry::ApicadryFilter()->has('discips')->paginate($per_page);

        return response()->json([
            'cadries' => new DiscipCadryCollection($cadries),
        ]);

    }


}
