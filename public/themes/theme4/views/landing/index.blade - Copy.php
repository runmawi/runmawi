

<html lang="en">
<head>

<title>{{ ucwords('onboard-with-horrortv | Horror-TV') }}</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/typography.css';?>" />
  <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/slick.css';?>" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800&display=swap" rel="stylesheet">

<style>
    
body {
    background-color: #000405;
}
@media (min-width: 1900px) {
    .container {
        max-width: 1920px;
    }
}
.footer-background-home {
    background-image: url("http://savagestudiosinc.com/wp-content/uploads/2022/07/footerbackground-scaled.jpg");
}  
    

h1{
  color: #fff;
  font-size: 80px;
  font-family: 'poppins';
  font-weight: 800;
  line-height: 1;
 /* text-shadow: 5px 5px #8A0303;*/
;
}
h2 {
  color: #fff;
  font-size: 53px;
  font-weight: 600;
  font-family: 'poppins';
}
h3 {
  color: #8A0303;
  font-size: 50px;
  font-style: italic;
  font-family: 'poppins';
}
h4 {
  color: #fff;
  font-size: 25px;
  text-align: center;
  font-family: 'poppins';
    line-height: 35px;
}
.page_bkgrd_home {
    background-image: url("http://savagestudiosinc.com/wp-content/uploads/2022/07/headerbackgroundhomepage.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    color: #000;
    background-position: center center;
}
.logo {
width: 350PX;  
    padding: 0px!important;
}
.row {
  display: flex;
}
    .img-fluid{
        padding: 8px;
        border-radius: 10px;
        height: 300px;
    }
   
.buttonClass {
  font-size:20px;
  font-family:poppins;
  padding: 15px 45px;
  text-decoration: none;
  border-width:0px;
  color:#fff!important;
  font-weight:bold;
  border-top-left-radius:13px;
  border-top-right-radius:13px;
  border-bottom-left-radius:13px;
  border-bottom-right-radius:13px;
  background:#8A0303;
    
}

.buttonClass:hover {
  background: rgba(208, 2, 27, 1);
     color:#fff!important;
    text-decoration: none;
}
.buttonClassLarge {
  font-size:28px !important;
  font-family:poppins;
  padding: 15px 45px;
  text-decoration: none;
  border-width:0px;
  color:#fff;
  font-weight:bold;
  border-top-left-radius:13px;
  border-top-right-radius:13px;
  border-bottom-left-radius:13px;
  border-bottom-right-radius:13px;
  background:#8A0303;
}

.buttonClassLarge:hover {
  background: rgba(208, 2, 27, 1);
     color:#fff!important;
    text-decoration: none;
}
.center-image {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
@media (max-width: 768px) {
    .container {
        max-width: 100%;
    }
    .col-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
}
</style>
</head>
<body>
    <div class="page_bkgrd_home" >
        <div class="container" >

        <div class="row align-items-center p-3" >
            <div class="col-md-6 p-0" ><a href="horror-tv.com"><img class="logo" src="http://savagestudiosinc.com/wp-content/uploads/2022/07/full_logo-copy.png"></a></div>
            <div class="col-md-6" ><a href="{{ URL::to('/login') }}" class="buttonClass" style="float:right;">LOGIN</a></div>
        </div> 

        <div class="row mk" style="margin-top: 10%">
            <div class="col-lg-8 col-md-12 mov" style="/* padding-left:10%; */" ><h1>Your New<br> Favorite <br><img src="http://savagestudiosinc.com/wp-content/uploads/2022/07/screaming-1.png"><br>Service</h1><br><a href="{{ URL::to('/signup') }}" class="buttonClassLarge" >Sign Up Today for $2.45</a></div>
        </div>  </div>
        <div class="container" style="margin-top: 20%;">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 style="text-align: center; line-height:1.5;">BECOME PART OF HORROR-TV's ORIGIN STORY!</h2>
                    <h4 class="col-lg-12" style=" color: grey;margin:0 auto;">We are looking for 2,000 beta testers. A one time, low cost of $2.45/month will give you access as a beta tester. Original subscribers keep that price for as long as they are subscribed. You will have access to a private Facebook group where you will be helping curate the film library and be an integral part in creating a user experience that all horror fans will love.</h4>
                    <br/><br/>
                </div>
                <div class="col-md-12 text-center"><a href="{{ URL::to('/signup') }}" class="buttonClassLarge ">Sign up today and join our origin story for just $2.45!</a></div>
            </div>
        </div>
   </div>
    <div class="container" style="margin-top: 5%">
        <h2 class="text-center" style=" font-size: 40px;">FEATURED MOVIES</h2>
          <div class="col-sm-12 overflow-hidden mt-4">
       <!-- <div class="favorites-contens">
                    <ul class="fav favorlist-inline  row p-0 mb-0">  http://savagestudiosinc.com/wp-content/uploads/2022/07/movieposterfullwidth.png
                       <li class="slide-item">
                                    <img class="img-fluid"  src="<?php echo  URL::to('/assets/img/11.webp')?>">                             
                       </li>
                         <li class="slide-item">
                                    <img class="w-100 img-fluid" src="<?php echo  URL::to('/assets/img/12.webp')?>">                             
                       </li>
                         <li class="slide-item">
                                    <img class="w-100 img-fluid" src="<?php echo  URL::to('/assets/img/13.webp')?>">                             
                       </li>
                         <li class="slide-item">
                                    <img class="w-100 img-fluid" src="<?php echo  URL::to('/assets/img/14.webp')?>">                             
                       </li>
                         <li class="slide-item">
                                    <img class="w-100 img-fluid" src="<?php echo  URL::to('/assets/img/15.webp')?>">                             
                       </li>
                        <li class="slide-item">
                                    <img class="w-100 img-fluid" src="<?php echo  URL::to('/assets/img/16.webp')?>">                             
                       </li>
                        
                        
                       
                    </ul>
                 </div>-->
<!--
              <div class="row">
                  <div class="col-lg-2 col-4 "> <img class="img-fluid"  src="<?php echo  URL::to('/assets/img/11.webp')?>"> </div>
                  <div class="col-lg-2 col-4 "> <img class="img-fluid" src="<?php echo  URL::to('/assets/img/12.webp')?>">  </div>
                  <div class="col-lg-2 col-4 "> <img class="img-fluid" src="<?php echo  URL::to('/assets/img/13.webp')?>">  </div>
                  <div class="col-lg-2 col-4 "> <img class="img-fluid" src="<?php echo  URL::to('/assets/img/14.webp')?>">  </div>
                  <div class="col-lg-2 col-4 "> <img class="img-fluid" src="<?php echo  URL::to('/assets/img/15.webp')?>">  </div>
                  <div class="col-lg-2 col-4 "> <img class="img-fluid" src="<?php echo  URL::to('/assets/img/16.webp')?>">  </div>
                  
              </div>
-->
              <div class="row">
                  <div class="col-lg-12 ">
                      <img class="img-fluid"  src="http://savagestudiosinc.com/wp-content/uploads/2022/07/movieposterfullwidth.png"> 
                  </div>
              </div>
        </div>
    </div>
        <div class="container">
    <div class="row align-items-center" style="margin-top: 5%">
        <div class="col-sm-12 col-lg-5" >
            <h2 style="  background-color: #8A0303;padding:10px;">HALF OFF YOUR SUB FOR EVER!</h2>
            <h4 style="text-align: left; color: grey; margin-top: 10px;">Once you've subscribed during the beta test phase, your subscription will remain at $2.45 for as long as you remain a member. <strong style="color: #fff;">Paying for the year up front saves you even more at $24.95.</strong></h4>
            <h2 style="margin-top: 30px; background-color: #8A0303;padding:10px;">HELP CURATE THE MOVIES!</h2>
            <h4 style="text-align: left;  color: grey; margin-top: 10px;">As a beta test member of horror-tv.com you will be given special access to a private Facebook group where as a founding member you will be able to help pick future films and TV shows to be added to the site
                </h4>
            <h2 style="margin-top: 30px;  background-color: #8A0303;padding:10px;">ALL THE SCREENS!</h2>
            <h4 style="text-align: left; color: grey; margin-top: 10px;">We are currently developing both the phone apps and the TV apps once these come to market you will be sent an e-mail to help evaluate these as well</h4>
        </div>
        <div class="col-sm-12  col-lg-6" ><img class="w-100" style="" src="http://savagestudiosinc.com/wp-content/uploads/2022/07/scrensizes.png"></div>
    </div>  </div>
    <div class="footer-background-home">
        <div style="height: 200px;"></div>
        <h2 style="margin-top: 150px; text-align: center; ">TIME IS LIMITED. ACT NOW!</h2>
        <h4 class="col-md-4" style="margin:0 auto;">ONCE WE REACH OUR BETA TEST LEVEL OF 2000 USERS THE PRICE WILL DOUBLE. GET STARTED TODAY DON'T MISS OUT.</h4>
        <div class="col-md-12 text-center mt-5 pt-3"><a href="{{ URL::to('/signup') }}" class="buttonClassLarge" >Sign Up Today for $2.45</a></div>
        <div style="height: 200px;"></div>
    </div>
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
      <!-- Magnific Popup-->
      <script src="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <script src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <script src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>
</body>
</html>
