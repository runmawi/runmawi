<?php

namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\EmailTemplate;
use App\Video;
use App\Plan;
use App\Subscription;
use App\VideoCommission;
use App\PpvPurchase;
use Laravel\Cashier\Invoice;
use URL;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use DB;
use Flash;

class AdminPaymentManagementController extends Controller
{
    public function index()
    {
        $revenue =  Plan::select(('plans.price'))
        ->join('subscriptions','subscriptions.stripe_plan', '=', 'plans.plan_id')
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
    
    public function SubscriptionIndex()
    {

    //    $user = User::where('role', '!=' , 'admin')->get();
       $subscription = Subscription::select('subscriptions.*','users.*')
       ->join('users', 'subscriptions.user_id', '=', 'users.id')
       ->where('users.role', '!=' , 'admin')
       ->get();

        // dd($user);
        $data = array(
            'subscription' => $subscription,
            );
        return View('admin.payment.subscription_payment', $data);
        
    }

    public function SubscriptionView($id)
    {
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

    public function PayPerViewIndex()
    {
        $PayPerView = PpvPurchase::select('ppv_purchases.*','videos.*','users.*')
        ->join('videos', 'ppv_purchases.video_id', '=', 'videos.id')
        ->join('users', 'ppv_purchases.user_id', '=', 'users.id')
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
         $data = array(
             'payperView' => $PayPerView,
             );
         return View('admin.payment.ppv_payment', $data);
    }

    public function PayPerView($id)
    {
        // dd($id);
 
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















public function PayPerView_search(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');
         $view = URL::to('admin/ppvpayment/view');
        //  $edit = URL::to('admin/template/edit');
      if($query != '')
      {
        $data =  PpvPurchase::select('ppv_purchases.*','videos.*','users.*')
        ->join('videos', 'ppv_purchases.video_id', '=', 'videos.id')
        ->join('users', 'ppv_purchases.user_id', '=', 'users.id')
        ->where('users.username', 'like', '%'.$query.'%')
        ->orWhere('videos.title', 'like', '%'.$query.'%')
        ->orWhere('users.card_type', 'like', '%'.$query.'%')
        ->orderBy('ppv_purchases.created_at', 'desc')
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
        <td>'.$row->title.'</td>
        <td>'.$row->stripe_id.'</td>
        <td>'.$row->card_type.'</td>
        <td>'.'₹'. $row->total_amount.'</td>
        <td>'.'₹'.$row->admin_commssion.'</td>
        <td>'.'₹'.$row->moderator_commssion.'</td>
        <td>'.$row->status.'</td>

         <td> '."<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $view/$row->video_id'><i class='lar la-eye'></i>
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