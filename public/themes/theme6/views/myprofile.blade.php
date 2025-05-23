
@php
include(public_path('themes/theme6/views/header.php'));
$settings = App\Setting::first(); 
@endphp

<style>

.left-card, .right-card{/*background-color: #131313;*/background-color: #000 ;padding-right: 15px;padding-left: 15px;}
.left-card{flex-grow: 3;}
.right-card{flex-grow: 4;}
p.phone-mail {margin-bottom: 0.3rem;}
span.details {border-radius: 3px;padding: 5px 15px;background: #1F1F1F;font-size: 14px;}
.form-control.details{height: 25px;font-size: 14px;}
button.edit-details {padding: 5px 56px;background: #1F1F1F;font-size: 14px;color: #fff;margin-top: 2rem;border: transparent;border-radius: 25px;cursor: pointer;}
.my-profile .sign-user_card{background-color: var(--iq-body-bg);box-shadow: unset;}
    #main-header{ color: #fff; }
    .svg{ color: #fff; } 
    .form-control {
           height: 45px;
           line-height: 29px!important;
           background: #33333391;
           border: 1px solid var(--iq-body-text);
           font-size: 14px;
           color: var(--iq-secondary);
           border-radius: 4px;
  }

  /* .sign-user_card input{
     background-color: rgb(255 255 255) !important;
  } */

  /* profile */
  .col-md-12.profile_image {
     display: flex;
  }

  .profile-bg{
        height: 100px;
        width: 150px!important;
  }

  .img-fluid{
      min-height: 0px!important;
  }

  img.multiuser_img {
     padding: 9%;
     border-radius: 70%;
  }

  .name{
     font-size: larger;
     font-family: auto;
     color: white;
     text-align: center;
  }

  .bdr{ }

  .circle {
     color: white;
     position: absolute;
     margin-top: -6%;
     margin-left: 20%;
     margin-bottom: 0;
     margin-right: 0;
  }

  svg{
      height: 30px;
    }

  .usk li{
      list-style: none;
     padding: 10px 10px;
     cursor: pointer;
  }
    /* .rounded-circle {
    height: 150px;
    width: 150px;
} */
    .fa-fw{
        position: absolute;
    right: 0px;
    top: 34px;
        color: #000;
    background-color: #578cea;
    padding: 12px 22px;
    /* width: 100%; */
    display: flex;
    justify-content: center;
    }
    .modal-backdrop.show{
      opacity: 0;
    }
    .modal-backdrop{
      position:relative;
    }
    label{
      color: #000;
    }
    th label{
      color: #fff !important;
    }
    .modal-open .modal{
      overflow: hidden;
    }
    .my-profile .form-group {
         margin-bottom: 0.5rem;
      }
      .modal-header{padding:1rem 1rem 0 1rem;}
      .alert.text-red {color: red;opacity: 0.9;}
      #avatar-edit {
         position: relative;
         display: inline-block;
      }

      /* Initially hide the edit button */
      #avatar-edit-btn {
         display: none;
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         background-color: rgba(0, 0, 0, 0.5);
         color: #fff;
         padding: 5px;
         border-radius: 50%;
      }

      /* Show the edit button when hovering over the image container */
      #avatar-edit:hover #avatar-edit-btn {
         display: block;
         background-color: transparent;
         cursor: pointer;
      }
      #avatar-edit:hover img.rounded-circle.img-fluid.d-block.position-relative.mb-3 {
         opacity: 0.5;
      }

      .usk li.active {background-color: #1F1F1F; }

</style>

<body>

@php
  $jsonString = file_get_contents(base_path('assets/country_code.json'));   
  $jsondata = json_decode($jsonString, true); 

  $data = Session::all(); 
  
@endphp


<div class="main-content">
        
<div class="row">
  
    <!-- TOP Nav Bar -->
  <div class="iq-top-navbar">
     <div class="iq-navbar-custom">
        <nav style="display:none;"  class="navbar navbar-expand-lg navbar-light p-0">
           <div class="iq-menu-bt d-flex align-items-center">
              <div class="wrapper-menu">
                 <div class="main-circle"><i class="las la-bars"></i></div>
              </div>
              <div class="iq-navbar-logo d-flex justify-content-between">
                 <a href="<?php echo URL::to('home') ?>" class="header-logo">
                    <div class="logo-title">
                       <span class="text-primary text-uppercase"><?php $settings = App\Setting::first(); echo $settings->website_name ; ?></span>
                    </div>
                 </a>
              </div>
           </div>
            
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
              <i class="ri-menu-3-line"></i>
           </button>
           <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto navbar-list">
                  <li class="nav-item nav-icon">
                  <a type="button" class="btn btn-primary  noborder-radius btn-login nomargin visitbtn" href="<?php echo URL::to('home') ?>" ><span>Visit site</span></a>
                  </li>
                 <li class="line-height pt-3">
                    <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                       <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user">
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
                                      <p class="mb-0 font-size-12">View personal profile details.</p>
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
                                      <p class="mb-0 font-size-12">Modify your personal details.</p>
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
                                      <p class="mb-0 font-size-12">Manage your account parameters.</p>
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
                                      <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                                   </div>
                                </div>
                             </a>
                             <div class="d-inline-block w-100 text-center p-3">
                                <a class="bg-primary iq-sign-btn" href="#" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
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
  

    <!-- MainContent -->
<section class="my-profile  setting-wrapper pt-0 p-3">        
    <div class="container">
       
                     {{-- message --}}
      @if (Session::has('message'))
         <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
      @endif

         <div class="sign-user_card">
        <div class="row" style="gap:10px;">
           
            <div class="left-card mb-3 bdr">
                <div class="mt-5 text-white p-0">
                    <ul class="usk" style="margin-left: -45px;">
                        <li class="active"><a class="showSingle" target="1">{{ __('Account Info') }}</a></li>
                        <li><a class="showSingle" target="2">{{ __('Plan Details') }}</a></li>
                        <li><a class="showSingle" target="5">{{ __("Preference for videos") }}</a></li>
                        <li><a class="showSingle" target="6">Profile</a></li>
                        <li><a class="showSingle" target="7">Recently Viewed Items</a></li>
                        <li><a class="showSingle" target="8">Tv Activation Code</a></li>
                        <li><a class="showSingle" target="9">Tv Logged User List</a></li>
                    </ul>
                </div>
            </div>
            <div class="right-card mb-3">
                  <div class="targetDiv" id="div1">
                     <div class="profile-pic-name d-flex align-items-center m-5">
                        <div>
                           @php 
                              $data =  Session::all()
                           @endphp
                           <div class="">
                              <div id="avatar-edit">
                                 @if($user->provider != 'facebook' || $user->provider != 'google')
                                    <img class="rounded-circle img-fluid d-block position-relative mb-3" src="{{URL::asset('public/uploads/avatars/').'/'.$user->avatar}}" alt="profile-bg" style="height: 65px;width:65px;"/>
                                 @else
                                    <img class="rounded-circle img-fluid d-block mb-3" src="{{URL::asset('public/uploads/avatars/').'/'.$user->avatar}}" alt="profile-bg" style="height: 65px;width:65px;object-fit:cover;"/>
                                 @endif
                                 <div id="avatar-edit-btn" class="edit-details position-absolute"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                              </div>
                              <div id="avatar-submit" style="display: none;">
                                 <form id="avatar-form" action="{{ URL::to('/profileupdate') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <img id="avatar-preview" class="rounded-circle img-fluid d-block position-relative mb-3" src="{{URL::asset('public/uploads/avatars/').'/'.$user->avatar}}" alt="profile-bg" style="height: 65px;width:65px;"/>
                                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                    <input type="file" class="form-control editbtn mt-3" name="avatar" id="avatar" accept="image/*" style="display: none;"/>
                                 </form>
                                 <button id="submit-avatar" class="edit-details m-0">{{ __('Save') }}</button>
                              </div>
                           </div>
                        </div>
                        <h4 class="pl-3">{{ __($user->username)}}</h4>
                     </div>
                     <div class="phone-email-details row ml-4">
                        <div class="col-3">
                           <div id="phone-no-edit">
                              <p class="phone-mail">{{ __('Phone Number') }}</p>
                              <span class="details">{{ $user->mobile }}</span>
                              <button id="phone-edit-btn" class="edit-details">{{ __('Edit') }}</button>
                           </div>
                           <div id="phone-no-submit" style="display: none;">
                              <form id="phone-form" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}" method="post">
                                 <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                 <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                                 <p class="phone-mail">{{ __('Phone Number') }}</p>
                                 <input type="text" id="mobile" name="mobile" value="{{ $user->mobile }}" class="form-control details" placeholder="{{ __('Mobile Number') }}" onkeypress="return isNumberKey(event)" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);" minlength="8"
                                    maxlength="15">
                                    <span id="mobile_exists_error" style="color: red; display: none;font-size:14px;">Already exists!</span>
                                    <span id="err-phone-format" style="color: red; display: none;font-size:14px;">Invalid length!</span>

                              </form>
                              <button id="submit-phone" class="edit-details" onclick="checkmobile(event)">{{ __('Submit') }}</button>
                           </div>
                        </div>
                        
                     
                           <div class="col-3" id="email-edit">
                              <div >
                                 <p class="phone-mail">{{ __('Email ID') }}</p>
                                 <span class="details">{{ $user->email }}</span>
                                 <button id="email-edit-btn" class="edit-details">{{ __('Edit') }}</button>
                              </div>
                           </div>
                           <div class="col-6">
                              <div id="email-submit" style="display: none;">
                                 <form id="email-form" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                    <p class="phone-mail">{{ __('Email ID') }}</p>
                                    <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control details" placeholder="{{ __('Email') }}">
                                    <span id="email_exists_error" style="color: red; display: none;font-size:14px;">Already exists!</span>
                                    <span id="err-mail-format" style="color: red; display: none;font-size:14px;">Invalid format!</span>
                                 </form>
                                 <button id="submit-email" class="edit-details" onclick="checkEmail(event)">{{ __('Submit') }}</button>
                              </div>
                           </div>
                        


                     </div>

                  </div>

         
               <div class="col-sm-12 targetDiv" id="div2">
                  <div class="current-plan m-5">
                     <h4>{{ __('Current Plan') }}</h4>
                     <h4 class="text-primary mt-5 mb-4">{{ __($user->plan_name) }}</h4>
                     @php
                        $deviceNames = $alldevices->pluck('device_name')->toArray();
                        $deviceList = implode(', ', $deviceNames);
                     @endphp
                     <span>
                        {{ __('Good video quality in HD ('. $video_quality->first()->video_quality.'). Watch ad-free on '.$deviceList.'.' ) }}
                     </span><br>

                     <a class="btn btn-primary mt-4" href="{{ URL::to('/becomesubscriber')}}">{{ __('Change Plan') }}</a>
                  </div>
               </div>
                
                <div class="targetDiv m-5" id="div3">
                    <div class="row align-items-center justify-content-between mb-3 mt-3">
                        <div class="col-sm-4">
                   <?php  if($user_role == 'registered'){ ?>
                          <h6><?php echo 'Registered'." " .'(Free)'; ?></h6>                                       
                          <h6>Subscription</h6>                                       
                       <?php }elseif($user_role == 'subscriber'){ ?>
                          <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                          <br>       
                       <h5 class="card-title mb-0">Available Specification :</h5><br>
                       <h6> Video Quality : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->video_quality ; } else { ' ';} ?></p></h6>  
                       <h6> Video Resolution : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                       <h6> Available Devices : <p> <?php if($plans != null || !empty($plans) ) {  echo $devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                          <!--<h6>Subscription</h6>-->
                       <?php } ?>
                       </div>
                        <div class="col-sm-6">
                           <?php if(Auth::user()->role == "subscriber"){ ?>
                            <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >Upgrade Plan </a>        
                            <?php }else{ ?>
                    <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                    <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="targetDiv m-5" id="div4">
                 <div class="mb-3" id="updatepic">
               
            </div>
                </div>
                <div class="targetDiv m-5" id="div5">
                    <div class=" mb-3">
                  <h4 class="card-title mb-0">Preference for videos</h4>
                  <form action="{{ route('users-profile-Preference') }}" method="POST"  >
                  @csrf
                  <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                  <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>Preference Language</h5></label>
                    <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                        @foreach ($preference_languages as $preference_language)
                           <option value="{{ $preference_language->id }}" @if( !empty(json_decode($user->preference_language)) && in_array( $preference_language->id, json_decode($user->preference_language) ))selected='selected' @endif >{{ $preference_language->name }}</option>
                        @endforeach
                    </select>
                 </div>

                 <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>Preference Genres</h5></label>
                    <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                        @foreach ($videocategory as $preference_genres)
                           <option value="{{ $preference_genres->id }}" @if( !empty(json_decode($user->preference_genres)) && in_array( $preference_genres->id, json_decode($user->preference_genres) ))selected='selected' @endif >{{ $preference_genres->name }}</option>
                        @endforeach
                    </select>
                 </div>

                  <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                  </form>		
              </div>
               </div>
                  <div class="targetDiv m-5" id="div6">
                     <div class="p-3 mb-3">
                        <div class="row justify-content-between">
                           <h4 class="card-title mb-0 manage"> Profile</h4>
                           <div id="error-message" class="alert text-red" style="display: none;">
                              {{ __("You have reached the maximum profile limit.") }}
                        </div>
                     </div>
                     <div class="col-md-12 profile_image mt-3 p-0">                  
                        @forelse  ( $profile_details as $profile )
                           <div class="">
                              <div>
                                 <h2 class="name">{{ $profile ? $profile->user_name : ''  }}</h2>
                                 <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                              </div>
                              <div class=" text-center text-white">
                                 
                                 <a  href="{{ route('profile-details_edit', $profile->id ) }}"> <i class="fa fa-pencil"></i> </a>

                                 @if($Multiuser == null)
                                    <a class="ml-2"  href="{{ URL::to('profile_delete', $profile->id)}}" onclick="return confirm('Are you sure to delete this Profile?')" >
                                       <i class="fa fa-trash"></i>
                                    </a> 
                                 @endif

                              </div>
                           </div> 
                        @empty
                           <div class="col-sm-6">  
                              <p class="name"> No Profile </p>  
                           </div>
                        @endforelse

                        <div class="col-md-6">
                           <a id="add-profile-btn" style="color: white !important; cursor: pointer;">
                              <i class="fa fa-plus-circle fa-100x"></i> <?= 'add profile' ?>
                           </a>
                        </div>                        
                     </div>
   
                     </div> 
                  </div>
                <div class="targetDiv m-5" id="div7">
                    <div class="iq-card" id="recentviews" style="background-color:#191919;">
                 <div class="iq-card-header d-flex justify-content-between" >
                    <div class="iq-header-title">
                       <h4 class="card-title">Recently Viewed Items</h4>
                    </div>
                    
                 </div>
                  <div class="iq-card-body">
                    <div class="table-responsive " >
                       <table class="data-tables table movie_table recent_table" style="width:100%">
                          <thead>
                             <tr>
                                <th style="width:20%;">Video</th>
                                <th style="width:10%;">Rating</th>
                                <th style="width:20%;">Category</th>
                                   <!-- <th style="width:10%;">Views</th>
                            <th style="width:10%;">User</th>
                                 <th style="width:20%;">Date</th> 
                                <th style="width:10%;"><i class="lar la-heart"></i></th>-->
                             </tr>
                          </thead>
                          <tbody>
                          @foreach($recent_videos as $video)
                          @foreach($video as $val)
                             <tr>
                                <td>
                                   <div class="media align-items-center">
                                      <div class="iq-movie">
                                      <a href="javascript:void(0);"><img
                                               src="{{ URL::to('/') . '/public/uploads/images/' . $val->image }}"
                                               class="img-border-radius avatar-40 img-fluid" alt=""></a>  </div>
                                      <div class="media-body text-white text-left ml-3">
                                         <p class="mb-0"></p>
                                         <small> </small>
                                      </div>
                                   </div>
                                </td>
                                <td>{{ $val->rating }}<i class="lar la-star mr-2"></i></td>
                                <td>@if(isset($val->categories->name)) {{ $val->categories->name }} @endif</td>
                               <!-- <td>{{ $val->views }}</td> 
                              
                                 <td>{{ $val->created_at }}</td>
                                <td><i class="las la-heart text-primary"></i></td> -->
                             </tr>
                             @endforeach                                                                     
                             @endforeach                                                                     
                          </tbody>
                       </table>
                    </div>
                 </div>
                </div>
               
                </div>
                 <div class="targetDiv m-5" id="div8">
                  
                          <p class="text-white">Enter Tv Activation Code</p>
                <form id="tv-code" accept-charset="UTF-8" action="{{ URL::to('user/tv-code') }}"   enctype="multipart/form-data" method="post">
                              @csrf
                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <input type="hidden" name="email" value="{{ $user->email }}" />
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="text" name="tv_code" id="tv_code" value="@if(!empty($UserTVLoginCode->tv_code)){{ $UserTVLoginCode->tv_code.' '.$UserTVLoginCode->uniqueId }}@endif" />

                                          </div>
                                       <div class="col-md-4">
                                       @if(!empty($UserTVLoginCode->tv_code))
                                             <a type="button" href="{{ URL::to('user/tv-code/remove/') }}/{{$UserTVLoginCode->id}}" style="z-index:999; position: absolute; background-color:#df1a10!important;" class="btn round tv-code-remove text-red">Remove</a>
                                       @else
                                       <a type="button" id='tvCode' style='z-index:999; position: absolute;' class="btn round tv-code text-white">Add</a>
                                       @endif
                                          </div>
                                       </div>
                           </form>
                  </div>
                  <div class="targetDiv m-5" id="div9">
                  
                  <p class="text-white">Tv Logged User List</p>
       
                               <div class="col-md-12 col-lg-12">

                               <table class="table  artists-table iq-card text-center p-0">
                                          <tr class="r1">
                                             <th><label> S.No </label></th>
                                             <th><label> Email </label></th>
                                             <th><label> TV Code </label></th>
                                             <th><label> Action </label></th>
                                             
                                             @foreach($LoggedusersCode as $key=>$Logged_usersCode)
                                             <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td valign="bottom"><p> {{ $Logged_usersCode->email  }} </p></td>
                                                <td valign="bottom"><p> {{ $Logged_usersCode->tv_code  }} </p></td>
                                                <td>
                                                   <p class=" align-items-center list-user-action">
                                                      <a type="button" href="{{ URL::to('user/tv-code/remove/') }}/{{$Logged_usersCode->id}}" style="z-index:999;  background-color:#df1a10!important;" class="btn round tv-code-remove text-red">Remove</a>
                                                   </p>
                                                </td>
                                             </tr>
                                          @endforeach
                                    </table>

                                  </div>
                               </div>
          </div>
            </div></div>
            
<style>
.form-control {
background-color: #F2F5FA;
border: 1px solid #acaeb3;
height: 45px;
position: relative;
color: #000000!important;
font-size: 16px;
width: 100%;
-webkit-border-radius: 6px;
height: 45px;
border-radius: 4px;
}
</style>
            


  <div class="clear"></div>   
  
    </div>
    </div>
   
</div>
</div>  
</div>
<!--</div>-->
        

  </div>

  <!-- email validation existing mail -->
<script>
   function checkEmail(event) {
      event.preventDefault();
      
      var email = document.getElementById('email').value;
      // alert(email);

      $.ajax({
         url: '{{ route('check.email') }}',
         type: 'POST',
         data: {
               _token: '{{ csrf_token() }}',
               email: email
         },
         success: function(response) {
               if(response.exists) {
                  $('#email_exists_error').show();
               } else {
                  $('#email_exists_error').hide();
                  document.getElementById('email-form').submit();
               }
         }
      });
   }
</script>

<!-- mobile length validation -->
<script>
   $(document).ready(function(){
      
      $('#mobile').change(function(){
         var mob_length = $('#mobile').val().length;
         console.log(mob_length);
         if(mob_length < 7){
            $('#submit-phone').attr('disabled',true);
            $('#err-phone-format').show();
         } else{
            $('#submit-phone').attr('disabled',false);
         }
      });

      $('#email').change(function() {
         var value = $('#email').val();
         var atPosition = value.indexOf('@');
         var dotPosition = value.lastIndexOf('.');

         if (atPosition === -1 || dotPosition === -1 || dotPosition <= atPosition + 1 || dotPosition === value.length - 1) {
            $('#submit-email').attr('disabled', true);
            $('#err-mail-format').show();
         } else {
            $('#submit-email').attr('disabled', false);
         }
      });


   });
</script>

  <!-- mobile validation existing mobile -->
<script>
   function checkmobile(event) {
      event.preventDefault();
      
      var mobile = document.getElementById('mobile').value;
      // alert(mobile);


      $.ajax({
         url: '{{ route('check.mobile') }}',
         type: 'POST',
         data: {
               _token: '{{ csrf_token() }}',
               mobile: mobile
         },
         success: function(response) {
               if(response.exists) {
                  $('#mobile_exists_error').show();
               } else {
                  $('#mobile_exists_error').hide();
                  document.getElementById('phone-form').submit();
               }
         }
      });
   }
</script>


 
<script>
   document.addEventListener('DOMContentLoaded', function() {
      var phoneEditBtn = document.getElementById('phone-edit-btn');
      var emailEditBtn = document.getElementById('email-edit-btn');
      var phoneNoEdit = document.getElementById('phone-no-edit');
      var emailEdit = document.getElementById('email-edit');
      var phoneNoSubmit = document.getElementById('phone-no-submit');
      var emailSubmit = document.getElementById('email-submit');
      var avatarEditBtn = document.getElementById('avatar-edit-btn');
      var avatarInput = document.getElementById('avatar');
      var avatarSubmit = document.getElementById('avatar-submit');
      var avatarEdit = document.getElementById('avatar-edit');
      var avatarPreview = document.getElementById('avatar-preview');

       phoneEditBtn.addEventListener('click', function(event) {
           event.preventDefault();
           phoneNoEdit.style.display = 'none';
           phoneNoSubmit.style.display = 'block';
       });

       emailEditBtn.addEventListener('click', function(event) {
           event.preventDefault();
           emailEdit.style.display = 'none';
           emailSubmit.style.display = 'block';
       });


      avatarEditBtn.addEventListener('click', function(event) {
         event.preventDefault();
         avatarInput.click();
      });

      avatarInput.addEventListener('change', function() {
         avatarEdit.style.display = 'none';
         avatarSubmit.style.display = 'block';

         if (avatarInput.files && avatarInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                  avatarPreview.src = e.target.result;
            }

            reader.readAsDataURL(avatarInput.files[0]);
         }
      });

      document.getElementById('submit-avatar').addEventListener('click', function() {
         document.getElementById('avatar-form').submit();
      });
   });
