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
	
.vod-info{padding:0;list-style:none;margin:15px 0;color:var(--text-color-opacity)}
.vod-info li span{background-color:red;display:inline-block;width:10px;height:10px;border-radius:50%;margin-right:5px}
.dataTables_filter {
        display: none;
    }
.dataTables_length {
	display: none;
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
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ route( $inputs_details_array['all_list_route'] ) }}">{{ "All " . $inputs_details_array['text_main_name'] . " Stream" }}						</a>
                        <a class="black" href="{{ route( $inputs_details_array['create_route'] ) }}">{{ "Add New ". $inputs_details_array['text_main_name'] ."Stream"}}</a>
						
						@if ( $currentRouteName == "admin.livestream.index" )
                        	<a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Stream For Approval</a>
						@endif

					</div>
         <div class="container-fluid p-0">
	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-6">
                <h4><i class="entypo-video"></i> {{ $inputs_details_array['text_main_name']  }}</h4>
                
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
                <a href="{{ route( $inputs_details_array['create_route'] ) }}" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> Add New</a>
				
				<div class="mt-2 d-flex justify-content-end align-items-center gap-2">
					<label for="search-box" class="fw-bold mb-0">Search:</label>
					<div class="w-50">
						<input type="text" id="search-box" class="form-control">
					</div>
				</div>
				
				{{-- Bulk video delete --}}
			 	<button style="margin-bottom: 10px" class="btn btn-primary delete_all"> Delete Selected Video </button>
			</div>
		</div>    
	
	<div class="clear"></div>

	<div class="gallery-env mt-2">
		
			<table class="data-tables table livestream_table iq-card text-center p-0" style="width:100%">
				<thead>
					<tr class="r1">
						<th>Select All <input type="checkbox" id="select_all"></th>
						<th>Image</th>
						<th>Title</th>
						<th>User Name</th>
						<th>{{ $inputs_details_array['text_main_name'] . ' Type'}}</th>
						<th>{{ $inputs_details_array['text_main_name'] . ' Access'}}</th>
						<th>Status</th>
						<th>Stream Type</th>
						<th>Publish Type</th>
						<th>Publish Time</th>
						<th>Slider</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($videos as $key => $video)

					<tr id="tr_{{ $video->id }}">
						<td><input type="checkbox"  class="sub_chk" data-id="{{$video->id}}"></td>

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
                        	<td> <p class = "bg-primary video_active"> <?php  echo "Published"; ?></p></td>
						<?php }elseif($video->active == 2){ ?>
                        	<td>  <p class = "bg-danger video_active"><?php  echo "Rejected"; ?></p></td>
						<?php }?>  

						<td> @if( $video->url_type != null && $video->url_type == "Encode_video") {{ 'Video Encoder' }} @elseif( $video->url_type != null && $video->url_type == "live_stream_video") {{ 'Live Stream Video' }} @else {{  ucwords($video->url_type)  }} @endif
							
							@if( $video->url_type != null && $video->url_type == "Encode_video")
								<i class="fa fa-info-circle encode_video_alert"  aria-hidden="true" 
										data-title = "{{ $video->title }}" data-name="{{$video->Stream_key}}"
										data-rtmpURL= "{{ $video->rtmp_url ? $video->rtmp_url : null }}" 
										data-hls-url= "{{ $video->hls_url ? $video->hls_url : null }}" 
										
										data-linkedin-restream = "{{ $video->linkedin_restream_url && $video->linkedin_streamkey  ? $video->youtube_restream_url.'/'. $video->linkedin_streamkey : " " }}" 
										data-youtube-restream  = "{{ $video->youtube_restream_url && $video->youtube_streamkey  ? $video->youtube_restream_url.'/'. $video->youtube_streamkey : " " }}" 
										data-facebook-restream = "{{ $video->fb_restream_url && $video->fb_streamkey  ? $video->fb_restream_url."/".$video->fb_streamkey : " " }}"
										data-twitter-restream  = "{{ $video->twitter_restream_url && $video->twitter_streamkey ? $video->twitter_restream_url."/".$video->twitter_streamkey : " " }}"   
										value="{{$video->Stream_key}}" onclick="addRow(this)" >
								</i>
							@endif

 						</td>

						<td>{{ ucwords(str_replace('_', ' ', $video->publish_type))}}</td>

						{{-- Publish Time --}}
						<td>
							@if ($video->publish_type == "publish_now" || ($video->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($video->publish_time))) 
                                                                    
								<ul class="vod-info m-0 pt-1">
									<li><span></span> <small>LIVE NOW</small> </li>
								</ul>

							@elseif ($video->publish_type == "publish_later")
								<small> {{ 'Live Start On '.  Carbon\Carbon::createFromFormat('Y-m-d\TH:i',$video->publish_time)->format('j F Y g:ia') }} </small>
							
							@elseif ( $video->publish_type == "recurring_program" )

								@php
									$recurring_timezone = App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first();
									$Current_time = Carbon\Carbon::now(current_timezone());
									$convert_time = $Current_time->copy()->timezone($recurring_timezone);
								@endphp
								
								@if ( $video->recurring_program != "custom")
									
									@php

										switch ($video->recurring_program_week_day) {

											case 1 :
												$recurring_program_week_day =  'Monday' ;
											break;

											case 2:
												$recurring_program_week_day =  'Tuesday' ;
											break;

											case 3 :
												$recurring_program_week_day = 'Wednesday' ;
											break;

											case 4:
												$recurring_program_week_day =  'Thursday' ;
											break;

											case 5:
												$recurring_program_week_day =  'Friday' ;
											break;

											case 6:
												$recurring_program_week_day =  'Saturday' ;
											break;

											case 7:
												$recurring_program_week_day = 'Sunday' ;
											break;

											default:
												$recurring_program_week_day =  null ;
											break;
										}
									@endphp


									@if ( $video->recurring_program == "daily")

										@if ( $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')  ) 
											<ul class="vod-info m-0 pt-1">
												<li><span></span> <small>LIVE NOW</small> </li>
											</ul>
										@else
											<small> {{ 'Live Starts daily from '. Carbon\Carbon::parse($video->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($video->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
										@endif

										
									@elseif( $video->recurring_program == "weekly" )
										
										@if ( $video->recurring_program_week_day == $convert_time->format('N') && $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')  ) 
											<ul class="vod-info m-0 pt-1">
												<li><span></span> <small>LIVE NOW</small> </li>
											</ul>
										@else
											<small> {{ 'Live Starts On Every '. $video->recurring_program . " " . @$recurring_program_week_day . $video->recurring_program_month_day ." from ". Carbon\Carbon::parse($video->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($video->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
										@endif


									@elseif( $video->recurring_program == "monthly" )

										@if ( $video->recurring_program_month_day == $convert_time->format('d') && $video->program_start_time <= $convert_time->format('H:i') &&  $video->program_end_time >= $convert_time->format('H:i')   )
											<ul class="vod-info m-0 pt-1">
												<li><span></span> <small>LIVE NOW</small> </li>
											</ul>
										@else
											<small> {{ 'Live Starts On Every '. $video->recurring_program . " " . $video->recurring_program_month_day ." from ". Carbon\Carbon::parse($video->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($video->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
										@endif

									@endif
								

								@elseif (  $video->recurring_program == "custom" )

									@if ( $video->custom_start_program_time <= $convert_time->format('Y-m-d\TH:i:s') &&  $video->custom_end_program_time >= $convert_time->format('Y-m-d\TH:i:s') ) 
										<ul class="vod-info m-0 pt-1">
											<li><span></span> <small>LIVE NOW</small> </li>
										</ul>
									@else
										<small> {{ 'Live Starts On '. Carbon\Carbon::parse($video->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $video->recurring_timezone)->pluck('time_zone')->first() }} </small>
									@endif
								@endif
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
                            <a href="{{ route( $inputs_details_array['view_route']  , $video->slug ) }}" target="_blank" class="iq-bg-warning"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
							<a href="{{ route( $inputs_details_array['edit_route'] , $video->id) }}" class="iq-bg-success ml-2 mr-2"><img class="ply " src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
							<a href="{{ route( $inputs_details_array['delete_route'] ,  $video->id ) }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
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

			var youtube_restream_data   = $(ele).attr('data-youtube-restream');
			var facebook_restream_data  = $(ele).attr('data-facebook-restream');
			var twitter_restream_data   = $(ele).attr('data-twitter-restream');
			var linkedin_restream_data  = $(ele).attr('data-linkedin-restream');


			var youtube_restream  = youtube_restream_data  == ' ' ?  " " : '<div class="col-md-4"> <lable> Youtube </lable>  <td> <span class="btn btn-primary" id="youtube_button"  data-hls-url ='+hls_url+'  data-YouTube-restream = '+youtube_restream_data+'  onclick="YouTube_restream(this)">  Start </span> </td></div>'  ;
			var facebook_restream = facebook_restream_data == ' ' ?  " " : '<div class="col-md-4"> <lable> FaceBook </lable> <td> <span class="btn btn-primary" id="facebook_button" data-hls-url ='+hls_url+'  data-Facebook-restream= '+facebook_restream_data+' onclick="facebook_restream(this)"> Start </span> </td></div>'  ;
			var twitter_restream  = twitter_restream_data  == ' ' ?  " " : '<div class="col-md-4"> <lable> Twitter </lable> <td> <span class="btn btn-primary"  id="twitter_button" data-hls-url ='+hls_url+'   data-Twitter-restream= '+twitter_restream_data+' onclick="twitter_restream(this)"> Start </span> </td></div>' ;
			var linkedin_restream = linkedin_restream_data == " " ? " " : '<div class="col-md-4"> <lable> Linkedin </lable> <td> <span class="btn btn-primary" id="linkedin_button" data-hls-url ='+hls_url+'  data-Linkedin-restream= '+linkedin_restream_data+' onclick="Linkedin_restream(this)"> Start </span> </td></div>'  ;
		
			Swal.fire({
					allowOutsideClick:false,
					icon:'success',
					title: 'RTMP Streaming Details for '+ Rtmp_title ,
					html: '<div class="col-md-12">' + ' URL :  ' + Rtmp_url + '</div>' +"<br>"+ 
						  '<div class="col-md-12">' + 'Stream Key :  ' +  stream_key + '</div>'+"<br>"+ 
						  '<div class="col-md-12">' + 'HLS URL :  ' +  hls_url + '</div>' +"<br>"+ 
						  '<div class="col-md-12">' + '<lable> Live Re-stream : </lable> <br> <br> <p class="restream_error_message">  </p>  <div class="row">' +  youtube_restream  +  facebook_restream + twitter_restream + linkedin_restream +'</div> </div>' 
			})
		}

		function YouTube_restream(ele){

			$('#youtube_button').empty().append('Stop');
			$('#youtube_button').removeAttr('onclick').attr('onClick', 'stop_YouTube_restream(this);');

			var streaming_url  = $(ele).attr('data-YouTube-restream');
			var Hls_url        = $(ele).attr('data-hls-url');

			$.ajax({
				type   : 'POST',
				url    : "{{ route('youtube_start_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					streaming_url : streaming_url, 
					hls_url		  : Hls_url,
				},

				success:function(data){
					if( data.status == false ){
						$('#youtube_button').empty().append('Start');
						$('#youtube_button').removeAttr('onclick').attr('onClick', 'YouTube_restream(this);');
						$('.restream_error_message').empty().append(data.message).css('color', '#f92b2b');
					}
				}
        	});
		}

		function facebook_restream(ele){
			
			$('#facebook_button').empty().append('Stop');
			$('#facebook_button').removeAttr('onclick').attr('onClick', 'stop_facebook_restream(this);');

			var streaming_url = $(ele).attr('data-facebook-restream');
			var Hls_url       = $(ele).attr('data-hls-url');

			$.ajax({
				type   : 'POST',
				url    : "{{ route('fb_start_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					streaming_url : streaming_url, 
					hls_url		  : Hls_url,
				},

				success:function(data){
					if( data.status == false ){
						$('.restream_error_message').empty().append(data.message).css('color', '#f92b2b');
						$('#facebook_button').empty().append('Start');
						$('#facebook_button').removeAttr('onclick').attr('onClick', 'facebook_restream(this);');
					}
				}
        	});
		}

		function twitter_restream(ele){

			$('#twitter_restream').empty().append('Stop');
			$('#twitter_button').removeAttr('onclick').attr('onClick', 'stop_twitter_restream(this);');

			var streaming_url  = $(ele).attr('data-twitter-restream');
			var Hls_url        = $(ele).attr('data-hls-url');

			$.ajax({
				type   : 'POST',
				url    : "{{ route('twitter_start_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					streaming_url : streaming_url, 
					hls_url		  : Hls_url,
				},

				success:function(data){
					if( data.status == false ){
						$('#twitter_button').empty().append('Start');
						$('#twitter_button').removeAttr('onclick').attr('onClick', 'twitter_restream(this);');
						$('.restream_error_message').empty().append(data.message).css('color', '#f92b2b');
					}
				}
        	});
		}

		function Linkedin_restream(ele){

			$('#linkedin_button').empty().append('Stop');
			$('#linkedin_button').removeAttr('onclick').attr('onClick', 'stop_Linkedin_restream(this);');

			var streaming_url  = $(ele).attr('data-linkedin-restream');
			var Hls_url        = $(ele).attr('data-hls-url');

			$.ajax({
				type   : 'POST',
				url    : "{{ route('linkedin_start_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					streaming_url : streaming_url, 
					hls_url		  : Hls_url,
				},

				success:function(data){
					if( data.status == false ){
						$('#linkedin_button').empty().append('Start');
						$('#linkedin_button').removeAttr('onclick').attr('onClick', 'Linkedin_restream(this);');
						$('.restream_error_message').empty().append(data.message).css('color', '#f92b2b');
					}
				}
        	});
		}

		function stop_YouTube_restream(ele){

			// $('#youtube_button').empty().append('Stop');
			// $('#youtube_button').removeAttr('onclick').attr('onClick', 'stop_YouTube_restream(this);');

			var streaming_url  = $(ele).attr('data-YouTube-restream');
			var Hls_url        = $(ele).attr('data-hls-url');

			$.ajax({
				type   : 'POST',
				url    : "{{ route('youtube_stop_restream') }}",
				data:{
					_token : "{{ csrf_token() }}",
					streaming_url : streaming_url, 
					hls_url		  : Hls_url,
				},

				success:function(data){
					if( data.status == false ){
						$('#youtube_button').empty().append('Stop');
						$('.restream_error_message').empty().append(data.message).css('color', '#f92b2b');
					}else{
						$('#youtube_button').empty().append('Start');
						$('#youtube_button').removeAttr('onclick').attr('onClick', 'YouTube_restream(this);');
					}
				}
        	});

		}

		function stop_facebook_restream(ele) {

		}

		function stop_twitter_restream(ele) {

		}

		function stop_Linkedin_restream(ele) {

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
				location.reload();
			}
			})
		}
	});

    $(document).ready(function(){
       
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })

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
	   $(status).prop('checked', !video_Status);

	}
	}
</script>
<script>
$(document).ready(function () {
    $("#search-box").on("keyup", function () {
        var search = $(this).val().trim();
        if (search === "") {
            location.reload();
            return;
        }
        $.ajax({
            url: "{{ route('admin.livestream.search') }}",
            method: "GET",
            data: { search: search },
            success: function (response) {
                $("tbody").html(response);
            },
            error: function () {
                console.error("Error fetching search results");
            }
        });
    });
});
</script>

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
				   alert("Please select Anyone Live Stream");  
			 }  
			 else 
			 {  
				var check = confirm("Are you sure you want to delete selected Live Stream?");  
				if(check == true){  
					var join_selected_values =allVals.join(","); 
 
					$.ajax({
					  url: '{{ URL::to('admin/Livestream_bulk_delete') }}',
					  type: "get",
					  data:{ 
						 _token: "{{csrf_token()}}" ,
						 live_stream_video_id: join_selected_values, 
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
							   location.href = '{{ URL::to('admin/livestream') }}';
							});
						 }
					  },
				   });
				}  
			 }  
		});
 
	});
</script>

	@stop

@stop

