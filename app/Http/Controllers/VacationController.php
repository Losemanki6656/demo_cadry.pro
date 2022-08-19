<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use Auth;

class VacationController extends Controller
{

   public function vacations()
   {
      $cadries = Vacation::Filter()->get();

      return view('vacations.vacations',[
         'cadries' => $cadries
      ]);
   }
    
}
