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
    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
        <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
        <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
        <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
        <a class="black" href="{{ URL::to('admin/mobileapp') }}">RTMP URL Settings</a>
    </div>
    
    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
        <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
        <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
        <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
        <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
    
    <div class="container-fluid  p-0">
        <div class="iq-card">

            <div id="admin-container">
            
                <div class="admin-section-title">
                    <h4><i class="entypo-globe"></i> Payment Settings</h4> 
                    <hr>
                </div>

                <div class="clear"></div>


                    <form method="POST" action="{{ URL::to('admin/payment_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
            
                        @if(!empty($payment_settings))

                            <p><h3>Stripe Payment</h3></p>

                            <div class="row">

                                <div class="col-md-6">
                                    <label for="">Payment Mode</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        
                                        <div style="color:red;">Disable</div>

                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  @if ($payment_settings->stripe_status == 1) {{ "checked='checked'" }} @else {{ " " }} @endif name="stripe_status" id="stripe_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
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
                                <div class="make-switch" data-on="success" data-off="warning"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel-title">Stripe official Docs (<a href="https://stripe.com/docs/tutorials/dashboard" target="_blank">https://stripe.com/docs/tutorials/dashboard</a>)</div>
                                    <div class="panel-body" style="display: block;"> 
                                        <label>Name:</label> 
                                        <input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Test Secret Key" value="@if(!empty($payment_settings->plan_name)){{ $payment_settings->plan_name }}@endif" />
                                    </div> 
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Stripe Label:</label> 
                                    <input type="text" class="form-control" name="stripe_lable" id="stripe_lable" placeholder="Stripe Lable" value="@if(!empty($payment_settings->stripe_lable) && Auth::user()->role != 'demo'){{ $payment_settings->stripe_lable }}@endif" />
                                </div>

                                                        {{-- Test Key --}}

                                <div class="col-md-6 mt-3">
                                    <label>Test Publishable Key:</label> 
                                    <input type="text" class="form-control" name="test_publishable_key" id="test_publishable_key" placeholder="Test Publishable Key" value="@if(!empty($payment_settings->test_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_publishable_key }}@endif" />
                                </div>


                                <div class="col-md-6 mt-3">
                                    <label>Test Secret Key:</label> 
                                    <input type="text" class="form-control" name="test_secret_key" id="test_secret_key" placeholder="Test Secret Key" value="@if(!empty($payment_settings->test_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->test_secret_key }}@endif" />
                                </div>

                                                        {{-- Live Key --}}

                                <div class="col-md-6 mt-3">
                                    <label>Live Publishable Key:</label> 
                                    <input type="text" class="form-control" name="live_publishable_key" id="live_publishable_key" placeholder="Live Publishable Key" value="@if(!empty($payment_settings->live_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_publishable_key }}@endif" />
                                </div>
                               
                                <div class="col-md-6 mt-3">
                                    <label>Live Secret Key:</label> 
                                    <input type="text" class="form-control" name="live_secret_key" id="live_secret_key" placeholder="Live Secret Key" value="@if(!empty($payment_settings->live_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings->live_secret_key }}@endif" />
                                </div>

                                                        {{-- Subscription Trail --}}

                                <div class="col-md-6 mt-3">
                                    <label for=""> Stripe Subscription Trail Status:  </label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;"> Disable </div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  @if ($payment_settings->subscription_trail_status == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="subscription_trail_status" id="subscription_trail_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;"> Enable </div>
                                        <div class="make-switch" data-on="success" data-off="warning"></div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> Stripe Subscription Trail Days: </label> 
                                    <input type="number" min="1"  class="form-control" name="subscription_trail_days" id="subscription_trail_days" placeholder=" 1 - 100 " value="@if(!empty($payment_settings->subscription_trail_days) && Auth::user()->role != 'demo'){{ $payment_settings->subscription_trail_days }}@endif" />
                                </div>
                            </div>
                            
                            <br>
                        @endif

                        {{-- Razorpay --}}

                        @if(!empty($Razorpay_payment_setting))
                            <p><h3>Razorpay Payment</h3></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Payment Mode</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">Disable</div>
                                            <div class="mt-1">
                                                <label class="switch">
                                                    <input type="checkbox"  @if ($Razorpay_payment_setting->status == 1) {{ "checked='checked'" }} @else {{ " " }} @endif name="Razorpay_status" id="Razorpay_status">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                    
                                <div class="col-md-6">
                                    <label for="">Razorpay Mode</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">OFF</div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  @if ($Razorpay_payment_setting->live_mode == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="Razorpay_live_mode" id="Razorpay_live_mode">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;">ON</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="panel-title">Razorpay official docs (<a href="https://razorpay.com/" target="_blank"> https://razorpay.com/ </a>)</div>
                                    <div class="panel-body" style="display: block;"> 
                                        <label>Name:</label> 
                                        <input type="text" class="form-control" name="Razorpay_plan_name" id="plan_name" placeholder="Razorpay Test Secret Key" value="@if(!empty($Razorpay_payment_setting->plan_name)){{ $Razorpay_payment_setting->plan_name }}@endif" />
                                    </div> 
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Razorpay Label:</label> 
                                    <input type="text" class="form-control" name="Razorpay_lable" id="Razorpay_label" placeholder="Razorpay Label" value="@if(!empty($Razorpay_payment_setting->Razorpay_lable) && Auth::user()->role != 'demo'){{ $Razorpay_payment_setting->Razorpay_lable }}@endif" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Razorpay Test Publishable Key:</label> 
                                    <input type="text" class="form-control" name="Razorpay_test_publishable_key" id="Razorpay_test_publishable_key" placeholder="Razorpay Test Publishable Key" value="@if(!empty($Razorpay_payment_setting->test_publishable_key) && Auth::user()->role != 'demo'){{ $Razorpay_payment_setting->test_publishable_key }}@endif" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Razorpay Test Secret Key:</label> 
                                    <input type="text" class="form-control" name="Razorpay_test_secret_key" id="Razorpay_test_secret_key" placeholder="Razorpay Test Secret Key" value="@if(!empty($Razorpay_payment_setting->test_secret_key) && Auth::user()->role != 'demo'){{ $Razorpay_payment_setting->test_secret_key }}@endif" />
                                </div>
                    
                                <div class="col-md-6 mt-3">
                                    <label>Razorpay Live Publishable Key:</label> 
                                    <input type="text" class="form-control" name="Razorpay_live_publishable_key" id="Razorpay_live_publishable_key" placeholder="Razorpay Live Publishable Key" value="@if(!empty($Razorpay_payment_setting->live_publishable_key) && Auth::user()->role != 'demo'){{ $Razorpay_payment_setting->live_publishable_key }}@endif" />
                                </div>
                    
                                <div class="col-md-6 mt-3">
                                    <label>Razorpay Live Secret Key:</label> 
                                    <input type="text" class="form-control" name="Razorpay_live_secret_key" id="Razorpay_live_secret_key" placeholder="Razorpay Live Secret Key" value="@if(!empty($Razorpay_payment_setting->live_secret_key) && Auth::user()->role != 'demo'){{ $Razorpay_payment_setting->live_secret_key }}@endif" />
                                </div>
                    
                            </div> <br><br>
                        @endif

                        {{-- paypal_payment_settings --}}

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
                                <div class="make-switch" data-on="success" data-off="warning"></div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                                    <div class="panel-title"><label>Paypal official docs (<a href="https://www.paypal.com/us/home" target="_blank">https://www.paypal.com/us/home</a>)</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                    <div class="panel-body" style="display: block;"> 
                                        <label>Test PayPal Username:</label> 
                                        <input type="text" class="form-control" name="test_paypal_username" id="test_paypal_username" placeholder="Test PayPal Username" value="@if(!empty($paypal_payment_settings->test_paypal_username) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->test_paypal_username }}@endif" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label>PayPal Label:</label> 
                                <input type="text" class="form-control" name="paypal_lable" id="paypal_lable" placeholder="PayPal Label" value="@if(!empty($paypal_payment_settings->paypal_lable) && Auth::user()->role != 'demo'){{ $paypal_payment_settings->paypal_lable }}@endif" />
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

                           
                            </div>
                        @endif

                        {{-- Paystack --}}

                        @if(!empty($paystack_payment_setting))

                            <p><h3>Paystack  Payment</h3></p>

                            <div class="row">

                                <div class="col-md-6">

                                    <label for="">Payment Mode</label>

                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">Disable</div>
                                            <div class="mt-1">
                                                <label class="switch">
                                                    <input type="checkbox"  @if ($paystack_payment_setting->status == 1) {{ "checked='checked'" }} @else {{ " " }} @endif name="paystack_status" >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                    
                                <div class="col-md-6">
                                    <label for=""> Paystack Mode </label>

                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        
                                        <div style="color:red;">OFF</div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  name="paystack_live_mode"  @if ($paystack_payment_setting->paystack_live_mode == 1) {{ "checked='checked'" }} @else {{ "" }} @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;">ON</div>
                                    </div>

                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="panel-title"> Paystack official docs (<a href="https://paystack.com/" target="_blank"> https://paystack.com/ </a>)</div>
                                    <label>Name:</label> 
                                    <input type="text" class="form-control" name="paystack_name" id="paystack_name" placeholder="Paystack Name" value="@if(!empty($paystack_payment_setting->paystack_name)){{ $paystack_payment_setting->paystack_name }}@endif" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> Paystack Label: </label> 
                                    <input type="text" class="form-control" name="paystack_lable"  placeholder="Paystack Label" value="@if( !empty($paystack_payment_setting->paystack_lable ) && Auth::user()->role != 'demo'){{ $paystack_payment_setting->paystack_lable }}@endif" />
                                </div>
                             
                                <div class="col-md-6 mt-3">
                                    <label> Paystack Test Publishable Key: </label> 
                                    <input type="text" class="form-control" name="paystack_test_publishable_key"  placeholder="Paystack Test Publishable Key" value="@if(!empty($paystack_payment_setting->paystack_test_publishable_key) && Auth::user()->role != 'demo'){{ $paystack_payment_setting->paystack_test_publishable_key }}@endif" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> Paystack Test Secret Key: </label> 
                                    <input type="text" class="form-control" name="paystack_test_secret_key" placeholder="Paystack Test Secret Key" value="@if(!empty($paystack_payment_setting->paystack_test_secret_key) && Auth::user()->role != 'demo'){{ $paystack_payment_setting->paystack_test_secret_key }}@endif" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> Paystack Live Publishable Key: </label> 
                                    <input type="text" class="form-control" name="paystack_live_publishable_key"  placeholder="Paystack Live Publishable Key" value="@if(!empty($paystack_payment_setting->paystack_live_publishable_key) && Auth::user()->role != 'demo'){{ $paystack_payment_setting->paystack_live_publishable_key }}@endif" />
                                </div>
                    
                                <div class="col-md-6 mt-3">
                                    <label> Paystack Live Secret Key: </label> 
                                    <input type="text" class="form-control" name="paystack_live_secret_key" placeholder="Paystack Live Secret Key" value="@if(!empty($paystack_payment_setting->paystack_live_secret_key) && Auth::user()->role != 'demo'){{ $paystack_payment_setting->paystack_live_secret_key }}@endif" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> Paystack Callback URL: </label> 
                                    <input type="text" class="form-control" name="paystack_callback_url"  placeholder="Paystack Callback URL" value="@if( !empty($paystack_payment_setting->paystack_callback_url ) && Auth::user()->role != 'demo'){{ $paystack_payment_setting->paystack_callback_url }}@endif" readonly />
                                </div>

                    
                            </div> <br><br>
                        @endif

                        {{-- CinetPay --}}

                        @if(!empty($Cinet_payment_setting))

                            <p><h3>Cinet Payment</h3></p>

                            <div class="row">

                                <div class="col-md-6">

                                    <label for="">Payment Mode</label>

                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">Disable</div>
                                            <div class="mt-1">
                                                <label class="switch">
                                                    <input type="checkbox"  @if ($Cinet_payment_setting->CinetPay_Status == 1) {{ "checked='checked'" }} @else {{ " " }} @endif name="CinetPay_Status" >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                    
                    
                                <div class="col-md-6">
                                    <div class="panel-title"> Cinet Pay official docs(<a href="https://app.cinetpay.com/" target="_blank"> https://app.cinetpay.com/ </a>)</div>
                                    <label>Name:</label> 
                                    <input type="text" class="form-control" name="CinetPay_Lable" id="CinetPay_Lable" placeholder="CinetPay Name" value="@if(!empty($Cinet_payment_setting->CinetPay_Lable)){{ $Cinet_payment_setting->CinetPay_Lable }}@endif" />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> CinetPay API Key: </label> 
                                    <input type="text" class="form-control" name="CinetPay_APIKEY"  placeholder="CinetPay API Key" value="@if( !empty($Cinet_payment_setting->CinetPay_APIKEY ) && Auth::user()->role != 'demo'){{ $Cinet_payment_setting->CinetPay_APIKEY }}@endif"  />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> CinetPay Sceret Key: </label> 
                                    <input type="text" class="form-control" name="CinetPay_SecretKey"  placeholder="CinetPay Sceret Key" value="@if(!empty($Cinet_payment_setting->CinetPay_SecretKey) && Auth::user()->role != 'demo'){{ $Cinet_payment_setting->CinetPay_SecretKey }}@endif" />
                                </div>
                                
                                <div class="col-md-6 mt-3">
                                    <label> CinetPay Site ID: </label> 
                                    <input type="text" class="form-control" name="CinetPay_SITE_ID"  placeholder="CinetPay Site ID" value="@if( !empty($Cinet_payment_setting->CinetPay_SITE_ID ) && Auth::user()->role != 'demo'){{ $Cinet_payment_setting->CinetPay_SITE_ID }}@endif" />
                                </div>

                             
                            </div> <br><br>
                        @endif

                                    {{-- Paydunya --}}

                        @if(!empty($Paydunya_payment_setting))

                            <p><h3>Paydunya Payment</h3></p>
                        
                            <div class="row">
                        
                                <div class="col-md-6">
                        
                                    <label for="">Payment Mode</label>
                        
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">Disable</div>
                                            <div class="mt-1">
                                                <label class="switch">
                                                    <input type="checkbox"  {{ $Paydunya_payment_setting->paydunya_status ?? $Paydunya_payment_setting->paydunya_status == 1 ? "checked" : null}}  name="paydunya_status" >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Paydunya Mode</label>
    
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">OFF</div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  @if($Paydunya_payment_setting->live_mode == 1) {{ "checked='checked'" }} @else {{ "" }} @endif name="paydunya_live_mode" id="paydunya_live_mode">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;">ON</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                        
                        
                                <div class="col-md-6">
                                    <div class="panel-title"> Paydunya official Docs(<a href="https://paydunya.com/" target="_blank"> https://paydunya.com/ </a>)</div>
                                    <label>Name:</label> 
                                    <input type="text" class="form-control" name="paydunya_label" id="paydunya_label" placeholder="Paydunya  Name" value="@if(!empty($Paydunya_payment_setting->paydunya_label)){{ $Paydunya_payment_setting->paydunya_label }}@endif" />
                                </div>

                                
                                <div class="col-md-6 mt-3">
                                    <label> Master Key: </label> 
                                    <input type="text" class="form-control" name="paydunya_masterkey"  placeholder="Paydunya Master Key" value="@if( !empty($Paydunya_payment_setting->paydunya_masterkey ) && Auth::user()->role != 'demo'){{ $Paydunya_payment_setting->paydunya_masterkey }}@endif"  />
                                </div>
                                <br>
                        
                                <div class="col-md-6 mt-3">
                                    <label> Test Publishable Key: </label> 
                                    <input type="text" class="form-control" name="paydunya_test_PublicKey"  placeholder="Paydunya Test Publish Key" value="@if( !empty($Paydunya_payment_setting->paydunya_test_PublicKey ) && Auth::user()->role != 'demo'){{ $Paydunya_payment_setting->paydunya_test_PublicKey }}@endif"  />
                                </div>
                        
                                <div class="col-md-6 mt-3">
                                    <label> Test Secret Key: </label> 
                                    <input type="text" class="form-control" name="paydunya_test_PrivateKey"  placeholder="Paydunya Test Sceret Key" value="@if(!empty($Paydunya_payment_setting->paydunya_test_PrivateKey) && Auth::user()->role != 'demo'){{ $Paydunya_payment_setting->paydunya_test_PrivateKey }}@endif" />
                                </div>
                                
                                <div class="col-md-6 mt-3">
                                    <label> Test Token Key: </label> 
                                    <input type="text" class="form-control" name="paydunya_test_token"  placeholder="Paydunya Test Token Key" value="@if( !empty($Paydunya_payment_setting->paydunya_test_token ) && Auth::user()->role != 'demo'){{ $Paydunya_payment_setting->paydunya_test_token }}@endif"  />
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label> Live Publishable Key: </label> 
                                    <input type="text" class="form-control" name="paydunya_live_PublicKey"  placeholder="Paydunya Live Publish Key" value="@if(!empty($Paydunya_payment_setting->paydunya_live_PublicKey) && Auth::user()->role != 'demo'){{ $Paydunya_payment_setting->paydunya_live_PublicKey }}@endif" />
                                </div>
                        
                                <div class="col-md-6 mt-3">
                                    <label> Live Secret Key: </label> 
                                    <input type="text" class="form-control" name="paydunya_live_PrivateKey"  placeholder="Paydunya Live Sceret Key" value="@if(!empty($Paydunya_payment_setting->paydunya_live_PrivateKey) && Auth::user()->role != 'demo'){{ $Paydunya_payment_setting->paydunya_live_PrivateKey }}@endif" />
                                </div>

                                
                                <div class="col-md-6 mt-3">
                                    <label> Live Token Key: </label> 
                                    <input type="text" class="form-control" name="paydunya_live_token"  placeholder="Paydunya Live Token Key" value="@if(!empty($Paydunya_payment_setting->paydunya_live_token) && Auth::user()->role != 'demo'){{ $Paydunya_payment_setting->paydunya_live_token }}@endif" />
                                </div>
                        
                            </div> 
                            <br><br>
                        @endif

                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        
                        <div class="panel-body mt-3" >
                            <input type="submit" value="Update Payment Settings" class="btn btn-primary " />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop