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
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/bootstrap.min.css" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/typography.css" />
    <!-- Style -->
      <link rel="stylesheet" href="<?= style_sheet_link()?>" />

    <!-- Responsive -->
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/responsive.css" />
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
        .sign-user_card{
            background: rgba(11, 11, 11, 0.75)!important;
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
    .demo_cred {
        background: #5c5c5c69;
        padding: 15px;
        border-radius: 15px;
        border: 2px dashed #51bce8;
        text-align: left;
    }    
</style>
</head>

<body>
    <section class="sign-in-page" style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
        <div class="container">
            <div class="row  align-items-center height-self-center">
                <div class="col-lg-3  col-12">
                </div>
                <div class="col-lg-5 col-12 col-md-12 align-self-center">

                    <div class="sign-user_card ">                    
                        <div class="sign-in-page-data">
                            <div class="sign-in-from  m-auto" align="center">
                                <div align="center">
                                  <img class="" src="{{ $settings->logo ? URL::to('/public/uploads/settings/'.$settings->logo ) : URL::to('/public/uploads/settings/'.$settings->default_video_image) }}" style="margin-bottom:1rem;" width="200px" height="100px">       
                                  <h3 class="mb-3 text-center">Advertiser Sign In</h3>
                                </div>
                                <form method="POST" action="{{ url('advertiser/post-login') }}" class="mt-4" autocomplete="off">
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
                                        <input id="email_id" type="text" class="form-control @error('email_id') is-invalid @enderror" name="email_id" placeholder="{{ __('E-Mail') }}" value="{{ old('email_id') }}" required autocomplete="email_id" autofocus style="width: 90% !important;">
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password" style="width: 91%; display: inline-block;">
                                        <div class="position-relative">
                                            <button 
                                                class="btn btn-default reveal" 
                                                onclick="visibility1()" 
                                                type="button" 
                                                style="position: absolute;background: none; border: none; padding: 0;color:#fff;bottom:32px;right:33px;box-shadow:none;"
                                            >
                                                <i id="toggleIcon" class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    

                                    <div class="sign-info">
                                        <button type="submit" class="btn btn-hover" style="width:100%;color:#fff!important;margin: 0 20px;">SIGN IN</button>

                                    </div> 
                            <div class="mt-2 d-flex justify-content-end  links" style="width: 92%">
                                <a href="{{ url('advertiser/forget-password') }}" class="text-primary ml-2">Reset Password </a>
                            </div>
                                    <hr style="color:#1e1e1e;">

                                </form>
                                 <div class="d-flex justify-content-center  links">
                                Don't have an account? <a href="{{ url('advertiser/register') }}" class="text-primary ml-2">Sign Up</a>
                            </div>
                            </div>
                        </div>
                        <div class="">
                           
                           

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

        });
    </script>


    <script>
        function visibility1() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = "text";
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
@php
    include('packages/webnexs/avod/src/views/ads_footer.blade.php')
@endphp
<!-- jQuery, Popper JS -->
<script src="{{URL::to('/')}}/assets/js/jquery-3.4.1.min.js"></script>
<script src="{{URL::to('/')}}/assets/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="{{URL::to('/')}}/assets/js/bootstrap.min.js"></script>
<!-- Slick JS -->
<script src="{{URL::to('/')}}/assets/js/slick.min.js"></script>
<!-- owl carousel Js -->
<script src="{{URL::to('/')}}/assets/js/owl.carousel.min.js"></script>
<!-- select2 Js -->
<script src="{{URL::to('/')}}/assets/js/select2.min.js"></script>
<!-- Magnific Popup-->
<script src="{{URL::to('/')}}/assets/js/jquery.magnific-popup.min.js"></script>
<!-- Slick Animation-->
<script src="{{URL::to('/')}}/assets/js/slick-animation.min.js"></script>
<!-- Custom JS-->
<script src="{{URL::to('/')}}/assets/js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript">
<?php if(session('success')){ ?>
    toastr.success("<?php echo session('success'); ?>");
<?php }else if(session('error')){  ?>
    toastr.error("<?php echo session('error'); ?>");
<?php }else if(session('warning')){  ?>
    toastr.warning("<?php echo session('warning'); ?>");
<?php }else if(session('info')){  ?>
    toastr.info("<?php echo session('info'); ?>");

<?php } ?>

</script>
</html>

