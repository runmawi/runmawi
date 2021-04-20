
<style>
.container.page-height {
        padding-top: 80px !important;
}
    i.fa.fa-google-plus {
    padding: 10px !important;
}
</style>

<section class="sign-in-page"style="background:url('<?php echo URL::to('/').'/assets/img/home/vod-header.png'; ?>') no-repeat;background-size: cover;">
<div class="container  page-height">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12 align-self-center">
              <div class="col-lg-9" >
              <h1 style="text-align:center;font-size: 60px;">WATCH<br> TV SHOWS &amp;<br> MOVIES <br>ANYWHERE,<br> ANYTIME</h1>
                  </div>
          </div>

       
                  
           <div class="col-lg-4 col-md-12 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto" align="center">
                      <img src="<?php echo URL::to('/').'/assets/img/logo.png/'; ?>" style="margin-bottom:1rem;">
                      <h2 class="mb-3 text-center">{{ __('Forgot Password') }}</h2>
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
                            <div class="col-sm-offset-1 col-sm-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder= "email@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
								<p class="reset-help">We will send you an email with instructions on how to reset your password.</p>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								
								<button type="submit" class="btn btn-primary btn-hover">
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

</section>

@extends('footer')
