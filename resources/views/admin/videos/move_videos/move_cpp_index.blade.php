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
      margin-left: 300px;
   }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

@section('content')

   <div id="content-page" class="content-page">

      <div class="mt-5 d-flex">
         <a class="black" href="{{ URL::to('admin/videos') }}">All Videos</a>
         <a class="black" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
         <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
         <a class="black" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
         <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
         <a class="black"  href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a>
      </div>
                     
      <div class="container-fluid p-0">
         <div class="row">
            <div class="col-sm-12">
               <div class="iq-card">
                  <div class="col-md-12 iq-card-header">
                     <div class="row p-1 m-1 mb-2">
                        <div class="col-md-7"> <h4> Move Videos CPP </h4></div>
                        <div class="col-md-2"><a href="{{ URL::to('/admin/assign_videos/partner') }}"><button type="button" class="btn btn-primary  btn-default">Move Videos CPP </button></a></div>
                        <div class="col-md-3"><a href="{{ URL::to('/admin/assign_videos/channel_partner') }}"><button type="button" class="btn btn-primary  btn-default" >Move Videos Channel </button></a></div>
                     <div>
                  </div>
                  </hr>
                  
                  <div class="iq-card-body table-responsive p-0 " style="margin-top: 2rem;" >

                     <form action="{{ URL::to('/admin/move/cpp-partner') }}"  method= "post">

                        <div class="row d-flex col-md-12 p-1 m-1" style="margin-top: 2rem;">
                           
                           <div class="col-md-6">
                              <label for="">Choose Content Partner</label>
                              <select name="cpp_users" class="form-control" id="cpp_users">
                                 @foreach(@$ModeratorsUser as $value)
                                    <option value="{{ $value->id }}">{{ $value->username }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <div class="col-md-6" >
                              <label for="">Choose Video (*To Be Moved)</label>
                              <select name="video_data" class="form-control" id="video_data">
                                 @foreach(@$video as $value)
                                    <option value="{{ $value->id }}">{{ $value->title }}</option>
                                 @endforeach
                              </select>
                           </div><br>
                           
                           {{-- Particular Commission Percentage --}}
                           
                           @if ( $setting->CPP_Commission_Status == 1)    

                              <div class="col-md-6" style="margin-top: 2rem;">
                                 <label for="">Commission Percentage (%)</label>
                                 <input type="number" class="form-control" name="CPP_commission_percentage" id="CPP_commission_percentage"  placeholder="0 - 100"
                                        value=""  min="0" max="100" step="1" oninput="this.value = this.value > 100 ? 100 : this.value < 0 ? 0 : this.value;" />
                              </div>

                           @endif
                         
                        </div><br>

                        <div class="col-md-12">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                           <button type="submit" style="margin-right: 10px;" class="btn btn-primary" value="submit">Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            </div>
         </div>
         </div>
      </div>
   </div>
@stop