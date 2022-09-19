@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">
	<!--<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Update Menu Item</h4>
</div>-->

<div class="modal-body">
	<form id="update-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/menu/update') }}" method="post">
        <label for="name">Menu Item Name</label>
        <input name="name" id="name" placeholder="Menu Item Name" class="form-control" value="{{ $menu->name }}" /><br />
		
		<label for="name">Menu Item URL</label>
		<select name="select_url" id="select_url" class="form-control">
			<option value="">Select URL</option>
			<option value="add_Site_url" @if($menu->select_url == "add_Site_url"){{ 'selected' }}@endif >Site URL</option>
			<option value="add_Custom_url"@if($menu->select_url == "add_Custom_url"){{ 'selected' }}@endif>Custom URL</option>
		</select><br />
		 <div id="div_Site">
			<label for="url">Menu Item URL (ex. /site/url)</label>
			<input name="url" id="url" placeholder="URL Slug" class="form-control" value="{{ $menu->url }}" /> 
		</div>
		 <div id="div_Custom">
			<label for="url">Custom URL (ex. full url)</label>
			<input name="custom_url" id="custom_url" placeholder="Custom URL" class="form-control" value="{{ $menu->custom_url }}" /><br />
		</div>
             <label for="categories" style="font-size:12px;">Categories (Need to Display video categories in this Menu) ? </label><br>
             <input type="radio" name="in_menu" value="none" <?php if( $menu->in_menu == "none") { echo "checked";} ?>/>  <label class="ml-1">None</label>
             <input type="radio" name="in_menu" value="video" <?php if( $menu->in_menu == "video") { echo "checked";} ?> /><label class="ml-1">Video Categories</label>
			 <input type="radio" name="in_menu" value="live" <?php if( $menu->in_menu == "live") { echo "checked";} ?>/><label class="ml-1"> Live Categories</label>
			 <input type="radio" name="in_menu" value="tv_show" <?php if( $menu->in_menu == "tv_show") { echo "checked";} ?>/><label class="ml-1"> Tv Shows</label>
        
        <input type="hidden" name="id" id="id" value="{{ $menu->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	
	<button type="button" class="btn btn-primary" id="submit-update-menu">Update</button>
    <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/menu') }}">Close</a>
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

				$(document).ready(function(){
				
				$('#div_Site').hide();
				$('#div_Custom').hide();
				if($('#select_url').val() == 'add_Site_url'){
						$('#div_Custom').hide();
						$('#div_Site').show();
					}else if($('#select_url').val() == 'add_Custom_url'){
						$('#div_Site').hide();
						$('#div_Custom').show();
					}

				$('#select_url').change(function(){
					if($('#select_url').val() == 'add_Site_url'){
						$('#div_Custom').hide();
						$('#div_Site').show();
					}else if($('#select_url').val() == 'add_Custom_url'){
						$('#div_Site').hide();
						$('#div_Custom').show();
					}
				})
			})

		</script>

	@stop
@stop

