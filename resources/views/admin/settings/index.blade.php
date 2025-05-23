@extends('admin.master')

@include('admin.favicon')


    <head>
		<link rel="stylesheet" href="<?= URL::to('/'). '/assets/dist/css/styles.css';?>" />
		<script src="<?= URL::to('/'). '/assets/dist/js/scripts.js';?>"></script>

    </head>
	<style>
        .checkbox{
            opacity: 1!important;
            margin-bottom: 25px;
        }
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
        tr{
            border:transparent!important;
        }
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

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .ppv_switvh span, .ppv_switvh label{display:none;}
    .form-control.ppv_expiry_input, .form-control.ply_btn_input{background-color:#f0f0f0!important};
    /* input */


    .input-effect {
        position: relative;
        width: 100%;
        margin-bottom: 20px; 
    }

    input.effect-22 {
        width: 100%;
        padding: 10px 10px 10px 10px;
        border: 1px solid #ccc;
        font-size: 14px;
        outline: none;
        border-radius: 4px;
        background: none;
        transition: border-color 0.3s ease;
    }

    input.effect-22:focus {
        background: #ededed;
    }
    .effect-label {
        position: absolute;
        left: 10px;
        top: 50%;  
        transform: translateY(-50%);
        transition: 0.3s ease all;
        color: #999;
        font-size: 16px;
        pointer-events: none;
        padding: 0 5px;
    }
    input:focus + .effect-label,
    input:not(:placeholder-shown) + .effect-label {
        top: -10px;
        left: 10px;
        font-size: 12px;
        color: #007bff; 
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
    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
        <a class="black" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
        <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
        <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
        <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
        <a class="black"  href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
    </div>

    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/system_settings') }}">Social Login Settings</a>
        <a class="black" href="{{ URL::to('admin/currency_settings') }}">Currency Settings</a>
        <a class="black" href="{{ URL::to('admin/revenue_settings/index') }}">Revenue Settings</a>
        <a class="black" href="{{ URL::to('admin/ChooseProfileScreen') }}" class="iq-waves-effect">Profile Screen</a>
        <a class="black" href="{{ URL::to('admin/ThemeIntegration') }}" class="iq-waves-effect">Theme</a>
    </div>

<div class="container-fluid p-0">
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

            <div class="row" id="wrapper">
                        <!-- Sidebar-->
                <div class="col-lg-3">
                    <div class=" bg-white" id="sidebar-wrapper">
                        <!-- <div class="sidebar-heading border-bottom bg-light">Start Bootstrap</div> -->
                        <div class="list-group list-group-flush">
                            <a class="list-group-item list-group-item-action list-group-item-light " id="rtmp_url_setting" href="#!">RTMP Streaming URL Settings </a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="site_setting" href="#!">Site Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="ppv_setting" href="#!">PPV Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="video_setting" href="#!">Video Settings</a>
                            @if(!empty($adminaccesspermission) && $adminaccesspermission->slider_trailer == 1)
                                <a class="list-group-item list-group-item-action list-group-item-light " id="slider_settings" href="#!">Slider Settings</a>
                            @endif
                            <a class="list-group-item list-group-item-action list-group-item-light " id="registration_setting" href="#!">Registration Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="email_setting" href="#!">Email Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="social_setting" href="#!">Social Networks Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="series_setting" href="#!">TV Shows Settings</a>
                            <?php if(Auth::User()->role =="admin" && Auth::User()->package =="Business"){  ?>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="transcoding_setting" href="#!"> Transcoding Settings</a>
                            <?php } ?>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="subscription_setting" href="#!">Coupon Code Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="login_setting" href="#!">Login Page Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="advertisement_setting" href="#!">Advertisement Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="app_setting" href="#!">APP Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="script_setting" href="#!">Script Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="default_Image_setting" href="#!"> Default Image Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="cpp_payouts_setting" href="#!">  Payouts Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light" id="recpatcha_setting" href="#!">{{  ucwords('recaptcha settings') }}</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="timezone_setting" href="#!">TimeZone Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="search_setting" href="#!">Search Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="custom_css_setting" href="#!">Custom CSS Settings</a>
                            <a class="list-group-item list-group-item-action list-group-item-light " id="button_text_setting" href="#!">Button Text Settings</a>
                            <!-- Content Partner -->
                        </div>
                    </div>
                </div>


                <div class="col-lg-8 p-0">
                    <form method="POST" action="{{ URL::to('admin/settings/save_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

                        <!-- Page content wrapper-->
                        <div class="container-fluid" id="site" style="">
                            <div class="row p-2">
                                <div class="panel-heading">
                                <div class="panel-title"><label>Site Name</label></div>
                                <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-primary" data-collapsed="0">

                                    <div class="panel-heading">
                                        <div class="panel-title"><label>Site Description</label></div>
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
                                            {{-- Logo --}}

                                <div class="panel panel-primary mt-4" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>Logo
                                            <small>(Dimensions: 180px X 29px)</small></label>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <div class="panel-body col-md-6" >
                                                <p class="p1">Enter Your Logo Width Below:</p>
                                                <input type="number" class="form-control" name="logo_width" id="logo_width"
                                                        placeholder="Logo Width"  value="@if(!empty($settings->logo_width)){{ $settings->logo_width }}@endif" />
                                            </div>

                                            <div class="panel-body col-md-6" >
                                                <p class="p1">Enter Your Logo Height Below:</p>
                                                <input type="number" class="form-control" name="logo_height" id="logo_height"
                                                        placeholder="Logo Height"  value="@if(!empty($settings->logo_height)){{ $settings->logo_height }}@endif" />
                                            </div>
                                        </div>

                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i> </a>
                                        </div>

                                        <div class="panel-body" style="display: block;">
                                            @if(!empty($settings->logo))
                                                <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->logo }}" style="max-height:100px" />
                                            @endif
                                            <p class="p1">Upload Your Site Logo:</p>
                                            <input type="file" multiple="true" class="form-control" name="logo" id="logo" />
                                        </div>
                                    </div>
                                </div>

                                </div>
                                <!-- </div> -->
                            <div class="col-md-6 mt-4 pt-3">
                                    <div class="panel-body" style="display: block;">
                                        <p class="p1">Enter Your Website Description Below:</p>
                                        <input type="text" class="form-control" name="website_description" id="website_description"
                                            placeholder="Site Description"
                                            value="@if(!empty($settings->website_description)){{ $settings->website_description }}@endif" />
                                    </div>
                                    <br>
                                    @if(!empty($sitemap))
                                    <div class="panel-body" style="display: block;">
                                    <label>Click Here to Download you'r SiteMap :</label>
                                        <a href="{{ route('download.xml') }}">Download SiteMap XML</a>
                                    </div>
                                    @endif
                                    <div class=" mt-4 pt-3  p-0" data-collapsed="0">
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

                        <!-- Page content wrapper-->
                        <div class="container-fluid" id="button_text" style="">
                            <div class="row button-text mt-3">
                                <div class="col-6 input-effect">
                                    <input class="effect-22" type="text"  name="play_text" id="play_text" value="@if(!empty($button_text->play_text)){{ $button_text->play_text }}@endif">
                                    <label class="effect-label">Play Now button</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect">
                                    <input class="effect-22" type="text"  name="play_btn_live" id="play_btn_live" value="@if(!empty($button_text->play_btn_live)){{ $button_text->play_btn_live }}@endif">
                                    <label class="effect-label">Play button for Live</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect mt-5">
                                    <input class="effect-22" type="text"  name="subscribe_text" id="subscribe_text" value="@if(!empty($button_text->subscribe_text)){{ $button_text->subscribe_text }}@endif">
                                    <label class="effect-label">Subscribe button</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect mt-5">
                                    <input class="effect-22" type="text"  name="purchase_text" id="purchase_text" value="@if(!empty($button_text->purchase_text)){{ $button_text->purchase_text }}@endif">
                                    <label class="effect-label">Purchase button</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect mt-5">
                                    <input class="effect-22" type="text"  name="registered_text" id="registered_text" value="@if(!empty($button_text->registered_text)){{ $button_text->registered_text }}@endif">
                                    <label class="effect-label">Register button</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect mt-5">
                                    <input class="effect-22" type="text"  name="country_avail_text" id="country_avail_text" value="@if(!empty($button_text->country_avail_text)){{ $button_text->country_avail_text }}@endif">
                                    <label class="effect-label">Not available country button</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect mt-5">
                                    <input class="effect-22" type="text"  name="video_visible_text" id="video_visible_text" value="@if(!empty($button_text->video_visible_text)){{ $button_text->video_visible_text }}@endif">
                                    <label class="effect-label">Video visiblity message</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect mt-5">
                                    <input class="effect-22" type="text"  name="live_visible_text" id="live_visible_text" value="@if(!empty($button_text->live_visible_text)){{ $button_text->live_visible_text }}@endif">
                                    <label class="effect-label">Live visiblity message</label>
                                    <span class="focus-bg"></span>
                                </div>
                                <div class="col-6 input-effect mt-5">
                                    <input class="effect-22" type="text"  name="series_visible_text" id="series_visible_text" value="@if(!empty($button_text->series_visible_text)){{ $button_text->series_visible_text }}@endif">
                                    <label class="effect-label">Series visiblity message</label>
                                    <span class="focus-bg"></span>
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
                                <div class="">
                                    <div class="">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-md-12">
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


                                <div class="panel-heading">
                                    <div class="panel-title"><label> Horizontal Default Image</label></div>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="default_horizontal_image" style="margin: auto;">
                                                @if(!empty($settings->default_horizontal_image))
                                                    <img src="{{ URL::to('/') . '/public/uploads/images/' . $settings->default_horizontal_image }}" style="max-height: 25%; max-width: 25%" />
                                                @endif
                                            </div>

                                            <p class="p1">Upload Your Default Image:</p>
                                            <input type="file" multiple="true" class="form-control" name="default_horizontal_image" id="default_horizontal_image" />
                                        </div>
                                    </div>
                            </div>
                        </div>


                        <!-- PPV Setting -->
                        <!-- <div class="container-fluid" id="ppv" > -->
                        <div class="container-fluid row align-items-center p-3" id="ppv">
                            <div class="row p-2">
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
                                <div class="row mt-3 p-2">
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
                                                    <div class="make-switch ppv_switvh" data-on="success" data-off="warning">
                                                        <input type="number" class="form-control" name="ppv_hours" id="ppv_hours"
                                                            placeholder="# of pay Per view hours"
                                                            value="@if(!empty($settings->ppv_hours)){{ $settings->ppv_hours }}@endif" />
                                                    </div>
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
                                                <div class="make-switch ppv_switvh" data-on="success" data-off="warning">
                                                    <input type="text" class="form-control" name="ppv_price" id="ppv_price"
                                                        placeholder="# of PPV Global Price"
                                                        value="@if(!empty($settings->ppv_price)){{ $settings->ppv_price }}@endif" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row p-2">
                                <div class="col-sm-6" id="Pay_Per_view_Hours">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <div class="panel-heading">
                                            <div class="panel-title"><label>IOS PRODUCT ID</label></div>
                                            <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <p class="p1">IOS Product Id :</p>
                                            <div class="form-group">
                                                <div class="make-switch ppv_switvh" data-on="success" data-off="warning">
                                                    <input type="text" class="form-control" name="ios_product_id" id="ios_product_id"
                                                        placeholder=""
                                                        value="@if(!empty($settings->ios_product_id)){{ $settings->ios_product_id }}@endif" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="PPV_Global_Price">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <div class="panel-heading">
                                            <div class="panel-title"><label>IOS Global Price</label> </div>
                                            <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <p class="p1">IOS Plan Price:</p>
                                            <div class="form-group">
                                                <div class="make-switch ppv_switvh" data-on="success" data-off="warning">
                                                    <input type="text" class="form-control" name="ios_plan_price" id="ios_plan_price"
                                                        placeholder="# of PPV Global IOS Price"
                                                        value="@if(!empty($settings->ios_plan_price)){{ $settings->ios_plan_price }}@endif" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row mt-3">
                                <div class="ppv-for-free mt-3">
                                    <label class="mt-1">Enable free for subscribers</label>
                                    <div class="d-flex">
                                        <div class="col-sm-4">
                                            <div><label class="mt-1">Videos</label> </div>

                                            <div class="d-flex ">
                                                <div>OFF</div>
                                                <div class="mt-1">
                                                    <label class="switch" style="margin: 0 5px">
                                                        <input type="checkbox" {{ !empty($settings->enable_ppv_rent) && $settings->enable_ppv_rent ? 'checked' : '' }} value="1" name="enable_ppv_rent" id="enable_ppv_rent" />
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>ON</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div>
                                                <label class="mt-1">Live</label>
                                            </div>

                                            <div class="d-flex ">
                                                <div>OFF</div>
                                                <div class="mt-1">
                                                    <label class="switch" style="margin: 0 5px">
                                                        <input type="checkbox" {{ !empty($settings->enable_ppv_rent_live) && $settings->enable_ppv_rent_live ? 'checked' : '' }} value="1" name="enable_ppv_rent_live" id="enable_ppv_rent_live" />
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>ON</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div>
                                                <label class="mt-1"> Series</label>
                                            </div>

                                            <div class="d-flex ">
                                                <div>OFF</div>
                                                <div class="mt-1">
                                                    <label class="switch" style="margin: 0 5px">
                                                        <input type="checkbox" {{ !empty($settings->enable_ppv_rent_series) && $settings->enable_ppv_rent_series ? 'checked' : '' }} value="1" name="enable_ppv_rent_series" id="enable_ppv_rent_series" />
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>ON</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-12">
                                        <label>{{ "Ppv description for Video" }}</label>
                                        <input type="text" class="form-control" name="video" id="video" placeholder="Ppv description for video"
                                                        value="@if(!empty($settings->video)){{ $settings->video }}@endif" style="background-color: #e8f5e9 !important;"/>
                                    </div>
                                    <div class="col-12">
                                        <label>{{ "Ppv description for Live" }}</label>
                                        <input type="text" class="form-control" name="live" id="live" placeholder="Ppv description for live"
                                                        value="@if(!empty($settings->live)){{ $settings->live }}@endif" />
                                    </div>
                                    <div class="col-12">
                                        <label>{{ "Ppv description for Series" }}</label>
                                        <input type="text" class="form-control" name="series" id="series" placeholder="Ppv description for series"
                                                        value="@if(!empty($settings->series)){{ $settings->series }}@endif" />
                                    </div>
                                </div>
                            </div>
                            {{-- Set Expiry time --}}
                            {{-- <div class="row mt-5 justify-content-between">
                                <label class="mt-1">PPV expiry duration for videos</label>
                                <div class="col-sm-5">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <span class="text-primary font-size-14">Video started after purchase</span>
                                        <div class="row">
                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Days </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_video_expiry_days" id="started_video_expiry_days" value="@if(!empty($settings->started_video_expiry_days)){{ $settings->started_video_expiry_days }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Hours  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_video_expiry_hours" id="started_video_expiry_hours" value="@if(!empty($settings->started_video_expiry_hours)){{ $settings->started_video_expiry_hours }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Minutes  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_video_expiry_mints" id="started_video_expiry_mints" value="@if(!empty($settings->started_video_expiry_mints)){{ $settings->started_video_expiry_mints }}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <span class="text-primary font-size-14">Video not started after purchase</span>
                                        <div class="row">
                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Days </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_video_expiry_days" id="before_video_expiry_days" value="@if(!empty($settings->before_video_expiry_days)){{ $settings->before_video_expiry_days }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Hours  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_video_expiry_hours" id="before_video_expiry_hours" value="@if(!empty($settings->before_video_expiry_hours)){{ $settings->before_video_expiry_hours }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Minutes  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_video_expiry_mints" id="before_video_expiry_mints" value="@if(!empty($settings->before_video_expiry_mints)){{ $settings->before_video_expiry_mints }}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- expiry duration for live --}}
                            {{-- <div class="row mt-5 justify-content-between">
                                <label class="mt-1">PPV expiry duration for Live</label>
                                <div class="col-sm-5">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <span class="text-primary font-size-14">Live started after purchase</span>
                                        <div class="row">
                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Days </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_live_expiry_days" id="started_live_expiry_days" value="@if(!empty($settings->started_live_expiry_days)){{ $settings->started_live_expiry_days }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Hours  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_live_expiry_hours" id="started_live_expiry_hours" value="@if(!empty($settings->started_live_expiry_hours)){{ $settings->started_live_expiry_hours }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Minutes  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_live_expiry_mints" id="started_live_expiry_mints" value="@if(!empty($settings->started_live_expiry_mints)){{ $settings->started_live_expiry_mints }}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <span class="text-primary font-size-14">Live not started after purchase</span>
                                        <div class="row">
                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Days </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_live_expiry_days" id="before_live_expiry_days" value="@if(!empty($settings->before_live_expiry_days)){{ $settings->before_live_expiry_days }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Hours  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_live_expiry_hours" id="before_live_expiry_hours" value="@if(!empty($settings->before_live_expiry_hours)){{ $settings->before_live_expiry_hours }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Minutes  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_live_expiry_mints" id="before_live_expiry_mints" value="@if(!empty($settings->before_live_expiry_mints)){{ $settings->before_live_expiry_mints }}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- expiry duration for Season --}}
                            {{-- <div class="row mt-5 justify-content-between">
                                <label class="mt-1">PPV expiry duration for season</label>
                                <div class="col-sm-5">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <span class="text-primary font-size-14">Season started after purchase</span>
                                        <div class="row">
                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Days </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_season_expiry_days" id="started_season_expiry_days" value="@if(!empty($settings->started_season_expiry_days)){{ $settings->started_season_expiry_days }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Hours  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_season_expiry_hours" id="started_season_expiry_hours" value="@if(!empty($settings->started_season_expiry_hours)){{ $settings->started_season_expiry_hours }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Minutes  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="started_season_expiry_mints" id="started_season_expiry_mints" value="@if(!empty($settings->started_season_expiry_mints)){{ $settings->started_season_expiry_mints }}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="panel panel-primary" data-collapsed="0">
                                        <span class="text-primary font-size-14">Season not started after purchase</span>
                                        <div class="row">
                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Days </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_season_expiry_days" id="before_season_expiry_days" value="@if(!empty($settings->before_season_expiry_days)){{ $settings->before_season_expiry_days }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Hours  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_season_expiry_hours" id="before_season_expiry_hours" value="@if(!empty($settings->before_season_expiry_hours)){{ $settings->before_season_expiry_hours }}@endif">
                                                </div>
                                            </div>

                                            <div class="panel-body col-md-4">
                                                <div class="form-group">
                                                    <p class="p1"> Minutes  </p>
                                                    <input class="form-control ppv_expiry_input" type="number" name="before_season_expiry_mints" id="before_season_expiry_mints" value="@if(!empty($settings->before_season_expiry_mints)){{ $settings->before_season_expiry_mints }}@endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- End Set Expiry time --}}
                        </div>


                        <!-- video setting -->
                        <div  class="container-fluid  mt-3" id="videos_settings" style="">

                            <div class="panel panel-primary mt-3" data-collapsed="0">

                                <div class="panel-heading">
                                    <h5 class="panel-title mb-4">Videos Setting</h5>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>

                                <div class="row">
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
                                </div>

                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  Admin Video Expiry   </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->videos_expiry_status) || (isset($settings->videos_expiry_status) &&
                                                                $settings->videos_expiry_status))checked="checked" value="1"@else value="0"@endif
                                                                name="videos_expiry_status" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1"> {{ ucwords('EPG status') }}  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->epg_status) || (isset($settings->epg_status) &&
                                                                $settings->epg_status))checked="checked" value="1"@else value="0"@endif
                                                                name="epg_status" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  Show Description </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_description) || (isset($settings->show_description) &&
                                                                $settings->show_description))checked="checked" value="1"@else value="0"@endif
                                                                name="show_description" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  Show Links & details </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_Links_and_details) || (isset($settings->show_Links_and_details) &&
                                                                $settings->show_Links_and_details))checked="checked" value="1"@else value="0"@endif
                                                                name="show_Links_and_details" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1"> Enable Show Genre </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_genre) || (isset($settings->show_genre) &&
                                                                $settings->show_genre))checked="checked" value="1"@else value="0"@endif
                                                                name="show_genre" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  Show Languages </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_languages) || (isset($settings->show_languages) &&
                                                                $settings->show_languages))checked="checked" value="1"@else value="0"@endif
                                                                name="show_languages" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1"> {{ ucwords('Enable show subtitle') }} </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_subtitle) || (isset($settings->show_subtitle) &&
                                                                $settings->show_subtitle))checked="checked" value="1"@else value="0"@endif
                                                                name="show_subtitle" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  Show Artist </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_artist) || (isset($settings->show_artist) &&
                                                                $settings->show_artist))checked="checked" value="1"@else value="0"@endif
                                                                name="show_artist" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  Show Recommended Videos </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_recommended_videos) || (isset($settings->show_recommended_videos) &&
                                                                $settings->show_recommended_videos))checked="checked" value="1"@else value="0"@endif
                                                                name="show_recommended_videos" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  Show Views  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" @if(!isset($settings->show_views) || (isset($settings->show_views) &&
                                                                $settings->show_views))checked="checked" value="1"@else value="0"@endif
                                                                name="show_views" id="" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1"> Enable Home-Page Views All  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox"  {{ !is_null($settings->homepage_views_all_button_status) && $settings->homepage_views_all_button_status == 1 ? 'checked' : null }} value="{{ $settings->homepage_views_all_button_status }}"
                                                                name="homepage_views_all_button_status" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slider setting -->
                        <div class="container-fluid" id="trailer_slider">
                            <div class="panel panel-primary mt-3" data-collapsed="0">
                                <div class="panel-heading">
                                    <h5 class="panel-title mb-4">Slider settings</h5>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-sm-10">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                                style="width: ;">
                                                <div><label class="mt-1">Enable trailer on slider: </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="pr-2">OFF</div>
                                                    <div class="mt-1">
                                                        <label class="switch">
                                                            <input type="checkbox" @if(!isset($settings->slider_trailer) ||
                                                            (isset($settings->slider_trailer) && $settings->slider_trailer))checked="checked"
                                                            value="1"@else value="0"@endif name="slider_trailer" id="slider_trailer" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="pl-2">ON</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                                <!-- </div> -->

                        <!-- Registration Setting -->
                        <div class="container-fluid" id="registration">
                            <div class="panel panel-primary mt-3" data-collapsed="0">
                                <div class="panel-heading">
                                    <h5 class="panel-title mb-4">Registration</h5>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                                style="width: ;">
                                                <div><label class="mt-1">Enable Free Registration </label></div>
                                                <div class="d-flex justify-content-between">

                                                    <div>OFF</div>

                                                    <div class="mt-1">
                                                        <label class="switch">
                                                            <input type="checkbox" @if(!isset($settings->free_registration) ||
                                                            (isset($settings->free_registration) &&
                                                            $settings->free_registration))checked="checked" value="1"@else value="0"@endif
                                                            name="free_registration" id="free_registration" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="input-group color-picker align-items-center justify-content-between"
                                                style="width: ;">
                                                <label class="mt-1"> Require users to verify account by email: </label>
                                                <div class="d-flex">
                                                <div>OFF</div>
                                                <div class="mt-1">
                                                    <label class="switch">
                                                    <input type="checkbox" @if(!isset($settings->activation_email) ||
                                                        (isset($settings->activation_email) && $settings->activation_email))checked="checked"
                                                        value="1"@else value="0"@endif name="activation_email" id="activation_email" />
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>ON</div>
                                            </div>
                                            </div></div>
                                        <div class="col-sm-10">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                                style="width: ;">
                                                <label class="mt-1"> Enable registered users ability to upgrade to subscriber:</label>
                                                <div class="d-flex">
                                                <div>OFF</div>
                                                <div class="mt-1">
                                                    <label class="switch">
                                                        <input type="checkbox" @if(!isset($settings->premium_upgrade) ||
                                                        (isset($settings->premium_upgrade) && $settings->premium_upgrade))checked="checked"
                                                        value="1"@else value="0"@endif name="premium_upgrade" id="premium_upgrade" />
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div>ON</div>
                                                </div></div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                                style="width: ;">
                                                <div><label class="mt-1">Can Access Free Content: </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                    <div class="mt-1">
                                                        <label class="switch">
                                                            <input type="checkbox" @if(!isset($settings->access_free) ||
                                                            (isset($settings->access_free) && $settings->access_free))checked="checked"
                                                            value="1"@else value="0"@endif name="access_free" id="access_free" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-10">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between"
                                                style="width: ;">
                                                <div><label class="mt-1">Enable Landing Page: </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                    <div class="mt-1">
                                                        <label class="switch">
                                                            <input type="checkbox" @if(!isset($settings->enable_landing_page) ||
                                                            (isset($settings->enable_landing_page) && $settings->enable_landing_page))checked="checked"
                                                            value="1"@else value="0"@endif name="enable_landing_page" id="enable_landing_page" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div>ON</div>
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
                            <div class="row">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>System Email</label></div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="panel-body" style="display: block;">
                                        <p class="p1">Email address to be used to send system emails:</p>
                                        <input type="text" class="form-control" name="system_email" id="system_email"
                                            placeholder="Email Address"
                                            value="@if(!empty($settings->system_email)){{ $settings->system_email }}@endif" />
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

                                    <div class="panel panel-primary mt-3" data-collapsed="0">
                                        <div class="panel-heading">
                                            <div class="panel-title"><label>Google Analytics Link</label></div>
                                            <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel-body" style="display: block;">
                                            <input type="text" class="form-control" name="google_analytics_link" id="google_analytics_link"
                                                placeholder="Google Analytics Link"
                                                value="@if(!empty($settings->google_analytics_link)){{ $settings->google_analytics_link }}@endif" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                <div class="panel panel-primary mt-3" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>System Address</label></div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">

                                        <p class="p1">Enter you're System Address:</p>
                                        <textarea id="system_address" name="system_address" class="form-control"
                                                placeholder="Email System Address"
                                                value="@if(!empty($settings->system_address)){{ $settings->system_address }}@endif"><?php echo $settings->system_address; ?></textarea>

                                    </div>
                                </div>
                                <div class="panel panel-primary mt-3" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>System Phone Number</label></div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">

                                        <p class="p1">Enter you're System Phone Number:</p>
                                        <input type="text" class="form-control" name="system_phone_number" id="system_phone_number"
                                            placeholder="System Phone Number"
                                            value="@if(!empty($settings->system_phone_number)){{ $settings->system_phone_number }}@endif" />
                                    </div>
                                </div></div>
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
                                <div class="row d-flex">
                                    <div class="col-md-6">
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

                                    <p class="p1">TikTok:</p>
                                    <input type="text" class="form-control" name="tiktok_page_id" id="tiktok_page_id" placeholder="TikTok User ID"
                                        value="@if(!empty($settings->tiktok_page_id)){{ $settings->tiktok_page_id }}@endif" />

                                </div>

                                </div>

                                <div class="col-md-6">
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
                                        <br />

                                        <p class="p1">E-Mail:</p>
                                    <input type="email" class="form-control" name="email_page_id" id="email_page_id"
                                        placeholder="E-Mail ID"
                                        value="@if(!empty($settings->email_page_id)){{ $settings->email_page_id }}@endif"  />
                                        <br />


                                </div>
                            </div>
                        </div></div>
                        <!-- </div> -->


                        <!-- Content Partner Payouts  Setting-->
                        <div class="container-fluid" id="cpp_payouts" style="padding:15px;">
                            <div class="row" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <!-- <label>Content Partner Payouts : </label> -->
                                    </div>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div><p class="mt-1"> Payouts Settings</p></div>
                                        <div class="d-flex align-items-center">

                                            <div class="mr-2">Manual</div>

                                            <div class="mt-1">
                                                <label class="switch">
                                                <input type="checkbox" @if(!isset($settings->payout_method) ||
                                                (isset($settings->payout_method) && $settings->payout_method))checked="checked"
                                                value="1"@else value="0" @endif name="payout_method" id="payout_method" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="ml-2">PaymentGateWay</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                                <!-- </div> -->
                            <!-- </div> -->


                        <!-- Series  Setting-->
                        <div class="container-fluid" id="seasonsetting">

                            <div class="row d-flex" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>TV Shows Setting</label></div>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row d-flex">
                                        <div class="col-md-6">
                                            <div>
                                                <div class="panel-title"><label>Enable PPV Season</label></div>
                                                <div class="d-flex align-items-center">

                                                <div class="mr-2">OFF</div>
                                                    <div class="mt-1">
                                                        <label class="switch">
                                                            <input type="checkbox" @if(!isset($settings->series_season) ||
                                                                (isset($settings->series_season) && $settings->series_season))checked="checked"
                                                                value="1"@else value="0"@endif name="series_season" id="series_season" />
                                                                <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ml-2">On</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row d-flex">
                                        <div class="col-md-6">
                                            <div>
                                                <div class="panel-title"><label> TV Shows Networks</label></div>
                                                <p>Enable & Disable Networks</p>
                                                <div class="d-flex align-items-center">
                                                <div class="mr-2">OFF</div>
                                                    <div class="mt-1">
                                                        <label class="switch">
                                                            <input type="checkbox" @if(!isset($settings->series_networks_status) ||
                                                                (isset($settings->series_networks_status) && $settings->series_networks_status))checked="checked"
                                                                value="1"@else value="0"@endif name="series_networks_status" id="series_networks_status" />
                                                                <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="ml-2">On</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Transcoding  Setting -->
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
                                            <br>
                                            <br>
                                            <div class="mt-1  align-items-center justify-content-around">
                                                <label class="m-0">Select Transcoding Resolution :</label>
                                                <select class="form-control js-example-basic-multiple" id="transcoding_resolution" name="transcoding_resolution[]" multiple="multiple">
                                                    <!-- if(in_array($val, $zutaten)) echo 'checked="checked"'; -->
                                                    <option value="240p" <?php if(in_array("240p",$resolution)){ echo 'selected' ;} ?>> 240 P </option>
                                                    <option value="360p"<?php if(in_array("360p",$resolution)){ echo 'selected' ;} ?>> 360 P </option>
                                                    <option value="480p"<?php if(in_array("480p",$resolution)){ echo 'selected' ;} ?>> 480 P </option>
                                                    <option value="720p"<?php if(in_array("720p",$resolution)){ echo 'selected' ;} ?>> 720 P </option>
                                                    <option value="1080p"<?php if(in_array("1080p",$resolution)){ echo 'selected' ;} ?>> 1080 P </option>
                                                </select>
                                            </div>
                                            <br>
                                            <br>

                                            </div>
                                            <br>
                                            <br>

                                        <!-- Video CLIP -->

                                            <label for="">Add Video Clip On Transcoding</label>
                                        <div class="row">
                                                <div>
                                                <div class="mt-1 d-flex align-items-center justify-content-around">
                                                        <div class="mr-2">OFF</div>
                                                        <label class="switch">
                                                        <input type="checkbox" @if(!isset($settings->video_clip_enable) ||
                                                            (isset($settings->video_clip_enable) && $settings->video_clip_enable))checked="checked"
                                                            value="1"@else value="0"@endif name="video_clip_enable" id="video_clip_enable" />
                                                        <span class="slider round"></span>
                                                        </label>
                                                        <div class="ml-2">ON</div>
                                                    </div>
                                                </div>
                                            <br>
                                            <br>
                                            <div class="mt-1  align-items-center justify-content-around">
                                            <label class="m-0">Video Clip :</label>
                                                    <p class="p1">Drop and drag the video file</p>
                                                    <div style="position: relative;" >
                                                        <input type="file" accept="video/mp4,video/x-m4v,video/*" name="video_clip" id="video_clip" />
                                                        <!-- <p class="p1">Drop and drag the video file</p>  class="form_video-upload" -->
                                                    </div>
                                                    <?php if(!empty($settings->video_clip)){ ?>
                                                    <video width="200" height="200" controls>
                                                        <source src="<?php echo URL::to('storage/app/public/').'/'.$settings->video_clip; ?>" type="video/mp4" />
                                                    </video>
                                                    <?php }else{  } ?>
                                            </div>
                                            <br>
                                            <br>

                                            </div>
                                        </div>
                                        <!-- /// -->
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Time Zone Setting -->
                        <div class="container-fluid" id="time_zone_setting" style="">
                            <div class="panel panel-primary mt-3" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>Time Zone Setting</label></div>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 align-center">
                                            <div class="row">
                                                <div>
                                                <div class="mt-1 d-flex align-items-center justify-content-around">
                                                        <label class="m-0">Choose TimeZone to Schedule </label>

                                                        <select class="form-control mb-3"  id="time_zone" name="time_zone">
                                                            @foreach($TimeZone as $time_zone)
                                                                <option value="{{ $time_zone->time_zone }}" @if(isset($settings->default_time_zone) && $time_zone->time_zone ==  $settings->default_time_zone)selected="selected"@endif> {{ $time_zone->time_zone }}</option>
                                                            @endforeach
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Time Zone Setting -->
                        <div class="container-fluid" id="search_setting_form" style="">
                            <div class="panel panel-primary mt-3" data-collapsed="0">

                                <div class="panel-heading">
                                    <h5 class="panel-title mb-4"> Search Enable/Disable Setting </h5>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>

                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  {{ ucwords('Show title')}}  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" name="search_title_status" id="" value = {{ $settings->search_title_status }} {{ $settings->search_title_status ? 'checked' : null }}/>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1"> {{ ucwords('Show category') }}  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" name="search_category_status" value = {{ $settings->search_category_status }} {{ $settings->search_category_status ? 'checked' : null }}  />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1"> {{ ucwords('Show search tags') }}  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox"  name="search_tags_status" value = {{ $settings->search_tags_status }} {{ $settings->search_tags_status ? 'checked' : null }} />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  {{ ucwords('show description') }}  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" name="search_description_status"  value={{ $settings->search_description_status }}  {{ $settings->search_description_status ? 'checked' : null }}/>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1">  {{ ucwords('show details') }}  </label></div>
                                                <div class="d-flex justify-content-between">
                                                    <div>OFF</div>
                                                        <div class="mt-1">
                                                            <label class="switch">
                                                                <input type="checkbox" name="search_details_status" value={{ $settings->search_details_status }}  {{ $settings->search_details_status ? 'checked' : null }}/>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    <div>ON</div>
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
                                        <div class="panel-title"> <label>Settings For New Subscription Coupon Code </label> </div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">

                                            <div class="panel-body d-flex align-items-baseline" style="display: block;">
                                                <p class="panel-title mr-2">Coupon Enable / Disable:</p>
                                            <input type="checkbox" @if($settings->new_subscriber_coupon == 1)checked="checked"
                                                    value="1"@else value="0"@endif name="new_subscriber_coupon">
                                            </div>
                                        <div class="col-sm-6">
                                            <div class="panel-body mt-3" style="display: block;">
                                                <label class="panel-title">Discount %:</label>
                                                <div class="form-group add-profile-pic checkbox">

                                                    <input type="text" class="form-control" @if(isset($settings->discount_percentage))
                                                    value="<?=$settings->discount_percentage;?>"@endif placeholder="Discount %:"
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

                        <!-- Login Settings -->
                        <!-- <div class="container-fluid" id="login" style=""> -->
                        <div class="container-fluid" id="login" style="">
                            <div class="col-md-12">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"><label>Login Page Content Image</label></div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        {{-- <p>Login Page Content:</p> --}}
                                        <div class="form-group add-profile-pic">
                                            @if(!empty($settings->login_content))
                                            <img src="{{ URL::to('/') . '/public/uploads/settings/' . $settings->login_content }}"
                                                style="max-height:100px" />
                                            @endif

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
                                        <div class="panel-title"><label>Email Image:</label></div>
                                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        {{-- <p>Email Image:</p> --}}
                                        <div class="form-group add-profile-pic">
                                            @if(!empty($settings->email_image))
                                            <img src="{{ URL::to('public/uploads/settings/'.$settings->email_image) }}"
                                                style="max-height:100px" />
                                            @endif

                                            <input id="f02" type="file" name="email_image" placeholder="Upload Image" />
                                            <p class="padding-top-20 p1">Must be JPEG, PNG, or GIF and cannot exceed 10MB.</p>
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
                                            {{-- <p class="p1">Email Signature:</p> --}}
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

                            <br>
                        </div>



                        <div class="container-fluid" id="advertisement" style="">
                            <div class="panel panel-primary mt-3" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title"><label>Advertisement</label></div>
                                    <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                </div>
                            </div><br>

                            <div class="row d-flex">
                                <div class="col-md-6">
                                    <label for=""> Ads on videos Status :</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">

                                        <div style="color:red;">Disable</div>

                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  {{ $settings->ads_on_videos == 1 ? 'checked' : null }} name="ads_on_videos" id="ads_on_videos">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>

                                <div class="col-md-6">
                                    <label for=""> {{ __('Ads variables on Livestream Status') }} :</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">

                                        <div style="color:red;">Disable</div>

                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  {{ $settings->ads_variable_status == 1 ? 'checked' : null }} name="ads_variable_status" id="ads_variable_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                            </div>
                            <br>

                            <div class="row d-flex">

                                <div class="col-md-6">
                                    <label for="">Default Ads Status :</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">

                                        <div style="color:red;">Disable</div>

                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  {{ $settings->default_ads_status == 1 ? 'checked' : null }} name="default_ads_status" id="default_ads_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>

                                <div class="col-md-6">
                                    <label for="">Ads Play 24/7 :</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">

                                        <div style="color:red;">Disable</div>

                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  @if ($settings->ads_play_unlimited_period == 1) {{ "checked='checked'" }} @else {{ " " }} @endif name="ads_play_unlimited_period" id="ads_play_unlimited_period">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                                <br>

                                <div class="col-md-6">

                                        {{-- default URL --}}
                                    <div class="form-group ">
                                        <label>Default Ads url</label>
                                        <input id="default_ads" type="text" name="default_ads_url" class="form-control" placeholder="Default Ads in videos"
                                        value="@if(!empty($settings->default_ads_url)){{ $settings->default_ads_url }}@endif" />
                                    </div>

                                    <div class="form-group add-profile-pic">
                                        <label>Featured Ad Pre Roll:</label>
                                        <input id="featured_pre_ad" type="text" name="featured_pre_ad" class="form-control" placeholder="Featured Ad Pre Roll"
                                        value="@if(!empty($settings->featured_pre_ad)){{ $settings->featured_pre_ad }}@endif" />
                                    </div>

                                    <div class="form-group add-profile-pic">
                                        <label>Featured Ad Mid Roll:</label>
                                        <input id="featured_mid_ad" type="text" name="featured_mid_ad" class="form-control"placeholder="Featured Ad Mid Roll"
                                        value="@if(!empty($settings->featured_mid_ad)){{ $settings->featured_mid_ad }}@endif" />
                                    </div>

                                    <div class="form-group add-profile-pic">
                                        <label>Featured Ad Post Roll:</label>
                                        <input id="featured_post_ad" type="text" name="featured_post_ad" class="form-control" placeholder="Featured Ad Post Roll"
                                        value="@if(!empty($settings->featured_post_ad)){{ $settings->featured_post_ad }}@endif" />
                                    </div>
                                </div> <br>

                                <div class="col-md-6">
                                    <div class="form-group add-profile-pic">
                                        <label>Cost Per Click Advertiser:</label>
                                        <input id="cpc_advertiser" type="text" name="cpc_advertiser" class="form-control" placeholder="Cost Per Click Advertiser"
                                        value="@if(!empty($settings->cpc_advertiser)){{ $settings->cpc_advertiser }}@endif" />
                                    </div>

                                    <div class="form-group add-profile-pic">
                                        <label>Cost Per Click Admin:</label>
                                        <input id="cpc_admin" type="text" name="cpc_admin" class="form-control" placeholder="Cost Per Click Admin"
                                        value="@if(!empty($settings->cpc_admin)){{ $settings->cpc_admin }}@endif" />
                                    </div>

                                    <div class="form-group add-profile-pic">
                                        <label>Cost Per View Advertiser:</label>
                                        <input id="cpv_advertiser" type="text" name="cpv_advertiser" class="form-control" placeholder="Cost Per View Advertiser"
                                        value="@if(!empty($settings->cpv_advertiser)){{ $settings->cpv_advertiser }}@endif" />
                                    </div>

                                    <div class="form-group add-profile-pic">
                                        <label>Cost Per View Admin:</label>
                                        <input id="cpv_admin" type="text" name="cpv_admin" class="form-control" placeholder="Cost Per View Admin"
                                        value="@if(!empty($settings->cpv_admin)){{ $settings->cpv_admin }}@endif" />
                                    </div>
                                </div>

                                {{-- Note: Adveristment Redirectio for Payment Page While Signup/login --}}

                                <div class="col-md-6">
                                    <label for="">Enable Payment Page <Small> (Adveristment Panel)</Small> :</label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">

                                        <div style="color:red;">Disable</div>

                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox"  {{ ($settings->ads_payment_page_status == 1) ? 'Checked' : null}} name="ads_payment_page_status" id="ads_payment_page_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                        <div style="color:green;">Enable</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            <input type="submit" id = "settingupdate" value="Update Settings" class="mt-3 btn btn-primary pull-right" />
                        </div>
                    </form>


                    <div class="container-fluid" id="script" >
                        <h5 class="mb-4">Header/Footer Scripts:</h5>
                        <div class="row p-0">
                                <form method="POST" action="{{ URL::to('admin/settings/script_settings') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" >
                                    <div class="col-md-12">
                                        <h5>Header Script CDN:</h5>
                                        <textarea  rows="5" class="form-control" name="header_script"  id="header_script"
                                            placeholder="Header Script">
                                            @if(!empty($script->header_script)){{ $script->header_script }}@endif</textarea>
                                            <!-- id="summaryheader" -->

                                        <h5 class="mt-3">Footer Script CDN:</h5>
                                        <textarea  rows="5" class="form-control" name="footer_script" id="footer_script"
                                            placeholder="Footer Script">@if(!empty($script->footer_script)){{ $script->footer_script }}@endif</textarea>
                                            <!-- id="summaryfooter" -->
                                        </div>
                                            <div class="col-md-12 mt-3">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                        <input type="submit" id="scriptsetting" value="Update Settings" class="btn btn-primary pull-right" />
                                    </div>
                                </form>
                        </div>

                    </div>
                    <div class="container-fluid" id="css_custom_setting" >
                        <h5 class="mb-4">Custom Css</h5>
                        <div class="row p-0">
                            <form method="POST" action="{{ URL::to('admin/settings/custom_css_settings') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <textarea rows="5" class="form-control" name="custom_css" id="custom_css" placeholder="Custom css" style="background-color: #F0F0F0;">
                                        @if(!empty($css)){{ $css}}@endif
                                    </textarea>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="submit" id="csssetting" value="Update Settings" class="btn btn-primary pull-right" />
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- </div> -->

                    <div class="container-fluid" id="app" >
                        <h5>App URL Settings for Playstore/Appstore:</h5>
                        <div class="row">
                            <form method="POST" action="{{ URL::to('admin/app_settings/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

                                <div class="row mt-4">

                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                                            <div class="panel-title"><label>Android URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="android_url" id="android_url" value="@if(!empty($app_settings->android_url)){{ $app_settings->android_url }}@endif"  />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                                            <div class="panel-title"><label>IOS URL</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="ios_url" id="ios_url" value="@if(!empty($app_settings->ios_url)){{ $app_settings->ios_url }}@endif"  />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                                            <div class="panel-title"><label>Android TV</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="android_tv" id="android_tv" value="@if(!empty($app_settings->android_tv)){{ $app_settings->android_tv }}@endif"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                                            <div class="panel-title"><label>Fire TV</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="Firetv_url" id="Firetv_url" value="@if(!empty($app_settings->Firetv_url)){{ $app_settings->Firetv_url }}@endif"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                                            <div class="panel-title"><label>Samsung TV</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="samsungtv_url" id="samsungtv_url" value="@if(!empty($app_settings->samsungtv_url)){{ $app_settings->samsungtv_url }}@endif"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                                            <div class="panel-title"><label>Lg TV</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="Lgtv_url" id="Lgtv_url" value="@if(!empty($app_settings->Lgtv_url)){{ $app_settings->Lgtv_url }}@endif"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                                            <div class="panel-title"><label>Roku TV</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                                            <div class="panel-body" style="display: block;">
                                                <input type="text" class="form-control" name="Rokutv_url" id="Rokutv_url" value="@if(!empty($app_settings->Rokutv_url)){{ $app_settings->Rokutv_url }}@endif"  />
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                                    <div class="d-flex justify-content-end mt-3" style=" ">
                                        <input type="submit" id="appupdate" value="Update APP Settings" class="btn btn-primary text-right" />
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>


                    {{-- RTMP streaming --}}
                    <div class="container-fluid" id="rtmp_url" >
                        <h5>RTMP Video Streaming</h5>
                        <div class="row p-0">
                            <form method="POST" action="{{ URL::to('admin/rtmp_setting/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Setting_rtmpURL">
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="panel panel-primary p-0" data-collapsed="0">
                                            <div class="panel-heading">
                                                <div class="panel-title ml-3" >
                                                    <label>RTMP URL</label>
                                                </div>

                                                <table class="table" id="dynamicTable">
                                                    @forelse($rtmp_url as $key => $url)
                                                        <tr>
                                                            <td class="col-md-4" ><input type="text" name="addmore[0][rtmp_url]" placeholder="rtmp://75.119.145.126:1935/show/" class="form-control rtmp_urls" value="{{ $url->rtmp_url }}" readonly/></td>
                                                            <td class="col-md-4" ><input type="text" name="addmore[0][hls_url]" placeholder="http://75.119.145.126:9090/hls/streamkey/index.m3u8" class="form-control rtmp_urls" value="{{ $url->hls_url }}" readonly/></td>
                                                            <td class="col-md-4">
                                                                <button type="button" name="add" id="add" class="btn btn-success add">Add </button>
                                                                <button type="button" name="remove_url" id="remove_url" class="btn btn-danger remove_url"  data-name="{{ $url->id }}" value="{{ $url->rtmp_url }}" onclick="addRow(this)" >Remove</button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td ><input type="text" name="addmore[0][rtmp_url]" placeholder=" rtmp://75.119.145.126:1935/show" class="form-control" /></td>
                                                            <td ><input type="text" name="addmore[0][hls_url]" placeholder="http://75.119.145.126:9090/hls/streamkey/index.m3u8" class="form-control" /></td>
                                                            <td><button type="button" name="add" id="add" class="btn btn-success add">Add </button></td>
                                                        </tr>
                                                    @endforelse
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                    <div class="row mt-4 justify-content-end">
                                        <div class="col-md-6 " >
                                            <input type="submit" id="appupdate" value="Update RTMP URL Settings" class="btn btn-primary ml-3 " />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- recpatcha --}}
                    <div class="container-fluid" id="recpatcha_settings" >
                        <h5>Re-captcha Settings</h5>
                        <div class="row">
                            <form method="POST" action="{{ URL::to('admin/captcha')  }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

                                <div class="row mt-4">

                                    <div class="row d-flex" > 
                                        <div class="col-sm-6" id="">
                                            <div class="panel panel-primary" data-collapsed="0">
                                                <div class="panel-heading">
                                                    <div class="panel-title"><label> {{ ucwords('Captcha Site Key') }}</label></div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <div >
                                                            <input type="text" class="form-control" name="captcha_site_key" id="captcha_site_key" required
                                                            placeholder="Captcha Site Key"
                                                                value="@if(!empty($captchas->captcha_site_key)){{ $captchas->captcha_site_key }}@endif" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6" id="">
                                            <div class="panel panel-primary" data-collapsed="0">
                                                <div class="panel-heading">
                                                    <div class="panel-title"><label> Captcha Secret Key  </label> </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <div >
                                                            <input type="text" class="form-control" name="captcha_secret_key" id="captcha_secret_key"
                                                                placeholder="Captcha Secret Key" required
                                                                value="@if(!empty($captchas->captcha_secret_key)){{ $captchas->captcha_secret_key }}@endif" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <br>

                                    <div class="row d-flex mb-2">
                                        <div class="col-md-6">
                                            <label for=""> {{ ucwords('Enable sign-in Captcha')}} :</label>
                                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                                <div style="color:red;">Disable</div>
        
                                                <div class="mt-1">
                                                    <label class="switch">
                                                        <input type="checkbox" {{ ( $captchas != null && $captchas->enable_captcha == "1") ?  'checked' : null  }} name="enable_captcha"  />
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
        
                                                <div style="color:green;">Enable</div>
                                            </div>
                                            <div class="make-switch" data-on="success" data-off="warning"></div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <label for=""> {{ ucwords('Enable sign-up Captcha')}} :</label>
                                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
        
                                                <div style="color:red;">Disable</div>
        
                                                <div class="mt-1">
                                                    <label class="switch">
                                                        <input type="checkbox"  {{ $settings->enable_captcha_signup == 1 ? 'checked' : null }} name="enable_captcha_signup" id="enable_captcha_signup">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
        
                                                <div style="color:green;">Enable</div>
                                            </div>
                                            <div class="make-switch" data-on="success" data-off="warning"></div>
                                        </div> 
                                    </div><br>

                                    <div class="row d-flex">
                                        <div class="col-md-6">
                                            <label for=""> {{ ucwords('Enable contact-us Captcha')}} :</label>
                                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
        
                                                <div style="color:red;">Disable</div>
        
                                                <div class="mt-1">
                                                    <label class="switch">
                                                        <input type="checkbox"  {{ $settings->enable_captcha_contactus == 1 ? 'checked' : null }} name="enable_captcha_contactus" id="enable_captcha_contactus">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
        
                                                <div style="color:green;">Enable</div>
                                            </div>
                                            <div class="make-switch" data-on="success" data-off="warning"></div>
                                        </div>
                                    </div> <br>

                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                                    <div class="d-flex justify-content-end mt-3" style=" ">
                                        <input type="submit" id="appupdate" value="Update Re-captcha Settings" class="btn btn-primary text-right" />
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>

    <script>
            ClassicEditor
            .create( document.querySelector( '#summary-ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );
            ClassicEditor
            .create( document.querySelector( '#system_address' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->

@section('javascript')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>

<script>
    $(document).ready(function(){

        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);

        $("#expiry_time_started").mask("00");
    })
</script>
	<script src="{{ URL::to('assets\admin\js\bootstrap-switch.min.js') }}"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
	<script>

// $(document).ready(function(){
//     $('#sitemap').click(function(){
//         alert();
//         var Excel_url =  "{{ $sitemap  }}";
//         location.href = Excel_url;
//     });
// });

	$(document).ready(function(){

        $('.js-example-basic-multiple').select2();

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
		$('#cpp_payouts').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();


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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
	});

    $('#button_text_setting').click(function(){
        $('#button_text').show();
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
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#trailer_slider').hide();
	});

	$('#recpatcha_setting').click(function(){
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
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').show();
		$('#settingupdate').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
        $("#settingupdate").hide();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
	});
    $('#custom_css_setting').click(function(){
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
		$('#script').hide();
		$('#scriptsetting').hide();
        $("#Defaut_image_setting").hide();
		$('#settingupdate').hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
        $("#settingupdate").hide();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').show();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
        // $("#Pay_Per_view_Hours").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
        $("#settingupdate").show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
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
        $("#ppv_setting").show();
        $("#demo_mode").hide();
        // $("#Pay_Per_view_Hours").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").show();
		$('#settingupdate').hide();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
    });

    $("#cpp_payouts_setting").click(function () {
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
        $("#ppv_setting").show();
        $("#demo_mode").hide();
        // $("#Pay_Per_view_Hours").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
		$('#cpp_payouts').show();
		$('#settingupdate').show();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
    });


    $("#timezone_setting").click(function () {
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
        $("#Defaut_image_setting").hide();
        $("#ppv_setting").hide();
        $("#demo_mode").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting,#settingupdate').show();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();
    });

    $("#search_setting").click(function () {
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
        $("#Defaut_image_setting").hide();
        $("#ppv_setting").hide();
        $("#demo_mode").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
		$('#search_setting_form').show();
        $('#settingupdate').show();
        $('#css_custom_setting').hide();
        $('#button_text').hide();
        $('#trailer_slider').hide();

    });

    $('#slider_settings').click(function(){
        $('#button_text').hide();
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
		$('#app').hide();
        $("#Defaut_image_setting").hide();
        $("#transcodingsetting").hide();
        $("#seasonsetting").hide();
        $("#rtmp_url").hide();
		$('#settingupdate').show();
		$('#cpp_payouts').hide();
		$('#recpatcha_settings').hide();
		$('#time_zone_setting').hide();
        $('#search_setting_form').hide();
        $('#css_custom_setting').hide();
        $('#trailer_slider').show();
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


{{-- validate --}}

<script>


$(document).ready(function($){

$('form[id="Setting_rtmpURL"]').validate({
    ignore: [],
    rules: {
        'ABCD[][]': {
        required: true,
        },
        'rtmp_url': {
        required: true,
        },
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
           $("#dynamicTable").append('<tr><td class="col-md-4"><input type="text" name="addmore['+i+'][rtmp_url]" placeholder="rtmp://123.456.789.123/hls/"  class="form-control" /></td> <td class="col-md-5"> <input type="text" name="addmore['+i+'][hls_url]" placeholder="http://75.119.145.126:9090/hls/streamkey/index.m3u8"  class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
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
