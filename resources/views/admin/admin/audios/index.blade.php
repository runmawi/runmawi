@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-audio"></i> Audios</h3><a href="{{ URL::to('admin/audios/create') }}" class="btn btn-black"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
			<div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="<?= Request::get('s'); ?>" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>

	<div class="gallery-env">
		
		<div class="row">

		@foreach($audios as $audio)
		
			<div class="col-sm-6 col-md-4">
				
				<article class="album">
					
					<header>
						
						<a href="{{ URL::to('audio/') . '/' . $audio->id }}" target="_blank">
							<img src="{{ Config::get('site.uploads_dir') . 'images/' . $audio->image }}" />
						</a>
						
						<a href="{{ URL::to('admin/audios/edit') . '/' . $audio->id }}" class="album-options">
							<i class="entypo-pencil"></i>
							Edit
						</a>
					</header>
					
					<section class="album-info">
						<h3><a href="{{ URL::to('admin/audios/edit') . '/' . $audio->id }}"><?php if(strlen($audio->title) > 25){ echo substr($audio->title, 0, 25) . '...'; } else { echo $audio->title; } ?></a></h3>
						
						<p>{{ $audio->description }}</p>
					</section>
					
					<footer>
						
						<div class="album-images-count">
							<i class="entypo-audio"></i>
						</div>
						
						<div class="album-options">
							<a href="{{ URL::to('admin/audios/edit') . '/' . $audio->id }}">
								<i class="entypo-pencil"></i>
							</a>
							
							<a href="{{ URL::to('admin/audios/delete') . '/' . $audio->id }}" class="delete">
								<i class="entypo-trash"></i>
							</a>
						</div>
						
					</footer>
					
				</article>
				
			</div>

		@endforeach

		<div class="clear"></div>

		<div class="pagination-outter"><?= $audios->appends(Request::only('s'))->render(); ?></div>
		
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
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this audio?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>

	@stop

@stop

