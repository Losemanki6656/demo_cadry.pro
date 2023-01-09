<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\DemoCadry;
use App\Models\Vacation;
use App\Models\UserTask;
use App\Models\DepartmentStaff;
use App\Http\Resources\CadryCollection;
use App\Http\Resources\DeleteCadryCollection;
use App\Http\Resources\VacationCadryCollection;
use App\Http\Resources\DepartmentStaffCollection;
use App\Http\Resources\CadryMedCollection;
use App\Http\Resources\UserTaskCollection;

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
                ->where(function($query) {
                    $query->where([
                                    ['birht_date','<=','1957-01-01'],
                                    ['sex', 1],
                                ])
                        ->orwhere([
                                    ['birht_date','<=','1967-01-01'],
                                    ['sex', 0],
                        ]);
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
            ->select(['cadries.*', 'medical_examinations.*'])
            ->where('cadries.status', true)
            ->where('medical_examinations.status',true)
            ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
            ->orderBy('medical_examinations.date2')
            ->whereDate('medical_examinations.date2','<=', now())
            ->with('allstaffs');

        return response()->json([
            'cadries' => new CadryMedCollection($cadries->paginate($per_page))
        ]);
        
    }

    public function pereview_expired_meds(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = Cadry::ApiFilter()->with('allstaffs')->has('med','=',0);

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
        if($request->birth_date) 
        $birth_date = strtotime($request->birth_date); else $birth_date = now();
        $dateMonth = date('m', $birth_date);
        $dateDay = date('d', $birth_date);

        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $cadries = Cadry::ApiFilter()->whereMonth('birht_date', '=', $dateMonth)
            ->whereDay('birht_date', '=', $dateDay);

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

    public function stafffiles(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $stafffiles = Cadry::ApiFilter()->has('staff_files', '=', 0);

        return response()->json([
            'stafffiles' => new CadryCollection($stafffiles->paginate($per_page))
        ]);
    }

    public function user_tasks()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $tasks = UserTask::query()->where( 'user_id', auth()->user()->id )
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('comment','like','%'.$search.'%');
                });
            })->orderBy('created_at', 'desc');

        return response()->json([
            'tasks' => new UserTaskCollection($tasks->paginate($per_page))
        ]);
    }

    public function task_delete($task_id)
    {
        
        if(!UserTask::find($task_id))
            return response()->json([
                'message' => "Bunday topshiriq topilmadi!"
            ],404);
           
        UserTask::find($task_id)->delete();

        return response()->json([
            'message' => "Topshiriq muvaffaqqiyatli o'chirildi!"
        ]);
        
    }


    public function pereview_passports(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
        
        $passports = Cadry::ApiFilter()->has('passports', '=', 0);

        return response()->json([
            'passports' => new CadryCollection($passports->paginate($per_page))
        ]);
    }
}
