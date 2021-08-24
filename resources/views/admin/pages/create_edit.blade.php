@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ '/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop


@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="iq-card">

<div id="admin-container">
<!-- This is where -->
	
   <!-- <ol class="breadcrumb"> <li> <a href="{{ URL::to('/admin/pages') }} "><i class="fa fa-newspaper-o"></i>All Pages</a> </li> <li class="active">@if(!empty($page->id)) <strong>{{ $page->title }}</strong> @else <strong>New Page</strong> @endif</li> </ol>-->

	<div class="admin-section-title">
	@if(!empty($page->id))
        <div class="d-flex justify-content-between">
            <div>
		<h4>{{ $page->title }}</h4> </div>
            <div>
		<a href="{{ URL::to('page') . '/' . $page->slug }}" target="_blank" class="btn btn-info">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i></a></div></div>
		
	@else
		<h5><i class="entypo-plus"></i> Add New Page</h5> 
	@endif
	</div>
    
      @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif    
    
    
    <hr>
	<div class="clear"></div>

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row mt-4">
				
				<div class="@if(!empty($page->created_at)) col-sm-6 @else col-sm-8 @endif"> 

					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Title</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Add the page title in the textbox below:</p> 
							<input type="text" class="form-control" name="title" id="title" placeholder="Page Title" value="@if(!empty($page->title)){{ $page->title }}@endif" />
						</div> 
					</div>

				</div>

				<div class="@if(!empty($page->created_at)) col-sm-3 @else col-sm-4 @endif">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>SEO URL Slug</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">(example. /page/slug-name)</p> 
							<input type="text" class="form-control" name="slug" id="slug" placeholder="slug-name" value="@if(!empty($page->slug)){{ $page->slug }}@endif" />
						</div> 
					</div>
				</div>

				@if(!empty($page->created_at))
					<div class="col-sm-3">
						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
							<div class="panel-title"><label>Created Date</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
							<div class="panel-body" style="display: block;"> 
								<p class="p1">Select Date/Time Below</p> 
								<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($page->created_at)){{ $page->created_at }}@endif" />
							</div> 
						</div>
					</div>
				@endif

			</div>
            
             <div class=" mt-3 form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                        <label>Banner:</label>
                        <input type="file" multiple="true" class="form-control" name="banner" id="banner" />

            </div>



			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><label>Page Content</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body mt-3" style="display: block; padding:0px;">
					<textarea class="form-control" name="body" id="summary-ckeditor">@if(!empty($page->body)){{ $page->body }}@endif</textarea>
				</div> 
			</div>

			<div class="clear"></div>


			<div class="row"> 

				<div class="col-sm-4 mt-3"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"><label> Status Settings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<div>
								<label for="active" style="float:left; display:block; margin-right:10px;">Is this page Active:</label>
								<input type="checkbox" @if(!isset($page->active) || (isset($page->active) && $page->active))checked="checked" value="1"@else value="0"@endif name="active" id="active" />
							</div>
						</div> 
					</div>
                    <div class="mt-3">
                    @if(!isset($page->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
			@endif

			@if(isset($page->id))
				<input type="hidden" id="id" name="id" value="{{ $page->id }}" />
			@endif
 </div>
				</div>

			</div><!-- row -->

			<div class="mt-2 p-2"  style="display: flex;
    justify-content: flex-end;">
			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
     <input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" /></div>

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>

    </div></div>
	
</div>
	@section('javascript')


	<script type="text/javascript" src="{{ '/saka/application/assets/admin/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/saka/application/assets/js/jquery.mask.min.js' }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');

		$('input[type="checkbox"]').change(function() {
			if($(this).is(":checked")) {
		    	$(this).val(1);
		    } else {
		    	$(this).val(0);
		    }
		    console.log('test ' + $(this).is( ':checked' ));
		});

		tinymce.init({
			relative_urls: false,
		    selector: '#body',
		    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
		    plugins: [
		         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		         "save table contextmenu directionality emoticons template paste textcolor code"
		   ],
		   menubar:false,
		 });

	});



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