@extends('admin.master')


@section('content')
<style>
    .form-control {
    background-color: var(--iq-body-bg);
    border: 1px solid transparent;
    height: 46px;
    position: relative;
    color: var(--iq-body-text);
    font-size: 16px;
    width: 100%;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}
</style>
<div id="content-page" class="content-page">
         <div class="container-fluid">
<!--<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Update Category</h4>
</div>-->
<div class="iq-card">
<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/videos/categories/update') }}" method="post" enctype="multipart/form-data">
       
         <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                        <label>Name:</label>

                        <input type="text" id="name" name="name" value="{{ $categories[0]->name }}" class="form-control" placeholder="Enter Name">
                        @if ($errors->has('name'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label>Slug:</label>

                        <input type="text" id="slug" name="slug" value="{{ $categories[0]->slug }}" class="form-control" placeholder="Enter Slug">
                        @if ($errors->has('slug'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>
        
        
                <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                        <label>Display In Home page:</label>
                        <input type="radio" id="in_home" name="in_home" value="1" <?php if( $categories[0]->in_home == 1) { echo "checked";} ?>>Yes
                        <input type="radio" id="in_home" name="in_home" value="0" <?php if( $categories[0]->in_home == 0) { echo "checked";} ?>>No

                    </div>
        
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label>Image:</label>
                        @if(!empty($categories[0]->image))
                        <img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $categories[0]->image }}" class="movie-img" width="200"/>
                        @endif
                        <p>Select the movie image (1280x720 px or 16:9 ratio):</p> 
                        <input type="file" multiple="true" class="form-control" name="image" id="image" />

                    </div>




                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">

                        <label>Category:</label>
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
        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<a type="button" class="btn btn-primary" data-dismiss="modal" href="{{ URL::to('admin/videos/categories') }}">Close</a>
	<button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
</div>
    </div>
</div>
</div>
	@section('javascript')
<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>
             @stop

@stop