@extends('admin.master')

    <head>
		<link rel="stylesheet" href="<?= URL::to('/'). '/assets/dist/css/styles.css';?>" />
		<script src="<?= URL::to('/'). '/assets/dist/js/scripts.js';?>"></script>

    </head>
	<style>
		#wrapper{
	/* margin-top: 10%;
	margin-left: -23%; */

		}
#sidebar-wrapper{		
	
	/* margin-top: -10%; */
}
#page-content-wrapper{		
	
	/* margin-top: 10%; */
}
	</style>
	<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
    .p1{
        font-size: 12px;
    }
        .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>
@section('css')
	<style type="text/css">
	.make-switch{
		z-index:2;
	}
        
      
	</style>

@stop

@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
				
<div id="content-page" class="content-page">
    <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
    <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
    <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
    <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
   <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
    
    <div class="mt-4">
        <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
    <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
     <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>  
    <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
    <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>
         <div class="container-fluid mt-5">
              <div class="iq-card">

<div id="admin-container">
<!-- This is where -->
@if (Session::has('message'))
<div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@if(count($errors) > 0)
@foreach( $errors->all() as $message )
<div class="alert alert-danger display-hide" id="successMessage" >
<button id="successMessage" class="close" data-close="alert"></button>
<span>{{ $message }}</span>
</div>
@endforeach
@endif
	<div class="admin-section-title">
		<h4><i class="entypo-globe"></i> Site Settings</h4> 
        <hr>
	</div>
	<!-- <div class="clear"></div> -->
    <!-- <body> -->
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <!-- <div class="sidebar-heading border-bottom bg-light">Start Bootstrap</div> -->
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="rtmp_url_setting" href="#!">RTMP Streaming URL Settings </a>  
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="site_setting" href="#!">Site Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="ppv_setting" href="#!">PPV Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="video_setting" href="#!">Video Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="registration_setting" href="#!">Registration Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="email_setting" href="#!">Email Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="social_setting" href="#!">Social Networks Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="series_setting" href="#!">Series Settings</a>
                    <?php if(Auth::User()->role =="admin" && Auth::User()->package =="Pro"){  ?>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="transcoding_setting" href="#!"> Transcoding Settings</a>
                    <?php } ?>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="subscription_setting" href="#!">New Subscription Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="login_setting" href="#!">Login Page Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="advertisement_setting" href="#!">Advertisement Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="app_setting" href="#!">APP Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="script_setting" href="#!">Script Settings</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" id="default_Image_setting" href="#!"> Default Image Settings</a>
                </div>
            </div>



	<form method="POST" action="{{ URL::to('admin/settings/save_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
	
            <!-- Page content wrapper-->
           <div class="container-fluid" id="site" style="padding-left:10px;">
        <div class="col-md-8">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><label>Site Name</label></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p class="p1">Enter Your Website Name Below:</p>
                    <input type="text" class="form-control" name="website_name" id="website_name"
                        placeholder="Site Title"
                        value="@if(!empty($settings->website_name)){{ $settings->website_name }}@endif" />
                </div>
            </div>
			</div>
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><label>Site Description</label></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p class="p1">Enter Your Website Description Below:</p>
                    <input type="text" class="form-control" name="website_description" id="website_description"
                        placeholder="Site Description"
                        value="@if(!empty($settings->website_description)){{ $settings->website_description }}@endif" />
                </div>
            </div>
            <!-- </div> -->
            <div class="panel panel-primary col-md-12 mt-3 p-0" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><label>Logo <small>(Dimensions: 180px X 29px)</small></label></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    @if(!empty($settings->logo))
                    <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->logo }}"
                        style="max-height:100px" />
                    @endif
                    <p class="p1">Upload Your Site Logo:</p>
                    <input type="file" multiple="true" class="form-control" name="logo" id="logo" />
                </div>
                <div class="panel panel-primary mt-3 col-md-6 p-0" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Favicon</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" style="display: block;">
                        @if(!empty($settings->favicon))
                        <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->favicon }}"
                            style="max-height:20px" />
                        @endif
                        <p class="p1">Upload Your Site Favicon:</p>
                        <input type="file" multiple="true" class="form-control" name="favicon" id="favicon" />
                    </div>
                </div>
            </div>
        </div>
   
	</div>

    <!-- Default Image Setting-->
     <div class="container-fluid" id="Defaut_image_setting" style="">
            <div class="panel panel-primary mt-3" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><label>Default Image</label></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 align-center">
                            <div class="row">
                                <div>
                                    <div class="default_video_image" style="margin: auto;">
                                        @if(!empty($settings->default_video_image))
                                            <img src="{{ URL::to('/') . '/public/uploads/images/' . $settings->default_video_image }}" style="max-height: 25%; max-width: 25%" />
                                        @endif
                                    </div>
                                 
                                    <p class="p1">Upload Your Default Image:</p>
                                    <input type="file" multiple="true" class="form-control" name="default_video_image" id="default_video_image" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
                            <!-- PPV  -->


        <!-- <div class="container-fluid" id="ppv" > -->
        <div class="row">
            <input type="hidden" value="0" name="demo_mode" id="demo_mode" />
        </div>
        <div class="container-fluid row mt-3" id="ppv">
            <div class="col-sm-6">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Pay per View</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body row">
                        <p class="col-md-8 p1">Enable Pay per View:</p>
                        <div class="form-group col-md-4">
                            <input type="checkbox" name="ppv_status" id="ppv_status" @if(!isset($settings->ppv_status)
                            || (isset($settings->ppv_status) && $settings->ppv_status))checked="checked" value="1"@else
                            value="0"@endif />
                        </div>
                    </div>
                </div>
            </div>
        <div class="row mt-3">
            <div class="col-sm-6" id="Pay_Per_view_Hours">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Pay Per view Hours</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="p1">Hours :</p>
                        <div class="form-group">
                            <div class="make-switch" data-on="success" data-off="warning">

                                <input type="number" class="form-control" name="ppv_hours" id="ppv_hours"
                                    placeholder="# of pay Per view hours"
                                    value="@if(!empty($settings->ppv_hours)){{ $settings->ppv_hours }}@endif" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" id="PPV_Global_Price">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>PPV Global Price</label> </div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="p1">PPV / Movie Price (USD):</p>
                        <div class="form-group">
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="text" class="form-control" name="ppv_price" id="ppv_price"
                                    placeholder="# of PPV Global Price"
                                    value="@if(!empty($settings->ppv_price)){{ $settings->ppv_price }}@endif" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                <!-- video setting -->


            <!-- <div class="container-fluid" id="video" style=""> -->
        <div  class="container-fluid row mt-3" id="videos_settings" style="">
            <div class="col-sm-6">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Videos Per Page</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="p1">Default number of videos to show per page:</p>
                        <input type="text" class="form-control" name="videos_per_page" id="videos_per_page"
                            placeholder="# of Videos Per Page"
                            value="@if(!empty($settings->videos_per_page)){{ $settings->videos_per_page }}@endif" />
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Posts Per Page</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="p1">Default number of posts to show per page:</p>
                        <input type="text" class="form-control" name="posts_per_page" id="posts_per_page"
                            placeholder="# of Posts Per Page"
                            value="@if(!empty($settings->posts_per_page)){{ $settings->posts_per_page }}@endif" />
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
    <!-- Registration -->



    <div class="container-fluid" id="registration">
        <div class="panel panel-primary mt-3" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title"><label>Registration</label></div>
                <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group color-picker d-flex align-items-center justify-content-between"
                            style="width: ;">
                            <div><label class="mt-1">Enable Free Registration </label></div>
                            <div class="d-flex justify-content-between">

                                <div>ON</div>

                                <div class="mt-1">
                                    <label class="switch">
                                        <input type="checkbox" @if(!isset($settings->free_registration) ||
                                        (isset($settings->free_registration) &&
                                        $settings->free_registration))checked="checked" value="1"@else value="0"@endif
                                        name="free_registration" id="free_registration" />
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div>OFF</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group color-picker align-items-center justify-content-between"
                            style="width: ;">
                            <div><label class="mt-1"> Require users to verify account by email: </label></div>
                            <div>ON</div>
                            <div class="mt-1">
                                <label class="switch">
                                <input type="checkbox" @if(!isset($settings->activation_email) ||
                                    (isset($settings->activation_email) && $settings->activation_email))checked="checked"
                                    value="1"@else value="0"@endif name="activation_email" id="activation_email" />
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div>OFF</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group color-picker d-flex align-items-center justify-content-between"
                            style="width: ;">
                            <div><label class="mt-1"> Enable registered users ability to upgrade to subscriber:</label>
                            </div>
                            <div>ON</div>
                            <div class="mt-1">
                                <label class="switch">
                                    <input type="checkbox" @if(!isset($settings->premium_upgrade) ||
                                    (isset($settings->premium_upgrade) && $settings->premium_upgrade))checked="checked"
                                    value="1"@else value="0"@endif name="premium_upgrade" id="premium_upgrade" />
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div>OFF</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group color-picker d-flex align-items-center justify-content-between"
                            style="width: ;">
                            <div><label class="mt-1">Can Access Free Contrent: </label></div>
                            <div class="d-flex justify-content-between">
                                <div>ON</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input type="checkbox" @if(!isset($settings->access_free) ||
                                        (isset($settings->access_free) && $settings->access_free))checked="checked"
                                        value="1"@else value="0"@endif name="access_free" id="access_free" />
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div>OFF</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Email Setting  -->


    <!-- <div class="container-fluid" id="email"> -->
        <div class="container-fluid row mt-3 " id="email">
            <div class="col-md-10">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>System Email</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" style="display: block;">
                        <p class="p1">Email address to be used to send system emails:</p>
                        <input type="text" class="form-control" name="system_email" id="system_email"
                            placeholder="Email Address"
                            value="@if(!empty($settings->system_email)){{ $settings->system_email }}@endif" />
                    </div>
                </div>
                <div class="panel panel-primary mt-3" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Google Analytics Tracking ID</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" style="display: block;">

                        <p class="p1">Google Analytics Tracking ID (ex. UA-12345678-9)::</p>
                        <input type="text" class="form-control" name="google_tracking_id" id="google_tracking_id"
                            placeholder="Google Analytics Tracking ID"
                            value="@if(!empty($settings->google_tracking_id)){{ $settings->google_tracking_id }}@endif" />
                    </div>
                </div>
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <p class="p1">Google Analytics API Integration (This will integrate with your dashboard
                                analytics)</p>
                        </div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body mt-5" style="display: block;">
                        <label>Google Oauth Client ID Key:</label>
                        <input type="text" class="form-control" name="google_oauth_key" id="google_oauth_key"
                            placeholder="Google Client ID Key"
                            value="@if(!empty($settings->google_oauth_key)){{ $settings->google_oauth_key }}@endif" />
                    </div>
                </div>
                <div class="panel panel-primary mt-3" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Refferal Settings</label> </div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" style="display: block;">
                        <label class="panel-title">Enable / Disable:</label>
                        <input type="checkbox" @if($settings->coupon_status == 1)checked="checked" value="1"@else
                        value="0"@endif name="coupon_status">
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->


    <!-- Social Login Settings  -->
        
        <!-- <div class="container-fluid" id="social" style=""> -->
        <div class="container-fluid" id="social" style="" style="padding:15px;">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><label>Social Networks</label></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">

                    <p class="p1">Facebook Page ID: ex. facebook.com/page_id (without facebook.com):</p>
                    <input type="text" class="form-control" name="facebook_page_id" id="facebook_page_id"
                        placeholder="Facebook Page"
                        value="@if(!empty($settings->facebook_page_id)){{ $settings->facebook_page_id }}@endif" />
                    <br />
                    <p class="p1">Google Plus User ID:</p>
                    <input type="text" class="form-control" name="google_page_id" id="google_page_id"
                        placeholder="Google Plus Page"
                        value="@if(!empty($settings->google_page_id)){{ $settings->google_page_id }}@endif" />
                    <br />
                    <p class="p1">Twitter Username:</p>
                    <input type="text" class="form-control" name="twitter_page_id" id="twitter_page_id"
                        placeholder="Twitter Username"
                        value="@if(!empty($settings->twitter_page_id)){{ $settings->twitter_page_id }}@endif" />
                    <br />
                    <p class="p1"> Instagram :</p>
                    <input type="text" class="form-control" name="instagram_page_id" id="instagram_page_id"
                        placeholder="Instagram "
                        value="@if(!empty($settings->instagram_page_id)){{ $settings->instagram_page_id }}@endif" />
                    <br />
                    <p class="p1"> Linkedin:</p>
                    <input type="text" class="form-control" name="linkedin_page_id" id="linkedin_page_id"
                        placeholder="Linkedin "
                        value="@if(!empty($settings->linkedin_page_id)){{ $settings->linkedin_page_id }}@endif" />
                    <br />
                    <p class="p1">Whatsapp :</p>
                    <input type="text" class="form-control" name="whatsapp_page_id" id="whatsapp_page_id"
                        placeholder="Whatsapp "
                        value="@if(!empty($settings->whatsapp_page_id)){{ $settings->whatsapp_page_id }}@endif" />
                    <br />
                    <p class="p1">Skype :</p>
                    <input type="text" class="form-control" name="skype_page_id" id="skype_page_id" placeholder="Skype "
                        value="@if(!empty($settings->skype_page_id)){{ $settings->skype_page_id }}@endif" />
                    <br />
                    <p class="p1">YouTube Channel ex. youtube.com/channel_name:</p>
                    <input type="text" class="form-control" name="youtube_page_id" id="youtube_page_id"
                        placeholder="YouTube Channel"
                        value="@if(!empty($settings->youtube_page_id)){{ $settings->youtube_page_id }}@endif" />
                </div>
            </div>
        </div>
    <!-- </div> -->




    <!-- Series  Setting-->
    <div class="container-fluid" id="seasonsetting" style="">
            <div class="panel panel-primary mt-3" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><label>Series Setting</label></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 align-center">
                            <div class="row">
                                <div>
                                 <div><label class="mt-1">Enable PPV Season</label></div>
                                 <div class="d-flex justify-content-between">

                        <div>OFF</div>

                                <div class="mt-1">
                                    <label class="switch">
                                    <input type="checkbox" @if(!isset($settings->series_season) ||
                                    (isset($settings->series_season) && $settings->series_season))checked="checked"
                                    value="1"@else value="0"@endif name="series_season" id="series_season" />
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div>On</div>
                            </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    




    <!-- Transcoding  Setting-->
    <div class="container-fluid" id="transcodingsetting" style="">
            <div class="panel panel-primary mt-3" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><label>Transcoding Setting</label></div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 align-center">
                            <div class="row">
                                <div>
                                <div class="mt-1 d-flex align-items-center justify-content-around">
                                         <div class="mr-2">OFF</div>
                                        <label class="switch">
                                        <input type="checkbox" @if(!isset($settings->transcoding_access) ||
                                    (isset($settings->transcoding_access) && $settings->transcoding_access))checked="checked"
                                    value="1"@else value="0"@endif name="transcoding_access" id="transcoding_access" />
                                        <!-- <input  type="checkbox"  name="transcoding_access" id="transcoding_access"  @if($settings->transcoding_access == 1) {{ "checked='checked'" }} @else {{ "" }} @endif> -->
                                        <span class="slider round"></span>
                                        </label>
                                           <div class="ml-2">ON</div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    <!-- Subscription Settings  -->

    <div class="container-fluid" id="subscription" style="">
        <div style="padding:15px;">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"> <label>Settings For New Subscription</label> </div>
                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="panel-body" style="display: block;">
                            <label class="panel-title">Coupon Enable / Disable:</label>
                            <label><input type="checkbox" @if($settings->new_subscriber_coupon == 1)checked="checked"
                                value="1"@else value="0"@endif name="new_subscriber_coupon"></label>
                        </div>
                        <div class="panel-body mt-3" style="display: block;">
                            <label class="panel-title">Discount %:</label>
                            <div class="form-group add-profile-pic checkbox">
                                <input type="text" class="form-control" @if(isset($settings->discount_percentage))
                                value="
                                <?=$settings->discount_percentage;?>"@endif placeholder="Discount %:"
                                name="discount_percentage">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="panel-body" style="display: block;">
                            <label class="panel-title">Coupon Code:</label>
                            <div class="form-group add-profile-pic checkbox">
                                <input type="text" class="form-control" @if(isset($settings->coupon_code)) value="
                                <?=$settings->coupon_code;?>"@endif placeholder="Enter Coupon Code" name="coupon_code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
        <!-- <div class="container-fluid" id="login" style=""> -->
        <div class="container-fluid" id="login" style="">
            <div class="col-md-10">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Login Page Content Image</label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" style="display: block;">
                        <p>Login Page Content:</p>
                        <div class="form-group add-profile-pic">
                            @if(!empty($settings->login_content))
                            <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->login_content }}"
                                style="max-height:100px" />
                            @endif
                            <label>Cover Image:</label>
                            <input id="f02" type="file" name="login_content" placeholder="Upload Image" />
                            <p class="padding-top-20 p1">Must be JPEG, PNG, or GIF and cannot exceed 10MB.</p>
                        </div>
                        <div class="form-group add-profile-pic">
                            <label>Login Text:</label>
                            <input id="login_text" type="text" name="login_text" class="form-control"
                                placeholder="Login Text"
                                value="@if(!empty($settings->login_text)){{ $settings->login_text }}@endif" />
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"><label>Email Signature </label></div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" style="display: block;">
                        <div class="form-group add-profile-pic">
                            <p class="p1">Email Signature:</p>
                            <textarea id="summary-ckeditor" name="signature" class="form-control"
                                placeholder="Email signature"
                                value="@if(!empty($settings->signature)){{ $settings->signature }}@endif"><?php echo $settings->signature; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><label>Pusher Notification</label></div>
                                <div class="panel-options"> <a href="#" data-rel="collapse"><i
                                            class="entypo-down-open"></i></a> </div>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <p class="p1">Notification Server Key:</p>
                                <input type="text" class="form-control" name="notification_key" id="notification_key"
                                    placeholder="Notification Server Key"
                                    value="@if(!empty($settings->notification_key)){{ $settings->notification_key }}@endif" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary mt-3" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">Notification Icon</div>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body" style="display: block; background:#141414;">
                        @if(!empty($settings->notification_icon))
                        <img src="{{ URL::to('/public/uploads/') . '/settings/' . $settings->notification_icon }}"
                            style="max-height:100px" />
                        @endif
                        <p>Upload Your Site Notification Icon:</p>
                        <input type="file" multiple="true" class="form-control" name="notification_icon"
                            id="notification_icon" />
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->

										  
 					 
