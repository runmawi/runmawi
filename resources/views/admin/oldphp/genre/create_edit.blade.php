@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ Url::to('/application/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->
	
	<ol class="breadcrumb"> <li> <a href="{{ Url::to('/admin/genre_list') }}"><i class="fa fa-newspaper-o"></i>Manage Genre</a> </li> <li class="active">@if(!empty($genre->id)) <strong>{{ $genre->name }}</strong> @else <strong>Create Genre</strong> @endif</li> </ol>

	<div class="admin-section-title">
	@if(!empty($genre->id))
		<h3>{{ $genre->name }}</h3> 
	@else
		<h3><i class="entypo-plus"></i> Create Genre</h3> 
	@endif
	</div>
	<div class="clear"></div>

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row">
				
				<div class="@if(!empty($genre->created_at)) col-sm-6 @else col-sm-8 @endif"> 

					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Genre</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p>Genre Name e.g. "Action, Romantic"</p> 
							<input type="text" class="form-control" name="name" id="name" value="@if(!empty($genre->name)){{ $genre->name }}@endif" />
                            
							<div>
							<label for="web_home" style="float:left; display:block; margin-right:10px;">Is this Genre Display in Web Home Page:</label>
							<input type="checkbox" @if(!empty($genre->web_home) && $genre->web_home == 1){{ 'checked="checked"' }}@endif name="web_home" id="web_home" value="1" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
							</div>
							<div>
							<label for="app_home" style="float:left; display:block; margin-right:10px;">Is this Genre Display in App Home Screen:</label>
							<input type="checkbox" @if(!empty($genre->app_home) && $genre->app_home == 1){{ 'checked="checked"' }}@endif name="app_home"  id="app_home" value="1" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
							</div>
						</div> 
					</div>
                    <div class="panel panel-primary" data-collapsed="0"> 
                        <div class="panel-heading"> 
                            <label for="web_home" style="float:left; display:block; margin-right:10px;">Slug:</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="@if(!empty($genre->slug)){{ $genre->slug }}@endif" />
                        </div>
                        </div>
                    
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Genre Image Cover</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							@if(!empty($genre->image))
							<img src="{{ Config::get('site.uploads_dir') . 'genres/' . $genre->image }}" class="movie-img" width="200"/>
							@endif
							<p>Select the movie image (1280x720 px or 16:9 ratio):</p> 
							<input type="file" multiple="true" class="form-control" name="image" id="image" />

						</div> 
					</div>

				</div>


			</div>

			<div class="clear"></div>


			@if(isset($genre->id))
				<input type="hidden" id="id" name="id" value="{{ $genre->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>

	
	
	
	@section('javascript')


	<script type="text/javascript" src="{{ Url::to('/application/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ Url::to('/application/assets/js/jquery.mask.min.js') }}"></script>

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
