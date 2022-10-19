@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">
                	<div class="modal-header">
                    <h4 class="modal-title">Update Video Schedule</h4>
                </div>
<div class="modal-body">
	<form id="update-menu-form" accept-charset="UTF-8" enctype="multipart/form-data" action="{{ URL::to('admin/video-schedule/update') }}" method="post">
        <label for="name">Name</label>
        <input name="name" id="name" placeholder="Name" class="form-control" value="{{ $schedule->name }}" /><br />
        <label for="slug">Description </label>
        <input name="description" id="description" placeholder="Description" class="form-control" value="{{ $schedule->description }}" /> <br />
        <div style="margin-left: -9%;">
            <div class="mt-1 d-flex align-items-center justify-content-around">
                <div><label class="mt-1"> Display on Home page </label></div>
                    <div class="mr-2">OFF</div>
                        <label class="switch mt-2">
                        <input name="in_home" type="checkbox"  @if (@$schedule->in_home == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                        <span class="slider round"></span>
                        </label>
                    <div class="ml-2">ON</div>
            </div>
        </div><br>
        <label class="m-0">Home Thumbnail: <small>(9:16 Ratio or 1080X1920px)</small></label>
        <div class="row">
            <div class="col-sm-6 p-0">
            <input type="file" class="form-group" name="image"  id="image"  >
            </div>
            <div class="col-sm-3 p-0">
            <img src="{{ $schedule->image }}" class="video-img w-100 mt-1" />
            </div>
        </div>
    <br>
        <div class="row">
            <div class="col-sm-6 p-0">
            <label class="m-0">Player Thumbnail: <small>(16:9 Ratio or 1280X720px)</small></label>
            <input type="file" class="form-group" name="player_image"  id="player_image"  >

            </div>
            <div class="col-sm-3 p-0">
            <img src="{{ $schedule->player_image }}" class="video-img w-100 mt-1" />
            </div>
        </div>


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

