@extends('layouts.app')

<!doctype html>
<html lang="en-US">

<head>
    <?php
    $uri_path = $_SERVER['REQUEST_URI'];
    $uri_parts = explode('/', $uri_path);
    $request_url = end($uri_parts);
    $uppercase = ucfirst($request_url);
    ?>

    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); ?>

    <title><?php echo $uppercase . ' | ' . $settings->website_name; ?></title>

    <meta name="description" content="<?php echo $settings->website_description; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link href="<?php echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css'); ?>" rel="stylesheet">

    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme5-nemisha/assets/css/bootstrap.min.css'); ?>" />

    <!-- Style -->
    <link rel="stylesheet" href="<?= typography_link() ?>" />

    <!-- Responsive -->
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <style>
        .map {

            font-size: 16px;
            line-height: 23px;
            margin-top: 15px !important;
            text-align: justify;

        }

        .wat {
            padding: 10px 18px 10px 18px;
        }

        @media (min-width: 992px) .container {
            max-width: 1200px !important;
        }

        .container-fluid {
            padding: 10px;
        }

        .slick-dots li {
            margin: 0;
        }

        .slick-dots li button:before {
            color: #01DC82 !important;
            font-size: 30px;
        }

        .card-text {
            color: #000;
        }

        .slick-dots {
            top: 100%;
            margin: 0;
            left: 0;
            right: 0;
            text-align: center !important;
            bottom: -40px !important;
        }

        .mn {
            margin: 10px 10px;
            transition: all .5s ease-in;

        }

        .mn img {
            border-radius: 5px;
        }

        .mn:hover {
            transform: scale(1.1);

        }

        @media only screen and (max-width : 320px) {
            .sec-21 {
                padding: 10px !important;
            }

            .nav-pills {
                border-radius: 5px;
                padding: 0 0px 0 0px !important;
            }

            .banner-top {
                background-color: rgb(23, 39, 52, 0.8);
                background-blend-mode: multiply;
            }

            .banner-top h1 {
                font-size: 25px !important;
            }

            .navbar-fixed-top {
                height: auto;
            }

            .map {
                height: 94px;
                font-size: 13px;
            }

            .img-lan1 {
                width: 60% !important;

            }

            .imk {
                margin-top: 15px !important;
            }

            .sec-31 {
                padding: 10px !important;
            }

            .img-lan {
                width: 100%;
            }

            #disp {
                display: none;
            }

            .pa {
                padding: 0;
            }

            h2 {

                text-align: center;

            }

            .sec-21 {
                text-align: center;
            }

            .lan {
                padding: 0;
            }

            .pt {
                background-image: none !important;
            }

            .sec-4 h2 {
                font-size: 30px !important;
            }

            .d-flex {
                flex-wrap: wrap;
            }

            #ikm {
                font-size: 25px !important;
            }

            .h-100 {
                height: auto !important;
            }

            .div1 {
                padding: 0 !important;
            }

            .ital {
                width: 100%;
                font-size: 20px;
            }

            .text-right {
                text-align: left !important;
            }

            h1 {
                font-size: 25px !important;
            }

            .position-relative {
                margin-top: 0 !important;
            }

        }

        .sec-4 h2 {
            font-size: 40px;
        }

        .nav-link {
            padding: 5px 20px;
        }

        .adv {
            font-size: 20px;

        }

        .sec-3 h2 {
            font-size: 40px;
        }

        .btn {
            border-radius: 30px !important;
        }

        h3 {
            font-weight: 600;
        }

        a:link {}

        h1 {
            font-family: 'futurabook';

            text-transform: uppercase;
            font-size: 25px;
            font-weight: 600;
            line-height: 65px;
            letter-spacing: 0em;
            text-align: center;

        }

        h2 {
            font-family: 'futuramedium';


        }

        .sec-2 h2 {
            font-size: 40px;
            margin: 0 60px auto;
        }

        h2 {
            font-weight: 700;
            font-weight: 40px;
        }

        main.py-4 {
            padding-bottom: 0 !important;
            padding-top: 0 !important;
        }

        body {
            background: #fff;
        }

        input {
            color: #000;
        }

        /*.sign-user_card {
       background: none !important;
   }*/
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
            /* background-image: linear-gradient(to right, black 60%, rgb(120, 120, 120) 0%);*/
            background-position: bottom;
            background-size: 50px 1px;
            background-repeat: repeat-x;
            background-position-x: 80px;
        }

        #otp:focus {
            border: none;
        }

        .nav-item {
            margin: 0 7px !important;
        }

        /*.sign-up-buttons{
       margin-left: 40% !important;
   }*/
        .verify-buttons {
            margin-left: 36%;
        }

        .container {}

        .panel-heading {
            margin-bottom: 1rem;
        }

        /* .form-control {
   background-color: var(--iq-body-text) !important;
   border: 1px solid transparent;
   height: 46px;
   position: relative;
   color: var(--iq-body-bg) !important;
   font-size: 16px;
   width: 100%;
   -webkit-border-radius: 6px;
   border-radius: 6px;
}
   a {
   color: var(--iq-body-text);
   text-decoration: none;
}*/
        .phselect {

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
            color: #000 !important;
            border-radius: 0;
            margin-bottom: 1rem !important;
        }

        .form-control:focus {

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

        /*input[type="file"] {
   display: none;
}*/
        .catag {
            padding-right: 150px !important;
        }

        i.fa.fa-google-plus {
            padding: 10px !important;
        }

        option {
            background: #474644 !important;
        }

        .card {
            background: transparent !important;
            border: none !important;
        }

        .plyr__control ply {
            height: 50px;
            width: 50px;
        }

        .reveal {
            margin-left: -92px;
            height: 45px !important;
            background: transparent !important;
            color: #fff !important;
        }

        .error {
            color: brown;


        }

        .agree {
            font-style: normal;
            font-weight: 400;
            font-size: 10px;
            line-height: 18px;
            display: flex;
            align-items: center;
            color: #000;
        }

        .get {


            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 32px;
        }

        .form-group {
            margin-bottom: 0;
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

        .btn-success span {
            position: relative;
            z-index: 2;
        }

        .sec-21 .btn {
            border-radius: 30px !important;

        }

        .sec-21 .btn-success:after {
            position: absolute;
            content: "";
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #F6D55C;
            transition: all .35s;
            z-index: -1;
            border-radius: 30px !important;
        }

        .sec-21 .btn-success:hover {
            color: #fff !important;
            border-color: 1px solid #ED553B !importan;

        }

        .sec-21 .btn-success:hover:after {
            width: 100%;
        }

        .sec-21 .btn-success:after {
            position: absolute;
            content: "";
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #F6D55C;
            transition: all .35s;
            z-index: -1;
            border-radius: 30px !important;
        }

        .btn-success:after {
            position: absolute;
            content: "";
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #F6D55C;
            transition: all .35s;
            z-index: -1;
            border-radius: 30px !important;
        }

        .btn-success:hover {
            color: #fff !important;
            border-color: 1px solid #ED553B !importan;

        }

        .btn-success:hover:after {
            width: 100%;
        }

        .sec-21 .btn-success {

            font-size: 20px;
        }

        .sec-21 .btn-success:hover {
            color: #fffff !important;
        }

        .sec-3 .btn-success {}

        .signup-desktop {
            background-color: #fff;
            border-radius: 5px !important;
            border: none !important;

            padding: 5px 10px !important;

            font-style: normal;
            font-weight: 600;

        }

        .nees {
            margin: 2px;
        }

        .nees1 {
            margin: 10px;
        }

        .signup-desktop i {
            font-size: 22px;
        }

        .btn-outline-success {
            border: none;
        }

        .signup-desktop:hover {
            background-color: burlywood;
            color: #fff;

        }

        .signup {
            background: rgba(1, 220, 130, 1) !important;
            padding: 10px 30px;
            font-family: 'Roboto', sans-serif;
            font-weight: 600;

        }

        .nav-link {
            font-family: 'futuraheavy';

        }

        p {
            font-family: 'futuralight';
            font-weight: 400;
            font-size: 20px;
            line-height: 32px;

        }

        .nav-link.active {
            color: #F6D55C !important;
            background:  !important;
            padding: 10px 0;
            border: none !important;
            border-bottom: 2px solid #F6D55C !important;



        }

        .nav-pills .nav-link {
            border-radius: 0 !important;
        }

        .btn {
            font-weight: 500;
        }

        .poli {
            font-family: 'Roboto', sans-serif;
            font-size: 11px;
        }

        .sec {
            padding: 70px 0 70px 0;
        }

        .sec-3 {
            background: #3CAEA3;

        }

        .in {
            font-size: 35px;
            line-height: 40px;
            font-weight: 600;
            color: #000;
            text-align: left;
            font-family: 'Roboto', sans-serif;
        }

        .btn-success {
            color: #fff !important;
            background: #ED553B !important;
            border: none !important;


            border-radius: 5px;


        }

        .bg-light {
            background-color: #fff !important;
            color: #000;
            z-index: 1;
        }

        .card-body {
            background-color: transparent;
            color: #fff !important;
            padding-left: 0 !important;
        }

        .nav-item {
            padding: 5px 7px
        }

        .nav-item:hover {
            padding: 5px 7px
        }

        .div1 {
            padding: 20px 90px 100px 20px;
        }

        .h-100 {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            align-self: center;
        }

        .nem {
            color: #1D639B;


        }

        .lan {
            margin-top: 40px;
        }

        .dig {
            font-style: normal;
            font-weight: 400;
            font-size: 22px;

            text-transform: uppercase;

        }

        .dropdown-menu {
            background: linear-gradient(0deg, rgba(1, 220, 130, 0.75), rgba(1, 220, 130, 0.75)),
                linear-gradient(0deg, rgba(1, 220, 130, 0.75), rgba(1, 220, 130, 0.75));
        }

        .dropdown-menu a {
            padding: 0.5rem 10px !important;
            font-size: 14px !important;
            color: #fff !important;
            font-weight: 400;
        }

        .dropdown-item {
            color: #000 !important;
            padding: 5px;

        }

        #ikm {
            font-size: 45px;
            font-weight: 600;
            line-height: 53px;
        }

        .pt p {

            font-size: 16px;
            line-height: 25px;
        }

        .pt img {
            margin-bottom: 10px;
        }

        .tune li {
            font-size: 20px;
            line-height: 40px;
            color: #fff;
        }

        .slick-next:before {
            content: '→';
            display: none;
        }

        .slick-prev:before {
            content: '←';
            display: none;
        }

        .nav-link {
            padding: 10px 0;
            font-size: 17px;
            border: none !important;
            border-bottom: 2px solid transparent !important;
        }

        .sec-3 {}

        .card {
            ;
            /* [1.1] Set it as per your need */
            overflow: hidden;
            /* [1.2] Hide the overflowing of child elements */
        }

        .card a {
            background: #173F5F !important;
        }

        /* [2] Transition property for smooth transformation of images */
        .card img {
            transition: transform .5s ease;
        }

        .small-t p {
            color: #000;
        }

        .sec-31 {
            background: #183F5F;

        }

        /* [3] Finally, transforming the image when container gets hovered */

        .card img:hover {
            transform: scale(1.1);

        }

        .card p:hover {
            color: #01DC82 !important;

        }

        .sec-3 h2 {}

        .nav-link {
            color: #fff !important;
        }

        .io {
            /*position: absolute;*/
            display: none;
            /*bottom: 0;
   left: 0;
   right: 0;
   display: flex;
   justify-content: center;
   align-items: center;
   width: 100%;
   color: white;
       line-height: 20px;
       text-align: center;*/
        }

        .suce {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: -1px 0 0 0;
            height: 30px;

            color: #F6D55C !important;
            border: none;
        }

        .nav-pills {

            border-radius: 5px;
            padding: 0 !important;
        }

        .btn-warning {
            padding: 8px 40px !important;
            background: #FA8F21 !important;
        }

        .sec-21 {
            background-color: #3CAEA3;
            color: #fff;
            padding: 40px;

        }

        .navbar-fixed-top {
            position: fixed;
            top: 0;
            height: 60px;
            width: 100%;
            z-index: 15;
        }

        .navbar-fixed-top.scrolled {
            background-color: #fff !important;
            transition: background-color 200ms linear;
        }

        .card img {

            border-radius: 5px !important;
        }

        .slick-dots li {
            margin: -2px;
        }

        .bkm {
            position: absolute;
            bottom: -5px;
            left: 18px;
            width: 80px;
            height: 28px;
            padding-left: 5px;

            background: rgba(0, 0, 0, 0.5);
            border-radius: 3px;
            font-size: 12px;
            color: #fff !important;
        }

        .bp {
            padding: 7px 20px;
        }

        .card img {
            max-height: 180px;
        }

        .vid {
            margin: 0 auto;
        }

        .bg-color {
            border: 10px solid #3CAEA3;
            min-height: 266px;
            margin: 0 8px auto;
            position: relative;
            padding: 30px 0px 20px 20px;
        }

        .bg-color1 {
            position: relative;
            border: 10px solid #ED553B;
            padding: 30px 0px 20px 20px;
            margin: 25px 8px auto;
        }

        .bg-color {
            border: 10px solid #3CAEA3;

            margin: 25px 8px auto;
            position: relative;
        }

        .bg-color p {
            color: #fff;
        }

        .bg-color1 p {
            color: #fff;
        }

        .bg-color h3 {
            color: #Fff;
            font-weight: 600;
            font-size: 30px;
            line-height: 52px;
            position: relative;
        }

        .bg-color1 h3 {
            color: #Fff;
            font-weight: 600;
            font-size: 30px;
            line-height: 52px;
            position: relative;
        }

        .comp {
            position: absolute;
            background: #183F5F;
            padding: 15px;
            top: -36px;
            left: -19px;

        }

        .clive {
            position: absolute;
            background: #183F5F;
            padding: 15px;
            top: -36px;
            left: -19px;

        }

        .set {
            position: absolute;
            background: #183F5F;
            padding: 15px;
            top: -36px;
            left: -19px;

        }

        .btn-outline-danger {

            color: #ED553B !important;
        }

        .btn-outline-danger:hover {
            color: #fff !important;
        }

        .all-video {
            margin: 0 auto;
        }

        .who {
            letter-spacing: 1.5px;
        }

        .ben {
            letter-spacing: 8px;
        }

        @media (max-width: 600px) {
            .img-lan {
                width: 100%;
            }

            .mobk {
                margin-top: 10px;
            }

            .navbar-fixed-top {
                height: 90px;
            }

            .ban {
                background-color: rgba(0, 0, 0, 0.65);
                background-blend-mode: multiply;
            }

            #disp {
                display: none;
            }

            .rated {
                padding: 0;
            }

            .map1 {
                display: flex;
                justify-content: center;
                flex-direction: column;
            }
        }
    </style>

    <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));
    
    $jsondata = json_decode($jsonString, true); ?>

    <section class="mb-0">

        <nav class="navbar navbar-expand-lg navbar-light navbar-fixed-top bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->logo; ?>" style=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <a type="button" class="btn btn-outline-danger bp mr-3" href="{{ route('login') }}">Sign In </a>
                    <a class="btn btn-success  my-2 mr-2 my-sm-0 bp" href="{{ route('signup') }}" style="">Sign
                        Up</a>
                </div>
            </div>
        </nav>

        <div class="position-relative ban"
            style="padding: 19.2% 0 37% 0!important;background-image:url('<?php echo URL::to('/assets/img/lan/v11.png'); ?>');background-repeat: no-repeat;background-size: 100% 100%;">
            <div class="fixe">
                <div class="row m-0  p-0" style="">
                    <div class="col-md-12 col-lg-12 p-0 text-center h-100 banner-top"
                        style="background-image:url('<?php echo URL::to('/assets/img/lan/v'); ?>');background-repeat: no-repeat;background-position: center 350px;
    background-size: 50%;">
                        <div></div>
                        <h1 class=" mt-5 pt-5">Welcome to <span class="">NEMISA TV</span></h1>
                        <h2 class="dig mt-1 mb-5 text-center">HOME OF EDUTAINMENT & ORIGINAL <br>STORY-TELLING</h2>
                        <!--  <p class="text-white" style="font-size:16px;">South Africa’s first free video sharing social platform where we mix knowledge <br>and entertainment for unique learning experience</p>-->
                    </div>
                </div>
            </div>
        </div>
        <section class="sec-21">
            <div class="container">
                <div class="row  mt-3 align-items-center">
                    <div class="col-lg-6">
                        <h2 class="ben  mb-3">Who are we ?</h2>

                        <p class="mt-2">NEMISA TV is a free to the public video sharing platform with unlimited video,
                            audio and animation content. Through this platform, we aim to entertain, upskill and prepare
                            for the fourth industrial revolution skills.</p>

                        <p class="mt-4 mb-3">NEMISA TV provides resources that include career openings, Learnerships,
                            interships, bursaries, funding, sponsorships, workshops and events.</p>

                        <a href="{{ route('login') }}" type="button" class="btn btn-success"
                            style="padding: 8px 35px;">Join Now</a>

                    </div>

                    <div class="col-lg-6 imk">
                        <img class="img-lan w-100" src="<?php echo URL::to('/assets/img/v1.png'); ?>" style="">
                    </div>
                </div>
            </div>
        </section>

        <section class="sec-2"
            style="background-image:url('<?php echo URL::to('/assets/img/lan/bg.png'); ?>');background-repeat: no-repeat;background-size: cover;">
            <div class="container">
                <div class="" style="padding:5% 0 5% 0;">
                    <div class="row m-0 p-0 justify-content-around align-items-center">
                        <div class="col-lg-6 p-0">

                            <video id="player" height="618" controls autoplay poster="<?php echo URL::to('/assets/img/lan/vi1.png'); ?>">
                                <source src="<?php echo URL::to('/assets/img/tv.mp4'); ?>" type="video/mp4">
                                <source src="" type="video/ogg">
                            </video>

                            <!-- <div class="row p-0">
                                <div class=" col-4 col-md-4 p-0"> <img class="img-lan" src="<?php echo URL::to('/assets/img/v1.png'); ?>" style=""></div>
                                <div class=" col-4 col-md-4 p-0" style="">   <img class="mt-4 img-lan" src="<?php echo URL::to('/assets/img/v2.png'); ?>" style=""></div>
                                <div class=" col-4 col-md-4 p-0"  style="">  <img class="mt-5 img-lan" src="<?php echo URL::to('/assets/img/v3.png'); ?>" style=""></div>
                                </div>color: #1D639B;
                            -->
                        </div>

                        <div class="col-lg-6 p-0">
                            <h2 class="ml-3" style="">NEMISA TV - Bringing the world of digital technology to
                                you.</h2>
                            <ul class="tune mt-3">
                                <li> Be transformed by the entertaining learning opportunities offered.</li>
                                <li>Thousands of videos available.</li>
                                <li>Get connected to communities of experts.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="">
            <div class="sec-3">
                <div class="container ">

                    <h2 class="text-center mt-2 ">Explore More With NEMISA TV</h2>
                    <div class="mt-3 ">
                        <ul class="nav nav-pills   m-0 p-0" id="pills-tab" role="tablist">

                            @foreach ($videos_categories as $key => $videos_category)
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                                        data-category-id={{ $videos_category->id }} onclick="Series_Category(this)"
                                        role="tab" aria-controls="pills-profile" aria-selected="false">
                                        {{ $videos_category->name }}
                                    </a>
                                </li>
                            @endforeach


                            <li class="nav-item">

                                <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More <i
                                        class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>

                                <div class="dropdown-menu">
                                    <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                        href="#pills-kids" role="tab" aria-controls="pills-kids"
                                        aria-selected="false">Comic & Kids</a>
                                </div>
                    </div>
                </div>
            </div>

            </ul>
            </div>
            <div class="container">

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">

                        <div class="row favorites-sli1 data">
                            @partial('landing_category_series')
                        </div>

                        <div class="row mt-2"></div>
                    </div>

                    <div class="text-center mt-3 mb-5 pb-2 col-lg-3 all-video">
                        <a class="btn btn-success my-2 my-sm-0 w-100" style="font-weight:600;font-size: 20px;"
                            herf="#"><span>All Videos <i class="fa fa-angle-right"
                                    aria-hidden="true"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>


        <!-- <section>
           <div>
               <img class="w-100" src="<?php echo URL::to('/assets/img/rt.png'); ?>" alt="">
           </div>
       </section>-->

        <!-- <section class="sec- mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img class=" mb-3" src="<?php echo URL::to('/assets/img/g1.png'); ?>" style="">
                        <h3 class="text-black">Watch Everywhere</h3>
                        <p class="wat">Watch videos, podcasts and live events on your phone, tablet or laptop. No matter which device you use, we are always a click away!</p>
                    </div>
                    <div class="col-md-4 text-center">
                            <img class="  mb-3" src="<?php echo URL::to('/assets/img/g2.png'); ?>" style="">
                        <h3 class="text-black">Stream Live</h3>
                        <p class="wat" style="padding: 10px 30px 10px 30px">Stream unlimited videos, podcasts and live events for free anytime! Wherever you are in Mzansi, we got you covered!</p>
                    </div>
                    <div class="col-md-4 text-center">
                            <img class=" mb-3 " src="<?php echo URL::to('/assets/img/g3.png'); ?>" style="">
                        <h3 class="text-black">Quality Videos</h3>
                        <p class="wat">Explore our edutainment video packed with 4IR and digital skills. Choose from a variety of documentaries, animation, radio, live shows and much more...</p>
                    </div>
                </div>
            </div>
        </section>-->

        <section class="sec- mt-5" id="disp">

            <div class="container mb-5">
                <h2 class="text-center text-black">Most popular </h2>
                <div id="slide">
                    <div>
                        <div class="row align-items-center justify-content-center mt-4">
                            <div class="col-lg-2 position-relative p-0 mn">
                                <a href="https://dev.nemisatv.co.za/">
                                    <img class="w-100" src="<?php echo URL::to('/assets/img/lan/radio.jpg'); ?>" style=>
                                    <p class="io">Radio</p>
                                </a>
                            </div>

                            <div class="col-lg-2 p-0 ">
                                <div class="position-relative mn">
                                    <a href="https://dev.nemisatv.co.za/category/Education"> <img class="w-100"
                                            src="<?php echo URL::to('/assets/img/lan/education.jpg'); ?>" style=>
                                        <p class="io">Education</p>
                                    </a>
                                </div>

                                <div class="position-relative mn"> <a href="https://dev.nemisatv.co.za/"> <img
                                            class="w-100 " src="<?php echo URL::to('/assets/img/lan/live.jpg'); ?>" style=>
                                        <p class="io">Live <br>Streaming</p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-2 position-relative p-0 mn">
                                <a href="https://dev.nemisatv.co.za/">
                                    <img class="w-100" src="<?php echo URL::to('/assets/img/lan/podcast.jpg'); ?>" style=>
                                    <p class="io">Podcast</p>
                                </a>
                            </div>

                            <div class="col-lg-2 p-0">
                                <div class="position-relative mn">
                                    <a href="https://dev.nemisatv.co.za/">
                                        <img class="w-100" src="<?php echo URL::to('/assets/img/lan/online.jpg'); ?>" style=>
                                        <p class="io">Online <br>Streaming </p>
                                    </a>
                                </div>

                                <div class="position-relative mn">
                                    <a href="https://dev.nemisatv.co.za/category/Movies">
                                        <img class="w-100 " src="<?php echo URL::to('/assets/img/lan/movies.jpg'); ?>" style=>
                                        <p class="io">Movies</p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-2 position-relative p-0 mn">
                                <a href="https://dev.nemisatv.co.za/category/Animation">
                                    <img class="w-100" src="<?php echo URL::to('/assets/img/lan/animation.jpg'); ?>" style=>
                                    <p class="io">Animation</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row align-items-center justify-content-center mt-4" >
                <div class="col-lg-2 position-relative p-0">
                    <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r1.png'); ?>" style=>
                    <p class="io">Digitech news update</p>
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn"> <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r2.png'); ?>" style=>
                       <p class="io">Webinars</p></div>
                    <div class="position-relative mn">  <img class="w-100 mt-3" src="<?php echo URL::to('/assets/img/lan/r3.png'); ?>" style=>
                       <p class="io">Events</p></div>
                    
                   
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r4.png'); ?>" style=>
                     <p class="io">User content</p>
                    
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn">
                        <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r2.png'); ?>" style=>
                      <p class="io">Music videos </p>
                    </div>
                    <div class="position-relative mn">
                        <img class="w-100 mt-3" src="<?php echo URL::to('/assets/img/lan/r6.png'); ?>" style=>
                      <p class="io">Movies</p>
                    </div>
                     
                     
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r7.png'); ?>" style=>
                     <p class="io">Animation</p>
                </div>
            </div></div>
            <div>
            <div class="row align-items-center justify-content-center mt-4" >
                <div class="col-lg-2 position-relative p-0">
                    <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r1.png'); ?>" style=>
                    <p class="io">Technical and practical</p>
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn"> <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r2.png'); ?>" style=>
                       <p class="io">Futuristic </p></div>
                    <div class="position-relative mn">  <img class="w-100 mt-3" src="<?php echo URL::to('/assets/img/lan/r3.png'); ?>" style=>
                       <p class="io">Innovative </p></div>
                    
                   
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r4.png'); ?>" style=>
                     <p class="io">Creative Ideas</p>
                    
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn">
                        <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r2.png'); ?>" style=>
                      <p class="io">Creative Ideas </p>
                    </div>
                    <div class="position-relative mn">
                        <img class="w-100 mt-3" src="<?php echo URL::to('/assets/img/lan/r6.png'); ?>" style=>
                      <p class="io">Alternative ideas</p>
                    </div>
                     
                     
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r7.png'); ?>" style=>
                     <p class="io">Animation</p>
                </div>
            </div></div>
            <div>
            <div class="row align-items-center justify-content-center mt-4" >
                <div class="col-lg-2 position-relative p-0">
                    <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r1.png'); ?>" style=>
                    <p class="io">Radio</p>
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn"> <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r2.png'); ?>" style=>
                       <p class="io">Education</p></div>
                    <div class="position-relative mn">  <img class="w-100 mt-3" src="<?php echo URL::to('/assets/img/lan/r3.png'); ?>" style=>
                       <p class="io">Live <br>Streaming</p></div>
                    
                   
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r4.png'); ?>" style=>
                     <p class="io">Podcast</p>
                    
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn">
                        <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r2.png'); ?>" style=>
                      <p class="io">Online <br>Streaming </p>
                    </div>
                    <div class="position-relative mn">
                        <img class="w-100 mt-3" src="<?php echo URL::to('/assets/img/lan/r6.png'); ?>" style=>
                      <p class="io">Movies</p>
                    </div>
                     
                     
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo URL::to('/assets/img/lan/r7.png'); ?>" style=>
                     <p class="io">Animation</p>
                </div>
            </div></div>-->



                </div>
        </section>
        <section class="sec-2"
            style="background-image:url('<?php echo URL::to('/assets/img/lan/bg1.png'); ?>');background-repeat: no-repeat;background-size:100% 100%;">
            <div class="container">

                <div class="" style="padding:5% 0 5% 0;">
                    <h2 class="ben   text-right" style="
