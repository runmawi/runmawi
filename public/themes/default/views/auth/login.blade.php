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
        
        html, body {
            height: 100%;
            margin: 0;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
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
            min-height: 0; /* Allows content to shrink below its minimum height */
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
        
        /* Ensure container-fluid in footer has proper padding */
        .footer .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
            margin: 0 auto;
            max-width: 100%;
        }
        
        /* Ensure content doesn't overflow */
        .sign-in-page .card {
            max-width: 100%;
            width: 100%;
        }

        .otp-input-fields {
            margin: auto;
            max-width: 400px;
            width: auto;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 20px;

            input {
                height: 40px;
                width: 40px;
                border-radius: 4px;
                border: 1px solid #2f8f1f;
                text-align: center;
                outline: none;
                font-size: 16px;

                &::-webkit-outer-spin-button,
                &::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                /* Firefox */
                &[type=number] {
                    -moz-appearance: textfield;
                }
            }
        }

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
            footer.py-4.mt-5{
                margin-top: 0 !important;
            } 
            .sign-in-page{background: #000;}
            .btn.disabled, .btn:disabled { cursor: not-allowed;}
            
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
            <div class="row mb-4  align-items-center height-self-center">
                <div class="col-lg-7  col-12 mb-4">
                    <h1 class="km"><?php echo $settings->login_text; ?></h1>
                </div>
                <div class="col-lg-5 col-12 col-md-12 align-self-center">
                    <div class="sign-user_card ">                    
                    <div class="sign-in-page-data">
                        <div class="sign-in-from  m-auto" align="center">
                            <div class="row justify-content-center">
                                <div class="col-md-12">

                                <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                        <img alt="apps-logo" class="apps"  src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo ; ?>"  ></div></div>
                                    <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                                        <img alt="apps-logo" class="apps"  src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo ; ?>"  ></div></div>
                                    <?php }else { ?> 
                                        <img alt="apps-logo" class="apps"  src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  ></div></div>
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

                                @if (@$AdminOTPCredentials->status == 1)

                                    <form id="otpForm" class="otp-form mt-4" method="get">
                                        <div class="row d-flex">
                                            <div class="col-md-4 col-4 form-group m-0">  {{-- Country Code --}}
                                                <select class="form-control text-center mobile_validation" id="ccode" name="ccode" required>
                                                    @foreach($country_json_data as $code)
                                                        <option value="{{  $code['dial_code'] }}" style="background-color:rgba(0,0,0,0.5)!important;" {{ $code['name'] == "India" ? 'selected' : ''}} > {{ "{$code['code']} ({$code['dial_code']})" }}</option>
                                                    @endforeach
                                                 </select> 
                                            </div>

                                            <div class="col-md-7 col-7 form-group m-0">  {{-- Mobile No --}}
                                                <input id="mobile" type="text" class="form-control mobile_validation" name="mobile" placeholder="{{ __('Mobile Number') }}" autofocus required pattern="\d*" maxlength="15" inputmode="numeric">
                                            </div>
                                            <div class="col-md-1 p-2">  {{-- Refresh--}}
                                                <a href="{{ route('login') }}">
                                                    <img src="{{ URL::to('public/img/refresh.svg') }}" alt="">
                                                </a>
                                            </div>
                                        </div>


                                            {{-- Mobile Exist Status --}}
                                        <span class="mob_exist_status"></span> 
                                        
                                        <div class="mt-3" align="left"  >
                                            <input type="checkbox" checked style="pointer-events: none;">
                                            <label class="form-check-label text-white" for="remember">{{ __('Send OTP to Mobile') }}</label>
                                        </div>  

                                            <div class="otp-div">
                                                <div class="otp-input-fields row">
                                                    <input type="number" class="otp__digit otp__field__1" placeholder="-"  name="otp_1">
                                                    <input type="number" class="otp__digit otp__field__2"  placeholder="-" name="otp_2">
                                                    <input type="number" class="otp__digit otp__field__3"  placeholder="-" name="otp_3">
                                                    <input type="number" class="otp__digit otp__field__4"  placeholder="-" name="otp_4">
                                                    <p class="info otp_send_message"> </p>
                                                </div>
            
                                                <div class="text-center p-1">
                                                    <button type="submit" class="btn btn-hover w-100" id="verify-button" style="line-height:20px" disabled >{{ __('Verify OTP') }}</button>
                                                </div>

                                                <div class="justify-content-end links text-right mt-2">
                                                    <a href="#"  id="resend_otp_button">{{ __('Resend OTP') }}</a>
                                                </div>
                                            </div>
                                    </form>
                                    @if (@$AdminOTPCredentials->status == 0)
                                        <div class="d-flex justify-content-end links">
                                            <a href="{{ route('Reset_Password') }}" class="f-link">{{ __('Forgot your password').'?' }}</a>
                                        </div>
                                    @endif


                                    <button type="submit" class="btn btn-hover ab send_otp_button" id="send_otp_button" onclick=sendOtp() style="width:100%;color:#fff!important;" >{{ __('SEND OTP') }}</button>
                                @else
                                    <form method="POST" id="email-login-form" action="{{ route('login') }}" class="mt-4">
                                        @csrf

                                        <input type="hidden" name="previous" value="{{ url()->previous() }}">
                            
                                        <div class="form-group">  {{-- E-Mail --}}
                                            <input id="email" type="email" class="form-control login-inputs-data @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Enter Your E-Mail') }}" value="{{ old('email') }}" autocomplete="email" autofocus>
                                        </div>
                                
                                        <div class="form-group mt-4">  {{-- Password --}}                            
                                            <input id="password" type="password" class="form-control login-inputs-data @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" autocomplete="current-password">
                                        </div>
                                        
                                        <div class="position-relative"> {{-- eyeSlash --}}        
                                            <span class="input-group-btn" id="eyeSlash">
                                                <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                            </span>

                                            <span class="input-group-btn" id="eyeShow" style="display: none;">
                                                <button class="btn btn-default reveal" onclick="visibility1()" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </span>
                                        </div>
                                
                                        <div class="d-flex justify-content-end links"> {{-- Reset_Password --}}     
                                            <a href="{{ route('Reset_Password') }}" class="f-link">{{ __('Forgot your password').'?' }}</a>
                                        </div>

                                         {{-- reCAPTCHA --}}
                                        @if(get_enable_captcha() == 1)   
                                            <div class="form-group text-left mt-4">
                                                {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                                {!! NoCaptcha::display() !!}
                                            </div>
                                        @endif

                                        <div class="sign-info">
                                            <button type="submit"id="email-login-button" class="btn btn-hover ab" style="width:100%;color:#fff!important;" disabled >{{ __('SIGN IN') }}</button>             
                                        </div>
                                @endif
                            
                        </form>

                        @if (@$AdminOTPCredentials->status == 0)
                            <div class="mt-3" align="left" style="" >
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
                                            <a href="{{ url('/auth/redirect/facebook') }}" class="" >
                                            <img alt="apps-logo" src="<?php echo URL::to('/').'/assets/img/fb.png'; ?>" width="30" style="margin-bottom:1rem;"></a>
                                        </div>
                                    <?php } ?>
                                    
                                        <?php if(@$system_settings != null && @$system_settings->google == 1 ){ ?>
                                            <div>
                                                <a href="{{ url('/auth/redirect/google') }}" class="" >
                                                    <img alt="apps-logo" src="<?php echo URL::to('/').'/assets/img/google.webp'; ?>" width="30" style="margin-bottom:1rem;">
                                                </a>
                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </form>
                            <div class="">
                        <div class="text -left links">
                        {{ __("Don't have an account?") }} <a href="{{ route('signup') }}" class="text-primary ml-2" style="font-weight: 600">{{ __('Sign Up Here!') }}</a>
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
        <script defer src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"async defer></script>     

<script>
    $(globalThis).load(function() {
        var email = $('#email').val().trim();
        var password = $('#password').val().trim();
        // alert(email);

        var loginButton = $('#email-login-button');

        if (email && password) {
            loginButton.prop("disabled", false);
        } else {
            loginButton.prop("disabled", true);
        }
    });
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

            $(document).ready(function(){
                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 5000);

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

            var onloadCallback = function(){ }

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

            // Mobile Exist Check 

            $(document).ready(function() {

                // $(".mobile_validation").on("input", function() {

                //     let mobileNumber = $('#mobile').val();
                //     let ccode = $('#ccode').val();
                    
                //     $('.mob_exist_status').text("");

                //     if( mobileNumber !== "" ){

                //         $.ajax({
                //             url: "{{ route('auth.otp.check-mobile-exist') }}",
                //             type: "get",
                //             data: {
                //                 mobile: mobileNumber,
                //                 ccode: ccode
                //             },
                //             dataType: "json",

                //             success: function(response) {
                //                 if (response.exists) {
                //                     document.getElementById("send_otp_button").removeAttribute("disabled");
                //                     $('.mob_exist_status').text("Mobile Number exists!").css('color', 'green');;

                //                 } else {
                //                     document.getElementById("send_otp_button").setAttribute("disabled", "disabled");
                //                     $('.mob_exist_status').text("Mobile Number not exists !").css('color', 'red');
                //                 }
                //             },
                //             error: function(error) {
                //                 console.error('AJAX error:', error);
                //             }
                //         });
                //     }
                // });

                $('.otp-div').hide();

                $('#resend_otp_button').click(function() {
                    sendOtp();
                });

                $('#mobile, #ccode').keypress(function(e) {
                    if (e.which == 13) { 
                        e.preventDefault();
                        sendOtp();
                    }
                });
            });

            function sendOtp() {
                $('#mobile').attr('readonly', true);
                $('#ccode').attr('disabled', true);

                let mobileNumber = $('#mobile').val();
                let ccode = $('#ccode').val();
                $('.mob_exist_status').text("");

                $.ajax({
                    url: "{{ route('auth.otp.sending-otp') }}",
                    type: "get",
                    data: {
                        mobile: mobileNumber,
                        ccode: ccode
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.exists) {
                            $('.otp-div').show();
                            $('#send_otp_button').hide();
                            $('.mob_exist_status').text(response.message_note).css('color', 'green');
                        } else {
                            if (response.error_note == "Invalid User") {
                                $('#mobile').attr('readonly', false);
                                $('#ccode').attr('disabled', false);
                            }
                            $('.mob_exist_status').text(response.message_note).css('color', 'red');
                        }
                    },
                    error: function(error) {
                        console.error('AJAX error:', error);
                    }
                });
            }

                
        var otp_inputs = document.querySelectorAll(".otp__digit")
        var mykey = "0123456789".split("")
        otp_inputs.forEach((_) => {
            _.addEventListener("keyup", handle_next_input)
        })

        function handle_next_input(event) {
            let current = event.target
            let index = parseInt(current.classList[1].split("__")[2])
            current.value = event.key

            if (event.keyCode == 8 && index > 1) {
                current.previousElementSibling.focus()
            }
            if (index < 4 && mykey.indexOf("" + event.key + "") != -1) {
                var next = current.nextElementSibling;
                next.focus()
            }
            var _finalKey = ""
            for (let {
                    value
                }
                of otp_inputs) {
                _finalKey += value
            }

            if (_finalKey.length == 4) {
                document.getElementById("verify-button").removeAttribute("disabled");
            } else {
                document.getElementById("verify-button").setAttribute("disabled", "disabled");
            }
        }

        $("#verify-button").click(function(e){
            e.preventDefault();
            let form = $('.otp-form')[0];
            let data = new FormData(form);
            $('.otp_send_message,.mob_exist_status').text( " " );
            
            $.ajax({
                url: "{{ route('auth.otp.otp_verification') }}",
                type: "get",
                data : data,
                data: $('.otp-form').serialize(),
                dataType:"JSON",
                
                success: function(response) {

                    if( response.status == true ){

                        globalThis.location.href = response.redirection_url;

                    }else if ( response.status == false ) {

                        $('.otp__digit').val("");
                        $('.otp_send_message').text( response.message_note ).css('color', 'red');
                        document.getElementById("verify-button").setAttribute("disabled", "disabled");
                    }
                },
            });
        });

        $(document).ready(function() {
            $(".login-inputs-data").on("input", function() {

                const email = $('#email').val().trim();
                const password = $('#password').val().trim();

                const loginButton = $('#email-login-button');

                if (email && password) {
                    loginButton.prop("disabled", false);
                } else {
                    loginButton.prop("disabled", true);
                }
            });

            $("#email-login-button").click(function(){ 
                event.preventDefault();
                $(this).prop("disabled", true); 

                $("#email-login-form").submit(); 
            });
        });

        </script>

    </body>

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

</html>