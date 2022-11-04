<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\DemoCadry;
use App\Models\Vacation;
use App\Models\DepartmentStaff;
use App\Http\Resources\CadryCollection;
use App\Http\Resources\DeleteCadryCollection;
use App\Http\Resources\VacationCadryCollection;
use App\Http\Resources\DepartmentStaffCollection;

class PereviewStatisticController extends Controller
{
    public function pereview_retireds(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

       if($request->sex)
       {
            $cadries = Cadry::ApiFilter()
                ->when(\Request::input('sex'),function($query,$sex){
                    $query->where(function ($query) use ($sex) {
                        if($sex == true)
                            return $query->where('sex', true)->where('birht_date','<=','1957-01-01');
                        else 
                            return $query->where('sex', false)->where('birht_date','<=','1967-01-01');
                    
                    });
                });
       } else {

            $cadries = Cadry::ApiFilter()
                ->where(function ($query) {
                    $query->Where('sex', 1)->where('birht_date','<=','1957-01-01');
                })
                ->orwhere(function ($query) {
                    $query->Where('sex', 0)->where('birht_date','<=','1967-01-01');
                });

       }

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_contractors(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

         $cadries = Cadry::ApiFilter()
                ->where('worklevel_id', 5)->with(['allstaffs','allstaffs.department','allstaffs.cadry']);

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_domestic_workers(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

         $cadries = Cadry::ApiFilter()
                ->where('worklevel_id', 5)->with(['allstaffs','allstaffs.department','allstaffs.cadry']);

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_not_meds(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = Cadry::FilterJoinApi()
            ->where('railway_id','!=',3)
            ->select(['cadries.*', 'medical_examinations.*'])
            ->where('cadries.status',true)
            ->where('medical_examinations.status',true)
            ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
            ->orderBy('medical_examinations.date2')
            ->whereDate('medical_examinations.date2','<=', now());

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_expired_meds(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = Cadry::ApiFilter()->has('med','=',0);

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_vacations(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        if($request->status_decret != null)
            $vacations = Vacation::ApiFilter()->where('status_decret', $request->status_decret);
        else $vacations = Vacation::ApiFilter();

        return response()->json([
            'cadries' => new VacationCadryCollection($vacations->paginate($per_page))
        ]);
        
    }

    public function pereview_not_careers(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = Cadry::ApiFilter()->has('careers', '=', 0);

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }
    public function pereview_not_relatives(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = Cadry::ApiFilter()->has('relatives', '=', 0);

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_birthdays(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = Cadry::ApiFilter()->whereMonth('birht_date', '=', now()->format('m'))
            ->whereDay('birht_date', '=', now()->format('d'));

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_new_cadries(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = Cadry::ApiFilter()
            ->whereDate('created_at','>=', $request->date1)
            ->whereDate('created_at','<=', $request->date2);

        return response()->json([
            'cadries' => new CadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_delete_cadries(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = DemoCadry::ApiFilter()
            ->whereDate('created_at','>=', $request->date1)
            ->whereDate('created_at','<=', $request->date2);

        return response()->json([
            'cadries' => new DeleteCadryCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_delete_black_cadries(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = DemoCadry::ApiBlackFilter()
            ->whereDate('created_at','>=', $request->date1)
            ->whereDate('created_at','<=', $request->date2);

        return response()->json([
            'cadries' => new DeleteCadryCollection($cadries->paginate($per_page))
        ]);
        
    }


    public function pereview_vacancies(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = DepartmentStaff::ApiFilter()
                ->where(function ($query) {
                    $query->whereRaw('stavka > summ_stavka')
                            ->orWhere('summ_stavka', null);
                });

        $x = $cadries->sum('stavka');
        $y = $cadries->sum('summ_stavka');

        $vacancies_count = $x - $y;

        return response()->json([
            'vacancies_count' => $vacancies_count,
            'vacancies' => new DepartmentStaffCollection($cadries->paginate($per_page))
        ]);
        
    }

    
    public function pereview_over(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = DepartmentStaff::ApiFilter()->whereRaw('stavka < summ_stavka');
        
        $x = $cadries->sum('stavka');
        $y = $cadries->sum('summ_stavka');
        $over_count = $y - $x;

        return response()->json([
            'over_count' => $over_count,
            'over' => new DepartmentStaffCollection($cadries->paginate($per_page))
        ]);
        
    }
}
