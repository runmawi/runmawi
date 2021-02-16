@include('header')

 <?php
   $settings = App\Setting::find(1);
?>

<div class="container">
    <div class="row justify-content-center">		
	 

		<div class="col-md-8 col-sm-offset-1">
			<div class="login-block">
				<a class="login-logo" href="<?php echo URL::to('/');?>">
                    <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
                </a>
				<div class="card-header"><h2 class="form-signin-heading">{{ __('Enter OTP') }}</h2></div>

				<div class="card-body">
					<form method="POST" action="{{ URL::to('/verifyOtp') }}" class="form-signin">
						@csrf
                        
                        <div class="form-group">
								<input id="otp" type="text" class="form-control @error('email') is-invalid @enderror" name="otp" placeholder="{{ __('Enter OTP Number') }}" value="{{ old('otp') }}" required autocomplete="off" autofocus>
						</div>
						
						<div class="form-group">
								<input id="mobile" type="hidden" name="mobile"  value="{{ $mobile }}">
						</div>
                        
						<div class="forgot-pass text-right padding-bottom-10">
						   @if (Route::has('password.request'))
								<a href="{{ route('password.request') }}">
									{{ __('Forgot Your Password?') }}
								</a>
							@endif
						</div>
						
						<div class="form-group mb-0">
							<button type="submit" class="btn btn-lg btn-primary btn-block">
								{{ __('Verify OTP') }}
							</button>
						</div>
						
                        <div class="line-design margin-bottom-10 footer-section-line1"></div>
						<div class="form-group mb-0 account-group text-center">
							<p style="color:#fff;">{{ __('New to') }} <?php echo $settings->website_name; ?>? <a href="{{ route('signup') }}">{{ __('Sign Up Now') }}</a> </p>
						</div>						
					</form>
				</div>
			</div>
		</div>
    </div>
</div>

@include('footer')

