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

  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')
     <div id="content-page" class="content-page">
         <div class="mt-5 d-flex">
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/videos') }}">All Videos</a>
                        <a class="black" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
                        <a class="black" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
                        <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
                        <a class="black" href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a>
         </div>
         
         <div class="container-fluid p-0">
            <div class="row ">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header ">
                     
                        <div class="iq-card-header-toolbar d-flex justify-content-between d-flex align-items-baseline">
                        <div class="form-group mr-2">                  
                           <select id="cpp_user_videos" name="cpp_user_videos"  class="form-control" >
                              <option value="">Select Videos By</option>
                                 <option value="cpp_videos">Videos ( Uploaded By CPP Users )</option>
                              </select>
                        </div>

                        <div class="form-group mr-2">
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" />
                        </div>
                           <a href="{{ URL::to('admin/videos/create') }}" class="btn btn-primary">Add movie</a>

                     {{-- Bulk video delete --}}
                           <button style="margin-bottom: 10px" class="btn btn-primary delete_all" >Delete Selected Video</button>

                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table text-center  table-striped table-bordered table movie_table iq-card " style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th><input type="checkbox" id="select_all"></th>
                                    <th>Title</th>
                                    <th>Duration</th>
                                    <!-- <th>Category</th> -->
                                    <!-- <th>Release Year</th> -->
                                    <!-- <th>Uploaded by</th> -->
                                    <th>Video Uploaded By</th>
                                    <th>Video Type</th>
                                    <th>Video Access</th>
                                    <th>Status</th>
                                    <!-- <th>Language</th> -->
                                    <!--<th style="width: 20%;">Description</th>-->
                                     <th>Views</th>
                                     <th>Slider</th>
                                    <th>Action</th>
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

                                    <!-- <td>{{ $video->rating }}</td> -->

                                    <td>
                                       @if(isset($video->duration))  
                                          @php
                                             $durationInSeconds = $video->duration;
                                             $hours = str_pad(floor($durationInSeconds / 3600), 2, '0', STR_PAD_LEFT);
                                             $minutes = str_pad(floor(($durationInSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT);
                                             $seconds = str_pad($durationInSeconds % 60, 2, '0', STR_PAD_LEFT);
                                          @endphp
                                          <p>{{ $hours }}:{{ $minutes }}:{{ $seconds }}</p>
                                        @endif
                                    </td>

                                    <!-- <td>@if(isset($video->category['categoryname']->name)) {{ @$video->category['categoryname']->name }} @endif</td> -->
                                    <!-- <td>@if(!empty(@$value->category[$key]->categoryname->name)) {{ @$value->category[$key]->categoryname->name }} @endif</td> -->

                                    <!-- <td>{{ @$value->category[$key]->categoryname->name }}</td> -->
                                    <!-- <td>{{ $video->draft }}</td> -->
                                    <!-- <td>
                                   
                                    </td> -->
                                    <!-- <td>@if(isset($video->cppuser->username)) Uploaded by {{ $video->cppuser->username }} @else  Admin @endif</td> -->
                                    <td>@if(isset($video->uploaded_by) && $video->uploaded_by == 'CPP') Uploaded by Content Partner 
                                       @elseif(isset($video->uploaded_by) && $video->uploaded_by == 'Channel') Uploaded by Channel Partner 
                                       @else  Uploaded by Admin @endif</td>
                                    <td>@if(isset($video->type) && $video->type == "") M3u8 Converted Video  
                                       @elseif(isset($video->type) && $video->type == "mp4_url") MP4 Video
                                       @elseif(isset($video->type) && $video->type == "m3u8_url") M3u8 URL Video
                                       @elseif(isset($video->type) && $video->type == "embed") Embed Video
                                       @elseif(isset($video->type) && $video->type == "VideoCipher") VideoCipher Video
                                       @endif</td>

                                    <!-- <td>{{ $video->type }}</td> -->

                                    <td>{{ $video->access }}</td>
                                   
                                             <?php if($video->draft == null){ ?>
                                    <td > <p class = "bg-warning video_active"><?php echo "Draft"; ?></p></td>
                                             <?php }elseif($video->draft == 1 && $video->status == 1 && $video->active == 1){ ?>
                                    <td > <p class = "bg-success video_active"><?php  echo "Published"; ?></p></td>
                                             <?php }else{ ?>
                                    <td> <p class = "bg-warning video_active"><?php  echo "Draft"; ?></p></td>
                                             <?php }?>
                                    
                                    
                             
                                    <!-- <td> @if(isset($video->languages->name)) {{ $video->languages->name }} @endif</td> -->
                                    <td>
                                       <!--<p> {{ substr($video->description, 0, 50) . '...' }} </p>-->
                                        {{ $video->views }}<i class="lar la-eye "></i>
                                    </td>

                                    <td> 
                                       <div class="mt-1">
                                          <label class="switch">
                                              <input name="video_status" class="video_status" id="{{ 'video_'.$video->id }}" type="checkbox" @if( $video->banner == "1") checked  @endif data-video-id={{ $video->id }}  data-type="video" onchange="update_video_banner(this)" >
                                              <span class="slider round"></span>
                                          </label>
                                      </div>
                                    </td>
                                    
                                    <td>
                                       <div class="flex align-items-center list-user-action">

                                          <a class="iq-bg-warning pt-1" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/category/videos') . '/' . $video->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit Meta" href="{{ URL::to('admin/videos/edit') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                             <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit Video" href="{{ URL::to('admin/videos/editvideo') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                          <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/videos/delete') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                       </div>
                                    </td>
                       
                                 </tr>
                                 @endforeach

                              </tbody>
                           </table>
                           <div class="clear"></div>
		<div class="pagination-outter mt-3 pull-right" >
      <!-- showing 1 to 5 of 2095 -->
      <h6>Showing {{ $videos->firstItem() }} - {{ $videos->lastItem() }} of {{ $videos->total() }} </h6>
      <!-- (for page {{ $videos->currentPage() }} ) -->
      <?= $videos->appends(Request::only('s'))->render(); ?></div>
		
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
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


	$(document).ready(function(){

$('#cpp_user_videos').change(function(){
   var val = $('#cpp_user_videos').val();
   if(val == "cpp_videos"){
	$.ajax({
   url:"{{ URL::to('admin/cppusers_videodata') }}",
   method:'get',
   data:{query:val},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
    });
   }
})

});
	
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
   $(document).ready(function () {

      $(".delete_all").hide();

       $('#select_all').on('click', function(e) {

            if($(this).is(':checked',true))  
            {
               $(".delete_all").show();
               $(".sub_chk").prop('checked', true);  
            } else {  
               $(".delete_all").hide();
               $(".sub_chk").prop('checked',false);  
            }  
       });


      $('.sub_chk').on('click', function(e) {

         var checkboxes = $('input:checkbox:checked').length;

         if(checkboxes > 0){
            $(".delete_all").show();
         }else{
            $(".delete_all").hide();
         }
      });


       $('.delete_all').on('click', function(e) {

           var allVals = [];  
            $(".sub_chk:checked").each(function() {  

                  allVals.push($(this).attr('data-id'));
            });  

            if(allVals.length <=0)  
            {  
                  alert("Please select Anyone video");  
            }  
            else 
            {  
               var check = confirm("Are you sure you want to delete selected videos?");  
               if(check == true){  
                   var join_selected_values =allVals.join(","); 

                   $.ajax({
                     url: '{{ URL::to('admin/VideoBulk_delete') }}',
                     type: "get",
                     data:{ 
                        _token: "{{csrf_token()}}" ,
                        video_id: join_selected_values, 
                     },
                     success: function(data) {
                        // console.log(JSON.stringify(data));
                        if(data.message == 'true'){
                           swal.fire({
                                 title: 'Success',
                                 text: 'The selected videos have been deleted successfully.!',
                                 allowOutsideClick: false,
                                 icon: 'success',
                           }).then(function() {
                              location.reload();
                           });
                        } else if(data.message == 'false') {
                           
                           swal.fire({
                                 title: 'Success',
                                 text: 'The selected videos have been deleted successfully.!',
                                 allowOutsideClick: false,
                                 icon: 'success',
                           }).then(function() {
                                 location.href = '{{ URL::to('admin/videos') }}';
                           });
                        }
                     },
                  });
               }  
            }  
       });

   });
</script>

<script>
      function update_video_banner(ele){

      var video_id = $(ele).attr('data-video-id');
      var status   = '#video_'+video_id;
      var video_Status = $(status).prop("checked");

      if(video_Status == true){
            var banner_status  = '1';
            var check = confirm("Are you sure you want to active this slider?");  

      }else{
            var banner_status  = '0';
            var check = confirm("Are you sure you want to remove this slider?");  
      }


      if(check == true){ 

         $.ajax({
                  type: "POST", 
                  dataType: "json", 
                  url: "{{ url('admin/video_slider_update') }}",
                        data: {
                           _token  : "{{csrf_token()}}" ,
                           video_id: video_id,
                           banner_status: banner_status,
                  },
                  success: function(data) {
                        if(data.message == 'true'){
                           // location.reload();
                        }
                        else if(data.message == 'false'){
                           swal.fire({
                           title: 'Oops', 
                           text: 'Something went wrong!', 
                           allowOutsideClick:false,
                           icon: 'error',
                           title: 'Oops...',
                           }).then(function() {
                              location.href = '{{ URL::to('admin/ActiveSlider') }}';
                           });
                        }
                     },
               });
      }else if(check == false){
         // $(status).prop('checked', true);
         $(status).prop('checked', !video_Status);
      }
      }
</script>


	@stop

@stop

