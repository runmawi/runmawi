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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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
                              <option value="">Select Videos By CPP</option>
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
                           <table class="table text-center table-striped table-bordered table movie_table iq-card " style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>Select All <input type="checkbox" id="select_all"></th>
                                    <th>Title</th>
                                    <th>Rating</th>
                                    <!-- <th>Category</th> -->
                                    <!-- <th>Release Year</th> -->
                                    <th>Uploaded by</th>
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

                                    <td>@if(isset($video->rating))  
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                       {{ $video->rating }} @else
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                        0 @endif
                                    </td>

                                    <!-- <td>@if(isset($video->category['categoryname']->name)) {{ @$video->category['categoryname']->name }} @endif</td> -->
                                    <!-- <td>@if(!empty(@$value->category[$key]->categoryname->name)) {{ @$value->category[$key]->categoryname->name }} @endif</td> -->

                                    <!-- <td>{{ @$value->category[$key]->categoryname->name }}</td> -->
                                    <!-- <td>{{ $video->draft }}</td> -->
                                    <!-- <td>
                                   
                                    </td> -->
                                    <td>@if(isset($video->cppuser->username)) Uploaded by {{ $video->cppuser->username }} @else  Admin @endif</td>
                                    <td>@if(isset($video->type) && $video->type == "") M3u8 Converted Video  
                                       @elseif(isset($video->type) && $video->type == "mp4_url") MP4 Video
                                       @elseif(isset($video->type) && $video->type == "m3u8_url") M3u8 URL Video
                                       @elseif(isset($video->type) && $video->type == "embed") Embed Video
                                       @endif</td>

                                    <!-- <td>{{ $video->type }}</td> -->

                                    <td>{{ $video->access }}</td>
                                   
                                             <?php if($video->draft == null){ ?>
                                    <td > <p class = "bg-warning video_active"><?php echo "Draft"; ?></p></td>
                                             <?php }elseif($video->draft == 1 && $video->status == 1 && $video->active == 1){ ?>
                                    <td > <p class = "bg-success video_active"><?php  echo "Approved"; ?></p></td>
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

                                       <?php if($video->draft != null && $video->draft == 1 && $video->status != null && $video->status == 1 && $video->active != null && $video->active == 1){ ?>
                                          <a class="iq-bg-warning mt-2" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/category/videos') . '/' . $video->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                       <?php } else{?>
                                          <a class="iq-bg-warning mt-2" style = "opacity: 0.6; cursor: not-allowed;" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Disable View" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                       <?php }?>

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

                        if(data.message == 'true'){

                           location.reload();

                        }else if(data.message == 'false'){

                           swal.fire({
                           title: 'Oops', 
                           text: 'Something went wrong!', 
                           allowOutsideClick:false,
                           icon: 'error',
                           title: 'Oops...',
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
         $(status).prop('checked', true);

      }
      }
</script>


	@stop

@stop

