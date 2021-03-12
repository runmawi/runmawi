@extends('admin.master')
<div id="content-page" class="content-page">
         <div class="container-fluid">
<!--<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Edit  Role</h4>
</div>-->
<div class="iq-card">
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
	<a type="button" class="btn btn-primary" data-dismiss="modal" href="{{ URL::to('admin/roles') }}">Close</a>
	<button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
    </div></div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>

 