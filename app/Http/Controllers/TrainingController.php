<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apparat;

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
}
