<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Position;
use App\Models\Specialty;
use App\Models\Technical;
use App\Models\Dual;
use App\Models\Cadry;
use App\Models\PositionTechnical;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrExport;


use App\Http\Resources\SpecialtyResource;
use App\Http\Resources\ProfessionResource;
use App\Http\Resources\TechnicalResource;
use App\Http\Resources\CadryDualResource;
use App\Http\Resources\DualResource;

class TechnicalSchoolController extends Controller
{
    public function professions()
    {
        $professions = Position::with('technicals')->get();
        $technicals = Technical::get();

        return response()->json([
            'professions' => ProfessionResource::collection($professions),
            'technicals' => $technicals
        ]);
    }

    public function api_duals_export()
    {
        $duals = Dual::orderBy('organization_id', 'desc')->with(['technical','cadry','organization','specialty','profession'])->get();

        $a = []; $x = 0;
        foreach($duals as $item) {
            $x ++;
            $a[] = [
                'id' => $x,
                'organization' => $item->organization->name,
                'fullname' => $item->cadry->last_name . ' ' . $item->cadry->first_name . ' ' . $item->cadry->middle_name,
                'technical' => $item->technical->name,
                'specialty' => $item->specialty->name,
                'profession' => $item->profession->name
            ];
        }

         $export = new ArrExport($a);
         return Excel::download($export, 'export.xlsx');

        return response()->json([ $a ]);
    }

    public function add_profession(Request $request)
    {
        $newprof = new Position();
        $newprof->name = $request->name;
        $newprof->save();

        foreach ($request->technicals as $tech) {
            if($tech['status'] == true) {
                $rel = new PositionTechnical();
                $rel->position_id = $newprof->id;
                $rel->technical_id = $tech['id'];
                $rel->save();
            }
            
        }

        return response()->json([

            'message' => "Kasb muvaffaqqiyatli qo'shildi!"
            
        ]);
    }

    public function update_profession($profession_id, Request $request)
    {
        $newprof = Position::find($profession_id);
        $newprof->name = $request->name;
        $newprof->save();

        PositionTechnical::where('position_id',$profession_id)->delete();

        foreach ($request->technicals as $tech) {
            if($tech['status'] == true) {
                $rel = new PositionTechnical();
                $rel->position_id = $profession_id;
                $rel->technical_id = $tech['id'];
                $rel->save();
            }
            
        }

        return response()->json([

            'message' => "Kasb muvaffaqqiyatli o'zgartirildi!"
            
        ]);
    }

    public function delete_profession($profession_id)
    {
        PositionTechnical::where('position_id', $profession_id)->delete();

        Position::find($profession_id)->delete();

        return response()->json([

            'message' => "Kasb muvaffaqqiyatli o'chirildi!"
            
        ]);
    }

    public function specialties()
    {
        $specialties = Specialty::with('profession')->get();

        $professions = Position::get();

        return response()->json([

            'specialties' => SpecialtyResource::collection($specialties),
            'professions' => $professions

        ]);
    }

    public function add_specialty(Request $request)
    {
        $newspec = new Specialty();
        $newspec->position_id = $request->profession_id;
        $newspec->name = $request->name;
        $newspec->comment = $request->comment;
        $newspec->save();

        return response()->json([

            'message' => "Ixtisoslik muvaffaqqiyatli qo'shildi!"
            
        ]);
    }

    public function update_specialty($specialty_id, Request $request)
    {
        $newspec = Specialty::find($specialty_id);
        $newspec->position_id = $request->profession_id;
        $newspec->name = $request->name;
        $newspec->comment = $request->comment;
        $newspec->save();

        return response()->json([

            'message' => "Ixtisoslik muvaffaqqiyatli o'zgartirildi!"
            
        ]);
    }

    public function delete_specialty(Specialty $specialty_id )
    {
        $specialty_id->delete();

        return response()->json([

            'message' => "Ixtisoslik muvaffaqqiyatli o'chirildi!"
            
        ]);
    }


    public function technicals()
    {
        $technicals = Technical::get();

        return response()->json([

            'technicals' => $technicals

        ]);
    }

    public function add_technical(Request $request)
    {
        $newprof = new Technical();
        $newprof->name = $request->name;
        $newprof->save();

        return response()->json([

            'message' => "Ta'lim muassasasi muvaffaqqiyatli qo'shildi!"
            
        ]);
    }

    public function update_technical($technical_id, Request $request)
    {
        $newprof = Technical::find($technical_id);
        $newprof->name = $request->name;
        $newprof->save();

        return response()->json([

            'message' => "Ta'lim muassasasi muvaffaqqiyatli o'zgartirildi!"
            
        ]);
    }

    public function delete_technical(Technical $technical_id)
    {
        $technical_id->delete();

        return response()->json([

            'message' => "Ta'lim muassasasi muvaffaqqiyatli o'chirildi!"
            
        ]);
    }

    public function add_profession_technical($profession_id, Request $request)
    {
        foreach ($request->technicals as $tech) {
            $rel = new PositionTechnical();
            $rel->position_id = $profession_id;
            $rel->technical_id = $tech['id'];
            $rel->save();
        }
       
        return response()->json([

            'message' => "Ta'lim muassasasi muvaffaqqiyatli biriktirildi!"
            
        ]);
    }

    public function add_dual(Cadry $cadry_id, Request $request)
    {           
        $newUpgrade = new Dual();
        $newUpgrade->railway_id = $cadry_id->railway_id;
        $newUpgrade->organization_id = $cadry_id->organization_id;
        $newUpgrade->cadry_id = $cadry_id->id;
        $newUpgrade->position_id = $request->profession_id;
        $newUpgrade->technical_id = $request->technical_id;
        $newUpgrade->specialty_id = $request->specialty_id;
        $newUpgrade->status = false;
        $newUpgrade->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function update_dual($dual_id, Request $request)
    {           
        $newUpgrade = Dual::find($dual_id);
        $newUpgrade->position_id = $request->profession_id;
        $newUpgrade->technical_id = $request->technical_id;
        $newUpgrade->specialty_id = $request->specialty_id;
        $newUpgrade->status = false;
        $newUpgrade->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli o'xzgartirildi!"
        ]);
    }

    public function delete_dual(Dual $dual_id)
    {           
        $dual_id->delete();

        return response()->json([
            'message' => "Muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function duals($cadry_id)
    {
        $duals = Dual::where('cadry_id', $cadry_id)->with([
            'profession',
            'technical',
            'specialty'
        ])->get();

        $professions = Position::with(['technicals','specialties'])->get();

        return response()->json([
             'duals' => DualResource::collection($duals),
             'professions' => CadryDualResource::collection($professions)
        ]);
        
    }


}
