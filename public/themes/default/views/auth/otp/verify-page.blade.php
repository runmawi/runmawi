<?php
    $settings = App\Setting::first();
    $system_settings = App\SystemSetting::first();

    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();
?>

<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('verify-OTP') }} | <?php echo $settings->website_name; ?></title>
    
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
    <link rel="preload" href="assets/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="assets/css/bootstrap.min.css"></noscript>

    <link rel="stylesheet" href="<?= typography_link() ?>" />
    <link rel="stylesheet" href="<?= style_sheet_link() ?>" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        .title {
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: "Poppins", sans-serif;

            h3 {
                font-weight: bold;
            }

            p {
                font-size: 12px;
                color: #118a44;

                &.msg {
                    color: initial;
                    text-align: initial;
                    font-weight: bold;
                }
            }
        }

        .otp-input-fields {
            margin: auto;
            background-color: white;
            box-shadow: 0px 0px 8px 0px #02025044;
            max-width: 400px;
            width: auto;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 40px;

            input {
                height: 40px;
                width: 40px;
                background-color: transparent;
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

                &:focus {
                    border-width: 2px;
                    border-color: darken(#2f8f1f, 5%);
                    font-size: 20px;
                }
            }
        }

        .result {
            max-width: 400px;
            margin: auto;
            padding: 24px;
            text-align: center;

            p {
                font-size: 24px;
                font-family: 'Antonio', sans-serif;
                opacity: 1;
                transition: color 0.5s ease;

                &._ok {
                    color: green;
                }

                &._notok {
                    color: red;
                    border-radius: 3px;
                }
            }
        }
    </style>
</head>

<body>

    
    <section class="sign-in-page"
        style="background:url('<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
        <div class="container">

            <div class="sign-user_card">
                <div class="sign-in-page-data">
                    <div class="sign-in-from m-auto" align="center">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <?php
                                $logoPath = '';
                                if ($theme_mode == "light" && !empty($theme->light_mode_logo)) {
                                    $logoPath = $theme->light_mode_logo;
                                } elseif ($theme_mode != "light" && !empty($theme->dark_mode_logo)) {
                                    $logoPath = $theme->dark_mode_logo;
                                } else {
                                    $logoPath = $settings->logo;
                                }
                                ?>
                                <img alt="apps-logo" class="apps" src="<?php echo URL::to('/') . '/public/uploads/settings/' . $logoPath; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <form  class="otp-form" name="otp-form" method="get">
                @csrf

                <div class="title">
                    <h3>OTP VERIFICATION</h3><br>
                    <p class="info">{{'Code has been sent to '.  substr_replace($user->mobile, '*****', 1, -3)  }} </p>
                    <p class="msg"></p>
                </div>

                <div class="otp-input-fields row d-flex">
                    <input type="number" class="otp__digit otp__field__1" placeholder="-"  name="otp_1">
                    <input type="number" class="otp__digit otp__field__2"  placeholder="-" name="otp_2">
                    <input type="number" class="otp__digit otp__field__3"  placeholder="-" name="otp_3">
                    <input type="number" class="otp__digit otp__field__4"  placeholder="-" name="otp_4">
                    <input type="hidden" value="{{ $user->id }}" name=user_id>
                    
                    <div>
                        <p class="info error-status"> </p>
                    </div>
                </div>
                <br>

                <div class="text-center p-1">
                    <button type="submit" class="btn btn-hover ab" id="verify-button" style="line-height:20px" disabled >{{ __('VERIFY OTP') }}</button>
                </div>
            </form>

            <div class="text-center p-1">
                <form action="{{ route('auth.otp.sending-otp') }}" method="post">
                    @csrf
                    <input  type="hidden" name="mobile" value="{{ $user->mobile }}">
                    <button type="submit" class="btn btn-hover ab " style="line-height:20px" >Re-send</button>
                </form>
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
            $('.error-status').text( " " );
            
            $.ajax({
                url: "{{ route('auth.otp.otp_verification') }}",
                type: "post",
                data : data,
                data: $('.otp-form').serialize(),
                dataType:"JSON",
                
                success: function(response) {

                    if( response.status == true ){

                        window.location.href = response.redirection_url;

                    }else if ( response.status == false ) {

                        $('.otp__digit').val("");
                        $('.error-status').text( response.message_note ).css('color', 'red');
                        document.getElementById("verify-button").setAttribute("disabled", "disabled");
                    }
                },
            });
        })
    </script>
</body>

@php
    include public_path('themes/default/views/footer.blade.php');
@endphp


<script defer src="assets/js/jquery-3.4.1.min.js"></script>
<script defer src="assets/js/popper.min.js"></script>
<script defer src="assets/js/bootstrap.min.js"></script>
<script defer src="assets/js/slick.min.js"></script>
<script defer src="assets/js/owl.carousel.min.js"></script>
<script defer src="assets/js/select2.min.js"></script>
<script defer src="assets/js/jquery.magnific-popup.min.js"></script>
<script defer src="assets/js/slick-animation.min.js"></script>
<script defer src="assets/js/custom.js"></script>
<script defer src="assets/js/jquery.lazy.js"></script>
<script defer src="assets/js/jquery.lazy.min.js"></script>
</html>