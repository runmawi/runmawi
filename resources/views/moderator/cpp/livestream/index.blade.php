@extends('moderator.master')
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
    label{
        font-size: 14px!important;
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
         <div class="container-fluid">
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
                <a href="{{ URL::to('/cpp/livestream/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>    
	
	<div class="clear"></div>

	<div class="gallery-env mt-2">
		
			<table class="data-tables table livestream_table " style="width:100%">
				<thead>
					<tr>
						<th><label>Image</label></th>
						<th><label>Title</label></th>
						<th><label>User Name</label></th>
						<th><label>Video Type</label></th>
						<th><label>Video Access</label></th>
						<th><label>Status</label></th>
						<th><label>Stream Type</label></th>
						<th><label>Action</label></th>
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
						<td class="bg-warning"> <?php echo "Pending"; ?></td>
							<?php }elseif($video->active == 1){ ?>
						<td class="bg-success"> <?php  echo "Approved"; ?></td>
							<?php }elseif($video->active == 2){ ?>
						<td class="bg-danger"> <?php  echo "Rejected"; ?></td>
							<?php }?>  

							<td> @if( $video->url_type != null && $video->url_type == "Encode_video") {{ 'Video Encoder' }} @elseif( $video->url_type != null && $video->url_type == "live_stream_video") {{ 'Live Stream Video' }} @else {{  ucwords($video->url_type)  }} @endif
							
								@if( $video->url_type != null && $video->url_type == "Encode_video")
									<i class="fa fa-info-circle encode_video_alert"  aria-hidden="true" data-title = "{{ $video->title }}" data-name="{{$video->Stream_key}}"  data-rtmpURL= "{{ $video->rtmp_url ? $video->rtmp_url : null }}" value="{{$video->Stream_key}}" onclick="addRow(this)" ></i>
								@endif
	
							</td>

						<td class="d-flex align-items-center list-user-action mt-4">
                            <!-- <a href="{{ URL::to('live/play/') . '/' . $video->id }}" target="_blank" class="iq-bg-warning"><i class="lar la-eye"></i></a> -->
							<a href="{{ URL::to('cpp/livestream/edit') . '/' . $video->id }}" class="iq-bg-success"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
							<a href="{{ URL::to('cpp/livestream/delete') . '/' . $video->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
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
    
    </div></div>

	@section('javascript')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		function addRow(ele) 
		{
			var stream_key= $(ele).attr('data-name');
			var Rtmp_url   = $(ele).attr('data-rtmpURL');
			var Rtmp_title = $(ele).attr('data-title');

			Swal.fire({
					allowOutsideClick:false,
					icon:'success',
					title: 'RTMP Streaming Details for '+ Rtmp_title ,
					html: '<div class="col-md-12">' + ' URL :  ' + Rtmp_url + '</div>' +"<br>"+ 
						  '<div class="col-md-12">' + 'Stream Key :  ' +  stream_key + '</div>' ,
			})
		}

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
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>


<script>
	$( document ).ready(function() {
		var Stream_error = '{{ $Stream_error }}';
		var Rtmp_url   = "{{ $Rtmp_url ? $Rtmp_url : 'No RTMP URL Added' }}" ;	
		var Stream_keys = '{{ $Stream_key }}';
		var Title = "{{ 'RTMP Streaming Details for'.' '. $title }}";
	
	
		if( Stream_error == 1){
			Swal.fire({
			allowOutsideClick:false,
			icon: 'success',
			title: Title,
			html: '<div class="col-md-12">' + ' URL :  ' + Rtmp_url + '</div>' +"<br>"+ 
					  '<div class="col-md-12">' + 'Stream Key :  ' +  Stream_keys + '</div>' ,
			}).then(function (result) {
			if (result.value) {
				@php
						session()->forget('Stream_key');
						session()->forget('Stream_error');
						session()->forget('Rtmp_url');
						session()->forget('title');
				@endphp
				location.href = "{{ URL::to('cpp/livestream')}}";
			}
			})
		}
	});
	
	</script>
		
	@stop

@stop

