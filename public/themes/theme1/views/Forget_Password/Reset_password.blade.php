<?php 
    $settings = App\Setting::first();
    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();

    
    $translate_checkout = App\SiteTheme::pluck('translate_checkout')->first();

    @$translate_language = App\Setting::pluck('translate_language')->first();

    $website_default_language = App\Setting::pluck('website_default_language')->first() ? App\Setting::pluck('website_default_language')->first() : $website_default_language;

    if(Auth::guest()){
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $UserTranslation = App\UserTranslation::where('ip_address',$userIp)->first();

        if(!empty($UserTranslation)){
            $translate_language = GetWebsiteName().$UserTranslation->translate_language;
        }else{
            $translate_language = GetWebsiteName().$website_default_language;
        }
    }else if(!Auth::guest()){

        $subuser_id=Session::get('subuser_id');
        if($subuser_id != ''){
            $Subuserranslation = App\UserTranslation::where('multiuser_id',$subuser_id)->first();
            if(!empty($Subuserranslation)){
                $translate_language = GetWebsiteName().$Subuserranslation->translate_language;
            }else{
                $translate_language = GetWebsiteName().$website_default_language;
            }
        }else if(Auth::user()->id != ''){
            $UserTranslation = App\UserTranslation::where('user_id',Auth::user()->id)->first();
            if(!empty($UserTranslation)){
                $translate_language = GetWebsiteName().$UserTranslation->translate_language;
            }else{
                $translate_language = GetWebsiteName().$website_default_language;
            }
        }else{
            $translate_language = GetWebsiteName().$website_default_language;
        }

    }else{
        $translate_language = GetWebsiteName().$website_default_language;
    }

    \App::setLocale(@$translate_language);

?>

<html>

<head>
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
    <title> {{ __('Reset Password') }} | <?php echo $settings->website_name; ?></title>
    <link rel="shortcut icon" href="<?= getFavicon() ?>" />

    <link rel="stylesheet" href="<?= URL::to('/assets/admin/css/font-awesome.min.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/admin/css/email/hellovideo-fonts.css') ?>" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />

    <link href="<?php echo URL::to('public/themes/theme1/assets/css/style.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= URL::to('/assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/css/typography.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/css/responsive.css') ?>" />
    <link rel="stylesheet" href="<?= URL::to('/assets/admin/css/animate.min.css') ?>" />

    <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        if (!window.jQuery) {
            document.write('<script src="<?= URL::to('/assets/js/jquery.min.js') ?>"><\/script>');
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <style>
        /*Button Bg color  */
        .btn {
            background-color: {{ button_bg_color() . '!important' }};
            border: {{ '1px solid' . button_bg_color() . '!important' }};
        }

        .container.page-height {
            padding-top: 80px !important;
        }

        .sign-in-from {
            padding: 0;
        }

        /* i.fa.fa-google-plus {
            padding: 10px !important;
        } */

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
        .sign-in-page{
            background: #000;
        }
        footer{
            background: #161617 !important;
        }
    </style>
</head>

<body>

    <section class="sign-in-page" /*style="background:url('<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->login_content; ?>') no-repeat;background-size: cover;"*/>
        <div class="container  page-height">
            <div class="row justify-content-around">
                <div class="col-lg-7 col-12 align-self-center">
                    <div class="">
                        <h1 class="km"><?php echo $settings->login_text; ?></h1>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 align-self-center">
                    <div class="sign-user_card ">
                        <div class="sign-in-page-data">
                            <div class="sign-in-from w-100 m-auto" align="center">

                                <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                                    <a href="<?php echo URL::to('home'); ?>"><img  src="<?php echo URL::to('public/uploads/settings/'. $theme->light_mode_logo) ; ?>"  style="margin-bottom:1rem;"></a>
                                <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                                    <a href="<?php echo URL::to('home'); ?>"><img  src="<?php echo URL::to('public/uploads/settings/'. $theme->dark_mode_logo) ; ?>"  style="margin-bottom:1rem;"></a>
                                <?php }else { ?> 
                                    <a href="<?php echo URL::to('home'); ?>"><img  src="<?php echo URL::to('public/uploads/settings/'. $settings->logo) ; ?>" style="margin-bottom:1rem;"></a>
                                <?php } ?>

                                <h2 class="mb-3 text-center h">{{ __('Forgot Password') }}</h2>

                                <div class="">
                                    
                                    @if (session('status-success'))
                                        <div class="alert alert-success status_message" role="alert" style="font-size: 15px;">
                                            {{ session('status-success') }}
                                        </div>
                                    @endif

                                    @if(session()->has('status-fails'))
                                        <div class="alert alert-danger status_message" role="alert" style="font-size: 15px;">
                                            {{ session()->get('status-fails') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('Send_Reset_Password_link') }}">
                                        @csrf

                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            placeholder="{{ __('email@example.com') }}" value="{{ old('email') }}" required
                                            autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <div class="alert alert-danger status_message">
                                                    {{ __('Email address is invalid! Please Provide the registered email address') }}
                                                </div>
                                            </span>
                                        @enderror

                                        <p class="reset-help text-center">{{ __('We will send you an email with instructions on how to reset your password') }}.</p>

                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            setTimeout(function() {
                $('.status_message').fadeOut('slow');
            }, 6000);
        })
    </script>

<?php include(public_path('themes/theme1/views/footer.blade.php'));  ?>

</body>

</html>
