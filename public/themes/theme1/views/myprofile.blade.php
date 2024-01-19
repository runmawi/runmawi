@php
    include public_path('themes/theme1/views/header.php');
    $settings = App\Setting::first();
@endphp


<style>
    svg {
        height: 30px;
    }

    #main-header {
        color: #fff;
    }

    .svg {
        color: #fff;
    }

    .form-control {
        height: 45px;
        line-height: 29px !important;
        background: #33333391;
        border: 1px solid var(--iq-body-text);
        font-size: 14px;
        color: var(--iq-secondary);
        border-radius: 4px;
    }

    .sign-user_card input {
        background-color: rgb(255 255 255) !important;
    }

    /* profile */
    .col-md-12.profile_image {
        display: flex;
    }

    .showSingle {
        cursor: pointer;
    }

    .red {
        color: #be0b14;
    }

    .btn_prd_up_22:after {
        position: absolute;
        left: 33.7%;
        top: -8%;
        bottom: calc(50% + 8px);
        width: 1px;
        height: calc(245px - 19px);
        transform: rotate(90deg);
        background: #fff;
        content: "";
        z-index: 0;
    }

    .btn_prd_up_33:after {
        position: absolute;
        left: 65.7%;
        top: -8%;
        bottom: calc(50% + 8px);
        width: 1px;
        height: calc(245px - 19px);
        transform: rotate(90deg);
        background: #fff;
        content: "";
        z-index: 0;
    }

    input[type='radio']:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #d1d3d1;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;
    }

    ul {
        list-style: none;
    }

    .gk {
        background: #2a2a2c;

        border-bottom: 1px solid #fff;
    }

    .transpar {
        border: 1px solid #ddd;
        background-color: transparent;
        padding: 10px 40px;
        color: #fff !important;


    }

    .sig {
        background: #161617;
        mix-blend-mode: normal;
        padding: 50px;
        border-radius: 20px;
    }

    .sig1 {
        background: #151516;
        mix-blend-mode: normal;
        padding: 25px;
        border-radius: 20px;
    }

    .btn {

        padding: 15px 120px;
        color: #fff !important;

        border: 1px solid #fff;
        background-color: transparent;
    }

    .ply {
        background: #000;

        padding: 10px;
        border-radius: 50%;
    }

    img.multiuser_img {
        padding: 10px;
        border-radius: 50%;
    }

    .bg-col p {
        font-family: Chivo;
        font-style: normal;
        font-weight: 400;
        font-size: 26px;
        line-height: 31px;
        /* identical to box height */
        padding-top: 10px;
        display: flex;
        align-items: center;

        color: #FFFFFF;
    }

    .container h1 {
        padding-left: 10px;
    }

    .bg-col {
        background: rgb(32, 32, 32);

        mix-blend-mode: color-dodge;
        border-radius: 20px;
        padding: 10px;
        color: #fff;
        height: 150px;
        padding-left: 90px;


    }

    .bl {
        background: #161617;
        padding: 10px;


    }

    .name {
        font-size: larger;
        font-family: auto;
        color: white;
        text-align: center;
    }

    .edit li {
        list-style: none;
        padding: 10px 10px;
        color: #fff;
        line-height: 31px;
    }

    .dl1 {
        font-weight: 100;
        font-size: 40px;
    }

    .circle {
        color: white;
        position: absolute;
        margin-top: -6%;
        margin-left: 20%;
        margin-bottom: 0;
        margin-right: 0;
    }

    .dl {
        font-size: 16px;
    }

    .black-text {
        color: black;
    }
</style>

