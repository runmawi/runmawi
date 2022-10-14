@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
    .lar {
    font-family: 'Line Awesome Free';
    font-weight: 400;
    margin: 4px;
}
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

@section('content')
<style>
   
</style>
<?php 
// foreach($videos as $video){
// 	dd($video->cppuser->username);
// }
?>
<div id="content-page" class="content-page">
   
                    <div class="d-flex">
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/livestream') }}">All Live Videos</a>
                        <a class="black" href="{{ URL::to('admin/livestream/create') }}">Add New Live Video</a>
                        <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Video Categories</a></div>
         <div class="container-fluid p-0">
	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-6">
                <h4><i class="entypo-video"></i> Live Videos</h4>
                
			</div>
			@if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage" >
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                        </div>
                        @endforeach
                        @endif
			<div class="col-md-6" align="right">	
<!--				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="<?= Request::get('s'); ?>" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>-->
                <a href="{{ URL::to('admin/livestream/create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>    
	
	<div class="clear"></div>

	<div class="gallery-env mt-2">
		
			<table class="data-tables table livestream_table iq-card text-center p-0" style="width:100%">
				<thead>
					<tr class="r1">
						<th>Image</th>
						<th>Title</th>
						<th>User Name</th>
						<th>Video Type</th>
						<th>Video Access</th>
						<th>Status</th>
						<th>Stream Type</th>
						<th>Slider</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($videos as $video)
					<tr>
						<td><img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" width="50" /></td>
						<td><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></td>
						<td> <?php if(!empty(@$video->cppuser->username)){ echo @$video->cppuser->username; }else{ @$video->usernames->username; }?></td>
						
						<?php if($video->access == "ppv" ){ ?>
							<td> <?php echo "Paid"; ?></td>
						<?php }else{ ?>
							<td> <?php  echo "Free"; ?></td>
						<?php }?>  
						<td>{{ $video->access }}</td>

						<?php if($video->active == 0){ ?>
                        	<td> <p class = "bg-warning video_active"><?php echo "Pending"; ?></p></td>
						<?php }elseif($video->active == 1){ ?>
                        	<td> <p class = "bg-primary video_active"> <?php  echo "Approved"; ?></p></td>
						<?php }elseif($video->active == 2){ ?>
                        	<td>  <p class = "bg-danger video_active"><?php  echo "Rejected"; ?></p></td>
						<?php }?>  

						<td> @if( $video->url_type != null && $video->url_type == "Encode_video") {{ 'Video Encoder' }} @elseif( $video->url_type != null && $video->url_type == "live_stream_video") {{ 'Live Stream Video' }} @else {{  ucwords($video->url_type)  }} @endif
							
							@if( $video->url_type != null && $video->url_type == "Encode_video")
								<i class="fa fa-info-circle encode_video_alert"  aria-hidden="true" 
										data-title = "{{ $video->title }}" data-name="{{$video->Stream_key}}"
										data-rtmpURL= "{{ $video->rtmp_url ? $video->rtmp_url : null }}" 
										data-hls-url= "{{ $video->hls_url ? $video->hls_url : null }}" 
										
										data-linkedin-restream = "{{ 'dat' }}" 
										data-youtube-restream  = "{{ $video->youtube_restream_url && $video->youtube_streamkey  ? $video->youtube_restream_url.'/'. $video->youtube_streamkey : null }}" 
										data-facebook-restream = "{{ $video->fb_restream_url && $video->fb_streamkey  ? $video->fb_restream_url."/".$video->fb_streamkey : null }}"
										data-twitter-restream  = "{{ $video->twitter_restream_url && $video->twitter_streamkey ? $video->twitter_restream_url."/".$video->twitter_streamkey : null }}"   
										value="{{$video->Stream_key}}" onclick="addRow(this)" >
								</i>
							@endif

 						</td>

						 <td> 
							<div class="mt-1">
							   <label class="switch">
								   <input name="video_status" class="video_status" id="{{ 'video_'.$video->id }}" type="checkbox" @if( $video->banner == "1") checked  @endif data-video-id={{ $video->id }}  data-type="video" onchange="update_video_banner(this)" >
								   <span class="slider round"></span>
							   </label>
						   </div>
						 </td>

						<td class=" align-items-center list-inline">								
                            <a href="{{ URL::to('live') .'/'.$video->slug }}" target="_blank" class="iq-bg-warning"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
							<a href="{{ URL::to('admin/livestream/edit') . '/' . $video->id }}" class="iq-bg-success ml-2 mr-2"><img class="ply " src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
							<a href="{{ URL::to('admin/livestream/delete') . '/' . $video->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		

		<div class="clear"></div>

		<div style="position: relative;top: -50px;" class="pagination-outter mt-3 pull-right"><?= $videos->appends(Request::only('s'))->render(); ?></div>
		
		
	</div>
    </div>
