@extends('admin.master')

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-archive"></i> Manage Permissions</h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-black"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Create New Permission</h4>
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/permissions/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				       
				        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                            <label>Pages:</label>

                            <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter Slug">
                            @if ($errors->has('name'))
                                <span class="text-red" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                      
                        </div> 
                        
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                            <label>Slug:</label>
                            
                            <input type="text" id="slug" name="slug" value="" class="form-control" placeholder="Enter Slug">
                                @if ($errors->has('slug'))
                                    <span class="text-red" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                            @endif
                      
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

	<div class="clear"></div>
		
		
		<div class="panel panel-primary category-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					Organize the Permissions below: 
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

				


            <table class="table table-bordered">
                <tr class="table-header">
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Operation</th>
                    @foreach($permissions as $permission)
                    <tr>
                        <td valign="bottom"><p>{{ $permission->name }}</p></td>
                        <td valign="bottom"><p>{{ $permission->slug }}</p></td>
                        <td>
                            <div class="actions"><a href="{{ URL::to('admin/permissions/edit/') }}/{{$permission->id}}" class="btn btn-black edit">Edit</a> <a href="{{ URL::to('admin/permissions/delete/') }}/{{$permission->id}}" class="btn btn-white delete">Delete</a></div>
                          
                        </td>
                    </tr> 
                
                  
                    @endforeach
            </table>
                    
				
				</div>
		
			</div>
		
		</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />


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

	@stop

@stop