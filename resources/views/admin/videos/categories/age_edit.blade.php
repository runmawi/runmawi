@extends('admin.master')


@section('content')
<style>
    .form-control {
    background-color: var(--iq-body-bg);
    border: 1px solid transparent;
    height: 46px;
    position: relative;
    color: var(--iq-body-text);
    font-size: 16px;
    width: 100%;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}
</style>
<div id="content-page" class="content-page">
         <div class="container-fluid">
<div class="iq-card">
<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/age/update') }}" method="post" enctype="multipart/form-data">
       
         <div class="form-group ">

                        <label>AGE:</label>
                        <input type="text" id="age" name="age" value="{{ $categories[0]->age }}" class="form-control" placeholder="Enter Name">
                    </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

                        <label>Slug:</label>

                        <input type="text" id="slug" name="slug" value="{{ $categories[0]->slug }}" class="form-control" placeholder="Enter Slug">
                        @if ($errors->has('slug'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>
        
                    <div class="form-group {{ $errors->has('in_home') ? 'has-error' : '' }}">
                        <label>Status:</label>
                        <input type="radio" id="active" name="active" value="1" <?php if( $categories[0]->active == 1) { echo "checked";} ?>>Active
                        <input type="radio" id="active" name="active" value="0" <?php if( $categories[0]->active == 0) { echo "checked";} ?>> In Active

                    </div>

</div>

        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/videos/categories') }}">Close</a>
	<button type="button" class="btn btn-primary" id="submit-update-cat">Update</button>
</div>
    </div>
</div>
</div>
</div>

	@section('javascript')
<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>
             @stop

@stop