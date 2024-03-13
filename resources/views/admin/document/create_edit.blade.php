@extends('admin.master')


@section('content')

<div id="content-page" class="content-page">
         <div class="container-fluid">

<div class="iq-card">
    <h4><i class="entypo-archive"></i> Add New Document Category</h4>
	<div class="modal-body">
		<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/document/update') }}" method="post" enctype="multipart/form-data">
         			<div class="form-group">
                        <label class="m-0">Name:</label>
                        <input type="text" id="name" name="name" value="{{ $Document->name }}" class="form-control" placeholder="Enter Name">
                    </div>

                    <div class="form-group">
                        <label class="m-0">Slug:</label>
                        <input type="text" id="slug" name="slug" value="{{ $Document->slug }}" class="form-control" placeholder="Enter Slug">
                    </div>
    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="m-0">Image:</label>
								@if(!empty($Document->image))
									<img src="{{ URL::to('public/uploads/Document/'.$Document->image) }}" class="movie-img" width="200"/>
								@endif
							</div>
			
							<div class="form-group">
								<input type="file" multiple="true" class="form-control" name="image" id="image" />
							</div>
						</div>
					</div>

                        
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="m-0">Document:</label>
								@if(!empty($Document->document))
                                    <a target="_blank" href="{{ URL::to('public/uploads/Document/'.$Document->document) }}">Click Here See Document</a>
								@endif
							</div>
			
							<div class="form-group">
								<input type="file" multiple="true" class="form-control" name="document" id="document" />
							</div>
						</div>
					</div>

                    <div class="form-group">
                        <label class="m-0">Category:</label>

                        <select id="document_category"  name="document_category[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                            @foreach($DocumentGenre as $Genre)
                                @if(in_array(@$Genre->id, @$category_Document))
                                    <option value="{{ $Genre->id }}" selected="true">{{ $Genre->name }}</option>
                                @else
                                    <option value="{{ $Genre->id }}">{{ $Genre->name }}</option>
                                @endif 
                            @endforeach
                        </select>

                    </div>

					<input type="hidden" name="id" id="id" value="{{ $Document->id }}" />
					<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    		</form>
		</div>

		<div class="modal-footer">
			<a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/document/genre') }}">Close</a>
			<button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
		</div>
    </div>
</div>
</div>

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>

<script>
    $(document).ready(function(){
    $('.js-example-basic-multiple').select2();
});
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