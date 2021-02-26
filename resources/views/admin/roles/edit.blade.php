<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Edit  Role</h4>
</div>

<div class="modal-body">
	
    <form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/roles/update/') }}" method="post" enctype="multipart/form-data">
       
         <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

            <label>Role:</label>

            <input type="text" id="name" name="name" value="{{ $roles->name }}" class="form-control" placeholder="Enter Role">
                        @if ($errors->has('name'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

        </div>

        <input type="hidden" name="id" id="id" value="{{ $roles->id }}" />
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