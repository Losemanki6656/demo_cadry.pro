<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Category;
use App\Models\DepartmentCadry;
use App\Models\DepartmentStaff;
use App\Models\Cadry;
use Auth;


use App\Http\Resources\StaffOrgResource;
use App\Http\Resources\StaffOrgCollection;

class StaffController extends Controller
{
    public function api_staff_positions(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $staffs = Staff::query()
        ->where('organization_id', Auth::user()->userorganization->organization_id)
        ->where('status',true)
        ->when(\Request::input('name'),function($query,$search){
            $query
            ->where('name','like','%'.$search.'%');
        })
        ->with(['cadries','departments'])->paginate($per_page);

        return response()->json([
            'staffs' => new StaffOrgCollection($staffs)
        ]);
    }

    public function api_categories()
    {
        $categories = Category::all();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function api_add_staff(Request $request)
    {
        $organ = auth()->user()->userorganization;

        $addstaff = new Staff();
        $addstaff->railway_id = $organ->railway_id;
        $addstaff->organization_id = $organ->organization_id;
        $addstaff->name = $request->name ?? '';
        $addstaff->category_id = $request->category_id ?? 1;
        $addstaff->staff_count = 1;
        $addstaff->save();

        return response()->json([
            'message' => "Lavozim muvaffaqqiyatli qo'shildi !",
        ]);
    }

    public function api_update_staff($staff_id, Request $request)
    {
        $addstaff = Staff::find($staff_id);
        $addstaff->name = $request->name ?? '';
        $addstaff->category_id = $request->category_id ?? 1;
        $addstaff->save();

        return response()->json([
            'message' => "Lavozim muvaffaqqiyatli yangilandi !",
        ]);
    }

    public function api_delete_staff($staff_id)
    {
        $staff = Staff::find($staff_id);
                            $staff->status = false;
                            $staff->save();

                            return response()->json([
                                'status' => true,
                                'message' => "Muvaffaqqiyatli o'chirildi!"
                            ], 200);
                            
        if (DepartmentCadry::where('staff_id', $staff_id)->count() ) {
        
            return response()->json([
                'status' => false,
                'message' => "Ushbu lavozimga tegishli xodimlar mavjud!"
            ], 403);
    
        } else
                if (DepartmentStaff::where('staff_id', $staff_id)->count() ) {
            
                return response()->json([
                    'status' => false,
                    'message' => "Ushbu lavozim bo'limga biriktirilgan!"
                ], 403);
        
            } else {

                    $x = Cadry::where('staff_id', $staff_id)->where('status',true);
                    if( $x->count()) {
                        return response()->json([
                            'status' => false,
                            'message' => "Ushbu lavozimga tegishli xodim mavjud. Xodim ma'lumotlarini taxrirlab chiqishingiz zarur!",
                        ], 403);

                    } else {
                            $staff = Staff::find($staff_id);
                            $staff->status = false;
                            $staff->save();

                            return response()->json([
                                'status' => true,
                                'message' => "Muvaffaqqiyatli o'chirildi!"
                            ], 200);
                        }
    
        }
       
    }

    
}
