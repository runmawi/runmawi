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
    .p1{
        font-size: 12px;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

	<div class="admin-section-title">
        <div class="iq-card">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-video"></i> Videos</h3><a href="{{ URL::to('admin/ppv/create') }}" class="btn btn-black"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
			<div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="<?= Request::get('s'); ?>" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>    
	
	<div class="clear"></div>

	<div class="gallery-env">
		
		<div class="row">

		@foreach($videos as $video)
		
			<div class="col-sm-6 col-md-4">
				
				<article class="album">
					
					<header>
						
						<a href="{{ URL::to('channelVideos/play_videos/') . '/' . $video->id }}" target="_blank">
							<img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" />
						</a>
						
						<a href="{{ URL::to('admin/videos/edit') . '/' . $video->id }}" class="album-options">
							<i class="entypo-pencil"></i>
							Edit
						</a>
					</header>
					
					<section class="album-info">
						<h3><a href="{{ URL::to('admin/ppv/edit') . '/' . $video->id }}"><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></a></h3>
						
						<p>{{ $video->description }}</p>
					</section>
					
					<footer>
						
						<div class="album-images-count">
							<i class="entypo-video"></i>
						</div>
						
						<div class="album-options">
							<a href="{{ URL::to('admin/ppv/edit') . '/' . $video->id }}">
								<i class="entypo-pencil"></i>
							</a>
							
							<a href="{{ URL::to('admin/ppv/delete') . '/' . $video->id }}" class="delete">
								<i class="entypo-trash"></i>
							</a>
						</div>
						
					</footer>
					
				</article>
				
			</div>

		@endforeach

		<div class="clear"></div>

		<div class="pagination-outter"><?= $videos->appends(Request::only('s'))->render(); ?></div>
		
		</div>
		
	</div>

</div>
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

	@stop

@stop

