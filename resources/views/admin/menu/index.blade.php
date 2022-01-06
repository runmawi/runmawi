@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
</style>
@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
	<div class="admin-section-title">
        <div class="iq-card">
		<div class="row">
			<div class="col-md-4">
				<h4><i class="entypo-list"></i> Menu Items</h4>
			</div>
            <div class="col-md-8" align="right">
                <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
            
		</div>
	
<hr>
	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif    
    
                
				<div class="modal-header">
                    <h4 class="modal-title">New Menu Item</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body p-3">
					<form id="new-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/menu/store') }}" method="post">
				        <label for="name">Enter the new menu item name below</label>
				        <input name="name" id="name" placeholder="Menu Item Name"  required class="form-control" value="" /><br />
				        <label for="url">Menu Item URL (ex. /site/url)</label>
				        <input name="url" id="url" placeholder="URL" class="form-control" required value="" /><br />
				   
				        <div class="clear"></div>
                        
                        <label for="categories">Categories (Need to Display video categories in this Menu) ? </label><br>
                     None :<input type="radio" name="in_menu" value="none" />
                     Video Categories : <input type="radio" name="in_menu" value="video"  />
				      
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submit-new-menu">Save changes</button>
				        </div>
                        
				    </form>
				</div>
				
				
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-menu">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
		
		
		<div class="panel panel-primary menu-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<p>Organize the Menu Items below: (max of 3 levels)</p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body" style="color:#000000;">
		
				<div id="nestable" class="nested-list dd with-margins">

					<ol class="dd-list">

					<?php $previous_item = array(); ?>
					<?php $first_parent_id = 0; ?>
					<?php $second_parent_id = 0; ?>
					<?php $depth = 0; ?>
					@foreach($menu as $menu_item)

						@if( (isset($previous_item->id) && $menu_item->parent_id == $previous_item->parent_id) || $menu_item->parent_id == NULL )
							<li>
						@endif

						@if( (isset($previous_item->parent_id) && $previous_item->parent_id !== $menu_item->parent_id) && $previous_item->id != $menu_item->parent_id )
							@if($depth == 2)
								<!--</li></ol>-->
								<?php $depth -= 1; ?>
							@endif
							@if($depth == 1 && $menu_item->parent_id == $first_parent_id)
								</li></ol>
								<?php $depth -= 1; ?>
							@endif
							
						@endif

						@if(isset($previous_item->id) && $menu_item->parent_id == $previous_item->id && $menu_item->parent_id !== $previous_item->parent_id )
							<?php if($first_parent_id != 0):
								$first_parent_id = $menu_item->parent_id;
							else:
								$second_parent_id = $menu_item->parent_id;
							endif; ?>
                    <div class="d-flex">
							<ol class="dd-list">
							<?php $depth += 1; ?>
						@endif

                                <div class="d-flex justify-content-between" style="width:30%;">
							<div class="dd-handle mt-3">{{ $menu_item->name}}</div>
							<div class=" align-items-center list-user-action mt-2"><a href="{{ URL::to('/admin/menu/edit/') }}/{{ $menu_item->id }}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit"><i class="ri-pencil-line"></i></a> <a href="{{ URL::to('/admin/menu/delete/') }}/{{ $menu_item->id }}"  class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete"><i class="ri-delete-bin-line"></i></a></div>
</div>

						<?php $previous_item = $menu_item; ?>

					@endforeach
						
						

					</ol>
						</div>
				</div>
		
			</div>
		
		</div>
    </div></div>
    </div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

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
			$('form[id="new-menu-form"]').validate({
				rules: {
					name : 'required',
					url : 'required',
				},
				submitHandler: function(form) {
				form.submit();
				}
			});

</script>

	@stop

@stop