<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentStaff;
use App\Models\DepartmentCadry;
use App\Models\Cadry;
use App\Models\Classification;
use Auth;
use App\Http\Resources\DepartmentStaffResource;
use App\Http\Resources\DepartmentCadryResource;

use App\Http\Resources\DepartmentCollection;

class DepartmentController extends Controller
{

    public function add_department(Request $request)
    {
        $organ = auth()->user()->userorganization;

        $addDepartment = new Department();
        $addDepartment->railway_id = $organ->railway_id;
        $addDepartment->organization_id = $organ->organization_id;
        $addDepartment->name = $request->name ?? '';
        $addDepartment->save();

        return response()->json([
            'message' => "Bo'lim muvaffaqqiyatli qo'shildi!"
        ]);
    }
    public function update_department(Request $request, $department_id)
    {
        $editDepartment =  Department::find($department_id);
        $editDepartment->name = $request->name;
        $editDepartment->save();

        return response()->json([
            'message' => "Bo'lim muvaffaqqiyatli yangilandi!"
        ]);
    }

    public function delete_department($department_id)
    {
        if (DepartmentCadry::where('department_id', $department_id)->count()) {
        
            return response()->json([
                'message' => "Ushbu bo'limga tegishli xodimlar mavjud!"
            ], 422);
    
        } else {
            
            Department::find($id)->delete();
            return response()->json([
                'message' => "Muvaffaqqiyatli o'chirildi!"
            ], 200);
    
        }
    }

    

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

    public function department_staffs($department_id)
    {
        $department = DepartmentStaff::where('department_id', $department_id)->with(['cadry'])->get();

        return response()->json([
            'department' => DepartmentStaffResource::collection($department)
        ]);
    }

    public function load_classifications(Request $request)
    {
        $data = [];

        if ($request->has('search')) {
            $search = $request->search;
            $data = Classification::where('name_uz', 'LIKE', "%$search%")
                ->OrWhere('code_staff', 'LIKE', "%$search%")
                ->take(50)->get();
        }
        return response()->json($data);
    }

    public function departmentStaffCreate($department_id, Request $request)
    {
        $org = auth()->user()->userorganization;

        $newItem = new DepartmentStaff();
        $newItem->railway_id = $org->railway_id;
        $newItem->organization_id = $org->organization_id;
        $newItem->department_id = $department_id;
        $newItem->staff_id = $request->staff_id;

        if ($request->class_staff_id)
            $newItem->classification_id = $request->class_staff_id;
        $newItem->staff_full = $request->staff_full;
        $newItem->stavka = $request->rate;
        if ($request->status_sv == 'on') {
            $newItem->status = true;
        }
        $newItem->save();

        return response()->json([
            'status' => true,
            'message' => "Lavozim Muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function departmentStaffUpdate($department_staff_id, Request $request)
    {

        $newItem = DepartmentStaff::find($department_staff_id);
        $newItem->staff_full = $request->staff_full;
        $newItem->staff_id = $request->staff_id;
        $newItem->stavka = $request->rate;
        if($request->class_staff_id) {
            $newItem->classification_id  = $request->class_staff_id;
        }
        $newItem->save();

        $cadries = DepartmentCadry::where('department_staff_id',$department_staff_id)->get();

        foreach($cadries as $item) {
            $item->staff_full = $request->staff_full;
            $item->staff_id = $request->staff_id;
            $item->save();

            if($item->staff_status == 0) {
                $cadry = Cadry::find($item->cadry_id);
                $cadry->post_name = $request->staff_full;
                $cadry->save();
            }
            
        }
        return response()->json([
            'status' => true,
            'message' => "Lavozim Muvaffaqqiyatli yangilandi!"
        ]);
    }

    public function departmentStaffDelete(DepartmentStaff $department_staff_id)
    {
        try {

            $department_staff_id->delete();

            return response()->json([
                'status' => true,
                'message' => "Lavozim Muvaffaqqiyatli yangilandi!"
            ]);
            
        } catch (\Exception $e) {
           
            report($e);
     
            return response()->json([
                'status' => false,
                'message' => "O'chirish imkoniyati mavjud emas . Lavozimga tegishli xodimlar mavjud!"
            ]);
        }
    }

    public function department_staff_caddries($department_staff_id)
    {
        $cadries = DepartmentCadry::where('department_staff_id', $department_staff_id)->with('cadry')->get();

        return response()->json([
            'department_cadries' => DepartmentCadryResource::collection($cadries)
        ]);
    }
}
