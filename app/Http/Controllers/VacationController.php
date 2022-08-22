<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\DepartmentCadry;
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
}
