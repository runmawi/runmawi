<?php
    $settings = App\Setting::find(1);
    $system_settings = App\SystemSetting::find(1);

    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();
    
    $translate_checkout = App\SiteTheme::pluck('translate_checkout')->first();

    @$translate_language = App\Setting::pluck('translate_language')->first();

    $website_default_language = App\Setting::pluck('website_default_language')->first() ? App\Setting::pluck('website_default_language')->first() : 'en';

    $AdminOTPCredentials =  App\AdminOTPCredentials::where('status',1)->first();
    
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   
    $country_json_data = json_decode($jsonString, true);
    
    usort($country_json_data, function ($a, $b) {
        return strcmp($a['code'], $b['code']);
    });

    
    if(Auth::guest()){
       $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
       $userIp = $geoip->getip();
       $UserTranslation = App\UserTranslation::where('ip_address',$userIp)->first();

       if(!empty($UserTranslation)){
           $translate_language = GetWebsiteName().$UserTranslation->translate_language;
       }else{
           $translate_language = GetWebsiteName().@$website_default_language;
       }
   }else if(!Auth::guest()){

       $subuser_id=Session::get('subuser_id');
       if($subuser_id != ''){
           $Subuserranslation = App\UserTranslation::where('multiuser_id',$subuser_id)->first();
           if(!empty($Subuserranslation)){
               $translate_language = GetWebsiteName().$Subuserranslation->translate_language;
           }else{
               $translate_language = GetWebsiteName().@$website_default_language;
           }
       }else if(Auth::user()->id != ''){
           $UserTranslation = App\UserTranslation::where('user_id',Auth::user()->id)->first();
           if(!empty($UserTranslation)){
               $translate_language = GetWebsiteName().$UserTranslation->translate_language;
           }else{
               $translate_language = GetWebsiteName().@$website_default_language;
           }
       }else{
           $translate_language = GetWebsiteName().@$website_default_language;
       }

   }else{
       $translate_language = GetWebsiteName().@$website_default_language;
   }

    \App::setLocale(@$translate_language);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ __('Login') }} | <?php echo $settings->website_name ; ?></title>

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
        <link rel="stylesheet" href="assets/css/responsive.css" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
        </script>

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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        .page-wrapper {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .sign-in-page {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 15px;
            position: relative;
            margin: 0;
            flex: 1;
            min-height: 0;
        }

        .footer {
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 1.5rem 0;
            position: relative;
            z-index: 10;
            flex-shrink: 0;
            margin-top: auto;
        }
        
        .footer .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
            margin: 0 auto;
            max-width: 100%;
        }
        
        .sign-in-page .card {
            max-width: 100%;
            width: 100%;
        }

        /* Enhanced OTP Input Styling */
        .otp-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
        }

        .otp-input-fields {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .otp-input-fields input {
            width: 60px;
            height: 60px;
            border: 2px solid #ddd;
            border-radius: 8px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            outline: none;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            color: #ecececff;
        }

        .otp-input-fields input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background: #fff;
        }

        .otp-input-fields input:valid {
            border-color: #28a745;
        }

        .otp-input-fields input::-webkit-outer-spin-button,
        .otp-input-fields input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input-fields input[type=number] {
            -moz-appearance: textfield;
        }

        /* TV/Large Screen Optimizations */
        @media (min-width: 1200px) {
            .otp-input-fields input {
                width: 80px;
                height: 80px;
                font-size: 32px;
                margin: 0 5px;
            }
            
            .sign-user_card {
                min-width: 600px;
            }
        }

        /* Mobile Optimizations */
        @media (max-width: 768px) {
            .otp-input-fields {
                gap: 8px;
            }
            
            .otp-input-fields input {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }

        /* Form Styling */
        .mobile-input-group {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
        }

        .mobile-input-group .form-control {
            border-radius: 6px;
            border: 2px solid #ddd;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .mobile-input-group .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .country-select {
            flex: 0 0 120px;
        }

        .mobile-input {
            flex: 1;
        }

        .refresh-btn {
            flex: 0 0 50px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border: 2px solid #ddd;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background: #e9ecef;
            border-color: #007bff;
        }

        /* Status Messages */
        .status-message {
            margin: 10px 0;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
        }

        .status-success {
            background: rgba(40, 167, 69, 0.1);
            color: #155724;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-error {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        /* Button Enhancements */
        .btn-primary-custom {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 6px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary-custom:hover:not(:disabled) {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .btn-primary-custom:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .step {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
            color: #fff;
            position: relative;
            padding: 20px !important;
        }

        .step.active {
            background: #007bff;
        }

        .step.completed {
            background: #28a745;
        }

        .step.inactive {
            background: #6c757d;
        }


        .step:last-child::after {
            display: none;
        }

        /* Animation for form transitions */
        .form-step {
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
        }

        .form-step.active {
            opacity: 1;
            transform: translateX(0);
        }

        /* Other existing styles */
        .reveal{
            margin-left: -57px;
            height: 45px !important;
            background: #ED553B !important;
            color: #fff !important;
            position: absolute;
            right: 0px;
            border-radius: 0!important;
            top: -61px;
        }
        
        .sign-in-page .btn{
            border-radius: 6px!important;
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
        
        footer.py-4.mt-5{
            margin-top: 0 !important;
        } 
        
        .sign-in-page{background: #000;}
        
        .btn.disabled, .btn:disabled { 
            cursor: not-allowed;
        }

        /* Countdown Timer */
        .countdown-timer {
            color: #007bff;
            font-weight: bold;
            margin-left: 10px;
        }

        .resend-link {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .resend-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .resend-link.disabled {
            color: #6c757d;
            cursor: not-allowed;
            pointer-events: none;
        }
        </style>
    </head>

    @php
        $login_bg_img = $settings->login_content;
        $login_bgimg = $login_bg_img == 'Landban.png' ? false : true;
    @endphp

    <body>
        <div class="page-wrapper">
            @if($login_bgimg)
                <section class="sign-in-page" style="background:url('{{ asset('public/uploads/settings/' . $settings->login_content) }}') no-repeat center center fixed; background-size: cover; width: 100%;">
                    <div class="overlay"></div>
            @else
                <section class="sign-in-page bg-set">
            @endif
        
        <div class="container">
            <div class="row mb-4 align-items-center height-self-center">
                <div class="col-lg-7 col-12 mb-4">
                    <h1 class="km"><?php echo $settings->login_text; ?></h1>
                </div>
                <div class="col-lg-5 col-12 col-md-12 align-self-center">
                    <div class="sign-user_card">                    
                        <div class="sign-in-page-data">
                            <div class="sign-in-from m-auto" align="center">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">

                                        <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                            <img alt="apps-logo" class="apps" src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo ; ?>">
                                        <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                                            <img alt="apps-logo" class="apps" src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo ; ?>">
                                        <?php }else { ?> 
                                            <img alt="apps-logo" class="apps" src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>">
                                        <?php } ?>

                                        <?php if($settings->demo_mode == 1) { ?>
                                            <div class="demo_cred">
                                                <p class="links" style="font-weight: 600; border-bottom: 2px dashed #fff;">{{ __('Demo Login') }}</p>
                                                <p class="links"><strong>{{ __('Email') }}</strong>: admin@admin.com</p>
                                                <p class="links mb-0"><strong>{{ __('Password') }}</strong>: Webnexs123!@#</p>
                                            </div>
                                        <?php } ?>

                                        @if (Session::has('message'))
                                            <div id="successMessage" class="alert alert-success">{{ Session::get('message') }}</div>
                                        @endif
                                        
                                        @if(count($errors) > 0)
                                            @foreach( $errors->all() as $message )
                                                <div class="alert alert-danger display-hide" id="successMessage">
                                                    <button id="successMessage" class="close" data-close="alert"></button>
                                                    <span>{{ $message }}</span>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if (@$AdminOTPCredentials->status == 1)
                                            <!-- Step Indicator -->
                                            <div class="step-indicator">
                                                <div class="step active" id="step1">1</div>
                                                <div class="step inactive" id="step2">2</div>
                                            </div>

                                            <!-- Mobile Number Form -->
                                            <form id="mobileForm" class="form-step active mt-4">
                                                <h5 class="text-white mb-3">{{ __('Enter Your Mobile Number') }}</h5>
                                                
                                                <div class="mobile-input-group">
                                                    <select class="form-control country-select" id="ccode" name="ccode" required>
                                                        @foreach($country_json_data as $code)
                                                            <option value="{{ $code['dial_code'] }}" {{ $code['name'] == "India" ? 'selected' : ''}}>
                                                                {{ $code['code'] }} ({{ $code['dial_code'] }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                    <input id="mobile" type="tel" class="form-control mobile-input" name="mobile" 
                                                           placeholder="{{ __('Mobile Number') }}" autofocus required 
                                                           pattern="\d*" maxlength="15" inputmode="numeric">
                                                    
                                                    <!-- <a href="{{ route('login') }}" class="refresh-btn">
                                                        <img src="{{ URL::to('public/img/refresh.svg') }}" alt="Refresh" width="24">
                                                    </a> -->
                                                </div>

                                                <div class="status-message" id="mobileStatus" style="display: none;"></div>
                                                
                                                <div class="mt-3" style="text-align: left;">
                                                    <input type="checkbox" checked style="pointer-events: none;">
                                                    <label class="form-check-label text-white" for="remember">{{ __('Send OTP to Mobile') }}</label>
                                                </div>  

                                                <div class="text-center mt-3">
                                                    <button type="button" class="btn btn-primary-custom w-100" id="sendOtpBtn">
                                                        {{ __('SEND OTP') }}
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- OTP Verification Form -->
                                            <form id="otpForm" class="form-step mt-4" style="display: none;">
                                                <h5 class="text-white mb-3">{{ __('Enter Verification Code') }}</h5>
                                                <p class="text-white-50 mb-4">{{ __('We sent a 4-digit code to your mobile number') }}</p>
                                                
                                                <div class="otp-container">
                                                    <div class="otp-input-fields">
                                                        <input type="text" class="otp__digit" id="otp1" name="otp_1" maxlength="1" pattern="\d" inputmode="numeric">
                                                        <input type="text" class="otp__digit" id="otp2" name="otp_2" maxlength="1" pattern="\d" inputmode="numeric">
                                                        <input type="text" class="otp__digit" id="otp3" name="otp_3" maxlength="1" pattern="\d" inputmode="numeric">
                                                        <input type="text" class="otp__digit" id="otp4" name="otp_4" maxlength="1" pattern="\d" inputmode="numeric">
                                                    </div>
                                                    
                                                    <div class="status-message" id="otpStatus" style="display: none;"></div>
                                                    
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary-custom w-100" id="verifyOtpBtn" disabled>
                                                            {{ __('Verify OTP') }}
                                                        </button>
                                                    </div>

                                                    <div class="text-center mt-3">
                                                        <span class="text-white-50">{{ __("Didn't receive code?") }}</span>
                                                        <a href="#" class="resend-link" id="resendOtpBtn">{{ __('Resend OTP') }}</a>
                                                        <span class="countdown-timer" id="countdownTimer" style="display: none;"></span>
                                                    </div>

                                                    <div class="text-center mt-2">
                                                        <button type="button" class="btn btn-link text-white" id="backToMobileBtn">
                                                            {{ __('← Change Mobile Number') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                        @else
                                            <!-- Email Login Form -->
                                            <form method="POST" id="email-login-form" action="{{ route('login') }}" class="mt-4">
                                                @csrf

                                                <input type="hidden" name="previous" value="{{ url()->previous() }}">
                                    
                                                <div class="form-group">
                                                    <input id="email" type="email" class="form-control login-inputs-data @error('email') is-invalid @enderror" 
                                                           name="email" placeholder="{{ __('Enter Your E-Mail') }}" value="{{ old('email') }}" 
                                                           autocomplete="email" autofocus>
                                                </div>
                                        
                                                <div class="form-group mt-4">                            
                                                    <input id="password" type="password" class="form-control login-inputs-data @error('password') is-invalid @enderror" 
                                                           placeholder="{{ __('Password') }}" name="password" autocomplete="current-password">
                                                </div>
                                                
                                                <div class="position-relative">        
                                                    <span class="input-group-btn" id="eyeSlash">
                                                        <button class="btn btn-default reveal" onclick="visibility1()" type="button">
                                                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                        </button>
                                                    </span>

                                                    <span class="input-group-btn" id="eyeShow" style="display: none;">
                                                        <button class="btn btn-default reveal" onclick="visibility1()" type="button">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                        
                                                <div class="d-flex justify-content-end links">     
                                                    <a href="{{ route('Reset_Password') }}" class="f-link">{{ __('Forgot your password').'?' }}</a>
                                                </div>

                                                @if(get_enable_captcha() == 1)   
                                                    <div class="form-group text-left mt-4">
                                                        {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                                        {!! NoCaptcha::display() !!}
                                                    </div>
                                                @endif

                                                <div class="sign-info">
                                                    <button type="submit" id="email-login-button" class="btn btn-hover ab" style="width:100%;color:#fff!important;" disabled>
                                                        {{ __('SIGN IN') }}
                                                    </button>             
                                                </div>
                                            </form>

                                            <div class="mt-3" style="text-align: left;">
                                                <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label text-white" for="remember">
                                                    {{ __('Keep me signed in') }}
                                                </label>
                                            </div>  
                                        @endif

                                        <hr style="color:#1e1e1e;">
                                        
                                        <div class="soc mb-3">
                                            <div class="d-flex align-items-center">
                                                <?php if(@$system_settings != null && @$system_settings->facebook == 1 || @$system_settings->google == 1){ ?>
                                                    <div>
                                                        <p class="links">{{ __('Login with using').':' }}</p>
                                                    </div>
                                                <?php } ?>
                                                
                                                <?php if(@$system_settings != null && @$system_settings->facebook == 1){ ?>
                                                    <div>
                                                        <a href="{{ url('/auth/redirect/facebook') }}" class="">
                                                            <img alt="apps-logo" src="<?php echo URL::to('/').'/assets/img/fb.png'; ?>" width="30" style="margin-bottom:1rem;">
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                                
                                                <?php if(@$system_settings != null && @$system_settings->google == 1 ){ ?>
                                                    <div>
                                                        <a href="{{ url('/auth/redirect/google') }}" class="">
                                                            <img alt="apps-logo" src="<?php echo URL::to('/').'/assets/img/google.webp'; ?>" width="30" style="margin-bottom:1rem;">
                                                        </a>
                                                    </div>
                                                <?php  } ?>
                                            </div>
                                        </div>

                                        <div class="text-left links">
                                            {{ __("Don't have an account?") }} 
                                            <a href="{{ route('signup') }}" class="text-primary ml-2" style="font-weight: 600">{{ __('Sign Up Here!') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            @php
                include(public_path('themes/default/views/footer.blade.php'));
            @endphp
        </footer>
        </div>

        <style>
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1;
            }
            .container {
                position: relative;
                z-index: 2;
            }
        </style>

        <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script defer src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>     

        <script>
            $(document).ready(function() {
                // Theme handling
                var theme_change = "{{ $theme_mode }}";
                var bg_img_check = "{{ $login_bgimg ? 'true' : 'false' }}";
                
                if(theme_change === 'dark' && bg_img_check === 'false'){
                    $(".bg-set").css("background", "#000");
                    $(".km").css("color", "#fff");
                } else if(theme_change === 'light' && bg_img_check === 'false'){
                    $(".bg-set").css("background", "#fff");
                    $(".km").css("color", "#000");
                }

                // Hide success messages after 5 seconds
                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 5000);

                // Enhanced OTP Input Handling
                const otpInputs = document.querySelectorAll('.otp__digit');
                let countdownInterval;
                let resendTimeout;

                // Initialize OTP inputs
                otpInputs.forEach((input, index) => {
                    input.addEventListener('input', function(e) {
                        // Only allow digits
                        this.value = this.value.replace(/[^0-9]/g, '');
                        
                        if (this.value.length === 1) {
                            // Move to next input
                            if (index < otpInputs.length - 1) {
                                otpInputs[index + 1].focus();
                            }
                        }
                        
                        checkOTPComplete();
                    });

                    input.addEventListener('keydown', function(e) {
                        // Handle backspace
                        if (e.key === 'Backspace' && this.value === '' && index > 0) {
                            otpInputs[index - 1].focus();
                        }
                        
                        // Handle arrow keys for TV navigation
                        if (e.key === 'ArrowLeft' && index > 0) {
                            e.preventDefault();
                            otpInputs[index - 1].focus();
                        }
                        
                        if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                            e.preventDefault();
                            otpInputs[index + 1].focus();
                        }

                        // Handle paste
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            if ($('#verifyOtpBtn').is(':enabled')) {
                                $('#verifyOtpBtn').click();
                            }
                        }
                    });

                    // Handle paste event
                    input.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const paste = (e.clipboardData || window.clipboardData).getData('text');
                        const digits = paste.replace(/[^0-9]/g, '').slice(0, 4);
                        
                        for (let i = 0; i < digits.length && i < otpInputs.length; i++) {
                            otpInputs[i].value = digits[i];
                        }
                        
                        // Focus on next empty input or last filled input
                        const nextEmptyIndex = Array.from(otpInputs).findIndex(inp => inp.value === '');
                        if (nextEmptyIndex !== -1) {
                            otpInputs[nextEmptyIndex].focus();
                        } else {
                            otpInputs[otpInputs.length - 1].focus();
                        }
                        
                        checkOTPComplete();
                    });
                });

                function checkOTPComplete() {
                    const allFilled = Array.from(otpInputs).every(input => input.value.length === 1);
                    $('#verifyOtpBtn').prop('disabled', !allFilled);
                }

                function clearOTP() {
                    otpInputs.forEach(input => input.value = '');
                    otpInputs[0].focus();
                    $('#verifyOtpBtn').prop('disabled', true);
                }

                function showMessage(elementId, message, type) {
                    const element = $(elementId);
                    element.removeClass('status-success status-error');
                    element.addClass(type === 'success' ? 'status-success' : 'status-error');
                    element.text(message).show();
                }

                function hideMessage(elementId) {
                    $(elementId).hide();
                }

                function startCountdown(seconds) {
                    let timeLeft = seconds;
                    $('#resendOtpBtn').addClass('disabled');
                    $('#countdownTimer').show().text(`(${timeLeft}s)`);
                    
                    countdownInterval = setInterval(() => {
                        timeLeft--;
                        $('#countdownTimer').text(`(${timeLeft}s)`);
                        
                        if (timeLeft <= 0) {
                            clearInterval(countdownInterval);
                            $('#resendOtpBtn').removeClass('disabled');
                            $('#countdownTimer').hide();
                        }
                    }, 1000);
                }

                function switchToOTPStep() {
                    $('#step1').removeClass('active').addClass('completed');
                    $('#step2').removeClass('inactive').addClass('active');
                    $('#mobileForm').removeClass('active').hide();
                    $('#otpForm').addClass('active').show();
                    $('#mobile, #ccode').prop('readonly', true);
                    clearOTP();
                    startCountdown(60); // 60 second countdown
                }

                function switchToMobileStep() {
                    $('#step1').removeClass('completed').addClass('active');
                    $('#step2').removeClass('active').addClass('inactive');
                    $('#otpForm').removeClass('active').hide();
                    $('#mobileForm').addClass('active').show();
                    $('#mobile, #ccode').prop('readonly', false);
                    hideMessage('#otpStatus');
                    hideMessage('#mobileStatus');
                    clearInterval(countdownInterval);
                    $('#countdownTimer').hide();
                    $('#resendOtpBtn').removeClass('disabled');
                }

                // Mobile validation and OTP sending
                function validateMobile() {
                    const mobile = $('#mobile').val().trim();
                    const ccode = $('#ccode').val();
                    
                    if (mobile.length < 8 && mobile.length > 1) {
                        showMessage('#mobileStatus', 'Please enter a valid mobile number', 'error');
                        $('#sendOtpBtn').prop('disabled', true);
                        return false;
                    }
                    
                    hideMessage('#mobileStatus');
                    $('#sendOtpBtn').prop('disabled', false);
                    return true;
                }

                // Event handlers
                $('#mobile, #ccode').on('input change', function() {
                    validateMobile();
                });

                $('#mobile').on('keypress', function(e) {
                    // Only allow digits
                    if (!/[0-9]/.test(String.fromCharCode(e.which))) {
                        e.preventDefault();
                    }
                    
                    if (e.which === 13) { // Enter key
                        e.preventDefault();
                        if (!$('#sendOtpBtn').is(':disabled')) {
                            $('#sendOtpBtn').click();
                        }
                    }
                });

                $('#sendOtpBtn').on('click', function() {
                    if (!validateMobile()) return;
                    
                    const mobile = $('#mobile').val().trim();
                    const ccode = $('#ccode').val();
                    
                    $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Sending...');
                    hideMessage('#mobileStatus');

                    $.ajax({
                        url: "{{ route('auth.otp.sending-otp') }}",
                        type: "GET",
                        data: { mobile: mobile, ccode: ccode },
                        dataType: "json",
                        success: function(response) {
                            if (response.exists) {
                                showMessage('#mobileStatus', response.message_note || 'OTP sent successfully!', 'success');
                                setTimeout(() => switchToOTPStep(), 1000);
                            } else {
                                showMessage('#mobileStatus', response.message_note || 'Failed to send OTP', 'error');
                                $('#sendOtpBtn').prop('disabled', false).text('{{ __("SEND OTP") }}');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', error);
                            showMessage('#mobileStatus', 'Network error. Please try again.', 'error');
                            $('#sendOtpBtn').prop('disabled', false).text('{{ __("SEND OTP") }}');
                        }
                    });
                });

                $('#verifyOtpBtn').on('click', function() {
                    const otpValues = Array.from(otpInputs).map(input => input.value).join('');
                    
                    if (otpValues.length !== 4) {
                        showMessage('#otpStatus', 'Please enter complete OTP', 'error');
                        return;
                    }

                    $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Verifying...');
                    hideMessage('#otpStatus');

                    const formData = {
                        otp_1: otpInputs[0].value,
                        otp_2: otpInputs[1].value,
                        otp_3: otpInputs[2].value,
                        otp_4: otpInputs[3].value,
                        mobile: $('#mobile').val(),
                        ccode: $('#ccode').val()
                    };

                    $.ajax({
                        url: "{{ route('auth.otp.otp_verification') }}",
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        success: function(response) {
                            if (response.status === true) {
                                showMessage('#otpStatus', 'OTP verified successfully!', 'success');
                                setTimeout(() => {
                                    window.location.href = "/home";
                                }, 1500);
                            } else {
                                showMessage('#otpStatus', response.message_note || 'Invalid OTP', 'error');
                                clearOTP();
                                $('#verifyOtpBtn').text('{{ __("Verify OTP") }}');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', error);
                            showMessage('#otpStatus', 'Verification failed. Please try again.', 'error');
                            clearOTP();
                            $('#verifyOtpBtn').text('{{ __("Verify OTP") }}');
                        }
                    });
                });

                $('#resendOtpBtn').on('click', function(e) {
                    e.preventDefault();
                    if ($(this).hasClass('disabled')) return;
                    
                    const mobile = $('#mobile').val().trim();
                    const ccode = $('#ccode').val();
                    
                    hideMessage('#otpStatus');
                    
                    $.ajax({
                        url: "{{ route('auth.otp.sending-otp') }}",
                        type: "GET",
                        data: { mobile: mobile, ccode: ccode },
                        dataType: "json",
                        success: function(response) {
                            if (response.exists) {
                                showMessage('#otpStatus', 'OTP resent successfully!', 'success');
                                clearOTP();
                                startCountdown(60);
                            } else {
                                showMessage('#otpStatus', response.message_note || 'Failed to resend OTP', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', error);
                            showMessage('#otpStatus', 'Failed to resend OTP. Please try again.', 'error');
                        }
                    });
                });

                $('#backToMobileBtn').on('click', function() {
                    switchToMobileStep();
                });

                // Email login form validation
                $(".login-inputs-data").on("input", function() {
                    const email = $('#email').val().trim();
                    const password = $('#password').val().trim();
                    $('#email-login-button').prop("disabled", !(email && password));
                });

                $("#email-login-button").on('click', function(e) { 
                    e.preventDefault();
                    $(this).prop("disabled", true); 
                    $("#email-login-form").submit(); 
                });

                // Password visibility toggle
                window.visibility1 = function() {
                    var x = document.getElementById('password');
                    if (x.type === 'password') {
                        x.type = "text";
                        $('#eyeShow').show();
                        $('#eyeSlash').hide();
                    } else {
                        x.type = "password";
                        $('#eyeShow').hide();
                        $('#eyeSlash').show();
                    }
                };

                // reCAPTCHA callback
                window.onloadCallback = function() {};

                // Initialize mobile validation on page load
                validateMobile();
            });
        </script>

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-3.4.1.min.js"><\/script>')</script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/slick.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/jquery.magnific-popup.min.js"></script>
        <script src="assets/js/slick-animation.min.js"></script>
        <script src="assets/js/custom.js"></script>
        <script src="assets/js/jquery.lazy.min.js"></script>

    </body>
</html>