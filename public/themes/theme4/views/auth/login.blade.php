<?php
$settings = App\Setting::find(1);
$system_settings = App\SystemSetting::find(1);
?>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Login | <?php echo $settings->website_name ; ?></title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Chivo&family=Lato&family=Open+Sans:wght@473&family=Yanone+Kaffeesatz&display=swap" rel="stylesheet">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme1/assets/css/bootstrap.min.css')?>" rel="stylesheet">
      <!-- Typography CSS -->
      <link href="<?php echo URL::to('public/themes/theme4/assets/css/typography.css') ?>" rel="stylesheet">
      <!-- Style -->
      <link href="<?php echo URL::to('public/themes/theme4/assets/css/style.css') ?>" rel="stylesheet">
      <link href="<?php echo URL::to('public/themes/theme4/assets/css/responsive.css') ?>" rel="stylesheet">

      <!-- Responsive -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

                
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
  </script>
    
<style>
  
.login-box {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  padding: 40px;
  transform: translate(-50%, -50%);
  background: rgba(0,0,0,.5);
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0,0,0,.6);
  border-radius: 10px;
}

.login-box h2 {
  margin: 0 0 30px;
  padding: 0;
  color: #fff;
  text-align: center;
}

.login-box .user-box {
  position: relative;
}

.login-box .user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
}
.login-box .user-box label {
  position: absolute;
}

.login-box .user-box input:focus ~ label,
.login-box .user-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #03e9f4;
  font-size: 12px;
}

.login-box form a {
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  color: #03e9f4;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: .5s;
  margin-top: 40px;
  letter-spacing: 4px
}

.login-box a:hover {
  background: #03e9f4;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 5px #03e9f4,
              0 0 25px #03e9f4,
              0 0 50px #03e9f4,
              0 0 100px #03e9f4;
}

.login-box a span {
  position: absolute;
  display: block;
}

.login-box a span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #03e9f4);
  animation: btn-anim1 1s linear infinite;
}

@keyframes btn-anim1 {
  0% {
    left: -100%;
  }
  50%,100% {
    left: 100%;
  }
}

.login-box a span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #03e9f4);
  animation: btn-anim2 1s linear infinite;
  animation-delay: .25s
}

@keyframes btn-anim2 {
  0% {
    top: -100%;
  }
  50%,100% {
    top: 100%;
  }
}

.login-box a span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #03e9f4);
  animation: btn-anim3 1s linear infinite;
  animation-delay: .5s
}

@keyframes btn-anim3 {
  0% {
    right: -100%;
  }
  50%,100% {
    right: 100%;
  }
}

.login-box a span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #03e9f4);
  animation: btn-anim4 1s linear infinite;
  animation-delay: .75s
}

@keyframes btn-anim4 {
  0% {
    bottom: -100%;
  }
  50%,100% {
    bottom: 100%;
  }
}

    
    label{
       font-family: 'Poppins', sans-serif;
font-weight: 500;
font-size: 20px;
line-height: 28px;
        color: #fff;
        display: block;
    }
    .form-group {
  position: relative;
  margin-bottom: 1.5rem;
        
}

.form-control-placeholder {
  position: absolute;
 
  padding: 7px 0 0 1px;
  transition: all 800ms;
  opacity: 0.8;
  color: #fff;
    top:15px;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  pointer-events: none;
  transition: .5s;

}

.form-control:focus + .form-control-placeholder,
.form-control:valid + .form-control-placeholder {
  font-size: 75%;
  transform: translate3d(0, -100%, 0);
  opacity: 0.5;
    
}
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
    .in{
       
font-size: 48px;
line-height: 57px;
        font-weight: 600;
        color: #fff;
        text-align: left;
      font-family: 'Poppins', sans-serif;




    }
  
    	.input-icons i {
			position: absolute;
            left: 20px;
		}
		
		.input-icons {
			width: 100%;
			margin-bottom: 10px;
		}
		
		.icon {
			padding: 10px;
			color: #fff;
			min-width: 50px;
            font-size: 24px;
			text-align: center;
		}
		
		.input-field {
			width: 100%;
			padding: 10px 0px 0px;
			height: 59px;
           
		}
	
       
    .signcont {
 }
    a.f-link {
    margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;

        font-size: 14px;
    
}
   .d-inline-block {
    display: block !important;
}
i.fa.fa-google-plus {
   /* padding: 10px !important;*/
}
    .demo_cred {
    background: #5c5c5c69;
    padding: 15px;
    border-radius: 15px;
    border: 2px dashed #51bce8;
    text-align: left;
}    
   .form-control::-moz-placeholder {
  color: #fff!important;
  opacity: 1;
       
}
.form-control:-ms-input-placeholder {
color: rgba(255, 255, 255, 0.5);     
}
.form-control::-webkit-input-placeholder {
color: rgba(255, 255, 255, 0.5);    
}
    .sign-in-page{
        
        padding: 40px;
        padding-top: 100px;
      
    }  
    .form-control{
        
    }
    .icn i{
        border:1px solid #fff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px;
        width: 40px;
        height: 40px;
        color: #fff;
    }
    .sea{
        font-size: 20px;
        color: #fff;
    }
    .modal-header{
        border:none!important;
    }
    .btn-close{
        position: absolute;
        top: 6%;
        right: 3%;
        background: transparent;
        border: none;
    }
    .button.btn.signup {
        background-color: #FF0052!important;
    }
    

