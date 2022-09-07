@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">
                	<div class="modal-header">
                    <h4 class="modal-title">Update Video Schedule</h4>
                </div>
<div class="modal-body">
	<form id="update-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/video-schedule/update') }}" method="post">
        <label for="name">Name</label>
        <input name="name" id="name" placeholder="Name" class="form-control" value="{{ $schedule->name }}" /><br />
         <label for="slug">Description </label>
         <input name="description" id="description" placeholder="Description" class="form-control" value="{{ $schedule->description }}" /> 

        <input type="hidden" name="id" id="id" value="{{ $schedule->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	
	<button type="button" class="btn btn-primary" id="submit-update-menu">Update</button>
    <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/video-schedule') }}">Close</a>
</div>

    </div></div>
</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	@section('javascript')

    <script>
	$(document).ready(function(){
		$('#submit-update-menu').click(function(){
			$('#update-menu-form').submit();
		});

	});
    </script>

	@stop
@stop

