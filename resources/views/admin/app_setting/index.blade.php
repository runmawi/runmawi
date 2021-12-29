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
				<h4><i class="entypo-archive"></i> APP Setting </h4>
			</div>
            <div class="col-md-8" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add APP Settings</a></div>
            <hr>
		</div>
	

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					
					<h4 class="modal-title">Add APP Settings </h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="clear"></div>
				<div class="modal-body">
                <form method="POST" action="{{ URL::to('admin/app_settings/store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row mt-4">
			
			<div class="col-md-12">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Android URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="android_url" id="android_url" value="@if(!empty($revenue_settings->android_url)){{ $revenue_settings->android_url }}@endif"  />
					</div> 
				</div>
			</div>

			<div class="col-md-12">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>IOS URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="ios_url" id="ios_url" value="@if(!empty($revenue_settings->ios_url)){{ $revenue_settings->ios_url }}@endif"  />
					</div> 
				</div>
			</div>
			<div class="col-md-12 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Status</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
					<label class="switch">
					<input type="checkbox"  name="status"  id="status">
							<span class="slider round"></span>
						</label>
					</div> 
				</div>
			</div>
			<!-- <div class="col-md-6 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>User Commission in % </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
                    <input type="text" class="form-control" name="vod_user_commission" id="vod_user_commission" value="@if(!empty($revenue_settings->vod_user_commission)){{ $revenue_settings->vod_user_commission }}@endif" />
					</div> 
				</div>
			</div> -->
			
		</div>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<div class="panel-body mt-3" style="display: flex;
            justify-content: flex-end;">
        <input type="submit" value="Update APP Settings" class="btn btn-primary " />
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
					<!-- <p class="p1">Organize the sliders below: </p> -->
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list with-margins">


            <table class="table table-bordered" id="slidertbl">
                <tr class="table-header">
				<th class="text-center">ID</th>
                    <th class="text-center">Android URL</th>
                    <th class="text-center">IOS URL</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
                    @foreach($app_settings as $app)
                    <tr class="dd" id="{{ $app->id }}">
					<td valign="bottom" class="text-center">{{ $app->id }}</td>
                        <td valign="bottom" class="text-center">{{ $app->android_url }}</td>
                        <td valign="bottom" class="text-center">{{ $app->ios_url }}</td>
						<td>@if ($app->status == 1)
						<p class="font-weight-bold text-success">Approved</p>
						@elseif ($app->status == 0)
						<p class="font-weight-bold text-danger">Pending</p>
						@else
						<button class="btn btn-success status_change" value="on" data-id="{{$app->id}}">Approve</button>
						<button class="btn btn-danger status_change" value="off" data-id="{{$app->id}}">Pending</button>
						@endif</td>
                        <td class="text-center">
                        <div class="align-items-center list-user-action"><a href="{{ URL::to('admin/app_settings/edit/') }}/{{$app->id}}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Edit"><i class="ri-pencil-line"></i></a> <a href="{{ URL::to('admin/app_settings/delete/') }}/{{$app->id}}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                        onclick="return confirm('Are you sure?')"   data-original-title="Delete"><i class="ri-delete-bin-line"></i></a></div>

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


