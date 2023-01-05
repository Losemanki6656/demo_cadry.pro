<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apparat;
use App\Models\Upgrade;
use App\Models\Cadry;
use App\Models\Railway;
use App\Models\Organization;
use App\Models\TrainingDirection;
use App\Http\Resources\UpgradeResource;
use App\Http\Resources\ManagementUpgradeCollection;
use App\Http\Resources\ManagementOrganizationCollection;
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
                ],
                [
                    'id' => 3,
                    'name' => "Dual ta'lim"
                ]
            ];

        return response()->json([
            'type_qualification' => $type_qualification,
            'apparats' => $apparats
        ]);
    }

    public function api_statistics_upgrades()
    {
       $upgrades = Upgrade::query()
            ->where('dataqual', request('date_qual'))
            ->when(request('railway_id'), function ( $query, $railway_id) {
                return $query->where('railway_id', $railway_id);
                
            })->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);
            });

        $upgrades_count = $upgrades->count();     
        $bedroom = $upgrades->where('status_bedroom', false)->count();

        return response()->json([
            'upgrades_count' => $upgrades_count,
            'status_bedroom' => $bedroom
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
            ],
            [
                'id' => 3,
                'name' => "Dual ta'lim"
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
            ->when(\Request::input('search'),function($query, $search){
                $query->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', '%'. $search .'%');
                
                });
            })
            ->with('upgrades', function ($query) use ($date_qual) {
                return $query
                    ->where('dataqual', $date_qual)
                    ->when(\Request::input('apparat_id'),function($query, $apparat_id){
                        $query->where(function ($query) use ($apparat_id) {
                            $query->where('apparat_id', $apparat_id);
                        
                        });
                    })
                    ->when(\Request::input('training_direction_id'),function($query, $training_direction_id ){
                        $query->where(function ($query) use ($training_direction_id ) {
                            $query->where('training_direction_id', $training_direction_id );
                        
                        });
                    });
            });


        $upgrades_count = $railways->withCount(['upgrades'  => function ($query) use ($date_qual) {
            $query->where('dataqual', $date_qual);
        }])->get()->sum('upgrades_count');
        $upgrades_count_bedroom = $railways->withCount(['upgrades' => function ($query) use ($date_qual) {
            $query->where('status_bedroom', false)->where('dataqual', $date_qual);
        }])->get()->sum('upgrades_count');

        return response()->json([
            'upgrades_count' => $upgrades_count,
            'upgrades_count_bedroom' => $upgrades_count_bedroom,
            'railways' => new ManagementUpgradeCollection($railways->paginate($per_page))
        ]);
    }

    public function management_upgrades_organization(Request $request, $railway_id)
    {

        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $date_qual = $request->date_qual;

        $organizations = Organization::query()
            ->where('railway_id', $railway_id)
            ->when(\Request::input('search'),function($query, $search){
                $query->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', '%'. $search .'%');
                
                });
            })
            ->with('upgrades', function ($query) use ($date_qual) {
                return $query
                    ->where('dataqual', $date_qual)
                    ->when(\Request::input('apparat_id'),function($query, $apparat_id){
                        $query->where(function ($query) use ($apparat_id) {
                            $query->where('apparat_id', $apparat_id);
                        
                        });
                    })
                    ->when(\Request::input('training_direction_id'),function($query, $training_direction_id ){
                        $query->where(function ($query) use ($training_direction_id ) {
                            $query->where('training_direction_id', $training_direction_id );
                        
                        });
                    });
            })->paginate($per_page);
            

        return response()->json([
            'organizations' => new ManagementOrganizationCollection($organizations)
        ]);
    }


    public function management_upgrades_export(Request $request)
    {
        $apparats = Apparat::get();

        $data = [];

        $date_qual = $request->date_qual;

        foreach($apparats as $item)
        {

            $total_mtu1 = 0;
            $total_mtu2 = 0;
            $total_mtu3 = 0;
            $total_mtu4 = 0;
            $total_mtu5 = 0;
            $total_mtu6 = 0;
            $total_time = 0;
            $total_all = 0;

            $directions = TrainingDirection::where('apparat_id', $item->id)->get();
            
            $x = [];
            foreach($directions as $direc) {
                $datas = [];
                $all = Upgrade::where('training_direction_id', $direc->id)->where('dataqual', $date_qual)->count(); 

                $organizations = Organization::query()
                    ->where('railway_id','!=', 1)
                    ->where('railway_id','!=', 2)
                    ->where('railway_id','!=', 3)
                    ->where('railway_id','!=', 4)
                    ->where('railway_id','!=', 5)
                    ->where('railway_id','!=', 6)
                    ->withCount(['upgrades' => function ($query) use ($date_qual, $direc) {
                        $query->where('dataqual', $date_qual)
                            ->where('training_direction_id', $direc->id );
                    }])->get();

                $datas = $organizations->where('upgrades_count','>',0);
                
                $atext = '';
                foreach ($datas as $tex) 
                {
                    $atext = $atext . $tex->name . ' - ' . $tex->upgrades_count . '<br>';
                }

                $mtu1 = Upgrade::where('training_direction_id', $direc->id)->where('dataqual', $date_qual)->where('railway_id', 1)->count();
                $mtu2 = Upgrade::where('training_direction_id', $direc->id)->where('dataqual', $date_qual)->where('railway_id', 2)->count();
                $mtu3 = Upgrade::where('training_direction_id', $direc->id)->where('dataqual', $date_qual)->where('railway_id', 3)->count();
                $mtu4 = Upgrade::where('training_direction_id', $direc->id)->where('dataqual', $date_qual)->where('railway_id', 4)->count();
                $mtu5 = Upgrade::where('training_direction_id', $direc->id)->where('dataqual', $date_qual)->where('railway_id', 5)->count();
                $mtu6 = Upgrade::where('training_direction_id', $direc->id)->where('dataqual', $date_qual)->where('railway_id', 6)->count();

                $total_mtu1 = $total_mtu1 + $mtu1;
                $total_mtu2 = $total_mtu2 + $mtu2;
                $total_mtu3 = $total_mtu3 + $mtu3;
                $total_mtu4 = $total_mtu4 + $mtu4;
                $total_mtu5 = $total_mtu5 + $mtu5;
                $total_mtu6 = $total_mtu6 + $mtu6;
                $total_all = $total_all + $all;
                $total_others = $total_all - $total_mtu1 - $total_mtu2 - $total_mtu3 - $total_mtu4 - $total_mtu5 - $total_mtu6;
                $total_time = $total_time + $direc->time_lesson;


                $x[] = [
                    'id' => $direc->id,
                    'name' => $direc->name,
                    'staff_name' => $direc->staff_name,
                    'comment_time' => $direc->comment_time,
                    'mtu1' => $mtu1,
                    'mtu2' => $mtu2,
                    'mtu3' => $mtu3,
                    'mtu4' => $mtu4,
                    'mtu5' => $mtu5,
                    'mtu6' => $mtu6,
                    'others' => $atext,
                    'total' => $all
                ];
            }

            $data[] = [
                [
                    'id' => 0,
                    'name' => $item->name,
                    'type_staff' => "Tinglovchilarning kasbiy toifalari",
                    'time_education' => "O'qish davri",
                    'mtu1' => "Toshkent MTU",
                    'mtu2' => "Qo'qon MTU",
                    'mtu3' => "Buxoro MTU",
                    'mtu4' => "Qo'ng'irot MTU",
                    'mtu5' => "Qarshi MTU",
                    'mtu6' => "Termiz MTU",
                    'others' => "Boshqalar",
                    'total' => "Jami",
                    'directions' => $x,
                    'total_directions' => [
                        'total' => 'Jami',
                        'total_directions' => $directions->count(),
                        'total_time' => $total_time,
                        'total_mtu1' => $total_mtu1,
                        'total_mtu2' => $total_mtu2,
                        'total_mtu3' => $total_mtu3,
                        'total_mtu4' => $total_mtu4,
                        'total_mtu5' => $total_mtu5,
                        'total_mtu6' => $total_mtu6,
                        'total_others' => $total_others,
                        'total_all' => $total_all
                    ]
                ]
            ];
            
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function management_organization_upgrades($organization_id, Request $request)
    {
        $apparats = Apparat::query()
            ->when(\Request::input('apparat_id'),function($query, $apparat_id ){
                        $query->where(function ($query) use ($apparat_id ) {
                            $query->where('id', $apparat_id );
                        
                        });
                    })
            ->get();

        $data = [];
        $x = [];
        
        $date_qual = $request->date_qual;

        foreach($apparats as $item)
        {

            $directions = TrainingDirection::where('apparat_id', $item->id)->get();
            
            foreach($directions as $direc) {

                $all  =  Upgrade::query()
                    ->when(\Request::input('training_direction_id'),function($query, $training_direction_id ){
                        $query->where(function ($query) use ($training_direction_id ) {
                            $query->where('training_direction_id', $training_direction_id );
                        
                        });
                    })
                    ->where('organization_id', $organization_id)->where('training_direction_id', $direc->id)
                    ->where('dataqual', $date_qual)
                    ->count();   

                if($all > 0) {
                    $x[] = [
                        'id' => $direc->id,
                        'apparat_id' => $direc->apparat,
                        'name' => $direc->name,
                        'upgrades_count' => $all
                    ];
                }
                    
            }

          
            
        }

        return response()->json([
            'data' => $x
        ]);
    }
}
