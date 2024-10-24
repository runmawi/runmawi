<?php

namespace App\Http\Controllers;
use Auth;
use View;
use Redirect;
use \App\User as User;
use GuzzleHttp\Client;
use App\Setting as Setting;
use Illuminate\Http\Request;
use App\PartnerMonetizationSetting;

class AdminPartnerMonetizationSettings extends Controller
{

    public function Index()
    {
        
        if (!Auth::guest() && Auth::user()->package == 'Channel' || Auth::user()->package == 'CPP') {
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
            // $revenue_settings = PartnerMonetizationSetting::get();
            // $data = array(
            //             'revenue_settings' => $revenue_settings  ,
            // );
            // return view('admin.revenuesettings.index',$data);
            $partner_monetization_settings = PartnerMonetizationSetting::where('id', '=', 1)->first();
            $data = array(
                'partner_monetization_settings' => $partner_monetization_settings,
            );
            return view('admin.partner_monetization_settings.edit');
        }
    }

    // public function Store(Request $request)
    // {
    //     $input = $request->all();
    //     $revenue_settings = new PartnerMonetizationSetting;
    //     $revenue_settings->admin_commission = $input['admin_commission'];
    //     $revenue_settings->user_commission = $input['user_commission'];
    //     $revenue_settings->vod_admin_commission = $input['vod_admin_commission'];
    //     $revenue_settings->vod_user_commission = $input['vod_user_commission'];
    //     $revenue_settings->user_id = Auth::User()->id;
    //     $revenue_settings->save();
    //     return Redirect::back();

    // }

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

    // public function Edit($id)
    // {
    //     if (!Auth::guest() && Auth::user()->package == 'Channel' || Auth::user()->package == 'CPP') {
    //         return redirect('/admin/restrict');
    //     }
    //     $user = User::where('id', 1)->first();
    //     $duedate = $user->package_ends;
    //     $current_date = date('Y-m-d');
    //     if ($current_date > $duedate) {
    //         $client = new Client();
    //         $url = "https://flicknexs.com/userapi/allplans";
    //         $params = [
    //             'userid' => 0,
    //         ];

    //         $headers = [
    //             'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
    //         ];
    //         $response = $client->request('post', $url, [
    //             'json' => $params,
    //             'headers' => $headers,
    //             'verify' => false,
    //         ]);

    //         $responseBody = json_decode($response->getBody());
    //         $settings = Setting::first();
    //         $data = array(
    //             'settings' => $settings,
    //             'responseBody' => $responseBody,
    //         );
    //         return View::make('admin.expired_dashboard', $data);
    //     } else if (check_storage_exist() == 0) {
    //         $settings = Setting::first();

    //         $data = array(
    //             'settings' => $settings,
    //         );

    //         return View::make('admin.expired_storage', $data);
    //     } else {
    //         $revenue_settings = PartnerMonetizationSetting::where('id', '=', $id)->first();
    //         $data = array(
    //             'revenue_settings' => $revenue_settings,
    //         );
    //         return view('admin.revenuesettings.edit', $data);
    //     }
    // }

    // public function Delete($id)
    // {

    //     PartnerMonetizationSetting::destroy($id);

    //     return Redirect::back();
    // }

}
