@extends('channel.master')
<style>
    label{
        font-size: 16px;
    }
    .ab{
        top:14px!important;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')
<?php //dd($cppuser); ?>
     <div id="content-page" class="content-page">
         <div class="container-fluid mt-4">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Video Lists</h4>
                        </div>
                        
                        
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                    <!-- <label class="p-2">Videos By CPP Users:</label> -->
                         <div class="form-group mr-2">                  
                                    <select id="cpp_user_videos" name="cpp_user_videos"  class="form-control" >
                                    <option value="">Select Videos By CPP</option>
                                        <option value="cpp_videos">Videos ( Uploaded By CPP Users )</option>
                                    </select>
                  </div>
                             <div class="form-group mr-2">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" />
                    </div>
                           <a href="{{ URL::to('channel/videos/create') }}" class="btn btn-primary">Add movie</a>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " style="width:100%">
                              <thead>
                                 <tr>
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
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($videos as $video)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);">
                                             @if(!empty($video->image) && ($video->image) != null )
                                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt="">
                                             @else
                                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $settings->default_video_image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt="">
                                             @endif
                                            
                                                
                                                </a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $video->title }}</p>
                                             <!-- <small>2h 15m</small> -->
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $video->rating }}</td>
                                    <!-- <td>@if(isset($video->categories->name)) {{ $video->categories->name }} @endif</td> -->
                                    <!-- <td>{{ $video->year }}</td> -->
                                    <!-- <td>{{ $video->draft }}</td> -->
                                    <!-- <td>
                                   
                                    </td> -->
                                    <td>@if(isset($video->channeluser->channel_name)) Uploaded by {{ $video->channeluser->channel_name }} @else Uploaded by Admin @endif</td>

                                    <td>{{ $video->type }}</td>
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
                                        {{ $video->views }}<img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>">
                                    </td>
                                    <td>
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/channel/category/videos') . '/' . $video->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('/channel/videos/edit') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit Video" href="{{ URL::to('channel/videos/editvideo') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                          <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('/channel/videos/delete') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach

                              </tbody>
                           </table>
                           <div class="clear"></div>

		<div class="pagination-outter"><?= $videos->appends(Request::only('s'))->render(); ?></div>
		
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
   // alert(query);
  $.ajax({
   url:"{{ URL::to('/channel/video_search') }}",
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
   url:"{{ URL::to('/cpp/cppusers_videodata') }}",
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
	@stop

@stop

