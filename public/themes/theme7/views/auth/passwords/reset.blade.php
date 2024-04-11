<?php 
    $settings = App\Setting::first();

    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();
?>

<html>

<head>
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
    <title>Reset Password | <?php echo $settings->website_name; ?></title>
    <link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />

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
    <script>
        if (!window.jQuery) {
            document.write('<script src="<?= THEME_URL . '/assets/js/jquery.min.js' ?>"><\/script>');
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
</head>


<style>
    .btn {
            background-color: {{ button_bg_color() . '!important' }};
            border: {{ '1px solid' . button_bg_color() . '!important' }};
        }

        .container.page-height {
            padding-top: 20px !important;
        }

        .sign-in-from {
            padding: 0;
        }

        i.fa.fa-google-plus {
            padding: 10px !important;
        }

        .container-fluid {}

        h1 {
            color: #fff;
        }

        .h {
            color: #fff;
        }

        .km {
            text-align: center;
            font-size: 75px;
            font-weight: 900;
        }

        input {
            border: 1px solid gray !important;
        }

        .reset-help {
            margin-top: 10px;
            padding: 15px;
        }

        .sign-user_card {
            padding: 20px;
        }
        .sign-in-page {
            background: #000;
        }
    .colour {
        background-color: {{ button_bg_color() . '!important' }};
        border: {{ '1px solid' . button_bg_color() . '!important' }};
    }

    .btn-hover:before {
        background-color: {{ button_bg_color() . '!important' }};
        border: {{ '1px solid' . button_bg_color() . '!important' }};
    }

    #ck-button {
        margin: 4px;
        /*    background-color:#EFEFEF;*/
        border-radius: 4px;
        /*    border:1px solid #D0D0D0;*/
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
        /*    top:-20px;*/
    }

    #ck-button input:checked+span {
        background-color: #3daae0;
        color: #fff;
    }

    i.fa.fa-google-plus {
        padding: 10px !important;
    }
    h1, h2, h3, h4, h5, h6, p, button, input, label {
        font-family: "Inter", sans-serif !important;
    }
    .reveal{
        margin-left: -68px;
        height: 45px !important;
        background: #ED553B !important;
        color: #fff !important;
        position: absolute;
        right: 15px;
        border-radius: 0!important;
        top: 38px;
        padding:5px 15px !important;
    }
</style>

<body>
    <section class="sign-in-page">
        <div class="container  page-height">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-12 align-self-center">
                    <div class="">
                        <h1 class="km"><?php echo $settings->login_text; ?></h1>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 align-self-center">
                    <div class="sign-user_card login-block text-center forgot-box">
                        <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                            <img src="<?php echo URL::to('public/uploads/settings/'. $theme->light_mode_logo) ; ?>"  style="margin-bottom:1rem;">
                        <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                            <img src="<?php echo URL::to('public/uploads/settings/'. $theme->dark_mode_logo) ; ?>"  style="margin-bottom:1rem;">
                        <?php }else { ?> 
                            <img src="<?php echo URL::to('public/uploads/settings/'. $settings->logo) ; ?>"  style="margin-bottom:1rem;">
                        <?php } ?>
                        <h2 class="mb-3 text-center text-white">{{ __('Reset Password') }}</h2>
                        <div class="card-body">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="email" class="col-form-label text-left"
                                            style="font-size: 15px;">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email"
                                            autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="password" class="col-form-label text-left"
                                            style="font-size: 15px;">{{ __('Create Password') }}</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="position-relative">
                                        <span class="input-group-btn" id="eyeSlash-password">
                                            <button class="btn btn-default reveal" onclick="visibility1('password')" type="button">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-btn" id="eyeShow-password" style="display: none;">
                                            <button class="btn btn-default reveal" onclick="visibility1('password')" type="button">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="password-confirm" class="col-form-label text-left"
                                            style="font-size: 15px;">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div class="position-relative">
                                        <span class="input-group-btn" id="eyeSlash-password-confirm">
                                            <button class="btn btn-default reveal" onclick="visibility1('password-confirm')" type="button">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-btn" id="eyeShow-password-confirm" style="display: none;">
                                            <button class="btn btn-default reveal" onclick="visibility1('password-confirm')" type="button">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary colour">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

@php include(public_path('themes/theme7/views/footer.blade.php')); @endphp

<script>
    function visibility1(inputId) {
        var x = document.getElementById(inputId);
        var eyeSlashId = inputId + '-eyeSlash';
        var eyeShowId = inputId + '-eyeShow';

        if (x.type === 'password') {
            x.type = "text";
            $('#' + eyeShowId).show();
            $('#' + eyeSlashId).hide();
        } else {
            x.type = "password";
            $('#' + eyeShowId).hide();
            $('#' + eyeSlashId).show();
        }
    }
</script>
