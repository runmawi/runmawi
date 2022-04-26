<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country as Country;
use \Redirect as Redirect;
use App\User as User;
use App\Setting as Setting;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class AdminManageCountries extends Controller
{
    public function Index() {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
            $country = Country::all();
            $data = array(
        	   'countries' => $country
        	);
            return view('admin.countries.index',$data);
        }
    }
    
    public function store(Request $request) {
            $input = $request->all();
            $county = new Country();
            $county->country_name = $input['country_name'];
            $county->save();
            return Redirect::back()->with(array('note' => 'You have been successfully Added New Country', 'note_type' => 'success'));
    }


    public function delete($county_id) {
            Country::find($county_id)->delete();
            return Redirect::back()->with(array('note' => 'Country Deleted successfully', 'note_type' => 'success'));
    }
}
