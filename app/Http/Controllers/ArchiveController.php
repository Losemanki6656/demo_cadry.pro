<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\Department;
use App\Models\DepartmentStaff;
use App\Models\DepartmentCadry;
use App\Models\Career;
use App\Http\Resources\ArchiveCadryCollection;
use App\Http\Resources\ArchiveCadryResource;
use App\Http\Resources\DepResource;

class ArchiveController extends Controller
{
    public function archive_cadry(Request $request) 
    {
        if($request->pinfl) 
           {
                 $cadries = Cadry::query()
                    ->where('status', false)
                    ->when(\Request::input('pinfl'),function($query, $pinfl){
                        $query->where(function ($query) use ($pinfl) {
                            $query->Where('jshshir', 'LIKE', '%'. $pinfl .'%');
                        });
                    })
                    ->paginate(10);

                    return response()->json([
                        'status' => true,
                        'cadries' => new ArchiveCadryCollection($cadries),
                    ]);
           }
        else {
                return response()->json([
                    'status' => false,
                    'message' => "Xodim topilmadi!",
                ]);
             }
        

       
    }

    
    public function accept_get_cadry($archive_cadry_id)
    {
        $cadry = Cadry::find($archive_cadry_id);

        $departments = Department::where('organization_id',auth()->user()->userorganization->organization_id)->get();

        return response()->json([
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
            'archive_cadry' => new ArchiveCadryResource($cadry),
            'departments' => DepResource::collection($departments),
        ]);
    }

    public function save_archive_cadry($archive_cadry_id, Request $request)
    {
        $org = auth()->user()->userorganization;

        $dep = DepartmentStaff::with('cadry')->find($request->department_staff_id);

            $newItem = new DepartmentCadry();
            $newItem->railway_id = $org->railway_id;
            $newItem->organization_id = $org->organization_id;
            $newItem->department_id = $request->department_id;
            $newItem->department_staff_id = $request->department_staff_id;
            $newItem->staff_id = $dep->staff_id;
            $newItem->staff_full = $dep->staff_full;
            $newItem->staff_date = $request->staff_date;
            $newItem->staff_status = $request->staff_status;

            if($dep->stavka < $dep->cadry->sum('stavka') +  $request->rate) 
                $newItem->status_sv = true; 
            else
                $newItem->status_sv = false;

                $newItem->cadry_id = $archive_cadry_id;
                $newItem->stavka = $request->rate;
                $newItem->save();
                
                $cadr = Cadry::find($archive_cadry_id);
                $cadr->railway_id = $org->railway_id;
                $cadr->organization_id = $org->organization_id;
                $cadr->department_id = $request->department_id;
                $cadr->post_name = $dep->staff_full;
                $cadr->status = true;
                $cadr->save();

                $x = Career::where('cadry_id',$archive_cadry_id)->count();
                $y = new Career();
                $y->sort = $x + 1;
                $y->cadry_id = $archive_cadry_id;
                $y->date1 = date("Y", strtotime($request->staff_date));
                $y->date2 = '';
                $y->staff = $dep->staff_full;
                $y->save();

                return response()->json([
                    'message' => "Xodim ma'lumotlari muvaffaqqiyatli tiklandi!"
                ]);
    }
}
