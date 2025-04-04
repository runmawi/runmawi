<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Auth;
use Hash;
use View;
use Flash;
use Image;
use App\Plan;
use App\Video;
use App\Setting;
use App\PpvPurchase;
use App\Subscription;
use \App\User as User;
use App\EmailTemplate;
use GuzzleHttp\Client;
use App\VideoCommission;
use App\SubscriptionPlan;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use Laravel\Cashier\Invoice;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use App\SeriesSeason;
use App\Series;
use App\Livestream;

class AdminPaymentManagementController extends Controller
{
    public function index()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $revenue =  SubscriptionPlan::select(('subscription_plans.price'))
        ->join('subscriptions','subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
        ->get();



// dd($revenue);

        $subscription_revenue = 0 ;
        foreach($revenue as $key => $value){
        foreach($value as $key => $price){
            $subscription_revenue += $price;
        
        }
    }
    $video_revenue =  Video::join('ppv_purchases', 'videos.id', '=', 'ppv_purchases.video_id')
    ->select(('videos.ppv_price'))
    ->get(); 
    $ppv_revenue = 0 ;
    foreach($video_revenue as $key => $value){
    foreach($value as $key => $ppv_price){
        $ppv_revenue += $ppv_price;

    }

}


    // exit();

        // SELECT SUM(plans.price) FROM `subscriptions` INNER JOIN plans on subscriptions.stripe_id = plans.plan_id;

        $data = array(
            'subscription_revenue' => $subscription_revenue,
            'ppv_revenue' => $ppv_revenue,
            );

        return View('admin.payment.charts', $data);

        }
    }
    
    public function SubscriptionIndex()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{

    //    $user = User::where('role', '!=' , 'admin')->get();
       $subscription = Subscription::select('subscriptions.*','users.*','subscription_plans.plans_name as subscription_plans_name','subscription_plans.type as subscription_plans_type')
       ->join('users', 'subscriptions.user_id', '=', 'users.id')
       ->join('subscription_plans', 'subscription_plans.plan_id', '=', 'subscriptions.stripe_id')
       ->where('users.role', '!=' , 'admin')
       ->where('subscriptions.price', '!=' , '')
       ->get();

        // dd($subscription);
        $data = array(
            'subscription' => $subscription,
            );
        return View('admin.payment.subscription_payment', $data);
        }
    }

    public function SubscriptionView($id)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        // dd($id);
        $subscription = Subscription::select('subscriptions.*','users.*')
        ->join('users', 'subscriptions.user_id', '=', 'users.id')
        ->where('subscriptions.user_id', '=' , $id)
        ->get();
        // dd($subscription);
 
        $data = array(
            'subscription' => $subscription,
            );
        return View('admin.payment.subscription_view', $data);
        }
    }

    public function PayPerViewIndex()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $PayPerView = PpvPurchase::select('ppv_purchases.*','videos.*','users.*')
        ->join('videos', 'ppv_purchases.video_id', '=', 'videos.id')
        ->join('users', 'ppv_purchases.user_id', '=', 'users.id')
        ->orderBy('ppv_purchases.created_at', 'desc') 
        // ->where('users.role', '!=' , 'admin')
        ->get();
