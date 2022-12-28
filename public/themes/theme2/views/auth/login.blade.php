<?php
$settings = App\Setting::find(1);
$system_settings = App\SystemSetting::find(1);
?>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Login | <?php echo $settings->website_name ; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme1/assets/css/bootstrap.min.css')?>" rel="stylesheet">
      <!-- Typography CSS -->
      <link href="<?php echo URL::to('public/themes/theme2/assets/css/typography.css') ?>" rel="stylesheet">
      <!-- Style -->
      <link href="<?php echo URL::to('public/themes/theme2/assets/css/style.css') ?>" rel="stylesheet">
      <link href="<?php echo URL::to('public/themes/theme2/assets/css/responsive.css') ?>" rel="stylesheet">

      <!-- Responsive -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
    </script>
    
<style>
    a:link{
        margin-right: 5px;
    }
    h1,h2,h3,h4{
        font-family: 'Roboto', sans-serif;

    }
    h2{
        font-weight: 700;
        font-weight: 40px!important;
    }
    body{
        background: #fff;
    }
    h3 {font-size: 30px!important;}
    .from-control::placeholder{
        color: #7b7b7b!important;
      

    }
    .links{
         color: #fff;
    }
    .nv{
        font-size: 14px;
       color: #fff;
        margin-top: 25px;
    }
    .km{
       text-align:center;
         font-size: 75px;
        font-weight: 900;
        
       
    }
    .in{
       
font-size: 35px;
        line-height: 40px;
        font-weight: 600;
        color: #000;
        text-align: left;
        font-family: 'Roboto', sans-serif;




    }
    	.input-icons i {
			position: absolute;
            left: 20px;
		}
		
		.input-icons {
			width: 100%;
			margin-bottom: 10px;
		}
		.get{
   font-family: 'Roboto', sans-serif;
font-style: normal;
font-weight: 500;
font-size: 20px;
line-height: 55px;
}
		.icon {
			padding: 10px;
			color: #fff;
			min-width: 50px;
            font-size: 24px;
			text-align: center;
		}
		
		/*.input-field {
			width: 100%;
			padding: 10px;
			height: 59px;
           
		}*/
	
       
    .signcont {
 }
    label{
        color: #000!important;
        margin-bottom: 0;
    }
    a.f-link {
    
        font-size: 14px;
        color: #000!important;
    
}
   .d-inline-block {
    display: block !important;
}
i.fa.fa-google-plus {
    /* padding: 10px !important;*/}
    .btn-success{
        background: rgba(1, 220, 130, 1)!important;

    }
    .demo_cred {
    background: #5c5c5c69;
    padding: 15px;
    border-radius: 15px;
    border: 2px dashed #51bce8;
    text-align: left;
}    
   .form-control::-moz-placeholder {
  color: #fff!important;
  opacity: 1;
         letter-spacing: 0.28em;
}
.form-control:-ms-input-placeholder {
  color: #999;
      letter-spacing: 0.28em;
}
.form-control::-webkit-input-placeholder {
  color: #999;
      letter-spacing: 0.28em;
}
    .sign-in-page{
        
      /*  padding: 40px;
        padding-top: 100px;*/
       
    } 
    .nees{
        margin: 2px;
    }
    .nees1{
        margin: 10px;
    }
    .sign-user_card input{
        height: 45px;
    }
    .signup-desktop{
        background-color: #fff;
        border:1px solid #252525!important;
        font-family: 'Roboto', sans-serif;

font-style: normal;
font-weight: 600;

    }
    .signup-desktop i{
        font-size: 23px;
    }
     .signup-desktop:hover{
        background-color: burlywood;
         color: #fff;

    }
    .signup{
       background: rgba(1, 220, 130, 1)!important;

    }
    p{
   font-family: 'Roboto', sans-serif;

}
</style>
    </head>

<body>
<section class="mb-0" ><!--style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;"-->
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
  <a class="navbar-brand" href="#"><img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    

      <button class="btn btn-outline-success my-2 mr-2 my-sm-0" type="submit">Sign in</button>
      <a class="btn btn-success my-2 my-sm-0"  href="{{ route('signup') }}" style="" >Sign up</a>
    
  </div>
