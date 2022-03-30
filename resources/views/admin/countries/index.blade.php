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
    .p1{
        font-size: 12px;
    }
</style>
@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
	<div class="admin-section-title">
          <div class="">
		<div class="row">
			<div class="col-md-4">
				<h4><i class="entypo-archive"></i> Blocked Countries </h4>
			</div>
            <div class="col-md-8" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title">Select a Country to Block</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/countries/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				     
                    <select class="selectpicker countrypicker form-control" name="country_name" data-live-search="true" data-default="United States" data-flag="true"></select>
                        
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
					<p class="p1">Organize the Blocked Countries below: </p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins p-0">

				     <table class="table table-bordered iq-card">
                        <tr class="table-header r1">
                            <th class="text-center"><label>#ID</label></th>
                            <th class="text-center"><label>Country Name</label></th>
                            <th class="text-center"><label>Action</label></th>
                            <?php $i = 1; ?>
                            @foreach($countries as $country)
                            <tr>
                                <td valign="bottom" class="text-center">{{ $i }}</td>
                                <td valign="bottom" class="text-center">{{ $country->country_name }}</td>
                                <td class="text-center">
                                    <div class="align-items-center list-user-action">
                                        <a href="{{ URL::to('admin/countries/delete/') }}/{{$country->id}}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a></div>

                                </td>
                            </tr>
                          <?php $i++; ?>
                            @endforeach
                </table>


                    
				
				</div>
		
			</div>
		
		</div>
    </div></div>

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
        <script src="<?= URL::to('/assets/admin/js/countrypicker.js');?>"></script>
	@stop

@stop