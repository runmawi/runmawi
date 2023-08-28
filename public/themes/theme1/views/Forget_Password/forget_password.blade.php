<?php 
    $settings = App\Setting::first();
    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();
?>

<html>

<head>
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
    <title>Reset Password | <?php echo $settings->website_name; ?></title>
    <link rel="shortcut icon" href="<?= getFavicon() ?>" />

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="<?= URL::to('/assets/css/style.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/css/typography.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/css/responsive.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/admin/css/animate.min.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/admin/css/email/rrssb.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/admin/css/animate.min.css') ?>" />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<style>
    #ck-button {
        margin: 4px;
        border-radius: 4px;
        overflow: auto;
        float: left;
    }

    #ck-button label {
        float: left;
        width: 4.0em;
    }

    #ck-button label span {
        text-align: center;
        display: block;
        color: #fff;
        background-color: #3daae0;
        border: 1px solid #3daae0;
        padding: 0;
    }

    #ck-button label input {
        position: absolute;
    }

    #ck-button input:checked+span {
        background-color: #3daae0;
        color: #fff;
    }

    .mobile-div {
        margin-left: -2%;
        margin-top: 1%;
    }

    .modal-header {
        padding: 0px 15px;
        border-bottom: 1px solid #e5e5e5 !important;
        min-height: 16.42857143px;
    }

    #otp {
        padding-left: 15px;
        letter-spacing: 42px;
        border: 0;
        background-position: bottom;
        background-size: 50px 1px;
        background-repeat: repeat-x;
        background-position-x: 80px;
    }

    #otp:focus {
        border: none;
    }

    .verify-buttons {
        margin-left: 36%;
    }

    .container {
        margin-top: 70px;
    }

    .panel-heading {
        margin-bottom: 1rem;
    }

    .phselect {
        width: 100%;
        height: 45px !important;
        background: transparent !important;
        color: var(--iq-white) !important;
    }

    .form-control {
        height: 45px;
        line-height: 45px;
        background: transparent !important;
        border: 1px solid var(--iq-body-text);
        font-size: 14px;
        color: var(--iq-white) !important;
        border-radius: 0;
        margin-bottom: 1rem !important;
    }

    .form-control:focus {
        color: var(--iq-white) !important;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
    }

    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }

    .catag {
        padding-right: 150px !important;
    }

    i.fa.fa-google-plus {
        padding: 10px !important;
    }

    option {
        background: #474644 !important;
    }

    .reveal {
        margin-left: -60px;
        height: 45px !important;
        background: transparent !important;
        color: #fff !important;
    }

    #fileLabel {
        position: absolute;
        top: 8px;
        color: #fff;
        padding: 8px;
        left: 114px;
        background: rgba(11, 11, 11, 1);
        font-size: 12px;
    }

    .error {
        color: brown;
        font-family: 'remixicon';
    }
</style>

<body>
    <section style="background:url('<?php echo URL::to('/public/uploads/settings/' . $settings->login_content); ?>') no-repeat scroll 0 0;;background-size: cover;">
        <div class="container">
            <div class="row justify-content-center align-items-center height-self-center">
                <div class="col-sm-9 col-md-7 col-lg-5 align-self-center">
                    <div class="sign-user_card ">
                        <div class="sign-in-page-data">

                            <div class="sign-in-from w-100 m-auto">

                                <div align="center">
                                    
                                    <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                        <img  src="<?php echo URL::to('public/uploads/settings/'. $theme->light_mode_logo) ; ?>"  style="margin-bottom:1rem;">
                                    <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                                        <img  src="<?php echo URL::to('public/uploads/settings/'. $theme->dark_mode_logo) ; ?>"  style="margin-bottom:1rem;">
                                    <?php }else { ?> 
                                        <img  src="<?php echo URL::to('public/uploads/settings/'. $settings->logo) ; ?>" style="margin-bottom:1rem;">
                                    <?php } ?>

                                    <h3 class="mb-3 text-center"> Reset Password </h3>
                                </div>

                                  @if (session('status_message'))
                                    <div class="alert alert-danger status_message" role="alert" style="font-size: 15px;">
                                        {{ session('status_message') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('forget_password_update') }}" id="reset_password_form">
                                    @csrf

                                    <input type="hidden" name="reset_token" value="{{ $data['reset_token'] }}">

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ $data['decrypted_email'] }}" required readonly>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>
                                                </div>

                                                <div>
                                                    <span class="input-group-btn" id="eyeSlash">
                                                        <button class="btn btn-default reveal" onclick="visibility1()"type="button">
                                                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                    <span class="input-group-btn" id="eyeShow" style="display: none;">
                                                        <button class="btn btn-default reveal" onclick="visibility1()" type="button">
                                                            <i class="fa fa-eye" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input id="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                                                </div>

                                                <div class="">
                                                    <span class="input-group-btn" id="eyeSlash1">
                                                        <button class="btn btn-default reveal" onclick="visibility2()" type="button">
                                                            <i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                                    </span>

                                                    <span class="input-group-btn" id="eyeShow1" style="display: none;">
                                                        <button class="btn btn-default reveal" onclick="visibility2()" type="button">
                                                            <i class="fa fa-eye" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <span
                                                style="color: var(--iq-white);font-size: 14px;font-style: italic;">
                                                (Password should be at least 8 characters in length and should include at least
                                                one upper case letter, one number, and one special character.)
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="sign-up-buttons col-md-12" align="right">
                                            <button class="btn btn-hover btn-primary btn-block signup"
                                                style="display: block;" type="submit"
                                                name="create-account">{{ __('Reset Password') }}</button>
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

    <script>

        $(document).ready(function() {
            setTimeout(function() {
                $('.status_message').fadeOut('slow');
            }, 6000);
        })

        function visibility1() {
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
        }

        function visibility2() {
            var x = document.getElementById('password_confirmation');
            if (x.type === 'password') {
                x.type = "text";
                $('#eyeShow1').show();
                $('#eyeSlash1').hide();
            } else {
                x.type = "password";
                $('#eyeShow1').hide();
                $('#eyeSlash1').show();
            }
        }
    </script>

                {{-- Validation --}}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $("#reset_password_form").validate({

            rules: {
                password: {
                    minlength: 8,
                    maxlength: 30,
                },
                password_confirmation: {
                    equalTo: "#password"
                },
            },
            messages: {
                password: "Please provide the most powerful password !",
                password_confirmation: "Please enter the same password value here again",
            }
        });
    </script>

    @php include(public_path('themes/default/views/footer.blade.php')); @endphp

</body>