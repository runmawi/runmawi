<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;

class CurrentTimeController extends Controller
{
    public function current_time(Request $request)
    {
        $current_carbon = Carbon::now(current_timezone());

        $data = array(
            'Get_hours' =>  $current_carbon->hour ,
            'Get_Minutes' => $current_carbon->minute ,
            'Get_Seconds' => $current_carbon->second ,
            'Get_Year' => $current_carbon->year ,
            'Get_Date' => $current_carbon->day ,
            'Get_Day' => substr(strtoupper($current_carbon->format('l')), 0, 3) ,
        );

        return view ('admin.current_time.index',compact('data'));
    }
}
