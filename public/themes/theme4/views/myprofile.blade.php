
@php
include(public_path('themes/theme4/views/header.php'));
$settings = App\Setting::first(); 
@endphp

<style>
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

  .sign-user_card input{
     background-color: rgb(255 255 255) !important;
  }

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
    .rounded-circle {
    height: 150px;
    width: 150px;
}
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
<section class="m-profile  setting-wrapper pt-0 p-3">        
    <div class="container">
       
                     {{-- message --}}
      @if (Session::has('message'))
         <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
      @endif

         <div class="sign-user_card">
        <div class="row align-items-center">
            <div class="col-lg-4 mb-3 bdr">
                  <a class="" href="{{ URL::to('/home') }}"><button class='fas fa-arrow-alt-circle-left btn bd btn-action back'  style=''> {{ (__('Home')) }}</button></a>
                  <br><br>
                <h3>{{ (__('Account Settings')) }}</h3>
                <div class="mt-5 text-white p-0">
                    <ul class="usk" style="margin-left: -45px;">
                      <!--  <li><a class="showSingle" target="1">User Settings</a></li>-->
                          <!-- <li><a class="showSingle" target="2">Transaction details</a></li>-->
                         <!--  <li><a class="showSingle" target="3">Plan details</a></li>-->
                        <li><a class="showSingle" target="1">{{ (__('Manage Profile')) }}</a></li>
                        <li><a class="showSingle" target="2">{{ (__('Plan details')) }}</a></li>
                        <li><a class="showSingle" target="5">{{ (__('Preference for videos')) }}</a></li>
                        <li><a class="showSingle" target="6">{{ (__('Profile')) }}</a></li>
                        <li><a class="showSingle" target="7">{{ (__('Recently Viewed Items')) }}</a></li>
                        <li><a class="showSingle" target="8">{{ (__('Tv Activation Code')) }}</a></li>
                        <li><a class="showSingle" target="9">{{ (__('Tv Logged User List')) }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 mb-3">
                <div class="targetDiv" id="div1">
                <div class=" d-flex justify-content-between mb-3">
                <?php $data = Session::all(); if($user->provider != 'facebook' || $user->provider != 'google'){ ?> 
                    <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/>
                    <?php }else{ ?> 
                    <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?=  $user->provider_avatar; ?>"  alt="profile-bg"/>
                     <?php } ?>
                    <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
                   </div>
                     <div class=""> <!--style="margin-left: 66%;margin-right: 13%;padding-left: 1%;padding-bottom: 0%;"-->
                <div class="" id="personal_det">
                <div class="" >
                    <div class="d-flex align-items-baseline justify-content-between">
                    <div><h5 class="mb-2 pb-3 ">{{ __('Personal Details') }}</h5></div>
                    <div><a href="javascript:;" onclick="jQuery('#add-profile').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {{ __('Change') }}</a>
                        </div></div>
                    </div>
                    <div class="a-border"></div>
                   <div class="a-border"></div>
                      <div class="row jusitfy-content-center">
                        <div class="col-md-3 mt-3">
                            <h5>{{ __('Account Details') }}</h5>
                          </div>
                        <div class="col-md-9">
                             <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">{{ __('Email') }}</span>
                            <p class="mb-0"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></p>
                        </div>   
                    </div>
                    <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">{{ __('Username') }}</span>
                            <p class="mb-0"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></p>
                        </div>   
                    </div>
                    <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">{{ __('Password') }}</span>
                            <p class="mb-0">***********</p>
                        </div>
                    </div>
                    
                  
                       
                   
                          </div>
                    </div>
                      <div class="a-border"></div>
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                             <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-2 mb-2">
                            <span class="text-light font-size-13">{{ __('Phone') }}</span>
                            <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></p>
                        </div>
                    </div> 
                    <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">{{ __('DOB') }}</span>
                            <p class="mb-0"><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></p>
                              
                        </div>
                    </div>
                  
                        </div>
                    </div>
                   
                        </div>
                          <div class="a-border"></div>
                         
                          <div class="mt-3 row align-items-center">
                              <div class="col-md-3"> <h5 class="card-title mb-2">{{ __('Update Profile') }}</h5></div>
                              <div class="col-md-9"> 
                    <form action="{{ URL::to('/profileupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                    <input type="file" multiple="true" class="form-control editbtn mt-3" name="avatar" id="avatar" />
                    <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" /> -->    
                            </div>
                            <div class="col-sm-6">
                                 <button type="submit" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile " style="display: none;">{{ __('Verify Profile') }} </button>
                    <button class="btn btn-primary noborder-radius btn-login nomargin editbtn " type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>     
                            </div>
                        </div>
                                  
                    </form>	</div>
                              <div class="col-md-3"></div></div>
                   
                      
                </div>
                    <!-- Add New Modal -->
<div class="modal fade" id="add-profile">
  <div class="modal-dialog">
     <div class="modal-content">
        
        <div class="modal-header">
                <h4 class="modal-title text-black">{{ __('Update Profile') }}</h4>
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           
        </div>
        
        <div class="modal-body">
           <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}" method="post">
              <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
              <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                            
                  <div class="form-group">
                          <label>{{ __('Username') }} :</label>
                          <input type="text" id="username" name="username" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" class="form-control" placeholder="username">
                        </div>
                    
                        <div class="form-group">
                          <label>{{ __('Email') }} :</label>
                          <input type="email" readonly id="email" name="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" class="form-control" placeholder="{{ __('Email') }}">
                        </div> 
                    
                    
                        <div class="form-group position-relative">
                          <label>{{ __('Password') }}:</label><br>
                          <input type="password" id="pass_log_id"  name="password"   placeholder="{{ __('Password') }}"  class="form-control"  >
                            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>

                      </div> 
                    
                    
                        <div class="form-group">
                           <label> {{ __('Phone') }}:</label>
                           <input type="number" id="mobile" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==10) return false;" name="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" class="form-control" placeholder="{{ __('Mobile Number') }}">
                        </div>
                        <div class="form-group">
                        <label>{{ __('DOB') }} :</label>
                        <input type="date" id="DOB" name="DOB" value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                           <!-- <input type="text" id="DOB" name="DOB" value="" class="form-control" placeholder="DOB"> -->
                        </div>

            </form>
        </div>
        
        <div class="modal-footer">
           <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
           <button type="button" class="btn btn-primary" id="submit-new-cat">{{ __('Save changes') }}</button>
        </div>
     </div>
  </div>
