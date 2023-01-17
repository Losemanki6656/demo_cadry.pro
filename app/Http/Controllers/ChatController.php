<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Classification;
use App\Models\DepartmentStaff;
use App\Models\Department;
use App\Models\Cadry;
use App\Models\Region;
use App\Models\DepartmentCadry;
use App\Models\MedicalExamination;
use App\Models\Organization;
use App\Models\Railway;
use App\Models\DeleteCadry;
use Auth;
use Illuminate\Http\Request;
use DB;
use URL;
use App\Models\Career;

class ChatController extends Controller
{
    public function index()
    {
        return view('filemanager.chat');
    }

    public function loadClassification(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Classification::where('name_uz', 'LIKE', "%$search%")
                ->OrWhere('code_staff', 'LIKE', "%$search%")
                ->take(50)->get();
        }
        return response()->json($data);
    }

    public function loadCadry(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Cadry::OrgFilter()
                ->where(function ($query) use ($search) {
                    $query->Orwhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('middle_name', 'like', '%' . $search . '%');
                })
                ->get();
        }
        return response()->json($data);
    }



    public function loadDepartment(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = Department::where('organization_id', Auth::user()->userorganization->organization_id)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->get();
        }
        return response()->json($data);
    }

    public function loadStaff(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = Staff::where('organization_id', Auth::user()->userorganization->organization_id)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->get();
        }
        return response()->json($data);
    }

    public function loadRegion(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = Region::where('name', 'like', '%' . $search . '%')->get();
        }
        return response()->json($data);
    }

    public function addstaffToDepartment($id)
    {
        $org_id = Auth::user()->userorganization->organization_id;
        $department = Department::find($id);
        $staffs = Staff::where('organization_id', $org_id)->get();
        $depstaff = DepartmentStaff::where('department_id', $id)->with(['department', 'staff', 'cadry'])->get();

        return view('cadry.addstaffdep', [
            'staffs' => $staffs,
            'depstaff' => $depstaff,
            'department' => $department
        ]);
    }

    public function stafftoDepartment(Request $request)
    {
        $newItem = new DepartmentStaff();
        $newItem->railway_id = Auth::user()->userorganization->railway_id;
        $newItem->organization_id = Auth::user()->userorganization->organization_id;
        $newItem->department_id = $request->department_id;
        $newItem->staff_id = $request->staff_id;
        if ($request->class_staff_id)
            $newItem->classification_id = $request->class_staff_id;
        $newItem->staff_full = $request->staff_full;
        $newItem->stavka = $request->st_1;
        if ($request->status_sv == 'on') {
            $newItem->status = true;
        }
        $newItem->save();

        return redirect()->back()->with('msg', 1);
    }

    public function department_cadry_add($id)
    {
        $depstaff = DepartmentStaff::with(['staff', 'department', 'classification', 'cadry'])->find($id);

        return view('cadry.addCadryToDepartmentStaff', [
            'depstaff' => $depstaff
        ]);
    }

    public function addCadryToDepartmentStaff($id, Request $request)
    {
        
        $all = DepartmentCadry::where('cadry_id',$request->cadry_id)->where('staff_status',false)->get();
            if(count($all) && $request->staff_status == 0)  return redirect()->back()->with('msg', 1);

        $dep = DepartmentStaff::with('cadry')->find($id);

            $newItem = new DepartmentCadry();
            $newItem->railway_id = $dep->railway_id;
            $newItem->organization_id = $dep->organization_id;
            $newItem->department_id = $dep->department_id;
            $newItem->department_staff_id = $id;
            $newItem->staff_id = $dep->staff_id;
            $newItem->staff_full = $dep->staff_full;
            $newItem->staff_date = $request->staff_date;
            $newItem->staff_status = $request->staff_status;
            if($dep->stavka < $dep->cadry->sum('stavka') +  $request->st_1) 
                $newItem->status_sv = true; 
            else
                $newItem->status_sv = false;
                $newItem->cadry_id = $request->cadry_id;
                $newItem->stavka = $request->st_1;
                $newItem->save();
                
            if($request->staff_status == 0) {
                $cadr = Cadry::find($request->cadry_id);
                $cadr->post_name = $dep->staff_full;
                $cadr->department_id = $dep->department_id;
                $cadr->staff_id = $dep->staff_id;
                $cadr->save();
            }

            if($request->careerCheck) {
               $x = Career::where('cadry_id',$request->cadry_id)->count();
               $y = new Career();
               $y->sort = $x + 1;
               $y->cadry_id = $request->cadry_id;
               $y->date1 = date("Y", strtotime($request->staff_date));
               $y->date2 = '';
               $y->staff = $dep->staff_full;
               $y->save();
            }
           

            return redirect()->route('addstaffToDepartment', ['id' => $dep->department_id])->with('msg', 1);
    }

    public function department_staffs($id)
    {
        $cadries = DepartmentCadry::where('department_staff_id', $id)->with('cadry')->get();

        return view('cadry.DepartmentCadries', [
            'cadries' => $cadries
        ]);
    }

    public function deleteDepStaff(Request $request)
    {
        if (DepartmentCadry::where('department_staff_id', $request->id)->count()) {
            return response()->json([
                'message' => "error"
            ], 500);
        } else {
            DepartmentStaff::find($request->id)->delete();
            return response()->json([
                'message' => "Muvaffaqqiyatli o'chirildi!"
            ], 200);
        }
    }

    public function editCadryStaff($id)
    {
        $item = DepartmentStaff::find($id);
        $staffs = Staff::where('organization_id',auth()->user()->userorganization->organization_id)->get();
        return view('cadry.editstaffCadry', [
            'item' => $item,
            'staffs' => $staffs
        ]);
    }

    public function StaffCadryEdit($id)
    {
        $item =  DepartmentCadry::find($id);

        $staffs = DepartmentStaff::where('department_id',$item->department_id)->get();

        return view('cadry.StaffCadryEdit', [
            'item' => $item,
            'staffs' => $staffs
        ]);
    }

    public function deleteStaffCadry($id)
    {
        $item =  DepartmentCadry::with('cadry')->find($id);

        $careers = Career::where('cadry_id',$item->cadry_id)->orderBy('id', 'desc')->get();

        return view('cadry.deleteStaffCadry', [
            'item' => $item,
            'careers' => $careers
        ]);
    }

    public function SuccessDeleteCadryStaff($id, Request $request)
    {
        $item =  DepartmentCadry::with('cadry')->find($id);

        $newDelCadry = new DeleteCadry();
        $newDelCadry->railway_id = $item->railway_id;
        $newDelCadry->organization_id = $item->organization_id;
        $newDelCadry->department_id = $item->department_id;
        $newDelCadry->cadry_id = $item->cadry_id;
        $newDelCadry->number = $request->number;
        $newDelCadry->comment = $request->comment;
        $newDelCadry->staff_full = $item->staff_full;
        $newDelCadry->date = $item->del_date;
        $newDelCadry->save();

        $car = Career::find($request->career);
        $car->date2 = date("Y", strtotime($request->del_date));
        $car->save();

        $item->delete();

        return redirect()->route('cadry_edit',['id' =>  $item->cadry_id])->with('msg' , 4);


    }

    public function loadVacan(Request $request)
    {
        
        $data = DepartmentStaff::where('department_id', $request->department_id)->with('staff')->get();

        return response()->json($data, 200);
    }

    public function successEditStaffCadry($id, Request $request)
    {
        $newItem = DepartmentCadry::find($id);
        $editstaff = DepartmentStaff::with('cadry')->find($request->staff_id);

        $x = 0;
        $vakant = DepartmentCadry::where('department_staff_id',$request->staff_id)->where('staff_status', false )->get();
        foreach ($vakant as $item) {
            if($item->cadry_id != $newItem->cadry_id) $x ++;
        }

                $newItem->department_id = $request->department_id;
                $newItem->department_staff_id = $request->staff_id;
                $newItem->staff_id = $editstaff->staff_id;
                $newItem->staff_full = $editstaff->staff_full;
                $newItem->staff_status = $request->staff_status;
                $newItem->staff_date = $request->staff_date;

                if($editstaff->stavka <= $editstaff->cadry->sum('stavka') + $request->st_1) 
                    $newItem->status_sv = true; 
                else
                    $newItem->status_sv = false;

                $newItem->stavka = $request->st_1;
                $newItem->save();

                $cadry = Cadry::find($newItem->cadry_id);
                $cadry->department_id = $request->department_id;
                $cadry->staff_id = $editstaff->staff_id;

                if($request->staff_status == 0)
                    $cadry->post_name = $editstaff->staff_full;

                $cadry->post_date = $request->staff_date;
                $cadry->save();

                if($request->careerCheck == 'on') {
                    $careerItem = Career::find($request->career);
                    $careerItem->date2 = date("Y", strtotime($request->staff_date));
                    $careerItem->save();

                    $itC = new Career();
                    $itC->cadry_id = $newItem->cadry_id;
                    $itC->sort = $careerItem->sort + 1;
                    $itC->date1 =  date("Y", strtotime($request->staff_date));
                    $itC->date2 = '';
                    $itC->staff = $editstaff->staff_full;
                    $itC->save();

                }

                return back()->with('msg', 1);

    }

    public function editDepStaff($id,Request $request) 
    {
        $newItem = DepartmentStaff::find($id);
        $newItem->staff_full = $request->staff_full;
        $newItem->staff_id = $request->staff_id;
        $newItem->stavka = $request->st_1;
        if($request->class_staff_id) {
            $newItem->classification_id  = $request->class_staff_id;
        }
        $newItem->save();

        $cadries = DepartmentCadry::where('department_staff_id',$id)->get();
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

        return redirect()->back()->with('msg', 1);
    }

    public function editcadryStaffStatus($id, Request $request)
    {
        $item = DepartmentCadry::find($id);
        $item->stavka = $request->st_1;
        if($request->status_sv == 'on') {
            $item->status_sv = true;
        } else $item->status_sv = false;
        if($request->status_decret == 'on') {
            $item->status = true;
        } else $item->status = false;
        if($request->sdec == 'on') {
            $item->status_decret = true;
        } else $item->status_decret = false;
        $item->save();

        $cadry = Cadry::find($item->cadry_id);
        $cadry->department_id = $item->department_id;
        $cadry->save();

         return redirect()->back()->with('msg', 1);
    }

    public function control()
    {
        $orgs = \App\Models\Railway::query()
            ->withCount(['cadries' => function ($query) {
                $query->where('status', true);
            }])
            ->get();
       
    }

    public function api_control()
    {
        $orgs = \App\Models\Railway::query()
            ->withCount(['cadries' => function ($query) {
                $query->where('status', true);
            }])
            ->get();

            $a = [];
            foreach($orgs as $item) {
                $cadry30 = Cadry::where('railway_id', $item->id)->where('status', true)->whereYear('birht_date', '>=', 1992)->count();
                $cadry30_women = Cadry::where('railway_id', $item->id)->where('status', true)->whereYear('birht_date', '>=', 1992)->where('sex', false)->count();
                $cadry30_leaders = Cadry::where('railway_id', $item->id)->where('status', true)->whereYear('birht_date', '>=', 1992)->where('post_name', 'LIKE', '%boshli%')->count();
                $a[] = [
                    'id' => $item->id,
                    'name' =>  $item->name,
                    'cadries_count' => $item->cadries_count,
                    'cadry30_all' => $cadry30,
                    'cadry30_man' => $cadry30 - $cadry30_women,
                    'cadry30_women' => $cadry30_women,
                    'cadry30_leaders' => $cadry30_leaders,

                ];
            }
            return response()->json($a);
       
    }


    public function xx()
    {
        $orgs = \App\Models\Organization::query()
            ->where('railway_id', '!=',3)
            ->withCount(['cadries' => function ($query) {
                $query->has('staff_category', '=', 0);
            }])
            ->get();

            $a = []; $i = 0;
        foreach ($orgs as $item){
            $i ++;
            $a[$i] = $item->name . '#' . $item->cadries_count;
        }

        dd($a);

        $railways = Railway::all();
        $u = [];
        foreach ( $railways as $rail) {
           
            $organizations = Organization::where('railway_id',$rail->id)->get();
            
            $p = 0; $fakt = 0; $all = 0; $allSv = 0; $car = 0; $rel = 0; $med = 0;
            foreach($organizations as $organ)
            {
                
                $org_id = $organ->id;
    
                $careersCount = Cadry::where('organization_id', $org_id)->where('status',true)->has('careers', '=', 0)->count();
                $relativesCount = Cadry::where('organization_id', $org_id)->where('status',true)->has('relatives', '=', 0)->count();
                $mednotCount = Cadry::where('organization_id', $org_id)->where('status',true)->has('med','=',0)->count();
                $car = $car + $careersCount;
                $rel = $rel + $relativesCount;
                $med = $med + $mednotCount;
               
    
                if($org_id == 152) {
                    
                    $alldepartments = Department::where('id','!=',4304)->where('organization_id', $org_id)
                    ->with(['departmentstaff','departmentstaff.cadry'])->get();
                } else {
                    
                    $alldepartments = Department::where('organization_id', $org_id)
                    ->with(['departmentstaff','departmentstaff.cadry'])->get();
                }
                
                foreach ($alldepartments as $item)
                {
                    $z = 0; $q = 0; $x = 0; $y = 0; $q = 0;
                    foreach($item->departmentstaff as $staff) {
                        $x = $staff->stavka;
                        $p = $p + $x;
                        $l = $staff->cadry->sum('stavka');
                        $y = $staff->cadry->where('status', false)->sum('stavka');
                        $fakt = $fakt + $y;
                        if($x>$l) $z = $z + $x - $l;
                        if($x<$y) $q = $q + $y - $x;
                    }
                    
                    $all = $all + $z;
                    $allSv =  $allSv + $q;
                }
            }
            
            $u[$org_id] = $rail->name . '#' . $p . '#' . $fakt . '#' . $all . '#' . $allSv . '#' . $car . '#' . $rel . '#' . $med;
          
        }
        
        dd($u);
    }
}
