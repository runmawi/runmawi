

<!--

 <?php
   $settings = App\Setting::find(1);
?>
-->

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/fl-logo.png" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
  </script>
<style>
    h3 {font-size: 30px!important;}
    .from-control::placeholder{
        color: #7b7b7b!important;
    }
    .links{
         color: #fff;
    }
    .nv{
        font-size: 14px;
       color: #fff;
        margin-top: 25px;
    }
    .km{
       text-align:center;
         font-size: 75px;
        font-weight: 900;
        
       
    }
    .signcont {
 }
    a.f-link {
    margin-bottom: 1rem;
        margin-left: 15vw;
        font-size: 14px;
    
}
   .d-inline-block {
    display: block !important;
}
i.fa.fa-google-plus {
    padding: 10px !important;
}
</style>

 
<!--<div class="page-height">
    <div class="row justify-content-center ">	
<div class="container signcont">
    <div class="row justify-content-center">	
		<div class="col-md-4 col-sm-offset-4">
			<div class="login-block">
				<a class="login-logo" href="<?php echo URL::to('/');?>">
                    <img src="<?php echo URL::to('/').'/assets/img/logo.png/'; ?>">
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
                           
                            <div class="col-md-3 ">
                            <a href="{{ url('/auth/redirect/google') }}" class="btn btn-danger"><i class="fa fa-google"></i> Google</a>
                            </div>
                        @endif  
						@if ( config('social.facebook') == 1 )
                            <div class="col-md-3 offset-md-3">
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
    </div></div>-->
<section class="sign-in-page">
   <div class="container">
      <div class="row  align-items-center height-self-center">
          <div class="col-lg-7  col-md-6">
              <div class="" >
              <h1 class="km">WATCH<br> TV SHOWS &amp;<br> MOVIES <br>ANYWHERE,<br> ANYTIME</h1>
                  </div>
          </div>
         <div class="col-lg-5 col-md-6 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from  m-auto" align="center">
                      <img src="<?php echo URL::to('/').'/assets/img/logo.png'; ?>" width="250" style="margin-bottom:1rem;">
                       @if (Session::has('message'))
                       <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                     <form method="POST" action="{{ route('login') }}" class="mt-4">
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
                          <!-- <input type="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email" autocomplete="off" required>-->
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('E-Mail or Phone number') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div class="form-group" style="  margin-top: 30px;">                                 
                           <!--<input type="password" class="form-control mb-0" id="exampleInputPassword2" placeholder="Password" required>-->
                            								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password" >
                        </div>
                         <div class="d-flex justify-content-around links">
                      @if (Route::has('password.request'))
                     <a href="{{ route('password.request') }}" class="f-link">Forgot your password?</a>
                      @endif
							
                  </div>
                        
                           <div class="sign-info">
                              <button type="submit" class="btn btn-hover ab" style="width:100%;color:#fff!important;">SIGN IN</button>
                                                            
                           </div> 
                         <div class="custom-control custom-checkbox" align="left" style="" >
                                 <!--<input type="checkbox" class="custom-control-input" id="customCheck">-->
                                 
                                 <!--<label class="custom-control-label" for="customCheck">Remember Me</label>-->
                                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

								<label class="form-check-label nv" for="remember">
									{{ __('Keep me signed in') }}
								</label>
                            
                              </div>  
                          <hr style="color:#1e1e1e;">
                         <!-- <h5 class="mb-3 text-center">Sign in by using</h5>
                         <div class="form-group row mb-0">
						@if ( config('social.google') == 1 )
                           
                            <div class="col-md-3 ">
                            <a href="{{ url('/auth/redirect/google') }}" style="background-color:#ea4335;border:none;color:#fff;"  class="btn signup-desktop"><i class="fa fa-google"></i> Google</a>
                            </div>
                        @endif  
						@if ( config('social.facebook') == 1 )
                            <div class="col-md-3 offset-md-3">
                                <a href="{{ url('/auth/redirect/facebook') }}" class="btn signup-desktop" style="background-color:#3f5c9a;border:none;color:#fff;"><i class="fa fa-facebook"></i> Facebook</a>
                            </div>
						@endif 
						</div>-->
                        <div class="soc mb-3">
                            <div class="d-flex align-items-center">
                                <div>
                            <p class="links">Login with using:</p>
                                    </div>
                                <div>
                                     <a href="{{ url('/auth/redirect/facebook') }}" class="" >
                                     <img src="<?php echo URL::to('/').'/assets/img/fb.png'; ?>" width="30" style="margin-bottom:1rem;"></a>
                                </div>
                                <div>
                                     <img src="<?php echo URL::to('/').'/assets/img/twiter.png'; ?>" width="30" style="margin-bottom:1rem;">
                                </div>
                                </div>
                         </div>
                     </form>
                  </div>
               </div>
               <div class="">
                  <div class="d-flex justify-content-center  links">
                     Don't have an account? <a href="{{ route('signup') }}" class="text-primary ml-2">Sign Up</a>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
     @include('footer')
      <!-- jQuery, Popper JS -->
      <script src="assets/js/jquery-3.4.1.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- Slick JS -->
      <script src="assets/js/slick.min.js"></script>
      <!-- owl carousel Js -->
      <script src="assets/js/owl.carousel.min.js"></script>
      <!-- select2 Js -->
      <script src="assets/js/select2.min.js"></script>
      <!-- Magnific Popup-->
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script src="assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script src="assets/js/custom.js"></script>



