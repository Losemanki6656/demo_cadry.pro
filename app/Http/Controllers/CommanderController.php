<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Commander;
use App\Models\Cadry;

use App\Http\Resources\CommanderCollection;
use App\Http\Resources\CommanderResource;


class CommanderController extends Controller
{
    public function commanders()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $commanders = Commander::where('status', false)->paginate($per_page);

        return response()->json([
            'commanders' => new CommanderCollection($commanders)
        ]);
    }

    public function cadry_commanders($cadry)
    {

        $commanders = Commander::where('cadry_id', $cadry)->get();

        return response()->json([
            'commanders' => CommanderResource::collection($commanders)
        ]);
    }

    public function commander_accept(Commander $commander)
    {

        $commander->update([
            'status' => true
        ]);

        return response()->json([
            'message' => 'success'
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

    public function commander_update(Commander $commander, Request $request)
    {
        $user = auth()->user();

        $commander->update([
            'user_id' => $user->id,
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

    public function commander_delete(Commander $commander)
    {
        $commander->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }

}