<body>



    @php
        $jsonString = file_get_contents(base_path('assets/country_code.json'));
        $jsondata = json_decode($jsonString, true);
    @endphp


    <div class="main-content">

        <div class="row">

            <!-- TOP Nav Bar -->
            <div class="iq-top-navbar">
                <div class="iq-navbar-custom">
                    <nav style="display:none;" class="navbar navbar-expand-lg navbar-light p-0">
                        <div class="iq-menu-bt d-flex align-items-center">
                            <div class="wrapper-menu">
                                <div class="main-circle"><i class="las la-bars"></i></div>
                            </div>
                            <div class="iq-navbar-logo d-flex justify-content-between">
                                <a href="<?php echo URL::to('home'); ?>" class="header-logo">
                                    <div class="logo-title">
                                        <span class="text-primary text-uppercase"><?php $settings = App\Setting::first();
                                        echo $settings->website_name; ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list">
                                <li class="nav-item nav-icon">
                                    <a type="button"
                                        class="btn btn-primary  noborder-radius btn-login nomargin visitbtn"
                                        href="<?php echo URL::to('home'); ?>"><span>{{ __('Visit site') }}</span></a>
                                </li>
                                <li class="line-height pt-3">
                                    <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                                        <img src="<?php echo URL::to('/') . '/public/uploads/avatars/' . Auth::user()->avatar; ?>" class="img-fluid avatar-40 rounded-circle"
                                            alt="user">
                                    </a>
                                    <div class="iq-sub-dropdown iq-user-dropdown">
                                        <div class="iq-card shadow-none m-0">
                                            <div class="iq-card-body p-0 ">
                                                <div class="bg-primary p-3">
                                                    <h5 class="mb-0 text-white line-height">{{ __('Hello Barry Tech') }}
                                                    </h5>
                                                    <span class="text-white font-size-12">{{ __('Available') }}</span>
                                                </div>
                                                <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                                                    <div class="media align-items-center">
                                                        <div class="rounded iq-card-icon iq-bg-primary">
                                                            <i class="ri-file-user-line"></i>
                                                        </div>
                                                        <div class="media-body ml-3">
                                                            <h6 class="mb-0 ">{{ __('My Profile') }}</h6>
                                                            <p class="mb-0 font-size-12">
                                                                {{ __('View personal profile details') }}.</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-hover">
                                                    <div class="media align-items-center">
                                                        <div class="rounded iq-card-icon iq-bg-primary">
                                                            <i class="ri-profile-line"></i>
                                                        </div>
                                                        <div class="media-body ml-3">
                                                            <h6 class="mb-0 ">{{ __('Edit Profile') }}</h6>
                                                            <p class="mb-0 font-size-12">
                                                                {{ __('Modify your personal details') }}.</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="account-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                                    <div class="media align-items-center">
                                                        <div class="rounded iq-card-icon iq-bg-primary">
                                                            <i class="ri-account-box-line"></i>
                                                        </div>
                                                        <div class="media-body ml-3">
                                                            <h6 class="mb-0 ">{{ __('Account settings') }}</h6>
                                                            <p class="mb-0 font-size-12">
                                                                {{ __('Manage your account parameters') }}.</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="privacy-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                                    <div class="media align-items-center">
                                                        <div class="rounded iq-card-icon iq-bg-primary">
                                                            <i class="ri-lock-line"></i>
                                                        </div>
                                                        <div class="media-body ml-3">
                                                            <h6 class="mb-0 ">{{ __('Privacy Settings') }}</h6>
                                                            <p class="mb-0 font-size-12">
                                                                {{ __('Control your privacy parameters') }}.</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="d-inline-block w-100 text-center p-3">
                                                    <a class="bg-primary iq-sign-btn" href="#"
                                                        role="button">{{ __('Sign out') }}<i
                                                            class="ri-login-box-line ml-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- TOP Nav Bar END -->

        </div>

        <!--<hr />-->

        <!-- MainContent -->
        <section class="m-profile setting-wrapper pt-0">
            <div class="container">

                {{-- message --}}
                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                <div class="row sig ">
                    <div class="col-md-4 mt-3 pt-3">
                        <h4 class="main-title mb-4">{{ __('My Account') }}</h4>
                        <p class="text-white">{{ __('Edit your name or change') }}<br>{{ __('your password') }}.</p>
                        <ul class="edit p-0 mt-5">
                            <li>
                                <div class="d-flex showSingle" target="1">
                                    <a>
                                        <img class="ply mr-3" src="<?php echo URL::to('/') . '/assets/img/edit.png'; ?>">
                                        {{ __('Edit Profile') }}
                                    </a>
                                </div>
                            </li>
                            <!-- <li><div class="d-flex showSingle" target="3">
                                <a>
                            <img class="ply mr-3" width="38" height="33" src="<?php echo URL::to('/') . '/assets/img/kids.png'; ?>">
                            {{ __('Kids zone') }}
                                </a>
                        </div></li> -->
                            <li>
                                <div class="d-flex showSingle" target="4">
                                    <a>
                                        <img class="ply mr-3" src="<?php echo URL::to('/') . '/assets/img/video.png'; ?>">
                                        {{ __('Video preferences') }}
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex " target="#">
                                    <?php if(Auth::User()->role == "registered"){ ?>
                                    <a href="<?= URL::to('/becomesubscriber') ?>">
                                        <img class="ply mr-3" src="<?php echo URL::to('/') . '/assets/img/plan.png'; ?>">
                                        {{ __('Plan') }}
                                    </a>
                                    <?php } ?>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex showSingle" target="2">
                                    <?php if(Auth::User()->role == "subscriber"){ ?>
                                    <!-- <a href="<?= URL::to('/upgrade-subscription_plan') ?>"> -->
                                    <img class="ply mr-3" src="<?php echo URL::to('/') . '/assets/img/plan.png'; ?>">
                                    {{ __('Plan') }}
                                    <!-- </a> -->
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-8 targetDiv" id="div1">

                        <div class="col-sm-3 d-flex  justify-content-end flex-column ">
                            <img class="rounded-circle img-fluid d-block ml-auto mb-3"
                                src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar ?>"
                                alt="profile-bg"/ style="" width="150">
                            <div class="d-flex justify-content-end">
                                <a href="<?php echo URL::to('logout'); ?>" class="transpar">{{ __('logout') }}</a>
                            </div>
                        </div>


                        <div class=" mb-3" id="personal_det">
                            <div class="col-md-12 text-rigth mt-4">
                                <div class="d-flex align-items-baseline justify-content-between">
                                    <div>
                                        <h5 class="mb-2 pb-3 ">{{ __('Personal Details') }}</h5>
                                    </div>
                                    <div><a href="javascript:;" onclick="jQuery('#add-new').modal('show');"
                                            class="Text-white" style="color: #fff!important;"><i
                                                class="fa fa-plus-circle"></i>{{ __('Edit') }} </a>
                                    </div>
                                </div>
                            </div>
                            <div class="a-border"></div>
                            <div class="row  text-right justify-content-between mt-3 mb-3">
                                <h4 class="p-3">{{ __('Account Details') }}</h4>
                                <div class="col-md-6 ">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-light font-size-13">{{ __('First Name') }}</span>
                                        <p class="mb-0">ALB</p>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-light font-size-13">{{ __('Last Name') }}</span>
                                        <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-light font-size-13">{{ __('Password') }}</span>
                                        <p class="mb-0">**********</p>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-light font-size-13">{{ __('Username') }}</span>
                                        <p class="mb-0">
                                            <?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-light font-size-13">{{ __('Email') }}</span>
                                        <p class="mb-0"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <hr style="color:#fff;">
                            <div class="row align-items-center text-right justify-content-between mt-3 mb-3">
                                <div class="col-md-6 d-flex justify-content-between mt-2">
                                    <span class="text-light font-size-13">{{ __('Phone') }}</span>
                                    <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></p>
                                </div>
                                <div class="col-md-6 d-flex justify-content-between mt-2">
                                    <span class="text-light font-size-13">{{ __('Country') }}</span>
                                    <p class="mb-0">{{ __('India') }}</p>
                                </div>

                            </div>
                            <div class="row align-items-center text-right justify-content-between mt-3 mb-3">
                                <div class="col-md-6 d-flex justify-content-between mt-2">
                                    <span class="text-light font-size-13">{{ __('DOB') }}</span>
                                    <p class="mb-0"><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="color:#fff;">
                    <div class="col-md-8 targetDiv" id="div2">
                        <div class="d-flex justify-content-around text-white">
                            <div class="d-felx text-center">
                                <p>{{ __('Choose plan') }}</p>
                                <input type="radio">
                                <ul>
                                    <li class="btn_prd_up_22"></li>
                                </ul>
                            </div>
                            <div class="d-felx text-center">
                                <p>{{ __('Make payment') }}</p>
                                <input type="radio">
                                <ul>
                                    <li class="btn_prd_up_33"></li>
                                </ul>
                            </div>
                            <div class="d-felx text-center">
                                <p>{{ __('Confirmation') }}</p>
                                <input type="radio">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="bg-col">
                                <div class="container ">

                                    <p>{{ __('Existing Plan') }} : </p>

                                    <?php  if($user_role == 'registered'){ ?>
                                    <h6><?php echo 'Registered' . ' ' . '(Free)'; ?></h6>
                                    <h6>{{ __('Subscription') }}</h6>
                                    <?php }elseif($user_role == 'subscriber'){ ?>
                                    <h6><?php echo $role_plan . ' ' . '(Paid User)'; ?></h6>
                                    <br>
                                    <h5 class="card-title mb-0">{{ __('Available Specification') }} :</h5><br>
                                    <h6>{{ __('Video Quality') }} : <p> <?php if ($plans != null) {
                                        $plans->video_quality;
                                    } else {
                                        ' ';
                                    } ?></p>
                                    </h6>
                                    <h6> {{ __('Video Resolution') }} : <p> <?php if ($plans != null) {
                                        $plans->resolution;
                                    } else {
                                        ' ';
                                    } ?> </p>
                                    </h6>
                                    <h6> {{ __('Available Devices') }} : <p> <?php if ($plans != null) {
                                        $plans->devices_name;
                                    } else {
                                        ' ';
                                    } ?> </p>
                                    </h6>
                                    <!--<h6>Subscription</h6>-->
                                    <?php } ?>

                                    <!-- <h1><span class="dl">$</span>1197 <span>for 9 months</span></h1></div> -->
                                </div>
                                <br>

                                <a href="<?= URL::to('/upgrade-subscription_plan') ?>"
                                    class="btn btn-primary editbtn">{{ __('Upgrade Plan') }} </a>
                                <br>

                            </div>

                        </div>
                    </div>
                  

                    <div class="col-md-8 targetDiv" id="div4">
                        <div class=" mb-3">
                            <h4 class="card-title mb-0">{{ __('Preference for videos') }}</h4>
                            <form action="{{ URL::to('admin/profilePreference') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                                <div class="form-group  mt-4 pt-5">
                                    <div class="col-md-6 p-0">
                                        <label>
                                            <h5 class="mb-4">{{ __('Preference Language') }}</h5>
                                        </label>

                                        <select id="" name="preference_language[]"
                                            class="js-example-basic-multiple myselect col-md-5"
                                            style="width: 46%!important;" multiple="multiple">
                                            @foreach ($preference_languages as $preference_language)
                                                <option value="{{ $preference_language->id }}" @if( !empty(json_decode($user->preference_language)) && in_array( $preference_language->id, json_decode($user->preference_language) ))selected='selected' @endif >{{ $preference_language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group  mt-4">
                                    <div class="col-sm-6 p-0">
                                        <label>
                                            <h5 class="mb-4">{{ __('Preference Genres') }}</h5>
                                        </label>

                                        <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect" style="width: 46%;" multiple="multiple">
                                            @foreach ($videocategory as $preference_genres)
                                                <option value="{{ $preference_genres->id }}" @if( !empty(json_decode($user->preference_genres)) && in_array( $preference_genres->id, json_decode($user->preference_genres) ))selected='selected' @endif >{{ $preference_genres->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="">
                                    <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2"
                                        type="submit" name="create-account"
                                        value="<?= __('Update Profile') ?>">{{ __('Update Profile') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

    </div>
    </section>

    <!--<section  class="m-profile setting-wrapper pt-0  mt-4">
        <div class="container">
            <div class="sig1">
               <h2 class="text-center mt-2 mb-3">Subscribe to Watch All </h2>
                <div class="" style="padding:50px!important;">
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">All Content Movies, Live sports, TV, Special Shows</p>
                    </div>
                    <div class="col-md-2">
                        <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/') . '/assets/img/tic.png'; ?>">
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/') . '/assets/img/tic.png'; ?>">
                    </div>
                </div>
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">Watch on TV or Laptopt</p>
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/') . '/assets/img/tic.png'; ?>">
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/') . '/assets/img/tic.png'; ?>">
                    </div>
                </div>
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">Ads Free Movies & Shows</p>
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/') . '/assets/img/tic.png'; ?>">
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/') . '/assets/img/tic.png'; ?>">
                    </div>
                </div>
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">Number of devices that can be logged in</p>
                    </div>
                    <div class="col-md-2 text-white">2</div>
                    <div class="col-md-2 text-white">4</div>
                </div>
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">Max Video Quality</p>
                    </div>
                    <div class="col-md-2 text-white">Full HD (1080p)</div>
                    <div class="col-md-2 text-white">4K (2160p)</div>
                </div>
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">Max Audio Quality</p>
                    </div>
                    <div class="col-md-2 text-white">Dolby 5.1</div>
                    <div class="col-md-2 text-white">Dolby 5.1</div>
                </div>
                    <div class="row  pt-3 ">
                        <div class="col-md-5 mr-3">
                            <a class=" btn" herf=""><span class="red">Super</span> $899/year</a>
                        </div>
                        <div class="col-md-5 ml-5">
                             <a class="btn" herf=""><span class="red">premium </span> $1499/year</a>
                        </div>
                    </div>
            </div>
        </div>
            <div style="background: #2a2a2c;
border-radius: 5px;padding:10px;">
            <p class="text-white mt-3 text-center">Continue with Super ></p>
        </div>
     </div>
        
    </section>-->
    <!-- <section class="m-profile setting-wrapper pt-0">
        <div class="container">
            
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="sign-user_card text-center mb-3">
                       

                    </div>
<div class="row">
<?php

?>

        <div class="col-sm-12">
            <div class="sign-user_card text-center mb-3">
            <?php if ( Auth::user()->role != 'admin') { ?>
                <div class="row">
                    <?php if (Auth::user()->role == 'subscriber' && empty(Auth::user()->paypal_id)){ 
                       ?>
                        <h3> Plan Details:</h3>
                        <p style="margin-left: 19px;margin-top: 8px"><?php if (!empty(Auth::user()->stripe_plan)) {
                            echo CurrentSubPlanName(Auth::user()->id);
                        } else {
                            echo 'No Plan you were choosed   ';
                        } ?></p>
                    <?php } ?>
                        <div class="col-sm-12 col-xs-12 padding-top-30">
                        <?php 
                        $paypal_id = Auth::user()->paypal_id;
                        if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus() )  ) {
                        $paypal_subscription = PaypalSubscriptionStatus();
                        } else {
                        $paypal_subscription = "";  
                        }

                        $stripe_plan = SubscriptionPlan();
                        if ( $user->subscribed($stripe_plan) && empty(Auth::user()->paypal_id) ) { 
                        if ($user->subscription($stripe_plan)->ended()) { ?>
                        <a href="<?= URL::to('/renew') ?>" class="btn btn-primary noborder-radius margin-bottom-20" > Renew Subscription</a>
                        <?php } else { ?>
                        <a href="<?= URL::to('/cancelSubscription') ?>" class="btn btn-danger noborder-radius margin-bottom-20" > Cancel Subscription</a>
                        <!-- <a href="<?//URL::to('/cancelSubscription');?>" class="btn btn-primary" >Cancel Subscription</a>
                        <?php  } } 
                        elseif(!empty(Auth::user()->paypal_id) && $paypal_subscription !="ACTIVE" )
                        {   ?>
                            <a href="<?= URL::to('/becomesubscriber') ?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>

                        <?php } else { echo $paypal_subscription; ?>
                        <a href="<?= URL::to('/becomesubscriber') ?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                        <?php } ?>
                        </div>

                        <div class="col-sm-12 col-xs-12 padding-top-30">
                            <?php
                            $billing_url = URL::to('/') . '/paypal/billings-details';
                            if (!empty(Auth::user()->paypal_id)) {
                                echo "<p><a href='" . $billing_url . "' class='plan-types'> <i class='fa fa-caret-right'></i> View Billing Details</a></p>";
                            }
                            ?>
                            <?php if ( $user->subscribed($stripe_plan) ) { 
                            if ($user->subscription($stripe_plan)->ended()) { ?>
                            <p><a href="<?= URL::to('/renew') ?>" class="plan-types" ><i class="fa fa-caret-right"></i> Renew Subscription</a></p>
                            <?php } else { ?>
                            <p><a href="<?= URL::to('/upgrade-subscription') ?>" class="plan-types" ><i class="fa fa-caret-right"></i> Change Plan</a></p>
                            <?php  } } ?>

                            <?php if ($user->subscribed($stripe_plan) && $user->subscription($stripe_plan)->onGracePeriod()) { ?>
                            <p><a href="<?= URL::to('/renew') ?>" class="plan-types" > Renew Subscription</a></p>
                            <?php } ?>

                            <?php if ($user->subscribed($stripe_plan)) { ?>
                            <a href="<?= URL::to('/stripe/billings-details') ?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>
                            <?php } ?>
                        </div>
                    </div>
            <?php } ?>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="sign-user_card text-center mb-3">
                <a href="<?= URL::to('/transactiondetails') ?>" class="btn btn-primary btn-login nomargin noborder-radius" >View Transaction Details</a>
            </div>
        </div>
</div>
                </div>
                <div class="col-lg-8"> <!--style="margin-left: 66%;margin-right: 13%;padding-left: 1%;padding-bottom: 0%;"
                    <div class="sign-user_card mb-3" id="personal_det">
                    <div class="col-md-12" >
                        <div class="d-flex align-items-baseline justify-content-between">
                        <div><h5 class="mb-2 pb-3 ">Personal Details</h5></div>
                        <div><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Change</a>
                            </div></div>
                        </div>
                        <div class="a-border"></div>
                        <div class="row align-items-center justify-content-between mb-3">
                            <div class="col-md-8">
                                <span class="text-light font-size-13">Email</span>
                                <p class="mb-0"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center justify-content-between mb-3">
                            <div class="col-md-8">
                                <span class="text-light font-size-13">Username</span>
                                <p class="mb-0"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center justify-content-between mb-3">
                            <div class="col-md-8">
                                <span class="text-light font-size-13">Password</span>
                                <p class="mb-0">**********</p>
                            </div>
                        </div>
                        <div class="row align-items-center justify-content-between mb-3">
                            <div class="col-md-8">
                                <span class="text-light font-size-13">Phone</span>
                                <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></p>
                            </div>

                        </div> </div>
                        <!-- Add New Modal -->
    <div class="modal fade" id="add-new">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title black-text">{{ __('Update Profile') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}"
                        enctype="multipart/form-data" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                        <div class="form-group">
                            <label> {{ __('Username') }}:</label>
                            <input type="text" id="username" name="username"
                                value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>"
                                class="form-control" placeholder="{{ __('username') }}">
                        </div>

                        <div class="form-group">
                            <label> {{ __('Email') }}:</label>
                            <input type="email" readonly id="email" name="email"
                                value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>"
                                class="form-control" placeholder="{{ __('Email') }}">
                        </div>


                        <div class="form-group">
                            <label>{{ __('Password') }}:</label><br>
                            <input type="password" name="password" value=""
                                placeholder="{{ __('Password') }}" class="form-control">
                            <!-- <input type="password"  name="password"  value="" placeholder="Password"  class="form-control"  > -->
                        </div>

                        <div class="form-group">
                            <label>{{ __('Image') }}:</label><br>
                            <input type="file" multiple="true" class="form-control" name="avatar"
                                id="avatar" required />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Phone') }} :</label>
                            <input type="number" id="mobile" pattern="/^-?\d+\.?\d*$/"
                                onkeypress="if(this.value.length==10) return false;" name="mobile"
                                value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>"
                                class="form-control" placeholder="{{ 'Mobile Number' }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('DOB') }} :</label>
                            <input type="date" id="DOB" name="DOB"
                                value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" style="padding: 9px 30px !important;" class="btn btn-primary"
                        data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" style="padding: 9px 30px !important;" class="btn btn-primary"
                        id="submit-new-cat">{{ __('Save changes') }}</button>
                </div>
            </div>
        </div>
        <style>
            .form-control {
                background-color: #F2F5FA;
                border: 1px solid transparent;
                height: 45px;
                position: relative;
                color: #000000 !important;
                font-size: 16px;
                width: 100%;
                -webkit-border-radius: 6px;
                height: 45px;
                border-radius: 4px;
            }
        </style>



        <div class="clear"></div>
        <form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8"
            file="1" enctype="multipart/form-data">
            <div class="well row">
                <!--<div class="col-sm-6 col-xs-12">
     <div class="row">
      <div class="col-sm-12 col-xs-12">
       <label for="avatar">My Avatar - Elite_<?php echo $user->id; ?></label>
       <div id="user-badge">
        <img src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar ?>" />
        <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
       </div>
      </div>
     </div>
    </div>-->
                <!--popup-->
                <div class="form-popup " id="myForm"
                    style="background:url(<?php echo URL::to('/') . '/assets/img/Landban.png'; ?>) no-repeat;	background-size: cover;padding:40px;display:none;">
                    <div class="col-sm-4 details-back">
                        <div class="row data-back">
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>{{ __('Oh snap!') }}</strong> <?= $errors->first('name') ?></div>
                                <?php endif; ?>
                                <label for="username" class="lablecolor"><?= __('Username') ?></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>{{ __('Oh snap!') }}</strong> <?= $errors->first('email') ?></div>
                                <?php endif; ?>
                                <label for="email"><?= __('Email') ?></label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>{{ __('Oh snap!') }}</strong> <?= $errors->first('name') ?></div>
                                <?php endif; ?>
                                <label for="username" class="lablecolor"><?= __('Phone Number') ?></label>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <select name="ccode">
                                            @foreach ($jsondata as $code)
                                                <option value="{{ $code['dial_code'] }}" <?php if ($code['dial_code'] == $user->ccode) {
                                                    echo "selected='selected'";
                                                } ?>>
                                                    {{ $code['name'] . ' (' . $code['dial_code'] . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" class="form-control" name="mobile" id="mobile"
                                            value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <label for="password"><?= __('Password') ?>
                                    {{ __('(leave empty to keep your original password)') }}</label>
                                <input type="password" class="form-control" name="password" id="password" />
                            </div>
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            <div class="col-sm-12 col-xs-12 mt-3">
                                <input type="submit" value="<?= __('Update Profile') ?>" class="btn btn-primary" />
                                <button type="button" class="btn btn-primary"
                                    onclick="closeForm()">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" id="subscribe">
                    <!--                    <a href="<?= URL::to('/becomesubscriber') ?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                    <a href="<?= URL::to('/stripe/billings-details') ?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>-->


                </div>

            </div>
            <div class="clear"></div>
        </form>
    </div>
    </div>

    </div>
    </div>
    </div>
    <!--</div>-->


    </div>
    <?php $settings = App\Setting::first(); ?>


    <!-- back-to-top End -->
    <!-- back-to-top End -->
    <!-- jQuery, Popper JS -->
    <script src="<?= URL::to('/') . '/assets/js/jquery-3.4.1.min.js' ?>"></script>
    <script src="<?= URL::to('/') . '/assets/js/popper.min.js' ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?= URL::to('/') . '/assets/js/bootstrap.min.js' ?>"></script>
    <!-- Slick JS -->
    <script src="<?= URL::to('/') . '/assets/js/slick.min.js' ?>"></script>
    <!-- owl carousel Js -->
    <script src="<?= URL::to('/') . '/assets/js/owl.carousel.min.js' ?>"></script>
    <!-- select2 Js -->
    <script src="<?= URL::to('/') . '/assets/js/select2.min.js' ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Magnific Popup-->
    <script src="<?= URL::to('/') . '/assets/js/jquery.magnific-popup.min.js' ?>"></script>
    <!-- Slick Animation-->
    <script src="<?= URL::to('/') . '/assets/js/slick-animation.min.js' ?>"></script>
    <!-- Custom JS-->
    <script src="<?= URL::to('/') . '/assets/js/custom.js' ?>"></script>
    <script>
        $(document).ready(function() {

            $(".tv-code").click(function() {
                $('#tv-code').submit();
            });
        });
        $(document).ready(function() {
            $(".thumb-cont").hide();
            $(".show-details-button").on("click", function() {
                var idval = $(this).attr("data-id");
                $(".thumb-cont").hide();
                $("#" + idval).show();
            });
            $(".closewin").on("click", function() {
                var idval = $(this).attr("data-id");
                $(".thumb-cont").hide();
                $("#" + idval).hide();
            });
        });
    </script>
    <script>
        function about(evt, id) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {

            }

            document.getElementById(id).style.display = "block";

        }
        // Get the element with id="defaultOpen" and click on it
        //document.getElementById("defaultOpen").click();
    </script>
    <!--<script>
        // Prevent closing from click inside dropdown
        $(document).on('click', '.dropdown-menu', function(e) {
            e.stopPropagation();
        });

        // make it as accordion for smaller screens
        if ($(window).width() < 992) {
            $('.dropdown-menu a').click(function(e) {
                e.preventDefault();
                if ($(this).next('.submenu').length) {
                    $(this).next('.submenu').toggle();
                }
                $('.dropdown').on('hide.bs.dropdown', function() {
                    $(this).find('.submenu').hide();
                })
            });
        }
    </script>-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.searches').on('keyup', function() {
                var query = $(this).val();
                //alert(query);
                // alert(query);
                if (query != '') {
                    $.ajax({
                        url: "<?php echo URL::to('/search'); ?>",
                        type: "GET",
                        data: {
                            'country': query
                        },
                        success: function(data) {
                            $('.search_list').html(data);
                        }
                    })
                } else {
                    $('.search_list').html("");
                }
            });
            $(document).on('click', 'li', function() {
                var value = $(this).text();
                $('.search').val(value);
                $('.search_list').html("");
            });
        });
    </script>
    <!--<script>
        window.onscroll = function() {
            myFunction()
        };

        var header = document.getElementById("myHeader");
        var sticky = header.offsetTop;

        function myFunction() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    </script>-->

</body>

</html>



<?php
if (isset($page) && $page == 'admin-dashboard') {
    $visitor_count = TotalVisitorcount();
    $chart_details = "[$total_subscription, $total_recent_subscription, $total_videos, $visitor_count]";
    $chart_lables = "['Total Subscribers', 'New Subscribers', 'Total Videos', 'Total Visitors']";
    $all_category = App\VideoCategory::all();
    $items = [];
    $lastmonth = [];
    foreach ($all_category as $category) {
        $categoty_sum = App\Video::where('video_category_id', '=', $category->id)->sum('views');
        $items[] = "'$category->name'";
        $lastmonth[] = "'$categoty_sum'";
    }
    $cate_chart = implode(',', $items);
    $last_month_chart = implode(',', $lastmonth);
}
?>



<!--@yield('javascript')-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>




<script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
        document.getElementById("personal").style.display = "none";
        document.getElementById("subplan").style.display = "none";
        document.getElementById("Profile").style.display = "none";
        document.getElementById("card").style.display = "none";
        document.getElementById("subscribe").style.display = "none";
        document.getElementById("avatar").style.display = "none";
        document.getElementById("recentviews").style.display = "none";
    }
</script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            width: '100%',
            placeholder: "Select an option",
        });

    });
