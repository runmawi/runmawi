@extends('admin.master')

@section('content')
<style type="text/css">
    table th, table td
    {
        width: 100px;
        padding: 5px;
        border: 1px solid #ccc;
    }
    .selected
    {
        background-color: #666;
        color: #fff;
    }
</style>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />
<div id="content-page" class="content-page">
         <div class="container-fluid">

	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-4">
				<h4><i class="entypo-archive"></i> Sliders </h4>
			</div>
            <div class="col-md-8" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
            <hr>
		</div>
	

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					
					<h4 class="modal-title">New Slider</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/sliders/store') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				      

                    <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                        <label>Selece the Slider Image (1280x720 px or 16:9 ratio):</label>
                        <input type="file" multiple="true" class="form-control" name="slider" id="slider" />
                    </div> 
                        
                    <div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                        <label>Target Link:</label>
                        <input type="text" class="form-control" name="link" id="link" />

                    </div>
					<div class="form-group {{ $errors->has('slider') ? 'has-error' : '' }}">
                        <label>Trailer Link:</label>
                        <input type="text" class="form-control" name="trailer_link" id="trailer_link" />

                    </div>

                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label>Title:</label>
                        <input type="text" class="form-control" name="title" id="title" />

                    </div>

                    <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                        <label>Status:</label>
                        <input type="radio" id="active" name="active" value="1">Active
                        <input type="radio" id="active" name="active" value="0">Deactive
                     </div>
                        
                        <div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="submit-new-cat">Save changes</button>
				</div>


				    </form>
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
					<p class="p1">Organize the sliders below: </p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list with-margins">

				


            <table class="table table-bordered" id="slidertbl">
                <tr class="table-header">
                    <th class="text-center">Slider Title</th>
                    <th class="text-center">Slider Image</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Operation</th>
                </tr>
                    @foreach($allCategories as $category)
                    <tr class="dd" id="{{ $category->id }}">
                        <td valign="bottom" class="text-center">{{ $category->title }}</td>
                         <td valign="bottom" class="text-center"> <img src="{{ URL::to('/') . '/public/uploads/videocategory/' . $category->slider }}" width="50" height="50"></td>

                        <td class="text-center"> <?php if( $category->active == 1 ) { echo "<span class='btn btn-success' value='Active'>Active</span>"; } else  { echo "<span class='btn btn-danger' value='Active'>Deactive</span>"; };?> </td>
                        <td class="text-center">
                            <div class="align-items-center list-user-action"><a href="{{ URL::to('admin/sliders/edit/') }}/{{$category->id}}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit"><i class="ri-pencil-line"></i></a> <a href="{{ URL::to('admin/sliders/delete/') }}/{{$category->id}}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete"><i class="ri-delete-bin-line"></i></a></div>
                           
                        </td>
                    </tr>
                    @endforeach
            </table>
                    
				
				</div>
		
			</div>
		
		</div>
    </div></div>
	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />
</div>
	@section('javascript')


		<script type="text/javascript">

		jQuery(document).ready(function($){


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


		});
		</script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js"></script>
		<script type="text/javascript">
			$(function () {
				$("#slidertbl").sortable({
					items: 'tr:not(tr:first-child)',
					cursor: 'pointer',
					axis: 'y',
					dropOnEmpty: false,
					start: function (e, ui) {
						ui.item.addClass("selected");
					},
					stop: function (e, ui) {
						ui.item.removeClass("selected");
						var selectedData = new Array();
						$(this).find("tr").each(function (index) {
							if (index > 0) {
								$(this).find("td").eq(2).html(index);
								selectedData.push($(this).attr("id"));
							}
						});
						updateOrder(selectedData)
					}
				});
			});

			function updateOrder(data) {
				
				$.ajax({
					url:'<?= URL::to('admin/slider_order');?>',
					type:'post',
					data:{position:data, _token : $('#_token').val()},
					success:function(){
						alert('Position changed successfully.');
						location.reload();
					}
				})
			}
		</script>
	@stop

@stop