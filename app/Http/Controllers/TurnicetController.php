<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turnicet;
use App\Http\Resources\Turnicet\TurnicetCollection;

class TurnicetController extends Controller
{
    public function index()
    {
        $cadries = Turnicet::query()
            ->when(request('search'),function($query, $search){
                $query->where('name','like','%'.$search.'%')
                    ->orWhere('deviceName','like','%'.$search.'%');
            })
            ->when(request('status'),function($query, $status){
                $query->where('status', $status);
            })
            ->when(request('datetime1'),function($query, $datetime1){
                $query->where('datetime', '>=', $datetime1);
            })
            ->when(request('datetime2'),function($query, $datetime2){
                $query->where('datetime', '<=', $datetime2);
            })
            ->orderBy('datetime','desc')->paginate(10);

        $cadries = new TurnicetCollection($cadries);

        return response()->json([
            'cadries' => $cadries
        ]);
    }
}
