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
@section('css')
	<style type="text/css">
	.make-switch{
		z-index:2;
	}
        
      
	</style>

@stop

@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div id="admin-container">
	
	<div class="admin-section-title">
		<h4><i class="entypo-globe"></i> Payment Settings</h4> 
        <hr>
	</div>
	<div class="clear"></div>

	
    <p><h3>Stripe Payment</h3></p>

	<form method="POST" action="{{ URL::to('admin/payment_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
	<div class="row">
			<!-- <div class="col-md-12"> -->
		<!-- <div class="row mt-4"> -->
			
			<div class="col-md-6">
            <label for="">Payment Mode</label>
            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
            <div style="color:red;">Disable</div>
            <div class="mt-1">
            <label class="switch">
            <input type="checkbox"  @if ($payment_settings->stripe_status == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="stripe_status" id="stripe_status">
            <span class="slider round"></span>
            </label>
            </div>
            <div style="color:green;">Enable</div>
            </div>
            <div class="make-switch" data-on="success" data-off="warning">                
            </div>
            </div>



            <div class="col-md-6">
            <label for="">Stripe Mode</label>
            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
            <div style="color:red;">OFF</div>
            <div class="mt-1">
            <label class="switch">
            <input type="checkbox"  @if ($payment_settings->live_mode == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="live_mode" id="live_mode">
            <span class="slider round"></span>
            </label>
            </div>
            <div style="color:green;">ON</div>
            </div>
            <div class="make-switch" data-on="success" data-off="warning">                
            </div>
            </div>

			<div class="col-md-6">
            <div class="panel-title">Stripe Plan (<a href="https://stripe.com/docs/tutorials/dashboard" target="_blank">https://stripe.com/docs/tutorials/dashboard</a>)</div>
            <div class="panel-body" style="display: block;"> 
                <label>Name:</label> 
                <input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Test Secret Key" value="@if(!empty($payment_settings->plan_name)){{ $payment_settings->plan_name }}@endif" />
            </div> 
			</div>
            <div class="col-md-6 mt-3">
            <label>Test Secret Key:</label> 
            <input type="text" class="form-control" name="test_secret_key" id="test_secret_key" placeholder="Test Secret Key" value="@if(!empty($payment_settings->test_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_secret_key }}@endif" />

			</div>
            <div class="col-md-6 mt-3">
            <label>Test Publishable Key:</label> 
		    <input type="text" class="form-control" name="test_publishable_key" id="test_publishable_key" placeholder="Test Publishable Key" value="@if(!empty($payment_settings->test_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_publishable_key }}@endif" />

			</div>

            <div class="col-md-6 mt-3">
            <label>Live Secret Key:</label> 
			<input type="text" class="form-control" name="live_secret_key" id="live_secret_key" placeholder="Live Secret Key" value="@if(!empty($payment_settings->live_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_secret_key }}@endif" />
			</div>
            
			<div class="col-md-6 mt-3">
            <label>Live Publishable Key:</label> 
			<input type="text" class="form-control" name="live_publishable_key" id="live_publishable_key" placeholder="Live Publishable Key" value="@if(!empty($payment_settings->live_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_publishable_key }}@endif" />
			</div>

            <div class="col-md-6 mt-3">
            <label>Stripe Lable:</label> 
			<input type="text" class="form-control" name="stripe_lable" id="stripe_lable" placeholder="Stripe Lable" value="@if(!empty($payment_settings->stripe_lable) && Auth::user()->role != 'demo'){{ $payment_settings->stripe_lable }}@endif" />
			</div>

			</div>
            <br>
            <br>
            @if(!empty($paypal_payment_settings))
            <p><h3>PayPal Payment</h3></p>
            <div class="row">
            <div class="col-md-6 mt-3">
            <label for="">Payment Mode</label>
            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
            <div style="color:red;">Disable</div>
            <div class="mt-1">
            <label class="switch">
            <input type="checkbox"  @if($paypal_payment_settings->paypal_status == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="paypal_status" id="paypal_status">
            <span class="slider round"></span>
            </label>
            </div>
            <div style="color:green;">Enable</div>
            </div>
            <div class="make-switch" data-on="success" data-off="warning">
            </div>
            
            </div>
            <div class="col-md-6 mt-3">
            <label for="">PayPal Mode</label>

            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
            <div style="color:red;">OFF</div>
            <div class="mt-1">
            <label class="switch">
            <input type="checkbox"  @if($paypal_payment_settings->paypal_live_mode == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="paypal_live_mode" id="live_mode">
            <span class="slider round"></span>
            </label>
            </div>
            <div style="color:green;">ON</div>
            </div>
            <div class="make-switch" data-on="success" data-off="warning">
            </div>
            
            </div>
            <div class="col-md-6 mt-3">
            	<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                    <div class="panel-title"><label>Paypal Payment API Keys (<a href="https://www.paypal.com/us/home" target="_blank">https://www.paypal.com/us/home</a>)</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                    <div class="panel-body" style="display: block;"> 
                        <label>Test PayPal Username:</label> 
                        <!-- paypal_payment_settings -->
                        <input type="text" class="form-control" name="test_paypal_username" id="test_paypal_username" placeholder="Test PayPal Username" value="@if(!empty($paypal_payment_settings->test_paypal_username) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->test_paypal_username }}@endif" />
        
            </div>
            </div>
            </div>

            <div class="col-md-6 mt-3">
            <label>Test PayPal Password:</label> 
				<input type="text" class="form-control" name="test_paypal_password" id="test_paypal_password" placeholder="Test PayPal Password" value="@if(!empty($paypal_payment_settings->test_paypal_password) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->test_paypal_password }}@endif" />

            </div>            
            <div class="col-md-6 mt-3">
            <label>Test PayPal Signature:</label> 
				<input type="text" class="form-control" name="test_paypal_signature" id="test_paypal_signature" placeholder="Test PayPal Signature" value="@if(!empty($paypal_payment_settings->test_paypal_signature) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->test_paypal_signature }}@endif" />

            </div>           
             <div class="col-md-6 mt-3">
             <label>Live PayPal Username:</label> 
				<input type="text" class="form-control" name="live_paypal_username" id="live_paypal_username" placeholder="Live PayPal Username" value="@if(!empty($paypal_payment_settings->live_paypal_username) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->live_paypal_username }}@endif" />
				
            </div>            
            <div class="col-md-6 mt-3">
            <label>Live PayPal Password:</label> 
				<input type="text" class="form-control" name="live_paypal_password" id="live_paypal_password" placeholder="Live PayPal Password" value="@if(!empty($paypal_payment_settings->live_paypal_password) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->live_paypal_password }}@endif" />
		
            </div>
            <div class="col-md-6 mt-3">
            <label>Live PayPal Signature:</label> 
				<input type="text" class="form-control" name="live_paypal_signature" id="live_paypal_signature" placeholder="Live PayPal Signature" value="@if(!empty($paypal_payment_settings->live_paypal_signature) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->live_paypal_signature }}@endif" />
		
            </div>
            <div class="col-md-6 mt-3">
            <label>PayPal Lable:</label> 
				<input type="text" class="form-control" name="paypal_lable" id="paypal_lable" placeholder="PayPal Lable" value="@if(!empty($paypal_payment_settings->paypal_lable) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->paypal_lable }}@endif" />
		
            </div>
		</div>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<div class="panel-body mt-3" style="display: flex;
    justify-content: flex-end;">
<input type="submit" value="Update Payment Settings" class="btn btn-primary " />
            </div>


            
	</form>
    @Endif
                  </div>
             </div>
    </div>
</div>

 

@stop