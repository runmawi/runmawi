<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Update Language</h4>
</div>

<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/languagestrans/update') }}" method="post" enctype="multipart/form-data">
       
                 
        
                    <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                        <label>Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php if( isset($categories[0]->name ) ) { echo $categories[0]->name;} ?>" >

                    </div>

        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-black" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-white" id="submit-update-cat">Update</button>
</div>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>