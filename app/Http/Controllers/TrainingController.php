<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apparat;

class TrainingController extends Controller
{
    public function apparats()
    {
        $apparats = Apparat::all();

        return response()->json([
            'apparats' => $apparats
        ]);
    }
}
