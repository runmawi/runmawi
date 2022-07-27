
@php
include(public_path('themes/default/views/header.php'));
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
       
         <div class="sign-user_card">
        <div class="row align-items-center">
           
            <div class="col-lg-4 mb-3 bdr">
                <h3>Account Setting</h3>
                <div class="mt-5 text-white p-0">
                    <ul class="usk" style="margin-left: -45px;">
                      <!--  <li><a class="showSingle" target="1">User Settings</a></li>-->
                          <!-- <li><a class="showSingle" target="2">Transaction details</a></li>-->
                         <!--  <li><a class="showSingle" target="3">Plan details</a></li>-->
                        <li><a class="showSingle" target="1">Manage Profile</a></li>
                        <li><a class="showSingle" target="2">Plan details</a></li>
                        <li><a class="showSingle" target="5">Preference for videos</a></li>
                        <li><a class="showSingle" target="6">Profile</a></li>
                        <li><a class="showSingle" target="7">Recently Viewd Items</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 mb-3">
                <div class="targetDiv" id="div1">
                <div class=" d-flex justify-content-between mb-3">
                    <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/>
                    <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
                    <a href="#updatepic" class="edit-icon text-primary">Edit</a></div>
                     <div class=""> <!--style="margin-left: 66%;margin-right: 13%;padding-left: 1%;padding-bottom: 0%;"-->
                <div class="" id="personal_det">
                <div class="" >
                    <div class="d-flex align-items-baseline justify-content-between">
                    <div><h5 class="mb-2 pb-3 ">Personal Details</h5></div>
                    <div><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Change</a>
                        </div></div>
                    </div>
                    <div class="a-border"></div>
                   <div class="a-border"></div>
                      <div class="row jusitfy-content-center">
                        <div class="col-md-3 mt-3">
                            <h5>Account Details</h5>
                          </div>
                        <div class="col-md-9">
                             <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">Email</span>
                            <p class="mb-0"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></p>
                        </div>   
                    </div>
                    <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">Username</span>
                            <p class="mb-0"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></p>
                        </div>   
                    </div>
                    <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">Password</span>
                            <p class="mb-0"></p>
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
                            <span class="text-light font-size-13">Phone</span>
                            <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></p>
                        </div>
                    </div> 
                    <div class="row align-items-center justify-content-end">
                        <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                            <span class="text-light font-size-13">DOB</span>
                            <p class="mb-0"><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></p>
                              
                        </div>
                    </div>
                  
                        </div>
                    </div>
                   
                        </div>
                          <div class="a-border"></div>
                         
                          <div class="mt-3 row align-items-center">
                              <div class="col-md-3"> <h5 class="card-title mb-2">Update Profile</h5></div>
                              <div class="col-md-9"> <!-- <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data"> -->
                    <form action="{{ URL::to('admin/profileupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                    <input type="file" multiple="true" class="form-control editbtn mt-3" name="avatar" id="avatar" />
                    <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" /> -->    
                            </div>
                            <div class="col-sm-6">
                                 <button type="submit" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile " style="display: none;"> Verify Profile</button>
                    <button class="btn btn-primary noborder-radius btn-login nomargin editbtn " type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>     
                            </div>
                        </div>
                                  
                    </form>	</div>
                              <div class="col-md-3"></div></div>
                   
                      
                </div>
                    <!-- Add New Modal -->
<div class="modal fade" id="add-new">
  <div class="modal-dialog">
     <div class="modal-content">
        
        <div class="modal-header">
                <h4 class="modal-title">Update Profile</h4>
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           
        </div>
        
        <div class="modal-body">
           <form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}" method="post">
              <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
              <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                            
                  <div class="form-group">
                          <label> Username:</label>
                          <input type="text" id="username" name="username" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" class="form-control" placeholder="username">
                        </div>
                    
                        <div class="form-group">
                          <label> Email:</label>
                          <input type="email" id="email" name="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" class="form-control" placeholder="Email">
                        </div> 
                    
                    
                        <div class="form-group">
                          <label>Password:</label><br>
                          <input type="password"  name="password"   placeholder="Password"  class="form-control"  >
                      </div> 
                    
                    
                        <div class="form-group">
                           <label> Phone:</label>
                           <input type="number" id="mobile" name="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" class="form-control" placeholder="Mobile Number">
                        </div>
                        <div class="form-group">
                        <label> DOB:</label>
                        <input type="date" id="DOB" name="DOB" value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                           <!-- <input type="text" id="DOB" name="DOB" value="" class="form-control" placeholder="DOB"> -->
                        </div>

            </form>
        </div>
        
        <div class="modal-footer">
           <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
        </div>
     </div>
  </div>
