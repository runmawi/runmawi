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
use App\Tag as Tag;
use App\Coupon as Coupon;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Response;

class AdminCouponManagement extends Controller
{
    public function index()
    {
        
         $coupons = Coupon::all();
        
         $data = array(
                   'coupons' => $coupons        	
         );
        return view('admin.coupons.index',compact('coupons'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'coupon_code' => 'required|max:255'
        ]);
        $input = $request->all();
        $coupons = new Coupon;
    	$coupons->coupon_code = $request['coupon_code'];
        $coupons->save();
        
        return Redirect::back()->with(array('note' => 'You have been successfully Added New Coupon', 'note_type' => 'success'));
    }
    
     public function edit($id) {
    	 $edit_coupons =  Coupon::where('id', '=', $id)->get();
         
         $data = array(
        	   'edit_coupons' => $edit_coupons
        	);
        return view('admin.coupons.edit',$data);

    }
    
    
    public function delete($id) {
    	
        Coupon::where('id',$id)->delete();

    	return Redirect::back()->with(array('note' => 'You have been successfully Added New Coupon', 'note_type' => 'success'));

    }

      public function update(Request $request) {
        $validatedData = $request->validate([
            'coupon_code' => 'required|max:255'
        ]);
        $input = $request->all();
        $id = $request['id'];
        $plans = Coupon::find($id);
    	$plans->coupon_code = $request['coupon_code'];
 		
        $plans->save();
        
        return Redirect::back()->with(array('note' => 'You have been successfully Added New Coupon', 'note_type' => 'success'));
    }
    
    
}
