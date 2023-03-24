<?php

namespace App\Http\Controllers;

use App\Models\Cadry;

use Illuminate\Http\Request;
use App\Models\VacationCadry;
use App\Http\Resources\DeadlineVacationCollection;

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
                'id' => 1,
                'name' => "Passport muddatlari yaqinlashayotganlar "
            ],
            [
                'id' => 1,
                'name' => "Shartnoma muddati yaqinlashganlar "
            ],
            [
                'id' => 1,
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
        
        } else {
            $cadries = DepartmentCadry::with('cadry')
                ->where('organization_id', $user->organization_id)
                ->orderBy('work_date2')
                ->paginate($per_page);
        }

        

        return response()->json([
            'categories' => $elements,
            'cadries' => $cadries
        ]);

    }
}
