<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Auth;


use App\Http\Resources\DepResource;

class DepartmentController extends Controller
{
    public function departments()
    {
        $all = 0; $allSv = 0;
        $org_id = Auth::user()->userorganization->organization_id;

        $page = request('page', session('department_page', 1));
        session(['department_page' => $page]);

        if($org_id == 152) {
            $departments = Department::query()->where('id','!=',4304)
            ->where('organization_id', $org_id)
            ->when(\Request::input('search'),function($query,$search){
                $query
                ->where('name','like','%'.$search.'%');
            })->with(['cadries','departmentstaff','departmentcadry'])->paginate(10, ['*'], 'page', $page);
            
            $alldepartments = Department::where('id','!=',4304)->where('organization_id', $org_id)
            ->with(['departmentstaff','departmentstaff.cadry'])->get();
        } else {
            $departments = Department::query()
                ->where('organization_id', $org_id)
                ->when(\Request::input('search'),function($query,$search){
                    $query
                    ->where('name','like','%'.$search.'%');
                })->with(['cadries','departmentstaff','departmentcadry'])->paginate(10, ['*'], 'page', $page);
            
            $alldepartments = Department::where('organization_id', $org_id)
            ->with(['departmentstaff','departmentstaff.cadry'])->get();
        }
        
        $a = []; $b = []; $plan = []; 
        foreach ($alldepartments as $item)
        {
            $z = 0; $q = 0; $x = 0; $y = 0;$p = 0; $q = 0;
            foreach($item->departmentstaff as $staff) {
                $x = $staff->stavka; $p = $p  + $x;
                $l = $staff->cadry->sum('stavka');
                $y = $staff->cadry->where('status_decret',false)->sum('stavka');
                if($x>$l) $z = $z + $x - $l;
                if($x<$y) $q = $q + $y - $x;
            }
            
            $a[$item->id] = $z;
            $b[$item->id] = $q;
            $all = $all + $z;
            $allSv =  $allSv + $q;
            $plan[$item->id] = $p;
        }
        
        return response()->json([
            'departments' => DepResource::collection($departments),
            'a' => $a,
            'b' => $b,
            'all' => $all,
            'allSv' => $allSv,
            'plan' => $plan
        ]);
    }
}