</div>
                    </div>

         
                <div class="col-sm-12 text-center targetDiv" id="div2">
                <?php $data = Session::all(); if($user->provider != 'facebook' || $user->provider != 'google'){ ?> 
                        <div class="d-flex justify-content-center">  <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/></div>
                        <?php }else{ ?> 
                        <div class="d-flex justify-content-center">  <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= $user->provider_avatar; ?>"  alt="profile-bg"/></div>
                           <?php } ?>
                    <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
                      <h4 class="mb-3"><?php if(!empty($user->role)): ?><?= $user->role ?><?php endif; ?> as on <?php if(!empty($user->created_at)): ?><?= $user->created_at ?><?php endif; ?></h4>
                      <h4 class="mb-3"></h4>
                    
      <div class="text-center">
                   <?php  if($user_role == 'registered'){ ?>
                          <h6><?php echo 'Registered'." " .'(Free)'; ?> {{ __('Subscription') }}</h6>                                       
                          <h6></h6>                                       
                       <?php }elseif($user_role == 'subscriber'){ ?>
                          <h6><?php echo $role_plan." " .'__(Paid User)'; ?></h6>
                          <br>       
                       <h5 class="card-title mb-0">{{ __('Available Specification') }} :</h5><br>
                       <h6> {{ __('Video Quality') }} : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->video_quality ; } else { ' ';} ?></p></h6>  
                       <h6> {{ __('Video Resolution') }} : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                       <h6> {{ __('Available Devices') }} : <p> <?php if($plans != null || !empty($plans) ) {  echo $devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                          <!--<h6>Subscription</h6>-->
                       <?php } ?>
                       </div>
                         
                         <!-- -->
                  <div class="row align-items-center justify-content-center mb-3 mt-3">
                     <div class=" text-center col-sm-4 ">
                        <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >{{ __('View Transaction Details') }}</a>
                     </div>

                        
                        <div class="col-sm-4 text-center">
                           @if(Auth::user()->role == "subscriber")
                              <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >{{ __('Upgrade Plan') }} </a>        
                           
                           @elseif( Auth::user()->role == "admin")

                           @else
                                 <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" >{{ __('Become Subscriber') }} </a>
                           @endif
                        </div>

                        @if(Auth::user()->role == "subscriber" && Auth::user()->payment_status != "Cancel")
                              <a  href="{{ URL::to('/cancelSubscription') }}" class="btn btn-primary editbtn" >{{ __('Cancel Membership') }}</a>
                        @endif

                        @if ( $payment_package != null  && $payment_package->payment_gateway == "Paystack")
                              <a href="{{ route('Paystack_Subscription_cancel', [ 'subscription_id' => $payment_package->stripe_id ]) }}" class="btn btn-primary btn-login nomargin noborder-radius" > {{ __('Cancel Membership') }} </a>
                        @endif

                    </div>
                  </div>
                
                <div class="targetDiv" id="div3">
                    <div class="row align-items-center justify-content-between mb-3 mt-3">
                        <div class="col-sm-4">
                   <?php  if($user_role == 'registered'){ ?>
                          <h6><?php echo 'Registered'." " .'(Free)'; ?></h6>                                       
                          <h6>{{ __('Subscription') }}</h6>                                       
                       <?php }elseif($user_role == 'subscriber'){ ?>
                          <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                          <br>       
                       <h5 class="card-title mb-0">{{ __('Available Specification') }} :</h5><br>
                       <h6> {{ __('Video Quality') }} : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->video_quality ; } else { ' ';} ?></p></h6>  
                       <h6> {{ __('Video Resolution') }} : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                       <h6> {{ __('Available Devices') }} : <p> <?php if($plans != null || !empty($plans) ) {  echo $devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                          <!--<h6>Subscription</h6>-->
                       <?php } ?>
                       </div>
                        <div class="col-sm-6">
                           <?php if(Auth::user()->role == "subscriber"){ ?>
                            <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >{{ __('Upgrade Plan') }} </a>        
                            <?php }else{ ?>
                    <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > {{ __('Become Subscriber') }}</a>
                    <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="targetDiv" id="div4">
                 <div class="mb-3" id="updatepic">
               
            </div>
                </div>
                <div class="targetDiv" id="div5">
                    <div class=" mb-3">
                  <h4 class="card-title mb-0">{{ __('Preference for videos') }}</h4>
                  <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                  @csrf
                  <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                  <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>{{ __('Preference Language') }}</h5></label>
                    <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                        @foreach($preference_languages as $preference_language)
                            <option value="{{ $preference_language->id }}" >{{$preference_language->name}}</option>
                        @endforeach
                    </select>
                 </div>

                 <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>{{ __('Preference Genres') }}</h5></label>
                    <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                        @foreach($videocategory as $preference_genres)
                            <option value="{{ $preference_genres->id }}" >{{$preference_genres->name}}</option>
                        @endforeach
                    </select>
                 </div>

                  <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                  </form>		
              </div>
                </div>
                <div class="targetDiv" id="div6"><div class=" mb-3">
           <h4 class="card-title mb-0 manage">{{ __('Profile') }} </h4>
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
                        <p class="name">{{ __('No Profile') }}  </p>  </div>
                  @endforelse

                  <div class="col-md-6" style="margin-top: 63px;">
                     <li> <a class="fa fa-plus-circle fa-100x" style="color: white !important; " href="{{ route('Multi-profile-create') }}" ></a> </li>
                  </div>

              </div>    
          </div> </div>
                <div class="targetDiv" id="div7">
                    <div class="iq-card" id="recentviews" style="background-color:#191919;">
                 <div class="iq-card-header d-flex justify-content-between" >
                    <div class="iq-header-title">
                       <h4 class="card-title">{{ __('Recently Viewed Items') }}</h4>
                    </div>
                    
                 </div>
                  <div class="iq-card-body">
                    <div class="table-responsive " >
                       <table class="data-tables table movie_table recent_table" style="width:100%">
                          <thead>
                             <tr>
                                <th style="width:20%;">{{ __('Video') }}</th>
                                <th style="width:10%;">{{ __('Rating') }}</th>
                                <th style="width:20%;">{{ __('Category') }}</th>
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
                 <div class="targetDiv" id="div8">
                  
                          <p class="text-white">{{ __('Enter Tv Activation Code') }}</p>
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
                                             <a type="button" href="{{ URL::to('user/tv-code/remove/') }}/{{$UserTVLoginCode->id}}" style="z-index:999; position: absolute; background-color:#df1a10!important;" class="btn round tv-code-remove text-red">{{ __('Remove') }}</a>
                                       @else
                                       <a type="button" id='tvCode' style='z-index:999; position: absolute;' class="btn round tv-code text-white">{{ __('Add') }}</a>
                                       @endif
                                          </div>
                                       </div>
                           </form>
                  </div>
                  <div class="targetDiv" id="div9">
                  
                  <p class="text-white">{{ __('Tv Logged User List') }}</p>
       
                               <div class="col-md-4">

                               <table class="table  artists-table iq-card text-center p-0">
                                          <tr class="r1">
                                             <th><label> {{ __('S.No') }} </label></th>
                                             <th><label> {{ __('Email') }} </label></th>
                                             <th><label> {{ __('TV Code') }} </label></th>
                                             <th><label> {{ __('Action') }} </label></th>
                                             
                                             @foreach($LoggedusersCode as $key=>$Logged_usersCode)
                                             <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td valign="bottom"><p> {{ $Logged_usersCode->email  }} </p></td>
                                                <td valign="bottom"><p> {{ $Logged_usersCode->tv_code  }} </p></td>
                                                <td>
                                                   <p class=" align-items-center list-user-action">
                                                      <a type="button" href="{{ URL::to('user/tv-code/remove/') }}/{{$Logged_usersCode->id}}" style="z-index:999; position: absolute; background-color:#df1a10!important;" class="btn round tv-code-remove text-red">Remove</a>
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
border: 1px solid transparent;
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
include(public_path('themes/theme4/views/footer.blade.php'));
@endphp