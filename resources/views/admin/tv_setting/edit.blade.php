@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">
<div class="modal-body">
	<form id="update-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/tv-settings/update') }}" method="post">
        <label for="name">TV Settings Update </label>
        <input name="name" id="name" placeholder="Name" class="form-control" value="{{ $TVSetting->name }}" /><br />
        <div class="col-sm-6">

          <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                            style="width: ;">
                                            <div><label class="mt-1">Enable Setting</label></div>

                                            <div class="mt-1 d-flex align-items-center justify-content-around">
                                                <div class="mr-2">OFF</div>
                                                <label class="switch mt-2">
                                                    <input type="checkbox" name="enable_id"
                                                        @if ($TVSetting->enable_id == 1) {{ "checked='checked'" }} @else {{ '' }} @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                                <div class="ml-2">ON</div>
                                            </div>

                                        </div>
                                <br>
                                <div class="col-sm-12">
                                    <div class="mt-1 d-flex align-items-center justify-content-around">

                                        <label class="m-0">Page Enable:</label>
                                        <select class="form-control" id="page_id" name="page_id">
                                            <option value="">Choose Age</option>
                                            @foreach($Pages as $key => $page)
                                                <option value="{{ $page->id }}"  {{  ($TVSetting->page_id == $page->id ) ? 'selected' : '' }} > {{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
        <input type="hidden" name="id" id="id" value="{{ $TVSetting->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	
	<button type="button" class="btn btn-primary" id="submit-update-menu">Update</button>
    <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/tv-settings/index') }}">Close</a>
</div>

    </div></div>
</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />
<script>
	$(document).ready(function(){
		$('#submit-update-menu').click(function(){
			$('#update-menu-form').submit();
		});

		$('#update-menu-form .menu-dropdown-radio').change(function(){
			changeNewMenuDropdownRadio($(this));
		});

	});

	function changeNewMenuDropdownRadio(object){
		if($(object).val() == 'none'){
			$('#update-menu-form #url').removeAttr('disabled');
		} else {
			$('#update-menu-form #url').attr('disabled', 'disabled');
		}
	}
</script>

	<?php if(isset($_GET['menu_first_level'])): ?>
		<input type="hidden" id="menu_first_level" value="1" />
	<?php endif; ?>

	@section('javascript')

		<script src="{{ URL::to ('/assets/admin/js/jquery.nestable.js') }}"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			if($('#menu_first_level').val() == 1){
				console.log('yup!');
				toastr.warning('Should only be added as a top level menu item!', "Video Or Post Category Menu Item", opts);
			}

			$('#nestable').nestable({ maxDepth: 3 });

			$('#add-new .menu-dropdown-radio').change(function(){
				changeNewMenuDropdownRadio($(this));
			});

			// Add New Menu
			$('#submit-new-menu').click(function(){
				$('#new-menu-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-menu').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-menu .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this menu item?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
				if($('.video_post').parents('.dd-list').length > 1){
					console.log('show error');
					window.location = '/admin/menu?menu_first_level=true';
				} else {
				
	    			$('.menu-panel').addClass('reloading');
	    			$.post('/admin/menu/order', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val() }, function(data){
	    				console.log(data);
	    				$('.menu-panel').removeClass('reloading');
	    			});

	    		}

			});


		});

		function changeNewMenuDropdownRadio(object){
			if($(object).val() == 'none'){
				$('#new-menu-form #url').removeAttr('disabled');
			} else {
				$('#new-menu-form #url').attr('disabled', 'disabled');
			}
		}

		</script>

		{{-- validate --}}

		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
		<script>
			$('form[id="update-menu-form"]').validate({
				rules: {
					name : 'required',
					url : 'required',
					},
				submitHandler: function(form) {
					form.submit(); }
				});
		</script>

	@stop
@stop

