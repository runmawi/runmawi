@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

<style>
    .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
     .content-page {
    overflow: hidden;
        margin-left: 300px;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">-->

@section('content')

     <div id="content-page" class="content-page">
         <div class="mt-5 d-flex">
                        <a class="black" href="{{ URL::to('admin/videos') }}">All Videos</a>
                        <a class="black" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
                       <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
                       <a class="black"  href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a></div>

                       
         <div class="container-fluid p-0">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                       
                        <div class="row">
                           <div class="col-md-5">
                              <a href="{{ URL::to('/admin/assign_Series/partner') }}"><button type="button" class="btn btn-default">Move TV Shows CPP </button></a>
                           </div>
                           <div class="col-md-5">
                              <a href="{{ URL::to('/admin/assign_Series/channel_partner') }}"><button type="button" class="btn btn-default" >Move Videos Channel </button></a>
                           </div>
                        <div>
                           <br>
                        <h4>Move TV Shows CPP</h4>
                           
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        
                        <form action="{{ URL::to('/admin/MoveSeries/cpp-partner') }}"  method= "post">

                           <div class="col-md-12">
                              <div class="row">
                                 <div class="col-md-12">
                                    <label for="">Choose Content Partner</label>
                                    <select name="cpp_users" class="form-control" id="cpp_users">
                                       @foreach(@$ModeratorsUser as $value)
                                          <option value="{{ $value->id }}">{{ $value->username }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-12">
                                 <label for="">Choose TV Shows (*To Be Moved)</label>
                                       <select name="Series_data" class="form-control" id="Series_data">
                                          @foreach(@$Series as $value)
                                             <option value="{{ $value->id }}">{{ $value->title }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                              </div>
                           </div>
                           <br>
                           <div class="col-md-12">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                 <button type="submit" style="margin-right: 10px;" class="btn btn-primary" value="submit">Submit</button>
                           </div>
                        </form>

                     <div class="clear"></div>
		
		               </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
</div>
<!--<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>-->
      

@stop

