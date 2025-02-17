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
    <title>Content Partner Login | <?php echo $settings->website_name ; ?></title>
    <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css'; ?>" />
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css" /> -->
    <!-- Typography CSS -->
    <!-- <link rel="stylesheet" href="assets/css/typography.css" /> 
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/typography.css'; ?>" /> -->
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= typography_link()?>" />
    <!-- Style -->
    <!-- <link rel="stylesheet" href="assets/css/style.css" /> -->
    <link rel="stylesheet" href="<?= style_sheet_link() ;?>" />
    <!-- Responsive -->
    <!-- <link rel="stylesheet" href="assets/css/responsive.css" /> -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/responsive.css'; ?>" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
    .links,.nv{color:#fff}
    .nv,a.f-link{font-size:14px}
    h3{font-size:30px!important}
    .from-control::placeholder{color:#7b7b7b!important}
    .km{text-align:center;font-size:75px;font-weight:900}
    a.f-link{margin-bottom:1rem}
    .d-inline-block{display:block!important}
    i.fa.fa-google-plus{padding:10px!important}
    .sign-in-from{margin:0 auto;display:block; text-align: center;}
    .reveal{margin-left:-57px;height:45px!important;background:#ed553b!important;
    color:#fff!important;position:absolute;right:0;border-radius:0!important;top:-61px;}
    .sign-in-page .btn {border: 0 !important;}
    body{background: #000;}
</style>
</head>
<body>
<section class="sign-in-page" style="background:black;background-size: cover;">
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
                  <div class="sign-in-from  m-auto">
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
                            <div class="position-relative">
                                 <span class="input-group-btn" id="eyeSlash">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                 </span>
                                 <span class="input-group-btn" id="eyeShow" style="display: none;">
                                   <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                 </span>
                            </div>
                        </div>
                         <div class="d-flex justify-content-end links">
                      @if (Route::has('password.request'))
                     <a href="{{  URL::to('cpp/password/reset') }}" class="f-link">Forgot your password?</a>
                      @endif
							
                  </div>
                        
                           <div class="sign-info">
                              <button type="submit" class="btn  ab" style="width:100%;color:#fff!important;">SIGN IN</button>
                                                            
                           </div> 
                           <div class="clear"></div>
                         <div class="custom-control custom-checkbox mt-3 text-left" style="" >
                                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
								<label class="form-check-label nv" for="remember">
									{{ __('Keep me signed in') }}
								</label>
                              </div>  
                          <hr style="color:#1e1e1e;">
                           <div class="mt-3">
                              <div class=" justify-content-center links">
                                 Become a Content Partner! <a href="<?= URL::to('/cpp/signup')?>" class="text-primary ml-2">Sign Up </a> Here!
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
{{-- Footer --}}
@php
    include(public_path('themes/theme3/views/footer.blade.php'));
@endphp
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