@extends('admin.master')
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
    .code_editor{
        min-height:300px;
    }
    </style>
@stop
@section('content')
<div id="content-page" class="content-page">
    <div class="d-flex">
        <a class="black"  href="{{ URL::to('admin/home-settings') }}">HomePage</a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/theme_settings') }}">Theme Settings</a>
        <a class="black" href="{{ URL::to('admin/payment_settings') }}">Payment Settings</a>
        <a class="black" href="{{ URL::to('admin/email_settings') }}">Email Settings</a>
        <a class="black" href="{{ URL::to('admin/mobileapp') }}">Mobile App Settings</a>
        <a class="black" href="{{ URL::to('admin/settings') }}">RTMP URL Settings</a>
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
	<div class="admin-section-title">
		<h4><i class="entypo-monitor"></i> Theme Settings for Default Theme</h4> 
	</div>
	<div class="clear"></div>

<form action="{{ URL::to('/admin/theme_settings/save')}}" method="post" enctype="multipart/form-data" id="theme_submit">
    
    @csrf
		<div class="panel panel-primary" data-collapsed="0">
                
                <div class="panel-body"> 
                        <div class="row mt-4 align-items-center">
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                         <div class="panel-heading"> <div class="panel-title"> <p>Site Background Color</p></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                <div class="input-group color-picker" >
                                    <label class="mt-2">Dark Mode</label>
                                    <input type="color" class="form-control ml-1"  name="dark_bg_color" data-format="hex" value="{{ $settings->dark_bg_color}}" />
                                </div>
                                    </div>
                                    <div class="col-sm-6 mt-5">
                                          <div class="input-group color-picker" >
                                    <label class="mt-2">Light Mode</label>
                                    <input type="color" class="form-control ml-1"  name="light_bg_color" data-format="hex" value="{{ $settings->light_bg_color}}" />
                                </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="row align-items-center">
                                    <div class="col-sm-6">
                                         <div class="panel-heading"> <div class="panel-title mb-0"> <p>Site Text Color</p></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                <div class="input-group color-picker">
                                    <label class="mt-2"> Dark Mode</label>
                                    <input type="color" class="form-control ml-1"  name="dark_text_color" data-format="hex" value="{{ $settings->dark_text_color  }}" />
                                </div>
                                     </div>
                                    <div class="col-sm-6 mt-5">
                                     <div class="input-group color-picker" >
                                    <label class="mt-2"> Light Mode</label>
                                    <input type="color" class="form-control ml-1"  name="light_text_color" data-format="hex" value="{{ $settings->light_text_color }}" />
                                </div>
                                     </div>
                                </div>
                            </div>
                           
                        </div>
                </div> 

                <div class="row mt-4 align-items-center">
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                         <div class="panel-heading"> <div class="panel-title"> <p>Admin Site Background Color</p></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                <div class="input-group color-picker" >
                                    <label class="mt-2">Admin Dark Mode</label>
                                    <input type="color" class="form-control ml-1"  name="admin_dark_bg_color" data-format="hex" value="{{ $settings->admin_dark_bg_color}}" />
                                </div>
                                    </div>
                                    <div class="col-sm-6 mt-5">
                                          <div class="input-group color-picker" >
                                    <label class="mt-2">Admin Light Mode</label>
                                    <input type="color" class="form-control ml-1"  name="admin_light_bg_color" data-format="hex" value="{{ $settings->admin_light_bg_color}}" />
                                </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="row align-items-center">
                                    <div class="col-sm-6">
                                         <div class="panel-heading"> <div class="panel-title mb-0"> <p>Admin Site Text Color</p></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                <div class="input-group color-picker">
                                    <label class="mt-2">Admin Dark Mode</label>
                                    <input type="color" class="form-control ml-1"  name="admin_dark_text_color" data-format="hex" value="{{ $settings->admin_dark_text_color  }}" />
                                </div>
                                     </div>
                                    <div class="col-sm-6 mt-5">
                                     <div class="input-group color-picker" >
                                    <label class="mt-2">Admin Light Mode</label>
                                    <input type="color" class="form-control ml-1"  name="admin_light_text_color" data-format="hex" value="{{ $settings->admin_light_text_color }}" />
                                </div>
                                     </div>
                                </div>
                            </div>
                           
                        </div>
                </div> 
               
                <div class="panel-body"> 
                        <div class="row mt-2">
                           
                            
                        </div>
                </div> 
            
            
            <div class="panel-heading mt-3"> 
                <div class="panel-title"> <label>Site Logo</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
            </div> 
			<div class="panel-body"> 
                       <div class="row mt-3">
                           <div class="col-sm-6">
                                <div class="input-group color-picker" >
                                    <label class="mt-2">Dark Mode</label>
                                    <input type="file" class="form-control ml-2"  name="dark_mode_logo"  value="" />
                                </div>
                                <img class="mt-3" src="{{ URL::to('/public/uploads/settings/'.$settings->dark_mode_logo)}}">
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group color-picker" >
                                    <label class="mt-2">Light Mode</label>
                                    <input type="file" class="form-control ml-2"  name="light_mode_logo" value="" />   
                                </div>
                                 <img class="mt-3 text-center"  src="{{ URL::to('/public/uploads/settings/'.$settings->light_mode_logo)}}">
                            </div>
                        </div>
                        <div class="row mt-1 mb-5" id="loader_video_div" style="display:none;">
                            <div class="col-sm-6" id="loader_videos">
                                <div class="input-group color-picker">
                                    <label class="mt-2">Loader Video</label>
                                    <input type="file" class="form-control ml-2" name="loader_video" value="" />
                                </div>
                            </div>
                        </div>
            </div> 

            <div class="row">
                <div class="col-md-6">
                    <div class="panel-heading mt-6"> 
                        <div class="panel-title"> 	
                            <h4><i class="entypo-monitor"></i> Theme Settings for Default Button Color</h4> 
                        </div> 
                        <p>Button Background Color</p>
                        <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                    </div> 
                </div>
            </div>

            
			   <div class="panel-body"> 
                    <div class="row mt-3">
                        <div class="col-sm-4">
                             <div class="input-group color-picker" style="width: 50%;">
                                <label class="mt-2">Color</label>
                                <input type="color" class="form-control ml-1"  name="button_bg_color" data-format="hex" @if( $settings->button_bg_color != null) value="{{ $settings->button_bg_color }}" @else value="{{ '#006AFF' }}"  @endif  />
                            </div>
                        </div>
                    </div>
                </div> 
                
                <div class="panel-heading mt-3"> 
                    <div class="panel-title"> 	
                        <h4><i class="entypo-monitor"></i> Checkout Theme Setting</h4> <br>
                    </div> 

                    <div class="row d-flex mb-3"> 

                        <div class="col-md-6">
                            <label>{{ ucfirst(trans('Enable signup page theme')) }}</label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:#006AFF;"> Default Page </div>

                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="signup_theme" class="signup_theme" id="signup_theme" type="checkbox" @if( $settings->signup_theme == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;"> Single Page</div>

                            </div>
                        </div>
                        @if(!empty($AdminAccessPermission) && $AdminAccessPermission->Audio_Page_checkout == 1)
                            <div class="col-sm-6">
                                <label>{{ ucfirst(trans('Enable Audio page theme')) }}</label>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="audio_page_checkout" class="audio_page_checkout" id="audio_page_checkout" type="checkbox" @if( $settings->audio_page_checkout == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        @endif 
                    </div>

                    <br>

                    <div class="row"> 
                        <div class="col-sm-6">
                            <label>{{ ucfirst(trans('signup Agree Message')) }}</label>
                           <input type="text" placeholder="Signup Agree Message" name="signup_payment_content" class="form-control signup_payment_content" id="signup_payment_content" value="@if(!empty($settings->signup_payment_content)){{ $settings->signup_payment_content }}@endif">
                       </div>

                                    {{-- Sign up - Step 2 Title  --}}
                        <div class="col-sm-6">
                             <label>{{ ucfirst(trans('Sign up - Step 2 Title')) }}</label>
                            <input type="text" placeholder="Sign up - Step 2 Title" name="signup_step2_title" class="form-control signup_step2_title" id="signup_step2_title" value="@if(!empty($settings->signup_step2_title)){{ $settings->signup_step2_title }}@endif">
                        </div>
                    </div>
                </div> <br>

                    <div class="row"> 
                        @if(!empty($AdminAccessPermission) && $AdminAccessPermission->enable_moderator_payment == 1)
                            <div class="col-sm-6">
                            <label>{{ ucfirst(trans('Sign up - CPP Title')) }}</label>
                            <input type="text" placeholder="CPP Signup Title" name="signup_cpp_title" class="form-control signup_cpp_title" id="signup_cpp_title" value="@if(!empty($settings->signup_cpp_title)){{ $settings->signup_cpp_title }}@endif">
                            </div>
                       @endif 

                                    {{-- Sign up - Channel Title  --}}
                        @if(!empty($AdminAccessPermission) && $AdminAccessPermission->enable_channel_payment == 1)
                            <div class="col-sm-6">
                                <label>{{ ucfirst(trans('Sign up - Channel Title')) }}</label>
                                <input type="text" placeholder="Channel Signup Title" name="signup_channel_title" class="form-control signup_channel_title" id="signup_channel_title" value="@if(!empty($settings->signup_channel_title)){{ $settings->signup_channel_title }}@endif">
                            </div>
                       @endif 

                    </div><br>

                  {{-- Style sheet  --}}

                <div>
                    <div class="row">
                        <div class="col-lg-6">
                             <div class="panel-heading mt-3 "> 
                        <div class="panel-title"> 	
                            <h5><i class="entypo-monitor"></i> Style Sheet Link</h5> 
                        </div>             
                    </div> 
    
                    <div class="panel-body"> 
                        <div class="">
                            <input name="style_sheet_link" class="form-control" placeholder="style.css" id="" type="text" value="{{  $settings->style_sheet_link ?  $settings->style_sheet_link : ""  }}">
                        </div>
                    </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="panel-heading mt-3 "> 
                        <div class="panel-title"> 	
                            <h5><i class="entypo-monitor"></i> Typography Link</h5> 
                        </div>             
                    </div> 
                    
    
                    <div class="panel-body"> 
                        <div class="">
                            <input name="typography_link" class="form-control" placeholder="typography.css" id="" type="text" value="{{  $settings->typography_link ?  $settings->typography_link : ""  }}">
                        </div>
                    </div> 
                        </div>
                    </div>
                </div> <br>

                <div class="row"> 
                    @if(!empty($AdminAccessPermission) && $AdminAccessPermission->enable_videoupload_limit_count == 1)
                    <div class="col-sm-6">
                        <label>{{ ucfirst(trans('Enable Video Upload limit Count')) }}</label>
                       <input type="text" placeholder="Video Upload limit Count" name="admin_videoupload_limit_count" class="form-control admin_videoupload_limit_count" id="admin_videoupload_limit_count" value="@if(!empty($settings->admin_videoupload_limit_count)){{ $settings->admin_videoupload_limit_count }}@endif">
                    </div>
                    @endif

                    @if(!empty($AdminAccessPermission) && $AdminAccessPermission->enable_videoupload_limit_status == 1)
                    <div class="col-sm-6">
                        <label>{{ ucfirst(('Enable Video Upload limit Status')) }} </label>
    
                        <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                            <div style="color:red;">Off</div>
                            <div class="mt-1">
                                <label class="switch">
                                    <input name="admin_videoupload_limit_status"  type="checkbox" @if( $settings->admin_videoupload_limit_status == "1") checked  @endif >
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div style="color:green;">On</div>
                        </div>
                    </div>
                    @endif
                </div>



                                 {{-- Prevent Viewing Page Source --}}

                <div class="panel-heading mt-3"> 

                    <div class="row d-flex mb-3" >

                        

                        <div class="col-md-6">
                            <label>{{ ucfirst(trans('Enable Loader')) }}</label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="loader_setting" class="loader_setting" id="loader_setting" type="checkbox" @if( $settings->loader_setting == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Enable</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>{{ ucfirst(trans('Loader Img/Video')) }}</label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Image</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="loader_format" class="loader_format" id="loader_format" type="checkbox" @if($settings->loader_format == "1") checked @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Video</div>
                            </div>
                        </div>
                    </div> 
                    <br>

                    <div class="row d-flex mb-3"> 
                        <div class="col-md-6">
                            <label>{{ ucfirst(trans(' Enable Developer Tools')) }}</label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="prevent_inspect" class="prevent_inspect" id="prevent_inspect" type="checkbox" @if( $settings->prevent_inspect == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Enable</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>{{ ucfirst(trans('Enable Profile Page')) }}</label>

                            <div class="d-flex justify-content-around align-items-center" style="width:60%;">
                                <div style="color:#006AFF;"> Profile Page 1  </div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="my_profile_theme" class="my_profile_theme" id="my_profile_theme" type="checkbox" @if( $settings->my_profile_theme == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Profile Page 2</div>
                            </div>
                        </div>  
                    </div>  
                    <br>

                    <div class="row d-flex mb-3"> 
                        <div class="col-md-6">
                            <label>{{ ucfirst(('Enable SignIn / SignUp Link')) }} <span> ( Header )</span></label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="signin_header"  type="checkbox" @if( $settings->signin_header == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Enable</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>{{ ucfirst(trans('enable search dropdown')) }}</label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="search_dropdown_setting" class="search_dropdown_setting" id="search_dropdown_setting" type="checkbox" @if( $settings->search_dropdown_setting == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Enable</div>
                            </div>
                        </div>

                        
                    </div> 
                    <br>

                    <div class="row d-flex mb-3"> 
                        

                        <div class="col-md-6">
                            <label>{{ (__('Enable Translate Option')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="translate_checkout"  type="checkbox" @if( $settings->translate_checkout == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>{{ ucfirst(('Admin Ads Pre/Post Position')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:85%;">
                                <div style="color:#006AFF;"> Individual  <span> (Default)</span>  </div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="admin_ads_pre_post_position"  type="checkbox" @if( $settings->admin_ads_pre_post_position == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;"> Combine (Only for Videos) </div>
                            </div>
                        </div>

                    </div>

                    <div class="row d-flex mb-3">
                        @if(!empty($AdminAccessPermission) && $AdminAccessPermission->Content_Partner_Page_checkout == 1)
                            <div class="col-md-6">
                                <label>{{ ucfirst(('Enable Content Partner Page')) }} </label>

                                <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                    <div style="color:red;">Vod</div>
                                    <div class="mt-1">
                                        <label class="switch">
                                            <input name="content_partner_checkout"  type="checkbox" @if( $settings->content_partner_checkout == "1") checked  @endif >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div style="color:green;">Aod</div>
                                </div>
                            </div>
                        @endif 
                    </div>

                    
                    <div class="row d-flex mb-3"> 
                    @if(!empty($AdminAccessPermission) && $AdminAccessPermission->Header_Top_Position_checkout == 1)

                        <div class="col-md-6">
                            <label>{{ ucfirst(('Header Top Position')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:65%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="header_top_position"  type="checkbox" @if( $settings->header_top_position == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Enable (Only for theme-4)</div>
                            </div>
                        </div>
                        @endif 

                        @if(!empty($AdminAccessPermission) && $AdminAccessPermission->Header_Side_Position_checkout == 1)

                        <div class="col-md-6">
                            <label>{{ ucfirst(('Header Side Position')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:65%;">
                                <div style="color:red;">Disable</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="header_side_position"  type="checkbox" @if( $settings->header_side_position == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">Enable (Only for theme-4)</div>
                            </div>
                        </div>
                        @endif 
            
                    </div>
                    
                    <div class="row d-flex mb-3"> 
                        @if(!empty($AdminAccessPermission) && $AdminAccessPermission->Extract_Images_checkout == 1)
                        <div class="col-md-6">
                            <label>{{ ucfirst(('Enable Extract Images')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:blue;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_extract_image"  type="checkbox" @if( $settings->enable_extract_image == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>
                    @endif 

                    <div class="col-md-6">
                        <label>{{ (__('Enable Bunny CDN Option')) }} </label>

                        <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                            <div style="color:red;">Off</div>
                            <div class="mt-1">
                                <label class="switch">
                                    <input name="enable_bunny_cdn"  type="checkbox" @if( $settings->enable_bunny_cdn == "1") checked  @endif >
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div style="color:green;">On</div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex mb-3"> 
                
                    <div class="col-md-6">
                            <label>{{ (__('Enable Tv Activation Code')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="Tv_Activation_Code"  type="checkbox" @if( $settings->Tv_Activation_Code == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>
                    <div class="col-md-6">
                            <label>{{ (__('Enable Tv Logged User List')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="Tv_Logged_User_List"  type="checkbox" @if( $settings->Tv_Logged_User_List == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>
                    </div>


                <div class="row d-flex mb-3"> 
                    @if(!empty($AdminAccessPermission) && $AdminAccessPermission->enable_moderator_payment == 1)
                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable Moderator Payment')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_moderator_payment"  type="checkbox" @if( $settings->enable_moderator_payment == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>
                    @endif 

                    @if(!empty($AdminAccessPermission) && $AdminAccessPermission->enable_channel_payment == 1)
                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable Channel Payment')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_channel_payment"  type="checkbox" @if( $settings->enable_channel_payment == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>
                    @endif 
                    <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable Moderator Monetization')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_moderator_Monetization"  type="checkbox" @if( $settings->enable_moderator_Monetization == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable Channel Monetization')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_channel_Monetization"  type="checkbox" @if( $settings->enable_channel_Monetization == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable Logged User Monetization')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_logged_device"  type="checkbox" @if( $settings->enable_logged_device == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable EPG Default TimeZone')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_default_timezone"  type="checkbox" @if( $settings->enable_default_timezone == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable 4K Resolution Conversion')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_4k_conversion"  type="checkbox" @if( $settings->enable_4k_conversion == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        
                        </div>
                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable PPV Plans')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_ppv_plans"  type="checkbox" @if( $settings->enable_ppv_plans == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        
                        </div>


                        <div class="col-md-6 mb-3">
                        <label>{{ ucfirst(('Enable Video Cipher Upload')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_video_cipher_upload"  type="checkbox" @if( $settings->enable_video_cipher_upload == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>{{ ucfirst(('Enable Video Compression')) }} </label>

                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_video_compression"  type="checkbox" @if( $settings->enable_video_compression == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>{{ ucfirst(('Enable Purchase button')) }} </label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="purchase_btn"  type="checkbox" @if( $settings->purchase_btn == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>{{ ucfirst(('Enable Subscribe button')) }} </label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="subscribe_btn"  type="checkbox" @if( $settings->subscribe_btn == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>{{ ucfirst(('Enable Channel partner button')) }} </label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_channel_btn"  type="checkbox" @if( $settings->enable_channel_btn == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>{{ ucfirst(('Enable CPP button')) }} </label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="enable_cpp_btn"  type="checkbox" @if( $settings->enable_cpp_btn == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>{{ ucfirst(('Access change password')) }} </label>
                            <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                <div style="color:red;">Off</div>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="access_change_pass"  type="checkbox" @if( $settings->access_change_pass == "1") checked  @endif >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div style="color:green;">On</div>
                            </div>
                        </div>

                    </div>
                    </div>

                </div>

                    </div>
                
                </div>
                
                <div class="panel-body mt-4 mb-4 mr-4" style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary " name="submit" id="save_settings"> Save Settings</button>
                </div>
</form>
    </div></div>
</div>
	<script src="<?= THEME_URL ?>/assets/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
	<script>
        function updateLoaderVideoVisibility() {
            var loaderFormat = $('#loader_format').is(':checked');
            if (loaderFormat) {
                $('#loader_video_div').show();
            } else {
                $('#loader_video_div').hide();
            }
        }

        $(document).ready(function() {
            updateLoaderVideoVisibility();

            $('#loader_format').on('click', function() {
                updateLoaderVideoVisibility();
            });
        });
        $('#theme_submit').on('submit', function(event) {

                    if (!loaderFormat) {
                        event.preventDefault(); 
                        $('#save_settings').attr('disabled', 'disabled');
                    } else {
                        $('#save_settings').removeAttr('disabled');
                    }
                });


	    var editor = ace.edit("custom_css");
	    editor.setTheme("ace/theme/textmate");
		editor.getSession().setMode("ace/mode/css");

		var textarea = $('textarea[name="custom_css"]').hide();
		editor.getSession().setValue(textarea.val());
		editor.getSession().on('change', function(){
		  textarea.val(editor.getSession().getValue());
		});

		var editor2 = ace.edit("custom_js");
	    editor2.setTheme("ace/theme/textmate");
		editor2.getSession().setMode("ace/mode/javascript");

		var textarea2 = $('textarea[name="custom_js"]').hide();
		editor2.getSession().setValue(textarea2.val());
		editor2.getSession().on('change', function(){
		  textarea2.val(editor2.getSession().getValue());
		});

        

        
        
	</script>

@stop

