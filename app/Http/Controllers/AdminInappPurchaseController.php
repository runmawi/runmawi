<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Redirect as Redirect;
use URL;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use App\InappPurchase;

class AdminInappPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $Inapp_Purchase = InappPurchase::all();

        return view('admin.Inapp_purchase.index',compact('Inapp_Purchase'));
    }

    public function store(Request $request){

        InappPurchase::create([
            'plan_price' => $request->plan_price,
            'product_id' => $request->product_id,
        ]);

        return Redirect::back()->with(array('message' => 'Successfully Created In-App Purchase Plans!', 'note_type' => 'success') );

    }

    public function edit(Request $request,$id)
    {
        $Inapp_Purchase = InappPurchase::where('id', '=', $id)->first();
        return view('admin.Inapp_purchase.edit',compact('Inapp_Purchase','Inapp_Purchase'));
    }

    public function update(Request $request)
    {
        InappPurchase::where('id',$request->id)->update([
            'plan_price' => $request->plan_price,
            'product_id' => $request->product_id,
        ]);

        return Redirect::back()->with(array('message' => 'Successfully Updated  In-App Purchase Plans!', 'note_type' => 'success') );
    }

    public function delete(Request $request,$id)
    {
       InappPurchase::where('id',$id)->delete();
       return Redirect::back()->with(array('message' => 'Successfully Deleted  In-App Purchase Plans', 'note_type' => 'success') );
    }
}
