<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Position;
use App\Models\Specialty;
use App\Models\Technical;
use App\Models\PositionTechnical;


use App\Http\Resources\SpecialtyResource;

class TechnicalSchoolController extends Controller
{
    

    public function professions()
    {
        $professions = Position::get();

        return response()->json([

            'professions' => $professions

        ]);
    }

    public function add_profession(Request $request)
    {
        $newprof = new Position();
        $newprof->name = $request->name;
        $newprof->save();

        return response()->json([

            'message' => "Kasb muvaffaqqiyatli qo'shildi!"
            
        ]);
    }

    public function update_profession($profession_id, Request $request)
    {
        $newprof = Position::find($profession_id);
        $newprof->name = $request->name;
        $newprof->save();

        return response()->json([

            'message' => "Kasb muvaffaqqiyatli o'zgartirildi!"
            
        ]);
    }

    public function delete_profession(Position $profession_id)
    {
        $profession_id->delete();

        return response()->json([

            'message' => "Kasb muvaffaqqiyatli o'chirildi!"
            
        ]);
    }

    public function specialties()
    {
        $specialties = Specialty::with('profession')->get();

        return response()->json([

            'specialties' => SpecialtyResource::collection($specialties)

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

    public function update_technical($technical_id, Technical $request)
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


}
