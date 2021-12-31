<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Plan as Plan;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\PaypalPlan as PaypalPlan;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Response;
use App\PaylPlan;
use App\Devices;
use App\PaymentSetting as PaymentSetting;
use App\SubscriptionPlan as SubscriptionPlan;



class AdminPlansController extends Controller
{
    
    public function index()
    {
      $slug = Str::slug('Laravel 5 Framework', '-');
        $plans = Plan::all();
        $devices = Devices::all();
        
         $data = array(
        	'plans' => $plans,
             'allplans'=> $plans,
             'devices'=> $devices,        	
        	);
         return view('admin.plans.index',$data);
    }   
    
public function PaypalIndex()
    {
        
        $slug = Str::slug('Laravel 5 Framework', '-');
        
        $plans = PaypalPlan::all();
        $devices = Devices::all();
         $data = array(
        	'plans' => $plans,
             'allplans'=> $plans,
             'devices'=> $devices,        	
        	
        	);
         return view('admin.paypal.index', $data);
    }

    public function subscriptionindex()
    {
        
        $slug = Str::slug('Laravel 5 Framework', '-');
        
        $plans_data = SubscriptionPlan::all();
        $plans = $plans_data->groupBy('plans_name');
        // dd($plans);
        $payment_settings = PaymentSetting::all();
        $devices = Devices::all();
         $data = array(
        	'plans' => $plans,
             'allplans'=> $plans,
             'devices'=> $devices,        	
             'payment_settings'=> $payment_settings,        	
        	
        	);
         return view('admin.subscription_plans.index', $data);
    }
     public function edit($id) {
    	 $edit_plan =  Plan::find($id);
         $permission = $edit_plan['devices'];
         $user_devices = explode(",",$permission);
         $devices = Devices::all();
         $data = array(
        	'edit_plan' => $edit_plan,
        	'user_devices' => $user_devices,
        	'devices' => $devices,
        	);
        return view('admin.plans.edit',$data);

    } 
    
    public function PaypalEdit($id) {
    	 
         $edit_plan =  PaypalPlan::find($id);
         $permission = $edit_plan['devices'];
         $user_devices = explode(",",$permission);
         $devices = Devices::all();
         $data = array(
        	'edit_plan' => $edit_plan,
            'user_devices' => $user_devices,
        	'devices' => $devices,
        	);
        return view('admin.paypal.edit',$data);

    }
    
    public function subscriptionedit($id) {
    	 
        // $edit_plan = SubscriptionPlan::find($id);
        $edit_plan =  Plan::where('plans_name','Monthly')->first();
        // dd($edit_plan);
        $payment_settings = PaymentSetting::all();
        $permission = $edit_plan['devices'];
        $user_devices = explode(",",$permission);
        $devices = Devices::all();
        $data = array(
           'edit_plan' => $edit_plan,
           'user_devices' => $user_devices,
           'devices' => $devices,
           'payment_settings' => $payment_settings,
           );
       return view('admin.subscription_plans.edit',$data);

   }
   
