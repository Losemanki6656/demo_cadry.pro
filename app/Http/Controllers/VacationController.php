<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
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
    
}
