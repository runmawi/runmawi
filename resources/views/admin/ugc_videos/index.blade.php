@extends('admin.master')
<style>
     .form-control {
    /*background: #fff!important; */
   
}
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
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
@section('content')
     <div id="content-page" class="content-page">
         <div class="mt-5 d-flex">
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/ugc_videos') }}">All UGC Videos</a>
                        <a class="black" href="{{ URL::to('admin/ugc_videos_index') }}">UGC Videos For Approval</a>
         </div>
         
         <div class="container-fluid p-0">
            <div class="row ">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header ">
                     
                    <div class="iq-card-header-toolbar d-flex justify-content-between d-flex align-items-baseline">
                        <div class="form-group mr-2">
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" />
                        </div>
                            {{-- Bulk video delete --}}
                            <button style="margin-bottom: 10px" class="btn btn-primary delete_all" >Delete Selected Video</button>
                    </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table text-center  table-striped table-bordered table movie_table iq-card " style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>Select All <input type="checkbox" id="select_all"></th>
                                    <th>Title</th>
                                    <th>Video Uploaded By</th>
                                    <th>Video Type</th>
                                    <th>Video Access</th>
                                    <th>Views</th>
                                    {{-- <th>Action</th> --}}
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($videos as $key => $video)
                                 <tr id="tr_{{$video->id}}" >
                                   
                                    <td><input type="checkbox" id="Sub_chck" class="sub_chk" data-id="{{$video->id}}"></td>

                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img
                                                   src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $video->title }}</p>
                                             <!-- <small>2h 15m</small> -->
                                          </div>
                                       </div>
                                    </td>
                                    <td>@if(isset($video->uploaded_by) && $video->uploaded_by == 'CPP') Uploaded by Content Partner 
                                       @elseif(isset($video->uploaded_by) && $video->uploaded_by == 'Channel') Uploaded by Channel Partner 
                                       @else  Uploaded by Admin @endif</td>
                                    <td>@if(isset($video->type) && $video->type == "") M3u8 Converted Video  
                                       @elseif(isset($video->type) && $video->type == "mp4_url") MP4 Video
                                       @elseif(isset($video->type) && $video->type == "m3u8_url") M3u8 URL Video
                                       @elseif(isset($video->type) && $video->type == "embed") Embed Video
                                       @endif</td>

                                 
                                             <?php if($video->draft == null){ ?>
                                    <td > <p class = "bg-warning video_active"><?php echo "Draft"; ?></p></td>
                                             <?php }elseif($video->draft == 1 && $video->status == 1 && $video->active == 1){ ?>
                                    <td > <p class = "bg-success video_active"><?php  echo "Published"; ?></p></td>
                                             <?php }else{ ?>
                                    <td> <p class = "bg-warning video_active"><?php  echo "Draft"; ?></p></td>
                                             <?php }?>
                                    <td>
                                        {{ $video->views }}<i class="lar la-eye "></i>
                                    </td>

                                    {{-- <td>
                                       <div class="flex align-items-center list-user-action">

                                       <?php if($video->draft != null && $video->draft == 1 && $video->status != null && $video->status == 1 && $video->active != null && $video->active == 1){ ?>
                                          <a class="iq-bg-warning pt-1" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ url('ugc/video-player/' . $video->slug) }}" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                       <?php } else{?>
                                          <a class="iq-bg-warning mt-2" style = "opacity: 0.6; cursor: not-allowed;" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Disable View" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                       <?php }?>

                                          <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/ugc-delete/delete') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                       </div>
                                    </td> --}}
                       
                                 </tr>
                                 @endforeach

                              </tbody>
                           </table>
                           <div class="clear"></div>
		                     <div class="pagination-outter mt-3 pull-right" >
                           <!-- showing 1 to 5 of 2095 -->
                           <h6>Showing {{ $videos->firstItem() }} - {{ $videos->lastItem() }} of {{ $videos->total() }} </h6>
                           <!-- (for page {{ $videos->currentPage() }} ) -->
                           <?= $videos->appends(Request::only('s'))->render(); ?>
                        </div>
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
   url:"{{ URL::to('/admin/live_search') }}",
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
@section('javascript')
@stop

@stop

