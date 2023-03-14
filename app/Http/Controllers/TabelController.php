<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TabelExport;

use App\Models\Cadry;
use App\Models\Tabel;
use App\Models\Holiday;
use App\Models\TabelCategory;
use App\Models\UserDepartment;
use App\Http\Resources\TableCadryResource;
use App\Http\Resources\TabelResources\TabelCategoryResource;
use App\Http\Resources\HolidayResources\HolidayResource;
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
  
        $holidays = Holiday::whereYear('holiday_date', $year)->whereMonth('holiday_date',$month)->get();

        $hols = $holidays;

        $days = []; $cadry_days = [];
        for($i = 1; $i <= $number; $i++)
        {
            $dayOfTheWeek = \Carbon\Carbon::parse($year  . '-' . $month . '-' . $i)->dayOfWeek;
            $weekday = $weekMap[$dayOfTheWeek];
            
            $holiday = false; 
            $before_day = false; 
            $category_id = null;

            foreach($hols as $hol)
            {
                if((int)$hol->holiday_date->format('d') == $i) {
                    if(!$hol->old_holiday) {
                        $category_id = 3;
                        break;
                    } else {
                        $before_day = true;
                        break;
                    }    
                } 
            }

            $days[] = [
                'day' => $i,
                'weekday' => $weekday,
                "category_id" => $category_id,
                "work_time" => null,
                'before_day' => $before_day
            ];

            $cadry_days[] = [
                'day' => $i,
                'weekday' => $weekday,
                "category_id" => $category_id,
                "work_time" => null,
            ];
        }
        $user = auth()->user()->department;

        if($user->status == 1) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                return $query->where('year', $year)->where('month',$month);
                }
            ])
            ->where('department_id', $user->department_id)
            ->limit($request->limit)
            ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                return $query->where('year', $year)->where('month',$month);
                }
            ])
            ->where('organization_id', $user->organization_id)
            ->limit($request->limit)
            ->get();
        }
        
       
        $tabel = [];

        foreach($cadries as $item)
        {
            if($item->tabel) {
                $cadry_tabel = $item->days;
            } else $cadry_tabel = $days;

            $tabel[] = [
                'id' => $item->id,
                'fullname' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name,
                'days' => $cadry_days
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

        DB::transaction(function() use ($request) {

            foreach($request->cadries as $item)
            {
                $factCount = 0;
                foreach($item['days'] as $day)
                {
                    // if($day['category_id'] && $day[''])
                }
                
                $cadry = Tabel::where('cadry_id',$item['id'])->where('year',$request->year)->where('month',$request->month);

                if($cadry->count())
                {
                    $cadry->first()->update([
                        'cadry_id' => $item['id'],
                        'year' => $request->year,
                        'month' => $request->month,
                        'days' => $item['days']
                    ]);
                }
                else
                Tabel::create([
                    'cadry_id' => $item['id'],
                    'year' => $request->year,
                    'month' => $request->month,
                    'days' => $item['days']
                ]);
            }
        });

        return response()->json([
            'message' => 'successfully',
        ]);
    }

    public function tabel_export()
    {
        $holidays = Holiday::whereYear('holiday_date', 2023)->whereMonth('holiday_date',3)->where('old_holiday',false)->get();
        $days = [];
        foreach($holidays as $item)
        {
            $days[] = $item->holiday_date->format('d');
        }
        

        return Excel::download(new TabelExport($days), 'tabel.xlsx');

    }
}
