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

   
   public function editVacation($id)
   {
      $item = Vacation::find($id);

      return view('vacations.editVacation',[
         'item' => $item
      ]);
   }

   public function editVacationPost($id, Request $request)
   {
      $sex = Cadry::find($request->cadry_id)->sex;

      if($sex == true && $request->status_vacation == 1)
         return redirect()->back()->with('msg' , 2);


      $item = Vacation::find($id);

      if($item->status_decret == 1 && $item->cadry_id != $request->cadry_id) 
      {
         $cadries = DepartmentCadry::where('cadry_id', $item->cadry_id)->get();
         foreach($cadries as $cadry){
            $cadry->status_decret = false;
            $cadry->save();
         }
      }

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

   public function deleteVacationPost(Request $request)
   {
      $item = Vacation::find($request->id);

      if($item->status_decret == 1) 
      {
         $cadries = DepartmentCadry::where('cadry_id', $item->cadry_id)->get();
         foreach($cadries as $cadry){
            $cadry->status_decret = false;
            $cadry->save();
         }
      }

      $item->delete();

      return response()->json(['status' => "Success"],200);
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
         $cadries = Cadry::SeFilter()
            ->select(['cadries.*', 'medical_examinations.*'])
            ->where('cadries.status',true)
            ->where('medical_examinations.status',true)
            ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
            ->orderBy('medical_examinations.date2')
            ->paginate(10);

         //dd($cadries);
         
      return view('vacations.meds',[
         'cadries' => $cadries
      ]);
   }

   public function AddInfoMed()
   {
      return view('vacations.AddInfoMed');
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

   public function addInfoMedSuccess(Request $request)
   {
      $meds = MedicalExamination::where('cadry_id', $request->cadry_id)->get();

      foreach ($meds as $item) {
         $item->status = false;
         $item->save();
      }
 
         MedicalExamination::create([
            'cadry_id' => $request->cadry_id,
            'date1' => $request->date1,
            'date2' => $request->date2, 
            'result' => $request->result ?? '',
            'status' => true
         ]); 
         
         return redirect()->route('meds')->with('msg' , 1);
   }
}
