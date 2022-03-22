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
                     <h4 class="card-title">CPC List</h4>
                  </div>
                 
               </div>
               <div class="iq-card-body table-responsive">
                  <input type="hidden" id="token" value="{{csrf_token()}}">

                  <div class="table-view">
                     <table class="table table-striped table-bordered table movie_table " style="width:100%">
                        <thead>
                           <tr>
                              <th><label>#</label></th>
                              <th><label>Ads Name</label></th>
                              <th><label>Advertiser Name</label></th>
                              <th><label>Video Name</label></th>
                              <th><label>Cost Advertiser</label></th>
                              <th><label>Cost Admin</label></th>
                              <th><label>View</label></th>
                              <th><label>Created At</label></th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($cpv_lists as $key => $cpv_list)
                           <tr>
                              <td>{{$key+1}}</td>
                              <td>{{get_ad($cpv_list->ad_id,'ads_name')}}</td>
                              <td>{{get_advertiser($cpv_list->advertiser_id,'company_name')}}</td>
                              <td>{{get_video($cpv_list->video_id,'title')}}</td>
                              <td>{{ucfirst($cpv_list->advertiser_share)}}</td>
                              <td>{{ucfirst($cpv_list->admin_share)}}</td>
                              <td>{{ucfirst($cpv_list->views_count)}}</td>
                              <td>{!! date('d/M/y', strtotime($cpv_list->created_at)) !!}</td>
                           </tr>
                           @endforeach
                           </tbody>
                        </table>
                        <div class="clear"></div>

                        <div class="pagination-outter"><?= $cpv_lists->appends(Request::only('s'))->render(); ?></div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   
   @section('javascript')
   <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
   
   @stop

   @stop

