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
    th{
        color:#000000;
    }
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">


<div class="admin-section-title">
    	<div class="">

		<div class="row">
			<div class="col-md-6">
				<h4><i class="entypo-archive"></i>  Plans </h4>
                
			</div>
            <div class="col-md-6" align="right">
            <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
            
		</div>
	


	<!-- Add New Modal -->
            <hr>
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title">New Plan</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/plans/store') }}" method="post">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />

						    <div class="form-group">
		                        <label> Plan Name:</label>
		                        <input type="text" id="slug" name="plans_name" value="" class="form-control" placeholder="Plan Name">
                            </div>
                        
                            <div class="form-group">
		                        <label> Plan ID:</label>
		                        <input type="text" id="plan_id" name="plan_id" value="" class="form-control" placeholder="Plan ID">
                            </div>

		                    <div class="form-group">
		                        <label>Days:</label>
		                        <input type="text" id="slug" name="days" value="" class="form-control" placeholder="Enter no.of days">
		                    </div>  
                        
                           <div class="form-group">
		                        <label>Billing Interval:</label>
		                        <input type="text" id="billing_interval" name="billing_interval" value="" class="form-control" placeholder="  etc .. Monthly , Yearly , 3 months ..">
		                    </div>  
                        
                            <div class="form-group">
		                        <label>Billing Type:</label>
		                        <input type="text" id="type" name="type" value="" class="form-control" placeholder="Example .. Non Refundable">
		                    </div>  
                        
                            <div class="form-group">
		                        <label>Payment Type:</label><br>
		                        One Time Payment : <input type="radio"  name="payment_type"  value="one_time" checked='checked'>
		                        Recurring : <input type="radio"  name="payment_type"  value="recurring">
		                    </div> 
                        
                         <div class="form-group">
		                        <label>Price(USD):</label>
		                        <input type="text" id="slug" name="price" value="" class="form-control" placeholder="Enter Price">
		                    </div>
							<div class="form-group">
		                        <label>Video Quality:</label>
		                        <input type="text" id="video_quality" name="video_quality" value="" class="form-control" placeholder="Quality">
		                    </div>  
							<div class="form-group">
		                        <label>Resolution :</label>
		                        <input type="text" id="resolution" name="resolution" value="" class="form-control" placeholder="Resolution">
		                    </div>  
							<div>
							<label> Devices :</label>
							</div>
						
                               @foreach($devices as $val)
							   <div class="col-md-4 d-flex" style="width: 33%; float:left;" >
						<label> {{ $val->devices_name }}</label>
						<label class="switch">
									<input type="checkbox"  name="devices[]"  value="{{ $val->id }}">
							<span class="slider round"></span>
						</label>
                               </div>
                               @endForeach

				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>
			<div class="panel panel-primary category-panel" data-collapsed="0">
		</div>
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">
					<table class="table-bordered iq-card text-center" id="categorytbl" style="width:100%;padding:10px;">
						<thead>
							<tr class="text-center r1">
								<th>Plan Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($plans as $plan )

							<tr class="text-center">

								<td><label> {{ $plan->plans_name }}</label> </td>
								<td class="align-items-center list-user-action"><a href="{{ URL::to('/') }}/admin/plans/edit/{{ $plan->id }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="ri-pencil-line"></i></a> <a href="{{ URL::to('/')}}/admin/plans/delete/{{ $plan->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line"></i></a></td>
							</tr>

							@endforeach
						</tbody>

					</table>
				</div>
		
			</div>
    </div>
</div>

</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

	<script type="text/javascript">

		jQuery(document).ready(function($){


			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});
		});
	</script>

	@stop