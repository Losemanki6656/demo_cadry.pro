<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Commander;

use App\Http\Resources\CommanderCollection;

class CommanderController extends Controller
{
    public function commanders()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $commanders = Commander::paginate($per_page);

        return response()->json([
            'commanders' => new CommanderCollection($commanders)
        ]);
    }

    public function add_commander(Cadry $cadry, Request $request)
    {
        $user = auth()->user();
        $organ = auth()->user()->userorganization;

        Commander::create([
            'railway_id' => $organ->railway_id,
            'organization_id' => $organ->organization_id,
            'user_id' => $user->id,
            'cadry_id' => $cadry->id,
            'country_id' => $request->country_id,
            'commander_payment_id' => $request->commander_payment_id,
            'commander_pupose_id' => $request->commander_pupose_id,
            'position' => $request->position,
            'command_number' => $request->command_number,
            'date_command' => $request->date_command,
            'date1' => $request->date1,
            'date2' => $request->date2,
            'days' => $request->days,
            'reason' => $request->reason
        ]);

        return response()->json([
            'message' => 'success'
        ]);
    }

}
