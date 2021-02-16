<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country as Country;
use \Redirect as Redirect;

class AdminManageCountries extends Controller
{
    public function Index() {
            $country = Country::all();
            $data = array(
        	   'countries' => $country
        	);
            return view('admin.countries.index',$data);
    }
    
    public function store(Request $request) {
            $input = $request->all();
            $county = new Country();
            $county->country_name = $input['country_name'];
            $county->save();
            return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));
    }
}
