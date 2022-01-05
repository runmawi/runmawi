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
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop


@section('content')

<div id="admin-container" style="margin-left: 330px;
    padding-top: 100px;">
<!-- This is where -->
       <div class="iq-card">
           <div class="">
	<h4>Manage Artist</h4>
               <hr>
	<!--<ol class="breadcrumb"> <li> <a href="{{ Url::to('/admin/artist_list') }}"><i class="fa fa-newspaper-o"></i>Manage Artist</a> </li> <li class="active">@if(!empty($artist->id)) <strong>{{ $artist->name }}</strong> @else <strong>Create Artist</strong> @endif</li> </ol>-->
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
	<div class="admin-section-title">
	@if(!empty($artist->id))
		<h3>{{ $artist->name }}</h3> 
	@else
		<h4><i class="entypo-plus"></i> Create Artist</h4> 
	@endif
	</div>
	
	<div class="clear"></div>

		<form id="artist_form" method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row mt-3">
				
				<div class="@if(!empty($artist->created_at)) col-sm-6 @else col-sm-8 @endif"> 

					<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Artist</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<input type="text" class="form-control" name="artist_name" id="artist_name" value="@if(!empty($artist->artist_name)){{ $artist->artist_name }}@endif" />
						</div> 
					</div>
                    
                      <div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Description</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<textarea class="form-control" name="description" id="description" >@if(!empty($artist->description)){{ $artist->description }}@endif</textarea>
						</div> 
					</div>  
                    
					<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><label>Picture</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							@if(!empty($artist->image))
							<img src="{{ URL::to('/public/uploads/artists/') . '/'.$artist->image }}" class="movie-img" width="200"/>
							@endif
							<p class="p1">Select the artist image (300x300 px or 2:2 ratio):</p> 
							<input type="file" multiple="true" class="form-control" name="image" id="image" />

						</div> 
					</div>
                    <div class="clear mt-3"></div>
                    @if(isset($artist->id))
				<input type="hidden" id="id" name="id" value="{{ $artist->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			
				</div>

                   
			</div>
 <div class="rk">
                            <input type="submit" value="{{ $button_text }}" class="btn btn-info " />
                </div>
			<div class="clear"></div>


			

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
$('form[id="artist_form"]').validate({
	rules: {
	  artist_name : 'required',
	  description : 'required',
	  image : 'required',
      parent_id: {
                required: true
            }
	},
	messages: {
	  title: 'This field is required',
	  description: 'This field is required',
	  image: 'This field is required',
      parent_id: {
                required: 'This field is required',
            }
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });

</script>
	@stop

@stop