</div></nav>
<div class="position-relative" style="margin-top:-70px;">
<div class="fixe">
    <div class="row m-0 p-0">
        <div class="col-md-4 col-lg-4 p-0">
             <img class="w-100" src="<?php echo  URL::to('/assets/img/h1.png')?>" style="">
             <img class="w-100 mt-2" src="<?php echo  URL::to('/assets/img/h2.png')?>" style="">
        </div>
        <div class="col-md-4 col-lg-4 ">
            <div class="row">
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/h3.png')?>" style=""></div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/h4.png')?>" style=""></div>
                </div>
            </div>
                <div class="sign-user_card mt-2 mb-2 p-0 ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from  m-auto" align="center">
                      <h1 class="in mt-3 text-center">Look Into Nemisa Tv For Realistic Experience. 
                                                        <br>Join Now!</h1>
                      <p class="get">Get 5 free days of Nemisa Tv</p>
                      <div class="form-group row mb-0 justify-content-center">
						@if ( config('social.google') == 1 )
                           
                            <div class="col-md-3 p-0">
                            <a href="{{ url('/auth/redirect/google') }}" style="border:none;color:#fff;"  class="btn signup-desktop"><i class="fa fa-google"></i> Google</a>
                            </div>
                        @endif  
						@if ( config('social.facebook') == 1 )
                            <div class="col-md-3 p-0">
                                <a href="{{ url('/auth/redirect/facebook') }}" class="btn signup-desktop" style="border:none;color:#fff;"><img class="" src="<?php echo  URL::to('/assets/img/ff.png')?>" style=""> Facebook</a>
                            </div>
						@endif 
						</div>
                      <?php if($settings->demo_mode == 1) { ?>
                        <div class="demo_cred">
                            <p class="links" style="font-weight: 600; border-bottom: 2px dashed #fff;">Demo Login</p>
                            <p class="links"><strong>Email</strong>: admin@admin.com</p>
                            <p class="links mb-0"><strong>Password</strong>: Webnexs123!@#</p>
                        </div>
                      <?php } else  { ?>
                      <?php } ?>
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
                     <form method="POST" action="{{ route('login') }}" class="mt-3">
                         @csrf
						   <input type="hidden" name="previous" value="{{ url()->previous() }}">
						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
                        <div class="d-flex">
                            
                         </div>
                         <hr>
                          <p class="bg-white" style="position: relative;    top: -28px;    z-index: 1;    width: 10%;">OR</p>
                         <div class="row justify-content-center">
                             <div class="col-lg-12">
                        <div class="form-group">  
                            <div class="input-icons">
                          <!-- <input type="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email" autocomplete="off" required>-->
                          <!--<i class="">   
                                <img class=" fa fa-user icon mr-3" src="<?php echo URL::to('/').'/assets/img/uss.png';  ?>"> </i>-->
                            <input id="email" type="email" class=" input-field form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('USER NAME') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div></div>
                        <div class="form-group" style="  ">                                 
                           <!--<input type="password" class="form-control mb-0" id="exampleInputPassword2" placeholder="Password" required>--><div class="input-icons">
                          <!-- <i class=""><img class=" fa fa-user icon mr-3" src="<?php echo URL::to('/').'/assets/img/lock.png';  ?>"> 
			</i> -->
			
                           
                            								<input id="password" type="password" class="input-field  form-control @error('password') is-invalid @enderror" placeholder="{{ __('PASSWORD') }}" name="password" required autocomplete="current-password" >
                        </div> </div>
                         <div class="links text-right">
                      @if (Route::has('password.request'))
                     <a href="{{ route('password.request') }}" class="f-link">Can't Login?</a>
                      @endif
							
                  </div>

                  
                                    {{-- reCAPTCHA  --}}
                        @if( get_enable_captcha()  == 1)   
                            <div class="form-group text-left" style="  margin-top: 20px;">
                                {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                        
                           <div class="sign-info">
                              <button type="submit" class="btn signup" style="width:100%;color:#252525!important;letter-spacing: 1px;font-size:20px;font-weight: 600;">START EXPLORING TODAY</button>
                           </div> 
                                  <div class="mt-3">
                  <div class="d-flex justify-content-center  links">
                     
                      <p class="text-left agree mb-0">By signing up you agree to Nemisa Tv Terms of Service and Privacy Policy. This page is protected by reCAPTCHA and is subject to Google's Terms of Service and Privacy Policy.</p>
                      
                  </div>
                <!--  <div class="d-flex align-items-center agree justify-content-strat">
                          <input type="checkbox" id="" name="" value="" class="mr-1" checked >
                    <label for="vehicle1"> Keep me signed in</label><br>
                          </div>-->
               </div>
                        </div>
                         </div>
                         <!-- <h5 class="mb-3 text-center">Sign in by using</h5>
                         -->
                                      </form>
                  </div>
               </div>
               
            </div>
             <div class="row">
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style=""></div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="nees">
                     <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style=""></div>
                </div>
            </div>
        
        </div>
        <div class="col-md-4 col-lg-4 p-0">
            <img class="w-100" src="<?php echo  URL::to('/assets/img/h6.png')?>" style="">
            <img class="w-100 mt-2" src="<?php echo  URL::to('/assets/img/h7.png')?>" style="">
        </div>
    </div>
    </div></div>
   <!--<div class="container">
      <div class="row  align-items-center justify-content-center height-self-center">
         <div class="col-lg-6 col-12 col-md-12 align-self-center">
             <div class="text-center">
                 <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;">
             </div>
            
         </div>
          
      </div>
   </div>-->
</section>
    <section class="sec-2">
        <div class="container-fluid">
            <div class="row align-items-center p-3">
                <div class="col-lg-6">
                    <h2 class="text-center text-black">Nemisa Tv - The <br>World in You</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="tune">
                        <li>Tune in and leave no stone untuned.</li>
                        <li>Beat the bushes of masters.</li>
                        <li>Get connected with global community.</li>
                        <li>Travel your journey with hot pics for you.</li>
.

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="sec-3">
        <div class="container-fluid">
            <div class="row mt-5 pt-4">
                <div class="col-md-3">
                    <div class="tn-bg">
                        <h2>34K+</h2>
                        <p>CLASSES</p>
                    </div>
                </div>
                <div class="col-md-3">
                <div class="tn-bg">
                        <h2>800K+</h2>
                        <p>MEMBERS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tn-bg">
                        <h2>11K+</h2>
                        <p>TEACHERS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tn-bg">
                        <h2>4.8*</h2>
                        <p>APP STORE RATING</p>
                    </div>
                </div>
            </div>
            <h3 class="text-center mt-5 pt-5">Explore More With Nemisa Tv</h3>
            <div class="mt-5">
                <ul class="nav nav-pills mb-3 justify-content-center " id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">All Genres</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Musical</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Documentry</a>
                     
                  </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-conta-tab" data-toggle="pill" href="#pills-conta" role="tab" aria-controls="pills-conta" aria-selected="false">Animation</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-mul-tab" data-toggle="pill" href="#pills-mul" role="tab" aria-controls="pills-mul" aria-selected="false">Multimedia</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-cast-tab" data-toggle="pill" href="#pills-cast" role="tab" aria-controls="pills-cast" aria-selected="false">Vodcast</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="false">News</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-nar-tab" data-toggle="pill" href="#pills-nar" role="tab" aria-controls="pills-nar" aria-selected="false">Webinar</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-Film-tab" data-toggle="pill" href="#pills-Film" role="tab" aria-controls="pills-Film" aria-selected="false">Film & Video</a>
                    </li>
                    <li class="nav-item">
                          <a class="nav-link" id="pills-kids-tab" data-toggle="pill" href="#pills-kids" role="tab" aria-controls="pills-kids" aria-selected="false">Comic & Kids</a>
                    </li><br>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-live-tab" data-toggle="pill" href="#pills-live" role="tab" aria-controls="pills-live" aria-selected="false">Live Recording</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-2d-tab" data-toggle="pill" href="#pills-2d" role="tab" aria-controls="pills-2d" aria-selected="false">2D & 3D Printing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-edu-tab" data-toggle="pill" href="#pills-edu" role="tab" aria-controls="pills-edu" aria-selected="false">Educational</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-cas-tab" data-toggle="pill" href="#pills-cas" role="tab" aria-controls="pills-cas" aria-selected="false">Padcast</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-eve-tab" data-toggle="pill" href="#pills-eve" role="tab" aria-controls="pills-eve" aria-selected="false">Event</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" id="pills-rad-tab" data-toggle="pill" href="#pills-rad" role="tab" aria-controls="pills-rad" aria-selected="false">Radio</a>
                    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div>    <div class="row mt-2">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div></div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
       <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div>
    </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
          <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div>
    </div>
    <div class="tab-pane fade" id="pills-conta" role="tabpanel" aria-labelledby="pills-conta-tab">    <div class="row">
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
              <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
    
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
</div>
          </div>
          <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r2.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
          </div>
         
            
      </div>
           <div class="col-md-3 p-0">
               <div class="card" style="">
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r1.png')?>" style="">
  <div class="card-body">
   
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
   <div class="d-flex small-t justify-content-between">
       <p class="">Diana and Roma EN</p>
       <p>1H 15Min</p>
      </div>
  </div>
              </div>
          </div></div></div>
</div>
            </div>
                <div class="text-center mt-5 pt-2">
                    <a class="btn btn-success my-2 my-sm-0" style="font-weight:600;font-size: 20px;" herf="#">Explore More</a>
            </div></div>
            <div class="container-fluid mt-5 pt-5">
                <h2 class="text-center">Top Pics for You </h2>
                <div class="row mt-4">
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                          <img class="w-100 " src="<?php echo  URL::to('/assets/img/t1.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                         <div class="nees1">
                             <img class="w-100 " src="<?php echo  URL::to('/assets/img/t2.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t3.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t4.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t5.png')?>" style=""></div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="nees1">
                            <img class="w-100 " src="<?php echo  URL::to('/assets/img/t6.png')?>" style=""></div>
                    </div>
                    
                </div>
                
            </div>
    </section>
    <section class="sec-4">
        <div class="container">
            <h2 class="text-center text-black">Members Endorsement</h2>
            <div class="mt-5">
                <p class="ital"> <img class="w-20" src="<?php echo  URL::to('/assets/img/comma.png')?>" style="margin-top:-35px;">I come to Nemisa tv for the curation and class quality. That's really worth the cost of membership to me.</p>
                <p class="text-center mt-2">—Jason R, Nemisa Student</p>
            </div>
        </div>
    </section>
    <section class="sec-3" style="padding:80px 30px 80px 30">
        <div class="container">
            <div class="row align-items-center">
            <div class="col-lg-6">
                <h2>Free edutainment for the digital warrior</h2>
                <p class="text-white mt-2">Advancing South Africans for the future with content that is missioned to deliver tangible digital skills to bridge the digital divide.</p>
                <p class="text-white mt-2">WATCH EVERYWHERE, STREAM LIVE, QUALITY VIDEOS</p>
            </div>
            <div class="col-lg-6">
                 <img class="w-100 " src="<?php echo  URL::to('/assets/img/m1.png')?>" style="">
            </div>
        </div></div>
    </section>

    
@php
    include(public_path('themes/theme2/views/footer.blade.php'));
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
</body>

      <!-- jQuery, Popper JS -->
      <script src="assets/js/jquery-3.4.1.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- Slick JS -->
      <script src="assets/js/slick.min.js"></script>
      <!-- owl carousel Js -->
      <script src="assets/js/owl.carousel.min.js"></script>
      <!-- select2 Js -->
      <script src="assets/js/select2.min.js"></script>
      <!-- Magnific Popup-->
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script src="assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script src="assets/js/custom.js"></script>

</html>

