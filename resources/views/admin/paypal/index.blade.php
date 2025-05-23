@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
			background-color: #FFF;
			color: #000;
			}
	.make-switch{
		z-index:2;
	}
        .admin-container{
            padding: 10px;
        }
        .iq-card{
            padding: 15px!important; 
        }
     .p1{
        font-size: 12px!important;
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
				<h3><i class="entypo-archive"></i> Paypal Plans </h3>
			</div>
            <div class="col-md-6" align="right"><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	


	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title">New Plan</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/paypalplans/store') }}" method="post">
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
		                        <label>Payment Type:</label><br>
		                        One Time Payment : <input type="radio"  name="payment_type"  value="one_time" checked='checked'>
		                        Recurring : <input type="radio"  name="payment_type"  value="recurring">
		                    </div> 
                        
                        
                            <div class="form-group">
		                         <label> Price (USD):</label>
		                         <input type="text" id="price" name="price" value="" class="form-control" placeholder="Price">
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
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>
			<div class="panel panel-primary category-panel" data-collapsed="0">
		</div>
			<div class="panel-body mt-3">
		
				<div id="nestable" class="nested-list dd with-margins">

					 <table class="table plan_table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Plan Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($plans as $k=> $plan )

							<tr>
                               <td>{{ $k+1 }}</td>
                               <td>{{ $plan->name }}</td>
                               <td class="list-user-action"><a href="{{ URL::to('/') }}/admin/paypalplans/edit/{{ $plan->id }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="ri-pencil-line"></i></a> <a  onclick="return confirm('Are you sure?')" href="{{ URL::to('/')}}/admin/paypalplans/delete/{{ $plan->id }}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line"></i></a></td>
                           </tr>

							@endforeach
						</tbody>

					</table>
						
				</div>
		
			</div>
    </div>
</div>

    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script type="text/javascript">

		jQuery(document).ready(function($){


			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});
		});
	</script>

	@stop