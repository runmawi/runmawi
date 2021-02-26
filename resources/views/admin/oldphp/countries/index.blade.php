@extends('admin.master')

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-archive"></i> Blocked Countries </h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-black"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Select a Country to Block</h4>
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/countries/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				     
                    <select class="selectpicker countrypicker form-control" name="country_name" data-live-search="true" data-default="United States" data-flag="true"></select>
                        
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
					Organize the Blocked Countries below: 
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

				     <table class="table table-bordered">
                        <tr class="table-header">
                            <th class="text-center">#ID</th>
                            <th class="text-center">Country Name</th>
                            <th class="text-center">Action</th>
                            <?php $i = 1; ?>
                            @foreach($countries as $country)
                            <tr>
                                <td valign="bottom" class="text-center">{{ $i }}</td>
                                <td valign="bottom" class="text-center">{{ $country->country_name }}</td>
                                <td class="text-center">
                                    <div class="actions">
                                        <a href="{{ URL::to('admin/sliders/delete/') }}/{{$country->id}}" class="btn btn-black  delete">Delete</a></div>

                                </td>
                            </tr>
                          <?php $i++; ?>
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
        <script src="<?= URL::to('/assets/admin/js/countrypicker.js');?>"></script>
	@stop

@stop