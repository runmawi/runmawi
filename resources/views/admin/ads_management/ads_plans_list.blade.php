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
                     <a data-toggle="modal" data-target='#edit_modal' class="btn btn-primary create_category">Create Ads Plan</a>
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
                              <th>No of Ads View Count</th>
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
                                 <td>{{ $ads_plan->created_at }}</td>
                                 <td><a class="iq-bg-success editcategory" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="Edit" data-toggle="modal" data-target='#edit_modal' data-id="{{ $ads_plan->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                    <a  onclick="return confirm('Are you sure?')" href="{{ URL::to('/admin/ads_plan_delete').'/'. $ads_plan->id }}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                    <!-- <i class="ri-delete-bin-line delete" id="delete"data-id="{{ $ads_plan->id }}" ></i> -->
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

   <div class="modal fade" id="edit_modal">
      <div class="modal-dialog">
         <form id="companydata">
          <div class="modal-content">
             <input type="hidden" id="plan_id" name="plan_id" value="">
             <input type="hidden" id="token" value="{{csrf_token()}}">
             <input type="hidden" id="url" name="url" value="">
             <div class="modal-body">
               <label>Plan Name</label>
               <input type="text" name="plan_name" id="plan_name" value="" class="form-control" placeholder="Ads Plan Name">
               <label>Plan Amount</label>
               <input type="text" name="plan_amount" id="plan_amount" value="" class="form-control" placeholder="Ads Plan Amount">
               <label>No of Ads view count</label>
               <input type="text" name="no_of_ads" id="no_of_ads" value="" class="form-control" placeholder="No of Ads view count">
            </div>
            <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-info">
         </div>
      </form>
   </div>
</div>
   @section('javascript')
   <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   <script>

      $(document).ready(function () {
         $('body').on('click', '#submit', function (event) {
           event.preventDefault()
           var id = $("#plan_id").val();
           var plan_name = $("#plan_name").val();
           var plan_amount = $("#plan_amount").val();
           var no_of_ads = $("#no_of_ads").val();
           var url = $("#url").val();

           $.ajax({
            url: url,
            type: "POST",
            data: {
             _token: $("#token").val(),
             id: id,
             plan_name: plan_name,
             plan_amount: plan_amount,
             no_of_ads: no_of_ads,
          },
          dataType: 'json',
          success: function (data) {

           $('#companydata').trigger("reset");
           $('#edit_modal').modal('hide');
           window.location.reload(true);
        }
     });
        });

         $('body').on('click', '.editcategory', function (event) {
           event.preventDefault();
           var id = $(this).data('id');
           $.get('adsplanedit/' + id , function (data) {
            $('#userCrudModal').html("Edit Plan");
            $('#submit').val("Edit Plan");
            $('#edit_modal').modal('show');
            $('#plan_id').val(data.data.id);
            $('#plan_name').val(data.data.plan_name);
            $('#plan_amount').val(data.data.plan_amount);
            $('#no_of_ads').val(data.data.no_of_ads);
            $('#url').val('edit_ads_plan');
         })
        });

          $('body').on('click', '.create_category', function (event) {
           event.preventDefault();
            $('#userCrudModal').html("Add Plan");
            $('#submit').val("Add Plan");
            $('#edit_modal').modal('show');
            $('#plan_id').val('');
            $('#plan_name').val('');
            $('#plan_amount').val('');
            $('#no_of_ads').val('');
            $('#url').val('add_ads_plan');
        });

      }); 
   </script>
<script>

      $('body').on('click', '#delete', function (event) {
            delete_link = 'ads_plan_delete/'+$(this).data('id');
            swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this category?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
             return false;
         });

   </script>
   @stop

   @stop