<div class="container-fluid" id="advertisement" style="">
        <div class="panel panel-primary mt-3" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title"><label>Advertisement</label></div>
                <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 align-center">
                        <div class="row">
                            
                            <p class="col-md-8 p1">Enable Advertisement on Videos:</p>

                            <div class="form-group col-md-12">
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" @if(!isset($settings->ads_on_videos) ||
                                    (isset($settings->ads_on_videos) && $settings->ads_on_videos))checked="checked"
                                    value="1"@else value="0"@endif name="ads_on_videos" id="ads_on_videos" />
                                </div>
                            </div>
                            <div class="form-group add-profile-pic">
                                <label>Featured Ad Pre Roll:</label>
                                <input id="featured_pre_ad" type="text" name="featured_pre_ad" class="form-control"
                                placeholder="Featured Ad Pre Roll"
                                value="@if(!empty($settings->featured_pre_ad)){{ $settings->featured_pre_ad }}@endif" />
                            </div>
                            <div class="form-group add-profile-pic">
                                <label>Featured Ad Mid Roll:</label>
                                <input id="featured_mid_ad" type="text" name="featured_mid_ad" class="form-control"
                                placeholder="Featured Ad Mid Roll"
                                value="@if(!empty($settings->featured_mid_ad)){{ $settings->featured_mid_ad }}@endif" />
                            </div>
                            <div class="form-group add-profile-pic">
                                <label>Featured Ad Post Roll:</label>
                                <input id="featured_post_ad" type="text" name="featured_post_ad" class="form-control"
                                placeholder="Featured Ad Post Roll"
                                value="@if(!empty($settings->featured_post_ad)){{ $settings->featured_post_ad }}@endif" />
                            </div>
                            <div class="form-group add-profile-pic">
                                <label>Cost Per Click Advertiser:</label>
                                <input id="cpc_advertiser" type="text" name="cpc_advertiser" class="form-control"
                                placeholder="Cost Per Click Advertiser"
                                value="@if(!empty($settings->cpc_advertiser)){{ $settings->cpc_advertiser }}@endif" />
                            </div>
                            <div class="form-group add-profile-pic">
                                <label>Cost Per Click Admin:</label>
                                <input id="cpc_admin" type="text" name="cpc_admin" class="form-control"
                                placeholder="Cost Per Click Admin"
                                value="@if(!empty($settings->cpc_admin)){{ $settings->cpc_admin }}@endif" />
                            </div>
                            <div class="form-group add-profile-pic">
                                <label>Cost Per View Advertiser:</label>
                                <input id="cpv_advertiser" type="text" name="cpv_advertiser" class="form-control"
                                placeholder="Cost Per View Advertiser"
                                value="@if(!empty($settings->cpv_advertiser)){{ $settings->cpv_advertiser }}@endif" />
                            </div>
                            <div class="form-group add-profile-pic">
                                <label>Cost Per View Admin:</label>
                                <input id="cpv_admin" type="text" name="cpv_admin" class="form-control"
                                placeholder="Cost Per View Admin"
                                value="@if(!empty($settings->cpv_admin)){{ $settings->cpv_admin }}@endif" />
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    <input type="submit" id = "settingupdate" value="Update Settings" class="btn btn-primary pull-right" />
            </form>


