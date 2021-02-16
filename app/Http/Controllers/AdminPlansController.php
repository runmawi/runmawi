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


class AdminPlansController extends Controller
{
    
    public function index()
    {
      $slug = Str::slug('Laravel 5 Framework', '-');
        $plans = Plan::all();
         $data = array(
        	'plans' => $plans
        	
        	);
         return view('admin.plans.index',compact('plans','allplans'));
    }   
    
public function PaypalIndex()
    {
        
        $slug = Str::slug('Laravel 5 Framework', '-');
        
        $plans = PaypalPlan::all();
         $data = array(
        	'plans' => $plans
        	
        	);
         return view('admin.paypal.index',compact('plans','allplans'));
    }
    
     public function edit($id) {
    	 $edit_plan =  Plan::where('id', '=', $id)->get();
         $data = array(
        	'edit_plan' => $edit_plan
        	);
        return view('admin.plans.edit',$data);

    } 
    
    public function PaypalEdit($id) {
    	 
         $edit_plan =  PaypalPlan::where('id', '=', $id)->get();
         $data = array(
        	'edit_plan' => $edit_plan
        	);
        return view('admin.paypal.edit',$data);

    }
    
    
    public function delete($id) {
    	
        Plan::where('id',$id)->delete();

    	return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));

    }    
    public function PaypalDelete($id) {
    	
        PaylPlan::where('id',$id)->delete();

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
                $new_plan = new Plan;
                $new_plan->plans_name = $request->plans_name;
                $new_plan->days = $request->days;
                $new_plan->payment_type = $request->payment_type;
                $new_plan->price = $request->price;
                $new_plan->plan_id = $request->plan_id;
                $new_plan->type = $request->type;
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
            
                $new_plan = new PaypalPlan;
                $new_plan->name = $request->plans_name;
                $new_plan->payment_type = $request->payment_type;
                $new_plan->price = $request->price;
                $new_plan->plan_id = $request->plan_id;
     
            $c_count = PaypalPlan::where('plan_id', '=', $new_plan->plan_id)->count();
            if ( $c_count == 0) {
                 $new_plan->save();
                 return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));
            } else {
                return Redirect::back()->with(array('note' => 'The  Country you were entered is already Exist', 'note_type' => 'failure'));
            }
    }
    
    
    public function update(Request $request) {
        $validatedData = $request->validate([
            'plans_name' => 'required|max:255',
            'days' => 'required|max:255',
            'price' => 'required|max:255',
            'type' => 'required|max:255',
        ]);
        $input = $request->all();
        $id = $request->id;
        $plans = Plan::find($id);
    	$plans->plans_name = $request->plans_name;
 		$plans->days = $request->days;
 		$plans->payment_type = $request->payment_type;
 		$plans->price  = $request->price;
        $plans->plan_id  = $request->plan_id;
        $plans->type  = $request->type;
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
        $id = $request['id'];
        $plans = PaypalPlan::find($id);
    	$plans->name = $request['plans_name'];
    	$plans->price = $request['price'];
    	$plans->payment_type = $request['payment_type'];
        $plans->plan_id  = $request['plan_id'];
        $plans->save();
        
        return Redirect::to('admin/paypalplans/')->with(array('note' => 'You have been successfully Added New Plan', 'note_type' => 'success'));
    }
    
}
