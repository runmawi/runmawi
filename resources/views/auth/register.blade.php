@extends('layouts.app')

@section('content')

 @extends('header')

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
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('messages.name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right"><?php echo __('messages.Username');?></label>

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
                            <label for="password" class="col-md-4 col-sm-offset-1 col-form-label text-md-right">{{ __('Password') }}</label>

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
                                <input id="password-confirm" type="checkbox" name="terms" value="0">
								<label for="password-confirm" class="col-form-label text-md-right" style="display: inline-block;">{{ __('Yes ,') }} <a data-toggle="modal" data-target="#terms" style="text-decoration:none;color: #00a650;"> {{ __('I Agree to Terms and  Conditions and privacy policy' ) }}</a></label>
                            </div>
                        </div>

						<div class="form-group row">
							<div class="col-md-10 col-sm-offset-1">
							<div class="pull-right sign-up-buttons">
							  <button class="btn btn-primary btn-login" type="submit" name="create-account">{{ __('Sign Up Today') }}</button>
							  <span>Or</span>
							   <a href="/login" class="btn btn-login">Log In</a>
							</div>
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
@endsection