">BENEFITS YOU CAN'T RESIST</h2>
                    <div class="row m-0 p-0 justify-content-around align-items-center">

                        <div class="col-lg-6">
                            <video id="player1" height="800" controls autoplay poster="<?php echo URL::to('/assets/img/lan/vi1.png'); ?>">
                                <source src="<?php echo URL::to('/assets/img/vq.mp4'); ?>" type="video/mp4">
                                <source src="" type="video/ogg">
                            </video>


                            <!-- <div class="row p-0">
                       <div class=" col-4 col-md-4 p-0"> <img class="img-lan" src="<?php echo URL::to('/assets/img/v1.png'); ?>" style=""></div>
                       <div class=" col-4 col-md-4 p-0" style="">   <img class="mt-4 img-lan" src="<?php echo URL::to('/assets/img/v2.png'); ?>" style=""></div>
                       <div class=" col-4 col-md-4 p-0"  style="">  <img class="mt-5 img-lan" src="<?php echo URL::to('/assets/img/v3.png'); ?>" style=""></div>
                    </div>color: #1D639B;-->
                        </div>
                        <div class="col-lg-6 p-0">

                            <!-- <p class="text-white mt-3" style="font-size: 22px;
line-height: 40px;">Use  the information as it is and the icons, please don’t
forgot to place the fullstops on the sentences. The image
next to it,  Please remove it and replace with this video.</p>-->


                            <div class="row">
                                <div class="col-lg-6 pa">
                                    <div>

                                    </div>
                                    <div class=" lan">
                                        <img class="mb-2" src="<?php echo URL::to('/assets/img/lan/v3.png'); ?>" style=>
                                        <h4 class="">User Feedback and Interaction</h4>
                                        <p style="color:#fff;font-weight:500;">Learn by interacting with experts and
                                            other users.</p>
                                    </div>

                                </div>
                                <div class="col-lg-6 p-0">
                                    <div>
                                    </div>
                                    <div class="lan ">
                                        <img class="mb-2" src="<?php echo URL::to('/assets/img/lan/v4.png'); ?>" style=>
                                        <h4 class="">Aggregated User generated content</h4>
                                        <p style="color:#fff;">Create and contribute your own digital content to
                                            empower other users.</p>
                                    </div>

                                </div>
                                <div class=" col-lg-6 rated mt-3">
                                    <img class="mb-2" src="<?php echo URL::to('/assets/img/lan/v5.png'); ?>" style=>
                                    <h4 class="">Curated multiformat<br> training content</h4>
                                    <p style="color:#fff;">Diverse learning content that focuses on the visual, audio,
                                        social, solitary, verbal and logical.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 pa">

                                <div></div>

                                <div class=" lan">
                                    <img class="mb-2" src="<?php echo URL::to('/assets/img/lan/v3.png'); ?>" style=>
                                    <h4 class="">User Feedback and<br> Interaction</h4>
                                    <p style="color:#fff;font-weight:500;">Learn by interacting with experts and
                                        other users.</p>
                                </div>
                            </div>

                            <div class="col-lg-6 p-0">
                                <div></div>

                                <div class="lan ">
                                    <img class="mb-2" src="<?php echo URL::to('/assets/img/lan/v4.png'); ?>" style=>
                                    <h4 class="">Aggregated User generated content</h4>
                                    <p style="color:#fff;">Create and contribute your own digital content to
                                        empower other users.</p>
                                </div>
                            </div>

                            <div class=" col-lg-6 rated">
                                <img class="mb-2" src="<?php echo URL::to('/assets/img/lan/v5.png'); ?>" style=>
                                <h4 class="">Curated multiformat<br> training content</h4>
                                <p style="color:#fff;">Diverse learning content that focuses on the visual, audio,
                                    social, solitary, verbal and logical.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <!--<section class="sec-31 p-0" >
         <div class="pt" style="background-image:url('<?php echo URL::to('/assets/img/lan/ntv.png'); ?>');background-repeat: no-repeat;
    background-position: right bottom;
   padding:30px;">
       
        <div class="container" style="margin-top: 30px;">
             <h2 class="mb-4">Benefits you Can’t <br>
