<div class="modal-header">
    <h4 class="modal-title">Update Category</h4>
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	
</div>

<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/sliders/update') }}" method="post" enctype="multipart/form-data">
       
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        <label>Image:</label>
                        @if(!empty($categories[0]->slider))
                        <img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $categories[0]->slider }}" class="movie-img" width="200"/>
                        @endif
                        <p>Select the movie image (1280x720 px or 16:9 ratio):</p> 
                        <input type="file" multiple="true" class="form-control" name="slider" id="slider" />

                    </div>
        
                    <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                        <label>Status:</label>
                        <input type="radio" id="in_home" name="active" value="1" <?php if( $categories[0]->active == 1) { echo "checked";} ?>>Yes
                        <input type="radio" id="active" name="active" value="0" <?php if( $categories[0]->active == 0) { echo "checked";} ?>>No

                    </div>

        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-white" id="submit-update-cat">Update</button>
</div>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>