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
            <div class="">
               <div class="iq-card-header d-flex justify-content-between mb-4">
                  <div class="iq-header-title">
                     <h4 class="card-title">Advertisement List</h4>
                  </div>
                 
               </div>
               <div class="iq-card-body table-responsive p-0">
                  <input type="hidden" id="save_url" value="{{URL::to('/')}}/admin/save_ads_status">
                  <input type="hidden" id="token" value="{{csrf_token()}}">

                  <div class="table-view ">
                     <table class="table table-striped table-bordered table movie_table iq-card" style="width:100%">
                        <thead>
                           <tr class="r1">
                              <th>#</th>
                              <th>Ads Name</th>
                              <th>Ads Category</th>
                              <th>Ads Play</th>
                              <th>Status</th>
                              <th>Created At</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($advertisements as $key => $advertisement)
                           <tr>
                                 <td>{{$key+1}}</td>
                                 <td>{{$advertisement->ads_name}}</td>
                                 <td>{{@$advertisement->categories->name}}</td>
                                 <td>{{ucfirst($advertisement->ads_position)}}</td>
                                 <td>@if ($advertisement->status == 1)
                                   <p class="font-weight-bold text-success">Approved</p>
                                   @elseif ($advertisement->status == 2)
                                   <p class="font-weight-bold text-danger">Disapproved</p>
                                   @else
                                   <button class="btn btn-success status_change" value="1" data-id="{{$advertisement->id}}">Approve</button>
                                   <button class="btn btn-danger status_change" value="2" data-id="{{$advertisement->id}}">DisApprove</button>
                                @endif</td>
                                 <td>{!! date('d/M/y', strtotime($advertisement->created_at)) !!}</td>
                                 <td class=" align-items-center list-user-action">								
							            <a href="{{ URL::to('admin/advertisement/edit') . '/' . $advertisement->id }}" class="iq-bg-success"><i class="ri-pencil-line"></i></a>
                                 <a href="{{ URL::to('admin/advertisement/delete') . '/' . $advertisement->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><i class="ri-delete-bin-line"></i></a>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <div class="clear"></div>

                        <div class="pagination-outter"><?= $advertisements->appends(Request::only('s'))->render(); ?></div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   
   @section('javascript')
   <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
   <script>

      $(document).ready(function () {
         $('body').on('click', '.status_change', function (event) {
           event.preventDefault()
           var status = $(this).val();
           var id = $(this).data('id');
           var url = $('#save_url').val();

           $.ajax({
            url: url,
            type: "POST",
            data: {
             _token: $("#token").val(),
             status: status,
             id: id,
          },
          dataType: 'json',
          success: function (data) {
           window.location.reload(true);
        }
     });
        });
        });

         
   </script>

   @stop

   @stop

