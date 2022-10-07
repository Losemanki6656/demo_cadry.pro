<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incentive;
use App\Models\Cadry;
use App\Models\DisciplinaryAction;

class IncentiveController extends Controller
{
    public function incentives()
    {
        
        $items = Incentive::with('cadry')->get();

        $x = 0; $a = [];
        foreach ($items as $item) 
        { 
            if(!$item->cadry)  {
                $x ++;
                $item->delete();
            }
        }


        return response()->json([
            'cadries' => $x
        ]);

    }

    public function control()
    {
        
        $items = Incentive::with('cadry')->get();

        $x = 0; $a = [];
        foreach ($items as $item) 
        { 
            $b = $item->cadry;
            $item->railway_id = $b->railway_id;
            $item->organization_id = $b->organization_id;
            $item->save();

            $x ++;
        }


        return response()->json([
            'cadries' => $x
        ]);

    }
}
