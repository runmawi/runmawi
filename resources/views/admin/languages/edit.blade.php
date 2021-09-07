@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">
<!--<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Update Language</h4>
</div>-->

<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/languages/update') }}" method="post" enctype="multipart/form-data">
       <h5>Language add</h5>
                 
        
                    <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                        <label>Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php if( isset($categories[0]->name ) ) { echo $categories[0]->name;} ?>" >

                    </div>

        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/admin-languages') }}">Close</a>
	<button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
</div>
             </div>
    </div></div>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>