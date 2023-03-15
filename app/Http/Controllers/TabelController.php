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
                    return $query->where('year', $year)->where('month', $month);
                }
            ])
            ->where('department_id', $user->department_id)
            ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month',$month);
                }
            ])
            ->where('organization_id', $user->organization_id)
            ->get();
        }
        
       
        $tabel = [];

        foreach($cadries as $item)
        {
            if($item->tabel) {
                $cadry_tabel = $item->tabel->days;
            } else $cadry_tabel = $cadry_days;

            $tabel[] = [
                'id' => $item->id,
                'fullname' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name,
                'days' => $cadry_tabel
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
        $user = auth()->user();

        DB::transaction(function() use ($request, $user) {

            foreach($request->cadries as $item)
            {
                $factCount = 0; $hours = 0; $rp = 0; $n = 0;
                foreach($item['days'] as $day)
                {
                    if($day['category_id']!=null && $day['work_time']!=null) {
                        $factCount ++;
                        $hours = $hours + $day['work_time'];

                        if($day['category_id'] == 3) $rp = $rp + $day['work_time'];
                        if($day['category_id'] == 2) $n = $n + $day['work_time'];
                    }
                }
                
                if($factCount){
                    $cadry = Tabel::where('cadry_id',$item['id'])->where('year',$request->year)->where('month',$request->month);

                    if($cadry->count())
                    {
                        $cadry->first()->update([
                            'cadry_id' => $item['id'],
                            'year' => $request->year,
                            'month' => $request->month,
                            'days' => $item['days'],
                            'send_user_id' => $user->id,
                            'fact' => $factCount,
                            'vsevo' => $hours,
                            'prazdnichniy' => $rp,
                            'nochnoy' => $n
                        ]);
                    }
                    else
                    Tabel::create([
                        'cadry_id' => $item['id'],
                        'year' => $request->year,
                        'month' => $request->month,
                        'days' => $item['days'],
                        'send_user_id' => $user->id,
                        'fact' => $factCount,
                        'vsevo' => $hours,
                        'prazdnichniy' => $rp,
                        'nochnoy' => $n,
                        'railway_id' => $user->department->railway_id,
                        'organization_id' => $user->department->organization_id,
                        'department_id' => $user->department->department_id
                    ]);
                }
                
            }
        });

        return response()->json([
            'message' => 'successfully',
        ]);
    }

    public function tabel_export(Request $request)
    {
        $holidays = Holiday::whereYear('holiday_date', $request->year)->whereMonth('holiday_date', $request->month)->where('old_holiday',false)->get();
        $days = [];

        foreach($holidays as $item)
        {
            $days[] = $item->holiday_date->format('d');
        }
        
        $cadries = $this->workers($request->year, $request->month);

        $x = 0; $a = [];
        foreach ($cadries as $cadry)
        {
            $x ++;
            $fullname = $cadry->cadry->last_name . ' ' . $cadry->cadry->fist_name . ' ' . $cadry->cadry->middle_name;

            $a[] = [
                $x,
                $fullname,
                $cadry->fact,
                $cadry->selosmenix_prostov,
                $cadry->ocherednoy_otpusk,
                $cadry->bolezn,
                $cadry->neyavki_razr,
                $cadry->razr_admin,
                $cadry->progul,
                $cadry->vixod_prazd,
                $cadry->tekush_pros,
                $cadry->opazjanie,
                $cadry->vsevo,
                $cadry->sdelno,
                $cadry->svixurochniy,
                $cadry->nochnoy,
                $cadry->prazdnichniy,
                $cadry->tabel_number,
                $cadry->ustanovleniy,
                $cadry->ekonomie,
                $cadry->vid_oplate,
                $cadry->sxema_rascheta,
                $cadry->dop_priznak,
                $cadry->prosent_primi,
                $cadry->dni_fact,
                $cadry->chasi_fact,
                $cadry->fact_rabot,
                $cadry->vixod_priznich
            ];

            $a[] = [
                ''
            ];

            $y = 0; $z = []; $q = [];
            $z[] = ''; $q[] = '';
            foreach ($cadry['days'] as $day)
            {
                $y ++;
                if($y <= 15) {
                    $z[] = $day['work_time'];
                } else {
                    $q[] = $day['work_time'];
                }
            }

            $a[] = $z; 
            $a[] = $q;
        }

        $organization = auth()->user()->department->organization->name;

        return Excel::download(new TabelExport($days, $a, $x, $request->year, $request->month, $organization), 'tabel.xlsx');

    }

    public function workers($year, $month)
    {
        $user = auth()->user()->department;

        if($user->status == 1) {
            $cadries = Tabel::where('year', $year)->where('month', $month)
                ->where('department_id', $user->department_id)->with('cadry')
                ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Tabel::where('year', $year)->where('month',$month)
                ->where('organization_id', $user->organization_id)->with('cadry')
                ->get();
        }

        return $cadries;
    }


}
