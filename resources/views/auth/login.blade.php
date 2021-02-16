@include('header')

 <?php
   $settings = App\Setting::find(1);
?>

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container page-height">
    <div class="row justify-content-center ">	
<div class="container">
    <div class="row justify-content-center">	
		<div class="col-md-4 col-sm-offset-4">
			<div class="login-block">
				<a class="login-logo" href="<?php echo URL::to('/');?>">
                    <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
                </a>
				<div class="card-header"><h2 class="form-signin-heading">{{ __('Sign-In') }}  </h2></div>
               
                    @if (Session::has('message'))
                       <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                     
				<div class="card-body">
					<form method="POST" action="{{ route('login') }}" class="form-signin">
						@csrf
						   <input type="hidden" name="previous" value="{{ url()->previous() }}">
						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror

						<div class="form-group">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>

								
						</div>

						<div class="form-group">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">

								
						</div>
						<div class="forgot-pass text-right padding-bottom-10">
						   @if (Route::has('password.request'))
								<a href="{{ route('password.request') }}">
									{{ __('Forgot Your Password?') }}
								</a>
							@endif
						</div>
						
						<div class="form-group mb-0">
							<button type="submit" class="btn btn-lg btn-primary btn-block loginin">
								{{ __('Login') }}
							</button>
						</div>
						
						<div class="form-group nomargin">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

								<label class="form-check-label" for="remember">
									{{ __('Keep me Signed in') }}
								</label>
							</div>
						</div>
						<div class="form-group row mb-0">
						@if ( config('social.google') == 1 )
                           
                            <div class="col-md-6 offset-md-4">
                            <a href="{{ url('/auth/redirect/google') }}" class="btn btn-danger"><i class="fa fa-google"></i> Google</a>
                            </div>
                        @endif  
						@if ( config('social.facebook') == 1 )
                            <div class="col-md-6 offset-md-8">
                                <a href="{{ url('/auth/redirect/facebook') }}" class="btn signup-desktop" style="background-color:#007bff;border:none;color:#fff;"><i class="fa fa-facebook"></i> Facebook</a>
                            </div>
						@endif 
						</div>
                        <div class="line-design margin-bottom-10 footer-section-line1"></div>
						<div class="form-group mb-0 account-group text-center">
							<p>{{ __('New to') }} <?php echo $settings->website_name; ?>? <a style="color: #d6bb04;" href="{{ route('signup') }}">{{ __('Sign Up Now') }}</a> </p>
						</div>						
					</form>
				</div>
			</div>
		</div>
    </div>
</div>
</div>

@include('footer')

