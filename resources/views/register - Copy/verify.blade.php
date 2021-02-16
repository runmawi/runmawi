@extends('layouts.app')
@section('content')
@include('/header')
<div class="container">
  <?php 
        $ref = Request::get('ref');
        $coupon = Request::get('coupon');
        $jsonString = file_get_contents(base_path('assets/country_code.json'));   
        $jsondata = json_decode($jsonString, true); 
    
        //Country from first step 
        $ccode = session()->get('ccode');
        // Mobile Number from First Step 
       $mobile = session()->get('mobile');
?>
    
    <input type="hidden" value="<?php echo THEME_URL."/register2";?>" class="base_url">
  <div class="row justify-content-center" id="signup-form">
    <div class="col-md-10 col-sm-offset-1">
      <div class="login-block">
        <a class="login-logo" href="<?php echo URL::to('/');?>">
          <?php
                $settings = App\Setting::find(1);
?>
          <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
        </a>
        <!--                <div class="panel-heading"><h1></h1></div>-->
        <div class="panel-body">
          <form action="" method="POST" id="verify">
             <div class="panel-heading"><h1><?=__('Verify Phone Number');?></h1></div>
               <p  class="success"></p>
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}
                </li>
                @endforeach
              </ul>
            </div>
            @endif
              
            <div class="well row col-xs-12">
<!--
                <div class="col-sm-12">
				    <label for="username" class="lablecolor"><?=__('Verify Phone Number');?></label>
                </div>
-->
                    <div class="col-sm-2">
                        
                     <select name="ccode" id="ccode">
                        @foreach($jsondata as $code)
                        <option value="{{ $code['dial_code'] }}" <?php if($code['dial_code'] == $ccode ) { echo "selected='seletected'"; } ?>> {{  $code['name']. $code['dial_code'] }}</option>
                        @endforeach
                    </select>
                  </div>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="mobile" id="mobile" value="<?php if(!empty($mobile)): ?><?= $mobile;?><?php endif; ?>" />
                      </div>
                     <div class="col-sm-3">
                        <div class="sign-up-buttons">
                            <input type="button" value="Send OTP" id="submit" class="btn btn-primary btn-login" style="">
                        </div>
                     </div>
              </div>
           
          </form>        
            
        <form action="" method="POST" id="confirm"  style="display:none;">
                <div class="panel-heading"><h1><?=__('Enter OTP');?></h1></div>
                <!--<label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right"><=__('Enter OTP');?></label>-->
                    <p style="color:green" id="success"></p>
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                      </ul>
                </div>
            @endif
            
              <div class="well row col-sm-offset-3 col-xs-12">
               
                <div class="col-sm-3">
				    <input type="text" class="form-control" name="otp" id="otp" value="" />
				    <input type="hidden" class="form-control" name="verify" id="verify_id" value="" />
				    <input type="hidden" class="form-control" name="number" id="number" value="" />
			     </div>
                   <div class="col-sm-3">
                        <div class="sign-up-buttons">
                            <input type="button" value="{{ __('Verify OTP') }}" id="checkotp"  placeholder="Please Enter OTP" class="btn btn-primary btn-login" style="">
                        </div>
                    </div>
              </div>
             
                
<!--
            <div class="form-group row" id="verify-button">
              <div class="col-md-10 col-sm-offset-1">
                <div class="pull-right sign-up-buttons">
                    <input type="button" value="{{ __('Verify OTP') }}" id="checkotp" class="btn btn-primary btn-login" style="font-size: 0.8em;">
                </div>
              </div>
            </div>
-->
            
            <div class="form-group row" id="continue-button" style="display:none;">
              <div class="col-md-10 col-sm-offset-1">
                <div class="pull-right sign-up-buttons">
                    <a href="<?php if (isset($ref) ) { echo URL::to('/').'/register2?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register2'; } ?>"  class="btn btn-primary btn-login" style="font-size: 0.8em;">{{ __('Continue Subscription') }}</a>
                   <!-- <span>Or</span>
                   <a type="button" href="<php echo URL::to('/').'/registerUser';?>" class="btn btn-warning"><php echo __('Skip');?></a>-->
                </div>
              </div>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

   $(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#submit").click(function(e){
        e.preventDefault();
        var ccode = $("#ccode").val();
        var mobile = $("#mobile").val();       
        var url = '{{ url('sendOtp') }}';        
        if (mobile.length > 5 ){
            $.ajax({
               url:url,
               method:'POST',
               data:{
                      ccode:ccode, 
                      mobile:mobile
                    },
               success:function(response){
                   
                   if (response.status == true) {
                       var veri = response.verify;
                       $("#verify_id").val(veri);
                       $("#verify").hide();
                       $("#confirm").css("display","block");
                       $("#number").val(response.mobile);
                       $("#success").html(response.message);
                   } else {
                       //alert();
                       $(".success").html(response.message);
                       $(".success").css("color","red");
                   }
               },
             
            });
          } else {
//               alert(response.message);
//                   return false;
                $("#success").html(response.message);
                alert('Length Must be atleast 10');
          }
   });  
       
    $("#checkotp").click(function(e){
        e.preventDefault();
        var otp = $("#otp").val();
        var number = $("#number").val();       
        var verify_id = $("#verify_id").val();       
        var url = '{{ url('verifyOtp') }}';        
        if (number.length > 5 ){
            $.ajax({
               url:url,
               method:'POST',
               data:{
                      otp:otp, 
                      number:number,
                      verify_id:verify_id
                    },
               success:function(response){
                   if (response.status == true) {
                           
                           $("#verify").hide();
                           $("#verify-button").hide();
                           $("#continue-button").css("display","block");
                           $("#confirm").css("display","block");
                           $("#success").html(response.message);
                           var base_url = $('.base_url').val();
//                       alert(base_url);
//                         window.location = base_url+'/register2';
                      // window.location.href = base_url;
                   } else {
                            $(".success").html(response.message);
                            $(".success").css("color","red");
                            return false;
                   }
                   
               },
            });
          } else {
                   alert('Length Must be atleast 10');
          }
   });
});
</script>




@include('footer')
@endsection 
