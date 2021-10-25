<?php

namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\EmailTemplate;
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
        $revenue =  DB::table('subscriptions')
        ->join('plans', 'subscriptions.stripe_id', '=', 'plans.plan_id')
        ->select(('plans.price'))
        ->get();
        $subscription_revenue = 0 ;
        foreach($revenue as $key => $value){
        foreach($value as $key => $price){
            $subscription_revenue += $price;
        }
    }
    $video_revenue =  DB::table('videos')
    ->join('ppv_purchases', 'videos.id', '=', 'ppv_purchases.video_id')
    ->select(('videos.ppv_price'))
    ->get(); 
    $ppv_revenue = 0 ;
    foreach($video_revenue as $key => $value){
    foreach($value as $key => $ppv_price){
        $ppv_revenue += $ppv_price;
    }
}
    // echo "<pre>";
    // print_r($ppv_revenue);
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




    	// $users = User::all();
        // foreach($users as $user){
        // dd($user->invoices());

        // $invoices[] = $user->invoices();
        // }
        // // dd($invoices);

        // $date = date('m/d/Y',strtotime("-1 days"));
        // foreach($invoices as $invoice){
        //     $data_invoices[] = $invoice;
        //     }
        //     foreach($data_invoices as $values){
        //     foreach($values as $value){  
        //       $created_date = date('m/d/Y', $value->created); 
            
        //     if($date == $created_date){
        //       $update_date = date('Y-m-d H:i:s', $value->created); 

        //         // echo "<pre>";
        //         // print_r($value);
        //         User::where('stripe_id', $value->customer)
        //                     ->update([
        //                         'previous_update_date' => $update_date
        //                         ]);

        //             }
        //         }  
        //     }


        // dd('test');
        $data = array(
            'subscription' => '$subscription',
            );
        return View('admin.payment.subscription_payment', $data);
        
    }
    public function PayPerViewIndex()
    {
       
    }
   
    public function Template_search(Request $request)
    {
        if($request->ajax())
     {

      $output = '';
      $query = $request->get('query');
         $view = URL::to('admin/template/view');
         $edit = URL::to('admin/template/edit');
      if($query != '')
      {
       $data = DB::table('email_templates')
         ->where('template_type', 'like', '%'.$query.'%')
         ->orderBy('created_at', 'desc')
         ->paginate(9);
         
      }
      else
      {

      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>'.$row->id.'</td>
        <td>'.$row->template_type.'</td>
        <td>'.$row->heading.'</td>
         <td> '."<a class='iq-bg-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='View' href=' $view/$row->id'><i class='lar la-eye'></i>
        </a>".'
        '."<a class='iq-bg-success' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit' href=' $edit/$row->id'><i class='ri-pencil-line'></i>
        </a>".'
        </td>
        </tr>
        ';
       }
      }
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