</div>
                    </div>

         
                <div class="col-sm-12 text-center targetDiv" id="div2">
                    <div class="d-flex justify-content-center">  <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/></div>
                    
                    <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
                      <h4 class="mb-3"><?php if(!empty($user->role)): ?><?= $user->role ?><?php endif; ?> as on <?php if(!empty($user->created_at)): ?><?= $user->created_at ?><?php endif; ?></h4>
                      <h4 class="mb-3"></h4>
                    
      <div class="text-center">
                   <?php  if($user_role == 'registered'){ ?>
                          <h6><?php echo 'Registered'." " .'(Free)'; ?> Subscription</h6>                                       
                          <h6></h6>                                       
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
                         
                         <!-- -->
                <div class="row align-items-center justify-content-center mb-3 mt-3">
                     <div class=" text-center colsm-4 ">
            <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >View Transaction Details</a>
        </div>
                        
                        <div class="col-sm-4 text-center">
                           @if(Auth::user()->role == "subscriber")
                              <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >Upgrade Plan </a>        
                           
                           @elseif( Auth::user()->role == "admin")

                           @else
                                 <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                           @endif
                        </div>
                    </div>
    </div>
                
                <div class="targetDiv" id="div3">
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
                <div class="targetDiv" id="div4">
                 <div class="mb-3" id="updatepic">
               
            </div>
                </div>
                <div class="targetDiv" id="div5">
                    <div class=" mb-3">
                  <h4 class="card-title mb-0">Preference for videos</h4>
                  <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                  @csrf
                  <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                  <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>Preference Language</h5></label>
                    <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                        @foreach($preference_languages as $preference_language)
                            <option value="{{ $preference_language->id }}" >{{$preference_language->name}}</option>
                        @endforeach
                    </select>
                 </div>

                 <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>Preference Genres</h5></label>
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
           <h4 class="card-title mb-0 manage"> Profile</h4>
              <div class="col-md-12 profile_image">
                  @forelse  ($profile_details as $profile)
                    <div class="">
                             <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                            
                             <h2 class="name">{{ $profile ? $profile->user_name : ''  }}</h2>
                         <div class="circle">
                                <a  href="{{ URL::to('profileDetails_edit', $profile->id)}}">
                                       <i class="fa fa-pencil"></i> </a>
                                @if($Multiuser == null)
                                 <a  href="{{ URL::to('profile_delete', $profile->id)}}" onclick="return confirm('Are you sure to delete this Profile?')" >
                                   <i class="fa fa-trash"></i> </a> 
                                @endif
                             </div>
                    </div>
                  @empty
                    <div class="col-sm-6">  <p class="name">No Profile</p>  </div>
                  @endforelse
              </div>    
          </div> </div>
                <div class="targetDiv" id="div7">
                    <div class="iq-card" id="recentviews" style="background-color:#191919;">
                 <div class="iq-card-header d-flex justify-content-between" >
                    <div class="iq-header-title">
                       <h4 class="card-title">Recently Viewd Items</h4>
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
                                <th style="width:10%;">Views</th>
                               <!-- <th style="width:10%;">User</th>-->
                                 <th style="width:20%;">Date</th> 
                                <th style="width:10%;"><i class="lar la-heart"></i></th>
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
            

<!--
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-8">
                            <span class="text-light font-size-13">Language</span>
                            <p class="mb-0">English</p>
                        </div>
                    </div>
                    <h5 class="mb-3 mt-4 pb-3 a-border">Billing Details</h5>
                    <div class="row justify-content-between mb-3">
                        <div class="col-md-8 r-mb-15">
                            <p>Your next billing date is 19 September 2020.</p>
                            <a href="#" class="btn btn-hover">Cancel Membership</a>
                        </div>
                        <div class="col-md-4 text-md-right text-left">
                            <a href="#" class="text-primary">Update Payment info</a>
                        </div>
                    </div>
                    <h5 class="mb-3 mt-4 pb-3 a-border">Plan Details</h5>
                    <div class="row justify-content-between mb-3">
                        <div class="col-md-8">
                            <p>Premium</p>                                
                        </div>
                        <div class="col-md-4 text-md-right text-left">
                            <a href="pricing-plan.html" class="text-primary">Change Plan</a>
                        </div>
                    </div>
-->
<!--
                    <h5 class="mb-3 pb-3 mt-4 a-border">Setting</h5>
                    <div class="row">
                        <div class="col-12 setting">
                            <a href="#" class="text-body d-block mb-1">Recent device streaming activity</a>
                            <a href="#" class="text-body d-block mb-1">Sign out of all devices </a>
                            <a href="#" class="text-body d-block">Download your person information</a>
                        </div>                            
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="sign-user_card" style="height: 400px;">
                    <h4 class="card-title mb-0">Plan Details</h4>
                    <div class="row align-items-center justify-content-between mb-3 mt-3">
                        <div class="col-sm-4">
                   <?php  if($user_role == 'registered'){ ?>
                          <h6><?php echo 'Registered'." " .'(Free)'; ?></h6>                                       
                          <h6>Subscription</h6>                                       
                       <?php }elseif($user_role == 'subscriber'){ ?>
                          <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                          <br>       
                       <h5 class="card-title mb-0">Available Specification :</h5><br>
                       <h6> Video Quality : <p> <?php if($plans != null ) {  $plans->video_quality ; } else { ' ';} ?></p></h6>  
                       <h6> Video Resolution : <p> <?php if($plans != null ) {  $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                       <h6> Available Devices : <p> <?php if($plans != null ) {  $plans->devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                          <!--<h6>Subscription</h6>
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
            </div>
            <div class="col-lg-6 mb-3" id="updatepic">
                <div class="sign-user_card mb-3">
                    <h4 class="card-title mb-2">Manage Profile</h4>
                    <!-- <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data"> 
                    <form action="{{ URL::to('/profileupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                    <input type="file" multiple="true" class="form-control editbtn" name="avatar" id="avatar" />
                    <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" />  <button type="submit" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile " style="display: none;"> Verify Profile</button>
                    <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                    </form>		
                </div>
            </div>

  <!-- {{-- Preference for videos --}} 
            <div class="col-lg-6 mb-3" id="">
              <div class="sign-user_card mb-3">
                  <h4 class="card-title mb-0">Preference for videos</h4>
                  <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                  @csrf
                  <input type="hidden" name="user_id" value="<?= $user->id ?>" />

                  <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>Preference Language</h5></label>
                    <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                        {{-- @foreach($language as $preference_language)
                            <option value="{{ $preference_language->id }}" >{{$preference_language->name}}</option>
                        @endforeach --}}
                    </select>
                 </div>

                 <div class="col-sm-9 form-group p-0 mt-3">
                    <label><h5>Preference Genres</h5></label>
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

<!-- {{-- Multiuser Profile --}} 
     <div class="col-lg-6 mb-3" >
        <div class="sign-user_card mb-3">
           <h4 class="card-title mb-0 manage"> Profile</h4>
              <div class="col-md-12 profile_image">
                  @forelse  ($profile_details as $profile)
                    <div class="">
                             <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                            
                             <h2 class="name">{{ $profile ? $profile->user_name : ''  }}</h2>
                         <div class="circle">
                                <a  href="{{ URL::to('profileDetails_edit', $profile->id)}}">
                                       <i class="fa fa-pencil"></i> </a>
                                @if($Multiuser == null)
                                 <a  href="{{ URL::to('profile_delete', $profile->id)}}" onclick="return confirm('Are you sure to delete this Profile?')" >
                                   <i class="fa fa-trash"></i> </a> 
                                @endif
                             </div>
                    </div>
                  @empty
                    <div class="col-sm-6">  <p class="name">No Profile</p>  </div>
                  @endforelse
              </div>    
          </div> 
        </div>
     </div>
<!-- {{-- Multiuser Profile --}} 
        </div>
   </div>
    </div>
</section>

<div id="main-admin-content">
    <div id="content-page" class="content-page">
        <div class="container-fluid">  
<!--
      <div class="row">
            <div class="col-12 col-md-12 col-lg-6" >
       <div class="iq-card">
                <div class="row" id="card">
                <div class="col-md-12" >
              <div class="iq-card-header d-flex justify-content-between align-items-center mb-0 ">
                 <div class="iq-header-title">
                    <h4 class="card-title mb-0">Card Details</h4>
                 </div>
              </div> 
              <div class="iq-card-body">
                 <ul class="list-inline p-0 mb-0">
                    <li>
                       <div class="row align-items-center justify-content-between mb-3 mt-3">
                          <div class="col-sm-4">
                               Card1                                    
                          </div>
                          <div class="col-sm-4">
                               
                                                                    
                          </div>
                           <div class="col-sm-4">
                              <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >Transaction Details</a>								               
                          </div>
                       </div>
                    </li>
                 </ul>
              </div>
                </div>
                </div>
                </div></div>

      </div>


      <div class="row">
      <div class="col-md-12">
              <div class="iq-card" id="recentviews" style="background-color:#191919;">
                 <div class="iq-card-header d-flex justify-content-between" >
                    <div class="iq-header-title">
                       <h4 class="card-title">Recently Viewd Items</h4>
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
                                <th style="width:10%;">Views</th>
                               <!-- <th style="width:10%;">User</th>
                                 <th style="width:20%;">Date</th> 
                                <th style="width:10%;"><i class="lar la-heart"></i></th>
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
           </div></div>
   
          <div class="container data-mdb-smooth-scroll">
         <div class="row justify-content-center">	
          <div class="col-md-12">
            
        <div class="login-block nomargin">

         <!--<h4 class="my_profile">
            <i class="fa fa-edit"></i> 
            <?php echo __('Update Your Profile Info');?>
          </h4>-->

  <div class="clear"></div>   
  <form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
     <div class="well row">
        <!--<div class="col-sm-6 col-xs-12">
           <div class="row">
              <div class="col-sm-12 col-xs-12">
                 <label for="avatar">My Avatar - Elite_<?php echo $user->id;?></label>
                 <div id="user-badge">
                    <img src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>" />
                    <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
                 </div>	
              </div>
           </div>
        </div>-->
            <!--popup-->
            <div class="form-popup " id="myForm" style="background:url(<?php echo URL::to('/').'/assets/img/Landban.png';?>) no-repeat;	background-size: cover;padding:40px;display:none;">
            <div class="col-sm-4 details-back">
           <div class="row data-back">
              <div class="well-in col-sm-12 col-xs-12" >
                 <?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
                 <label for="username" class="lablecolor"><?=__('Username');?></label>
                 <input type="text" class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
              </div>
              <div class="well-in col-sm-12 col-xs-12">
                 <?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
                 <label for="email"><?=__('Email');?></label>
                 <input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
              </div>
              <div class="well-in col-sm-12 col-xs-12">
                 <?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
                 <label for="username" class="lablecolor"><?=__('Phone Number');?></label>
                 <div class="row">
                     <div class="col-sm-6 col-xs-12">
                        <select name="ccode" >
                          @foreach($jsondata as $code)
                          <option value="{{ $code['dial_code'] }}" <?php if($code['dial_code'] == $user->ccode ) { echo "selected='selected'"; } ?>> {{ $code['name'].' ('. $code['dial_code'] . ')' }}</option>
                          @endforeach
                       </select>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                       <input type="text" class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
                    </div>
                 </div>
              </div>
              <div class="well-in col-sm-12 col-xs-12">
                 <label for="password"><?=__('Password');?> (leave empty to keep your original password)</label>
                 <input type="password" class="form-control" name="password" id="password"  />
              </div>
              <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
              <div class="col-sm-12 col-xs-12 mt-3">
                 <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary" />
                         <button type="button" class="btn btn-primary" onclick="closeForm()">Close</button>
              </div>
           </div>
        </div>
            </div>
        
        
            <div class="row" id="subscribe">
<!--                    <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>-->
                 
              
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

@php
  include(public_path('themes/default/views/footer.blade.php'));
@endphp

      <!-- back-to-top End -->
 <!-- back-to-top End -->
  <!-- jQuery, Popper JS -->
  <script src="<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>
  <script src="<?= URL::to('/'). '/assets/js/popper.min.js';?>"></script>
  <!-- Bootstrap JS -->
  <script src="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>"></script>
  <!-- Slick JS -->
  <script src="<?= URL::to('/'). '/assets/js/slick.min.js';?>"></script>
  <!-- owl carousel Js -->
  <script src="<?= URL::to('/'). '/assets/js/owl.carousel.min.js';?>"></script>
  <!-- select2 Js -->
  <script src="<?= URL::to('/'). '/assets/js/select2.min.js';?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Magnific Popup-->
  <script src="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
  <!-- Slick Animation-->
  <script src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
  <!-- Custom JS-->
  <script src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>
   <script>
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
<!--<script>
// Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
$('.dropdown-menu a').click(function(e){
  e.preventDefault();
  if($(this).next('.submenu').length){
    $(this).next('.submenu').toggle();
  }
  $('.dropdown').on('hide.bs.dropdown', function () {
    $(this).find('.submenu').hide();
  }
                   )
}
                           );
}
</script>-->
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


</div>
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


<!-- Imported styles on this page -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.min.js';?>"></script>
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/popper.min.js';?>"></script>
<script src="<?= URL::to('/'). '/assets/admin/dashassets/css/bootstrap.min.css';?>"></script>
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.dataTables.min.js';?>"></script>
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/dataTables.bootstrap4.min.js';?>"></script>
<!-- Appear JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.appear.js';?>"></script>
<!-- Countdown JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/countdown.min.js';?>"></script>
<!-- Select2 JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/select2.min.js';?>"></script>
<!-- Counterup JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/waypoints.min.js';?>"></script>
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.counterup.min.js';?>"></script>
<!-- Wow JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/wow.min.js';?>"></script>
<!-- Slick JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/slick.min.js';?>"></script>
<!-- Owl Carousel JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/owl.carousel.min.js';?>"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/jquery.magnific-popup.min.js';?>"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/smooth-scrollbar.js';?>"></script>
<!-- apex Custom JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/apexcharts.js';?>"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/chart-custom.js';?>"></script>
<!-- Custom JavaScript -->
<script src="<?= URL::to('/'). '/assets/admin/dashassets/js/custom.js';?>"></script>
<!-- End Notifications -->

<!--@yield('javascript')-->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
console.log(chart_01_lable);
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
</script>


















