@extends('admin.master')


@section('content')

<div id="content-page" class="content-page">
         <div class="container-fluid">

<div class="iq-card">
    <h4><i class="entypo-archive"></i> Add New Music Genre</h4>
	<div class="modal-body">
		<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/Music_genre/update') }}" method="post" enctype="multipart/form-data">
         			<div class="form-group">
                        <label class="m-0">Name:</label>
                        <input type="text" id="name" name="name" value="{{ $categories[0]->name }}" class="form-control" placeholder="Enter Name">
                    </div>

                    <div class="form-group">
                        <label class="m-0">Slug:</label>
                        <input type="text" id="slug" name="slug" value="{{ $categories[0]->slug }}" class="form-control" placeholder="Enter Slug">
                    </div>

					<div class="form-group">
                        <label>Active :</label>
                        <input type="radio" name="active" value="1" {{ $categories[0]->active == 1 ? "checked" : " " }} />Yes
                        <input type="radio" name="active" value="0" {{ $categories[0]->active == 0 ? "checked" : " " }} />No
                    </div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="m-0">Image:</label>
								@if(!empty($categories[0]->image))
									<img src="{{ URL::to('public/uploads/videocategory/'.$categories[0]->image) }}" class="movie-img" width="200"/>
								@endif
							</div>
			
							<div class="form-group">
								<input type="file" multiple="true" class="form-control" name="image" id="image" />
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
                    </div>

					<input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
					<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    		</form>
		</div>

		<div class="modal-footer">
			<a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/Music/Genre') }}">Close</a>
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