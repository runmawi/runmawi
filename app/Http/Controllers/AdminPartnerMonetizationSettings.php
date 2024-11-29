<?php

namespace App\Http\Controllers;

use App\PartnerMonetizationSetting;
use App\Setting as Setting;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Redirect;
use View;
use \App\User as User;

class AdminPartnerMonetizationSettings extends Controller
{

    public function Index()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::guest() && (Auth::user()->package == 'Channel' || Auth::user()->package == 'CPP')) {
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = array(
                'settings' => $settings,
                'responseBody' => $responseBody,
            );
            return View::make('admin.expired_dashboard', $data);
        } else if (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $partner_monetization_settings = PartnerMonetizationSetting::where('id', '=', 1)->first();
            $data = array(
                'partner_monetization_settings' => $partner_monetization_settings,
            );
            return view('admin.partner_monetization_settings.edit', $data);
        }
    }

    public function Store(Request $request)
    {
        $input = $request->all();
        $partner_monetization_settings = new PartnerMonetizationSetting;
        $partner_monetization_settings->viewcount_limit = $input['viewcount_limit'];
        $partner_monetization_settings->views_amount = $input['views_amount'];
        $partner_monetization_settings->user_id = Auth::User()->id;
        $partner_monetization_settings->save();
        return Redirect::back();
    }

    public function Update(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $partner_monetization_settings = PartnerMonetizationSetting::find($id);
        if (empty($partner_monetization_settings)) {
            // dd($partner_monetization_settings);
            $partner_monetization_settings = new PartnerMonetizationSetting;
        }
        $partner_monetization_settings->viewcount_limit = $input['viewcount_limit'];
        $partner_monetization_settings->views_amount = $input['views_amount'];
        $partner_monetization_settings->user_id = Auth::User()->id;
        $partner_monetization_settings->save();
        return Redirect::back();
    }

    public function Edit($id)
    {
         if (!Auth::check()) {
            return redirect()->route('login');
        }
         
        if (!Auth::guest() && (Auth::user()->package == 'Channel' || Auth::user()->package == 'CPP')) {
            return redirect('/admin/restrict');
        }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = array(
                'settings' => $settings,
                'responseBody' => $responseBody,
            );
            return View::make('admin.expired_dashboard', $data);
        } else if (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $partner_monetization_settings = PartnerMonetizationSetting::where('id', '=', $id)->first();
            $data = array(
                'partner_monetization_settings' => $partner_monetization_settings,
            );
            return view('admin.partner_monetization_settings.edit', $data);
        }
    }

}