</script>

<script>
    function closeForm() {
        document.getElementById("myForm").style.display = "none";
        document.getElementById("personal").style.display = "block";
        document.getElementById("subplan").style.display = "block";
        document.getElementById("Profile").style.display = "block";
        document.getElementById("card").style.display = "block";
        document.getElementById("subscribe").style.display = "block";
        document.getElementById("avatar").style.display = "block";
        document.getElementById("recentviews").style.display = "block";
    }
</script>

<?php  if (isset($page) && $page =='admin-dashboard') { ?>
<script>
    $(document).ready(function() {
        if (jQuery('#view-chart-01').length) {

            var chart_01_lable = $('#chart_01_lable').val();
            //alert(chart_01_lable);
            var options = {
                series: <?php echo $chart_details; ?>,
                chart: {
                    width: 250,
                    type: 'donut',
                },
                colors: ['#e20e02', '#f68a04', '#007aff', '#545e75'],
                labels: <?php echo $chart_lables; ?>,
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: false,
                    width: 0
                },
                legend: {
                    show: false,
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            console.log(chart_01_lable);
            var chart = new ApexCharts(document.querySelector("#view-chart-01"), options);
            chart.render();
        }

        if (jQuery('#view-chart-02').length) {
            var options = {
                series: [44, 30, 20, 43, 22, 20],
                chart: {
                    width: 250,
                    type: 'donut',
                },
                colors: ['#e20e02', '#83878a', '#007aff', '#f68a04', '#14e788', '#545e75'],
                labels: <?php echo '[' . $cate_chart . ']'; ?>,
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: false,
                    width: 0
                },
                legend: {
                    show: false,
                    formatter: function(val, opts) {
                        return val + " - " + opts.w.globals.series[opts.seriesIndex]
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#view-chart-02"), options);
            chart.render();
        }

        //category chart 


        if (jQuery('#view-chart-03').length) {
            var options = {
                series: [{
                    name: 'This Month',
                    data: [44, 55, 30, 60, 7000]
                }, {
                    name: 'Last Month',
                    data: [35, 41, 20, 40, 100]
                }],
                colors: ['#e20e02', '#007aff'],
                chart: {
                    type: 'bar',
                    height: 230,
                    foreColor: '#D1D0CF'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: <?php echo '[' . $cate_chart . ']'; ?>,
                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    enabled: false,
                    y: {
                        formatter: function(val) {
                            return "$ " + val + " thousands"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#view-chart-03"), options);
            chart.render();
        }
    });
</script>
<?php } ?>
<script>
    $(".targetDiv").hide();
    $(".targetDiv#div1").show();
    $(".showSingle .dimg").hide();




    jQuery(function() {
        jQuery('#showall').click(function() {
            jQuery('.targetDiv').show();
            jQuery('.showSingle .limg').show();

        });
        jQuery('.showSingle').click(function() {
            jQuery('.targetDiv').hide();
            jQuery('.showSingle .dimg').hide();
            jQuery('#div' + $(this).attr('target')).show();
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {


        // Add New Category
        $('#submit-new-cat').click(function() {
            $('#new-cat-form').submit();
        });
    });

    $(document).ready(function() {
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
@php
    include public_path('themes/theme1/views/footer.blade.php');
@endphp
