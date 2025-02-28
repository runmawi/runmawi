@php
    include public_path('themes/theme5-nemisha/views/header.php');
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
        background: #fff;
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

    .sigk {
        background: linear-gradient(180deg, rgba(21, 30, 41, 0.85) 0%, rgba(21, 30, 41, 0) 100%);
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

        padding: 10px 20px;
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

    .account {
        background: linear-gradient(180deg, #121C28 -35.59%, rgba(11, 18, 28, 0.36) 173.05%);
        padding:10px 15px;
        border-radius: 10px;
        color: #FFFFFF;
        font-size: 20px;
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
		background: #F27906 ;
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

    a.edit-button.Text-white{color:#fff !important;}
    body.light-theme .sigk{background: linear-gradient(180deg, rgba(220, 220, 220, 0.85) 0%, rgba(220, 220, 220, 0) 100%);}
    body.light-theme .account{background: linear-gradient(180deg, #c0c6ca -35.59%, rgba(200, 204, 207, 0.36) 173.05%);}
    body.light-theme a.edit-button.Text-white{color:#000 !important;}
    .reveal{
        margin-left: -65px;
        /* position: absolute; */
        height: 45px !important;
        background: #ED553B !important;
        color: #fff !important;
        top: 0px;
    }
    
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
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
                                        <p class="text-primary text-uppercase"><?php $settings = App\Setting::first();
                                        echo $settings->website_name; ?></p>
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
                                    <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
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
                                                            <p class="mb-0 font-size-12">View personal profile details.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-hover">
                                                    <div class="media align-items-center">
                                                        <div class="rounded iq-card-icon iq-bg-primary">
                                                            <i class="ri-profile-line"></i>
                                                        </div>
                                                        <div class="media-body ml-3">
                                                            <h6 class="mb-0 ">Edit Profile</h6>
                                                            <p class="mb-0 font-size-12">Modify your personal details.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="account-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                                    <div class="media align-items-center">
                                                        <div class="rounded iq-card-icon iq-bg-primary">
                                                            <i class="ri-account-box-line"></i>
                                                        </div>
                                                        <div class="media-body ml-3">
                                                            <h6 class="mb-0 ">Account settings</h6>
                                                            <p class="mb-0 font-size-12">Manage your account parameters.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="privacy-setting.html" class="iq-sub-card iq-bg-primary-hover">
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
                                                    <a class="bg-primary iq-sign-btn" href="#" role="button">Sign
                                                        out<i class="ri-login-box-line ml-2"></i></a>
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

        <div class="">
            <section class="m-profile setting-wrapper pt-0">
                <div class="container">
        
                    {{-- <img src="https://img.freepik.com/free-photo/gradient-dark-blue-futuristic-digital-grid-background_53876-129728.jpg?t=st=1720699527~exp=1720703127~hmac=009af48450d1394e58f536f81a4a956cf075db589e1d9b6cc33c6d3026708d54&w=826" style="border-radius: 30px; width:100%; height:200px; " alt="banner" > --}}

                    <div class="row justify-content-center m-1">
                        <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#add-new').modal('show');" >               
                            <img
                            src="<?= $user->ugc_banner ? URL::to('/') . '/public/uploads/ugc-banner/' . $user->ugc_banner : '' ?>"  style="border-radius: 30px; height:auto; width:100%; " alt="Add Banner Image" >
                        </a>
                    </div>
                    <div class="row justify-content-start mx-3">
                        <div >
                        <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#add-new').modal('show');" >
                        <img class="rounded-circle img-fluid text-center mb-3 mt-4"
                        src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="Add Profile Image" style="height: 80px; width: 80px;">
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
                                    <button style="background:#F27906 !important;color: #ffff!important; padding: 5px 100px !important; margin:0%;  cursor:pointer; border:none; "  class="ugc-button" >Share Profile</button>
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
                                
                                <div class="col-lg-6 col-md-12 mb-4 mx-auto" > 
                                        <h2>My Acount
                                            <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#add-new').modal('show');"><i class="fa fa-plus-circle"></i>
                                                <span style="font-size:15px;" >Edit</span>
                                            </a>
                                        </h2>
                                        <div class=" text-white pt-4">
                                        <p style="font-weight: 600; font-size: 18px;">First Name: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span></p> 
                                        </div>
                                        <div class=" text-white">
                                        <p style="font-weight: 600; font-size: 18px;">User Name: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span></p> 
                                        </div>
                                        <div class=" text-white">
                                        <p style="font-weight: 600; font-size: 18px;">Email-id: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></span></p> 
                                        </div>
                                        <div class=" text-white">
                                        <p style="font-weight: 600; font-size: 18px;">Cell Phone: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></span></p> 
                                        </div>
                                        <div class=" text-white">
                                            <p style="font-weight: 600; font-size: 18px;">Gender:
                                                <span style="font-weight: 100; font-size:17px;"> 
                                                    @if(!empty($user->gender) && $user->gender == "null")
                                                        {{__("Male")}}
                                                    @else
                                                        {{$user->gender}}
                                                    @endif
                                                </span>
                                            </p>
                                        </div>
                                        <div class=" text-white">
                                        <p style="font-weight: 600; font-size: 18px;">DOB: <span style="font-weight: 100; font-size:15px;" ><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></span></p> 
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
                                            <div style="border-radius: 7px; background-color:#F27906 ; padding:2px 5px;">
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
                        @foreach ($user_generated_content as $eachugcvideos)
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            
                             <a href="{{ url('ugc/video-player/' . $eachugcvideos->slug) }}" class="m-1">
                                        <div class="ugc-videos" style="position: relative;" >
                                            <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
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
                </div>
        
        
            </section>
        </div>
        


    {{-- <div class="row justify-content-center">
        <div class="col-lg-5 col-md-5 sigk text-center">
            <div class="d-flex justify-content-center">

               
                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <div>
                    <h4 class="main-title mb-4 text-center">My Account</h4>
                </div>
        
            </div>

            <img class="rounded-circle img-fluid text-center mb-3 mt-4"
                src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar ?>" alt="profile-bg" style="height: 150px; width: 150px;">
            <div> 
                <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#add-new').modal('show');"><i class="fa fa-plus-circle"></i> Edit
                </a>
            </div>

            <div class="text-center">
                <p class="account row ">
                    <span class="col-lg-4 text-left">First Name:</span> 
                    <span class="col-lg-4 text-left"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span>
                </p>

                <p class="account row ">
                    <span class="col-lg-4 text-left">User Name:</span>
                    <span class="col-lg-4 text-left"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span>
                </p>

                <p class="account row ">
                    <span class="col-lg-4 text-left">Email-id:</span>
                    <span class="col-lg-8 text-left"> <?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></span>
                </p>

                <p class="account row ">
                    <span class="col-lg-4 text-left">Cell Phone:</span>
                    <span class="col-lg-4 text-left"> <?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></span>
                </p>

                <p class="account row ">
                    <span class="col-lg-4 text-left">Gender:</span>
                    <span class="col-lg-5 text-left"> 
                        <select class="form-control" id="gender" name="gender">
                          @if(!empty($user->gender) && $user->gender == "null" ){{ 'selected' }}@endif> 
                            <option value="Male" @if(!empty($user->gender) && $user->gender == 'Male'){{ 'selected' }}@endif>  Male </option>
                            <option value="Female" @if(!empty($user->gender) && $user->gender == 'Female'){{ 'selected' }}@endif> Female </option>
                            @if(!empty($user->gender) && $user->gender == 'Others'){{ 'selected' }}@endif >
                        </select>
                    </span>
                </p>

                <p class="account row ">
                    <span class="col-lg-4 text-left">DOB:</span>
                    <span class="col-lg-6 text-left"> <?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></span>
                </p>

            </div>
        </div>
    </div> --}}
    
    
                        <!-- Add New Modal -->
    <div class="modal fade" id="add-new">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" style="color: #000;" >Update Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="new-cat-form" enctype="multipart/form-data" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}"
                        method="post">
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
                            <div class="input-group">
                                <input type="password" id="profile_password" name="password" placeholder="Password" class="form-control">
                                <div class="input-group-append" style="margin-left: 70px;">
                                    <button class="btn btn-default reveal" onclick="visibility1(event)" type="button" id="togglePassword">
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label> Cell Phone:</label>
                            <input type="number" id="mobile" name="mobile"
                                value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>"
                                class="form-control" placeholder="Mobile Number" maxlength="10" oninput="limitInput(this)">
                        </div>

                        <div class="form-group">
                            <label> Gender:</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="null" @if(!empty($user->gender) && $user->gender == "null" ){{ 'selected' }}@endif>  Select the Gender </option>
                                <option value="Male" @if(!empty($user->gender) && $user->gender == 'Male'){{ 'selected' }}@endif>  Male </option>
                                <option value="Female" @if(!empty($user->gender) && $user->gender == 'Female'){{ 'selected' }}@endif> Female </option>
                                <option value="Others" @if(!empty($user->gender) && $user->gender == 'Others'){{ 'selected' }}@endif > Others </option>
                            </select>
                        </div>
                        <div class="form-group">
                        <label> Profile Image:</label>
                            <input type="file" multiple="true" class="form-control"
                                name="avatar" id="avatar" required />
                        </div>
                        <div class="form-group">
                            <label> Banner Image:</label>
                                <input type="file" multiple="true" class="form-control"
                                    name="ugc_banner" id="ugc_banner" required />
                        </div>
                        <div class="form-group">
                            <label> DOB:</label>
                            <input type="date" id="DOB" name="DOB" class="form-control" max="<?php echo date("Y-m-d"); ?>"
                                value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" style="padding: 9px 30px !important;" class="btn btn-primary"
                        data-dismiss="modal">Close</button>
                    <button type="button" style="padding: 9px 30px !important;" class="btn btn-primary"
                        id="submit-new-cat">Save changes</button>
                </div>
            </div>
        </div>
        <style>
            .form-control {
                background-color: #fff;
                border: 1px solid transparent;
                height: 45px;
                position: relative;
                color: #000000 !important;
                font-size: 16px;
                width: 100%;
                -webkit-border-radius: 6px;
                height: 45px;
                border-radius: 4px;
                font-family: 'futuraheavy';
            }
            .sign-in-page .form-control:focus, .m-profile .form-control:focus{
                background: #fff!important;
            }
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
                                        class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh
                                        snap!</strong> <?= $errors->first('name') ?></div><?php endif; ?>
                                <label for="username" class="lablecolor"><?= __('Username') ?></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh
                                        snap!</strong> <?= $errors->first('email') ?></div><?php endif; ?>
                                <label for="email"><?= __('Email') ?></label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
                            </div>
                            <div class="well-in col-sm-12 col-xs-12">
                                <?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh
                                        snap!</strong> <?= $errors->first('name') ?></div><?php endif; ?>
                                <label for="username" class="lablecolor"><?= __('Phone Number') ?></label>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        {{-- <select name="ccode">
                                            @foreach ($jsondata as $code)
                                                <option value="{{ $code['dial_code'] }}" 
                                                <?php 
                                                    // if ($code['dial_code'] == $user->ccode) {
                                                    //     echo "selected='selected'";
                                                    // }
                                                ?>
                                                    {{ $code['name'] . ' (' . $code['dial_code'] . ')' }}</option>
                                            @endforeach
                                        </select> --}}
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
                                <input type="submit" value="<?= __('Update Profile') ?>" class="btn btn-primary" />
                                <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
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

    @php
        include public_path('themes/theme5-nemisha/views/footer.blade.php');
    @endphp

<script>
    function Copy() {
    var profile_url = $('#profile_url').val();
    var url =  navigator.clipboard.writeText(window.location.href);
    var profile =  navigator.clipboard.writeText(profile_url);
    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
           setTimeout(function() {
            $('.add_watch').slideUp('fast');
           }, 3000);
    }
  
</script>  

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
        function visibility1(event) {
            event.preventDefault(); // Prevent button default behavior
            var passwordInput = document.getElementById('profile_password');
            var toggleButton = document.getElementById('togglePassword');
            var icon = toggleButton.querySelector('i'); // Find the icon inside the button

            if (passwordInput.type === 'password') {
                passwordInput.type = "text";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = "password";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        function limitInput(input) {
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);  // Ensure only 10 digits
            }
        }
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
                const userId = {{ Auth::user()->id }}; // Get the user ID
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

            const userId = {{ Auth::user()->id }}; 
       
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
        const userId = {{ Auth::user()->id }};

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
    const userId = {{ Auth::user()->id }}; 

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

