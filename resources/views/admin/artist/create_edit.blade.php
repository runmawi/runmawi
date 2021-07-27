@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->
	
	<ol class="breadcrumb"> <li> <a href="{{ Url::to('/admin/artist_list') }}"><i class="fa fa-newspaper-o"></i>Manage Artist</a> </li> <li class="active">@if(!empty($artist->id)) <strong>{{ $artist->name }}</strong> @else <strong>Create Artist</strong> @endif</li> </ol>

	<div class="admin-section-title">
	@if(!empty($artist->id))
		<h3>{{ $artist->name }}</h3> 
	@else
		<h3><i class="entypo-plus"></i> Create Artist</h3> 
	@endif
	</div>
	<div class="clear"></div>

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row">
				
				<div class="@if(!empty($artist->created_at)) col-sm-6 @else col-sm-8 @endif"> 

					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Artist</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<input type="text" class="form-control" name="artist_name" id="artist_name" value="@if(!empty($artist->artist_name)){{ $artist->artist_name }}@endif" />
						</div> 
					</div>
                    
                      <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<textarea class="form-control" name="description" id="description" >@if(!empty($artist->description)){{ $artist->description }}@endif</textarea>
						</div> 
					</div>  
                    
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Picture</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							@if(!empty($artist->image))
							<img src="{{ URL::to('/public/uploads/artists/') . '/'.$artist->image }}" class="movie-img" width="200"/>
							@endif
							<p>Select the artist image (300x300 px or 2:2 ratio):</p> 
							<input type="file" multiple="true" class="form-control" name="image" id="image" />

						</div> 
					</div>

				</div>


			</div>

			<div class="clear"></div>


			@if(isset($artist->id))
				<input type="hidden" id="id" name="id" value="{{ $artist->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>

	
	
	
	@section('javascript')


	<script type="text/javascript" src="{{ Url::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ Url::to('/assets/js/jquery.mask.min.js') }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){


		tinymce.init({
			relative_urls: false,
		    selector: '#body, #body_guest',
		    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
		    plugins: [
		         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		         "save table contextmenu directionality emoticons template paste textcolor code"
		   ],
		   menubar:false,
		 });

	});



	</script>

	@stop

@stop
