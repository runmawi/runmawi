@extends('admin.master')

@section('content')
  <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">
 
                  <div class="col-sm-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">User</h4>
                           </div>
                        </div>
                        
                        <div class="iq-card-body">
                           <div class="table-view">
                           <table class="table table-bordered table-striped w-auto mentors">       
        <tr>
          <th class="headings">Username</th>
          <td>{{ $users->username }}</td>
        </tr>
        <tr>
          <th class="headings">User ID</th>
          <td>Flicknexs_{{ $users->id }}</td>
        </tr>

        <tr>
          <th class="headings">Email</th>
          <td>{{ $users->email }}</td>
        </tr>
        <tr>
          <th class="headings">Contact Details</th>
          <td>{{ $users->mobile }}</td>
        </tr>
        <tr>
          <th class="headings">Country Name</th>
          <td>{{ $country_name ? $country_name[0]['country_name'] : null }}</td>
        </tr>
<?php

$plans_name = ""; 
$created_at = "";
$end_date = "";
foreach($current_plan as $plan){
    $subscription_date = $plan->created_at;
    $date = date_create($subscription_date);
    $subscription_date = date_format($date, 'Y-m-d');
    $start_date = date('Y-m-d', strtotime($subscription_date));
$subscription_date = $plan->created_at;
$days = $plan->days.'days';
$date = date_create($subscription_date);
$subscription_date = date_format($date, 'Y-m-d');
$end_date= date('Y-m-d', strtotime($subscription_date. ' + ' .$days)); 
$plans_name = $plan->plans_name ;
$created_at = $start_date ;

 }

?>

        <tr>
          <th class="headings">Current Package </th>
          <td>{{ $plans_name }}</td>
        </tr>

        <tr>
          <th class="headings">Subscription Start Date</th>
          <td>{{ $created_at }}</td>
        </tr>
        <tr>
          <th class="headings">Subscription End Date</th>
          <td> {{  $end_date }}</td>
        </tr>
   
        <tr>
          <th class="headings">User Type</th>
          <td>{{ $users->role }}</td>
        </tr>

    </table>
</div>
</div>
</div>
<style>
.headings { font-weight: bold; }



</style>
                                       </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>







