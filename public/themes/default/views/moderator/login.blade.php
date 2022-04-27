<?php
$settings = App\Setting::find(1);
$system_settings = App\SystemSetting::find(1);
?>
<html>
<head>
    <?php //dd(URL::to('/'). '/assets/css/responsive.css');?>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Login | <?php echo $settings->website_name ; ?></title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css'; ?>" />
      <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css" /> -->
      <!-- Typography CSS -->
      <!-- <link rel="stylesheet" href="assets/css/typography.css" /> -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/typography.css'; ?>" />
      <!-- Style -->
      <!-- <link rel="stylesheet" href="assets/css/style.css" /> -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css'; ?>" />
      <!-- Responsive -->
      <!-- <link rel="stylesheet" href="assets/css/responsive.css" /> -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/responsive.css'; ?>" />
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

.sign-in-from{
  
    margin: 0 auto;
    display: block;
}
</style>

 
<section class="sign-in-page" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
   <div class="container">
      <div class="row  align-items-center justify-content-center height-self-center">
          <!-- <div class="col-lg-  col-md-6">
              <div class="" >
              <h1 class="km">WATCH<br> TV SHOWS &amp;<br> MOVIES <br>ANYWHERE,<br> ANYTIME</h1>
                  </div>
          </div> -->
         <div class="col-lg-5 col-md-12 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from  m-auto" align="center">
                  <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;">
                  <div>

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
                                              
                  </div>
                     <form method="POST" action="{{ URL::to('cpp/home') }}" class="mt-4">
                     <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

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
                     <!-- <a href="{{ route('password.request') }}" class="f-link">Forgot your password?</a> -->
                      @endif
							
                  </div>
                        
                           <div class="sign-info">
                              <button type="submit" class="btn  ab" style="width:100%;color:#fff!important;background:#8a0303!important">SIGN IN</button>
                                                            
                           </div> 
                           <div class="clear"></div>
                         <div class="custom-control custom-checkbox mt-3" align="left" style="" >
                                 <!--<input type="checkbox" class="custom-control-input" id="customCheck">-->
                                 
                                 <!--<label class="custom-control-label" for="customCheck">Remember Me</label>-->
                                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
								<label class="form-check-label nv" for="remember">
									{{ __('Keep me signed in') }}
								</label>
                              </div>  
                          <hr style="color:#1e1e1e;">
                           <div class="mt-3">
                              <div class=" justify-content-center links">
                                 To Content Partner Portal <a href="<?= URL::to('/cpp/signup')?>" class="text-primary ml-2">Sign Up </a> Here!
                              </div>                        
                           </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
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



