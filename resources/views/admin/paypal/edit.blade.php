@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/assets/admin/css/sweetalert.css' }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="iq-card">
<div class="admin-section-title">
    <h4 class="p-3">Paypal Edit</h4>
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



<div class="modal-body">
    	<form  accept-charset="UTF-8" action="{{ URL::to('admin/paypalplans/update') }}" method="post">
           <div class="row">
               <div class="col-md-6">
                        <div class="form-group">
                            <label>  Plans Name:</label>
                            <input type="text" id="name" name="plans_name" value="{{ $edit_plan->name }}" class="form-control" placeholder="Enter ">
                        </div>
                        
                            <div class="form-group">
		                        <label> Plan ID:</label>
		                        <input type="text" id="plans_id" name="plan_id" value="{{ $edit_plan->plan_id }}" class="form-control" placeholder="Plan ID">
                            </div> 
                        <div class="form-group">
                        <label>Video Quality:</label>
                            <input type="text" id="video_quality" name="video_quality"  value="{{ $edit_plan->video_quality }}" class="form-control" placeholder="Quality">
                        </div> 
                            
               </div>
               <div class="col-md-6">
                   <div class="form-group">
		                        <label> Price:</label>
		                        <input type="text" id="price" name="price" value="{{ $edit_plan->price }}" class="form-control" placeholder="Price">
                            </div>
                        <div class="form-group">
                          <label>Payment Type:</label><br>
                          One Time Payment : 
                            <input type="radio"  name="payment_type"  value="one_time" @if ($edit_plan->payment_type=='one_time') checked='checked' @endif>
                          Recurring : 
                            <input type="radio"  name="payment_type"  value="recurring"  @if ($edit_plan->payment_type=='recurring') checked='checked' @endif>
                          </div> 
                        <div class="form-group">

                          <label>Resolution :</label>
                <input type="text" id="resolution" name="resolution"  value="{{ $edit_plan->resolution }}" class="form-control" placeholder="Resolution">
            </div>  
            <div class="form-group">

            <label> Devices :</label>
            </div>
            @foreach($devices as $val)
            <div class="col-md-4 d-flex" style="width: 33%; float:left;">                                           
            <div>  <label  style="color:#000000!important;">{{ $val->devices_name }}</label></div>
                <label class="switch">
            <input class="form-check-input" type="checkbox" name="devices[]" value="{{ $val->id }}" {{ (in_array($val->id, $user_devices)) ? ' checked' : '' }}> 
                    <span class="slider round"></span>
                </label>
             </div>
                               
            @endForeach
            
               </div>


            <div>
            </div>
            
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
            
                     

                <input type="hidden" name="id" id="id" value="{{ $edit_plan->id }}" />

              <div class="modal-footer">
                <a type="button" class="btn btn-primary" data-dismiss="modal" href="{{ URL::to('admin/paypalplans') }}">Close</a>
                <input  type="submit" class="btn btn-primary" id="submit-update-cat" value="Update" />
            </div>
           
        </form>
</div>
             </div>
    </div>
</div>

    @stop


