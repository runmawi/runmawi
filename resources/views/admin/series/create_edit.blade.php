@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop


@section('content')

<div id="admin-container" style="margin-left: 340px;
    padding-top: 100px;" >
<!-- This is where -->
	
	<div class="admin-section-title">
	@if(!empty($series->id))
		<h3>{{ $series->title }}</h3> 
		<a href="{{ URL::to('series') . '/' . $series->id }}" target="_blank" class="btn btn-info">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
	@else
		<h3><i class="entypo-plus"></i> Add New Series</h3> 
	@endif
	</div>

	

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

		@if(!empty($series->created_at))
			<div class="row">
				<div class="col-md-9">
		@endif
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title">Title</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p>Add the series title in the textbox below:</p> 
							<input type="text" class="form-control" name="title" id="title" placeholder="Series Title" value="@if(!empty($series->title)){{ $series->title }}@endif" />
						</div> 
					</div>

                    
            @if(!empty($series->created_at))
                    </div>
                    <div class="col-sm-3">
                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                            <div class="panel-title">Created Date</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                            <div class="panel-body" style="display: block;"> 
                                <p>Select Date/Time Below</p> 
                                <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($series->created_at)){{ $series->created_at }}@endif" />
                            </div> 
                        </div>
                    </div>
                </div>
            @endif


			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Series Image Cover</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					@if(!empty($series->image))
						<img src="{{ URL::to('/') . '/public/uploads/images/' . $series->image }}" class="series-img" width="200"/>
					@endif
					<p>Select the series image (1280x720 px or 16:9 ratio):</p> 
					<input type="file" multiple="true" class="form-control" name="image" id="image" />
					
				</div> 
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Series Source</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<label for="type" style="float:left; margin-right:10px; padding-top:1px;">Series Format</label>
					<select id="type" name="type">
						<option value="embed">Embed Code</option>
						<option value="file" @if(!empty($series->type) && $series->type == 'file'){{ 'selected' }}@endif>Series File</option>
						<option value="upload" @if(!empty($series->type) && $series->type == 'upload'){{ 'selected' }}@endif>Upload Series</option>
					</select>
					<hr />

					<div class="new-series-file" @if(!empty($series->type) && $series->type == 'file'){{ 'style="display:block"' }}@else style = "display:none" @endif>
						<label for="mp4_url">Mp4 File URL:</label>
						<input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($series->mp4_url)){{ $series->mp4_url }}@endif" />
						<hr />
						<label for="webm_url">WebM File URL:</label>
						<input type="text" class="form-control" name="webm_url" id="webm_url" value="@if(!empty($series->webm_url)){{ $series->webm_url }}@endif" />
						<hr />
						<label for="ogg_url">Ogg File URL:</label>
						<input type="text" class="form-control" name="ogg_url" id="ogg_url" value="@if(!empty($series->ogg_url)){{ $series->ogg_url }}@endif" />
					</div>

					<div class="new-series-embed" @if(!empty($series->type) && $series->type == 'embed')style="display:block"@else style = "display:none" @endif>
						<label for="embed_code">Embed Code:</label>
						<textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($series->embed_code)){{ $series->embed_code }}@endif</textarea>
					</div>

					<div class="new-series-upload" @if(!empty($series->type) && $series->type == 'upload')style="display:block"@else style = "display:none" @endif>
						<label for="embed_code">Upload Series</label>
						<input type="file" name="series_upload" id="series_upload">
					</div>
					@if(!empty($series->type) && ($series->type == 'upload' || $series->type == 'file'))
					<series width="200" height="200" controls>
					<source src="{{ URL::to('/').'/storage/app/public/'.$series->mp4_url }}" type="series/mp4">
					</series>
					@endif
					@if(!empty($series->type) && $series->type == 'embed')
					<iframe src="{{ URL::to('/').'/storage/app/public/'.$series->mp4_url }}"></iframe>
					@endif
				</div> 
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				


			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Series Details, Links, and Info</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="details" id="summary-ckeditor">@if(!empty($series->details)){{ htmlspecialchars($series->details) }}@endif</textarea>
				</div> 
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Short Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Add a short description of the series below:</p> 
					<textarea class="form-control" name="description" id="description">@if(!empty($series->description)){{ htmlspecialchars($series->description) }}@endif</textarea>
				</div> 
			</div>

			<div class="row"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Genre</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Select a Series Category Below:</p>
					<select id="genre_id" name="genre_id">
						<option value="0">Uncategorized</option>
						@foreach($series_categories as $category)
							<option value="{{ $category->id }}" @if(!empty($series->genre_id) && $series->genre_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						@endforeach
					</select>
				</div> 
			</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Series Ratings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					IMDb Ratings 10 out of 10
					<input class="form-control" name="rating" id="rating" value="@if(!empty($series->rating)){{ $series->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
				</div> 
			</div>
			</div>
			</div>

			<div class="row"> 
			<div class="col-sm-6">
			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Language</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Select a Series Language Below:</p>
					<select class="form-control" id="language" name="language">
						@foreach($languages as $language)
							<option value="{{ $language->id }}" @if(!empty($series->language) && $series->language == $language->id)selected="selected"@endif>{{ $language->language }}</option>
						@endforeach
					</select>
				</div> 
			</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Series Year</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					Series Created Year
					<input class="form-control" name="year" id="year" value="@if(!empty($series->year)){{ $series->year }}@endif">
				</div> 
			</div>
			</div>
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Tags</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body" style="display: block;"> 
					<p>Add series tags below:</p> 
					<input class="form-control" name="tags" id="tags" value="">
				</div> 
			</div>

			<div class="clear"></div>


			<div class="row"> 

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Duration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p>Enter the series duration in the following format (Hours : Minutes : Seconds)</p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($series->duration)){{ gmdate('H:i:s', $series->duration) }}@endif">
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> User Access</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<label for="access" style="float:left; margin-right:10px;">Who is allowed to view this series?</label>
							<select id="access" name="access">
								<option value="guest" @if(!empty($series->access) && $series->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
								<option value="registered" @if(!empty($series->access) && $series->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
								<option value="subscriber" @if(!empty($series->access) && $series->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
							</select>
							<div class="clear"></div>
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Status Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<div>
								<label for="featured" style="float:left; display:block; margin-right:10px;">Is this series Featured:</label>
								<input type="checkbox" @if(!empty($series->featured) && $series->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="active" style="float:left; display:block; margin-right:10px;">Is this series Active:</label>
								<input type="checkbox" @if(!empty($series->active) && $series->active == 1){{ 'checked="checked"' }}@elseif(!isset($series->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
							</div>
						</div> 
					</div>
				</div>

			</div><!-- row -->

			@if(!isset($series->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
			@endif

			@if(isset($series->id))
				<input type="hidden" id="id" name="id" value="{{ $series->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

		</form>

		<div class="clear"></div>
		<!-- Manage Season -->
		@if(!empty($series->id))
		<h3>Season & Episodes</h3> 
		<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<a href="{{ URL::to('admin/season/create/') . '/' . $series->id  }}" class="btn btn-success"><i class="fa fa-plus-circle"></i>Create Season</a>
			</div>
		</div>
		<div class="row">
<table class="table table-bordered genres-table">

		<tr class="table-header">
			<th>Seasons</th>
			<th>Episodes</th>
			<th>Operation</th>
			
			@foreach($seasons as $key=>$seasons_value)
			<tr>
				<td valign="bottom"><p>Season {{$key+1}}</p></td>
				<td valign="bottom"><p>{{count($seasons[$key]['episodes'])}} Episodes</p></td>
				<td>
					<p>
						<a href="{{ URL::to('admin/season/edit') . '/' . $series->id. '/' . $seasons_value->id }}" class="btn btn-xs btn-black"><span class="fa fa-edit"></span> Manage Episodes</a>
						<a href="{{ URL::to('admin/season/delete') . '/' . $seasons_value->id }}" class="btn btn-xs btn-white delete"><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
			@endforeach
	</table>
            </div>
	

		<div class="clear"></div>

		
		</div>
		</div>
		@endif
<!-- This is where now -->
</div>

	
	
	
	@section('javascript')


	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');
		$('#tags').tagsInput();

		$('#type').change(function(){
			if($(this).val() == 'file'){
				$('.new-series-file').show();
				$('.new-series-embed').hide();
				$('.new-series-upload').hide();

			} else if($(this).val() == 'embed'){ 
				$('.new-series-file').hide();
				$('.new-series-embed').show();
				$('.new-series-upload').hide();

			}else{
				$('.new-series-file').hide();
				$('.new-series-embed').hide();
				$('.new-series-upload').show();
				
			}
		});

		tinymce.init({
			relative_urls: false,
		    selector: '#details',
		    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
		    plugins: [
		         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		         "save table contextmenu directionality emoticons template paste textcolor code"
		   ],
		   menubar:false,
		 });

	});

	function NumAndTwoDecimals(e , field) {
		var val = field.value;
		var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
		var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
		if (re.test(val)) {
			if(val > 10){
				alert("Maximum value allowed is 10");
				field.value = "";
			}
		} else {
			val = re1.exec(val);
			if (val) {
				field.value = val[0];
			} else {
				field.value = "";
			}
		}

	}


	</script>
    
        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

        <script>
        CKEDITOR.replace( 'summary-ckeditor', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        </script>



	@stop

@stop
