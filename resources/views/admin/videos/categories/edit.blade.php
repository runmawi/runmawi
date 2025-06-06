@extends('admin.master')


@section('content')

<div id="content-page" class="content-page">
         <div class="container-fluid">

<div class="iq-card">
    <h4><i class="entypo-archive"></i> Add New Category</h4>
<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/videos/categories/update') }}" method="post" enctype="multipart/form-data">
       
         <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                        <label class="m-0">Name:</label>

                        <input type="text" id="name" name="name" value="{{ $categories[0]->name }}" class="form-control" placeholder="Enter Name">
                        @if ($errors->has('name'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label class="m-0">Slug:</label>

                        <input type="text" id="slug" name="slug" value="{{ $categories[0]->slug }}" class="form-control" placeholder="Enter Slug">
                        @if ($errors->has('slug'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>
        
                    <div class="form-group">
                        <label>Home Page Genre Name:</label>
                        <input type="text" id="home_genre" name="home_genre" value="{{ $categories[0]->home_genre }}" class="form-control" placeholder="Enter Home Page Genre Name">
                    </div>  
                <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                        <label class="m-0">Display In Home page:</label>
                        <input type="radio" id="in_home" name="in_home" value="1" <?php if( $categories[0]->in_home == 1) { echo "checked";} ?>> Yes &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="in_home" name="in_home" value="0" <?php if( $categories[0]->in_home == 0) { echo "checked";} ?>> No

                    </div>
                    <!-- <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label class="m-0">Display In Footer page:</label>
                        <input type="radio" id="footer" name="footer" value="1" <?php if( $categories[0]->footer == 1) { echo "checked";} ?>> Yes &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="footer" name="footer" value="0" <?php if( $categories[0]->footer == 1) { echo "checked";} ?>> No
                    </div> -->
                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label>Display In Menu :</label>
                        <input type="radio" checked id="in_menu"  id="in_menu" name="in_menu" value="1" <?php if( $categories[0]->in_menu == 1) { echo "checked";} ?>>Yes
                        <input type="radio" id="in_menu" name="in_menu" value="0"<?php if( $categories[0]->in_menu == 0) { echo "checked";} ?>>No
                    </div>
                    <div class="col-md-12">
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="m-0">Image:</label>
                        @if(!empty($categories[0]->image))
                        <img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $categories[0]->image }}" class="movie-img" width="200"/>
                        @endif
                    </div>
        
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="m-0">Choose Category image (1080 X 1920px or 9:16 ratio):</label> 
                        <input type="file" multiple="true" class="form-control" name="image" id="image" />
                    </div>

                    </div>
                    <div class="col-md-6">
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="m-0">Banner Image:</label>
                        @if(!empty($categories[0]->banner_image))
                        <img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $categories[0]->banner_image }}" class="movie-img" width="200"/>
                        @endif
                    </div>
        
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label class="m-0">Choose Category Banner Image (1280x720 px or 16:9 ratio):</label> 
                        <input type="file" multiple="true" class="form-control" name="banner_image" id="banner_image" />
                    </div>

                    </div>
                    </div>
                    </div>
                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">

                        <label class="m-0">Category:</label>
                        <select id="parent_id" name="parent_id" class="form-control">
                        	
                            <option value="0">Select</option>
                            @foreach($allCategories as $rows)
                                <option value="{{ $rows->id }}" @if ($rows->id == $categories[0]->parent_id) selected  @endif >{{ $rows->name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('parent_id'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('parent_id') }}</strong>
                            </span>
                        @endif

                    </div>
                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label>Display In Home Banner:</label>
                            <input type="checkbox" @if($categories[0]->banner == 1){{ 'checked' }} @endif id="banner"  id="banner" name="banner" value="1">
                    </div>
                                    
        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/videos/categories') }}">Close</a>
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