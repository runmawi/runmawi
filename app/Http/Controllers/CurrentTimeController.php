<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;

class CurrentTimeController extends Controller
{
    public function current_time(Request $request)
    {
        $data = array(
            'Get_hours' =>  Carbon::now()->hour ,
            'Get_Minutes' => Carbon::now()->minute ,
            'Get_Seconds' => Carbon::now()->second ,
            'Get_Year' => Carbon::now()->year ,
            'Get_Date' => Carbon::now()->day ,
            'Get_Day' => substr(strtoupper(Carbon::now()->format('l')), 0, 3) ,
        );

        return view ('admin.current_time.index',compact('data',$data));
    }
}
