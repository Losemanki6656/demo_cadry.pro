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
                    ->orderBy('pass_date2')
                    ->paginate($per_page)
            );
        } else if($request->category_id == 4) {
            $cadries = new DeadlineInostransCollection(
                Cadry::where('organization_id', $user->organization_id)
                    ->where('inostrans',true)
                    ->orderBy('date_inostrans')
                    ->paginate($per_page)
            );
        }

        

        return response()->json([
            'categories' => $elements,
            'cadries' => $cadries
        ]);

    }

    public function ssl_pr()
    {
        return "EzYSogwkia-5SmlFpz91lhMiIIK6Z8OwxVJVyzmuVnU.3pwtKFma_U4-FdsIwurwNJB5L58sL-iySP6X-URW7hM";
    }
}
