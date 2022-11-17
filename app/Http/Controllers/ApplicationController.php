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

        $cadry = Cadry::where('birht_date', $request->birht_date)->where('jshshir', $jshshir)->where('passport', $passport)->first()->id;

        return app(\App\Http\Controllers\OrganizationController::class)->word_export_api($cadry);
    }
}