//         $video = Video::where('id','=',103)->first();  
//         $commssion = VideoCommission::first();
//         $percentage = $commssion->percentage; 
//         $ppv_price = $video->ppv_price;
//         $admin_commssion = ($percentage * 100) / $ppv_price ;
//         $turnover = 10000;
// $overheads = 12500;
// $difference = abs($turnover-$overheads);
//         $moderator_commssion = $ppv_price - $percentage;
//          dd($admin_commssion);


        $perPage = 10; 
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $PayPerView->forPage($currentPage, $perPage);
        $PayPerView = new LengthAwarePaginator(
            $currentItems, 
            $PayPerView->count(), 
            $perPage, 
            $currentPage, 
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

         $data = array(
             'payperView' => $PayPerView,
             );
         return View('admin.payment.ppv_payment', $data);
            }
    }




    public function PayPerView_search(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->get("query"))) {

                $output = "";
                $query = $request->get("query");

                $payPerView = PpvPurchase::select('ppv_purchases.*', 'videos.title as video_title', 'users.username as username')
                    ->join('videos', 'ppv_purchases.video_id', '=', 'videos.id')
                    ->join('users', 'ppv_purchases.user_id', '=', 'users.id')
                    ->where(function ($q) use ($query) {
                        $q->where('users.username', 'LIKE', "%" . $query . "%")
                            ->orWhere('videos.title', 'LIKE', "%" . $query . "%")
                            ->orWhere('ppv_purchases.payment_id', 'LIKE', "%" . $query . "%");
                    })
                    ->orderBy('ppv_purchases.created_at', 'desc')
                    ->get();

                $perPage = 10;
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $currentItems = $payPerView->forPage($currentPage, $perPage);
                $paginatedPayPerView = new LengthAwarePaginator(
                    $currentItems,
                    $payPerView->count(),
                    $perPage,
                    $currentPage,
                    ['path' => LengthAwarePaginator::resolveCurrentPath()]
                );

                if (count($paginatedPayPerView) > 0) {
                    $total_row = $paginatedPayPerView->count();
                    foreach ($paginatedPayPerView as $i => $payment) {
                        $output .= '
                        <tr>
                            <td>' . ($i + 1) . '</td>
                            <td>' . $payment->username . '</td>
                            <td>' . $payment->video_title . '</td>
                            <td>' . ($payment->payment_id ?: 'N/A') . '</td>
                            <td>₹ ' . ($payment->total_amount ?: '0.00') . '</td>
                            <td>₹ ' . ($payment->admin_commssion ?: '0.00') . '</td>
                            <td>₹ ' . ($payment->moderator_commssion ?: '0.00') . '</td>
                            <td>' . ($payment->status ?: 'N/A') . '</td>
                            <td>
                                <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="View"
                                    href="' . route('admin.ppvpayment.view', $payment->video_id) . '">
                                    <i class="lar la-eye"></i>
                                </a>
                            </td>
                        </tr>';
                    }
                } else {
                    $output = '
                        <tr>
                            <td align="center" colspan="9">No Data Found</td>
                        </tr>';
                }

                // Return the output as JSON with paginated data
                $data = [
                    "table_data" => $output,
                    "total_data" => $total_row,
                ];
                echo json_encode($data);
            }
        }
    }





    public function PayPerView($id)
    {
        // dd($id);
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $PayPerView = PpvPurchase::select('ppv_purchases.*','videos.*','users.*')
        ->join('videos', 'ppv_purchases.video_id', '=', 'videos.id')
        ->join('users', 'ppv_purchases.user_id', '=', 'users.id')
        ->where('ppv_purchases.video_id', '=' , $id)
        ->get();
        // dd($PayPerView);
 
        $data = array(
            'payperView' => $PayPerView,
            );
        return View('admin.payment.ppv_view', $data);

        }
    }
   
    public function Subscription_search(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');
         $view = URL::to('admin/subscription/view');
        //  $edit = URL::to('admin/template/edit');
      if($query != '')
      {
        $data = Subscription::select('subscriptions.*','users.*')
        ->join('users', 'subscriptions.user_id', '=', 'users.id')
        ->where('users.username', 'like', '%'.$query.'%')
        ->orWhere('users.user_type', 'like', '%'.$query.'%')
        ->orWhere('users.card_type', 'like', '%'.$query.'%')
        ->orderBy('subscriptions.created_at', 'desc')
        ->paginate(9);

      }
      else
      {

      }
      $i = 1 ;
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$i++.'</td>
        <td>'.$row->username.'</td>
        <td>'.$row->email.'</td>
        <td>'.$row->user_type.'</td>
        <td>'.$row->stripe_id.'</td>
        <td>'.$row->card_type.'</td>
        <td>'.'₹'. $row->price.'</td>
        <td>'.$row->ends_at.'</td>
        <td>'.$row->stripe_status.'</td>
         <td> '."<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $view/$row->id'><i class='lar la-eye'></i>
        </a>".'
        </td>
        </tr>
        ';
       }
      }
    //   '."<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
    //     </a>".'
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
}

}