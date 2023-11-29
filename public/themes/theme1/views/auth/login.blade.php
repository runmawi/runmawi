<?php
    $settings = App\Setting::find(1);
    $system_settings = App\SystemSetting::find(1);

    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();

    @$translate_language = App\Setting::pluck('translate_language')->first();
    \App::setLocale(@$translate_language);
?>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Login') }} | <?php echo $settings->website_name; ?></title>
    <!--<script type="text/javascript" src="<?php echo URL::to('/') . '/assets/js/jquery.hoverplay.js'; ?>"></script>-->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Chivo&family=Lato&family=Open+Sans:wght@473&family=Yanone+Kaffeesatz&display=swap"
        rel="stylesheet">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme1/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Typography CSS -->
    <link href="<?php echo URL::to('public/themes/theme1/assets/css/typography.css'); ?>" rel="stylesheet">
    <!-- Style -->
    <link href="<?php echo URL::to('public/themes/theme1/assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo URL::to('public/themes/theme1/assets/css/responsive.css'); ?>" rel="stylesheet">

    <!-- Responsive -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
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

        .in {

            font-size: 48px;
            line-height: 57px;
            font-weight: 900;
            color: #fff;

        }

        .input-icons i {
            position: absolute;
            left: 60px;
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
            padding: 10px;
            height: 59px;
            padding-left: 55px;
        }


        .signcont {}

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

        .form-control::-moz-placeholder {
            color: #fff !important;
            opacity: 1;
        }

        .form-control:-ms-input-placeholder {
            color: #999;
        }

        .form-control::-webkit-input-placeholder {
            color: #999;
        }

        .sign-in-page {
            background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%) !important;
            padding: 40px;
            padding-top: 100px;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <section class="sign-in-page"
        style="background:url('<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
        <div class="container">
            <div class="row  align-items-center justify-content-center height-self-center">
                <div class="col-lg-6 col-12 col-md-12 align-self-center">
                    <div class="text-center">

                        <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                            <img  src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo ; ?>"  style="margin-bottom:1rem;">
                        <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                            <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo ; ?>"  style="margin-bottom:1rem;">
                        <?php }else { ?> 
                            <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;">
                        <?php } ?>

                    </div>
                    <div class="sign-user_card "
                        style=" background: linear-gradient(rgba(136, 136, 136, 0.1) , rgba(64, 32, 32, 0.13), rgba(81, 57, 57, 0.12));!important;">
                        <div class="sign-in-page-data">
                            <div class="sign-in-from  m-auto" align="center">
                                <h1 class="in mt-3">{{ __('SIGN IN') }}</h1>
                                <?php 
                                if($settings->demo_mode == 1) { ?>
                                <div class="demo_cred">
                                    <p class="links" style="font-weight: 600; border-bottom: 2px dashed #fff;">{{ __('Demo Login') }}</p>
                                    <p class="links"><strong>{{ __('Email') }}</strong>: admin@admin.com</p>
                                    <p class="links mb-0"><strong>{{ __('Password') }}</strong>: Webnexs123!@#</p>
                                </div>
                                <?php } else  { } ?>

                                @if (Session::has('message'))
                                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}
                                    </div>
                                @endif

                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $message)
                                        <div class="alert alert-danger display-hide" id="successMessage">
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
                                        <div class="input-icons">
                                            <i class="">
                                                <img class=" fa fa-user icon mr-3" src="<?php echo URL::to('/') . '/assets/img/uss.png'; ?>"> </i>
                                            <input id="email" type="email"
                                                class=" input-field form-control @error('email') is-invalid @enderror"
                                                name="email" placeholder="{{ __('USER NAME') }}"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group" style="  margin-top: 30px;">
                                        <div class="input-icons">
                                            <i class=""><img class=" fa fa-user icon mr-3"
                                                    src="<?php echo URL::to('/') . '/assets/img/lock.png'; ?>">
                                            </i>

                                            <input id="password" type="password"
                                                class="input-field  form-control @error('password') is-invalid @enderror"
                                                placeholder="{{ __('PASSWORD') }}" name="password" required
                                                autocomplete="current-password">
                                        </div>
                                    </div>

                                    <div class="links text-right">
                                        <a href="{{ route('Reset_Password') }}" class="f-link">{{ __("Can't Login") }}?</a>
                                    </div>

                                    {{-- reCAPTCHA  --}}
                                    @if (get_enable_captcha() == 1)
                                        <div class="form-group text-left" style="  margin-top: 30px;">
                                            {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                            {!! NoCaptcha::display() !!}
                                        </div>
                                    @endif

                                    <div class="sign-info mt-3">
                                        <button type="submit" class="btn signup"
                                            style="width:100%;color:#fff!important;letter-spacing: 3.5px;font-size:20px;">{{ __('LOGIN') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-center  links">
                            <p class="text-primary text-white ml-2">{{ __('Not having an Account ? Click') }} <a class="sig"
                                    href="{{ route('signup') }}">{{ __('Here') }}</a> {{ __('to Sign Up') }}! </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        })
    </script>
</body>

@php
    @include public_path('themes\theme1\views\footer.blade.php');
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
