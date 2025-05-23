<!doctype html>
<html lang="en-US">

<head>

    <?php
    $uri_path = $_SERVER['REQUEST_URI'];
    $uri_parts = explode('/', $uri_path);
    $request_url = end($uri_parts);
    $uppercase = ucfirst($request_url);
    // dd(Auth::User()->id);
    ?>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name; ?>
    <title><?php echo $uppercase . ' | ' . $settings->website_name; ?></title>
    <meta name="description" content="<?php echo $settings->website_description; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/css/bootstrap.min.css' ?>" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/css/typography.css' ?>" />
    <!-- Style -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/css/style.css' ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caladea:wght@400;700&family=Inter:wght@100;300&family=Poppins:wght@300&display=swap"
        rel="stylesheet">
    <!-- Responsive -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/css/responsive.css' ?>" />
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/css/slick.css' ?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

</head>
<style>
    .btn {
        background-color: #8a0303 !important;
    }

    .m-profile {
        min-height: 100vh;
    }

    .img-fluid {
        min-height: 0px !important;
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

    .profile-bg {
        height: 100px;
        width: 150px !important;
    }

    .img-fluid {
        min-height: 0px !important;
    }

    img.multiuser_img {
        padding: 9%;
        border-radius: 70%;
    }

    .round:hover {
        color: #000 !important;
    }

    .name {
        font-size: larger;
        font-family: auto;
        color: white;
        text-align: center;
    }

    .bdr {}

    .round {
        padding: 10px 20px;
        padding: 10px 20px;
        border-radius: 20px !important;
        color: #fff !important;
    }

    .circle {
        color: white;
        position: absolute;
        margin-top: -6%;
        margin-left: 20%;
        margin-bottom: 0;
        margin-right: 0;
    }

    svg {
        height: 30px;
    }

    .usk li {
        list-style: none;
        padding: 10px 10px;
        cursor: pointer;
    }

    input[type=file]::file-selector-button {
        position: relative;
        top: -2px;
        left: -10px;
    }

    a {
        cursor: pointer;
    }

    .ugc-button{
        margin: 5px;
        padding: 3px 30px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    ul.ugc-tabs{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}

	ul.ugc-tabs li{
		background: #848880;
		color: #fff;
		display: inline-block;
        margin: 5px;
        padding: 3px 30px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
		cursor: pointer;
	}

    ul.ugc-tabs li.ugc-current{
		background: #ED563C;
		color: #fff;
	}

    .ugc-tab-content{
		display: none;
	}

	.ugc-tab-content.ugc-current{
		display: inherit;
	}

    .ugc-videos img{
        width: 100%;
        height: 180px;
        border-radius: 15px;
    }

.video-form-control{
        width:100%;
        background-color: #c9c8c888 ;
        border:none;
        padding: 3px 10px;
        border-radius: 7px;
    }

        .input-container {
            position: relative;
            width: 100%;
            max-width: 100%;
            border-radius: 10px;
        }

        .input-container textarea {
            background-color: #848880;
            color: white;
            border-radius: 10px;
            width: 100%;
            height: 100px;
            padding: 15px;
            border: none;
            resize: none;
            font-size: 16px;
        }

        .input-container .icon {
            position: absolute;
            right: 10px; 
            bottom: 10px; 
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 24px;
            display: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

         .input-container button:hover {
            background-color: #45a049;
        }

        .ugc-social-media {
            width: 100%;
            max-width: 100%;
            border-radius: 10px;
        }

        .ugc-social-media textarea {
            background-color:transparent;
            color: white;
            width: 100%;
            border: none;
            resize: none;
            font-size: 16px;
        }

        .ugc-social-media .icon {
            position: absolute;
            right: 10px; /* Aligns button to the right */
            bottom: 10px; /* Aligns button to the bottom */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 24px;
            display: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .ugc-social-media .icon:hover {
            background-color: #45a049;
        }

        .ugc-actions {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
        }

        .ugc-videos:hover .ugc-actions {
            display: block;
        }

        .shareprofile{
            padding: 10px 0px;
        }


</style>

<body>
    <!-- loader Start -->
    <!-- <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
    <!-- loader END -->
    <!-- Header -->

    <header id="main-header" style="padding: 15px 0;">
        <div class="main-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="navbar navbar-expand-lg navbar-light p-0">
                            <a href="#" class="navbar-toggler c-toggler" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <div class="navbar-toggler-icon" data-toggle="collapse">
                                    <span class="navbar-menu-icon navbar-menu-icon--top"></span>
                                    <span class="navbar-menu-icon navbar-menu-icon--middle"></span>
                                    <span class="navbar-menu-icon navbar-menu-icon--bottom"></span>
                                </div>
                            </a>
                            <a class="navbar-brand" href="<?php echo URL::to('home'); ?>"> <img src="<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->logo; ?>"
                                    class="c-logo" alt="<?php echo $settings->website_name; ?>"> </a>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <div class="menu-main-menu-container">


                                </div>
                            </div>
                            <div class="mobile-more-menu">
                                <a href="javascript:void(0);" class="more-toggle" id="dropdownMenuButton"
                                    data-toggle="more-toggle" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-more-line"></i>
                                </a>
                                <div class="more-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="navbar-right position-relative">
                                        <ul class="d-flex align-items-center justify-content-end list-inline m-0">

                                            <li class="hidden-xs">
                                                <div id="navbar-search-form">
                                                    <form role="search" action="<?php echo URL::to('/') . '/searchResult'; ?>" method="POST">
                                                        <input name="_token" type="hidden"
                                                            value="<?php echo csrf_token(); ?>">
                                                        <div>

                                                            <i class="fa fa-search">
                                                            </i>
                                                            <input type="text" name="search" class="searches"
                                                                id="searches" autocomplete="off" placeholder="Search">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div id="search_list" class="search_list" style="position: absolute;">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="navbar-right menu-right">
                                <ul class="d-flex align-items-center list-inline m-0">
                                    <li class="nav-item nav-icon">
                                        <a href="<?php echo URL::to('/') . '/searchResult'; ?>" class="search-toggle device-search">

                                            <i class="ri-search-line"></i>
                                        </a>
                                        <div class="search-box iq-search-bar d-search">
                                            <form action="<?php echo URL::to('/') . '/searchResult'; ?>" method="post" class="searchbox">
                                                <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">

                                                <div class="form-group position-relative">
                                                    <input type="text" name="search"
                                                        class="text search-input font-size-12 searches"
                                                        placeholder="type here to search...">
                                                    <i class="search-link ri-search-line"></i>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="iq-sub-dropdown search_content overflow-auto"
                                            id="sidebar-scrollbar">
                                            <div class="iq-card-body">
                                                <div id="search_list" class="search_list search-toggle device-search">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item nav-icon">
                                     
                                        <div class="iq-sub-dropdown">
                                            <div class="iq-card shadow-none m-0">
                                                <div class="iq-card-body">
                                                    <a href="#" class="iq-sub-card">
                                                        <div class="media align-items-center">
                                                            <img src="assets/images/notify/thumb-1.jpg"
                                                                class="img-fluid mr-3" alt="streamit" />
                                                            <div class="media-body">
                                                                <h6 class="mb-0 ">Boot Bitty</h6>
                                                                <small class="font-size-12"> just now</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="iq-sub-card">
                                                        <div class="media align-items-center">
                                                            <img src="assets/images/notify/thumb-2.jpg"
                                                                class="img-fluid mr-3" alt="streamit" />
                                                            <div class="media-body">
                                                                <h6 class="mb-0 ">The Last Breath</h6>
                                                                <small class="font-size-12">15 minutes ago</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="iq-sub-card">
                                                        <div class="media align-items-center">
                                                            <img src="assets/images/notify/thumb-3.jpg"
                                                                class="img-fluid mr-3" alt="streamit" />
                                                            <div class="media-body">
                                                                <h6 class="mb-0 ">The Hero Camp</h6>
                                                                <small class="font-size-12">1 hour ago</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item nav-icon">
                                        <a href="#"
                                            class="iq-user-dropdown  search-toggle p-0 d-flex align-items-center"
                                            data-toggle="search-toggle">
                                            <?php if(Auth::guest()): ?>
                                            <img src="<?php echo URL::to('/') . '/public/uploads/avatars/lockscreen-user.png'; ?>" class="img-fluid avatar-40 rounded-circle"
                                                alt="user">
                                            <?php else: ?>
                                            <img src="<?php echo URL::to('/') . '/public/uploads/avatars/' . Auth::user()->avatar; ?>" class="img-fluid avatar-40 rounded-circle"
                                                alt="user">
                                            <?php endif; ?>
                                        </a>
                                        <?php if(Auth::guest()): ?>
                                        <div class="iq-sub-dropdown iq-user-dropdown">
                                            <div class="iq-card shadow-none m-0">
                                                <div class="iq-card-body p-0 pl-3 pr-3">
                                                    <a href="<?php echo URL::to('login'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <i class="ri-settings-4-line text-primary"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Signin</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="<?php echo URL::to('signup'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <i class="ri-logout-circle-line text-primary"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Signup</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php elseif(Auth::user()->role == 'registered'): ?>
                                        <div class="iq-sub-dropdown iq-user-dropdown">
                                            <div class="iq-card shadow-none m-0">
                                                <div class="iq-card-body p-0 pl-3 pr-3">
                                                    <a href="<?php echo URL::to('myprofile'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <path class="st5"
                                                                        d="M13.4 33.7c0 .5.2.9.5 1.2.3.3.8.5 1.2.5h22.2l-4 4.1c-.4.3-.6.8-.6 1.3s.2 1 .5 1.3c.3.3.8.5 1.3.5s1-.2 1.3-.6l7.1-7.1c.7-.7.7-1.8 0-2.5l-7.1-7.1c-.7-.6-1.7-.6-2.4.1s-.7 1.7-.1 2.4l4 4.1H15.2c-1 .1-1.8.9-1.8 1.8z" />
                                                                    <path class="st5"
                                                                        d="M52.3 17.8c0-1.4-.6-2.8-1.6-3.7-1-1-2.3-1.6-3.7-1.6H27.5c-1.4 0-2.8.6-3.7 1.6-1 1-1.6 2.3-1.6 3.7v7.1c0 1 .8 1.8 1.8 1.8s1.8-.8 1.8-1.8v-7.1c0-1 .8-1.8 1.8-1.8H47c.5 0 .9.2 1.2.5.3.3.5.8.5 1.2v31.8c0 .5-.2.9-.5 1.2-.3.3-.8.5-1.2.5H27.5c-1 0-1.8-.8-1.8-1.8v-7.1c0-1-.8-1.8-1.8-1.8s-1.8.8-1.8 1.8v7.1c0 1.4.6 2.8 1.6 3.7 1 1 2.3 1.6 3.7 1.6H47c1.4 0 2.8-.6 3.7-1.6 1-1 1.6-2.3 1.6-3.7V17.8z" />
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">My Account</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="<?php echo URL::to('watchlater'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <style>
                                                                        .st0 {
                                                                            fill: #198fcf;
                                                                            stroke: #198fcf;
                                                                            stroke-width: .75;
                                                                            stroke-miterlimit: 10
                                                                        }
                                                                    </style>
                                                                    <path class="st0"
                                                                        d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z" />
                                                                    <path class="st1"
                                                                        d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z"
                                                                        style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10" />
                                                                    <path class="st2"
                                                                        d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z"
                                                                        style="fill:#198fcf" />
                                                                    <path class="st3"
                                                                        d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2"
                                                                        style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10" />
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Watch list</h6>
                                                            </div>
                                                        </div>
                                                    </a>


                                                    <a href="<?php echo URL::to('logout'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <path class="st6"
                                                                        d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7">
                                                                    </path>
                                                                    <path class="st6"
                                                                        d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Logout</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="iq-sub-dropdown iq-user-dropdown">
                                            <div class="iq-card shadow-none m-0">
                                                <div class="iq-card-body p-0 pl-3 pr-3">
                                                    <a href="<?php echo URL::to('myprofile'); ?>"
                                                        class="iq-sub-card  setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    x="0px" y="0px" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70;"
                                                                    xml:space="preserve">
                                                                    <style type="text/css">

                                                                    </style>

                                                                    <path class="st0"
                                                                        d="M32,34c-7.4,0-13.4-6-13.4-13.4S24.6,7.1,32,7.1s13.4,6,13.4,13.4S39.4,34,32,34z M32,10.5
		c-5.6,0-10.1,4.5-10.1,10.1S26.4,30.7,32,30.7s10.1-4.5,10.1-10.1S37.6,10.5,32,10.5z" />
                                                                    <path class="st0"
                                                                        d="M38.5,54.2H15.3l0,0v-2.8c0-9,6.8-16.7,15.8-17.2c4.3-0.3,8.4,1.1,11.5,3.6c0.1,0.1,0.3,0.1,0.4,0l1.8-1.8
		c0.3-0.3,0.3-0.5,0.1-0.6c-3.8-3.1-8.6-4.8-13.9-4.5c-10.7,0.6-19,9.9-19,20.6v5.1c0,0.6,0.5,1.1,1.1,1.1h28.8c0.5,0,0.8-0.6,0.4-1
		l-1.4-1.4C40.2,54.5,39.3,54.2,38.5,54.2z" />
                                                                    <path class="st0"
                                                                        d="M62.2,48.6v-2.4c0-0.3-0.2-0.5-0.5-0.5H59c-0.2,0-0.4-0.1-0.5-0.4c-0.1-0.4-0.3-0.7-0.4-1.1
		C58,44,58,43.8,58.2,43.6l1.9-1.9c0.2-0.2,0.2-0.5,0-0.7l-1.7-1.7c-0.2-0.2-0.5-0.2-0.7,0l-2,2c-0.2,0.2-0.4,0.2-0.6,0.1
		c-0.3-0.2-0.7-0.3-1-0.4c-0.2-0.1-0.4-0.3-0.4-0.5v-2.8c0-0.3-0.2-0.5-0.5-0.5h-2.4c-0.3,0-0.5,0.2-0.5,0.5v2.8
		c0,0.2-0.1,0.4-0.4,0.5c-0.4,0.1-0.7,0.2-1,0.4c-0.2,0.1-0.4,0.1-0.6-0.1l-2-2c-0.2-0.2-0.5-0.2-0.7,0L43.9,41
		c-0.2,0.2-0.2,0.5,0,0.7l1.9,1.9c0.2,0.2,0.2,0.4,0.1,0.6c-0.2,0.3-0.3,0.7-0.4,1.1c-0.1,0.2-0.3,0.4-0.5,0.4h-2.7
		c-0.3,0-0.5,0.2-0.5,0.5v2.4c0,0.3,0.2,0.5,0.5,0.5H45c0.2,0,0.4,0.1,0.5,0.4c0.1,0.4,0.3,0.7,0.4,1c0.1,0.2,0.1,0.4-0.1,0.6
		L44.1,53c-0.2,0.2-0.2,0.5,0,0.7l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l1.9-1.9c0.2-0.2,0.4-0.2,0.6-0.1c0.3,0.2,0.7,0.3,1.1,0.4
		c0.2,0.1,0.4,0.3,0.4,0.5V57c0,0.3,0.2,0.5,0.5,0.5h2.4c0.3,0,0.5-0.2,0.5-0.5v-2.7c0-0.2,0.1-0.4,0.4-0.5c0.4-0.1,0.7-0.3,1-0.4
		c0.2-0.1,0.4-0.1,0.6,0.1l1.9,1.9c0.2,0.2,0.5,0.2,0.7,0l1.7-1.7c0.2-0.2,0.2-0.5,0-0.7l-1.9-1.9c-0.2-0.2-0.2-0.4-0.1-0.6
		c0.2-0.3,0.3-0.7,0.4-1c0.1-0.2,0.3-0.4,0.5-0.4h2.7C62,49.1,62.2,48.9,62.2,48.6z M48.7,47.4c0-0.9,0.4-1.7,1-2.4
		c0.6-0.6,1.5-1,2.4-1s1.7,0.4,2.4,1c0.6,0.6,1,1.5,1,2.4c0,1.7-1.2,3.2-3.3,3.5c-0.1,0-0.1,0-0.2,0C50,50.6,48.7,49.1,48.7,47.4
		L48.7,47.4z" />

                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">My Account</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="<?php echo URL::to('watchlater'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <style>
                                                                        .st0 {
                                                                            fill: #198fcf;
                                                                            stroke: #198fcf;
                                                                            stroke-width: .75;
                                                                            stroke-miterlimit: 10
                                                                        }
                                                                    </style>
                                                                    <path class="st0"
                                                                        d="M21.5 23.7h14c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4h-14c-.2 0-.3-.2-.3-.4V24c0-.1.2-.3.3-.3zM21.5 32h13.4c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.2.2-.4.3-.4zM21.5 40.3h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.7c0-.3.2-.5.3-.5zM21.5 48.7h23.1c.2 0 .3.2.3.4v.8c0 .2-.1.4-.3.4H21.5c-.2 0-.3-.2-.3-.4v-.8c0-.3.2-.4.3-.4z" />
                                                                    <path class="st1"
                                                                        d="M48.4 37c-5.1 0-9.2-4.1-9.2-9.2s4.1-9.2 9.2-9.2 9.2 4.1 9.2 9.2-4.1 9.2-9.2 9.2zm0-16.7c-4.2 0-7.5 3.3-7.5 7.5s3.3 7.5 7.5 7.5 7.5-3.3 7.5-7.5-3.3-7.5-7.5-7.5z"
                                                                        style="fill:#198fcf;stroke:#198fcf;stroke-width:.5;stroke-miterlimit:10" />
                                                                    <path class="st2"
                                                                        d="M52.1 28.7h-3.8c-.4 0-.7-.3-.7-.7v-3.8c0-.2.2-.4.4-.4h.8c.2 0 .4.2.4.4v2.2c0 .4.3.7.7.7h2.2c.2 0 .4.2.4.4v.8c.1.2-.1.4-.4.4z"
                                                                        style="fill:#198fcf" />
                                                                    <path class="st3"
                                                                        d="M54.3 34v20.1c0 1-.8 1.9-1.9 1.9H17.3c-1 0-1.9-.8-1.9-1.9V17.5c0-1 .8-1.9 1.9-1.9h35.1c1 0 1.9.8 1.9 1.9v4.2"
                                                                        style="fill:none;stroke:#198fcf;stroke-width:2;stroke-miterlimit:10" />
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Watch list</h6>
                                                            </div>
                                                        </div>
                                                    </a>


                                                    <?php if(Auth::User()->role == "admin"){ ?>


                                                    <a href="<?php echo URL::to('admin'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    x="0px" y="0px" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70;"
                                                                    xml:space="preserve">
                                                                    <style type="text/css">
                                                                        .st0 {}
                                                                    </style>
                                                                    <g>
                                                                        <path class="st0"
                                                                            d="M52.5,37.8c-1.7,0-3.2,0.5-4.5,1.2c-2.4-2-5-3.7-8-4.6c4.5-3,7.2-8.2,6.4-13.8c-0.8-6.4-6.1-11.7-12.5-12.4
		c-4.1-0.5-8.1,0.8-11.2,3.6c-3.1,2.7-4.8,6.6-4.8,10.7c0,4.9,2.5,9.4,6.6,12c-5,1.7-9.3,5.1-12.3,9.5c-1.7,2.6-1.1,6.2,1.3,8
		C19,55.9,25.4,58,32.2,58c4.9,0,9.8-1.2,14.2-3.5c1.7,1.4,3.7,2.3,6.1,2.3c5.2,0,9.5-4.3,9.5-9.5S57.7,37.8,52.5,37.8L52.5,37.8z
		 M20.3,22.3c0-3.3,1.4-6.7,3.9-8.9c2.3-2,5-3,7.9-3c0.5,0,1,0,1.4,0.1c5.4,0.6,9.8,4.9,10.4,10.2c0.7,5.6-2.5,10.8-7.9,12.8
		l-3.8,1.4l-3.9-1.4C23.5,31.8,20.3,27.3,20.3,22.3L20.3,22.3z M15.1,49.9c-1.4-1.1-1.8-3.2-0.8-4.8c3.1-4.8,8.2-8.2,13.8-9.3
		l4.2-0.8l4.2,0.8c3.6,0.7,6.8,2.3,9.7,4.5c-1.9,1.7-3.1,4.2-3.1,6.9c0,2,0.6,3.9,1.8,5.5c-3.9,1.9-8.2,2.9-12.5,2.9
		C26,55.6,20.1,53.6,15.1,49.9L15.1,49.9z M52.5,54.5c-3.9,0-7.2-3.2-7.2-7.2s3.2-7.2,7.2-7.2s7.2,3.2,7.2,7.2S56.4,54.5,52.5,54.5z
		 M57.5,45.6L55,48l0.6,3.5l-3.1-1.7l-3.1,1.7L50,48l-2.5-2.4l3.5-0.5l1.5-3.1l1.5,3.1L57.5,45.6z" />
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Admin</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <?php } ?>
                                                    <a href="<?php echo URL::to('logout'); ?>"
                                                        class="iq-sub-card setting-dropdown">
                                                        <div class="media align-items-center">
                                                            <div class="right-icon">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 70 70"
                                                                    style="enable-background:new 0 0 70 70"
                                                                    xml:space="preserve">
                                                                    <path class="st6"
                                                                        d="M53.4 33.7H30.7M36.4 28.1l-5.7 5.7 5.7 5.7" />
                                                                    <path class="st6"
                                                                        d="M50.5 43.7c-2.1 3.4-5.3 5.9-9.1 7.3-3.7 1.4-7.8 1.6-11.7.4a18.4 18.4 0 0 1-9.6-28.8c2.4-3.2 5.8-5.5 9.6-6.6 3.8-1.1 7.9-1 11.7.4 3.7 1.4 6.9 4 9.1 7.3" />
                                                                </svg>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Logout</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                $(".dropdown-toggle").dropdown();
            });
        </script>

    </header>

    <head>
        <?php
        $jsonString = file_get_contents(base_path('assets/country_code.json'));
        $jsondata = json_decode($jsonString, true);
        ?>




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
                                            href="<?php echo URL::to('home'); ?>"><span>Visit site</span></a>
                                    </li>
                                    <li class="line-height pt-3">
                                        <a href="#"
                                            class="search-toggle iq-waves-effect d-flex align-items-center">
                                            <img src="<?php echo URL::to('/') . '/public/uploads/avatars/' . Auth::user()->avatar; ?>" class="img-fluid avatar-40 rounded-circle"
                                                alt="user">
                                        </a>
                                        <div class="iq-sub-dropdown iq-user-dropdown">
                                            <div class="iq-card shadow-none m-0">
                                                <div class="iq-card-body p-0 ">
                                                    <div class="bg-primary p-3">
                                                        <h5 class="mb-0 text-white line-height">Hello Barry Tech</h5>
                                                        <span class="text-white font-size-12">Available</span>
                                                    </div>
                                                    <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon iq-bg-primary">
                                                                <i class="ri-file-user-line"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">My Profile</h6>
                                                                <p class="mb-0 font-size-12">View personal profile
                                                                    details.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="profile-edit.html"
                                                        class="iq-sub-card iq-bg-primary-hover">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon iq-bg-primary">
                                                                <i class="ri-profile-line"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Edit Profile</h6>
                                                                <p class="mb-0 font-size-12">Modify your personal
                                                                    details.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="account-setting.html"
                                                        class="iq-sub-card iq-bg-primary-hover">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon iq-bg-primary">
                                                                <i class="ri-account-box-line"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Account settings</h6>
                                                                <p class="mb-0 font-size-12">Manage your account
                                                                    parameters.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="privacy-setting.html"
                                                        class="iq-sub-card iq-bg-primary-hover">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon iq-bg-primary">
                                                                <i class="ri-lock-line"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Privacy Settings</h6>
                                                                <p class="mb-0 font-size-12">Control your privacy
                                                                    parameters.</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="d-inline-block w-100 text-center p-3">
                                                        <a class="bg-primary iq-sign-btn" href="#"
                                                            role="button">Sign out<i
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
            <section class="m-profile  setting-wrapper pt-0 p-3">
                <div class="container">
        
                    {{-- <img src="https://img.freepik.com/free-photo/gradient-dark-blue-futuristic-digital-grid-background_53876-129728.jpg?t=st=1720699527~exp=1720703127~hmac=009af48450d1394e58f536f81a4a956cf075db589e1d9b6cc33c6d3026708d54&w=826" style="border-radius: 30px; width:100%; height:200px; " alt="banner" > --}}

                    <div class="row justify-content-center m-1">
                        <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#add-new').modal('show');" >               
                            <img
                            src="<?= $user->ugc_banner ? URL::to('/') . '/public/uploads/ugc-banner/' . $user->ugc_banner : '' ?>"  style="border-radius: 30px; height:auto; width:100%; " alt="banner" >
                        </a>
                    </div>
                    <div class="row justify-content-start mx-3">
                        <div >
                        <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#add-new').modal('show');" >
                        <img class="rounded-circle img-fluid text-center mb-3 mt-4"
                        src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile-bg" style="height: 80px; width: 80px;">
                        </a>
                        </div>
                       <div class="col" style="padding-top: 40px;" >
                        <div>
                        <h6>{{$user->username}}</h6>
                        </div>
                        <div class="py-2" >
                            @if($user->subscribers_count == 0 )
                            <p style="color: white; font-size:18px;" >No Subscribers</p>
                            @elseif($user->subscribers_count == 1 )
                            <p style="color: white; font-size:18px;" >1 Member Subscribed</p>
                            @else
                            <p style="color: white; font-size:18px;" >
                             <span class="subscriber-count"> {{ $user->subscribers_count }} </span> Members Subscribed
                            </p>
                            @endif
                        </div>
                       </div>
                    </div>
                   
                    <ul class="ugc-tabs mx-3">
                        <li class="tab-link ugc-current" data-tab="ugc-tab-1">Bio</li>
                        <li class="tab-link" data-tab="ugc-tab-2">Videos</li>
                        <li class="tab-link" data-tab="ugc-tab-3">Playlist</li>
                    </ul>
        
                    <div id="ugc-tab-1" class="ugc-tab-content ugc-current">
                        <div class="col-12 pt-3">
                            <div>
                                <h2>About</h2>
        
                                <div class="input-container" style="position: relative" >
                                    <form>
                                        <textarea id="ugc-about" name="ugc-about" value="" placeholder="Enter About You">{{ $user->ugc_about ? $user->ugc_about : '' }}</textarea>
                                        <input type="button" class="icon" style="color: green;" id="submit_about" value="&#10004;">
                                    </form>
                                </div>
                            </div>
                            <div class="pt-4" >
                                <h2>Links</h2>
                                <div class="py-2">
                                <h5>Facebook</h5>
                                <p style="color: white">
                                    <div class="ugc-social-media" style="position: relative" >
                                        <form>
                                            <textarea id="ugc-facebook" name="ugc-facebook" value="" placeholder="Facebook" rows="1" >{{ $user->ugc_facebook ? $user->ugc_facebook : '' }}</textarea>
                                            <input type="button" class="icon" style="color: green;" id="submit_facebook" value="&#10004;">
                                          
                                        </form>
                                    </div>
                                </p>
                                </div>
                                <div class="py-2">
                                <h5>Instagram</h5>
                                <p style="color: white">
                                    <div class="ugc-social-media" style="position: relative" >
                                        <form>
                                            <textarea id="ugc-instagram" name="ugc-instagram" placeholder="Instagram" rows="1" >{{ $user->ugc_instagram ? $user->ugc_instagram : '' }}</textarea>
                                            <input type="button" class="icon" style="color: green;" id="submit_instagram" value="&#10004;">
                                        </form>
                                    </div>
                                </p>
                                </div>
                                <div class="py-2">
                                <h5>Twitter</h5>
                                <p style="color: white">
                                    <div class="ugc-social-media" style="position: relative" >
                                        <form>
                                            <textarea id="ugc-twitter" name="ugc-twitter" placeholder="Twitter" rows="1" >{{ $user->ugc_twitter ? $user->ugc_twitter : '' }}</textarea>
                                            <input type="button" class="icon" style="color: green;" id="submit_twitter" value="&#10004;">
                                        </form>
                                    </div>
                                </p>
                                </div>
                            </div>
                            <div class="row pt-4" >
                                <div class="col-lg-6 col-md-12 mb-4"> 
                                    <h2>Profile Details</h2>
                                    <div class="text-white pt-4">
                                    <p style="font-weight: 600; font-size: 18px;">Profile link: <span style="font-weight: 100; font-size:15px;" >
                                    <a href="{{ route('profile.show', ['username' => $user->username]) }}"> {{ route('profile.show', ['username' => $user->username]) }} </a>
                                    </span></p> 
                                    </div>
                                    <div class=" text-white">
                                    <p style="font-weight: 600; font-size: 18px;">Total videos: <span style="font-weight: 100; font-size:15px;" >{{ $totalVideos ? $totalVideos : 0 }}</span></p> 
                                    </div>
                                    <div class=" text-white">
                                    <p style="font-weight: 600; font-size: 18px;" >Total views: <span style="font-weight: 100; font-size:15px;" >{{ $totalViews ? $totalViews : 0 }} views</span></p> 
                                    </div>
                                    <div class=" text-white">
                                    <p style="font-weight: 600; font-size: 18px;" >Joined: <span style="font-weight: 100; font-size:15px;" >{{ $user->created_at ? $user->created_at->format('d F Y') : '' }}</span></p> 
                                    </div>
                                    <div class=" text-white">
                                    <p style="font-weight: 600; font-size: 18px;" >Location: <span style="font-weight: 100; font-size:15px;" >{{ $user->location ? $user->location : '' }}</span></p> 
                                    </div>
                                    <div>
                                    <button style="background:#ED563C!important;color: #ffff!important; padding: 5px 100px !important; margin:0%;  cursor:pointer; border:none; "  class="ugc-button" >Share Profile</button>
                                    </div>
                                    <div class="shareprofile">
                                        <div class="d-flex bg-white p-2" style="width: 100px; border-radius:10px;  "> 
                                            <div class="d-flex">

                                            <div class="px-1">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('profile.show', ['username' => $user->username]) }}" target="_blank">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                            </div>
                                            <div class="px-1">
                                            <a href="https://twitter.com/intent/tweet?text={{ route('profile.show', ['username' => $user->username]) }}" target="_blank">
                                                <i class="ri-twitter-fill"></i>
                                            </a>
                                            </div>
                                            <div class="px-1">
                                               <a href="#" onclick="Copy();" class="share-ico"><i class="ri-links-fill" ></i></a>
                                               <input type="hidden" id="profile_url" value="{{ route('profile.show', ['username' => $user->username]) }}">
                                            </div>
                                            </div>
                                         </div>
                                    </div>
                                </div>

                        
                        
                                <div class="col-lg-6 col-md-12 mb-4">
                                                {{-- message --}}
                        
                                                @if (Session::has('message'))
                                                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                                                @endif
                                                <h2 class="text-center">My Account</h2>
                        
                                                <div class="row mt-5 align-items-center justify-content-between">
                                                    <div class="col-md-8">
                                                        <span class="text-light font-size-13">Email</span>
                                                        <div class="p-0">
                                                            <span class="text-light font-size-13">
                                                                {{ $user->email ? $user->email : ' ' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <a type="button" class="text-white font-size-13" data-toggle="collapse"
                                                            data-target="#update_userEmails">Change</a>
                                                    </div>
                                                </div>
                        
                                                <form id="update_userEmail" accept-charset="UTF-8"
                                                    action="{{ URL::to('/profile/update_userEmail') }}" method="post">
                                                    @csrf
                        
                                                    <input type="hidden" name="users_id" value="{{ $user->id }}" />
                                                    <span id="update_userEmails" class="collapse">
                                                        <div class="row mt-3">
                                                            <div class="col-md-8">
                                                                <input type="text" name="user_email" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a type="button" class="btn round update_userEmail">Update</a>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </form>
                        
                        
                                                <hr style="border:0.5px solid #fff;">
                                                <div class="row align-items-center">
                                                    <div class="col-md-5 mt-3">
                                                        <span class="text-light font-size-13">Password</span>
                                                        <div class="p-0 mt-2">
                                                            <span class="text-light font-size-13">*********</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 mt-2 text-right" style="font-size:14px;">
                                                        <a href="{{ URL::to('/password/reset') }}"
                                                            class="f-link text-white font-size-13">Send Reset Password Email</a>
                                                    </div>
                                                </div>
                                                <hr style="border:0.5px solid #fff;">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <span class="text-light font-size-13">Display Name</span>
                                                        <div class="p-0">
                                                            <span
                                                                class="text-light font-size-13"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <a type="button" class="text-white font-size-13" data-toggle="collapse"
                                                            data-target="#demo">Change</a>
                        
                                                    </div>
                                                </div>
                                                <form id="update_username" accept-charset="UTF-8"
                                                    action="{{ URL::to('/profile/update_username') }}" method="post">
                                                    @csrf
                        
                                                    <input type="hidden" name="users_id" value="{{ $user->id }}" />
                                                    <span id="demo" class="collapse">
                                                        <div class="row mt-3">
                                                            <div class="col-md-8">
                                                                <input type="text" name="user_name" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a type="button" class="btn round update_username">Update</a>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </form>
                        
                                                {{-- Display Image --}}
                                                <hr style="border:0.5px solid #fff;">
                        
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <span class="text-light font-size-13">Display Image</span>
                                                        <div class="p-0">
                                                            <span class="text-light font-size-13">
                                                                @if ($user->avatar != null)
                                                                    <img src="{{ URL::to('public/uploads/avatars/' . $user->avatar) }}"
                                                                        height="50px" width="50px" />
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <a type="button" class="text-white font-size-13" data-toggle="collapse"
                                                            data-target="#user_img">Change</a>
                                                    </div>
                                                </div>
                        
                                                <form id="update_userimg" accept-charset="UTF-8"
                                                    action="{{ URL::to('profile/update_userImage') }}" enctype="multipart/form-data"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="users_id" value="{{ $user->id }}" />
                                                    <span id="user_img" class="collapse">
                                                        <div class="row mt-3">
                                                            <div class="col-md-8">
                                                                <input type="file" multiple="true" class="form-control"
                                                                    name="avatar" id="avatar" required />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a type="button" class="btn round update_userimg">Update</a>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </form>
                                                {{-- TV Code --}}
                                                <hr style="border:0.5px solid #fff;">
                        
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <span class="text-light font-size-13">Tv Activation Code</span>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <a type="button" class="text-white font-size-13" data-toggle="collapse"
                                                            data-target="#user_tvcode">Add</a>
                                                    </div>
                                                </div>
                        
                        
                                                <form id="tv-code" accept-charset="UTF-8" action="{{ URL::to('user/tv-code') }}"
                                                    enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    <input type="hidden" name="users_id" value="{{ $user->id }}" />
                                                    <input type="hidden" name="email" value="{{ $user->email }}" />
                                                    <span id="user_tvcode" class="collapse">
                                                        <div class="row mt-3">
                                                            <div class="col-md-8">
                                                                <input type="text" name="tv_code" id="tv_code"
                                                                    value="@if (!empty($UserTVLoginCode->tv_code)) {{ $UserTVLoginCode->tv_code }} @endif" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                @if (!empty($UserTVLoginCode->tv_code))
                                                                    <a type="button"
                                                                        href="{{ URL::to('user/tv-code/remove/') }}/{{ $UserTVLoginCode->id }}"
                                                                        style="background-color:#df1a10!important;"
                                                                        class="btn round tv-code-remove text-red">Remove</a>
                                                                @else
                                                                    <a type="button" class="btn round tv-code text-white">Add</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </span>
                                                </form>
                        
                                                <hr style="border:0.5px solid #fff;">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <span class="text-light font-size-13">Membership Settings</span>
                        
                                                        <div class="p-0">
                                                            <span class="text-light font-size-13">
                                                                {{ ucwords('Current Membership -' . ' ' . $user->role) }}
                                                            </span><br>
                        
                                                            @if (Auth::user()->role == 'subscriber')
                                                                <span class="text-light font-size-13">
                                                                    @if ($user->subscription_ends_at != null && !empty($user->subscription_ends_at))
                                                                        {{ 'your subscription renew on ' . $user->subscription_ends_at->format('d-m-Y') }}
                                                                    @endif
                                                                </span>
                                                            @endif
                        
                                                        </div>
                        
                                                    </div>
                        
                                                    <div class="col-md-4 text-right">
                                                        @if (Auth::user()->role == 'subscriber')
                                                            {{-- <a href=" {{ URL::to('/upgrade-subscription_plan') }} class="text-white font-size-13"> Update Payment</a> --}}
                                                        @elseif(Auth::user()->role == 'admin')
                                                        @else
                                                            <a href="<?= URL::to('/becomesubscriber') ?>" class="text-white font-size-13">
                                                                Subscriber Payment</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr style="border:0.5px solid #fff;">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <a href="{{ URL::to('logout') }}" type="button" class="btn round">Logout</a>
                                                    </div>
                        
                                                    @if (Auth::user()->role == 'subscriber' && Auth::user()->payment_status != 'Cancel')
                                                        <div class="col-md-6 text-right">
                                                            <a href="{{ URL::to('/cancelSubscription') }}"
                                                                class="text-white font-size-13">Cancel Membership</a>
                                                        </div>
                                                    @endif
                        
                                                </div>
                                    </div>
                                </div>
                                    
                                
                            </div>
        
                            
                        </div>
                    </div>
        
                <div id="ugc-tab-2" class="ugc-tab-content">
        
                 <div class="row mx-3">
                    @foreach ($ugcvideos as $eachugcvideos)
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        
                         <a href="{{ url('ugc/video-player/' . $eachugcvideos->slug) }}" class="m-1">
                                    <div class="ugc-videos" style="position: relative;" >
                                        <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
                                        <div class="ugc-actions">
                                            <div style="border-radius: 7px; background-color:#ED563C; padding:2px 5px;">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Meta"
                                                data-original-title="Edit Meta" href="{{ URL::to('ugc-edit') . '/' . $eachugcvideos->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#fff" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                    </svg>
                                                </a>
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Video"
                                                data-original-title="Edit Video" href="{{ URL::to('ugc-editvideo') . '/' . $eachugcvideos->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-btn-fill" viewBox="0 0 16 16">
                                                    <path d="M0 12V4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2m6.79-6.907A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814z"/>
                                                    </svg>
                                                </a>
                                                <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="Delete Video"
                                                data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('ugc-delete') . '/' . $eachugcvideos->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                        
        
                                    <div class="text-white pt-3">
                                        <h6>{{$eachugcvideos->title}}</h6>
                                        <p style="margin:5px 0px;">{{$user->username}}</p>
                                        <p> {{$eachugcvideos->created_at->diffForHumans()}} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} views
                                            | {{$eachugcvideos->like_count}} Likes</p>
                                    </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3 pull-right" >
                    {{ $ugcvideos->links() }}
                </div>
                </div>
        
                <div id="ugc-tab-3" class="ugc-tab-content">
                    <div class="row mx-3">
                        @foreach ($ugcvideos as $eachugcvideos)
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            
                             <a href="{{ url('ugc/video-player/' . $eachugcvideos->slug) }}" class="m-1">
                                        <div class="ugc-videos" style="position: relative;" >
                                            <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
                                            <div class="ugc-actions" >
                                                <div style="border-radius: 7px; background-color:#ED563C; padding:2px 10px; " >
                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Meta"
                                                    data-original-title="Edit Meta" href="{{ URL::to('ugc-edit') . '/' . $eachugcvideos->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                        </svg>
                                                    </a>
                                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Video"
                                                    data-original-title="Edit Video" href="{{ URL::to('ugc-editvideo') . '/' . $eachugcvideos->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-btn-fill" viewBox="0 0 16 16">
                                                        <path d="M0 12V4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2m6.79-6.907A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814z"/>
                                                        </svg>
                                                    </a>
                                                    <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="Delete Video"
                                                    data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/videos/delete') . '/' . $eachugcvideos->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                            
            
                                        <div class="text-white pt-3">
                                            <h6>{{$eachugcvideos->title}}</h6>
                                            <p style="margin:5px 0px;">{{$user->username}}</p>
                                            <p> {{$eachugcvideos->created_at->diffForHumans()}} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} views
                                                | {{ $eachugcvideos->like_count}} Likes</p>
                                        </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
            
                    <div class="mt-3 pull-right" >
                        {{ $ugcvideos->links() }}
                    </div>
                </div>
        
        
                </div>
            </section>
                          
                        <!-- Add New Modal -->
                <div class="modal fade" id="add-new">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title text-black">Update Profile</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>

                            </div>

                            <div class="modal-body">
                                <form id="new-cat-form" accept-charset="UTF-8"
                                    action="{{ URL::to('/profile/update') }}" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                    <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                                    <div class="form-group">
                                        <label> Username:</label>
                                        <input type="text" id="username" name="username"
                                            value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>"
                                            class="form-control" placeholder="username">
                                    </div>

                                    <div class="form-group">
                                        <label> Email:</label>
                                        <input type="email" id="email" name="email"
                                            value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>"
                                            class="form-control" placeholder="Email">
                                    </div>


                                    <div class="form-group">
                                        <label>Password:</label><br>
                                        <input type="password" name="password" placeholder="Password"
                                            class="form-control">
                                    </div>


                                    <div class="form-group">
                                        <label> DOB:</label>
                                        <input type="date" id="DOB" name="DOB" class="form-control"
                                            value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                                    </div>

                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="submit-new-cat">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        <div class="col-sm-12 mt-4 text-center targetDiv" id="div2">
            <div class="d-flex justify-content-center"> <img class="rounded-circle img-fluid d-block  mb-3"
                    height="100" width="100"
                    src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar ?>" alt="profile-bg" /></div>

            <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
            <h4 class="mb-3"><?php if(!empty($user->role)): ?><?= $user->role ?><?php endif; ?> as on
                <?php if(!empty($user->created_at)): ?><?= $user->created_at ?><?php endif; ?></h4>
            <h4 class="mb-3"></h4>

            <div class="text-center">
                <?php  if($user_role == 'registered'){ ?>
                <h6><?php echo 'Registered' . ' ' . '(Free)'; ?> Subscription</h6>
                <h6></h6>
                <?php }elseif($user_role == 'subscriber'){ ?>
                <h6><?php echo $role_plan . ' ' . '(Paid User)'; ?></h6>
                <br>
                <h5 class="card-title mb-0">Available Specification :</h5><br>
                <h6> Video Quality : <p> <?php if ($plans != null || !empty($plans)) {
                    echo $plans->video_quality;
                } else {
                    ' ';
                } ?></p>
                </h6>
                <h6> Video Resolution : <p> <?php if ($plans != null || !empty($plans)) {
                    echo $plans->resolution;
                } else {
                    ' ';
                } ?> </p>
                </h6>
                <h6> Available Devices : <p> <?php if ($plans != null || !empty($plans)) {
                    echo $devices_name;
                } else {
                    ' ';
                } ?> </p>
                </h6>
                <!--<h6>Subscription</h6>-->
                <?php } ?>
            </div>

            <!-- -->
            <div class="row align-items-center justify-content-center mb-3 mt-3">
                <div class=" text-center colsm-4 ">
                    <a href="<?= URL::to('/transactiondetails') ?>"
                        class="btn btn-primary btn-login nomargin noborder-radius">View Transaction Details</a>
                </div>

                <div class="col-sm-4 text-center">
                    <?php if(Auth::user()->role == "subscriber"){ ?>
                    <a href="<?= URL::to('/upgrade-subscription_plan') ?>" class="btn btn-primary editbtn">Upgrade
                        Plan </a>
                    <?php }else{ ?>
                    <a href="<?= URL::to('/becomesubscriber') ?>"
                        class="btn btn-primary btn-login nomargin noborder-radius"> Become Subscriber</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="targetDiv" id="div3">
            <div class="row align-items-center justify-content-between mb-3 mt-3">
                <div class="col-sm-4">
                    <?php  if($user_role == 'registered'){ ?>
                    <h6><?php echo 'Registered' . ' ' . '(Free)'; ?></h6>
                    <h6>Subscription</h6>
                    <?php }elseif($user_role == 'subscriber'){ ?>
                    <h6><?php echo $role_plan . ' ' . '(Paid User)'; ?></h6>
                    <br>
                    <h5 class="card-title mb-0">Available Specification :</h5><br>
                    <h6> Video Quality : <p> <?php if ($plans != null || !empty($plans)) {
                        echo $plans->video_quality;
                    } else {
                        ' ';
                    } ?></p>
                    </h6>
                    <h6> Video Resolution : <p> <?php if ($plans != null || !empty($plans)) {
                        echo $plans->resolution;
                    } else {
                        ' ';
                    } ?> </p>
                    </h6>
                    <h6> Available Devices : <p> <?php if ($plans != null || !empty($plans)) {
                        echo $devices_name;
                    } else {
                        ' ';
                    } ?> </p>
                    </h6>
                    <!--<h6>Subscription</h6>-->
                    <?php } ?>
                </div>
                <div class="col-sm-6">
                    <?php if(Auth::user()->role == "subscriber"){ ?>
                    <a href="<?= URL::to('/upgrade-subscription_plan') ?>" class="btn btn-primary editbtn">Upgrade
                        Plan </a>
                    <?php }else{ ?>
                    <a href="<?= URL::to('/becomesubscriber') ?>"
                        class="btn btn-primary btn-login nomargin noborder-radius"> Become Subscriber</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="targetDiv" id="div4">
            <div class="mb-3" id="updatepic">

            </div>
        </div>
        <div class="targetDiv mt-5" id="div5">
            <div class=" mb-3">
                <h4 class="card-title mb-0">Preference for videos</h4>
                <form action="{{ route('users-profile-Preference') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                    <div class="col-sm-9 form-group p-0 mt-3">
                        <label>
                            <h5>Preference Language</h5>
                        </label>
                        <select id="" name="preference_language[]"
                            class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach ($preference_languages as $preference_language)
                                <option value="{{ $preference_language->id }}">{{ $preference_language->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-9 form-group p-0 mt-3">
                        <label>
                            <h5>Preference Genres</h5>
                        </label>
                        <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect"
                            style="width: 100%;" multiple="multiple">
                            @foreach ($videocategory as $preference_genres)
                                <option value="{{ $preference_genres->id }}">{{ $preference_genres->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit"
                        name="create-account" value="<?= __('Update Profile') ?>">{{ __('Update Profile') }}</button>
                </form>
            </div>
        </div>
        <div class="targetDiv" id="div6">
            <div class=" mb-3">
                <h4 class="card-title mb-0 manage"> My Account</h4>
                <div class="col-md-12 profile_image">
                    @forelse  ($profile_details as $profile)
                        <div class="">
                            <img src="{{ URL::asset('public/multiprofile/') . '/' . $profile->Profile_Image }}"
                                alt="user" class="multiuser_img" style="width:120px">

                            <h2 class="name">{{ $profile ? $profile->user_name : '' }}</h2>
                            <div class="circle">
                                <a href="{{ URL::to('profileDetails_edit', $profile->id) }}">
                                    <i class="fa fa-pencil"></i> </a>
                                @if ($Multiuser == null)
                                    <a href="{{ URL::to('profile_delete', $profile->id) }}"
                                        onclick="return confirm('Are you sure to delete this Profile?')">
                                        <i class="fa fa-trash"></i> </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-sm-6">
                            <p class="name">No Profile</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="targetDiv" id="div7">
            <div class="iq-card" id="recentviews" style="background-color:#191919;">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Recently Viewd Items</h4>
                    </div>

                </div>
                <div class="iq-card-body">
                    <div class="table-responsive ">
                        <table class="data-tables table movie_table recent_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:20%;">Video</th>
                                    <th style="width:10%;">Rating</th>
                                    <th style="width:20%;">Category</th>
                                    <th style="width:10%;">Views</th>
                                    <!-- <th style="width:10%;">User</th>-->
                                    <th style="width:20%;">Date</th>
                                    <th style="width:10%;"><i class="lar la-heart"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_videos as $video)
                                    @foreach ($video as $val)
                                        <tr>
                                            <td>
                                                <div class="media align-items-center">
                                                    <div class="iq-movie">
                                                        <a href="javascript:void(0);"><img
                                                                src="{{ URL::to('/') . '/public/uploads/images/' . $val->image }}"
                                                                class="img-border-radius avatar-40 img-fluid"
                                                                alt=""></a>
                                                    </div>
                                                    <div class="media-body text-white text-left ml-3">
                                                        <p class="mb-0"></p>
                                                        <small> </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $val->rating }}<i class="lar la-star mr-2"></i></td>
                                            <td>
                                                @if (isset($val->categories->name))
                                                    {{ $val->categories->name }}
                                                @endif
                                            </td>
                                            <td>{{ $val->views }}</td>

                                            <td>{{ $val->created_at }}</td>
                                            <td><i class="las la-heart text-primary"></i></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <style>
 
        </style>


             

        <div class="clear"></div>
        <form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8"
            file="1" enctype="multipart/form-data">
            <div class="well row">
              
                <!--popup-->
                <div class="form-popup " id="myForm"
                    style="background:url(<?php echo URL::to('/') . '/assets/img/Landban.png'; ?>) no-repeat;	background-size: cover;padding:40px;display:none;">
                    <div class="col-sm-4 details-back">
                        <div class="row data-back">
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button>
                                    <strong>Oh snap!</strong> <?= $errors->first('name') ?></div><?php endif; ?>
                                <label for="username" class="lablecolor"><?= __('Username') ?></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button>
                                    <strong>Oh snap!</strong> <?= $errors->first('email') ?></div><?php endif; ?>
                                <label for="email"><?= __('Email') ?></label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button>
                                    <strong>Oh snap!</strong> <?= $errors->first('name') ?></div><?php endif; ?>
                                <label for="username" class="lablecolor"><?= __('Phone Number') ?></label>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <!-- <select name="ccode">
                                            @foreach ($jsondata as $code)
                                                <option value="{{ $code['dial_code'] }}" 
                                                <?php
                                                    // if ($code['dial_code'] == $user->ccode) {
                                                    //     echo "selected='selected'";
                                                    // }
                                                 ?>
                                                 >
                                                    {{ $code['name'] . ' (' . $code['dial_code'] . ')' }}</option>
                                            @endforeach
                                        </select> -->
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" class="form-control" name="mobile" id="mobile"
                                            value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <label for="password"><?= __('Password') ?> (leave empty to keep your original
                                    password)</label>
                                <input type="password" class="form-control" name="password" id="password" />
                            </div>
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            <div class="col-sm-12 col-xs-12 mt-3">
                                <input type="submit" value="<?= __('Update Profile') ?>"
                                    class="btn btn-primary" />
                                <button type="button" class="btn btn-primary"
                                    onclick="closeForm()">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" id="subscribe">

                </div>

            </div>
            <div class="clear"></div>
        </form>
        </div>
        </div>

        </div>
        </div>
        </div>


        </div>
        <?php $settings = App\Setting::first(); ?>
        <footer class="mb-0">
            <div class="container-fluid">
                <div class="block-space">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-4 col-sm-12 r-mt-15">
                            <a class="navbar-brand" href="<?php echo URL::to('home'); ?>"> <img src="<?php echo URL::to('/') . '/public/uploads/settings/' . $settings->logo; ?>"
                                    class="c-logo" alt="Flicknexs"> </a>
                            <div class="d-flex mt-2">
                                <a href="https://www.facebook.com/<?php echo FacebookId(); ?>" target="_blank"
                                    class="s-icon">
                                    <i class="ri-facebook-fill"></i>
                                </a>
                                <a href="#" class="s-icon">
                                    <i class="ri-skype-fill"></i>
                                </a>
                                <a href="#" class="s-icon">
                                    <i class="ri-linkedin-fill"></i>
                                </a>
                                <a href="#" class="s-icon">
                                    <i class="ri-whatsapp-fill"></i>
                                </a>
                                <a href="https://www.google.com/<?php echo GoogleId(); ?>" target="_blank"
                                    class="s-icon">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12 p-0">
                            <ul class="f-link list-unstyled mb-0">
                        
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            
                        </div>
                        <div class="col-lg-3 col-md-4 p-0">
                            
                            <ul class="f-link list-unstyled mb-0">

                                <?php 
                        
                        $pages = App\Page::all();
                        
                        foreach($pages as $page): ?>
                                <?php if ( $page->slug != 'promotion' ){ ?>
                                <li><a
                                        href="<?php echo URL::to('page'); ?><?= '/' . $page->slug ?>"><?= __($page->title) ?></a>
                                </li>
                                <?php } ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="copyright py-2">
                <div class="container-fluid">
                    <p class="mb-0 text-center font-size-14 text-body" style="color:#fff!important;">
                        <?php echo $settings->website_name; ?> - 2021 All Rights Reserved</p>
                </div>
            </div>
        </footer>

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
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.searches').on('keyup', function() {
                    var query = $(this).val();
                    //alert(query);
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
       

</body>

</html>


</div>
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


<!-- Imported styles on this page -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/popper.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/css/bootstrap.min.css' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/dataTables.bootstrap4.min.js' ?>"></script>
<!-- Appear JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.appear.js' ?>"></script>
<!-- Countdown JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/countdown.min.js' ?>"></script>
<!-- Select2 JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/select2.min.js' ?>"></script>
<!-- Counterup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/waypoints.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.counterup.min.js' ?>"></script>
<!-- Wow JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/wow.min.js' ?>"></script>
<!-- Slick JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/slick.min.js' ?>"></script>
<!-- Owl Carousel JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/owl.carousel.min.js' ?>"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/jquery.magnific-popup.min.js' ?>"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/smooth-scrollbar.js' ?>"></script>
<!-- apex Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/apexcharts.js' ?>"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/chart-custom.js' ?>"></script>
<!-- Custom JavaScript -->
<script src="<?= URL::to('/') . '/assets/admin/dashassets/js/custom.js' ?>"></script>
<!-- End Notifications -->

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
</script>

<script>
    $(document).ready(function() {
        $(".update_username").click(function() {
            $('#update_username').submit();
        });

        $(".update_userimg").click(function() {
            $('#update_userimg').submit();
        });

        $(".update_userEmail").click(function() {
            $('#update_userEmail').submit();
        });
        $(".tv-code").click(function() {
            $('#tv-code').submit();
        });

    });


    $(document).ready(function() {
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
<script>
$(document).ready(function(){
	
	$('ul.ugc-tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.ugc-tabs li').removeClass('ugc-current');
		$('.ugc-tab-content').removeClass('ugc-current');

		$(this).addClass('ugc-current');
		$("#"+tab_id).addClass('ugc-current');
	})

})
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
       });
 
            document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('ugc-about');
            const submitButton = document.getElementById('submit_about');

            input.addEventListener('input', function() {
                const value = this.value;
                if (value.length > 0) {
                    submitButton.style.display = 'inline';
                } else {
                    submitButton.style.display = 'none';
                }
            });

            $('#submit_about').click(function(){
                const userId = {{ $user->id }}; // Get the user ID
                $.ajax({
                    url: '<?php echo route('ugc.about.submit') ?>',
                    type: "post",
                    data: {
                            _token: '{{ csrf_token() }}',
                            user_id: userId,
                            ugc_about: $('#ugc-about').val()
                        },        
                        success: function(value){
                        if(value.status){
                            location.reload();
                        }else{
                            alert( value.message);
                        }
                    }
                });
            })
        });


            document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('ugc-facebook');
            const submitButton = document.getElementById('submit_facebook');

            input.addEventListener('input', function() {
            const value = this.value;
            if (value.length > 0) {
            submitButton.style.display = 'inline';
            } else {
            submitButton.style.display = 'none';
            }
            });
        
  
            $('#submit_facebook').click(function(){

            const userId = {{ $user->id }}; 
       
            $.ajax({
            url: '<?php echo route('ugc.facebook.submit') ?>',
            type: "post",
            data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    ugc_facebook: $('#ugc-facebook').val()
                },        
                success: function(value){
                if(value.status){
                    location.reload();
                }else{
                    alert( value.message);
                }
                }
            });
            })
        });
 
        document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('ugc-instagram');
        const submitButton = document.getElementById('submit_instagram');

        input.addEventListener('input', function() {
        const value = this.value;
        if (value.length > 0) {
            submitButton.style.display = 'inline';
        } else {
            submitButton.style.display = 'none';
        }
        });


        $('#submit_instagram').click(function(){
        const userId = {{ $user->id }};

        $.ajax({
            url: '<?php echo route('ugc.instagram.submit') ?>',
            type: "post",
            data: {
              _token: '{{ csrf_token() }}',
              user_id: userId,
              ugc_instagram: $('#ugc-instagram').val()
            },        
            success: function(value){
                   if(value.status){
                       location.reload();
                   }else{
                       alert( value.message);
                   }
               }
            });
        })
    });

        document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('ugc-twitter');
        const submitButton = document.getElementById('submit_twitter');

        input.addEventListener('input', function() {
        const value = this.value;
        if (value.length > 0) {
            submitButton.style.display = 'inline';
        } else {
        submitButton.style.display = 'none';
        }
    });


    $('#submit_twitter').click(function(){
    const userId = {{ $user->id }}; 

    $.ajax({
       url: '<?php echo route('ugc.twitter.submit') ?>',
       type: "post",
       data: {
              _token: '{{ csrf_token() }}',
              user_id: userId,
              ugc_twitter: $('#ugc-twitter').val()
        },        
        success: function(value){
                   if(value.status){
                       location.reload();
                   }else{
                       alert( value.message);
                   }
               }
         });
        })
    });

    $('.shareprofile').hide()
    jQuery('.ugc-button').on('click',function(){
    jQuery('.shareprofile').toggle();
    })    
</script>