</script>


  
  <?php $settings = App\Setting::first(); ?>

  
   <script>
$(document).ready(function () {

$(".tv-code").click(function(){
$('#tv-code').submit();
});
});

$(document).ready(function () {
  $(".thumb-cont").hide();
  $(".show-details-button").on("click", function () {
    var idval = $(this).attr("data-id");
    $(".thumb-cont").hide();
    $("#" + idval).show();
  });
  $(".closewin").on("click", function () {
    var idval = $(this).attr("data-id");
    $(".thumb-cont").hide();
    $("#" + idval).hide();
  });
});
</script>
<script>
function about(evt , id) {
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

<script type="text/javascript">
$(document).ready(function () {
$('.searches').on('keyup',function() {
  var query = $(this).val();
  //alert(query);
  // alert(query);
   if (query !=''){
  $.ajax({
    url:"<?php echo URL::to('/search');?>",
    type:"GET",
    data:{
      'country':query}
    ,
    success:function (data) {
      $('.search_list').html(data);
    }
  }
        )
   } else {
        $('.search_list').html("");
   }
}
                 );
$(document).on('click', 'li', function(){
  var value = $(this).text();
  $('.search').val(value);
  $('.search_list').html("");
}
              );
}
               );
</script>
<!--<script>
window.onscroll = function() {myFunction()};

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
if (isset($page) && $page =='admin-dashboard') {
        $visitor_count = TotalVisitorcount();
        $chart_details = "[$total_subscription, $total_recent_subscription, $total_videos, $visitor_count]";
        $chart_lables = "['Total Subscribers', 'New Subscribers', 'Total Videos', 'Total Visitors']";
        $all_category = App\VideoCategory::all();
        $items = array(); 
        $lastmonth = array();      
           foreach($all_category as $category) {
              $categoty_sum = App\Video::where("video_category_id","=",$category->id)->sum('views');
              $items[] = "'$category->name'";
              $lastmonth[] = "'$categoty_sum'";
           }
           $cate_chart = implode(',', $items);
           $last_month_chart = implode(',', $lastmonth);
}
?>





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

   function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
      }
      return true;
   }

   $(document).ready(function(){
      $(".usk li:first-child a").trigger("click");

      $(".showSingle").click(function() {
         var target = $(this).attr("target");
         
         $("#div" + target).show();

         $(".usk li").removeClass("active");
         $(this).parent().addClass("active");
      });
   });



