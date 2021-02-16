@extends('layouts.app')
@include('/header')



<style>

#ck-button {
    margin:4px;
/*    background-color:#EFEFEF;*/
    border-radius:4px;
/*    border:1px solid #D0D0D0;*/
    overflow:auto;
    float:left;
}

#ck-button label {
    float:left;
    width:4.0em;
}

#ck-button label span {
    text-align:center;
   
    display:block;
  
    color: #fff;
    background-color: #3daae0;
    border: 1px solid #3daae0;
    padding: 0;
}

#ck-button label input {
    position:absolute;
/*    top:-20px;*/
}

#ck-button input:checked + span {
    background-color:#3daae0;
    color:#fff;
}
    
    .mobile-div {
        margin-left: -10%;
        margin-top: 1%;
        width: 37%;
    }
  

</style>

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); ?>
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
    

?>
<div class="container">
    <div class="row justify-content-center" id="signup-form">
         
                  
        <div class="col-md-10 col-sm-offset-1">
			<div class="login-block">
                 
                
				<a class="login-logo" href="<?php echo URL::to('/');?>">
                    <?php
                    $settings = App\Setting::find(1);
                    ?>
                    
                    <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
                </a>
            
                <div class="panel-heading"><h1>{{ __('Enter your Info below to Sign-Up for an Account!') }}</h1></div>

                <div class="panel-body">
                    <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="payment-form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right ">{{ __('User Profile') }}</label>

                                <div class="col-md-6">
                                        <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />

                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                            
                            <div class="form-group">
                            <div class="col-sm-2">
                              <select name="ccode" >
                                @foreach($jsondata as $code)
                                <option value="{{ $code['dial_code'] }}" <?php if($code['dial_code']) { echo "selected='seletected'"; } ?>> {{ $code['dial_code'] }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-5 mobile-div">
								<input id="mobile" type="text" class="form-control @error('email') is-invalid @enderror" name="mobile" placeholder="{{ __('Enter Mobile Number') }}" value="{{ old('mobile') }}" required autocomplete="off" autofocus>

                            </div>
						</div>
                            
<!--
                            
                            <div class="col-md-6">
                                <select name="ccode" >
                                    @foreach($jsondata as $code)
                                       <option value="{{ $code['dial_code'] }}">{{ $code['dial_code'] }}</option>
                                    @endforeach
                                </select>
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required>
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
-->
                        </div>

                        <div class="form-group row">
                            
                            <label for="password" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">
                                {{ __('Password') }}
                            </label>
                            
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                
                                
                            </div>
                        </div>
                        
                        <div class="form-group row">
							<div class="col-md-4 col-sm-offset-1"></div>
							<div class="col-md-7">
                                <input id="password-confirm" type="checkbox" name="terms" value="0" required>
								<label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block;">{{ __('Yes') }} ,<a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #fff;"> {{ __('I Agree to Terms and  Conditions and privacy policy' ) }}</a></label>
                            </div>
                        </div>

						<div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
							<div class="pull-right sign-up-buttons">
							  <button class="btn btn-lg btn-primary btn-block" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
<!--
							  <span>Or</span>
							   <a href="/login" class="btn btn-login">Log In</a>
-->
							</div>
							</div>
						</div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
  <div class="modal fade" id="terms" role="dialog" >
    <div class="modal-dialog" style="width: 90%;color: #000;">
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:#000;"><?php echo __('Terms and Conditions');?></h4>
        </div>
        <div class="modal-body" >
            <?php
                $terms_page = App\Page::where('slug','terms-and-conditions')->pluck('body');
             ?>
            <p><?php echo $terms_page[0];?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
        </div>
      </div>
    </div>
  </div>

   <script>
        $(document).ready(function() {
            $('.input-phone').intlInputPhone();
        });
    </script>
@include('footer')

@endsection 
