<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VacationIntegration;
use App\Models\Cadry;
use App\Models\Vacation;
use App\Http\Resources\VacationIntegrationResource;

class VacationIntegrationController extends Controller
{
    
    public function vacations_1c_api()
    {
        $org_id = auth()->user()->userorganization->organization_id;
        $vacations = VacationIntegration::where('status',true)->where('status_suc',false)->where('organization_id',$org_id)->with('cadry')->get();

        return response()->json([
            'vacations' => VacationIntegrationResource::collection($vacations)
        ]);
    }

    public function vacations_1c_api_success($id)
    {
        $vacation = VacationIntegration::find($id);
        if(!$vacation)  return response()->json([
            'message' => 'vacation not found!'
        ],404);

        $vacation->status_suc = true;
        $vacation->save();

        $vacs = Vacation::where('cadry_id',$vacation->cadry_id)->where('status',true)->get();
        
        foreach($vacs as $vac){
            $vac->status = false;
            $vac->save();
        }

        $item = new Vacation();
        $item->railway_id = $vacation->railway_id;
        $item->organization_id = $vacation->organization_id;
        $item->cadry_id = $vacation->cadry_id;
        $item->date1 = $vacation->date1;
        $item->date2 = $vacation->date2;
        $item->status = true;
        $item->status_decret = 0;
        $item->save();
        
        return response()->json([
            'message' => 'successfully accepted!'
        ]);
    }

    public function vacations_1c_api_refuse($id)
    {
        $vacation = VacationIntegration::find($id);
        if(!$vacation)  return response()->json([
            'message' => 'vacation not found!'
        ],404);

        $vacation->status = false;
        $vacation->save();

        return response()->json([
            'message' => 'successfully refused!'
        ]);
    }

    public function vacations_1c() 
    {
        $cadries = VacationIntegration::Filter()->paginate(10);

        return view('vacations.vacations1c',[
            'cadries' => $cadries
        ]);
    }

    public function addVacation1C(Request $request)
    {

        $validator = VacationIntegration::where('status_suc',false)->where('cadry_id',$request->cadrySeach)->get();

        if(count($validator) > 0)
        {
            return redirect()->back()->with('msg', 3);

        } else {
            $cadry = Cadry::find($request->cadrySeach);

            $newItem = new VacationIntegration();
            $newItem->railway_id = $cadry->railway_id;
            $newItem->organization_id = $cadry->organization_id;
            $newItem->department_id = $cadry->department_id;
            $newItem->cadry_id = $request->cadrySeach;
            $newItem->number_order = $request->pr_number;
            $newItem->main_day = $request->main_day;
            $newItem->for_staff = $request->for_staff;
            $newItem->for_experience = $request->for_experience;
            $newItem->for_climate = $request->for_climate;
            $newItem->for_other = $request->for_other;
            $newItem->for_hardwork = $request->for_hardwork;

            if($request->underage) $newItem->underage = 30;
            if($request->invalid) $newItem->invalid = 30;
            if($request->invalid_child) $newItem->invalid_child = 3;
            if($request->childrens) $newItem->childrens = 3;
            if($request->donor) $newItem->donor = 2;
            if($request->more) $newItem->more = 3;
            
            $newItem->period1 = $request->period1;
            $newItem->period2 = $request->period2;
            $newItem->date1 = $request->date1_1c;
            $newItem->date2 = $request->date2_1c;
            $newItem->alldays = $request->all_day;

            $newItem->save();

            return redirect()->route('vacations')->with('msg' , 1);
        }
    }

    public function deleteVacIntro($id)
    {
        VacationIntegration::find($id)->delete(); 
        
        return redirect()->back()->with('msg', 4);

    }
}
