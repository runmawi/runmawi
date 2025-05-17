<?php
$settings = App\Setting::find(1) ?? new class {
    public $website_name = 'Runmawi';
    public $favicon = 'favicon.ico';
    public $login_content = '';
    public $login_text = 'Welcome Back';
};

$system_settings = App\SystemSetting::find(1) ?? new class {
    public $timezone = 'UTC';
};

date_default_timezone_set($system_settings->timezone);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | {{ $settings->website_name ?? 'Runmawi' }}</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::to('/public/uploads/settings/' . ($settings->favicon ?? 'favicon.ico')) }}" />
    
    <!-- CSS -->
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    
    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
    /* Reset and Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        width: 100%;
    }
    
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: url('{{ URL::to("/public/uploads/settings/".($settings->login_content ?? '')) }}') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }
    
    /* Main Content Wrapper */
    .page-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    
    /* Login Page Styles */
    .sign-in-page {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 15px;
        position: relative;
        height: calc(100vh - 100px); 
    }
    
    .sign-in-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }
    
    .sign-in-page > .container {
        position: relative;
        z-index: 2;
    }
    
    /* Footer Styles */
    .footer {
        width: 100%;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 1.5rem 0;
        position: relative;
        z-index: 3;
        margin-top: auto;
    }
    
    .footer .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }
    
    /* Login Card */
    .sign-user_card {
        margin: 20px 0;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }
    
    /* Typography */
    h3 {
        font-size: 30px !important;
        margin-bottom: 1.5rem;
    }
    
    .from-control::placeholder {
        color: #7b7b7b !important;
    }
    
    .links {
        color: #fff;
    }
    
    .nv {
        font-size: 14px;
        color: #fff;
        margin-top: 25px;
    }
    
    .km {
        text-align: center;
        font-size: 75px;
        font-weight: 900;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .signcont {}
    
    a.f-link {
        margin-bottom: 1rem;
        margin-left: 15vw;
        font-size: 14px;
        color: #fff;
        text-decoration: none;
    }
    
    a.f-link:hover {
        text-decoration: underline;
    }
    
    .d-inline-block {
        display: block !important;
    }
    
    i.fa.fa-google-plus {
        padding: 10px !important;
    }
    
    .demo_cred {
        background: rgba(92, 92, 92, 0.6);
        padding: 15px;
        border-radius: 15px;
        border: 2px dashed #51bce8;
        text-align: left;
        margin-bottom: 20px;
        color: #fff;
    }
    
    .btn-google {
        background-color: #ea4335;
        border: none;
        color: #fff;
    }
    
    .btn-google:hover {
        background-color: #d33426;
        color: #fff;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .sign-in-page {
            padding: 1rem 0;
        }
        
        .km {
            font-size: 50px;
            margin-bottom: 1.5rem;
        }
        
        .sign-user_card {
            padding: 1.5rem;
        }
    }
</style>
    </head>

<body>
<div class="page-wrapper">
    <section class="sign-in-page">
   <div class="container">
      <div class="row  align-items-center height-self-center">
          <div class="col-lg-7  col-12">
              <h1 class="km"><?php echo $settings->login_text; ?></h1>         
          </div>
         <div class="col-lg-5 col-12 col-md-12 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from  m-auto" align="center">
                     
                      <?php if($settings->demo_mode == 1) { ?>
                        <div class="demo_cred">
                            <p class="links" style="font-weight: 600; border-bottom: 2px dashed #fff;">Demo Login</p>
                            <p class="links"><strong>Email</strong>: admin@admin.com</p>
                            <p class="links mb-0"><strong>Password</strong>: Webnexs123!@#</p>
                        </div>
                      <?php } else  { ?>
                      <?php } ?>
                       @if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage" >
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                        </div>
                        @endforeach
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
                         <div class="mt-3" align="left" style="" >
                                 <!--<input type="checkbox" class="custom-control-input" id="customCheck">-->
                                 
                                 <!--<label class="custom-control-label" for="customCheck">Remember Me</label>-->
                                  <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

								<label class="form-check-label text-white" for="remember">
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
                               <?php if($system_settings != null && $system_settings->facebook == 1){ ?>
                                <div>
                                    <p class="links">Login with using:</p>
                                </div>
                                <div>
                                     <a href="{{ url('/auth/redirect/facebook') }}" class="" >
                                     <img src="<?php echo URL::to('/').'/assets/img/fb.png'; ?>" width="30" style="margin-bottom:1rem;"></a>
                                    </div>
                               <?php } ?>

                               <!-- <div>
                                      <a href="{{ url('/auth/redirect/twiter') }}" class="" >
                                          <img src="<?php echo URL::to('/').'/assets/img/twiter.png'; ?>" width="30" style="margin-bottom:1rem;"></a>
                                </div>-->
                                <?php if($system_settings != null && $system_settings->google == 0 ){  }else{ ?>
                                    <div>
                                    <a href="{{ url('/auth/redirect/google') }}" class="" >
                                        <img src="<?php echo URL::to('/').'/assets/img/google.png'; ?>" width="30" style="margin-bottom:1rem;"></a>

                                    </div>
                                <?php  } ?>
                                
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            @include('footer')
        </div>
    </footer>
</div>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"><\/script>')</script>
    
    <!-- jQuery, Popper JS -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    
    <!-- Slick JS -->
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    
    <!-- Owl Carousel JS -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    
    <!-- Select2 JS -->
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    
    <!-- Magnific Popup JS -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    
    <!-- Slick Animation JS -->
    <script src="{{ asset('assets/js/slick-animation.min.js') }}"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    
    <script>
        $(document).ready(function(){
            // Auto-hide success messages after 3 seconds
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        });
    </script>
</body>
</html>

