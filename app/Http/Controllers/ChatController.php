<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Classification;
use App\Models\DepartmentStaff;
use App\Models\Department;
use App\Models\Cadry;
use App\Models\Region;
use App\Models\DepartmentCadry;
use Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('filemanager.chat');
    }

    public function loadClassification(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Classification::where('name_uz','LIKE',"%$search%")
            ->OrWhere('code_staff','LIKE',"%$search%")
            ->take(50)->get();
        }
        return response()->json($data);
    }

    public function loadCadry(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Cadry::OrgFilter()
                    ->where(function ($query) use ($search) {
                        $query->Orwhere('last_name','like','%'.$search.'%')
                            ->orWhere('first_name','like','%'.$search.'%')
                            ->orWhere('middle_name','like','%'.$search.'%');
                    })
                ->get();
        }
        return response()->json($data);
    }

    public function loadDepartment(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = Department::where('organization_id', Auth::user()->userorganization->organization_id)
                    ->where(function ($query) use ($search) {
                        $query->where('name','like','%'.$search.'%');
                    })
                ->get();
        }
        return response()->json($data);
    }

    public function loadStaff(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = Staff::where('organization_id', Auth::user()->userorganization->organization_id)
                    ->where(function ($query) use ($search) {
                        $query->where('name','like','%'.$search.'%');
                    })
                ->get();
        }
        return response()->json($data);
    }

    public function loadRegion(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = Region::where('name','like','%'.$search.'%')->get();
        }
        return response()->json($data);
    }

    public function addstaffToDepartment($id)
    {
        $org_id = Auth::user()->userorganization->organization_id;
        $department = Department::find($id);
        $staffs = Staff::where('organization_id',$org_id)->get();
        $depstaff = DepartmentStaff::where('department_id',$id)->with(['department','staff','cadry'])->get();

        return view('cadry.addstaffdep',[
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
        $newItem->classification_id = $request->class_staff_id;
        $newItem->staff_full = $request->staff_full;
        $newItem->stavka = $request->st_1 + $request->st_2;
        if($request->status_sv == 'on') {
            $newItem->status = true;
        }
        $newItem->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function department_cadry_add($id)
    {
        $depstaff = DepartmentStaff::with(['staff','department','classification','cadry'])->find($id);

        return view('cadry.addCadryToDepartmentStaff',[
            'depstaff' => $depstaff
        ]);
    }

    public function addCadryToDepartmentStaff($id, Request $request)
    {
        $dep = DepartmentStaff::with('cadry')->find($id);
        
        if($request->st_1 + $request->st_2 <= $dep->stavka - $dep->cadry->sum('stavka'))
            {
                $newItem = new DepartmentCadry();
                $newItem->railway_id = $dep->railway_id;
                $newItem->organization_id = $dep->organization_id;
                $newItem->department_id = $dep->department_id;
                $newItem->department_staff_id = $id;
                $newItem->staff_id = $dep->staff_id;
                $newItem->staff_full = $dep->staff_full;
                $newItem->status_sv = $dep->status;
                $newItem->cadry_id = $request->cadry_id;
                $newItem->stavka = $request->st_1 + $request->st_2;
                $newItem->save();

                return redirect()->route('addstaffToDepartment',['id' => $dep->department_id])->with('msg' , 1);
            } else  return redirect()->back()->with('msg' ,1);

    }

    public function department_staffs($id)
    {
        $cadries = DepartmentCadry::where('department_staff_id', $id)->with('cadry')->get();

        return view('cadry.DepartmentCadries',[
            'cadries' => $cadries
        ]);
    }

    public function deleteDepCadry(Request $request)
    {
        DepartmentCadry::find($request->id)->delete();

        return response()->json([
            'message' => "Muvaffaqqiyatli o'chirildi!"
        ], 200);
    }

    public function deleteDepStaff(Request $request)
    {
        if(DepartmentCadry::where('department_staff_id',$request->id)->count()) {
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
        $cadries = DepartmentCadry::where('cadry_id', $id)->with(['staff','department'])->get();

        return view('cadry.editstaffCadry',[
            'cadries' => $cadries
        ]);
    }

    public function StaffCadryEdit($id)
    {
        $item =  DepartmentCadry::find($id);

        return view('cadry.StaffCadryEdit',[
            'item' => $item
        ]);
    }
}
