@extends('admin.master')

@section('css')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
</style>
@stop


@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">
<div id="admin-container">
	<!-- This is where -->

	<div class="admin-section-title">
		<h3><i class="entypo-credit-card"></i> Mobile Settings</h3> 
	</div>
	<div class="clear"></div>

	<form method="POST" action="{{ URL::to('admin/mobile_app/store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            

		<div class="row">

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title">Splash Screen</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                
				<div class="panel-body" style="display: block; background:#f1f1f1;"> 
                    <input type="submit" value="Save Settings" class="btn btn-black pull-right" />
					@if(!empty($mobile_settings->splash_image))
					<img src="{{ URL::to('/') . '/public/uploads/settings/' . $mobile_settings->splash_image }}" style="max-height:100px" />
					@endif
					<p>Upload Splash Screen:(960dp x 720dp)</p> 
					<input type="file" multiple="true" class="form-control" name="splash_image" id="splash_image" />

				</div> 
			</div>
		</div>

		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		
	</form>





	<div class="clear"></div>

	<div class="clear"></div>
    
    <div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-archive"></i> Sliders </h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-black"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>
	</div>
    
    <div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Slider</h4>
				</div>
				
                <div class="modal-body">
                    <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/mobile/sliders/store') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                                <label>Image:</label>
                                <input type="file" multiple="true" class="form-control" name="slider" id="slider" />

                            </div> 
                            <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                                <label>Target Link:</label>
                                <input type="text" multiple="true" class="form-control" name="link" id="link" />

                            </div>
                            <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                                <label>Status:</label>
                                <input type="radio" id="active" name="active" value="1">Active
                                <input type="radio" id="active" name="active" value="0">Deactive
                             </div>
                    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-black" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>
    
    <!-- Add New Modal -->
	<div class="modal fade" id="update-category">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>
    
    	<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">
                    <table class="table table-bordered">
                        <tr class="table-header">
                            <th class="text-center">Slider Image</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Operation</th>
                            @foreach($allCategories as $category)
                            <tr>
                                <td valign="bottom" class="text-center"><img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $category->slider }}" width="50" height="50"></td>
                                <td class="text-center"> <?php if( $category->active == 1 ) { echo "<span class='btn btn-success' value='Active'>Active</span>"; } else  { echo "<span class='btn btn-danger' value='Active'>Deactive</span>"; };?> </td>
                                <td class="text-center">
                                    <div class="actions"><a href="{{ URL::to('admin/mobile/sliders/edit/') }}/{{$category->id}}" class="btn btn-black edit">Edit</a> <a href="{{ URL::to('admin/mobile/sliders/delete/') }}/{{$category->id}}" class="btn btn-white delete">Delete</a></div>

                                </td>
                            </tr>
                            @endforeach
                    </table>

				
				</div>
		
			</div>
                </div>
    </div>
    
    
    
    <input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />  

</div>

	@section('javascript')

		<script src="<?= URL::to('/assets/admin/js/jquery.nestable.js');?>"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			$('#nestable').nestable({ maxDepth: 3 });

			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-category').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-category .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this category?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
    			$('.category-panel').addClass('reloading');
    			$.post('<?= URL::to('admin/videos/categories/order');?>', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val()  }, function(data){
    				console.log(data);
    				$('.category-panel').removeClass('reloading');
    			});

			});


		});
		</script>
    
<script src="{{ URL::to('/assets/admin/js/bootstrap-switch.min.js') }}"></script>
@stop

@stop