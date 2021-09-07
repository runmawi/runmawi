@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/assets/admin/css/sweetalert.css' }}">
@endsection
<style>
    #edit-form {
        margin: 3% !important;
    }

</style>
@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="iq-card">
<div class="admin-section-title" style="padding:20px;">
    <h4>Plan edit</h4>
    <hr>
       <!--  <div class="row">
            <div class="col-md-12">
                <h3><i class="entypo-archive"></i>  Room Topic </h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
        </div> -->
    </div>

<!--<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Update Plans</h3>
</div>-->


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif   



<div class="panel panel-default ">
  
    	<form  accept-charset="UTF-8" action="{{ URL::to('admin/plans/update') }}" method="post" id="edit-form">
             
           <div class="row">
                
               <div class="col-md-6">
                        <div class="form-group">
                            <label>Plans Name:</label>
                            <input type="text" id="name" name="plans_name" value="{{ $edit_plan[0]->plans_name }}" class="form-control" placeholder="Enter ">
                        </div>
                        
                            <div class="form-group">
		                        <label> Plan ID:</label>
		                        <input type="text" id="plans_id" name="plan_id" value="{{ $edit_plan[0]->plan_id }}" class="form-control" placeholder="Plan ID">
                            </div>
            
            
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
            
                          <div class="form-group">
                                <label>Days:</label>
                                <input type="text" id="days" name="days" value="{{ $edit_plan[0]->days }}" class="form-control" placeholder="Enter no.of Days">
                            </div>
                   <div class="form-group">
		                        <label>Payment Type:</label><br>
		                        One Time Payment : <input type="radio"  name="payment_type"  value="one_time" @if ($edit_plan[0]->payment_type=='one_time') checked='checked' @endif>
		                        Recurring : <input type="radio"  name="payment_type"  value="recurring"  @if ($edit_plan[0]->payment_type=='recurring') checked='checked' @endif>
		                    </div> 
                          
            
            
                       
                   </div>
               <div class="col-md-6">
                   
                <div class="form-group">
		                        <label>Billing Interval:</label>
		                        <input type="text" id="billing_interval" name="billing_interval" value="{{ $edit_plan[0]->billing_interval }}" class="form-control" placeholder="  etc .. Monthly , Yearly , 3 months ..">
		                    </div>  
                            <div class="form-group">
		                        <label>Billing Type:</label>
		                        <input type="text" id="type" name="type" value="{{ $edit_plan[0]->type }}" class="form-control" placeholder="Example .. Non Refundable">
		                    </div> 
                    <div class="form-group">
                            <label>Price(USD):</label>
                            <input type="text" id="slug" name="price" value="{{ $edit_plan[0]->price }}" class="form-control" placeholder="Enter Price">
                        </div>
           
                            
                   </div>
               </div>

                <input type="hidden" name="id" id="id" value="{{ $edit_plan[0]->id }}" />

              <div class="modal-footer">
                <a type="button" class="btn btn-danger" data-dismiss="modal" href="{{ URL::to('admin/plans') }}">Close</a>
                <input  type="submit" class="btn btn-primary" id="submit-update-cat" value="Update" />
            </div>
           
        </form>
</div>
             </div></div></div>
    @stop


