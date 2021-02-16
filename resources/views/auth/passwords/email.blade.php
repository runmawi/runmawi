@include('header')

<div class="container  page-height">
    <div class="row justify-content-center">

        <div class="card" style="margin-top: 30px;">
                  
            <div class="col-md-4 col-sm-offset-4">
        <div class="forgot-box">
            <div class="card text-center">
                <div class="card-header col-form-label"><h1>{{ __('Forgot Password') }}</h1></div>
			</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-sm-offset-1 col-sm-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder= "email@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
								<p class="reset-help">We will send you an email with instructions on how to reset your password.</p>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								
								<button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@extends('footer')
