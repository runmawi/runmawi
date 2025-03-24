<?php
    $settings = App\Setting::find(1);
    $system_settings = App\SystemSetting::find(1);

    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();
?>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>{{ __('Login') }} | <?php echo $settings->website_name ; ?></title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
      <!-- Bootstrap CSS -->
        <link rel="preload" href="assets/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="assets/css/bootstrap.min.css"></noscript>
      <link rel="stylesheet" href="" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="<?= typography_link()?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?= style_sheet_link()?>" />
      <!-- Responsive -->
      <link rel="preload" fetchpriority="high" href="assets/css/responsive.css" as="style"/>
      <link rel="stylesheet" href="assets/css/responsive.css" />
      <!-- Logo preload -->
    <link rel="preload" fetchpriority="high" href="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo ; ?>" as="image">
    <link rel="preload" fetchpriority="high" href="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo ; ?>" as="image">

 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
  </script>
<style>
.reveal{
margin-left: -57px;
height: 47px !important;
background: #ED553B !important;
color: #fff !important;
position: absolute;
right: 0px;
border-radius: 0!important;
top: -64px;
}
.sign-in-page .btn{
border-radius: 0!important;
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
.signcont {
}
a.f-link {
margin-bottom: 1rem;
font-size: 14px;
}
.d-inline-block {
display: block !important;
}
i.fa.fa-google-plus {
padding: 10px !important;
}
.demo_cred {
background: #5c5c5c69;
padding: 15px;
border-radius: 15px;
border: 2px dashed #51bce8;
text-align: left;
}    
    .sign-in-page {
        background: url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;
        background-size: cover;
    }

    @media (max-width:1024px){
        .km{font-size:25px;}
    }
    @media (max-width:600px){
        .km{font-size:20px;}
    }
</style>
        <link rel="preload" href="<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>" as="image">
    </head>

@php
    $login_bg_img = $settings->login_content;
    $login_bgimg = $login_bg_img == 'Landban.png' ? false : true;
@endphp

<body>
    @if($login_bgimg)
        <section class="sign-in-page" style="background:url('{{ asset('public/uploads/settings/' . $settings->login_content) }}') no-repeat scroll 0 0; background-size: cover;">
    @else
        <section class="sign-in-page bg-set">
    @endif
   <div class="container">
      <div class="row mb-4  align-items-center height-self-center">
          <div class="col-lg-7  col-12">
             
              <p class="km text-white"><?php echo $settings->login_text; ?></p>
                
          </div>
         <div class="col-lg-5 col-12 col-md-12 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from  m-auto" align="center">
                      <div class="row justify-content-center">
                          <div class="col-md-12">

                            <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                <img alt="apps-logo" class="apps"  src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo ; ?>" width="200" height="100" style="margin-bottom:1rem;"></div></div>
                            <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                                <img alt="apps-logo" class="apps"  src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo ; ?>" width="200" height="100" style="margin-bottom:1rem;"></div></div>
                            <?php }else { ?> 
                                <img alt="apps-logo" class="apps"  src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;"></div></div>
                            <?php } ?>

                            
                      <?php if($settings->demo_mode == 1) { ?>
                        <div class="demo_cred">
                            <p class="links" style="font-weight: 600; border-bottom: 2px dashed #fff;">{{ __('Demo Login') }}</p>
                            <p class="links"><strong>{{ __('Email') }}</strong>: admin@admin.com</p>
                            <p class="links mb-0"><strong>{{ __('Password') }}</strong>: Webnexs123!@#</p>
                        </div>
                      <?php } else  { ?>
                      <?php } ?>
                       @if (Session::has('message'))
                            <div id="successMessage" class="alert alert-success">{{ Session::get('message') }}</div>
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
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('E-Mail or Phone number') }}" value="{{ old('email') }}"  autocomplete="email" autofocus>
                        </div>
                        <div class="form-group" style="  margin-top: 30px;">                                 
                           <!--<input type="password" class="form-control mb-0" id="exampleInputPassword2" placeholder="Password" required>-->
                            								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password"  autocomplete="current-password" >
                        </div>
