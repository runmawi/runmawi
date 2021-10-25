@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
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
                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " style="width:100%">
                              <thead>
                                 <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Video Title</th>
                                    <th>Payment ID</th>
                                    <th>Payment Mode</th>
                                    <th>Padi Amount</th>
                                    <th>Admin Amount</th>
                                    <th>Moderator Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $i = 1 ; ?>
                              @foreach($payperView as $payment)
                                 <tr>
                                 <td> <p class="mb-0">{{ $i++ }}</p></td>
                                 <td> <p class="mb-0"></p>{{ $payment->username }}</td>
                                 <td> <p class="mb-0">{{ $payment->title }}</p></td>
                                 <td> <p class="mb-0">{{ $payment->stripe_id }}</p></td>
                                 <td> <p class="mb-0">{{ $payment->card_type }}</p></td>
                                 <td> <p class="mb-0">₹ {{ $payment->total_amount }}</p></td>
                                 <td> <p class="mb-0">₹ {{ $payment->admin_commssion }}</p></td>
                                 <td> <p class="mb-0">₹ {{ $payment->moderator_commssion }}</p></td>
                                    <td>
                                    <p class="mb-0">{{ $payment->status }}</p>
                                    </td>
                                    <td>
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('admin/ppvpayment/view') . '/' . $payment->video_id }}"><i class="lar la-eye"></i></a>
                                          <!-- <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/subscription/edit') . '/' . 1 }}"><i class="ri-pencil-line"></i></a> -->
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <!-- <div class="clear"></div> -->

		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      
         <script>
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ URL::to('/PayPerView_search') }}",
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

