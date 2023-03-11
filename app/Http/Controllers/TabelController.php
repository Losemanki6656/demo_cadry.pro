<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\Tabel;
use App\Models\TabelCategory;
use App\Http\Resources\TableCadryResource;
use App\Http\Resources\TabelResources\TabelCategoryResource;
use DB;

class TabelController extends Controller
{
    
    public function tabel_cadries(Request $request)
    {

        $month = $request->month;
        $year = $request->year;
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $weekMap = [
            0 => 'Ya',
            1 => 'Du',
            2 => 'Se',
            3 => 'Ch',
            4 => 'Pa',
            5 => 'Ju',
            6 => 'Sh',
        ];

        $days = [];
        for($i = 1; $i <= $number; $i++)
        {
            $dayOfTheWeek = \Carbon\Carbon::parse($year  . '-' . $month . '-' . $i)->dayOfWeek;
            $weekday = $weekMap[$dayOfTheWeek];

            $days[] = [
                'day' => $i,
                'weekday' => $weekday,
                "type_work" => null,
                "work_time" => null
            ];
        }
        $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
            return $query->where('year', $year)->where('month',$month);
        }
        ])
        ->where('department_id', 107)
        ->get();

        $tabel = [];

        foreach($cadries as $item)
        {
            if($item->tabel) {
                $cadry_tabel = $item->days;
            } else $cadry_tabel = $days;

            $tabel[] = [
                'id' => $item->id,
                'fullname' => $item->last_name . ' ' . $item->fist_name . ' ' . $item->middle_name,
                'staff' => 'staff',
                'days' => $days
            ];
        }

        $categories = TabelCategoryResource::collection(TabelCategory::get());

        return response()->json([
            'categories' => $categories,
            'days' => $days,
            'cadries' => $tabel
        ]);
    }

    public function create_tabel_to_cadry(Request $request)
    {
       
        // $input = [
        //     'cadry_id' => $request->cadry_id,
        //     'tabel_year' => $request->year,
        //     'table_month' => $request->month,
        //     'days' => $request->days
        // ];

        // dd($request->all());

        // $json = $request->all();
       

        DB::transaction(function() use ($request) {
            foreach($request->all() as $item)
            {
                Tabel::create($item);
            }
        });

        return response()->json([
            'message' => 'successfully',
        ]);
    }
}