</style>
    </head>

<body>

<section class="sign-in-page" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;height:100vh;">
    <div class="container">
    <div id="myModal" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background:transparent!important;">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 25px;
    color: #fff;"><i class="fa fa-times" aria-hidden="true"></i>
</button>
      </div>
      <div class="">
       <div class="container">
      <div class="row  align-items-center justify-content-center height-self-center">
         <div class=" align-self-center">
             <!--<div class="text-center">
                 <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;">
             </div>-->
            <div class="sign-user_card">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from  m-auto" align="center">
                      <h1 class="in mt-3 text-center mb-3">Sign In</h1>
                     
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
                       <a class="sig text-white mt-3" href="{{ route('signup') }}" style="">   Do you have an Flicknexs account? </a>
                    
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
                         <div class="row justify-content-center">
                             <div class="col-lg-11">
                                 <div role="group" class="form-group">
     <input id="email" type="email" class=" input-field form-control @error('email') is-invalid @enderror" name="email" placeholder="" value="{{ old('email') }}" required autocomplete="email" autofocus>
    <label for="year" class="d-block form-control-placeholder" required="required">{{ __('Email Address') }}</label>
  </div>
                        <div class="form-group">  
                            <div class="input-icons">
                          <!-- <input type="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email" autocomplete="off" required>-->
                     
                          
                        </div></div>
                        <div class="form-group" style="  margin-top: 20px;">                                 
                           <!--<input type="password" class="form-control mb-0" id="exampleInputPassword2" placeholder="Password" required>--> 
                            <div role="group" class="form-group">
                         
                           
                            								<input id="password" type="password" class="input-field  form-control @error('Password') is-invalid @enderror" placeholder="" name="password" required autocomplete="current-password" >
                                 <label for="year" class="d-block form-control-placeholder" required="required">{{ __('PASSWORD') }}</label>
                        </div> </div>
                         
                                                            
                                    {{-- reCAPTCHA  --}}
                            @if( get_enable_captcha()  == 1)   
                                <div class="form-group text-left" style="  margin-top: 30px;">
                                    {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                    {!! NoCaptcha::display() !!}
                                </div>
                            @endif
                        
                           <div class="sign-info mt-5 mb-3 text-center">
                              <button type="submit" class="btn signup" style="width:80%;color:#fff!important;letter-spacing: 1.5px;font-size:20px;">SIGN IN</button>
                           </div> 
                                 <div class="links text-center mt-3">
                      @if (Route::has('password.request'))
                     <a href="{{ route('password.request') }}" class="f-link">Can't Login?</a>
                      @endif
							
                  </div>



                                 <div class="row align-items-center mt-3">
                                     <div class="col-md-5 p-0"> <img class="w-100"  src="<?php echo  URL::to('/assets/img/l3.png')?>"></div>
                                     <div class="col-md-2 mt-3 p-0"><p class="text-white">OR</p></div>
                                     <div class="col-md-5 p-0"> <img class="w-100"  src="<?php echo  URL::to('/assets/img/l3.png')?>"></div>
                                 </div>
                                 <div class="row justify-content-center">
                                     <div class="col-md-1 p-0 icn">  <a href="{{ url('/auth/redirect/google') }}" ><i class="fa fa-google"></i> </a></div>
                                     <div class="col-md-2 p-0 icn">  <a href="{{ url('/auth/redirect/facebook') }}"><i class="fa fa-facebook" aria-hidden="true"></i></a></div>
                                 </div>
                               
                                
</div>
                                  <div class="mt-3">
                  <div class="d-flex justify-content-center  links">
                      <p class="text-primary text-white mb-3">
                      <p class="text-left agree">By continuing, you agree terms and conditions and privacy notes</p>
                      
                  </div>
                  <div class="d-flex align-items-center mt-2 agree justify-content-strat">
                          <input type="checkbox" id="" name="" value="" class="mb-2 mr-1" checked>
                    <label for="vehicle1"> Keep me signed in</label><br>
                          </div>
               </div>
                        </div>
                      
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
                                      </form>
                  </div>
               </div>
               
            </div>
            
         </div>
          
      </div>
 <!-- Button trigger modal -->


<!-- Modal -->

      </div>
     
    </div>
  </div>
</div>
    
   </div>
   </div>
</section>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
  
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
    @php
    @include(public_path('themes\theme3\views\footer.blade.php'));
@endphp
</body>


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

</html>

