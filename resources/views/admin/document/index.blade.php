@extends('admin.master')


@section('content')

<div id="content-page" class="content-page">
         <div class="container-fluid">

<div class="iq-card">
    <h4><i class="entypo-archive"></i> Add New Document</h4>
	<div class="modal-body">
		<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/document/store') }}" method="post" enctype="multipart/form-data">
         			<div class="form-group">
                        <label class="m-0">Name:</label>
                        <input type="text" id="name" name="name"  class="form-control" placeholder="Enter Name">
                    </div>

                    <div class="form-group">
                        <label class="m-0">Slug:</label>
                        <input type="text" id="slug" name="slug"  class="form-control" placeholder="Enter Slug">
                    </div>
        
                    <div class="row">
						<div class="col-md-6">
                            <div class="form-group">
                                <label>Document:</label>
                                <input type="file" multiple="true" class="form-control" name="document" id="document" />
                            </div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
                            <div class="form-group">
                                <label>Image:</label>
                                <input type="file" multiple="true" class="form-control" name="image" id="image" />
                            </div>
						</div>
					</div>

                    <div >
                        <label class="m-0">Category:</label>
                        	<select id="document_category" name="document_category[]" style="width: 100%;" multiple="multiple" class="form-control js-example-basic-multiple">
								<!-- <option value="0">Select</option> -->
								@foreach($DocumentGenre as $Genre)
									<option value="{{ $Genre->id }}">{{ $Genre->name }}</option>
								@endforeach
                        	</select>
                    </div>
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