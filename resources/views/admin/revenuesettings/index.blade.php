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
     .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />
<div id="content-page" class="content-page">
      <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
    <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
    <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
    <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
   <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
   <a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>

    <div class="mt-4">
                    <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>

    <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
     <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
    <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
    <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
 
         <div class="container-fluid mt-5">

	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-4">
				<h4><i class="entypo-archive"></i> Revenue Setting </h4>
			</div>
            <div class="col-md-8" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Currency</a></div>
            <hr>
		</div>
	

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					
					<h4 class="modal-title">Add Revenue </h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				
				<div class="modal-body">
                <form method="POST" action="{{ URL::to('admin/revenue_settings/store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		<div class="row mt-4">
			
			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Admin Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="admin_commission" id="admin_commission" value="@if(!empty($revenue_settings->admin_commission)){{ $revenue_settings->admin_commission }}@endif"  />
					</div> 
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>User Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="user_commission" id="user_commission" value="@if(!empty($revenue_settings->user_commission)){{ $revenue_settings->user_commission }}@endif"  />
					</div> 
				</div>
			</div>
			<div class="col-md-6 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Admin Commission in %</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<input type="text" class="form-control" name="vod_admin_commission" id="vod_admin_commission" value="@if(!empty($revenue_settings->vod_admin_commission)){{ $revenue_settings->vod_admin_commission }}@endif" />
					</div> 
				</div>
			</div>
			<div class="col-md-6 mt-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>User Commission in % </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
                    <input type="text" class="form-control" name="vod_user_commission" id="vod_user_commission" value="@if(!empty($revenue_settings->vod_user_commission)){{ $revenue_settings->vod_user_commission }}@endif" />
					</div> 
				</div>
			</div>
			
		</div>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<div class="panel-body mt-3" style="display: flex;
            justify-content: flex-end;">
        <input type="submit" value="UpdateRevenue Settings" class="btn btn-primary " />
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
				<th class="text-center">ID</th>
                    <th class="text-center">Admin Commission</th>
                    <th class="text-center">User Commission</th>
                    <th class="text-center">VOD Admin Commission</th>
                    <th class="text-center">VOD User Commission</th>
                    <th class="text-center">Action</th>
                </tr>
                    @foreach($revenue_settings as $revenue)
                    <tr class="dd" id="{{ $revenue->id }}">
					<td valign="bottom" class="text-center">{{ $revenue->id }}</td>
                        <td valign="bottom" class="text-center">{{ $revenue->admin_commission }}</td>
                        <td valign="bottom" class="text-center">{{ $revenue->user_commission }}</td>
                        <td valign="bottom" class="text-center">{{ $revenue->vod_admin_commission }}</td>
                        <td valign="bottom" class="text-center">{{ $revenue->vod_user_commission }}</td>
                        <td class="text-center">
                        <div class="align-items-center list-user-action"><a href="{{ URL::to('admin/revenue_settings/edit/') }}/{{$revenue->id}}"  class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Edit"><i class="ri-pencil-line"></i></a> <a href="{{ URL::to('admin/revenue_settings/delete/') }}/{{$revenue->id}}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
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


