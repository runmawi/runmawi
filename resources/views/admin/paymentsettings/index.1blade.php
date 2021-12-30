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
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
	</style>
@section('css')
	
@stop


@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="iq-card">

<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
		<h4><i class="entypo-credit-card"></i> Payment Settings</h4> 
	</div>
	<div class="col-md-12">
	<div class="row">
	<div class="col-md-3" id="stripe_header">
	<button><span style="color:black;" >Stripe Payment</span></button>
	</div>
	<div class="col-md-3" id="paypal_header">
	<button><span style="color:black;" >PayPal Payment</span></button>
	</div>
	</div>
	</div>

	<div class="clear mt-2"></div>

	<div id="stripe_payment">

	<form method="POST" action="{{ URL::to('admin/payment_settings') }}" accept-charset="UTF-8" enctype="multipart/form-data">
		
		<div class="row">
			
			<div class="col-md-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Live Mode Or Test Mode</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<p class="p1">Payment Settings are in Live Mode:</p>
                        
                        
                        
	
						<div class="form-group">
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div>ON</div>
                                <div class="mt-1">
                            <label class="switch">
							<input type="checkbox" @if(!isset($payment_settings->live_mode) || (isset($payment_settings->live_mode) && $payment_settings->live_mode))checked="checked" value="1"@else value="0"@endif name="live_mode" id="live_mode" />
							<span class="slider round"></span>
							</label></div>
                                <div>OFF</div>
                                </div>
				        	<div class="make-switch" data-on="success" data-off="warning">
				               <!-- <input type="checkbox" @if(!isset($payment_settings->live_mode) || (isset($payment_settings->live_mode) && $payment_settings->live_mode))checked="checked" value="1"@else value="0"@endif name="live_mode" id="live_mode" /> -->
                                	
				            </div>
						</div>
						
					</div> 
				</div>
			</div>

			<div class="col-md-9">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title"><label>Stripe Payment API Keys (<a href="https://stripe.com/docs/tutorials/dashboard" target="_blank">https://stripe.com/docs/tutorials/dashboard</a>)</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<label>Test Secret Key:</label> 
						<input type="text" class="form-control" name="test_secret_key" id="test_secret_key" placeholder="Test Secret Key" value="@if(!empty($payment_settings->test_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_secret_key }}@endif" />

						<br />
						<label>Test Publishable Key:</label> 
						<input type="text" class="form-control" name="test_publishable_key" id="test_publishable_key" placeholder="Test Publishable Key" value="@if(!empty($payment_settings->test_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_publishable_key }}@endif" />

						<br />
						<label>Live Secret Key:</label> 
						<input type="text" class="form-control" name="live_secret_key" id="live_secret_key" placeholder="Live Secret Key" value="@if(!empty($payment_settings->live_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_secret_key }}@endif" />

						<br />
						<label>Live Publishable Key:</label> 
						<input type="text" class="form-control" name="live_publishable_key" id="live_publishable_key" placeholder="Live Publishable Key" value="@if(!empty($payment_settings->live_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_publishable_key }}@endif" />
					</div> 
				</div>
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
					<div class="panel-title">Stripe Plan (<a href="https://stripe.com/docs/tutorials/dashboard" target="_blank">https://stripe.com/docs/tutorials/dashboard</a>)</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
					<div class="panel-body" style="display: block;"> 
						<label>Name:</label> 
						<input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Test Secret Key" value="@if(!empty($payment_settings->plan_name)){{ $payment_settings->plan_name }}@endif" />
						
					</div> 
				</div>
				</div>
                <div class="mt-3"></div>
                 <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="Update Payment Settings" class="btn btn-primary pull-right" />


			</div>		
            
          
		</div>

		
	<div id="paypal_payment">

<div class="row">
	
	<div class="col-md-3">
		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Live Mode Or Test Mode</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				<p class="p1">Payment Settings are in Live Mode:</p>
				
				
				

				<div class="form-group">
					<div class="d-flex justify-content-around align-items-center" style="width:50%;">
						<div>ON</div>
						<div class="mt-1">
					<label class="switch">
					<input type="checkbox" @if(!isset($paypal_payment_settings->paypal_live_mode) || (isset($paypal_payment_settings->paypal_live_mode) && $paypal_payment_settings->paypal_live_mode))checked="checked" value="1"@else value="0"@endif name="paypal_live_mode" id="paypal_live_mode" />
<span class="slider round"></span>
</label></div>
						<div>OFF</div>
						</div>
					<div class="make-switch" data-on="success" data-off="warning">
					   <!-- <input type="checkbox" @if(!isset($payment_settings->live_mode) || (isset($payment_settings->live_mode) && $payment_settings->live_mode))checked="checked" value="1"@else value="0"@endif name="live_mode" id="live_mode" /> -->
							
					</div>
				</div>
				
			</div> 
		</div>
	</div>

	<div class="col-md-9">
		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title"><label>Paypal Payment API Keys (<a href="https://www.paypal.com/us/home" target="_blank">https://www.paypal.com/us/home</a>)</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				<label>Test PayPal Username:</label> 
				<!-- paypal_payment_settings -->
				<input type="text" class="form-control" name="test_paypal_username" id="test_paypal_username" placeholder="Test PayPal Username" value="@if(!empty($paypal_payment_settings->test_paypal_username) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->test_paypal_username }}@endif" />

				<br />
				<label>Test PayPal Password:</label> 
				<input type="text" class="form-control" name="test_paypal_password" id="test_paypal_password" placeholder="Test PayPal Password" value="@if(!empty($paypal_payment_settings->test_paypal_password) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->test_paypal_password }}@endif" />

				<br />
				<label>Test PayPal Signature:</label> 
				<input type="text" class="form-control" name="test_paypal_signature" id="test_paypal_signature" placeholder="Test PayPal Signature" value="@if(!empty($paypal_payment_settings->test_paypal_signature) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->test_paypal_signature }}@endif" />

				<br />
				<label>Live PayPal Username:</label> 
				<input type="text" class="form-control" name="live_paypal_username" id="live_paypal_username" placeholder="Live PayPal Username" value="@if(!empty($paypal_payment_settings->live_paypal_username) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->live_paypal_username }}@endif" />
				<br />
				<label>Live PayPal Password:</label> 
				<input type="text" class="form-control" name="live_paypal_password" id="live_paypal_password" placeholder="Live PayPal Password" value="@if(!empty($paypal_payment_settings->live_paypal_password) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->live_paypal_password }}@endif" />
				<br />
				<label>Live PayPal Signature:</label> 
				<input type="text" class="form-control" name="live_paypal_signature" id="live_paypal_signature" placeholder="Live PayPal Signature" value="@if(!empty($paypal_payment_settings->live_paypal_signature) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->live_paypal_signature }}@endif" />
			</div> 
		</div>
		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
			<div class="panel-title">PayPal Plan (<a href="https://www.paypal.com/us/home" target="_blank">https://www.paypal.com/us/home</a>)</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
			<div class="panel-body" style="display: block;"> 
				<label>Name:</label> 
				<input type="text" class="form-control" name="paypal_plan_name" id="paypal_plan_name" placeholder="PayPal Plan" value="@if(!empty($paypal_payment_settings->paypal_plan_name)){{ $paypal_payment_settings->paypal_plan_name }}@endif" />
				
			</div> 
		</div>
		<div class="mt-3"></div>
                 <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="Update Payment Settings" class="btn btn-primary pull-right" />


			</div>	
</div>


	</form>




	






	<div class="clear"></div>

</div>
                </div></div></div><!-- admin-container -->

@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/bootstrap-switch.min.js') }}"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				if($(this).is(":checked")) {
			    	$(this).val(1);
			    } else {
			    	$(this).val(0);
			    }
			});

		});
		// stripe_header
		// paypal_header
		// stripe_payment
		// paypal_payment
		$('#paypal_payment').hide();
		$(document).ready(function(){
		$('#stripe_header').click(function() {
		alert('Your Payment Mode Changed to Stripe ');

				$('#stripe_payment').show();
				$('#paypal_payment').hide();
				
			});
			$('#paypal_header').click(function() {
		alert('Your Payment Mode Changed to PayPal ');

				$('#stripe_payment').hide();
				$('#paypal_payment').show();
				
			});

			});


	</script>

@stop

@stop