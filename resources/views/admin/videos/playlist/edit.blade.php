@extends('admin.master')


@section('content')

<div id="content-page" class="content-page">
         <div class="container-fluid">

<div class="iq-card">
    <h4><i class="entypo-archive"></i> Add New PlayList</h4>
<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/videos/playlist/update') }}" method="post" enctype="multipart/form-data">
       
         <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label class="m-0">Name:</label>

                        <input type="text" id="title" name="title" value="{{ $Playlist->title }}" class="form-control" placeholder="Enter Name">
                        @if ($errors->has('title'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label class="m-0">Slug:</label>

                        <input type="text" id="slug" name="slug" value="{{ $Playlist->slug }}" class="form-control" placeholder="Enter Slug">
                        @if ($errors->has('slug'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>
        
                    <div class="col-md-12">
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="m-0">Image:</label>
                        @if(!empty($Playlist->image))
                        <img src="{{ URL::to('/') . '/public/uploads/images/' . $Playlist->image }}" class="movie-img" width="200"/>
                        @endif
                    </div>
        
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="m-0">Choose Playlist image (1080 X 1920px or 9:16 ratio):</label> 
                        <input type="file" multiple="true" class="form-control" name="image" id="image" />
                    </div>

                    </div>
      
                    </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label>Description:</label>
                            <textarea class="form-control" name="description" >{{ @$Playlist->description }}</textarea>
                    </div>
                                    
        <input type="hidden" name="id" id="id" value="{{ $Playlist->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/videos/playlist') }}">Close</a>
	<button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
</div>
    </div>
</div>
</div>

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
    
$('form[id="update-cat-form"]').validate({
	rules: {
        name : 'required',
	//   image : 'required',
      parent_id: {
                required: true
            }
	},
	messages: {
        name: 'This field is required',
	//   image: 'This field is required',
      parent_id: {
                required: 'This field is required',
            }
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });



	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>

@stop


@stop