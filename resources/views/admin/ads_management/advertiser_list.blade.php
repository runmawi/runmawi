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
                     <h4 class="card-title">Advertisers Lists</h4>
                  </div>
                  
               </div>
               <div class="iq-card-body table-responsive">
                  <div class="table-view">
                     <input type="hidden" id="save_url" value="{{URL::to('/')}}/admin/save_advertiser_status">
                     <input type="hidden" id="token" value="{{csrf_token()}}">
                     <table class="table table-striped table-bordered table movie_table " style="width:100%">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Company Name</th>
                              <th>Lisence Number</th>
                              <th>Address</th>
                              <th>Mobile Number</th>
                              <th>Email ID</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($advertisers as $key => $advertiser)
                           <tr>
                                 <td>{{ $key+1 }}</td>
                                 <td>{{ $advertiser->company_name }}</td>
                                 <td>{{ $advertiser->license_number }}</td>
                                 <td>{{ $advertiser->address }}</td>
                                 <td>{{ $advertiser->mobile_number }}</td>
                                 <td>{{ $advertiser->email_id }}</td>
                                 <td>@if ($advertiser->status == 1)
                                   <p class="font-weight-bold text-success">Approved</p>
                                   @elseif ($advertiser->status == 2)
                                   <p class="font-weight-bold text-danger">Disapproved</p>
                                   @else
                                   <button class="btn btn-success status_change" value="1" data-id="{{$advertiser->id}}">Approve</button>
                                   <button class="btn btn-danger status_change" value="2" data-id="{{$advertiser->id}}">DisApprove</button>
                                @endif</td>
                                <td class="d-flex align-items-center list-user-action">								
							            <a href="{{ URL::to('admin/advertiser/edit') . '/' . $advertiser->id }}" class="iq-bg-success"><i class="ri-pencil-line"></i></a>
                                 <a href="{{ URL::to('admin/advertiser/delete') . '/' . $advertiser->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><i
                                  class="ri-delete-bin-line"></i></a>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <div class="clear"></div>

                        <div class="pagination-outter"><?= $advertisers->appends(Request::only('s'))->render(); ?></div>

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

