<!doctype html>
<html lang="en-US">
   <head>

      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
// dd(Auth::User()->id);

 ?>
   @php
   include(public_path('themes/theme1/views/header.php'));
   $settings = App\Setting::first(); 
@endphp


   <body>
      <!-- loader Start -->
     <!-- <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
      <!-- loader END -->
     <!-- Header -->
     
   
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
                                    <h5 class="mb-0 text-white line-height">{{ __('Hello Barry Tech') }}</h5>
                                    <span class="text-white font-size-12">{{ __('Available') }}</span>
                                 </div>
                                 <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-primary">
                                          <i class="ri-file-user-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">{{ __('My Profile') }}</h6>
                                          <p class="mb-0 font-size-12">{{ __('View personal profile details') }}.</p>
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
                                          <p class="mb-0 font-size-12">{{ __('Modify your personal details') }}.</p>
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
                                          <p class="mb-0 font-size-12">{{ __('Manage your account parameters') }}.</p>
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
                                          <p class="mb-0 font-size-12">{{ __('Control your privacy parameters') }}.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <div class="d-inline-block w-100 text-center p-3">
                                    <a class="bg-primary iq-sign-btn" href="#" role="button">{{ __('Sign out') }}<i class="ri-login-box-line ml-2"></i></a>
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
         <!--   <div class="sign-user_card">-->
                <div class="row justify-content-center">
                          

                  <div class="col-md-4">
                     {{-- message --}}

                     @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                  @endif
                        <h2 class="text-center">{{ __('My Account') }}</h2>
                       
                         <div class="row mt-5 align-items-center justify-content-between">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Email') }}</span>
                                 <div class="p-0">
                                    <span class="text-light font-size-13"> {{ $user->email ? $user->email : " "   }}</span></div>
                              </div>
                              <!-- <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#update_userEmails">Change</a>
                              </div> -->
                           </div>

                           <form id="update_userEmail" accept-charset="UTF-8" action="{{ URL::to('/profile/update_userEmail') }}" method="post">
                              @csrf

                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <span id="update_userEmails" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="text"  name="user_email" class="form-control">
                                          </div>
                                       <div class="col-md-4">
                                             <a type="button" class="btn round update_userEmail">{{ __('Update') }}</a></div>
                                       </div>
                              </span>
                           </form>


                        <hr style="border:0.5px solid #fff;">
                        <div class="row align-items-center">
                            <div class="col-md-5 mt-3">
                                <span class="text-light font-size-13">{{ __('Password') }}</span>
                                <div class="p-0 mt-2">
                                       <span class="text-light font-size-13">*********</span>
                                </div>
                           </div>
                            <div class="col-md-7 mt-2 text-right" style="font-size:14px;">
                                <a href="{{ URL::to('/password/reset') }}" class="f-link text-white font-size-13">{{ __('Send Reset Password Email') }}</a>
                            </div>
                            </div>
                          <hr style="border:0.5px solid #fff;">
                           <div class="row align-items-center">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Display Name') }}</span>
                                 <div class="p-0">
                                    <span class="text-light font-size-13"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span></div>
                              </div>
                              <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#demo">Change</a>
                                 
                              </div>
                           </div>
                           <form id="update_username" accept-charset="UTF-8" action="{{ URL::to('/profile/update_username') }}" method="post">
                              @csrf

                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <span id="demo" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="text"  name="user_name" class="form-control">
                                          </div>
                                       <div class="col-md-4">
                                             <a type="button" class="btn btn-primary text-light round update_username">{{ __('Update') }}</a></div>
                                       </div>
                              </span>
                           </form>

                           {{-- Display Image --}}
                           <hr style="border:0.5px solid #fff;">

                           <div class="row align-items-center">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Display Image') }}</span>
                                 <div class="p-0">
                                    <span class="text-light font-size-13">
                                       @if( $user->avatar != null ) 
                                          <img src="{{ URL::to('public/uploads/avatars/'.$user->avatar)  }}" height="50px" width="50px" />
                                       @endif
                                    </span>
                                 </div>
                              </div>
                              <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#user_img">Change</a>
                              </div>
                           </div>

                           <form id="update_userimg" accept-charset="UTF-8" action="{{ URL::to('profile/update_userImage') }}"   enctype="multipart/form-data" method="post">
                              @csrf
                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <span id="user_img" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" required/>
                                          </div>
                                       <div class="col-md-4 d-flex align-items-center">
                                             <a type="button" class="btn btn-primary text-white round update_userimg">{{ __('Update') }}</a></div>
                                       </div>
                              </span>
                           </form>
                           {{-- TV Code --}}
                           <hr style="border:0.5px solid #fff;">

                           <div class="row align-items-center">
                              <div class="col-md-8">
                                 <span class="text-light font-size-13">{{ __('Tv Activation Code') }}</span>
                              </div>
                              <div class="col-md-4 text-right">
                                    <a type="button" class="text-white font-size-13" data-toggle="collapse" data-target="#user_tvcode">{{ __('Add') }}</a>
                              </div>
                           </div>

                           
                           <form id="tv-code" accept-charset="UTF-8" action="{{ URL::to('user/tv-code') }}"   enctype="multipart/form-data" method="post">
                              @csrf
                              <input type="hidden" name="users_id" value="{{ $user->id }}" />
                              <input type="hidden" name="email" value="{{ $user->email }}" />
                              <span id="user_tvcode" class="collapse">
                                       <div class="row mt-3">
                                          <div class="col-md-8">
                                                <input type="text" name="tv_code" id="tv_code" value="@if(!empty($UserTVLoginCode->tv_code)){{ $UserTVLoginCode->tv_code }}@endif" />
                                          </div>
                                       <div class="col-md-4">
                                       @if(!empty($UserTVLoginCode->tv_code))
                                             <a type="button" href="{{ URL::to('user/tv-code/remove/') }}/{{$UserTVLoginCode->id}}" style="background-color:#df1a10!important;" class="btn round tv-code-remove text-red">{{ __('Remove') }}</a>
                                       @else
                                       <a type="button"  class="btn round tv-code text-white">{{ __('Add') }}</a>
                                       @endif
                                          </div>
                                       </div>
                              </span>
                           </form>
                          <hr style="border:0.5px solid #fff;">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <span class="text-light font-size-13">{{ __('Membership Settings') }}</span>

                              <div class="p-0">
                                 <span class="text-light font-size-13">
                                       {{ ucwords('Current Membership -'.' '.$user->role) }}
                                    </span><br>

                                    @if(Auth::user()->role == "subscriber" )
                                    <span class="text-light font-size-13">
                                          @if( $user->subscription_ends_at != null && !empty($user->subscription_ends_at) )
                                             {{   "your subscription renew on ". ($user->subscription_ends_at)->format('d-m-Y') }}
                                          @endif
                                       </span>
                                    @endif
                                   
                              </div>
                              
                            </div>

                              <div class="col-md-4 text-right">
                                    @if( (Auth::user()->role == "subscriber" ) )
                                       {{-- <a href=" {{ URL::to('/upgrade-subscription_plan') }} class="text-white font-size-13">{{ __('Update Payment') }} </a> --}}
                                    @elseif( (Auth::user()->role == "admin" ) )

                                    @else
                                       <a href="<?=URL::to('/becomesubscriber');?>"  class="text-white font-size-13"> {{ __('Purchase Subscription') }}</a>
                                    @endif
                              </div>
                        </div>
                         <hr style="border:0.5px solid #fff;">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a  href="{{ URL::to('logout') }}" type="button" class="btn btn-primary text-light round">{{ __('Logout') }}</a>
                            </div>

                            @if(Auth::user()->role == "subscriber" && Auth::user()->payment_status != "Cancel")
                              <div class="col-md-6 text-right">
                                    <a  href="{{ URL::to('/cancelSubscription') }}" class="text-white font-size-13" >{{ __('Cancel Membership') }}</a>
                              </div>
                            @endif
                            
                        </div>
                        </div>
                    </div>
                </div>
          
           <!-- <div class="row ">
               
                <div class="col-lg-4 mb-3 bdr">
                    <h3>Account Setting</h3>
                    <div class="mt-5 text-white p-0">
                        <ul class="usk" style="margin-left: -45px;">
                          <!--  <li><a class="showSingle" target="1">User Settings</a></li>-->
                              <!-- <li><a class="showSingle" target="2">Transaction details</a></li>-->
                             <!--  <li><a class="showSingle" target="3">Plan details</a></li>
                            <li><a class="showSingle" target="1">Manage Profile</a></li>
                            <li><a class="showSingle" target="2">Plan details</a></li>
                            <li><a class="showSingle" target="5">Preference for videos</a></li>
                           <!-- <li><a class="showSingle" target="6">Profile</a></li>
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
                         <div class=""> <!--style="margin-left: 66%;margin-right: 13%;padding-left: 1%;padding-bottom: 0%;"
                    <div class="" id="personal_det">
                    <div class="" >
                        <div class="d-flex align-items-baseline justify-content-between">
                        <div><h5 class="mb-2 pb-3 ">Personal Details</h5></div>
                        <div><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary text-white"><i class="fa fa-plus-circle"></i> Change</a>
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
                                <span class="text-light font-size-13"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></span>
                            </div>   
                        </div>
                        <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                                <span class="text-light font-size-13">Username</span>
                                <span class="text-light font-size-13"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></span>
                            </div>   
                        </div>
                        <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                                <span class="text-light font-size-13">Password</span>
                                <span class="text-light font-size-13"></span>
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
                                <span class="text-light font-size-13"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></span>
                            </div>
                        </div> 
                        <div class="row align-items-center justify-content-end">
                            <div class="col-md-8 d-flex justify-content-between mt-1 mb-2">
                                <span class="text-light font-size-13">DOB</span>
                                <span class="text-light font-size-13"><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></span>
                                  
                            </div>
                        </div>
                      
                            </div>
                        </div>
                       
                            </div>
                              <div class="a-border"></div>
                             
                              <div class="mt-3 row align-items-center">
                                  <div class="col-md-3"> <h5 class="card-title mb-2">Update Profile</h5></div>
                                  <div class="col-md-9"> <!-- <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data"> 
                        <form action="{{ URL::to('admin/profileupdate') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                        <input type="file" multiple="true" class="form-control editbtn mt-3" name="avatar" id="avatar" />
                        <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" /> 
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
                    <h4 class="modal-title text-black">{{ __('Update Profile') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('/profile/update') }}" method="post">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<input type="hidden" name="user_id" value="<?= $user->id ?>" />
                                
						    <div class="form-group">
		                        <label> {{ __('Username') }}:</label>
		                        <input type="text" id="username" name="username" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" class="form-control" placeholder="{{ __('username') }}">
                            </div>
                        
                            <div class="form-group">
		                        <label> {{ __('Email') }}:</label>
		                        <input type="email" id="email" name="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" class="form-control" placeholder="{{ __('Email') }}">
                            </div> 
                        
                        
                            <div class="form-group">
		                        <label>{{ __('Password') }}:</label><br>
		                        <input type="password"  name="password"   placeholder="{{ __('Password') }}"  class="form-control"  >
		                    </div> 
                        
                           {{--                         
                              <div class="form-group">
                                 <label> {{ __('Phone') }}:</label>
                                 <input type="number" id="mobile" name="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" class="form-control" placeholder="{{ __('Mobile Number') }}">
                              </div>
                             --}}

                            <div class="form-group">
                              <label>{{ __('DOB') }} :</label>
                               <input type="date" id="DOB" name="DOB" class="form-control"   value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                            </div>

				    </form>
				</div>
				
				<div class="modal-footer">
					{{-- <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button> --}}
					<button type="button" class="btn btn-primary" id="submit-new-cat">{{ __('Save changes') }}</button>
				</div>
			</div>
		</div>
	</div>
                        </div>

             
                    <div class="col-sm-12 mt-4 text-center targetDiv" id="div2">
                        <div class="d-flex justify-content-center">  <img class="rounded-circle img-fluid d-block  mb-3" height="100" width="100" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/></div>
                        
                        <h4 class="mb-3"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></h4>
                          <h4 class="mb-3"><?php if(!empty($user->role)): ?><?= $user->role ?><?php endif; ?> as on <?php if(!empty($user->created_at)): ?><?= $user->created_at ?><?php endif; ?></h4>
                          <h4 class="mb-3"></h4>
                        
          <div class="text-center">
                       <?php  if($user_role == 'registered'){ ?>
                              <h6><?php echo 'Registered'." " .'(Free)'; ?> {{ __('Subscription') }}</h6>                                       
                              <h6></h6>                                       
                           <?php }elseif($user_role == 'subscriber'){ ?>
                              <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                              <br>       
                           <h5 class="card-title mb-0">{{ __('Available Specification') }} :</h5><br>
                           <h6>{{ __('Video Quality') }}  : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->video_quality ; } else { ' ';} ?></p></h6>  
                           <h6>{{ __('Video Resolution') }}  : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                           <h6> {{ __('Available Devices') }} : <p> <?php if($plans != null || !empty($plans) ) {  echo $devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
                              <!--<h6>Subscription</h6>-->
                           <?php } ?>
                           </div>
                             
                             <!-- -->
                    <div class="row align-items-center justify-content-center mb-3 mt-3">
                         <div class=" text-center colsm-4 ">
                <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >{{ __('View Transaction Details') }}</a>
            </div>
                            
                            <div class="col-sm-4 text-center">
                               <?php if(Auth::user()->role == "subscriber"){ ?>
                                <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >{{ __('Upgrade Plan') }} </a>        
                                <?php }else{ ?>
                        <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" >{{ __('Become Subscriber') }} </a>
                        <?php } ?>
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
                           <h5 class="card-title mb-0">{{ __('Available Specification') }} :</h5><br>
                           <h6> {{ __('Video Quality') }} : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->video_quality ; } else { ' ';} ?></p></h6>  
                           <h6>{{ __('Video Resolution') }}  : <p> <?php if($plans != null || !empty($plans)) {  echo $plans->resolution ; } else { ' ';} ?>  </p></h6>                               
                           <h6>{{ __('Available Devices') }}  : <p> <?php if($plans != null || !empty($plans) ) {  echo $devices_name ; } else { ' ';} ?> </p></h6>                                                                                                                   
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
                    <div class="targetDiv mt-5" id="div5">
                        <div class=" mb-3">
                      <h4 class="card-title mb-0">{{ __('Preference for videos') }}</h4>
                      <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                      @csrf
                      <input type="hidden" name="user_id" value="<?= $user->id ?>" />
   
                      <div class="col-sm-9 form-group p-0 mt-3">
                        <label><h5>{{ __('Preference Language') }}</h5></label>
                        <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach($preference_languages as $preference_language)
                                <option value="{{ $preference_language->id }}" >{{ __($preference_language->name) }}</option>
                            @endforeach
                        </select>
                     </div>
   
                     <div class="col-sm-9 form-group p-0 mt-3">
                        <label><h5>{{ __('Preference Genres') }}</h5></label>
                        <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach($videocategory as $preference_genres)
                                <option value="{{ $preference_genres->id }}" >{{ __($preference_genres->name)}}</option>
                            @endforeach
                        </select>
                     </div>
   
                      <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                      </form>		
                  </div>
                    </div>
                    <div class="targetDiv" id="div6"><div class=" mb-3">
               <h4 class="card-title mb-0 manage">{{ __('My Account') }} </h4>
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
                        <div class="col-sm-6">  <p class="name">{{ __('No Profile') }}</p>  </div>
                      @endforelse
                  </div>    
              </div> </div>
                    <div class="targetDiv" id="div7">
                        <div class="iq-card" id="recentviews" style="background-color:#191919;">
                     <div class="iq-card-header d-flex justify-content-between" >
                        <div class="iq-header-title">
                           <h4 class="card-title">{{ __('Recently Viewd Items') }}</h4>
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
                                    <th style="width:10%;">{{ __('Views') }}</th>
                                   <!-- <th style="width:10%;">User</th>-->
                                     <th style="width:20%;">{{ __('Date') }}</th> 
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
  /* .form-control {
    position: relative;
    font-size: 16px;
    width: 100%;
    height: 45px;
    border-radius: 4px;
   }*/
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
                        <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius text-white" > Become Subscriber</a>
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
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button> <strong>{{ __('Oh snap!') }}</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
							<label for="username" class="lablecolor"><?=__('Username');?></label>
							<input type="text" class="form-control" name="name" id="name" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button> <strong>{{ __('Oh snap!') }}</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
							<label for="email"><?=__('Email');?></label>
							<input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
						</div>
						<div class="well-in col-sm-12 col-xs-12">
							<?php if($errors->first('name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button> <strong>{{ __('Oh snap!') }}</strong> <?= $errors->first('name'); ?></div><?php endif; ?>
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
							<label for="password"><?=__('Password');?>{{ __('(leave empty to keep your original password)') }} </label>
							<input type="password" class="form-control" name="password" id="password"  />
						</div>
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<div class="col-sm-12 col-xs-12 mt-3">
							<input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary" />
                             <button type="button" class="btn btn-primary" onclick="closeForm()">{{ __('Close') }}</button>
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
@php
  include(public_path('themes/theme1/views/footer.blade.php'));
@endphp
</html>
	




	

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

<script>

      $(document).ready(function(){
         $(".update_username").click(function(){
            $('#update_username').submit();
         });

         $(".update_userimg").click(function(){
            $('#update_userimg').submit();
         });

         $(".update_userEmail").click(function(){
            $('#update_userEmail').submit();
         });

         $(".tv-code").click(function(){
            $('#tv-code').submit();
         });

      });

      
   $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
      
</script>
