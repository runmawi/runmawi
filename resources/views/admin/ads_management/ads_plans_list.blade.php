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
                        <h4 class="card-title">Ads Plans List</h4>
                     </div>

                     <div class="iq-card-header-toolbar d-flex align-items-center">
                        <a data-toggle="modal" data-target='#edit_modal' class="btn btn-primary create_ads_plan">Create Ads Plan</a>
                     </div>
                  </div>

                  <div class="iq-card-body table-responsive">
                     <div class="table-view">
                        <table class="table table-striped table-bordered table movie_table " style="width:100%">

                           <thead>
                              <tr class="r1">
                                 <th>#</th>
                                 <th>Plan Name</th>
                                 <th>Plan Amount</th>
                                 <th>No of Ads uploads Count</th>
                                 <th>Status</th>
                                 <th>Created at</th>
                                 <th>Action</th>
                              </tr>
                           </thead>

                           <tbody>
                              @foreach($ads_plans as $key => $ads_plan)
                                 <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $ads_plan->plan_name }}</td>
                                    <td>{{ $ads_plan->plan_amount }}</td>
                                    <td>{{ $ads_plan->no_of_ads }}</td>
                                    <td>{{ $ads_plan->status == 1 ? "ON" : "OFF" }}</td>
                                    <td>{{ $ads_plan->created_at }}</td>
                                    <td>
                                       <a class="iq-bg-success edit-ads-plans" data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="Edit" data-toggle="modal" data-target='#edit_modal' data-id="{{ $ads_plan->id }}"><img class="ply" src="{{ URL::to('/assets/img/icon/edit.svg') }}">
                                       </a>

                                       <a onclick="return confirm('Are you sure?')" href="{{ URL::to('/admin/ads_plan_delete').'/'. $ads_plan->id }}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                          <img class="ply" src="{{ URL::to('/assets/img/icon/delete.svg') }}">
                                       </a>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <div class="clear"></div>

                        <div class="pagination-outter"><?= $ads_plans->appends(Request::only('s'))->render(); ?></div>

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
            <form id="companydata">

            <div class="modal-content">
               <input type="hidden" id="id" name="id" value="">
               <input type="hidden" id="token" value="{{csrf_token()}}">
               <input type="hidden" id="url" name="url" value="">
               
               <div class="modal-body">
                  <div class="row d-flex p-0">

                     <div class="col-md-12 pb-2">
                        <label for="plan_name">Plan Name</label>
                        <input type="text" name="plan_name" id="plan_name" class="form-control" placeholder="Ads Plan Name" >
                     </div>
                  
                     <div class="col-md-12 pb-2">
                        <label for="plan_amount">Plan Amount</label>
                        <div class="d-flex">
                           <input type="text" style="text-align: center;" name="currency_symbol" id="currency_symbol" class="form-control col-md-4" value="{{ currency_symbol() }}" readonly>
                           <input type="number" name="plan_amount" id="plan_amount" class="form-control col-md-8" placeholder="Ads Plan Amount">
                        </div>
                     </div>
                  
                     <div class="col-md-12 pb-2">
                        <label for="plan_id">Plan Id</label>
                        <input type="text" name="plan_id" id="plan_id" class="form-control" placeholder="Ads Stripe Plan Id" >
                     </div>
                  
                     <div class="col-md-12 pb-2">
                        <label for="no_of_ads">No of Ads Upload Count</label>
                        <input type="number" name="no_of_ads" id="no_of_ads" class="form-control" placeholder="No of Ads Upload count" >
                     </div>
                  
                     <div class="col-md-12 pb-2">
                        <label for="description">Plan Description</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Description" >
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
      <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>

      <script>

         $(document).ready(function () {

            $('body').on('click', '.create_ads_plan', function (event) {
               event.preventDefault();
               $('#userCrudModal').html("Add Plan");
               $('#submit').val("Add Plan");
               $('#edit_modal').modal('show');
               $('#plan_id,#plan_name,#plan_amount,#no_of_ads,#description,#status').val('');
               $('#url').val('add_ads_plan');
            });

            $('body').on('click', '#submit', function (event) {
               event.preventDefault();

               var isValid = true;

               $('.error-message').remove();

               ['#plan_name', '#plan_id','#no_of_ads','#description','#plan_amount'].forEach(function (field) {
                  if ($(field).val().trim() === "") {
                     isValid = false;
                     $(field).after('<span class="error-message" style="color:red;">' + $(field).attr('id').replace('_', ' ') + ' is required</span>');
                  }
               });

               if (isValid) {
                  var status = $('#status').is(':checked') ? 1 : 0;

                  $.post({
                     url: $("#url").val(),
                     data: {
                           _token: $("#token").val(),
                           plan_name: $("#plan_name").val(),
                           plan_amount: $("#plan_amount").val(),
                           no_of_ads: $("#no_of_ads").val(),
                           status: status,
                           plan_id: $("#plan_id").val(),
                           description: $('#description').val(),
                           id: $("#id").val(),
                     },
                     dataType: 'json',
                     success: function () {
                           $('#companydata').trigger("reset");
                           $('#edit_modal').modal('hide');
                           window.location.reload(true);
                     }
                  });
               }
            });


            $('body').on('click', '.edit-ads-plans', function (event) {
               event.preventDefault();

               var id = $(this).data('id');

               $.get('adsplanedit/' + id , function (data) {
                  $('#userCrudModal').html("Edit Plan");
                  $('#submit').val("Edit Plan");
                  $('#edit_modal').modal('show');
                  $('#id').val(data.data.id);
                  $('#plan_name').val(data.data.plan_name);
                  $('#plan_amount').val(data.data.plan_amount);
                  $('#no_of_ads').val(data.data.no_of_ads);
                  $('#description').val(data.data.description);
                  if (data.data.status == 1) {
                        $('#status').prop('checked', true);
                  } else {
                        $('#status').prop('checked', false);
                  }                 
                  $('#plan_id').val(data.data.plan_id);
                  $('#url').val('edit_ads_plan');
               })
            });
         }); 

         $('body').on('click', '#delete', function (event) {
            delete_link = 'ads_plan_delete/'+$(this).data('id');
            swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this category?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
               return false;
         });

      </script>
   @stop

   <style>
      .error-message{
         text-transform: capitalize;
      }
   </style>
@stop