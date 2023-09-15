<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\DepartmentCadry;
use App\Models\MedicalExamination;
use App\Models\Cadry;
use App\Models\Holiday;
use App\Models\Organization;
use Auth;
use App\Http\Resources\VacationCadryResource;
use App\Http\Resources\VacationCadryCollection;
use App\Http\Resources\CadrySearchCollection;
use App\Http\Resources\VaccResource;

class VacationController extends Controller
{

   public function vacations()
   {
      $cadries = Vacation::Filter()->paginate(10);

      return view('vacations.vacations',[
         'cadries' => $cadries
      ]);
   }

   public function api_cadry_vacations($cadry_id)
   {
      $vacations = Vacation::where('cadry_id',$cadry_id)->get();

      return response()->json([
         'vacations' => VaccResource::collection($vacations)
      ]);
   }

   public function api_cadry_vacations_delete(Vacation $vacation_id)
   {
      $vacation_id->delete();

      return response()->json([
         'message' => "Muvaffaqqiyatli o'chirildi!"
      ]);
   }

   public function loadCadryApi(Request $request)
   {
      if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;
      
       $data = [];

       if ($request->has('search')) {
           $search = $request->search;
           $data = Cadry::OrgFilter()
               ->where(function ($query) use ($search) {
                   $query->where('last_name', 'like', '%' . $search . '%')
                       ->orWhere('first_name', 'like', '%' . $search . '%')
                       ->orWhere('middle_name', 'like', '%' . $search . '%');
               })
               ->paginate($per_page);
       }
       return response()->json(new CadrySearchCollection($data));
   }

   public function api_vacations()
   {
      if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

      $page = request('page', session('cadry_page', 1));
      session(['cadry_page' => $page]);

      $cadries = Vacation::Filter()->paginate($per_page, ['*'], 'page', $page);

      return response()->json([
         'cadries' => new VacationCadryCollection($cadries)
      ]);
   }

   public function api_vacations_add()
   {

      return response()->json([
         'status_decret' => [
            [
                'id' => 0,
                'name' => "Mehnat ta'tili"
            ],
            [
                'id' => 1,
                'name' => "Bola parvarishlash ta'tili"
            ],
            [
               'id' => 2,
               'name' => "Xomiladorlik va tug'ish ta'tili"
            ],
            [
               'id' => 3,
               'name' => "Ish haqi saqlanmaydigan ta'til"
            ],
            [
               'id' => 4,
               'name' => "Ish haqi qisman saqlanadigan ta'til"
            
            ],
            [
               'id' => 5,
               'name' => "O'quv ta'tili"
            
            ],
            [
               'id' => 6,
               'name' => "Ijodiy ta'tili"
            
            ],
            [
               'id' => 7,
               'name' => "Kasallik ta'tili"
            
            ]
      ]
            ]);
   }

   public function api_vacations_add_post(Request $request)
   {

      $sex = Cadry::find($request->cadry_id)->sex;

      if($sex == true && $request->status_decret == 1)
         return response()->json([
            'status' => false,
            'message' => "Xodimning jinsi ta'til turiga to'g'ri kelmaydi!"
         ]);

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
      if($request->status_decret == 1)
         if(!$request->date2)
            $item->date2 = date('Y-m-d', strtotime(now()->addYear(2))); 
         else
            $item->date2 = $request->date2;
      else
         $item->date2 = $request->date2 ?? now();
      $item->command_number = $request->command_number;
      $item->period1 = $request->period1;
      $item->period2 = $request->period2;
      $item->alldays = $request->alldays;
      $item->status = true;
      $item->status_decret = $request->status_decret;
      $item->save();
      
      if($request->status_decret == 1) 
      {
         $cadries = DepartmentCadry::where('cadry_id', $request->cadry_id)->get();
         foreach($cadries as $cadry){
            $cadry->status_decret = true;
            $cadry->save();
         }
      }

      return response()->json([
         'status' => true,
         'message' => "Ta'tilga yuborish muvaffaqqiyatli bajarildi!"
      ]);
   }

   public function api_vacations_edit($vacation_id, Request $request)
   {
      $con = Vacation::where('id',$vacation_id)->where('status',true)->count();
      if($con < 1)
      return response()->json([
         'status' => false,
         'message' => "Ta'til mavjud emas!"
      ]);

      $sex = Cadry::find($request->cadry_id)->sex;

      if($sex == true && $request->status_decret == 1)
      return response()->json([
         'status' => false,
         'message' => "Xodimning jinsi ta'til turiga to'g'ri kelmaydi!"
      ]);


      $item = Vacation::find($vacation_id);

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
      $item->command_number = $request->command_number;
      $item->period1 = $request->period1;
      $item->period2 = $request->period2;
      $item->alldays = $request->alldays;
      if($request->status_decret == 1)
         if(!$request->date2)
            $item->date2 = date('Y-m-d', strtotime(now()->addYear(2))); 
         else
            $item->date2 = $request->date2;
      else
         $item->date2 = $request->date2 ?? now();
      $item->status = true;
      $item->status_decret = $request->status_decret;
      $item->save();
      
      if($request->status_decret == 1) 
      {
         $cadries = DepartmentCadry::where('cadry_id', $request->cadry_id)->get();
         foreach($cadries as $cadry){
            $cadry->status_decret = true;
            $cadry->save();
         }
      }

      return response()->json([
         'status' => true,
         'message' => "Ta'tilga yuborish muvaffaqqiyatli yangilandi!"
      ]);

   }

   public function api_vacations_delete($vacation_id)
   {
      $con = Vacation::where('id', $vacation_id)->where('status',true)->count();
      if($con < 1)
      return response()->json([
         'status' => false,
         'message' => "Ta'til mavjud emas!"
      ]);

      $item = Vacation::find($vacation_id);

      if($item->status_decret == 1) 
      {
         $cadries = DepartmentCadry::where('cadry_id', $item->cadry_id)->get();
         foreach($cadries as $cadry){
            $cadry->status_decret = false;
            $cadry->save();
         }
      }

      $item->delete();

      return response()->json([
         'status' => true,
         'message' => "Ta'til muvaffaqqiyatli o'chirildi!"
      ]);
   }

   public function api_vacations_decret_success($vacation_id, Request $request)
   {
      $con = Vacation::where('id',$vacation_id)->where('status',true)->count();
      if($con < 1)
      return response()->json([
         'status' => false,
         'message' => "Ta'til mavjud emas!"
      ]);

      $item = Vacation::find($vacation_id);
      $item->date2 = $request->date2;
      $item->status = false;
      $item->save();

      $cadries = DepartmentCadry::where('cadry_id', $item->cadry_id)->get();
         foreach($cadries as $cadry){
            $cadry->status_decret = false;
            $cadry->save();
         }

      return response()->json([
         'status' => true,
         'message' => "Ta'til muvaffaqqiyatli yakunlandi!"
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
         if(!$request->date2)
            $item->date2 = date('Y-m-d', strtotime(now()->addYear(2))); 
         else
            $item->date2 = $request->date2;
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
      $status = Organization::find(auth()->user()->userorganization->organization_id)->status_vac;

      $holidays = Holiday::whereYear('holiday_date', '=', now()->format('Y'))->get();

      return view('vacations.addVacation',[
         'holidays' => $holidays,
         'status' => $status
      ]);
   }
    
   public function delete_vacation_cadry(Vacation $id) {
     
      $id->delete();

      return back();
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
         if(!$request->date2)
            $item->date2 = date('Y-m-d', strtotime(now()->addYear(2))); 
         else
            $item->date2 = $request->date2;
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

      $med = MedicalExamination::find($id);

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
