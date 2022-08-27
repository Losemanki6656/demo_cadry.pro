<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\DepartmentCadry;
use App\Models\MedicalExamination;
use App\Models\Cadry;
use Auth;

class VacationController extends Controller
{

   public function vacations()
   {
      $cadries = Vacation::Filter()->paginate(10);

      return view('vacations.vacations',[
         'cadries' => $cadries
      ]);
   }

   public function addVacation()
   {

      return view('vacations.addVacation');
   }
    
   public function addVacationsucc(Request $request)
   {
      $sex = Cadry::find($request->cadry_id)->sex;

      if($sex == true && $request->status_vacation == 1)
         return redirect()->back()->with('msg' , 2);

      $org_id = auth()->user()->userorganization->organization_id;
      $railway_id = auth()->user()->userorganization->railway_id;

      $vacations = Vacation::where('cadry_id',$request->cadry_id)->where('status',true)->get();
      foreach($vacations as $vac){
          $vac->status = false;
          $vac->save();
      }

      $item = new Vacation();
      $item->railway_id = $railway_id;
      $item->organization_id = $org_id;
      $item->cadry_id = $request->cadry_id;
      $item->date1 = $request->date1;
      if($request->status_vacation == 1)
         $item->date2 = date('Y-m-d', strtotime(now()->addYear(2))); 
      else
         $item->date2 = $request->date2 ?? now();
      $item->status = true;
      $item->status_decret = $request->status_vacation;
      $item->save();
      
      if($request->status_vacation == 1) 
      {
         $cadries = DepartmentCadry::where('cadry_id', $request->cadry_id)->get();
         foreach($cadries as $cadry){
            $cadry->status_decret = true;
            $cadry->save();
         }
      }

      return redirect()->route('vacations')->with('msg' , 1);
   }

   
   public function meds()
   {
      $cadries = Cadry::query()
         ->where('organization_id',auth()->user()->userorganization->organization_id)
         ->where('status', true)
         ->when(\Request::input('name_se'),function($query,$name_se){
            $query->where(function ($query) use ($name_se) {
               $query->orWhere('last_name', 'LIKE', '%'. $name_se .'%')
                     ->orWhere('first_name', 'LIKE', '%'.$name_se.'%')
                     ->orWhere('middle_name', 'LIKE', '%'.$name_se.'%');
               
            });
         })
         ->with('med')
         ->paginate(10);

      
      return view('vacations.meds',[
         'cadries' => $cadries
      ]);
   }

   public function editMed($id, Request $request)
   {
      $validated = $request->validate([
            'date1' => ['required', 'date'],
            'date2' => ['required', 'date'],
      ]);

      $med = MedicalExamination::where('status',true)->where('cadry_id', $id)->first();

      $med->update([
         'date1' => $request->date1,
         'date2' => $request->date2, 
         'result' => $request->result ?? ''
      ]); 

      return back()->with('msg' , 1);
   }

   public function AddMed($id, Request $request)
   {
      $meds = MedicalExamination::where('cadry_id', $id)->get();

      foreach ($meds as $item) {
         $item->status = false;
         $item->save();
      }
 
         MedicalExamination::create([
            'cadry_id' => $id,
            'date1' => $request->date1,
            'date2' => $request->date2, 
            'result' => $request->result ?? '',
            'status' => true
         ]); 
         
         return back()->with('msg' , 1);
   }
}
