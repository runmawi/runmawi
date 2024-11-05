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
                  
                           {{-- Title Header --}}

                  <div class="iq-card-header d-flex justify-content-between">
                     <div class="iq-header-title">
                        <h4 class="card-title">Channel Subscription Plans</h4>
                     </div>

                     <div class="iq-card-header-toolbar d-flex align-items-center">
                        <a data-toggle="modal" data-target='#edit_modal' class="btn btn-primary create_channel_plan">Create Plans</a>
                     </div>
                  </div>

                  <div class="iq-card-header d-flex justify-content-between">
                     <div class="iq-header-title">
                        <div class="row">
                           <div class="col-sm-12 d-flex">
                               <label class="m-0">Enable / Disable  Plans Page </label>
                               <div class="panel-body">
                                   <div class="mt-1 p-1">
                                       <label class="switch">
                                           <input name="user_channel_plans_page_status" class="user_channel_plans_page_status" type="checkbox" {{ ($setting->user_channel_plans_page_status) == "1" ? 'checked' : ''  }}  onchange="user_channel_plans_page_status(this)" >
                                           <span class="slider round"></span>
                                       </label>
                                   </div>
                               </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="iq-card-body table-responsive">
                     <div class="table-view">
                        <table class="table table-striped table-bordered table movie_table" id="Subscription_Plans" style="width:100%">

                           <thead>
                              <tr class="r1">
                                 <th>#</th>
                                 <th>Plan Name</th>
                                 <th>Plan Price</th>
                                 <th>Days</th>
                                 <th>Billing Interval</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                           </thead>

                           <tbody>
                              @foreach($Channel_Subscription_Plans as $key => $plan)
                                 <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $plan->plan_name }}</td>
                                    <td>{{ $plan->price }}</td>
                                    <td>{{ $plan->days }}</td>
                                    <td>{{ $plan->billing_interval }}</td>
                                    <td>{{ $plan->status == 1 ? "ON" : "OFF" }}</td>
                                    <td>
                                       <a class="iq-bg-success edit-ads-plans" data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="Edit" data-toggle="modal" data-target='#edit_modal' data-id="{{ $plan->id }}"><img class="ply" src="{{ URL::to('/assets/img/icon/edit.svg') }}">
                                       </a>

                                       <a onclick="return confirm('Are you sure?')" href="{{ route('admin.user-channel-subscription-plan.delete',[$plan->id]) }}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                          <img class="ply" src="{{ URL::to('/assets/img/icon/delete.svg') }}">
                                       </a>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <div class="clear"></div>
                        <div class="pagination-outter"><?= $Channel_Subscription_Plans->appends(Request::only('s'))->render(); ?></div>
                     </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {{-- Modal --}}
      <div class="modal fade" id="edit_modal">
         <div class="modal-dialog">
            <form id="channel-subscription-plan">

               <div class="modal-content">
                  <input type="hidden" id="id" name="id" value="">
                  <input type="hidden" id="token" value="{{csrf_token()}}">
                  <input type="hidden" id="url" name="url" value="">
                  
                  <div class="modal-body">
                     <div class="row d-flex p-0">

                        <div class="col-md-12 pb-2">
                           <label for="plan_name">Plan Name</label>
                           <input type="text" name="plan_name" id="plan_name" class="form-control" placeholder="Plan Name" >
                        </div>

                        @forelse ($payment_settings as $item)
                           <div class="col-md-12 pb-2">
                              <label>{{ $item->payment_type }} Plan ID:</label>
                              <input type="text" id="plan_id" name="plan_id[]" value="" class="form-control" placeholder="Plan ID">
                              <input type="hidden" id="paymentGateway" name="paymentGateway[]" value={{ $item->payment_type}}  class="form-control" placeholder="paymentGateway">
                              <p>* Get Plan Key From {{ $item->payment_type }}</p>
                           </div>
                        @empty
                            
                        @endforelse

                        <div class="col-md-12 pb-2">
                           <label for="price">Plan Price</label>
                           <div class="d-flex">
                              <input type="text" style="text-align: center;" name="currency_symbol" id="currency_symbol" class="form-control col-md-4" value="{{ currency_symbol() }}" readonly>
                              <input type="number" name="price" id="price" class="form-control col-md-8" placeholder="Plan Amount">
                           </div>
                        </div>
                     
                        <div class="col-md-12 pb-2">
                           <label for="plan_content">Plan Content</label>
                           <input type="text" name="plan_content" id="plan_content" class="form-control" placeholder="Plan Content">
                        </div>

                        <div class="col-md-12 pb-2">
                           <label>Billing Interval:</label>
                           <input type="text" id="billing_interval" name="billing_interval" value="" class="form-control" placeholder="  etc .. Monthly , Yearly , 3 months ..">
                        </div>

                        <div class="col-md-12 pb-2">
                           <label>Billing Type:</label>
                           <input type="text" id="billing_type" name="billing_type" value="" class="form-control" placeholder="Example .. Non Refundable">
                        </div>

                        <div class="col-md-12 pb-2">
                           <label>Payment Type:</label><br>
                           <input type="radio" name="payment_type" value="recurring" checked='checked'> Recurring
                        </div>

                        <div class="col-md-12 pb-2">
                           <label> Days :</label>
                           <input type="text" id="days" name="days" value="" class="form-control" placeholder="Days">
                        </div>

                        <div class="col-md-12 pb-2">
                           <label> IOS Product ID :</label>
                           <input type="text" id="ios_product_id" name="ios_product_id" value="" class="form-control" placeholder="IOS Product ID">
                        </div>

                        <div class="col-md-12 pb-2">
                           <label>IOS Plan Price ( {{ currency_symbol() }} ):</label>
                           <input type="text" id="ios_plan_price" name="ios_plan_price" value="" class="form-control" placeholder="IOS Plan Price">
                        </div>

                        <div class="col-md-12 pb-2">
                           <label>Status</label>
                           <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                              <div style="color:red;">Disable</div>

                              <div class="mt-1">
                                 <label class="switch">
                                    <input type="checkbox" name="status" id="status" >
                                    <span class="slider round"></span>
                                 </label>
                              </div>

                              <div style="color:green;">Enable</div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-info">
               </div>
            </form>
         </div>
      </div>

      @section('javascript')

         <script>
            $(document).ready(function () {

               $('#Subscription_Plans').DataTable({ });

               $('body').on('click', '.create_channel_plan', function (event) {

                  event.preventDefault();
                  $('#user-channel-sub-plan-modal').html("Add Plan");
                  $('#submit').val("Add Plan");
                  $('#edit_modal').modal('show');

                  // Clear all form fields within the modal
                  $('#channel-subscription-plan').find('input:not([type="hidden"]), select, textarea').val('');
                  $('#status').prop('checked', false); 
                  $('#currency_symbol').val('{{ currency_symbol() }}');
                  $('#url').val("{{ route('admin.user-channel-subscription-plan.store') }}");
               });

               $('body').on('click', '#submit', function (event) {

                  event.preventDefault();
                  $('.error-message').remove(); 
                  var isValid = true;
                 
                  const requiredFields = [
                     '#plan_name', '#plan_id', '#plan_content', '#billing_interval',
                     '#billing_type','#days','#price', '#ios_product_id', '#ios_plan_price'
                  ];

                  requiredFields.forEach(function (field) {
                     if ($(field).val().trim() === "") {
                        isValid = false;
                        $(field).after('<span class="error-message" style="color:red;">' + $(field).attr('id').replace('_', ' ') + ' is required</span>');
                     }
                  });

                  if (isValid) {
                     var status = $('#status').is(':checked') ? 1 : 0;
                     $('#status').val(status);

                     $.get({
                        url: $("#url").val(),
                        data: $('#channel-subscription-plan').serialize(),
                        dataType: 'json',
                        success: function () {
                           $('#channel-subscription-plan').trigger("reset");
                           $('#edit_modal').modal('hide');
                           window.location.reload(true);
                        }
                     });
                  }
               });
      
               $('body').on('click', '.edit-ads-plans', function (event) {
                  event.preventDefault();
                  var id = $(this).data('id');
      
                  $.get("{{ route('admin.user-channel-subscription-plan.edit', '') }}/" + id, function (data) {
                     $('#user-channel-sub-plan-modal').html("Edit Plan");
                     $('#submit').val("Edit Plan");
                     $('#edit_modal').modal('show');
      
                     $.each(data.data, function (key, value) {
                        if (key === 'status') {
                           $('#status').prop('checked', value == 1); 
                        } else {
                           $('#' + key).val(value); 
                        }
                     });
      
                     $('#url').val("{{ route('admin.user-channel-subscription-plan.update', ':id') }}".replace(':id', id));
                  });
               });
            });

            function user_channel_plans_page_status(ele) {

               var Status = $('.user_channel_plans_page_status').prop("checked");

               var actionText = Status ? "active" : "remove";

               var Subscription_Plan = Status ? '1' : '0';

               var confirmationMessage = "Are you sure you want to " + actionText + " this  Subscription Plan Page?";
               var check = confirm(confirmationMessage);

               if (check) {
                  $.ajax({
                     type: "get",
                     dataType: "json",
                     url: "{{ route('admin.user-channel-subscription-plan.page-status') }}",
                     data: {
                           _token: "{{csrf_token()}}",
                           Subscription_Plan: Subscription_Plan,
                     },
                     success: function (data) {
                           if (data.message == 'false') {
                              swal.fire({
                                 title: 'Oops',
                                 text: 'Something went wrong!',
                                 allowOutsideClick: false,
                                 icon: 'error',
                                 title: 'Oops...',
                              }).then(function () {
                                 location.href = '{{ URL::to('admin/subscription-plans') }}';
                              });
                           }
                     },
                  });
               } else {
                  $(ele).prop('checked', !Status);
               }
            }

         </script>
      @stop

   <style>
      .error-message{
         text-transform: capitalize;
      }
   </style>
@stop