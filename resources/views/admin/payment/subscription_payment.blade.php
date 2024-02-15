@extends('admin.master')
<style>
    .form-control{
        background: #fff!important;
    }
</style>

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Subscription Payment</h4>
                        </div>
                        
                        
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" />
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table  text-center iq-card" style="width:100%" id="subscription_payment">
                              <thead>
                                 <tr class="r1">
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Subscription Title</th>
                                    <th>Payment ID</th>
                                    <th>Payment Mode</th>
                                    <th>Paid Amount</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $i = 1 ; ?>
                              @foreach($subscription as $payment)
                                 <tr>
                                 <td> <p class="mb-0">{{ $i++ }}</p></td>
                                 <td> <p class="mb-0"></p>{{ $payment->username }}</td>
                                 <td> <p class="mb-0"></p>{{ $payment->email }}</td>
                                 <td> <p class="mb-0">{{ @$payment->subscription_plans_name }}</p></td>
                                 <td> <p class="mb-0">{{ $payment->stripe_id ? ($payment->stripe_id) : "Cus_ Not Available" }}</p></td>
                                 <td> <p class="mb-0">{{ $payment->subscription_plans_type }}</p></td>

                                    <td>
                                       <div class="media align-items-center">
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0"> {{ currency_symbol().' '.$payment->price }}</p>
                                          </div>
                                       </div>
                                    </td>
                                    <td>
                                    <p class="mb-0">{{ $payment->ends_at }}</p>
                                    </td>
                                    <td>
                                    <p class="mb-0">{{ $payment->stripe_status }}</p>
                                    </td>
                                    <td>
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('admin/subscription/view') . '/' . $payment->user_id }}"><i class="lar la-eye"></i></a>
                                          <!-- <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/subscription/edit') . '/' . 1 }}"><i class="ri-pencil-line"></i></a> -->
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="clear"></div>

		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

         <script>
$(document).ready(function(){

   $(document).ready(function() {
    $('#subscription_payment').DataTable();
});

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ URL::to('admin/subscription_search') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>

@stop

