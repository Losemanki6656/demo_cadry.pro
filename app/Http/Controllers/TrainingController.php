<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apparat;
use App\Models\Upgrade;
use App\Models\Cadry;

class TrainingController extends Controller
{
    public function apparats()
    {
        $apparats = Apparat::with('directions')->get();

        $type_qualification = [
                [
                    'id' => 1,
                    'name' => "Malaka oshirish"
                ],
                [
                    'id' => 2,
                    'name' => "Qayta tayyorlash"
                ]
            ];

        return response()->json([
            'type_qualification' => $type_qualification,
            'apparats' => $apparats
        ]);
    }
    public function cadry_add_qual(Cadry $cadry_id, Request $request)
    {           
        $newUpgrade = new Upgrade();
        $newUpgrade->railway_id = $cadry_id->railway_id;
        $newUpgrade->organization_id = $cadry_id->organization_id;
        $newUpgrade->cadry_id = $cadry_id->id;
        $newUpgrade->apparat_id = $request->apparat_id;
        $newUpgrade->cadry_id = $cadry_id->id;
        $newUpgrade->type_training = $request->type_qualification;
        $newUpgrade->training_direction_id = $request->training_direction_id;
        $newUpgrade->dataqual = $request->date_1;
        $newUpgrade->status = false;       
        $newUpgrade->status_bedroom = $request->status_bedroom;
        $newUpgrade->address = $request->address;       
        $newUpgrade->comment = $request->comment;
        $newUpgrade->save();

        $newItem = new Upgrade();
        $newItem->railway_id = $cadry_id->railway_id;
        $newItem->organization_id = $cadry_id->organization_id;
        $newItem->cadry_id = $cadry_id->id;
        $newItem->apparat_id = $request->apparat_id;
        $newItem->cadry_id = $cadry_id->id;
        $newItem->type_training = $request->type_qualification;
        $newItem->training_direction_id = $request->training_direction_id;
        $newItem->dataqual = $request->date_2;
        $newItem->status_bedroom = $request->status_bedroom;
        $newItem->address = $request->address;       
        $newItem->comment = $request->comment;
        $newItem->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function cadry_qual_update($qualification_id, Request $request)
    {           
        $newUpgrade = Upgrade::find($qualification_id);
        $newUpgrade->apparat_id = $request->apparat_id;
        $newUpgrade->type_training = $request->type_qualification;
        $newUpgrade->training_direction_id = $request->training_direction_id;
        $newUpgrade->dataqual = $request->date_qualification;
        $newUpgrade->status_bedroom = $request->status_bedroom;
        $newUpgrade->address = $request->address;       
        $newUpgrade->comment = $request->comment;
        $newUpgrade->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli yangilandi!"
        ]);
    }

    public function cadry_filter($cadry_id)
    {
        $cadries = Upgrade::where('cadry_id', $cadry_id)->get();

        return response()->json([
            'cadries' => $cadries
        ]);
        
    }

    public function statistics(Request $request)
    {
        $cadries = Upgrade::where('cadry_id',$cadry_id)->get();

        return response()->json([
            'cadries' => $cadries
        ]);
    }
}