</script>

<!-- check multiprofile validation -->
<script>
   document.getElementById('add-profile-btn').addEventListener('click', function () {
       fetch('{{ route("check-profile-limit") }}', {
           method: 'GET',
           headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}',
               'Accept': 'application/json',
           }
       })
       .then(response => response.json())
       .then(data => {
           if (data.limitReached) {
               document.getElementById('error-message').style.display = 'block';
           } else {
               window.location.href = '{{ route("Multi-profile-create") }}';
           }
       })
       .catch(error => console.error('Error:', error));
   });
</script>

<script>

$(document).ready(function(){
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
  $(document).ready(function(){
     if(jQuery('#view-chart-01').length){

var chart_01_lable = $('#chart_01_lable').val();
//alert(chart_01_lable);
var options = {
  series: <?php echo $chart_details;?>,
  chart: {
  width: 250,
     type: 'donut',
  },
colors:['#e20e02', '#f68a04', '#007aff','#545e75'],
labels: <?php echo $chart_lables;?>,
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
var chart = new ApexCharts(document.querySelector("#view-chart-01"), options);
chart.render();
} 

if(jQuery('#view-chart-02').length){
    var options = {
      series: [44, 30, 20, 43, 22,20],
      chart: {
      width: 250,
      type: 'donut',
    },
    colors:['#e20e02','#83878a', '#007aff','#f68a04', '#14e788','#545e75'],
    labels: <?php echo "[".$cate_chart."]";?>,
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


if(jQuery('#view-chart-03').length){
    var options = {
      series: [{
      name: 'This Month',
      data: [44, 55,30,60,7000]
    }, {
      name: 'Last Month',
      data: [35, 41,20,40,100]
    }],
    colors:['#e20e02', '#007aff'],
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
      categories: <?php echo "[".$cate_chart."]";?>,
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
        formatter: function (val) {
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
        
        
    
        
      jQuery(function(){
     jQuery('#showall').click(function(){
           jQuery('.targetDiv').show();
           jQuery('.showSingle .limg').show();
            
    });
    jQuery('.showSingle').click(function(){
          jQuery('.targetDiv').hide();
          jQuery('.showSingle .dimg').hide();         
          jQuery('#div'+$(this).attr('target')).show();
    });
});
        
    
    </script>
<script type="text/javascript">

jQuery(document).ready(function($){


// Add New Category
   $('#submit-new-cat').click(function(){
      $('#new-cat-form').submit();
   });
   $('#submit-email-cat').click(function(){
      $('#new-cat-form').submit();
   });
});

    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
<script>
    $(document).on('click', '.toggle-password', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    
    var input = $("#pass_log_id");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>



@php
   include(public_path('themes/theme6/views/footer.blade.php'));
@endphp