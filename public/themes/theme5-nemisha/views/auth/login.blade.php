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
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/bootstrap.min.css')?>" rel="stylesheet">
      <!-- Typography CSS -->
      <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/typography.css') ?>" rel="stylesheet">
      <!-- Style -->
      <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/style.css') ?>" rel="stylesheet">
      <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/responsive.css') ?>" rel="stylesheet">
                  <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css') ?>" rel="stylesheet">

      <!-- Responsive -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
    </script>
    
<style>
     .sec-3{
        background:#003C3C
!important;
    }
    a:link{
        margin-right: 5px;
    }
    h1,h2,h3,h4{
       
    

    }
    h2{
        font-weight: 700;
        font-weight: 40px!important;
    }
    body{
        background: #fff;
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
       
font-size: 35px;
        line-height: 40px;
        font-weight: 600;
        color: #;
        text-align: left;
    



    }
     .btn-outline-success{
        border: 1px solid #ED553B;
         color: #ED553B;
    }
     .btn-outline-success:hover{
        border: 1px solid #ED553B;
        background-color: #ED553B!important;
         color: #000!important;
    }
    	.input-icons i {
			position: absolute;
            left: 20px;
		}
		
		.input-icons {
			width: 100%;
			margin-bottom: 10px;
		}
		.get{
  color: #fff;
font-style: normal;
font-weight: 500;
font-size: 20px;
line-height: 55px;
}
		.icon {
			padding: 10px;
			color: #fff;
			min-width: 50px;
            font-size: 24px;
			text-align: center;
		}
		
		/*.input-field {
			width: 100%;
			padding: 10px;
			height: 59px;
           
		}*/
	
       
    .signcont {
 }
    label{
        color: #000!important;
        margin-bottom: 0;
    }
    a.f-link {
    
        font-size: 14px;
        
    
}
   .d-inline-block {
    display: block !important;
}
i.fa.fa-google-plus {
    /* padding: 10px !important;*/}
    .btn-success{
        background: #ED553B!important;
        border: 1px solid #ED553B;

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
         letter-spacing: 0.28em;
}
.form-control:-ms-input-placeholder {
  color: #999;
      letter-spacing: 0.28em;
}
.form-control::-webkit-input-placeholder {
  color: #999;
      letter-spacing: 0.28em;
}
    .sign-in-page{
        
      /*  padding: 40px;
        padding-top: 100px;*/
       
    } 
    .nees{
        margin: 2px;
    }
    .nees1{
        margin: 10px;
    }
    .sign-user_card input{
        height: 45px;
    }
    .signup-desktop{
        background-color: #fff;
        border:1px solid #252525!important;
       
 padding: 7px 8px!important;
font-style: normal;
font-weight: 600;

    }
    .signup-desktop i{
        font-size: 22px;
    }
     .signup-desktop:hover{
        background-color: burlywood;
         color: #fff;

    }
    .signup{
       background: rgba(1, 220, 130, 1)!important;

    }
    p{
   font-family: 'Roboto', sans-serif;

}
    .join{
        color: #FFD109;
    }
    .nemi{
        color: #01DC82;
    }

}
    .btn-success{
        background-color: transparent!important;
        color: #fff;
    }
    .bg-light{
        background-color: #fff!important;
    }
</style>
    </head>

<body>
<section class="mb-0" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-0">
        <div class="container-fluid">
  <a class="navbar-brand" href="#"><img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    

      <button class="btn btn-outline-success my-2 mr-2 my-sm-0" type="submit">Sign in</button>
      <a class="btn btn-success my-2 my-sm-0"  href="{{ route('signup') }}" style="" >Sign up</a>
    
  </div>
