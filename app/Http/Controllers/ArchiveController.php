<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\Department;
use App\Models\DepartmentStaff;
use App\Models\DepartmentCadry;
use App\Models\DemoCadry;
use App\Models\CadryCreate;
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

    public function archive_cadries() 
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = Cadry::query()
            ->where('status',false)
            ->where('organization_id', auth()->user()->userorganization->organization_id)
            ->when(request('last_name'), function ( $query, $last_name) {
                return $query->where('last_name', 'LIKE', '%'. $last_name .'%');
                
            })->when(request('middle_name'), function ( $query, $middle_name) {
                return $query->where('middle_name', 'LIKE', '%'. $middle_name .'%');
                
            })->when(request('first_name'), function ( $query, $first_name) {
                return $query->where('first_name', 'LIKE', '%'. $first_name .'%');

            })->when(request('department_id'), function ( $query, $department_id) {
                    return $query->where('department_id', $department_id);

            })->when(request('staff_id'), function ($query, $staff_id) {
                $arr = DepartmentCadry::where('staff_id',$staff_id)->pluck('cadry_id')->toArray();
                return $query->whereIn('id', $arr);

            })->when(request('education_id'), function ($query, $education_id) {
                return $query->where('education_id', $education_id);

            })->when(request('birth_region_id'), function ($query, $birth_region_id) {
                return $query->where('birth_region_id', $birth_region_id);

            })->when(request('sex'), function ($query, $sex) {
                if ($sex == "true") $z = true; else $z = false;
                return $query->where('sex', $z);

            })->when(request('age_start'), function ($query, $age_start) {
                return $query->whereYear('birht_date', '<=', now()->format('Y') - $age_start);

            })->when(request('age_end'), function ($query, $age_end) {
                return $query->whereYear('birht_date', '>=', now()->format('Y') - $age_end);

            })
            ->paginate($per_page);

        return response()->json([
            'cadries' => new ArchiveCadryCollection($cadries),
        ]);
     
       
    }

    public function archive_cadry_pinfl_update($archive_cadry_id, Request $request)
    {
        $cadry = Cadry::find($archive_cadry_id);

        $cadries = Cadry::where('id','!=',$archive_cadry_id)->where('jshshir', $request->pinfl);
        
        if($cadries->count() == 0) {
            $cadry->jshshir = $request->pinfl;
            $cadry->save();

            return response()->json([
                'status' => true,
                'message' => "Muvaffaqqiyatli o'zgartirildi!",
                'cadry' => null
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Bunday xodim mavjud!",
                'cadry' => new ArchiveCadryResource($cadries->first())
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
            $newItem->command_number = $request->command_number;

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

                $cadryCreate = new CadryCreate();
                $cadryCreate->railway_id = $org->railway_id;
                $cadryCreate->organization_id = $org->organization_id;
                $cadryCreate->cadry_id = $cadr->id;
                $cadryCreate->command_number = $request->command_number;
                $cadryCreate->comment = $request->comment;
                $cadryCreate->save();
        

                $x = Career::where('cadry_id', $archive_cadry_id)->count();
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
