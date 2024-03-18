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
    <title>{{ __('login-OTP') }} | <?php echo $settings->website_name; ?></title>
    <!--<script type="text/javascript" src="<?php echo URL::to('/') . '/assets/js/jquery.hoverplay.js'; ?>"></script>-->
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
    <!-- Bootstrap CSS -->
    <link rel="preload" href="assets/css/bootstrap.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    </noscript>
    <link rel="stylesheet" href="" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= typography_link() ?>" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= style_sheet_link() ?>" />
    <!-- Responsive -->
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .reveal {
            margin-left: -57px;
            height: 45px !important;
            background: #ED553B !important;
            color: #fff !important;
            position: absolute;
            right: 0px;
            border-radius: 0 !important;
            top: -61px;
        }

        .sign-in-page .btn {
            border-radius: 0 !important;
        }

        h3 {
            font-size: 30px !important;
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
        }

        .signcont {}

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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance:textfield; /*This is for firefox*/
        }
    </style>
</head>

<body>
    <section class="sign-in-page"
        style="background:url('<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
        <div class="container">
            <div class="row mb-4  align-items-center height-self-center">
                <div class="col-lg-7  col-12">

                    <h1 class="km"><?php echo $settings->login_text; ?></h1>

                </div>
                <div class="col-lg-5 col-12 col-md-12 align-self-center">
                    <div class="sign-user_card ">
                        <div class="sign-in-page-data">
                            <div class="sign-in-from  m-auto" align="center">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">

                                        <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                        <img alt="apps-logo" class="apps" src="<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->light_mode_logo; ?>">
                                    </div>
                                </div>
                                <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?>
                                <img alt="apps-logo" class="apps" src="<?php echo URL::to('/') . '/public/uploads/settings/' . $theme->dark_mode_logo; ?>">
                            </div>
                        </div>
                        <?php }else { ?>
                        <img alt="apps-logo" class="apps" src="<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->logo; ?>">
                    </div>
                </div>
                <?php } ?>
                <br>


                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-success">{{ Session::get('message') }}</div>
                @endif


                <form method="post" action="{{ route('auth.otp.sending-otp') }}" class="mt-4">
                    
                    @csrf
                    <input type="hidden" name="previous" value="{{ url()->previous() }}">

                    <div class="form-group">
                        
                        <input id="mobile" type="number" class="form-control" name="mobile" placeholder="{{ __('Mobile Number') }}" value="{{ old('mobile') }}" autocomplete="email" autofocus required>
                    </div>

                        {{-- Mobile exist Status --}}
                    <span class="mob_exist_status"> </span>

                    <div class="d-flex justify-content-end links">
                        <a href="{{ route('login') }}" class="f-link">{{ __('Login vai E-Mail').' ?' }}</a> &nbsp; &nbsp;
                        <a href="{{ route('Reset_Password') }}" class="f-link">{{ __('Forgot your password') . ' ?' }}</a>
                    </div>

                    {{-- reCAPTCHA  --}}
                    @if (get_enable_captcha() == 1)
                        <div class="form-group text-left" style="  margin-top: 30px;">
                            {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    @endif

                    <div class="sign-info">
                        <button type="submit" class="btn btn-hover ab" id="send_otp_button" style="width:100%;color:#fff!important;" disabled >{{ __('SEND OTP') }}</button>
                    </div>

                    <hr style="color:#1e1e1e;">

                    <div class="soc mb-3">
                        <div class="d-flex align-items-center">
                            @if ((@$system_settings != null && @$system_settings->facebook == 1) || @$system_settings->google == 1)
                                <div>
                                    <p class="links">{{ __('Login with using') . ':' }}</p>
                                </div>
                            @endif

                            @if (@$system_settings != null && @$system_settings->facebook == 1)
                                <div>
                                    <a href="{{ url('/auth/redirect/facebook') }}" class="">
                                        <img alt="apps-logo" src="<?php echo URL::to('/') . '/assets/img/fb.png'; ?>" width="30"
                                            style="margin-bottom:1rem;"></a>
                                </div>
                            @endif

                            @if (@$system_settings != null && @$system_settings->google == 1)
                                <div>
                                    <a href="{{ url('/auth/redirect/google') }}" class="">
                                        <img alt="apps-logo" src="<?php echo URL::to('/') . '/assets/img/google.png'; ?>" width="30"
                                            style="margin-bottom:1rem;">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                </form>
                <div class="">
                    <div class="text -left links">
                        {{ __("Don't have an account?") }} <a href="{{ route('signup') }}"
                            class="text-primary ml-2">{{ __('Sign Up here!') }}</a>
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
    <script defer src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 5000);
        })
    
        $(document).ready(function() {

                        
            $( "#mobile" ).on( "keyup", function() {

                let mobileNumber = $('#mobile').val();
                $('.mob_exist_status').text("");

                if( mobileNumber !== "" ){

                    $.ajax({
                        url: "{{ route('auth.otp.check-mobile-exist') }}",
                        type: "get",
                        data: { mobile: mobileNumber },
                        dataType: "json",

                        success: function(response) {
                            if (response.exists) {
                                document.getElementById("send_otp_button").removeAttribute("disabled");

                                $('.mob_exist_status').text("Mobile Number exists!").css('color', 'green');;

                            } else {
                                document.getElementById("send_otp_button").setAttribute("disabled", "disabled");

                                $('.mob_exist_status').text("Mobile Number not exists !").css('color', 'red');
                            }
                        },
                        error: function(error) {
                            console.error('AJAX error:', error);
                        }
                    });
                }

            } );
        });
    </script>

</body>

@php
    include public_path('themes/default/views/footer.blade.php');
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
