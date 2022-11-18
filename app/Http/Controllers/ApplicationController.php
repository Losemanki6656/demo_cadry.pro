<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;

class ApplicationController extends Controller
{
    
    public function find_cadry(Request $request)
    {
        $passport = str_replace('-', ' ', $request->passport);
        $jshshir = str_replace('-', '', $request->jshshir);

        $cadry = Cadry::where('status', true)->where('birht_date', $request->birht_date)->where('jshshir', $jshshir)->where('passport', $passport)->first();

        if(!$cadry) {
            return response()->json([
                'message' => "Exodim Platformasida bunday xodim topilmadi yoki Platformadagi ma'lumotlarga siz to'ldirgan ma'lumotlar mos kelmadi..."
            ], 403);
        } else
        return app(\App\Http\Controllers\OrganizationController::class)->word_export_api($cadry->id);
    }
}