Resist</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="row mt-5 ">
                    <div class="col-lg-6 pa">
                        <div>
                             <img class="" src="<?php echo URL::to('/assets/img/lan/v1.png'); ?>" style=>
                        <h4 class="">Hours of content</h4>
                        <p style="color:#00DADA;">Watch your favorite content across Languages & topics</p>
                        </div>
                        <div class=" lan" style="margin-top:65px;">
                             <img class="" src="<?php echo URL::to('/assets/img/lan/v3.png'); ?>" style=>
                        <h4 class="">User Feedback and<br> Interaction</h4>
                        <p style="color:#00DADA;">Learn by interacting with experts and other users.</p>
                        </div>
                       
                    </div>
                    <div class="col-lg-6 p-0">
                        <div>
                        <img class="" src="<?php echo URL::to('/assets/img/lan/v2.png'); ?>" style=>
                        <h4 class="">Audience Tested</h4>
                        <p style="color:#00DADA;">Enjoy the wide variety of movies & Educations Content much more choice of Audience</p>
                        </div>
                        <div class="lan ">
                             <img class="" src="<?php echo URL::to('/assets/img/lan/v4.png'); ?>" style=>
                        <h4 class="">Aggregated User generated content</h4>
                        <p style="color:#00DADA;">Create and contribute your own digital content to empower other users.</p>
                        </div>
                         
                    </div>
                    <div class="lan col-lg-6 " style="margin-top:20px;">
                             <img class="" src="<?php echo URL::to('/assets/img/lan/v5.png'); ?>" style=>
                        <h4 class="">Curated multiformat<br> training content</h4>
                        <p style="color:#00DADA;">Diverse learning content that focuses on the visual, audio, social, solitary, verbal and logical.</p>
                        </div>
                </div>
            </div>
            
            </div></div></div>
    </section>-->

        <section class="sec-4 mt-5">
            <div class="container-fluid">
                <h2 class="text-center text-black mb-5">Members Endorsement</h2>
                <div class="row mt-4 justify-content-center">
                    <div class="col-lg-3">
                        <div class="">
                            <img class="w-50" src="<?php echo URL::to('/assets/img/lan/c1.png'); ?>" style="">
                        </div>

                        <p class=" map">“Salute has inspired me to work smarter on
                            my craft using Technology as a Dj.”</p>
                        <h4 class="text-black">LIYA NDAMASE</h4>
                        <p>Television</p>
                    </div>

                    <div class="col-lg-3">
                        <div class="">
                            <img class="w-50" src="<?php echo URL::to('/assets/img/lan/c2.png'); ?>" style="">
                        </div>
                        <p class=" map">“Through the digital marketing course on NEMISA TV. I was able to create a
                            successful online skateboard.”</p>
                        <h4 class="text-black">MUSA BALOYI</h4>
                        <p>Sound</p>
                    </div>

                    <div class="col-lg-3">
                        <div class="">
                            <img class="w-50" src="<?php echo URL::to('/assets/img/lan/c3.png'); ?>" style="">
                        </div>
                        <p class=" map">“A data free content is the next big
                            thing. I love NEMISA TV.”</p>
                        <h4 class="text-black">JOEY MANGKA</h4>
                        <p>Web Developer</p>
                    </div>
                </div>

                <!-- <div class="">
                    <p class="ital nem"> <img class="w-20" src="<?php echo URL::to('/assets/img/comma.png'); ?>" style="margin-top:-35px;">I come to NEMISA TV for the curation and class quality. That's really worth the cost of membership to me.</p>
                    <p class="text-center mt-4">—Jason R, Nemisa Student</p>
                </div>-->

                <div class="text-center mt-5 mb-3"></div>
            </div>
        </section>

        <section class="sec-31" style="padding:40px 30px 40px 30px;">
            <div class="conatiner-fluid text-center">
                <h2 class="mb-3">Hours Of Infotainment, Edutainment <br>and Entertainment</h2>

                <div class="col-lg-7 vid">
                    <video id="player2" controls autoplay poster="<?php echo URL::to('/assets/img/dan.png'); ?>">
                        <source src="<?php echo URL::to('/assets/img/dance.mp4'); ?>" type="video/mp4">
                        <source src="" type="video/ogg">
                    </video>

                    <!--<video controls crossorigin playsinline poster="<?php echo URL::to('/assets/img/dan.png'); ?>" id="player">
                            <source src="<?php echo URL::to('/assets/img/dance.mp4'); ?>" type="video/mp4">
                    </video>  -->
                </div>

                <h3 class="mt-3">FREE EDUTAINMENT for the DIGITAL WARRIOR</h3>
                <P class="text-white">advancing South Africans in enhancing their digital literacy.</P>
                <p style="color:#F6D55C">WATCH EVERYWHERE, STREAM LIVE, QUALITY VIDEOS</p>
                <div class="all-video col-lg-3">
                    <a class="btn btn-success  my-2 mr-2 my-sm-0 w-100" style="font-size:20px;"
                        href="{{ route('login') }}">Get Started</a>
                </div>
            </div>

            <div class="container-fluid mt-5">
                <!-- <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6">
                        <img class="img-lan w-100" src="<?php echo URL::to('/assets/img/m1.png'); ?>" style="">
                    </div>

                    <div class="col-lg-6 p-0">
                        <h2>Free edutainment for the digital warrior</h2>
                        <p class="text-white adv mt-4">Advancing South Africans for the future with content that is missioned to deliver tangible digital skills to bridge the digital divide.</p>
                        <p class="text-white adv mt-4">WATCH EVERYWHERE, STREAM LIVE, QUALITY VIDEOS</p>
                        <a class="btn btn-lg btn-success  my-2 mr-2 my-sm-0 btn-block" style="padding:12px;width:70%;" href="{{ route('login') }}" ><span>Get Started</span></a>
                    </div>
                </div>-->

                <div class="row mt-5">
                    <div class="col-lg-4">
                        <div class="bg-color">
                            <div class="comp">
                                <img class="" src="<?php echo URL::to('/assets/img/comp.png'); ?>" style="">
                            </div>

                            <h3>Watch Everywhere</h3>
                            <p>Watch videos, podcasts and live events
                                on your phone, tablet or laptop. No matter which device you use, we are always a click
                                away!</p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="bg-color1" style="min-height: 266px;">
                            <div class="clive">
                                <img class=" " src="<?php echo URL::to('/assets/img/clive.png'); ?>" style="">
                            </div>

                            <h3>Stream Live </h3>
                            <p>Stream unlimited videos, podcasts
                                and live events for free anytime!
                                Whenever you are in Mzansi, we
                                got you covered!
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="bg-color">
                            <div class="set">
                                <img class=" " src="<?php echo URL::to('/assets/img/set.png'); ?>" style="">
                            </div>

                            <h3>Quality Videos</h3>
                            <p>Explore our edutainment video
                                packed with 4IR and digital skills.
                                Choose from a variety of documentaries,
                                animation, radio, live shows
                                and much more...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--<div class="container">
            <div class="row  align-items-center justify-content-center height-self-center">
                <div class="col-lg-6 col-12 col-md-12 align-self-center">
                    <div class="text-center">
                        <img src="<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->logo; ?>"  style="margin-bottom:1rem;">
                    </div>
                </div>
            </div>
        </div>-->

    </section>

    <section style="background:url('<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
        @section('content')

            <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));
            
            $jsondata = json_decode($jsonString, true); ?>

            <?php
            $ref = Request::get('ref');
            $coupon = Request::get('coupon');
            ?>

        </section>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // This is the bare minimum JavaScript. You can opt to pass no arguments to setup.
                const player = new Plyr('#player1');

                // Expose
                window.player = player;

                // Bind event listener
                function on(selector, type, callback) {
                    document.querySelector(selector).addEventListener(type, callback, false);
                }

                // Play
                on('.js-play', 'click', () => {
                    player.play();
                });

                // Pause
                on('.js-pause', 'click', () => {
                    player.pause();
                });

                // Stop
                on('.js-stop', 'click', () => {
                    player.stop();
                });

                // Rewind
                on('.js-rewind', 'click', () => {
                    player.rewind();
                });

                // Forward
                on('.js-forward', 'click', () => {
                    player.forward();
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const player = new Plyr('#player2');

                // Expose
                window.player = player;

                // Bind event listener
                function on(selector, type, callback) {
                    document.querySelector(selector).addEventListener(type, callback, false);
                }

                // Play
                on('.js-play', 'click', () => {
                    player.play();
                });

                // Pause
                on('.js-pause', 'click', () => {
                    player.pause();
                });

                // Stop
                on('.js-stop', 'click', () => {
                    player.stop();
                });

                // Rewind
                on('.js-rewind', 'click', () => {
                    player.rewind();
                });

                // Forward
                on('.js-forward', 'click', () => {
                    player.forward();
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // This is the bare minimum JavaScript. You can opt to pass no arguments to setup.
                const player = new Plyr('#player');

                // Expose
                window.player = player;

                // Bind event listener
                function on(selector, type, callback) {
                    document.querySelector(selector).addEventListener(type, callback, false);
                }

                // Play
                on('.js-play', 'click', () => {
                    player.play();
                });

                // Pause
                on('.js-pause', 'click', () => {
                    player.pause();
                });

                // Stop
                on('.js-stop', 'click', () => {
                    player.stop();
                });

                // Rewind
                on('.js-rewind', 'click', () => {
                    player.rewind();
                });

                // Forward
                on('.js-forward', 'click', () => {
                    player.forward();
                });
            });
        </script>

        <script>
            function Series_Category(ele) {

                var category_id = $(ele).attr('data-category-id');

                $.ajax({
                    type: "get",
                    url: "{{ route('landing_category_series') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        category_id: category_id,
                    },
                    success: function(data) {
                        $(".data").html(data);
                    },
                });
            }
        </script>

        @php
            include public_path('themes/theme5-nemisha/views/footer.blade.php');
        @endphp