<div class="container-fluid" id="script" >
<h5>APP Script:</h5>
    <div class="row">
	        <form method="POST" action="{{ URL::to('admin/settings/script_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" >
            <div class="col-md-12">
                <h5>Header Script CDN:</h5>
                <textarea  rows="5" class="form-control" name="header_script" id="summaryheader"
                    placeholder="Header Script"></textarea>
            
                <h5 class="mt-3">Footer Script CDN:</h5>
                <textarea  rows="5" class="form-control" name="footer_script" id="summaryfooter"
                    placeholder="Footer Script"></textarea>
                   </div>
                    <div class="col-md-12 mt-3">
                <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                <input type="submit" id="scriptsetting" value="Update Settings" class="btn btn-primary pull-right" />
                         </div>
            </form>
            </div>

    </div>
<!-- </div> -->

    <div class="container-fluid" id="app" >
        <h5>APP Setting:</h5>
        <div class="row">
            <form method="POST" action="{{ URL::to('admin/app_settings/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                
                <div class="row mt-4">
                    
                    <div class="col-md-12">
                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                            <div class="panel-title"><label>Android URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                            <div class="panel-body" style="display: block;"> 
                                <input type="text" class="form-control" name="android_url" id="android_url" value="@if(!empty($app_settings->android_url)){{ $app_settings->android_url }}@endif"  />
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                            <div class="panel-title"><label>IOS URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                            <div class="panel-body" style="display: block;"> 
                                <input type="text" class="form-control" name="ios_url" id="ios_url" value="@if(!empty($app_settings->ios_url)){{ $app_settings->ios_url }}@endif"  />
                            </div> 
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                    <div class="col-md-12" style="display: flex; ">
                        <input type="submit" id="appupdate" value="Update APP Settings" class="btn btn-primary " />
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- RTMP streaming --}}

    <div class="container-fluid" id="rtmp_url" >
        <h5>RTMP Video Streaming</h5>
        <div class="row">
            <form method="POST" action="{{ URL::to('admin/rtmp_setting/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Setting_rtmpURL">
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                            <div class="panel-title" > 
                                <label>RTMP URL</label> 
                            </div> 

                            <table class="table table-bordered" id="dynamicTable">  

                                @forelse($rtmp_url as $key => $url)
                                    <tr>  
                                        <td ><input type="text" name="rtmp_url[0][url]" placeholder="rtmp://123.456.789.123/hls/" class="form-control rtmp_urls" value={{ $url->rtmp_url }} readonly/></td>  
                                        <td>
                                            <button type="button" name="add" id="add" class="btn btn-success add">Add </button>
                                            <button type="button" name="remove_url" id="remove_url" class="btn btn-danger remove_url"  data-name="{{ $url->id }}" value="{{$url->rtmp_url}}" onclick="addRow(this)" >Remove</button>
                                        </td>  

                                    </tr>  
                                @empty
                                    <tr>  
                                        <td ><input type="text" name="rtmp_url[0][url]" placeholder="rtmp://123.456.789.123/hls/" class="form-control" /></td>  
                                        <td >
                                            <button type="button" name="add" id="add" class="btn btn-success add">Add </button> 
                                        </td>  
                                    </tr>  
                                @endforelse
                            </table> 
                        </div>
                    </div>
                </div>

                <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                <div class="row mt-4">
                    <div class="col-md-6" style="">
                        <input type="submit" id="appupdate" value="Update RTMP URL Settings" class="btn btn-primary " />
                    </div>
                </div>
            </form>
        </div>
    </div>

    </div></div></div></div>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    
    <script>
    CKEDITOR.replace( 'summaryheader', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace( 'summaryfooter', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    </script>
    
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
		
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
	<script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
	<script>

	$(document).ready(function(){
		// alert('tst');
		$('#site').show();
		$('#ppv').hide();
		$('#registration').hide();
		$('#email').hide();
		$('#videos_settings').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
        $('#script').hide();
		$('#app').hide();
		$('#advertisement').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	$('#site_setting').click(function(){
		$('#site').show();
		$('#videos_settings').hide();
		$('#ppv').hide();
		// $('#videos_settings').hide();
		$('#registration').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
	});

	$('#ppv_setting').click(function(){
		// alert();
		$('#videos_settings').hide();
		$('#site').hide();
		$('#ppv').show();
		$('#registration').hide();
		$('#videos_settings').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});
	$('#video_setting').click(function(){
		$('#site').hide();
		$('#ppv').hide();
		$('#registration').hide();
		$('#videos_settings').show();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});
	$('#registration_setting').click(function(){
		$('#site').hide();
		$('#ppv').hide();
		$('#registration').show();
		$('#videos_settings').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});
	$('#email_setting').click(function(){
		$('#site').hide();
		$('#ppv').hide();
		$('#registration').hide();
		$('#videos_settings').hide();
		$('#email').show();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});
	$('#social_setting').click(function(){
		$('#site').hide();
		$('#ppv').hide();
		$('#registration').hide();
		$('#videos_settings').hide();
		$('#email').hide();
		$('#social').show();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
		$('#scriptsetting').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});
	$('#subscription_setting').click(function(){
		$('#site').hide();
		$('#ppv').hide();
		$('#registration').hide();
		$('#videos_settings').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').show();
		$('#login').hide();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
		$('#scriptsetting').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});
	$('#login_setting').click(function(){
		$('#site').hide();
		$('#videos_settings').hide();
		$('#ppv').hide();
		$('#registration').hide();
		// $('#videos_settings').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').show();
		$('#advertisement').hide();
        $('#script').hide();
		$('#app').hide();
		$('#scriptsetting').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});
	$('#advertisement_setting').click(function(){
		$('#videos_settings').hide();
		$('#site').hide();
		$('#ppv').hide();
		$('#registration').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').show();
        $('#script').hide();
		$('#app').hide();
		$('#scriptsetting').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});


    $('#script_setting').click(function(){
		$('#site').hide();
		$('#videos_settings').hide();
		$('#ppv').hide();
		// $('#videos_settings').hide();
		$('#registration').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
		$('#app').hide();
		$('#script').show();
		$('#scriptsetting').show();
        $("#Defaut_image_setting").hide();
		$('#settingupdate').hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});

	$('#app_setting').click(function(){
		$('#site').hide();
		$('#videos_settings').hide();
		$('#ppv').hide();
		// $('#videos_settings').hide();
		$('#registration').hide();
		$('#email').hide();
		$('#social').hide();
		$('#subscription').hide();
		$('#login').hide();
		$('#advertisement').hide();
		$('#script').hide();
		$('#app').show();
		$('#settingupdate').hide();
		$('#appupdate').show();
		$('#scriptsetting').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

	});

    $("#default_Image_setting").click(function () {
        // alert();
        $("#videos_settings").hide();
        $("#site").hide();
        $("#ppv").hide();
        $("#registration").hide();
        $("#videos_settings").hide();
        $("#email").hide();
        $("#social").hide();
        $("#subscription").hide();
        $("#login").hide();
        $("#advertisement").hide();
        $("#script").hide();
        $("#app").hide();
        // $("#season_setting").hide();
        $("#Defaut_image_setting").show();
        $("#ppv_setting").hide();
        $("#demo_mode").hide();
        $("#Pay_Per_view_Hours").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
        $("#settingupdate").show();

    });
     
    $("#transcoding_setting").click(function () {
        // alert();
        $("#videos_settings").hide();
        $("#site").hide();
        $("#ppv").hide();
        $("#registration").hide();
        $("#videos_settings").hide();
        $("#email").hide();
        $("#social").hide();
        $("#subscription").hide();
        $("#login").hide();
        $("#advertisement").hide();
        $("#script").hide();
        $("#app").hide();
        // $("#season_setting").hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").show();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();

    });
    $("#series_setting").click(function () {
        // alert();
        $("#videos_settings").hide();
        $("#site").hide();
        $("#ppv").hide();
        $("#registration").hide();
        $("#videos_settings").hide();
        $("#email").hide();
        $("#social").hide();
        $("#subscription").hide();
        $("#login").hide();
        $("#advertisement").hide();
        $("#script").hide();
        $("#app").hide();
        // $("#season_setting").hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").show();
        $("#rtmp_url").hide();

    });

    $("#rtmp_url_setting").click(function () {
        $("#videos_settings").hide();
        $("#site").hide();
        $("#ppv").hide();
        $("#registration").hide();
        $("#videos_settings").hide();
        $("#email").hide();
        $("#social").hide();
        $("#subscription").hide();
        $("#login").hide();
        $("#advertisement").hide();
        $("#script").hide();
        $("#app").hide();
        // $("#season_setting").hide();
        $("#Defaut_image_setting").hide();
        $("#ppv_setting").hide();
        $("#demo_mode").hide();
        $("#Pay_Per_view_Hours").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").show();
		$('#settingupdate').hide();

    });

	});
</script>
	
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				if($(this).is(":checked")) {
			    	$(this).val(1);
			    } else {
			    	$(this).val(0);
			    }
			});

			$('#free_registration').change(function(){
				if($(this).is(":checked")) {
					$('#activation_email_block').fadeIn();
					$('#premium_upgrade_block').fadeIn();
				} else {
					$('#activation_email_block').fadeOut();
					$('#premium_upgrade_block').fadeOut();
				}
			});

		});
        
        $('#ppv_status').on('change', function(){
                this.value = this.checked ? 1 : 0;
            
        }).change();

		
		$('#Pay_Per_view_Hours').hide();
		$('#PPV_Global_Price').hide();

				if($('#ppv_status').is(":checked")) {
					$('#Pay_Per_view_Hours').show();
					$('#PPV_Global_Price').show();
				} else {
					$('#Pay_Per_view_Hours').hide();
					$('#PPV_Global_Price').hide();
				}

	</script>

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace( 'summary-ckeditor', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    </script>

{{-- validate --}}

<script>


$(document).ready(function($){

$('form[id="Setting_rtmpURL"]').validate({
   
    rules: {
       ' rtmp_url[]': {
        required: true,
        // url: true
        }
    },

    messages: {
        rtmp_url: "This field is required",
    },
    submitHandler: function (form) {
        form.submit();
    },
});
});

// Append 
        var i = 0;
       
       $(".add").click(function(){
           ++i;
           $("#dynamicTable").append('<tr><td><input type="text" name="rtmp_url['+i+'][url]" placeholder="rtmp://123.456.789.123/hls/"  class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
       });
      
       $(document).on('click', '.remove-tr', function(){  
            $(this).parents('tr').remove();
       }); 


    function addRow(ele) 
		{
			var remove_Data= $(ele).attr('data-name');
            var checkstr =  confirm('are you sure you want to delete this?');

            if(checkstr == true){
                $.ajax({
                    url:"{{ URL::to('admin/rtmp_setting/rtmp_remove') }}",
                    method:'GET',
                    data:{
                        remove_Data:remove_Data
                    },
                    dataType:'json',
                    success:function(data)
                    {
                        window.location.href = "{{ URL::to('admin/settings') }}";
                    }
                })
            }else{
                return false;
            }
		}

        $(window).on('load', function () {
            $("#rtmp_url_setting").trigger("click");
        });
 
</script>

@stop

@stop
        
     
    </body>
                  
</html>
