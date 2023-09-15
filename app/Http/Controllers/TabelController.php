<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TabelExport;

use App\Models\Cadry;
use App\Models\Tabel;
use App\Models\Holiday;
use App\Models\TabelCategory;
use App\Models\UserDepartment;
use App\Models\Turnicet;
use App\Http\Resources\TableCadryResource;
use App\Http\Resources\TabelResources\TabelCategoryResource;
use App\Http\Resources\HolidayResources\HolidayResource;
use DB;
use Datetime;
use \Carbon\Carbon;

class TabelController extends Controller
{
    public function tabel_turnicet_download(Request $request)
    {
        set_time_limit(300);
        $month = $request->month;
        $year = $request->year;
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // $weekMap = [
        //     0 => 'Ya',
        //     1 => 'Du',
        //     2 => 'Se',
        //     3 => 'Ch',
        //     4 => 'Pa',
        //     5 => 'Ju',
        //     6 => 'Sh',
        // ];
  
        // $holidays = Holiday::whereYear('holiday_date', $year)->whereMonth('holiday_date',$month)->get();

        // $hols = $holidays;

        // $days = []; $cadry_days = [];
        // for($i = 1; $i <= $number; $i++)
        // {
        //     $dayOfTheWeek = \Carbon\Carbon::parse($year  . '-' . $month . '-' . $i)->dayOfWeek;
        //     $weekday = $weekMap[$dayOfTheWeek];
            
        //     $holiday = false; 
        //     $before_day = false; 
        //     $category_id = null;

        //     foreach($hols as $hol)
        //     {
        //         if((int)$hol->holiday_date->format('d') == $i) {
        //             if(!$hol->old_holiday) {
        //                 $category_id = 3;
        //                 break;
        //             } else {
        //                 $before_day = true;
        //                 break;
        //             }    
        //         } 
        //     }

        //     $days[] = [
        //         'day' => $i,
        //         'weekday' => $weekday,
        //         "category_id" => $category_id,
        //         "work_time" => null,
        //         'before_day' => $before_day
        //     ];

        //     $cadry_days[] = [
        //         'day' => $i,
        //         'weekday' => $weekday,
        //         "category_id" => $category_id,
        //         "work_time" => null,
        //     ];
        // }

        $user = auth()->user()->department;

        if($user->status == 1) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month', $month);
                }
            ])
            ->where('department_id', $user->department_id)
            ->where('status', true)
            ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month',$month);
                }
            ])
            ->where('organization_id', $user->organization_id)
            ->where('status', true)
            ->get();
        }
        
       
        $tabel = [];
           
        $arr = [];

        $arr[] = [''];
        $arr[] = [''];
        $arr[] = [''];
        $arr[] = [''];
        $arr[] = [''];
        $arr[] = [''];
        $arr[] = [''];
        $arr[] = [''];
        $arr[] = [''];

        $x = 0;

        foreach($cadries as $item)
        {
            $cadryTimes = [];
            $x ++ ;

            $arrrr = []; $barrrr = [];
            $vsevoYarimDen = 0;
            $vsevoYarimNoch = 0;
            $vsevo2YarimDen = 0;
            $vsevo2YarimNoch = 0;

            for($i = 1; $i <= $number; $i++)
                {
                    $umumiySoatNoch = 0; $umumiyMinutNoch = 0;
                    $umumiySoatDen = 0; $umumiyMinutDen = 0;

                    $datetime = Carbon::parse($year  . '-' . $month . '-' . $i);

                    // $dayOfTheWeek = $datetime->dayOfWeek;
                    // $weekday = $weekMap[$dayOfTheWeek];
                    
                    // $holiday = false; 
                    // $before_day = false; 
                    // $category_id = null;
        
                    // foreach($hols as $hol)
                    // {
                    //     if ((int)$hol->holiday_date->format('d') == $i) {
                    //         if(!$hol->old_holiday) {
                    //             $category_id = 3;
                    //             break;
                    //         } else {
                    //             $before_day = true;
                    //             break;
                    //         }    
                    //     } 
                    // }
                    
                    $turnicets = Turnicet::where('datetime','>=', $datetime->format('Y-m-d 00:00:01'))
                        ->where('datetime','<=', $datetime->format('Y-m-d 23:59:59'))
                        ->where('jshr', $item->jshshir)->orderBy('datetime','asc');
                    
                    if($turnicets->count() > 0) {

                        $hoursTime = []; 
                        $minutTime = [];

                        $hoursDen = []; 
                        $minutesDen = [];
                        $hoursNoch = []; 
                        $minutesNoch = [];

                        $kechasi = new Datetime($datetime->format('Y-m-d 22:00:01'));
                        $ertalab = new Datetime($datetime->format('Y-m-d 06:00:01'));

                        $lastTime = new Datetime($datetime->format('Y-m-d 00:00:01'));
                        $end = new Datetime($datetime->format('Y-m-d 23:59:59'));

                        $status = true;
                        foreach($turnicets->get() as $tur)
                        {
                            $kirgani = new Datetime($tur->datetime);

                            if($tur->status == 'OUT' && $status == true) {

                                if($kirgani >= $kechasi){

                                    if($lastTime >= $kechasi)
                                    {
                                        $noch = $kirgani->diff($lastTime);
                                        $umumiySoatNoch += $noch->format('%H');
                                        $umumiyMinutNoch += $noch->format('%i');

                                    } else if($lastTime >= $ertalab) {
                                        $noch = $kirgani->diff($kechasi);
                                        $den = $kechasi->diff($lastTime);

                                        $umumiySoatDen += $den->format('%H');
                                        $umumiyMinutDen += $den->format('%i');
                                        $umumiySoatNoch += $noch->format('%H');
                                        $umumiyMinutNoch += $noch->format('%i');

                                    } else {
                                        $noch = $lastTime->diff($ertalab);
                                        $den = $kechasi->diff($ertalab);

                                        $umumiySoatDen += $den->format('%H');
                                        $umumiyMinutDen += $den->format('%i');
                                        $umumiySoatNoch += $noch->format('%H');
                                        $umumiyMinutNoch += $noch->format('%i');

                                        $noch = $kirgani->diff($kechasi);

                                        $umumiySoatNoch += $noch->format('%H');
                                        $umumiyMinutNoch += $noch->format('%i');
                                    }

                                }  else {
                                    if($lastTime >= $ertalab) {
                                        $den = $lastTime->diff($kirgani);

                                        $umumiySoatDen += $den->format('%H');
                                        $umumiyMinutDen += $den->format('%i');

                                    } else {
                                        $noch = $ertalab->diff($lastTime);
                                        $den = $kirgani->diff($ertalab);

                                        $umumiySoatDen += $den->format('%H');
                                        $umumiyMinutDen += $den->format('%i');
                                        $umumiySoatNoch += $noch->format('%H');
                                        $umumiyMinutNoch += $noch->format('%i');
                                    }
                                }

                                $status = false;
                            } 
                            else 
                            if($tur->status == 'IN') {
                                $lastTime = new Datetime($tur->datetime);
                                $status = true;
                            }

                        }

                        if($status == true) {
                            if($lastTime >= $ertalab && $lastTime <= $kechasi) {
                                $den = $kechasi->diff($lastTime);
                                $noch = $end->diff($kechasi);
                                $umumiySoatDen += $den->format('%H');
                                $umumiyMinutDen += $den->format('%i');
                                $umumiySoatNoch += $noch->format('%H');
                                $umumiyMinutNoch += $noch->format('%i');
                                
                            } else if($lastTime <= $ertalab) {
                                $noch = $ertalab->diff($lastTime);
                                $den = $kechasi->diff($ertalab);
                                $umumiySoatDen += $den->format('%H');
                                $umumiyMinutDen += $den->format('%i');
                                $umumiySoatNoch += $noch->format('%H');
                                $umumiyMinutNoch += $noch->format('%i');

                                $noch = $end->diff($kechasi);
                                $umumiySoatNoch += $noch->format('%H');
                                $umumiyMinutNoch += $noch->format('%i');

                            } else {
                                $noch = $end->diff($lastTime);

                                $umumiySoatNoch += $noch->format('%H');
                                $umumiyMinutNoch += $noch->format('%i');
                            }

                            // if($item->id == 6 && $i == 31) 
                            // return response()->json([
                            //     'umumiySoatDen' => $umumiySoatDen,
                            //     'umumiyminDen' => $umumiyMinutDen,
                            //     'umumiySoatNoch' => $umumiySoatNoch,
                            //     'umumiyminnoch' => $umumiyMinutNoch
                            // ]);
                        }

                        $cadryTimes[$item->id] = [
                            'id'=>$x,
                            'name' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name
                        ];
                    } 
                    else {
                        $cadryTimes[$item->id] = [
                            'id'=> $x,
                            'name' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name
                        ];
                    }

                    $den = $umumiySoatDen + round($umumiyMinutDen/60);
                    $noch = $umumiySoatNoch + round($umumiyMinutNoch/60);
                    $arrrr[$i] = $den;
                    $barrrr[$i] = $noch;
                    if($i<=15) {
                        $vsevoYarimDen += $den;
                        $vsevoYarimNoch += $noch; 
                    } else {
                        $vsevo2YarimDen += $den;
                        $vsevo2YarimNoch += $noch;
                    }
                }
                
                $cadryTimes[] = [
                    'id' => '',
                    'name' => '',
                    'x' => 'день',
                    '1' => $arrrr[1] ?? '',
                    '2' => $arrrr[2] ?? '',
                    '3' => $arrrr[3] ?? '',
                    '4' => $arrrr[4] ?? '',
                    '5' => $arrrr[5] ?? '',
                    '6' => $arrrr[6] ?? '',
                    '7' => $arrrr[7] ?? '',
                    '8' => $arrrr[8] ?? '',
                    '9' => $arrrr[9] ?? '',
                    '10' => $arrrr[10] ?? '',
                    '11' => $arrrr[11] ?? '',
                    '12' => $arrrr[12] ?? '',
                    '13' => $arrrr[13] ?? '',
                    '14' => $arrrr[14] ?? '',
                    '15' => $arrrr[15] ?? '',
                    'yarim' => $vsevoYarimDen,
                    '16' => $arrrr[16] ?? '',
                    '17' => $arrrr[17] ?? '',
                    '18' => $arrrr[18] ?? '',
                    '19' => $arrrr[19] ?? '',
                    '20' => $arrrr[20] ?? '',
                    '21' => $arrrr[21] ?? '',
                    '22' => $arrrr[22] ?? '',
                    '23' => $arrrr[23] ?? '',
                    '24' => $arrrr[24] ?? '',
                    '25' => $arrrr[25] ?? '',
                    '26' => $arrrr[26] ?? '',
                    '27' => $arrrr[27] ?? '',
                    '28' => $arrrr[28] ?? '',
                    '29' => $arrrr[29] ?? '',
                    '30' => $arrrr[30] ?? '',
                    '31' => $arrrr[31] ?? '',
                    'vsevo2' => $vsevo2YarimDen,
                    'vsevo' => $vsevo2YarimDen + $vsevoYarimDen,
                ];
                $cadryTimes[] = [
                    'id' => '',
                    'name' => '',
                    'x' => 'ночь',
                    '1' => $barrrr[1] ?? '',
                    '2' => $barrrr[2] ?? '',
                    '3' => $barrrr[3] ?? '',
                    '4' => $barrrr[4] ?? '',
                    '5' => $barrrr[5] ?? '',
                    '6' => $barrrr[6] ?? '',
                    '7' => $barrrr[7] ?? '',
                    '8' => $barrrr[8] ?? '',
                    '9' => $barrrr[9] ?? '',
                    '10' => $barrrr[10] ?? '',
                    '11' => $barrrr[11] ?? '',
                    '12' => $barrrr[12] ?? '',
                    '13' => $barrrr[13] ?? '',
                    '14' => $barrrr[14] ?? '',
                    '15' => $barrrr[15] ?? '',
                    'yarim' => $vsevoYarimNoch,
                    '16' => $barrrr[16] ?? '',
                    '17' => $barrrr[17] ?? '',
                    '18' => $barrrr[18] ?? '',
                    '19' => $barrrr[19] ?? '',
                    '20' => $barrrr[20] ?? '',
                    '21' => $barrrr[21] ?? '',
                    '22' => $barrrr[22] ?? '',
                    '23' => $barrrr[23] ?? '',
                    '24' => $barrrr[24] ?? '',
                    '25' => $barrrr[25] ?? '',
                    '26' => $barrrr[26] ?? '',
                    '27' => $barrrr[27] ?? '',
                    '28' => $barrrr[28] ?? '',
                    '29' => $barrrr[29] ?? '',
                    '30' => $barrrr[30] ?? '',
                    '31' => $barrrr[31] ?? '',
                    'vsevo2' => $vsevo2YarimNoch,
                    'vsevo' => $vsevo2YarimNoch + $vsevoYarimNoch,
                ];

                $arr[] = $cadryTimes;
           
        }

        
        return Excel::download(new TabelExport($arr,$x, $x*3 + 9), 'tabel.xlsx');

        
    }


    public function tabel_turnicet_load(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $weekMap = [
            0 => 'Ya',
            1 => 'Du',
            2 => 'Se',
            3 => 'Ch',
            4 => 'Pa',
            5 => 'Ju',
            6 => 'Sh',
        ];
  
        $holidays = Holiday::whereYear('holiday_date', $year)->whereMonth('holiday_date',$month)->get();

        $hols = $holidays;

        $days = []; $cadry_days = [];
        for($i = 1; $i <= $number; $i++)
        {
            $dayOfTheWeek = \Carbon\Carbon::parse($year  . '-' . $month . '-' . $i)->dayOfWeek;
            $weekday = $weekMap[$dayOfTheWeek];
            
            $holiday = false; 
            $before_day = false; 
            $category_id = null;

            foreach($hols as $hol)
            {
                if((int)$hol->holiday_date->format('d') == $i) {
                    if(!$hol->old_holiday) {
                        $category_id = 3;
                        break;
                    } else {
                        $before_day = true;
                        break;
                    }    
                } 
            }

            $days[] = [
                'day' => $i,
                'weekday' => $weekday,
                "category_id" => $category_id,
                "work_time" => null,
                'before_day' => $before_day
            ];

            $cadry_days[] = [
                'day' => $i,
                'weekday' => $weekday,
                "category_id" => $category_id,
                "work_time" => null,
            ];
        }

        $user = auth()->user()->department;

        if($user->status == 1) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month', $month);
                }
            ])
            ->where('department_id', $user->department_id)
            ->where('status', true)
            ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month',$month);
                }
            ])
            ->where('organization_id', $user->organization_id)
            ->where('status', true)
            ->get();
        }
        
       
        $tabel = [];

        foreach($cadries as $item)
        {
            if($item->tabel) {
                $cadry_tabel = $item->tabel->days;
                $tabel[] = [
                    'id' => $item->id,
                    'fullname' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name,
                    'days' => $cadry_tabel
                ];
            } else {
                $cadry_days = [];

                for($i = 1; $i <= $number; $i++)
                {
                    $datetime = Carbon::parse($year  . '-' . $month . '-' . $i);

                    $dayOfTheWeek = $datetime->dayOfWeek;
                    $weekday = $weekMap[$dayOfTheWeek];
                    
                    $holiday = false; 
                    $before_day = false; 
                    $category_id = null;
        
                    foreach($hols as $hol)
                    {
                        if((int)$hol->holiday_date->format('d') == $i) {
                            if(!$hol->old_holiday) {
                                $category_id = 3;
                                break;
                            } else {
                                $before_day = true;
                                break;
                            }    
                        } 
                    }
                    
                    $turnicets = Turnicet::where('datetime','>=', $datetime->format('Y-m-d 00:00:01'))
                        ->where('datetime','<=', $datetime->format('Y-m-d 23:59:59'))
                        ->where('jshr', $item->jshshir)->orderBy('datetime','asc');
                    
                    if($turnicets->count() > 0) {

                        $hoursTime = []; $minutTime = [];
                        $lastTime = new Datetime($datetime->format('Y-m-d 00:00:01'));
                        $end = new Datetime($datetime->format('Y-m-d 23:59:59'));

                        $status = true;
                        foreach($turnicets->get() as $tur)
                        {
                            $kirgani = new Datetime($tur->datetime);

                            if($tur->status == 'OUT' && $status == true) {
                                $mejdu = $kirgani->diff($lastTime);
                                $hoursTime[] = $mejdu->format('%H');
                                $minutTime[] = $mejdu->format('%i');
                                $status = false;
                            } 
                            else 
                            if($tur->status == 'IN') {
                                $lastTime = new Datetime($tur->datetime);
                                $status = true;
                            }
                        }

                        if($status == true) {
                            $mejdu = $lastTime->diff($end);
                            $hoursTime[] = $mejdu->format('%H');
                            $minutTime[] = $mejdu->format('%i');
                        }

                        $summHours = array_sum($hoursTime);
                        $summMin = array_sum($minutTime);

                        $cadry_days[] = [
                            'day' => $i,
                            'weekday' => $weekday,
                            "category_id" => $category_id ?? 1,
                            "work_time" => $summHours + intdiv($summMin, 60),
                        ];
                    } 
                    else 
                    $cadry_days[] = [
                        'day' => $i,
                        'weekday' => $weekday,
                        "category_id" => $category_id,
                        "work_time" => null,
                    ];
                }

                $tabel[] = [
                    'id' => $item->id,
                    'fullname' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name,
                    'days' => $cadry_days
                ];
            }

           
        }

        $categories = TabelCategoryResource::collection(TabelCategory::get());

        return response()->json([
            'categories' => $categories,
            'days' => $days,
            'cadries' => $tabel
        ]);
    }

    public function tabel_cadries(Request $request)
    {

        $month = $request->month;
        $year = $request->year;
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $weekMap = [
            0 => 'Ya',
            1 => 'Du',
            2 => 'Se',
            3 => 'Ch',
            4 => 'Pa',
            5 => 'Ju',
            6 => 'Sh',
        ];
  
        $holidays = Holiday::whereYear('holiday_date', $year)->whereMonth('holiday_date',$month)->get();

        $hols = $holidays;

        $days = []; $cadry_days = [];
        for($i = 1; $i <= $number; $i++)
        {
            $dayOfTheWeek = \Carbon\Carbon::parse($year  . '-' . $month . '-' . $i)->dayOfWeek;
            $weekday = $weekMap[$dayOfTheWeek];
            
            $holiday = false; 
            $before_day = false; 
            $category_id = null;

            foreach($hols as $hol)
            {
                if((int)$hol->holiday_date->format('d') == $i) {
                    if(!$hol->old_holiday) {
                        $category_id = 3;
                        break;
                    } else {
                        $before_day = true;
                        break;
                    }    
                } 
            }

            $days[] = [
                'day' => $i,
                'weekday' => $weekday,
                "category_id" => $category_id,
                "work_time" => null,
                'before_day' => $before_day
            ];

            $cadry_days[] = [
                'day' => $i,
                'weekday' => $weekday,
                "category_id" => $category_id,
                "work_time" => null,
            ];
        }

        $user = auth()->user()->department;

        if($user->status == 1) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month', $month);
                }
            ])
            ->where('department_id', $user->department_id)
            ->where('status', true)
            ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month',$month);
                }
            ])
            ->where('organization_id', $user->organization_id)
            ->where('status', true)
            ->get();
        }
        
       
        $tabel = [];

        foreach($cadries as $item)
        {
            if($item->tabel) {
                $cadry_tabel = $item->tabel->days;
                $tabel[] = [
                    'id' => $item->id,
                    'fullname' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name,
                    'days' => $cadry_tabel
                ];
            } else {
                $cadry_days = [];

                for($i = 1; $i <= $number; $i++)
                {
                    $datetime = Carbon::parse($year  . '-' . $month . '-' . $i);

                    $dayOfTheWeek = $datetime->dayOfWeek;
                    $weekday = $weekMap[$dayOfTheWeek];
                    
                    $holiday = false; 
                    $before_day = false; 
                    $category_id = null;
        
                    foreach($hols as $hol)
                    {
                        if((int)$hol->holiday_date->format('d') == $i) {
                            if(!$hol->old_holiday) {
                                $category_id = 3;
                                break;
                            } else {
                                $before_day = true;
                                break;
                            }    
                        } 
                    }
                    
                    // $turnicets = Turnicet::where('datetime','>=', $datetime->format('Y-m-d 00:00:01'))
                    //     ->where('datetime','<=', $datetime->format('Y-m-d 23:59:59'))
                    //     ->where('jshr', $item->jshshir)->orderBy('datetime','asc');
                    
                    // if($turnicets->count() > 0) {

                    //     $hoursTime = []; $minutTime = [];
                    //     $lastTime = new Datetime($datetime->format('Y-m-d 00:00:01'));
                    //     $end = new Datetime($datetime->format('Y-m-d 23:59:59'));

                    //     $status = true;
                    //     foreach($turnicets->get() as $tur)
                    //     {
                    //         $kirgani = new Datetime($tur->datetime);

                    //         if($tur->status == 'OUT' && $status == true) {
                    //             $mejdu = $kirgani->diff($lastTime);
                    //             $hoursTime[] = $mejdu->format('%H');
                    //             $minutTime[] = $mejdu->format('%i');
                    //             $status = false;
                    //         } 
                    //         else 
                    //         if($tur->status == 'IN') {
                    //             $lastTime = new Datetime($tur->datetime);
                    //             $status = true;
                    //         }
                    //     }

                    //     if($status == true) {
                    //         $mejdu = $lastTime->diff($end);
                    //         $hoursTime[] = $mejdu->format('%H');
                    //         $minutTime[] = $mejdu->format('%i');
                    //     }

                    //     $summHours = array_sum($hoursTime);
                    //     $summMin = array_sum($minutTime);

                    //     $cadry_days[] = [
                    //         'day' => $i,
                    //         'weekday' => $weekday,
                    //         "category_id" => $category_id ?? 1,
                    //         "work_time" => $summHours + intdiv($summMin, 60),
                    //     ];
                    // } 
                    // else 
                    $cadry_days[] = [
                        'day' => $i,
                        'weekday' => $weekday,
                        "category_id" => $category_id,
                        "work_time" => null,
                    ];
                }

                $tabel[] = [
                    'id' => $item->id,
                    'fullname' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name,
                    'days' => $cadry_days
                ];
            }

           
        }

        $categories = TabelCategoryResource::collection(TabelCategory::get());

        return response()->json([
            'categories' => $categories,
            'days' => $days,
            'cadries' => $tabel
        ]);
    }

    public function cadries_turnicet(Request $request)
    {

        $month = $request->month;
        $year = $request->year;
        $user = auth()->user()->department;

        if($user->status == 1) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month', $month);
                }
            ])
            ->where('department_id', $user->department_id)
            ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Cadry::with(['tabel' => function($query) use ($year, $month) {
                    return $query->where('year', $year)->where('month',$month);
                }
            ])
            ->where('organization_id', $user->organization_id)
            ->get();
        }
        
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $holidays = Holiday::whereYear('holiday_date', $year)->whereMonth('holiday_date',$month)->get();

        $hols = $holidays;
        $weekMap = [
            0 => 'Ya',
            1 => 'Du',
            2 => 'Se',
            3 => 'Ch',
            4 => 'Pa',
            5 => 'Ju',
            6 => 'Sh',
        ];
        
        $tabel = [];

        foreach($cadries as $item)
        {

            $days = []; $cadry_days = [];

            for($i = 1; $i <= $number; $i++)
            {
                $datetime = Carbon::parse($year  . '-' . $month . '-' . $i);

                $dayOfTheWeek = $datetime->dayOfWeek;
                $weekday = $weekMap[$dayOfTheWeek];
                
                $holiday = false; 
                $before_day = false; 
                $category_id = null;
    
                foreach($hols as $hol)
                {
                    if((int)$hol->holiday_date->format('d') == $i) {
                        if(!$hol->old_holiday) {
                            $category_id = 3;
                            break;
                        } else {
                            $before_day = true;
                            break;
                        }    
                    } 
                }
                
                $turnicets = Turnicet::whereDate('datetime','>=', $datetime->format('Y-m-d 00:00:00'))
                    ->whereDate('datetime','<=', $datetime->format('Y-m-d 23:59:59'))
                    ->where('jshr', $item->jshshir);
                
                if($turnicets->count() > 0) {

                    $hoursTime = []; $minutTime = [];
                    $lastTime = new Datetime($datetime->format('Y-m-d 00:00:00'));
                    $end = new Datetime($datetime->format('Y-m-d 23:59:59'));

                    foreach($turnicets->get() as $tur)
                    {
                        $kirgani = new Datetime($tur->datetime);

                        if($tur->status == 'OUT') {
                            $mejdu = $kirgani->diff($lastTime);
                            $hoursTime[] = $mejdu->format('%H');
                            $minutTime[] = $mejdu->format('%i');
                            $status = false;
                        } 
                        else 
                        if($tur->status == 'IN') {
                            $lastTime = new Datetime($tur->datetime);
                            $status = true;
                        }
                    }

                    if($status == true) {
                        $mejdu = $lastTime->diff($end);
                        $hoursTime[] = $mejdu->format('%H');
                        $minutTime[] = $mejdu->format('%i');
                    }

                    $summHours = array_sum($hoursTime);
                    $summMin = array_sum($minutTime);

                    $cadry_days[] = [
                        'day' => $i,
                        'weekday' => $weekday,
                        "category_id" => $category_id,
                        "work_time" => $summHours + intdiv($summMin, 60),
                    ];
                } 
                else 
                $cadry_days[] = [
                    'day' => $i,
                    'weekday' => $weekday,
                    "category_id" => $category_id,
                    "work_time" => null,
                ];
            }

            $tabel[] = [
                'id' => $item->id,
                'fullname' => $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name,
                'days' => $cadry_days
            ];
        }

        $categories = TabelCategoryResource::collection(TabelCategory::get());

        return response()->json([
            'categories' => $categories,
            'days' => $days,
            'cadries' => $tabel
        ]);
    }

    public function create_tabel_to_cadry(Request $request)
    {    
        $user = auth()->user();

        DB::transaction(function() use ($request, $user) {

            foreach($request->cadries as $item)
            {
                $factCount = 0; $hours = 0; $rp = 0; $n = 0;
                foreach($item['days'] as $day)
                {
                    if($day['category_id']!=null && $day['work_time']!=null) {
                        $factCount ++;
                        $hours = $hours + $day['work_time'];

                        if($day['category_id'] == 3) $rp = $rp + $day['work_time'];
                        if($day['category_id'] == 2) $n = $n + $day['work_time'];
                    }
                }
                
                if($factCount){
                    $cadry = Tabel::where('cadry_id',$item['id'])->where('year',$request->year)->where('month',$request->month);

                    if($cadry->count())
                    {
                        $cadry->first()->update([
                            'cadry_id' => $item['id'],
                            'year' => $request->year,
                            'month' => $request->month,
                            'days' => $item['days'],
                            'send_user_id' => $user->id,
                            'fact' => $factCount,
                            'vsevo' => $hours,
                            'prazdnichniy' => $rp,
                            'nochnoy' => $n
                        ]);
                    }
                    else
                    Tabel::create([
                        'cadry_id' => $item['id'],
                        'year' => $request->year,
                        'month' => $request->month,
                        'days' => $item['days'],
                        'send_user_id' => $user->id,
                        'fact' => $factCount,
                        'vsevo' => $hours,
                        'prazdnichniy' => $rp,
                        'nochnoy' => $n,
                        'railway_id' => $user->department->railway_id,
                        'organization_id' => $user->department->organization_id,
                        'department_id' => $user->department->department_id
                    ]);
                } else Tabel::where('cadry_id',$item['id'])->where('year',$request->year)->where('month',$request->month)->delete();
                
            }
        });

        return response()->json([
            'message' => 'successfully',
        ]);
    }

    public function tabel_export(Request $request)
    {
        $holidays = Holiday::whereYear('holiday_date', $request->year)->whereMonth('holiday_date', $request->month)->where('old_holiday',false)->get();
        $days = [];

        foreach($holidays as $item)
        {
            $days[] = $item->holiday_date->format('d');
        }
        
        $cadries = $this->workers($request->year, $request->month);

        $x = 0; $a = [];
        foreach ($cadries as $cadry)
        {
            $x ++;
            $fullname = $cadry->cadry->last_name . ' ' . $cadry->cadry->fist_name . ' ' . $cadry->cadry->middle_name;

            $a[] = [
                $x,
                $fullname, '','','','','', '','','','','', '','','','','',
                $cadry->fact,
                $cadry->selosmenix_prostov,
                $cadry->ocherednoy_otpusk,
                $cadry->otsusk_s_rodam,
                $cadry->bolezn,
                $cadry->neyavki_razr,
                $cadry->razr_admin,
                $cadry->progul,
                $cadry->vixod_prazd,
                $cadry->tekush_pros,
                $cadry->opazjanie,
                $cadry->vsevo,
                $cadry->sdelno,
                $cadry->svixurochniy,
                $cadry->nochnoy,
                $cadry->prazdnichniy,
                $cadry->tabel_number,
                $cadry->ustanovleniy,
                $cadry->ekonomie,
                $cadry->vid_oplate,
                $cadry->sxema_rascheta,
                $cadry->sintecheskiy,
                $cadry->statya_rasxoda,
                $cadry->dop_priznak,
                $cadry->kod_primi,
                $cadry->prosent_iz_primi,
                $cadry->prosent_primi_iz,
                $cadry->dni_fact,
                $cadry->chasi_fact,
                $cadry->fact_rabot,
                $cadry->vixod_priznich
            ];

            $a[] = [
                ''
            ];

            $y = 0; $z = []; $q = [];
            $z[] = ''; $q[] = '';
            foreach ($cadry['days'] as $day)
            {
                $y ++;
                if($y <= 15) {
                    $z[] = $day['work_time'];
                } else {
                    $q[] = $day['work_time'];
                }
            }

            $a[] = $z; 
            $a[] = $q;
        }

        $organization = auth()->user()->department->organization->name;

        return Excel::download(new TabelExport($days, $a, $x, $request->year, $request->month, $organization), 'tabel.xlsx');

    }

    public function workers($year, $month)
    {
        $user = auth()->user()->department;

        if($user->status == 1) {
            $cadries = Tabel::where('year', $year)->where('month', $month)
                ->where('department_id', $user->department_id)->with('cadry')
                ->get();
    
        }
        else if(auth()->user()->department->status == 2) {
            $cadries = Tabel::where('year', $year)->where('month',$month)
                ->where('organization_id', $user->organization_id)->with('cadry')
                ->get();
        }

        return $cadries;
    }


}