    public function delete($id) {
    	
        Plan::where('id',$id)->delete();

    	return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));

    }    
    public function PaypalDelete($id) {
    	
        PaypalPlan::where('id',$id)->delete();

    	return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));

    }

    public function subscriptiondelete($id) {

    	
        SubscriptionPlan::where('id',$id)->delete();

    	return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));

    }

    public function store(Request $request) {
            $input = $request->all();
            $validatedData = $request->validate([
                'plans_name' => 'required|max:255',
                'days' => 'required|max:255',
                'price' => 'required|max:255',
                'type' => 'required|max:255'
            ]);  
                $devices = $request->devices;
                $plan_devices = implode(",",$devices);
                $new_plan = new Plan;
                $new_plan->plans_name = $request->plans_name;
                $new_plan->days = $request->days;
                $new_plan->payment_type = $request->payment_type;
                $new_plan->price = $request->price;
                $new_plan->plan_id = $request->plan_id;
                $new_plan->type = $request->type;
                $new_plan->video_quality = $request->video_quality;
                $new_plan->resolution = $request->resolution;
                $new_plan->devices = $plan_devices;
                $new_plan->billing_interval = $request->billing_interval;
                $c_count = Plan::where('plan_id', '=', $new_plan->plan_id)->count();
                    if ( $c_count == 0) {
                         $new_plan->save();
                         return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));
                    } else {
                        return Redirect::back()->with(array('note' => 'The  Country you were entered is already Exist', 'note_type' => 'failure'));
                    }
    }
        public function PaypalStore(Request $request) {
        
           $input = $request->all();
           $validatedData = $request->validate([
                'plans_name' => 'required|max:255',
            ]);       
            $devices = $request->devices;
            $plan_devices = implode(",",$devices);
                $new_plan = new PaypalPlan;
                $new_plan->name = $request->plans_name;
                $new_plan->payment_type = $request->payment_type;
                $new_plan->price = $request->price;
                $new_plan->plan_id = $request->plan_id;
                $new_plan->video_quality = $request->video_quality;
                $new_plan->resolution = $request->resolution;
                $new_plan->devices = $plan_devices;
     
            $c_count = PaypalPlan::where('plan_id', '=', $new_plan->plan_id)->count();
            if ( $c_count == 0) {
                 $new_plan->save();
                 return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));
            } else {
                return Redirect::back()->with(array('note' => 'The  Country you were entered is already Exist', 'note_type' => 'failure'));
            }
    }
    
            public function subscriptionstore(Request $request) {
        
           $input = $request->all();
           $validatedData = $request->validate([
                'plans_name' => 'required|max:255',
            ]);  
            // echo "<pre>";     
            // print_r($input);exit();
            $devices = $request->devices;
            $plan_devices = implode(",",$devices);


            foreach($request->plan_id as $key => $value){

                foreach($request->type as $typekey => $types){
                    if($typekey == $key){

                $new_plan = new SubscriptionPlan;
                $new_plan->type = $types;
                $new_plan->plans_name = $request->plans_name;
                $new_plan->payment_type = $request->payment_type;
                $new_plan->price = $request->price;
                $new_plan->plan_id = $value;
                $new_plan->billing_interval = $request->billing_interval;
                $new_plan->billing_type = $request->billing_type;
                $new_plan->days = $request->days;
                $new_plan->video_quality = $request->video_quality;
                $new_plan->resolution = $request->resolution;
                $new_plan->devices = $plan_devices;
                $new_plan->user_id = Auth::User()->id;            
                $new_plan->save();
                    }
                }
                }
            // foreach($request->plan_id as $key => $value){

            //     $new_plan = new SubscriptionPlan;
            //     $new_plan->plans_name = $request->plans_name;
            //     $new_plan->payment_type = $request->payment_type;
            //     $new_plan->price = $request->price;
            //     $new_plan->plan_id = $value;
            //     $new_plan->billing_interval = $request->billing_interval;
            //     $new_plan->billing_type = $request->billing_type;
            //     $new_plan->days = $request->days;
            //     $new_plan->video_quality = $request->video_quality;
            //     $new_plan->resolution = $request->resolution;
            //     $new_plan->devices = $plan_devices;
            //     $new_plan->user_id = Auth::User()->id;
            //     foreach($request->type as $key => $types){
            //     $new_plan->type = $types;
            //     $new_plan->save();
            // } 
            //     $new_plan->save();
            
            //     }
                // $new_plan = new SubscriptionPlan;
                // $new_plan->name = $request->plans_name;
                // $new_plan->payment_type = $request->payment_type;
                // $new_plan->price = $request->price;
                // $new_plan->plan_id = $request->plan_id;
                // $new_plan->billing_interval = $request->billing_interval;
                // $new_plan->billing_type = $request->billing_type;
                // $new_plan->days = $request->days;
                // $new_plan->video_quality = $request->video_quality;
                // $new_plan->resolution = $request->resolution;
                // $new_plan->devices = $plan_devices;
                
                return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));
     
          
    }
    
    
    public function update(Request $request) {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'days' => 'required|max:255',
            'price' => 'required|max:255',
            'type' => 'required|max:255',
        ]);
        $input = $request->all();
        if(!empty($request->video_quality)){
            $video_quality = $request->video_quality;
        }else{
            $video_quality = null;
        }
        $devices = $input['devices'];
        $plan_devices = implode(",",$devices);

        $id = $request->id;
        $plans = Plan::find($id);

    	$plans->plans_name = $request->plans_name;
 		$plans->days = $request->days;
 		$plans->payment_type = $request->payment_type;
 		$plans->price  = $request->price;
        $plans->plan_id  = $request->plan_id;
        $plans->type  = $request->type;
        $plans->video_quality = $input['video_quality'];
        $plans->resolution = $input['resolution'];
        $plans->devices = $plan_devices;
 		$plans->billing_interval  = $request->billing_interval;
		$plans_count = Plan::where('plans_name', '=', $plans->plans_name)->count();
        $plans->save();
        
        return Redirect::to('admin/plans/')->with(array('note' => 'You have been successfully Added New Plan', 'note_type' => 'success'));
    }   
    
    public function PaypalUpdate(Request $request) {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'plan_id' => 'required|max:255',
            'price' => 'required|max:255',
        ]);
        
        $input = $request->all();
        
        $devices = $input['devices'];
        $plan_devices = implode(",",$devices);
        $id = $request['id'];
        $plans = PaypalPlan::find($id);
    	$plans->name = $request['plans_name'];
    	$plans->price = $request['price'];
    	$plans->payment_type = $request['payment_type'];
        $plans->video_quality = $input['video_quality'];
        $plans->resolution = $input['resolution'];
        $plans->devices = $plan_devices;
        $plans->plan_id  = $request['plan_id'];
        $plans->save();
        
        return Redirect::to('admin/paypalplans/')->with(array('note' => 'You have been successfully Added New Plan', 'note_type' => 'success'));
    }

    public function subscriptionupdate(Request $request) {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'plan_id' => 'required|max:255',
            'price' => 'required|max:255',
        ]);
        $input = $request->all();
        // dd($input);

        // $edit_plan = SubscriptionPlan::find($id);
        // $payment_settings = PaymentSetting::all();
        $devices = $input['devices'];
        $plan_devices = implode(",",$devices);
        $id = $request['id'];
        $plans = SubscriptionPlan::find($id);
    	$plans->plans_name = $request['plans_name'];
    	$plans->price = $request['price'];
    	$plans->payment_type = $request['payment_type'];
        $plans->video_quality = $input['video_quality'];
        $plans->resolution = $input['resolution'];
        $plans->devices = $plan_devices;
        $plans->plan_id  = $request['plan_id'];
        $plans->save();
        
        return Redirect::to('admin/subscription-plans/')->with(array('note' => 'You have been successfully Added New Plan', 'note_type' => 'success'));
    }

    public function DevicesIndex()
    {
        
         $devices = Devices::all();
        
         $data = array(
                   'devices' => $devices        	
         );
        return view('admin.devices.index',compact('devices'));
    }

    public function DevicesStore(Request $request) {

        $input = $request->all();
        $devices = new Devices;
    	$devices->devices_name = $request['devices_name'];
    	$devices->user_id = Auth::User()->id;
        $devices->save();
        
        return Redirect::back()->with(array('note' => 'You have been successfully Added New Devices', 'note_type' => 'success'));
    }
    
     public function DevicesEdit($id) {
    	 $edit_devices =  Devices::where('id', '=', $id)->first();
         
         $data = array(
        	   'devices' => $edit_devices
        	);
        return view('admin.devices.edit',$data);

    }
    
    
    public function DevicesDelete($id) {
    	
        Devices::where('id',$id)->delete();

    	return Redirect::back()->with(array('note' => 'You have been successfully Added New Devices', 'note_type' => 'success'));

    }

      public function DevicesUpdate(Request $request) {

        $input = $request->all();
        $id = $request['id'];
        $devices = Devices::find($id);
        $devices->devices_name = $request['devices_name'];
    	$devices->user_id = Auth::User()->id;
        $devices->save();
        
        return Redirect::back()->with(array('note' => 'You have been successfully Added New Coupon', 'note_type' => 'success'));
    }












    
}
