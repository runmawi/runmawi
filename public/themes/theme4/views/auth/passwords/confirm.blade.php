<?php $settings = App\Setting::first(); ?>

<html>

<head>
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
    <title>Reset Password | <?php echo $settings->website_name; ?></title>
    <link rel="stylesheet" href="<?= THEME_URL . '/assets/css/bootstrap.min.css' ?>" />
    <link rel="stylesheet" href="<?= THEME_URL . '/assets/css/noty.css' ?>" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="<?= THEME_URL . '/assets/css/style.css' ?>" />
    <link rel="stylesheet" href="<?= THEME_URL . '/assets/css/animate.min.css' ?>" />
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
@extends('layouts.app')

@section('content')
    <section class="sign-in-page" style="background:linear-gradient(180deg, #282834 0%, #151517 127.69%), url('<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->login_content; ?>') no-repeat;background-size: cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="color:#fff!important;">{{ __('Confirm Password') }}</div>

                        <div class="card-body pt-0">
                            {{ __('Please confirm your password before continuing.') }}

                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Confirm Password') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

</html>
