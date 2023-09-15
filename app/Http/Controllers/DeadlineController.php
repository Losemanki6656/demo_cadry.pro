<?php

namespace App\Http\Controllers;

use App\Models\Cadry;

use Illuminate\Http\Request;
use App\Models\VacationCadry;
use App\Models\DepartmentCadry;
use App\Http\Resources\DeadlineVacationCollection;
use App\Http\Resources\DeadlineWorkStatusCollection;
use App\Http\Resources\DeadlinePassportCollection;
use App\Http\Resources\DeadlineInostransCollection;
use App\Http\Resources\BirthDaysCollection;

class DeadlineController extends Controller
{
    public function deadlines(Request $request)
    {
        $macAddr = exec('getmac');

        $user = auth()->user()->userorganization;

        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $elements = [
            [
                'id' => 1,
                'name' => "Ta'til muddati yaqinlashganlar "
            ],
            [
                'id' => 2,
                'name' => "Passport muddatlari yaqinlashayotganlar "
            ],
            [
                'id' => 3,
                'name' => "Shartnoma muddati yaqinlashganlar "
            ],
            [
                'id' => 4,
                'name' => "Xorij sertifikati muddati yaqinlashganlar "
            ],
            [
                'id' => 5,
                'name' => "Bugungi tug'ilgan kunlar"
            ],
        ];

        if($request->category_id == 1){

            $cadries = new DeadlineVacationCollection(
                VacationCadry::with('cadry')
                    ->where('organization_id', $user->organization_id)
                    ->orderBy('date1')
                    ->paginate($per_page)
                );
        
        } else if($request->category_id == 3) {
            $cadries = new DeadlineWorkStatusCollection(
                DepartmentCadry::with('cadry')
                    ->where('organization_id', $user->organization_id)
                    ->orderBy('work_date2')
                    ->paginate($per_page)
            );
        } else if($request->category_id == 2) {
            $cadries = new DeadlinePassportCollection(
                Cadry::where('organization_id', $user->organization_id)
                    ->where('status', true)
                    ->orderBy('pass_date2')
                    ->paginate($per_page)
            );
        } else if($request->category_id == 4) {
            $cadries = new DeadlineInostransCollection(
                Cadry::where('organization_id', $user->organization_id)
                    ->where('status', true)
                    ->where('inostrans',true)
                    ->orderBy('date_inostrans')
                    ->paginate($per_page)
            );
        }
        else if($request->category_id == 5) {
            $cadries = new BirthDaysCollection(
                Cadry::where('organization_id', $user->organization_id)
                    ->where('status', true)
                    ->whereMonth('birht_date', '=', now()->format('m'))
                    ->whereDay('birht_date', '=', now()->format('d'))
                    ->orderBy('birht_date')
                    ->paginate($per_page)
            );
        }

        
        return response()->json([
            'categories' => $elements,
            'cadries' => $cadries
        ]);

    }

    public function notific_deadlines()
    {
        $a = [];
        $user = auth()->user()->userorganization;
        $inostrans = Cadry::where('organization_id', $user->organization_id)
        ->where('status', true)
                        ->where('inostrans',true)
                        ->whereDate('date_inostrans', now())->count();
        if($inostrans) $a[] =  [
            'category_id' => 4,
            'message' => 'Chet fuqarosi shartnomasi muddati yakunlangan xodimlar',
            'count' => $inostrans
        ];

        $passport = Cadry::where('organization_id', $user->organization_id)
        ->where('status', true)
                        ->whereDate('pass_date2', now())
                        ->count();

                        if($passport) $a[] =  [
                            'category_id' => 2,
                            'message' => 'Passport muddati yakunlangan xodimlar',
                            'count' => $passport
                        ];

        $birthDays = Cadry::where('organization_id', $user->organization_id)
                        ->where('status', true)
                        ->whereMonth('birht_date', '=', now()->format('m'))
                        ->whereDay('birht_date', '=', now()->format('d'))
                        ->count();

                        if($birthDays) $a[] =  [
                            'category_id' => 5,
                            'message' => "Bugungu tug'ilgan kunlar",
                            'count' => $birthDays
                        ];
        if(count($a)) {
            $status = true;
            $message = 'Ogohlantirishlar mavjud!';
        } else {
            
            $status = false;
            $message = 'Ogohlantirishlar mavjud emas!';
        }
        return response()->json([
            'status' => $status,
            'data' => $a,
            'message' => $message
        ]);
    }

    public function ssl_pr()
    {
        return "EzYSogwkia-5SmlFpz91lhMiIIK6Z8OwxVJVyzmuVnU.3pwtKFma_U4-FdsIwurwNJB5L58sL-iySP6X-URW7hM";
    }
}