</div>
    
    </div></div>


	@section('javascript')
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		function addRow(ele) 
		{

			var stream_key = $(ele).attr('data-name');
			var Rtmp_url   = $(ele).attr('data-rtmpURL');
			var Rtmp_title = $(ele).attr('data-title');
			var hls_url    = $(ele).attr('data-hls-url');

			var youtube_restream    = $(ele).attr('data-youtube-restream');
			var facebook_restream   = $(ele).attr('data-facebook-restream');
			var twitter_restream    = $(ele).attr('data-twitter-restream');
			var linkedin_restream   = $(ele).attr('data-linkedin-restream');

			var youtube_restream  = '<div class="col-md-4">   <lable> Youtube </lable>  <td> <div class="mt-1"> <label class="switch">  <input name="youtube_restream"   type="checkbox" value= ' + youtube_restream + ' > <span class="slider round"></span></label></div></td></div>' ;
			var facebook_restream = '<div class="col-md-4">   <lable> FaceBook </lable>  <td> <div class="mt-1"> <label class="switch"> <input name="facebook_restream"  type="checkbox" value= ' + facebook_restream + ' > <span class="slider round"></span></label></div></td></div>' ;
			var twitter_restream  = '<div class="col-md-4">   <lable> Twitter </lable>  <td> <div class="mt-1"> <label class="switch">  <input name="twitter_restream"   type="checkbox" value= ' + twitter_restream + '  > <span class="slider round"></span></label></div></td></div>' ;
			var linkedin_restream = '<div class="col-md-4">   <lable> Linkedin </lable>  <td> <div class="mt-1"> <label class="switch"> <input name="linkedin_restream"  type="checkbox" value= ' + linkedin_restream + ' > <span class="slider round"></span></label></div></td></div>' ;
		
			var rtmp_hls_url = '<input type="hidden" name="rtmp_hls_url" value='+ hls_url +'>';

			Swal.fire({
					allowOutsideClick:false,
					icon:'success',
					title: 'RTMP Streaming Details for '+ Rtmp_title ,
					html: '<div class="col-md-12">' + ' URL :  ' + Rtmp_url + '</div>' +"<br>"+ 
						  '<div class="col-md-12">' + 'Stream Key :  ' +  stream_key + '</div>'+"<br>"+ 
						  '<div class="col-md-12">' + 'HLS URL :  ' +  hls_url + '</div>' +"<br>"+ 
						  '<div class="col-md-12">' + '<form> <lable> Live Re-stream : </lable> <br> <br> <p class="restream_error_message">  </p>  <div class="row">' +  youtube_restream  +  facebook_restream + twitter_restream + linkedin_restream + rtmp_hls_url +'</div> </div>' +
						  '<div class="col-md-12"> <input type="submit" value="Start Restream"  class="btn btn-primary" id="restream_button" onclick="restream_button(this)" > </div> </form>', 
			})
		}

		function restream_button(ele){

			$('.restream_error_message').empty()
			$('#restream_button').val('Stop Streaming');
			$('#restream_button').removeAttr('onclick');
			$('#restream_button').attr('onClick', 'stop_restream_button(this);');

			var youtube_restream_checkbox   = $("input[name=youtube_restream]").prop("checked");
			var facebook_restream_checkbox  = $("input[name=facebook_restream]").prop("checked");
			var twitter_restream_checkbox   = $("input[name=twitter_restream]").prop("checked");
			var linkedin_restream_checkbox  = $("input[name=linkedin_restream]").prop("checked");
   
			var youtube_restream  = $("input[name=youtube_restream]").val();
			var facebook_restream = $("input[name=facebook_restream]").val();
			var twitter_restream  = $("input[name=twitter_restream]").val(); 
			var linkedin_restream = $("input[name=linkedin_restream]").val();

			var hls_url = $("input[name=rtmp_hls_url]").val();

			$.ajax({
				type   : 'POST',
				url    : "{{ route('start_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					youtube_restream_checkbox    : youtube_restream_checkbox, 
					facebook_restream_checkbox   : facebook_restream_checkbox, 
					twitter_restream_checkbox    : twitter_restream_checkbox, 
					linkedin_restream_checkbox   : linkedin_restream_checkbox, 
					youtube_restream    : youtube_restream, 
					facebook_restream   : facebook_restream, 
					twitter_restream    : twitter_restream,
					linkedin_restream   : linkedin_restream, 
					hls_url				: hls_url,
				},

				success:function(data){
					if( data.status == false ){
						$('#restream_button').val('Start Streaming');
						$('#restream_button').removeAttr('onclick');
						$('#restream_button').attr('onClick', 'restream_button(this);');
						$('.restream_error_message').append('Please toogle any one of the Re-streams').css('color', '#f92b2b');
					}
				}
        	});

		}

		function stop_restream_button(ele){

			$('#restream_button').val('Start Streaming');
			$('#restream_button').removeAttr('onclick');
			$('#restream_button').attr('onClick', 'restream_button(this);');

			var youtube_restream_checkbox   = $("input[name=youtube_restream]").prop("checked");
			var facebook_restream_checkbox  = $("input[name=facebook_restream]").prop("checked");
			var twitter_restream_checkbox   = $("input[name=twitter_restream]").prop("checked");
			var linkedin_restream_checkbox  = $("input[name=linkedin_restream]").prop("checked");
   
			var youtube_restream  = $("input[name=youtube_restream]").val();
			var facebook_restream = $("input[name=facebook_restream]").val();
			var twitter_restream  = $("input[name=twitter_restream]").val(); 
			var linkedin_restream = $("input[name=linkedin_restream]").val();

			var hls_url = $("input[name=rtmp_hls_url]").val();

			$.ajax({
				type   : 'POST',
				url    : "{{ route('stop_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					youtube_restream_checkbox    : youtube_restream_checkbox, 
					facebook_restream_checkbox   : facebook_restream_checkbox, 
					twitter_restream_checkbox    : twitter_restream_checkbox, 
					linkedin_restream_checkbox   : linkedin_restream_checkbox, 
					youtube_restream    : youtube_restream, 
					facebook_restream   : facebook_restream, 
					twitter_restream    : twitter_restream,
					linkedin_restream   : linkedin_restream, 
					hls_url				: hls_url,
				},

				success:function(data){
					if( data.status == false ){
						$('#restream_button').val('Start Streaming');
						$('#restream_button').removeAttr('onclick');
						$('#restream_button').attr('onClick', 'restream_button(this);');
					}
				}
        	});
		}
		

		$(document).ready(function(){
			var delete_link = '';
			$('#DataTables_Table_0_paginate').hide();

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});

		});


		$( document ).ready(function() {
			var Stream_error = '{{ $Stream_error }}';
			var Rtmp_url   = "{{ $Rtmp_url ? $Rtmp_url : 'No RTMP URL Added' }}" ;	
			var Stream_keys = '{{ $Stream_key }}';
			var Title = "{{ 'RTMP Streaming Details for'.' '. $title }}";
			var hls_url   = "{{ $hls_url ? $hls_url : 'No HLS URL Added' }}" ;
	
		if( Stream_error == 1){
			Swal.fire({
			allowOutsideClick:false,
			icon: 'success',
			title: Title,
			html: '<div class="col-md-12">' + 'RTMP URL :  ' + Rtmp_url + '</div>' +"<br>"+ 
					  '<div class="col-md-12">' + 'Stream Key :  ' +  Stream_keys + '</div>'+"<br>"
                     ,
			}).then(function (result) {
			if (result.value) {
				@php
						session()->forget('Stream_key');
						session()->forget('Stream_error');
						session()->forget('Rtmp_url');
						session()->forget('title');
						session()->forget('hls_url');
				@endphp
				location.href = "{{ URL::to('admin/livestream')}}";
			}
			})
		}
	});
	</script>


<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
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
				url: "{{ url('admin/livevideo_slider_update') }}",
					  data: {
						 _token  : "{{csrf_token()}}" ,
						 video_id: video_id,
						 banner_status: banner_status,
				},
				success: function(data) {
					  if(data.message == 'true'){
						//  location.reload();
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

