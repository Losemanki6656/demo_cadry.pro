<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apparat;
use App\Models\Upgrade;
use App\Models\Cadry;
use App\Models\Railway;
use App\Models\TrainingDirection;
use App\Http\Resources\UpgradeResource;
use App\Http\Resources\ManagementUpgradeCollection;
use App\Http\Resources\ManagementApparatCollection;
use App\Http\Resources\TrainingDirectionCollection;

class TrainingController extends Controller
{
    public function apparats()
    {
        $apparats = Apparat::query()
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('name','like','%'.$search.'%');
                });
            })
            ->when(request('type_qualification_id'), function ( $query, $type_qualification_id) {
                return $query->where('type_qualification_id', $type_qualification_id);
            })->with('directions')->get();

        $type_qualification = [
                [
                    'id' => 1,
                    'name' => "Malaka oshirish"
                ],
                [
                    'id' => 2,
                    'name' => "Qayta tayyorlash"
                ]
            ];

        return response()->json([
            'type_qualification' => $type_qualification,
            'apparats' => $apparats
        ]);
    }
    public function cadry_add_qual(Cadry $cadry_id, Request $request)
    {           
        $newUpgrade = new Upgrade();
        $newUpgrade->railway_id = $cadry_id->railway_id;
        $newUpgrade->organization_id = $cadry_id->organization_id;
        $newUpgrade->cadry_id = $cadry_id->id;
        $newUpgrade->apparat_id = $request->apparat_id;
        $newUpgrade->cadry_id = $cadry_id->id;
        $newUpgrade->type_training = $request->type_qualification;
        $newUpgrade->training_direction_id = $request->training_direction_id;
        $newUpgrade->dataqual = $request->date_1;
        $newUpgrade->status = false;       
        $newUpgrade->status_bedroom = $request->status_bedroom;
        $newUpgrade->address = $request->address;       
        $newUpgrade->comment = $request->comment;
        $newUpgrade->save();

        $newItem = new Upgrade();
        $newItem->railway_id = $cadry_id->railway_id;
        $newItem->organization_id = $cadry_id->organization_id;
        $newItem->cadry_id = $cadry_id->id;
        $newItem->apparat_id = $request->apparat_id;
        $newItem->cadry_id = $cadry_id->id;
        $newItem->type_training = $request->type_qualification;
        $newItem->training_direction_id = $request->training_direction_id;
        $newItem->dataqual = $request->date_2;
        $newItem->status_bedroom = $request->status_bedroom;
        $newItem->address = $request->address;       
        $newItem->comment = $request->comment;
        $newItem->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function cadry_qual_update($qualification_id, Request $request)
    {           
        $newUpgrade = Upgrade::find($qualification_id);
        $newUpgrade->apparat_id = $request->apparat_id;
        $newUpgrade->type_training = $request->type_qualification;
        $newUpgrade->training_direction_id = $request->training_direction_id;
        $newUpgrade->dataqual = $request->date_qualification;
        $newUpgrade->status_bedroom = $request->status_bedroom;
        $newUpgrade->address = $request->address;       
        $newUpgrade->comment = $request->comment;
        $newUpgrade->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli yangilandi!"
        ]);
    }

    public function cadry_qual_delete($qualification_id)
    {           
        $newUpgrade = Upgrade::find($qualification_id)->delete();

        return response()->json([
            'message' => "Muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function cadry_filter($cadry_id)
    {
        $cadries = Upgrade::where('cadry_id', $cadry_id)->with(['apparat','training_direction'])->get();

        return response()->json([
             'cadries' => UpgradeResource::collection($cadries)
        ]);
        
    }

    public function statistics(Request $request)
    {
        $cadries = Upgrade::where('cadry_id',$cadry_id)->get();

        return response()->json([
            'cadries' => $cadries
        ]);
    }

    public function management_apparats(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $type_qualification = [
            [
                'id' => 1,
                'name' => "Malaka oshirish"
            ],
            [
                'id' => 2,
                'name' => "Qayta tayyorlash"
            ]
        ];

        $apparats = Apparat::query()
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('name','like','%'.$search.'%');
                });
            })
            ->when(request('type_qualification_id'), function ( $query, $type_qualification_id) {
                return $query->where('type_qualification_id', $type_qualification_id);
            })
            ->with('directions')->paginate($per_page);

        return response()->json([
            'apparats' => new ManagementApparatCollection($apparats),
            'type_qualifications' => $type_qualification
        ]);
    }

    public function management_add_apparat(Request $request)
    {
        $apparat = new Apparat();
        $apparat->type_qualification_id = $request->type_qualification_id;
        $apparat->name = $request->name;
        $apparat->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function management_apparat_update($apparat_id, Request $request)
    {
        $apparat = Apparat::find($apparat_id);
        $apparat->type_qualification_id = $request->type_qualification_id;
        $apparat->name = $request->name;
        $apparat->save();

        return response()->json([
            'message' => 'Muvaffaqqiyatli taxrirlandi!'
        ]);
    }
    
    public function management_apparat_delete(Apparat $apparat_id)
    {
        try {
            $apparat_id->delete();

        } catch (\Throwable $th) {  

            return response()->json([
                'message' => "Ushbu Xo'jalikka tegishli yo'nalishlar mavjud!"
            ], 403 );

        }

        return response()->json([
            'message' => "Muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function management_apparat_directions(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $directions = TrainingDirection::query()
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('name','like','%'.$search.'%')
                          ->orWhere('staff_name','like','%'.$search.'%');
                });
            })
            ->when(request('apparat_id'), function ( $query, $apparat_id) {
                return $query->where('apparat_id', $apparat_id);
            })->with('apparat')->paginate($per_page);


        return response()->json([
            'directions' => new TrainingDirectionCollection($directions)
        ]);
    }

    public function management_add_direction(Request $request)
    {
        $direction = new TrainingDirection();
        $direction->apparat_id = $request->apparat_id;
        $direction->name = $request->name;
        $direction->staff_name = $request->staff_name;
        $direction->time_lesson = $request->time_lesson;
        $direction->comment_time = $request->comment_time;
        $direction->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli qo'shildi!"
        ]);
    }

    
    public function management_update_direction($direction_id, Request $request)
    {
        $direction = TrainingDirection::find($direction_id);
        $direction->apparat_id = $request->apparat_id;
        $direction->name = $request->name;
        $direction->staff_name = $request->staff_name;
        $direction->time_lesson = $request->time_lesson;
        $direction->comment_time = $request->comment_time;
        $direction->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli taxrirlandi!"
        ]);
    }

    public function management_delete_direction( $direction_id )
    {
        try {
           
            $direction = TrainingDirection::find($direction_id);
            $direction->delete();
    
        } catch (\Throwable $th) {  

            return response()->json([
                'message' => "Ushbu yo'nalishga tegishli xodimalar mavjud!"
            ], 403 );

        }
      
        return response()->json([
            'message' => "Muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function management_upgrades(Request $request)
    {

        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $date_qual = $request->date_qual;

        $railways = Railway::query()
            ->where('status',true)
            ->when(\Request::input('search'),function($query, $search){
                $query->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', '%'. $search .'%');
                
                });
            })
            ->whereHas('upgrades', function ($query) use ($date_qual) {
                return $query->where('dataqual', $date_qual);
            })->paginate($per_page);

        // $upgrades = Upgrade::query()
        //     ->where('status',true)
        //     ->when(request('date_qual'), function ( $query, $date_qual) {
        //             return $query->where('dataqual', $date_qual);
                    
        //     })
        //     ->when(request('status_bedroom'), function ( $query, $status_bedroom) {
        //         return $query->where('status_bedroom', $status_bedroom);
                
        //     });

        return response()->json([
            'railways' => new ManagementUpgradeCollection($railways)
        ]);
    }
}
