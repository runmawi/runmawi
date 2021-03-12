@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-6">
				<h3><i class="entypo-archive"></i> User Roles</h3>
			</div>
            <div class="col-md-6" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Create New Role</h4>
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/roles/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				       
				        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                        <label>Role:</label>

                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="Enter Role">
                        @if ($errors->has('name'))
                            <span class="text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

                    </div>

                   
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
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
					Organize the Categories below: 
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

				


            <table class="table table-bordered">
                <tr class="table-header">
                    <th>Role</th>
                    <th>Operation</th>
                    @foreach($roles as $role)
                    <tr>
                        <td valign="bottom"><p>{{ $role->name }}</p></td>
                        <td>
                            <div class="flex align-items-center list-user-action"><a href="{{ URL::to('admin/roles/edit/') }}/{{$role->id}}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit"><i class="ri-pencil-line"></i></a> <a href="{{ URL::to('admin/roles/delete/') }}/{{$role->id}}" class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete"><i
                                                class="ri-delete-bin-line"></i></a></div>
                          
                        </td>
                    </tr>
                    @endforeach
            </table>
                    
				
				</div>
		
			</div>
		
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