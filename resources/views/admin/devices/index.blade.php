@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 25px;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

@endsection

@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">

<div class="admin-section-title">
     <div class="iq-card">
		<div class="row">
			<div class="col-md-6">
				<h4><i class="entypo-archive"></i> Devices </h4>
			</div>
            <div class="col-md-6" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	


	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    	<h4 class="modal-title">New Devices</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/devices/store') }}" method="post">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />

						    <div class="form-group">

		                        <label> Devices Name:</label>

		                        <input type="text" id="devices_name" name="devices_name" value="" class="form-control" placeholder="Enter Devices Name">
                            </div>

				    </form>
				</div>
				
				<div class="modal-footer">
					
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
			<div class="panel panel-primary category-panel" data-collapsed="0">
		</div>
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins mt-4">

					 <ol id="tree1" class="dd-list">

                        @foreach($devices as $val )

                            <li class="dd-item">
                                <div class="d-flex justify-content-between" style="width:30%;">
                               <div class="dd-handle"> <label>{{ $val->devices_name }}</label> </div>
                               <div class="align-items-center list-user-action"><a href="{{ URL::to('/') }}/admin/devices/edit/{{ $val->id }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a> <a href="{{ URL::to('/')}}/admin/devices/delete/{{ $val->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a></div></div>
                            </li>

                        @endforeach

                    </ol>
						
				</div>
		
			</div>
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

	<script type="text/javascript">

		jQuery(document).ready(function($){


			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});
		});
		
			// validate
			$('form[id="new-cat-form"]').validate({
			rules: {
                devices_name : 'required',
				},
			submitHandler: function(form) {
				form.submit(); }
			});

	</script>
@stop