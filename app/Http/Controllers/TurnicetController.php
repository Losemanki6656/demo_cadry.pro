<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turnicet;
use App\Http\Resources\Turnicet\TurnicetCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TurnicetExport;

class TurnicetController extends Controller
{
    public function index()
    {
        $cadries = Turnicet::query()
            ->when(request('search'),function($query, $search){
                $query->where('name','like','%'.$search.'%');
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
            ->orderBy('datetime','desc')
            ->paginate(10);

        $cadries = new TurnicetCollection($cadries);

        return response()->json([
            'cadries' => $cadries
        ]);
    }

    public function download()
    {
        $cadries = Turnicet::query()
            ->when(request('search'),function($query, $search){
                $query->where('name','like','%'.$search.'%');
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
            ->orderBy('datetime','desc')
            ->get();

            $arr = []; $x = 0;
        foreach($cadries as $item) 
        {
            $x ++ ;
            $arr[] = [
                'id' => $x,
                'name' => $item->name,
                'status' => $item->status,
                'date' => $item->datetime->format('d-m-Y'),
                'time' => $item->datetime->format('H:i:s')
            ];
        }
        
        return Excel::download(new TurnicetExport($arr, $x), 'Turnicet.xlsx');

    }
}
