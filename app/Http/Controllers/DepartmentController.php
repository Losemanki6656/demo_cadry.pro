<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentStaff;
use App\Models\DepartmentCadry;
use App\Models\Staff;
use App\Models\Cadry;
use App\Models\Classification;
use Auth;
use App\Http\Resources\DepartmentStaffResource;
use App\Http\Resources\DepartmentCadryResource;
use App\Http\Resources\DepartmentCadryCollection;
use App\Http\Resources\OrganizationCadryCollection;
use App\Http\Resources\OrgStaffResource;
use App\Http\Resources\OrgStaffCollection;


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
            
            Department::find($department_id)->delete();
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

    public function departments_cadries($department_id)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = DepartmentCadry::where('department_id',$department_id)->select('cadry_id')->groupBy('cadry_id')->pluck('cadry_id')->toArray();
        $items = Cadry::whereIn('id',$cadries)->paginate($per_page);

        return response()->json([
            'cadries' => new OrganizationCadryCollection($items),
            'status_vacation' => [
                [
                    'id' => 1,
                    'name' => "Mehnat ta'tili"
                ],
                [
                    'id' => 2,
                    'name' => "Bola parvarishlash ta'tili"
                ],
                [
                    'id' => 3,
                    'name' => "Ta'tilda emas"
                ]
            ],
        ]);
    }

    public function load_staffs(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $data = Staff::where('organization_id', Auth::user()->userorganization->organization_id)->paginate($per_page);

        if ($request->has('search')) {
            $search = $request->search;
            $data = Staff::where('organization_id', Auth::user()->userorganization->organization_id)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->paginate($per_page);
        }

        return response()->json(new OrgStaffCollection($data));
    }

    public function department_staffs($department_id)
    {
        $department = DepartmentStaff::where('department_id', $department_id)->with(['cadry','staff'])->get();

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
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        $cadries = DepartmentCadry::where('department_staff_id', $department_staff_id)->with('cadry')->paginate($per_page, ['*'], 'page', $page);

        return response()->json([
            'department_cadries' => new DepartmentCadryCollection($cadries),
            'status_vacation' => [
                [
                    'id' => 1,
                    'name' => "Mehnat ta'tili"
                ],
                [
                    'id' => 2,
                    'name' => "Bola parvarishlash ta'tili"
                ],
                [
                    'id' => 3,
                    'name' => "Ta'tilda emas"
                ]
            ],
        ]);
    }

    public function addCadryToDepartmentStaff($department_staff_id)
    {
        $depstaff = DepartmentStaff::with(['staff', 'department', 'classification', 'cadry'])->find($department_staff_id);

        return response()->json([
            'staff_name' => $depstaff->staff->name,
            'staff_fullname' => $depstaff->staff_full,
            'classification_name' => $depstaff->classification->name_uz ?? '',
            'plan_rate' => $depstaff->stavka,
            'fakt_rate' => $depstaff->cadry->sum('stavka'),
            'staff_statuts' => [
                [
                    'id' => 0,
                    'name' => "Asosiy"
                ],
                [
                    'id' => 1,
                    'name' => "O'rindosh"
                ]
                ],
        ]);
    }

    public function ApiaddCadryToDepartmentStaff($department_staff_id, Request $request)
    {
        $all = DepartmentCadry::where('cadry_id',$request->cadry_id)->where('staff_status',false)->get();
            if(count($all) && $request->staff_status == 0)  
                return response()->json([
                    'status' => false,
                    'message' => "Ushbu xodimda asosiy faoliyat turi mavjud!"
                ]);

            $dep = DepartmentStaff::with('cadry')->find($department_staff_id);

            $newItem = new DepartmentCadry();
            $newItem->railway_id = $dep->railway_id;
            $newItem->organization_id = $dep->organization_id;
            $newItem->department_id = $dep->department_id;
            $newItem->department_staff_id = $department_staff_id;
            $newItem->staff_id = $dep->staff_id;
            $newItem->staff_full = $dep->staff_full;
            $newItem->staff_date = $request->staff_date;
            $newItem->staff_status = $request->staff_status;
            if($dep->stavka < $dep->cadry->sum('stavka') +  $request->rate) 
                $newItem->status_sv = true; 
            else
                $newItem->status_sv = false;
                $newItem->cadry_id = $request->cadry_id;
                $newItem->stavka = $request->rate;
                $newItem->save();
                
            if($request->staff_status == 0) {
                $cadr = Cadry::find($request->cadry_id);
                $cadr->post_name = $dep->staff_full;
                $cadr->department_id = $dep->department_id;
                $cadr->staff_id = $dep->staff_id;
                $cadr->save();
            }

            if($request->career_status) {
               $x = Career::where('cadry_id',$request->cadry_id)->count();
               $y = new Career();
               $y->sort = $x + 1;
               $y->cadry_id = $request->cadry_id;
               $y->date1 = date("Y", strtotime($request->staff_date));
               $y->date2 = '';
               $y->staff = $dep->staff_full;
               $y->save();
            }
           

            return response()->json([
                'status' => true,
                'message' => "Xodim muvaffaqqiyatli qo'shildi!"
            ]);
    }
    
}
