@php
   include(public_path('themes/theme1/views/header.php'));
   $settings = App\Setting::first(); 
@endphp

    
    <style>
        svg{
            height: 30px;
        }
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
        .showSingle{
            cursor: pointer;
        }
        .red{
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
        ul{
            list-style: none;
        }
        .gk{
            background: #2a2a2c;
           
            border-bottom: 1px solid #fff;
        }
        .transpar{
            border:1px solid #ddd;
            background-color: transparent;
            padding: 10px 40px;
            color:#fff!important;
          
           
        }
        .sig{
            background: #161617;
mix-blend-mode: normal;
            padding: 50px;
            border-radius: 20px;
        } .sig1{
            background: #151516;
mix-blend-mode: normal;
            padding: 25px;
            border-radius: 20px;
        }
        .btn{
            
           padding: 15px 120px;
          color: #fff!important;
            
            border: 1px solid #fff;
            background-color: transparent;
        }
        .ply{
         background: #000;
            
            padding: 10px;
            border-radius: 50%;
        }
   img.multiuser_img {
    padding: 10px;
    border-radius: 50%;
}
        .bg-col p{
        font-family: Chivo;
font-style: normal;
font-weight: 400;
font-size: 26px;
line-height: 31px;
/* identical to box height */
padding-top:10px;
display: flex;
align-items: center;

color: #FFFFFF;
    }
        .container h1{
            padding-left: 10px;
        }
    .bg-col{
       background:rgb(32, 32, 32);

mix-blend-mode: color-dodge;
border-radius: 20px;
    padding: 10px;
    color: #fff;
        height: 150px;
        padding-left: 90px;
        
   
}
    .bl{
       background: #161617;
        padding: 10px;


    }

.name{
    font-size: larger;
    font-family: auto;
    color: white;
    text-align: center;
}
        .edit li{
            list-style: none;
            padding: 10px 10px;
            color: #fff;
            line-height: 31px;
        }
        .dl1{
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
        .dl{
            font-size: 16px;
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
                           <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-fluid avatar-40 rounded-circle" alt="user" >
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
		
		<!--<hr />-->
    
        <!-- MainContent -->
    <section  class="m-profile setting-wrapper pt-0">
        <div class="container">

                             {{-- message --}}
        @if (Session::has('message'))
            <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

            <div class="row sig ">
                <div class="col-md-4 mt-3 pt-3">
                    <h4 class="main-title mb-4">My Account</h4>
                    <p class="text-white">Edit your name or change<br>your password.</p>
                    <ul class="edit p-0 mt-5">
                        <li>
                            <div class="d-flex showSingle" target="1">
                                <a>
                            <img class="ply mr-3" src="<?php echo URL::to('/').'/assets/img/edit.png';  ?>"> 
                                    Edit Profile
                                </a>
</div>
                            </li>
                        <li><div class="d-flex showSingle" target="3">
                                <a>
                            <img class="ply mr-3" width="38" height="33" src="<?php echo URL::to('/').'/assets/img/kids.png';  ?>"> 
                                    Kids zone
                                </a>
                        </div></li>
                        <li><div class="d-flex showSingle" target="4">
                                <a>
                            <img class="ply mr-3" src="<?php echo URL::to('/').'/assets/img/video.png';  ?>"> 
                                   Video preferences
                                </a>
                     </div></li>
                        <li><div class="d-flex " target="#">
                        <?php if(Auth::User()->role == "registered"){ ?>
                           <a href="<?=URL::to('/becomesubscriber');?>">
                            <img class="ply mr-3" src="<?php echo URL::to('/').'/assets/img/plan.png';  ?>"> 
                                    Plan
                                </a>
                                <?php } ?></div></li>
                                <li><div class="d-flex showSingle" target="2">
                        <?php if(Auth::User()->role == "subscriber"){ ?>
                           <!-- <a href="<?=URL::to('/upgrade-subscription_plan');?>"> -->
                           <img class="ply mr-3" src="<?php echo URL::to('/').'/assets/img/plan.png';  ?>"> 
                            Plan
                                <!-- </a> -->
                                <?php } ?></div></li>
                    </ul>
                </div>
                
                <div class="col-md-8 targetDiv" id="div1">
                    
                    <div class="col-sm-3 d-flex  justify-content-end flex-column ">
                     <img class="rounded-circle img-fluid d-block ml-auto mb-3" src="<?= URL::to('/') . '/public/uploads/avatars/' . $user->avatar; ?>"  alt="profile-bg"/ style="" width="150">
                       <div class="d-flex justify-content-end">
                           <a href="<?php echo URL::to('logout') ?>" class="transpar">logout</a>
                   </div></div>
                   
                  
                    <div class=" mb-3" id="personal_det">
                    <div class="col-md-12 text-rigth mt-4" >
                        <div class="d-flex align-items-baseline justify-content-between">
                        <div><h5 class="mb-2 pb-3 ">Personal Details</h5></div>
                        <div><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="Text-white" style="color: #fff!important;"><i class="fa fa-plus-circle"></i> Edit</a>
                            </div></div>
                        </div>
                        <div class="a-border"></div>
                        <div class="row  text-right justify-content-between mt-3 mb-3">
                            <h4 class="p-3">Account Details</h4>
                            <div class="col-md-6 ">
                                <div class="d-flex justify-content-between mt-2">
                                <span class="text-light font-size-13">First Name</span>
                                <p class="mb-0">ALB</p></div>
                                <div class="d-flex justify-content-between mt-2">
                                <span class="text-light font-size-13">Last Name</span>
                                <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></p>
                            </div>
                                <div class="d-flex justify-content-between mt-2">
                                <span class="text-light font-size-13">Password</span>
                                    <p class="mb-0">**********</p></div>
                                <div class="d-flex justify-content-between mt-2">
                                <span class="text-light font-size-13">Username</span>
                                <p class="mb-0"><?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?></p>
                            </div> 
                                <div class="d-flex justify-content-between mt-2">
                                <span class="text-light font-size-13">Email</span>
                                <p class="mb-0"><?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?></p>
                            </div>   
                            </div>
                        </div> 
                          <hr style="color:#fff;">
                        <div class="row align-items-center text-right justify-content-between mt-3 mb-3">
                         <div class="col-md-6 d-flex justify-content-between mt-2">
                                <span class="text-light font-size-13">Phone</span>
                                <p class="mb-0"><?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?></p>
                            </div>
                        <div class="col-md-6 d-flex justify-content-between mt-2">
                                <span class="text-light font-size-13">Country</span>
                                <p class="mb-0">India</p>
                            </div>
                          
                        </div>
                <div class="row align-items-center text-right justify-content-between mt-3 mb-3">
                     <div class="col-md-6 d-flex justify-content-between mt-2">
                           <span class="text-light font-size-13">DOB</span>
                           <p class="mb-0"><?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?></p>
                        </div>
                </div>
                </div>
                </div>
                <hr style="color:#fff;">
                <div class="col-md-8 targetDiv" id="div2">
                    <div class="d-flex justify-content-around text-white">
                        <div class="d-felx text-center">
                        <p>Choose plan</p>
                        <input type="radio">
                            <ul>
                                <li class="btn_prd_up_22"></li>
                            </ul>
                        </div>
                        <div class="d-felx text-center">
                        <p>Make payment</p>
                            <input type="radio">
                             <ul>
                                <li class="btn_prd_up_33"></li>
                            </ul>
                        </div>
                        <div class="d-felx text-center">
                        <p>Confirmation</p>
                            <input type="radio"></div>
                    </div>
                <div class="col-md-12 mt-3">
                    <div class="bg-col">
                        <div class="container ">
                          
                        <p>Existing Plan : </p>

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
                              <!--<h6>Subscription</h6>-->
                           <?php } ?>

                        <!-- <h1><span class="dl">$</span>1197 <span>for 9 months</span></h1></div> -->
                        </div>
                        <br>       

                    <a href="<?=URL::to('/upgrade-subscription_plan');?>" class="btn btn-primary editbtn" >Upgrade Plan </a>        
                    <br>       
                        
                    </div>
                
                 <!-- <div class="col-md-12 mt-3">
                    <div class="bg-col">
                       <div class="container ">
                           
                        <p>SAVE $300</p>
                        <h1><span class="dl">$</span>894 <span class="dl1">for 6 months</span></h1></div> </div>
                      
                    </div>
            
                 <div class="col-md-12 mt-3">
                    <div class="bg-col">
                       <div class="container ">
                           
                                
                        <p>SAVE $99</p>
                        <h1><span class="dl">$</span>498 <span class="dl1">for 3 months</span></h1></div></div>
                        
                    </div>
           
                 <div class="col-md-12 mt-3">
                    <div class="bg-col">
                        <div class="container ">
                          
                        <p></p>
                                <h1><span class="dl">$</span>198 <span class="dl1">for 1 months</span></h1></div></div>-->
                        
                    </div>
                </div> 
                 <div class="col-md-8 targetDiv" id="div3">
                <div class="col-md-12 mt-3">
                    <div class="bg-col" onclick="jQuery('#add-new').modal('show');" >
                        <div class="container ">
                          
                        <p>SAVE $ 594</p>
                        <h1><span class="dl">$</span>1197 <span>for 9 months</span></h1></div>
                        </div>
                        
                    </div>
                
                 <div class="col-md-12 mt-3">
                    <div class="bg-col">
                       <div class="container ">
                           
                        <p>SAVE $ 300</p>
                        <h1><span class="dl">$</span>894 <span>for 6 months</span></h1></div> </div>
                      
                    </div>
            
                 <div class="col-md-12 mt-3">
                    <div class="bg-col">
                       <div class="container ">
                           
                                
                        <p>SAVE $ 99</p>
                        <h1><span class="dl">$</span>498 <span>for 3 months</span></h1></div></div>
                        
                    </div>
           
                 <div class="col-md-12 mt-3">
                    <div class="bg-col">
                        <div class="container mt-4">
                          
                        <p></p>
                                <h1><span class="dl">$</span>198 <span>for 1 months</span></h1></div></div>
                        
                    </div>
                </div>
               
                <div class="col-md-8 targetDiv" id="div4">
                  <div class=" mb-3">
                      <h4 class="card-title mb-0">Preference for videos</h4>
                      <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                      @csrf
                      <input type="hidden" name="user_id" value="<?= $user->id ?>" />
   
                      <div class="form-group  mt-4 pt-5">
                          <div class="col-md-6 p-0">
                        <label><h5 class="mb-4">Preference Language</h5></label>
                          
                        <select id="" name="preference_language[]" class="js-example-basic-multiple myselect col-md-5" style="width: 46%!important;"  multiple="multiple">
                            @foreach($preference_languages as $preference_language)
                                <option value="{{ $preference_language->id }}" >{{$preference_language->name}}</option>
                            @endforeach
                        </select>
                     </div> </div>
   <div class="form-group  mt-4">
                     <div class="col-sm-6 p-0">
                         <label><h5 class="mb-4">Preference Genres</h5></label>
      
                        <select id="" name="preference_genres[]" class="js-example-basic-multiple myselect" style="width: 46%;" multiple="multiple">
                            @foreach($videocategory as $preference_genres)
                                <option value="{{ $preference_genres->id }}" >{{$preference_genres->name}}</option>
                            @endforeach
                        </select>
       </div>
      </div><div class="">
                           <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button></div> 
                      </form>
                   
                </div>
            </div>
       
            </div></div>
         
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
                        <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/').'/assets/img/tic.png';  ?>"> 
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/').'/assets/img/tic.png';  ?>"> 
                    </div>
                </div>
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">Watch on TV or Laptopt</p>
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/').'/assets/img/tic.png';  ?>"> 
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/').'/assets/img/tic.png';  ?>"> 
                    </div>
                </div>
                <div class="row mt-5 pt-3  gk">
                    <div class="col-md-8">
                        <p class="text-white">Ads Free Movies & Shows</p>
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/').'/assets/img/tic.png';  ?>"> 
                    </div>
                    <div class="col-md-2">
                          <img class=" mr-3" width="38" height="33" src="<?php echo URL::to('/').'/assets/img/tic.png';  ?>"> 
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
                        <p style="margin-left: 19px;margin-top: 8px"><?php if(!empty(Auth::user()->stripe_plan)){ echo CurrentSubPlanName(Auth::user()->id); }else { echo "No Plan you were choosed   " ;} ?></p>
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
                        <a href="<?=URL::to('/renew');?>" class="btn btn-primary noborder-radius margin-bottom-20" > Renew Subscription</a>
                        <?php } else { ?>
                        <a href="<?=URL::to('/cancelSubscription');?>" class="btn btn-danger noborder-radius margin-bottom-20" > Cancel Subscription</a>
                        <!-- <a href="<?//URL::to('/cancelSubscription');?>" class="btn btn-primary" >Cancel Subscription</a> 
                        <?php  } } 
                        elseif(!empty(Auth::user()->paypal_id) && $paypal_subscription !="ACTIVE" )
                        {   ?>
                            <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>

                        <?php } else { echo $paypal_subscription; ?>
                        <a href="<?=URL::to('/becomesubscriber');?>" class="btn btn-primary btn-login nomargin noborder-radius" > Become Subscriber</a>
                        <?php } ?>
                        </div>

                        <div class="col-sm-12 col-xs-12 padding-top-30">
                            <?php
                            $billing_url = URL::to('/').'/paypal/billings-details';
                            if (!empty(Auth::user()->paypal_id)){
                            echo "<p><a href='".$billing_url."' class='plan-types'> <i class='fa fa-caret-right'></i> View Billing Details</a></p>";
                            } 
                            ?>
                            <?php if ( $user->subscribed($stripe_plan) ) { 
                            if ($user->subscription($stripe_plan)->ended()) { ?>
                            <p><a href="<?=URL::to('/renew');?>" class="plan-types" ><i class="fa fa-caret-right"></i> Renew Subscription</a></p>
                            <?php } else { ?>
                            <p><a href="<?=URL::to('/upgrade-subscription');?>" class="plan-types" ><i class="fa fa-caret-right"></i> Change Plan</a></p>
                            <?php  } } ?>

                            <?php if ($user->subscribed($stripe_plan) && $user->subscription($stripe_plan)->onGracePeriod()) { ?>
                            <p><a href="<?=URL::to('/renew');?>" class="plan-types" > Renew Subscription</a></p>
                            <?php } ?>

                            <?php if ($user->subscribed($stripe_plan)) { ?>
                            <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary noborder-radius btn-login nomargin" > View Subscription Details</a>
                            <?php } ?>
                        </div>
                    </div>
            <?php } ?> 
            </div>
        </div>

        <div class="col-sm-12">
            <div class="sign-user_card text-center mb-3">
                <a href="<?=URL::to('/transactiondetails');?>" class="btn btn-primary btn-login nomargin noborder-radius" >View Transaction Details</a>
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
		                        <input type="email" readonly id="email" name="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" class="form-control" placeholder="Email">
                            </div> 
                        
                        
                            <div class="form-group">
		                        <label>Password:</label><br>
		                        <input type="password"  name="password"  value="<?php if(!empty($user->password)): ?><?= $user->password ?><?php endif; ?>" placeholder="Password"  class="form-control"  >
		                        <!-- <input type="password"  name="password"  value="" placeholder="Password"  class="form-control"  > -->
		                    </div> 
                        
                        
                            <div class="form-group">
		                         <label> Phone:</label>
		                         <input type="number" id="mobile" maxlength="10" minlength="10" name="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" class="form-control" placeholder="Mobile Number">
                            </div>
                            
                            <div class="form-group">
                            <label> DOB:</label>
                            <input type="date" id="DOB" name="DOB" value="<?php if(!empty($user->DOB)): ?><?= $user->DOB ?><?php endif; ?>">
                            </div>

				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" style="padding: 9px 30px !important;" class="btn btn-primary" data-dismiss="modal">Close</button>
					<button type="button" style="padding: 9px 30px !important;" class="btn btn-primary" id="submit-new-cat">Save changes</button>
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
                    <div class="sign-user_card" style="height: 183px;">
                        <h4 class="card-title mb-0">Plan Details</h4>
                        <div class="row align-items-center justify-content-between mb-3 mt-3">
                            <div class="col-sm-4">
                       <?php  if($user_role == 'registered'){ ?>
                              <h6><?php echo 'Registered'." " .'(Free)'; ?></h6>                                       
                              <h6>Subcriptions</h6>                                       
                           <?php }elseif($user_role == 'subscriber'){ ?>
                              <h6><?php echo $role_plan." " .'(Paid User)'; ?></h6>
                              <br>                                       
                              <h6>Subcriptions</h6>  
                           <?php } ?>
                           </div>
                            <div class="col-sm-6">
                                <a href="<?=URL::to('/stripe/billings-details');?>" class="btn btn-primary editbtn" >Upgrade Plan </a>        
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3" id="updatepic">
                    <div class="sign-user_card mb-3">
                        <h4 class="card-title mb-0">Manage Profile</h4>
                        <!-- <form action="<?php if (isset($ref) ) { echo URL::to('/').'/register1?ref='.$ref.'&coupon='.$coupon; } else { echo URL::to('/').'/register1'; } ?>" method="POST" id="stripe_plan" class="stripe_plan" name="member_signup" enctype="multipart/form-data"> 
                        <form action="{{ URL::to('admin/profileupdate') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
						      <input type="hidden" name="user_id" value="<?= $user->id ?>" />
                        <input type="file" multiple="true" class="form-control editbtn" name="avatar" id="avatar" />
                        <!--   <input type="submit" value="<?=__('Update Profile');?>" class="btn btn-primary  noborder-radius btn-login nomargin editbtn" />     <button type="submit" value="Verify Profile" id="submit" class="btn btn-primary btn-login verify-profile " style="display: none;"> Verify Profile</button>
                        <button class="btn btn-primary noborder-radius btn-login nomargin editbtn mt-2" type="submit" name="create-account" value="<?=__('Update Profile');?>">{{ __('Update Profile') }}</button>                   
                        </form>		
                    </div>
                </div>

      {{-- Preference for videos --}}
                <div class="col-lg-6 mb-3" id="">
                  <div class="sign-user_card mb-3">
                      <h4 class="card-title mb-0">Preference for videos</h4>
                      <form action="{{ URL::to('admin/profilePreference') }}" method="POST"  >
                      @csrf
                      <input type="hidden" name="user_id" value="<?= $user->id ?>" />
   
                      <div class="col-sm-9 form-group">
                        <label><h5>Preference Language</h5></label>
                        <select id="" name="preference_language[]" class="js-example-basic-multiple myselect" style="width: 100%;" multiple="multiple">
                            @foreach($preference_languages as $preference_language)
                                <option value="{{ $preference_language->id }}" >{{$preference_language->name}}</option>
                            @endforeach
                        </select>
                     </div>
   
                     <div class="col-sm-9 form-group">
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

{{-- Multiuser Profile --}}
         <div class="col-lg-6 mb-3" >
            <div class="sign-user_card mb-3">
               <h4 class="card-title mb-0 manage"> Profile</h4>
                  <div class="col-md-12 profile_image">
                      @forelse  ($profile_details as $profile)
                        <div class="">
                                 <img src="{{URL::asset('public/multiprofile/').'/'.$profile->Profile_Image}}" alt="user" class="multiuser_img" style="width:120px">
                                 <div class="circle">
                                    <a  href="{{ URL::to('profileDetails_edit', $profile->id)}}">
                                           <i class="fa fa-pencil"></i> </a>
                                    @if($Multiuser == null)
                                     <a  href="{{ URL::to('profile_delete', $profile->id)}}" onclick="return confirm('Are you sure to delete this Profile?')" >
                                       <i class="fa fa-trash"></i> </a> 
                                    @endif
                                 </div>
                                 <div class="name">{{ $profile ? $profile->user_name : ''  }}</div>
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
                              @foreach($videos as $video)
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
  include(public_path('themes/theme1/views/footer.blade.php'));
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

$(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })

</script>
