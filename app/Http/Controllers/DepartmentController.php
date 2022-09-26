<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Auth;

use App\Http\Resources\DepartmentCollection;

class DepartmentController extends Controller
{

    public function departments()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $org_id = Auth::user()->userorganization->organization_id;

        $page = request('page', session('department_page', 1));
        session(['department_page' => $page]);

        if($org_id == 152) {
            $departments = Department::query()->where('id','!=',4304)
            ->where('organization_id', $org_id)
            ->when(\Request::input('search'),function($query,$search){
                $query
                ->where('name','like','%'.$search.'%');
            })->with(['cadries','departmentstaff','departmentcadry'])->paginate($per_page, ['*'], 'page', $page);
            
            $alldepartments = Department::where('id','!=',4304)->where('organization_id', $org_id)
            ->with(['departmentstaff','departmentstaff.cadry'])->get();
        } else {
            $departments = Department::query()
                ->where('organization_id', $org_id)
                ->when(\Request::input('search'),function($query,$search){
                    $query
                    ->where('name','like','%'.$search.'%');
                })->with(['cadries','departmentstaff','departmentcadry'])->paginate($per_page, ['*'], 'page', $page);
            
            $alldepartments = Department::where('organization_id', $org_id)
                ->with(['departmentstaff','departmentstaff.cadry'])->get();
        }
        
        return response()->json([
            'departments' => new DepartmentCollection($departments)
        ]);
    }
}
