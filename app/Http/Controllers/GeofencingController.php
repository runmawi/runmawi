<?php

namespace App\Http\Controllers;

use App\Geofencing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting as Setting;
use App\User as User;
use View;

class GeofencingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $settings = Setting::first();
            $data = array(
                'settings' => $settings,    
        );
            return View::make('admin.expired_dashboard', $data);
        }else{
        $Geofencing=Geofencing::first();
        return view ('admin.Geofencing.create',compact('Geofencing',$Geofencing));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->geofencing != ''){
            $geofencing = 'ON';
        }
        else{
            $geofencing = 'OFF';
        }

        if($request->id ==''){
        $Geofencing = new Geofencing;  
        }
        $Geofencing = Geofencing::first();  
        $Geofencing->geofencing = $geofencing;  
        $Geofencing->save();  
    
         return redirect('admin/Geofencing');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Geofencing  $geofencing
     * @return \Illuminate\Http\Response
     */
    public function show(Geofencing $geofencing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Geofencing  $geofencing
     * @return \Illuminate\Http\Response
     */
    public function edit(Geofencing $geofencing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Geofencing  $geofencing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Geofencing $geofencing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Geofencing  $geofencing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Geofencing $geofencing)
    {
        //
    }

    public function test()
    {
        //
    }
}