<div class="position-relative">
                                 <span class="input-group-btn" id="eyeSlash">
                                   <button class="btn btn-theme4 reveal" aria-label="Toggle visibility" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow" style="display: none;">
                                   <button class="btn btn-theme4 reveal" aria-label="Toggle visibility" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                            </div>
                        
                         <div class="d-flex justify-content-end links">
                                    <a href="{{ route('Reset_Password') }}" class="f-link">{{ __('Forgot your password').'?' }}</a>
                        </div>
                        
                                         {{-- reCAPTCHA  --}}
                        @if( get_enable_captcha()  == 1)   
                            <div class="form-group text-left" style="  margin-top: 30px;">
                                {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                        
                        <div class="sign-info">
                            <button type="submit" class="btn btn-hover ab" style="width:100%;color:#fff!important;">{{ __('SIGN IN') }}</button>                     
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
                                <?php if($system_settings != null){ ?>
                                    <div>
                                        <p class="links">{{ __('Login with using').':' }}</p>
                                    </div>
                                <?php } ?>
                               <?php if($system_settings != null && $system_settings->facebook == 1){ ?>
                                <div>
                                    <a href="{{ url('/auth/redirect/facebook') }}" class="" >
                                    <img alt="apps-logo" src="<?php echo URL::to('/').'/assets/img/fb.png'; ?>" width="30" height="30" style="margin-bottom:1rem;"></a>
                                </div>
                               <?php } ?>
                                <?php if($system_settings != null && $system_settings->google == 0 ){  }else{ ?>
                                    <div>
                                        <a href="{{ url('/auth/redirect/google') }}" class="" >
                                            <img alt="apps-logo" src="<?php echo URL::to('/').'/assets/img/google.webp'; ?>" width="30" height="30" style="margin-bottom:1rem;">
                                        </a>
                                    </div>
                                <?php  } ?>
                            </div>
                         </div>
                     </form>
                       <div class="">
                  <div class="text -left links">
                  {{ __("Don't have an account?") }} <a href="{{ route('signup') }}" class="text-primary ml-2">{{ __('Sign Up here!') }}</a>
                  </div>
                  
               </div>
                  </div>
               </div>
              
            </div>
         </div>
      </div>
   </div>
</section>
<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script defer src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"async defer></script>                
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 5000);
    })

    var onloadCallback = function(){
      
    }
</script>

<script>
    $(document).ready(function(){
        var theme_change = "{{ $theme_mode }}";
        var bg_img_check = "{{ $login_bgimg ? 'true' : 'false' }}";
        console.log('theme_change ' + theme_change);
        
        if(theme_change === 'dark' && bg_img_check === 'false'){
            $(".bg-set").css("background", "#000");
            $(".km").css("color", "#fff");
        }
        else if(theme_change === 'light' && bg_img_check === 'false'){
            $(".bg-set").css("background", "#fff");
            $(".km").css("color", "#000");
        }
    });
</script>


        <script>
    function visibility1() {
  var x = document.getElementById('password');
  if (x.type === 'password') {
    x.type = "text";
    $('#eyeShow').show();
    $('#eyeSlash').hide();
  }else {
    x.type = "password";
    $('#eyeShow').hide();
    $('#eyeSlash').show();
  }
}
</script>
    <script>
           $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
       </script>

</body>

@php
    include(public_path('themes/theme4/views/footer.blade.php'));
@endphp


      <!-- jQuery, Popper JS -->
      <script defer src="assets/js/jquery-3.4.1.min.js"></script>
      <script defer src="assets/js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script defer src="assets/js/bootstrap.min.js"></script>
      <!-- Slick JS -->
      <script defer src="assets/js/slick.min.js"></script>
      <!-- owl carousel Js -->
      <script defer src="assets/js/owl.carousel.min.js"></script>
      <!-- select2 Js -->
      <script defer src="assets/js/select2.min.js"></script>
      <!-- Magnific Popup-->
      <script defer src="assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script defer src="assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script defer src="assets/js/custom.js"></script>
    <script defer src="assets/js/jquery.lazy.js"></script>
      <script defer src="assets/js/jquery.lazy.min.js"></script>

</html>