</div></nav>
<div class="position-relative pad" style="padding:50px;" >
<div class="fixe">
     <h1 class="in mt-3 text-center">SIGN IN TO <span class="nemi">NEMISA TV</span></h1>
    <div class="row m-0 p-0 justify-content-center">
        
      
        <div class="col-md-6 col-lg-5">
              
          
                <div class="sign-user_card  mb-2 p-0 ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from  m-auto" align="center">
                     
                     <!-- <p class="get">Get 5 free days of Nemisa Tv</p>-->
                    
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
                     <form method="POST" action="{{ route('login') }}" class="mt-3">
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
                        <div class="d-flex">
                            
                         </div>
                       
                         <div class="row justify-content-center">
                             <div class="col-lg-12">
                        <div class="form-group">  
                            <div class="input-icons">
                          <!-- <input type="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email" autocomplete="off" required>-->
                          <!--<i class="">   
                                <img class=" fa fa-user icon mr-3" src="<?php echo URL::to('/').'/assets/img/uss.png';  ?>"> </i>-->
                            <input id="email" type="email" class=" input-field form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('USER NAME') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div></div>
                        <div class="form-group" style="  ">                                 
                           <!--<input type="password" class="form-control mb-0" id="exampleInputPassword2" placeholder="Password" required>--><div class="input-icons">
                          <!-- <i class=""><img class=" fa fa-user icon mr-3" src="<?php echo URL::to('/').'/assets/img/lock.png';  ?>"> 
			</i> -->
			
                           
                            								<input id="password" type="password" class="input-field  form-control @error('password') is-invalid @enderror" placeholder="{{ __('PASSWORD') }}" name="password" required autocomplete="current-password" >
                        </div> </div>
                         <div class="links text-right">
                      @if (Route::has('password.request'))
                     <a href="{{ route('password.request') }}" class="f-link mb-3">Can't Login?</a>
                      @endif
							
                  </div>

                  
                                    {{-- reCAPTCHA  --}}
                        @if( get_enable_captcha()  == 1)   
                            <div class="form-group text-left" style="  margin-top: 20px;">
                                {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                        
                           <div class="sign-info mt-1">
                              <button type="submit" class="btn signup" style="width:100%;color:#fff!important;letter-spacing: 1px;font-size:20px;font-weight: 600;">START EXPLORING TODAY</button>
                           </div> 
                                  <div class="mt-3">
                  <div class="d-flex   links">
                     
                      <p class="text-left agree mb-0">By signing up you agree to Nemisa Tv   <a style="color:#01DC82!important;" href="https://dev.nemisatv.co.za/page/terms-and-conditions" target="_blank" class="ml-1">Terms of Service and Privacy Policy</a></p>
                      
                  </div>
                                     <!--  <div class=" pt-4 mb-2">
                          <hr style="border-color:#fff;" >
                          <p class="bg-white" style="position: relative;top: -23px;left: ;z-index: 1;width: 5%;display: flex;justify-content: center;font-size:12px;">Or</p>
                      </div>-->
                                        <div class="form-group row mb-0 justify-content-center mt-4">
						@if ( config('social.google') == 1 )
                           
                            <div class="col-md-3 p-0 ">
                            <a href="{{ url('/auth/redirect/google') }}" style="border:none;color:#fff;"  class="btn signup-desktop"><i class="fa fa-google"></i> Google</a>
                            </div>
                        @endif  
						@if ( config('social.facebook') == 1 )
                            <div class="col-md-2 p-0 ">
                                <a href="{{ url('/auth/redirect/facebook') }}" class="btn signup-desktop" style="border:none;color:#fff;"><img class="" src="<?php echo  URL::to('/assets/img/ff.png')?>" style=""> Facebook</a>
                            </div>
						@endif 
						</div>
                <!--  <div class="d-flex align-items-center agree justify-content-strat">
                          <input type="checkbox" id="" name="" value="" class="mr-1" checked >
                    <label for="vehicle1"> Keep me signed in</label><br>
                          </div>-->
               </div>
                        </div>
                         </div>
                         <!-- <h5 class="mb-3 text-center">Sign in by using</h5>
                         -->
                                      </form>
                  </div>
               </div>
               
            </div>
           
        
        </div>
       
    </div>
    </div></div>
   <!--<div class="container">
      <div class="row  align-items-center justify-content-center height-self-center">
         <div class="col-lg-6 col-12 col-md-12 align-self-center">
             <div class="text-center">
                 <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;">
             </div>
            
         </div>
          
      </div>
   </div>-->
</section>
    
    <section class="sec-3" style="padding:80px 30px 80px 30px;">
        <div class="container">
            <div class="row align-items-center">
                 <div class="col-lg-6">
                 <img class="w-100 " src="<?php echo  URL::to('/assets/img/m1.png')?>" style="">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4">Free edutainment for the digital warrior</h2>
                <p class="text-white mt-2 mb-3">Advancing South Africans for the future with content that is missioned to deliver tangible digital skills to bridge the digital divide.</p>
                <p class="text-white mt-2 mb-3">WATCH EVERYWHERE, STREAM LIVE, QUALITY VIDEOS</p>
                  <a class="btn btn-lg btn-success  my-2 mr-2 my-sm-0 btn-block" style="padding:12px;width:70%;color:#fff!important;" href="{{ route('login') }}" ><span>Get Started</span></a>
            </div>
           
        </div></div>
    </section>

    
@php
    include(public_path('themes/theme5-nemisha/views/footer.blade.php'));
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
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
