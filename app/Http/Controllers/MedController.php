<?php

namespace App\Http\Controllers;
use App\Models\Cadry;
use App\Models\MedicalExamination;

use Illuminate\Http\Request;
use App\Http\Resources\MedCollection;

class MedController extends Controller
{
    public function meds()
   {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

         $cadries = Cadry::SeFilter()
            ->select(['cadries.*', 'medical_examinations.*'])
            ->where('cadries.status',true)
            ->where('medical_examinations.status',true)
            ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
            ->orderBy('medical_examinations.date2')
            ->paginate($per_page);
         
      return response()->json([
         'cadries' => new MedCollection($cadries)
      ]);
   }

   public function med_accepted($cadry_id, Request $request)
   {
      $meds = MedicalExamination::where('cadry_id', $cadry_id)->get();

      foreach ($meds as $item) {
         $item->status = false;
         $item->save();
      }
 
         MedicalExamination::create([
            'cadry_id' => $cadry_id,
            'date1' => $request->date1,
            'date2' => $request->date2, 
            'result' => $request->result ?? '',
            'status' => true
         ]); 
         
         return response()->json([
            'status' => true,
            'message' => "Tibbiy ko'rik ma'lumotlari tasdiqlandi!" 
         ]);
   }

   public function create_med_info(Request $request)
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
         
         return response()->json([
            'status' => true,
            'message' => "Tibbiy ko'rik ma'lumotlari muvaffaqqiyatli qo'shildi!" 
         ]);
   }

   public function api_cadry_meds_update($med_id, Request $request)
   {
      $med = MedicalExamination::find($med_id);
      $med->date1 = $request->date1;
      $med->date2 = $request->date2;
      $med->result = $request->result ?? '';
      
      return response()->json([
         'status' => true,
         'message' => "Tibbiy ko'rik ma'lumotlari muvaffaqqiyatli taxrirlandi!" 
      ]);
   }


}
