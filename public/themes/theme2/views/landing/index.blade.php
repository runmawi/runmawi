@extends('layouts.app')

<!doctype html>
<html lang="en-US">
   <head>
      <?php
$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);

      ?>
      <!-- Required meta tags -->
    <meta charset="UTF-8">
    <?php $settings = App\Setting::first(); //echo $settings->website_name;?>
    <title><?php echo $uppercase.' | ' . $settings->website_name ; ?></title>
    <meta name="description" content= "<?php echo $settings->website_description ; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $settings->favicon; ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
      
     <!-- Bootstrap CSS -->
      <!-- Typography CSS -->
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme2/assets/css/style.css') ?>" />
         <link rel="stylesheet" href="<?php echo URL::to('public/themes/theme2/assets/css/bootstrap.min.css') ?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?= typography_link(); ?>" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
<style>
    
    .slick-dots li{
          margin: 0;
    }
    .slick-dots li button:before{
        color: blue!important;
        font-size: 30px;
    }
    .slick-dots{
        top: 100%;
        margin: 0;
        left: 0;
        right: 0;
        text-align: center!important;
        bottom: -40px!important;
    }
    .mn{
        margin: 5px 15px;
    }
    @media only screen and (max-width : 320px) {
        .img-lan{
            width: 100%;
        }
        .d-flex{
            flex-wrap: wrap;
        }
        .h-100{
            height: auto!important;
        }
        .div1{
            padding: 0!important;
        }
        .ital{
            width: 100%;
            font-size: 20px;
        }
        .text-right{
            text-align: left!important;
        }
        h1{
            font-size: 40px!important;
        }
         .position-relative{
            margin-top: 0!important;
        }

    }
    .sec-4 h2{
        font-size: 40px;
    }
    .nav-link{
        padding: 5px 20px;
    }
    .adv{
        font-size: 20px;

    }
    .sec-3 h2{
        font-size: 40px;
    }
    .btn{
        border-radius: 4px!important;
    }
    h3{
        font-weight: 600;
    }
     a:link{
        margin-right: 5px;
    }
    h1{
       
font-size: 75px;
font-weight: 600;
line-height: 65px;
letter-spacing: 0em;
text-align: center;

    }
    h1,h2,h3,h4{
        font-family: 'Roboto', sans-serif;

    }
    .sec-2 h2{
        font-size: 40px;
    }
    h2{
        font-weight: 700;
        font-weight: 40px;
    }
    main.py-4{
        padding-bottom: 0!important;
        padding-top: 0!important;
    }
    body{
        background: #fff;
    }
    input{
        color: #000;
    }
    /*.sign-user_card {
        background: none !important;
    }*/
#ck-button {
    margin:4px;
/*    background-color:#EFEFEF;*/
    border-radius:4px;
/*    border:1px solid #D0D0D0;*/
    overflow:auto;
    float:left;
}
#ck-button label {
    float:left;
    width:4.0em;
}
#ck-button label span {
    text-align:center;
    display:block;
    color: #fff;
    background-color: #3daae0;
    border: 1px solid #3daae0;
    padding: 0;
}
#ck-button label input {
    position:absolute;
/*    top:-20px;*/
}

#ck-button input:checked + span {
    background-color:#3daae0;
    color:#fff;
}
    
.mobile-div {
	margin-left: -2%;
	margin-top: 1%;
}
.modal-header {
    padding: 0px 15px;
    border-bottom: 1px solid #e5e5e5 !important;
    min-height: 16.42857143px;
}
#otp {
    padding-left: 15px;
    letter-spacing: 42px;
    border: 0;
   /* background-image: linear-gradient(to right, black 60%, rgb(120, 120, 120) 0%);*/
    background-position: bottom;
    background-size: 50px 1px;
    background-repeat: repeat-x;
    background-position-x: 80px;
}
    #otp:focus {
        border: none;
    }
    /*.sign-up-buttons{
        margin-left: 40% !important;
    }*/.verify-buttons{
        margin-left: 36%;
    }
    .container{
        margin-top: 70px;
    }
    .panel-heading {
    margin-bottom: 1rem;
}
   /* .form-control {
    background-color: var(--iq-body-text) !important;
    border: 1px solid transparent;
    height: 46px;
    position: relative;
    color: var(--iq-body-bg) !important;
    font-size: 16px;
    width: 100%;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}
    a {
    color: var(--iq-body-text);
    text-decoration: none;
}*/
.phselect{
    
    height: 45px !important;
    background: transparent !important;
    color: var(--iq-white) !important;
}
.form-control {
    height: 45px;
    line-height: 45px;
    background: transparent !important;
    border: 1px solid var(--iq-body-text);
    font-size: 14px;
    color: #000!important;
    border-radius: 0;
    margin-bottom: 1rem !important;
}
    .form-control:focus {
    
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
}
    .custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
/*input[type="file"] {
    display: none;
}*/
    .catag {
    padding-right: 150px !important;
}
i.fa.fa-google-plus {
    padding: 10px !important;
}
    option {
    background: #474644 !important;
}
    .card{
        background: transparent!important;
        border:none!important;
    }
    .reveal{
        margin-left: -92px;
    height: 45px !important;
    background: transparent !important;
    color: #fff !important;
    }
    .error {
    color: brown;
   font-family: 'Roboto', sans-serif;

    }
   
    .agree {
    font-style: normal;
    font-weight: 400;
    font-size: 10px;
    line-height: 18px;
    display: flex;
    align-items: center;
    color: #000;
}
    .get{
   font-family: 'Roboto', sans-serif;

font-style: normal;
font-weight: 500;
font-size: 20px;
line-height: 32px;
}
    .form-group{
        margin-bottom: 0;
    }
    #fileLabel{
        position: absolute;
        top: 8px;
        color: #fff;
        padding: 8px;
        left: 114px;
        background:rgba(11, 11, 11,1);
        font-size: 12px;
    }
      .signup-desktop{
        background-color: #fff;
          border-radius: 5px!important;
        border:none!important;
        font-family: 'Roboto', sans-serif;
          padding: 5px 10px!important;

font-style: normal;
font-weight: 600;

    }
     .nees{
        margin: 2px;
    }
    .nees1{
        margin: 10px;
    }
    .signup-desktop i{
        font-size: 22px;
    }
    .btn-outline-success{
        border: none;
    }
     .signup-desktop:hover{
        background-color: burlywood;
         color: #fff;

    }
    .signup{
       background: rgba(1, 220, 130, 1)!important;
        padding: 10px 30px;
          font-family: 'Roboto', sans-serif;
        font-weight: 600;

    }
    p{
   font-family: 'Roboto', sans-serif;
font-weight: 400;
font-size: 20px;
line-height: 32px;

}
    .nav-link.active{
        color: #fff!important;
       background: #01DC82!important;


    }
    .btn{
        font-weight: 500;
    }
    .poli{
        font-family: 'Roboto', sans-serif;
        font-size: 11px;
    }
    .sec{
        padding: 70px 0 70px 0;
    }
    .in {
    font-size: 35px;
    line-height: 40px;
    font-weight: 600;
    color: #000;
    text-align: left;
    font-family: 'Roboto', sans-serif;
}
    .btn-success{
        color: #000;
    }
    .bg-light {
    background: transparent!important;
    color: #000;
    z-index: 1;
}
    .div1{
       padding:50px 90px 100px 20px;
    }
    .h-100{display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    align-self: center;}
    .nem{
        color: #01DC82;

    }
    .lan{
        margin-top: 40px;
    }
    .dig{
        font-style: normal;
font-weight: 400;
font-size: 35px;
line-height: 32px;
    }
    .tune li{
        font-size: 20px;
        line-height: 40px;
    }
    .slick-next:before {
    content: '→';
        display: none;
}
    .slick-prev:before {
    content: '←';
          display: none;
}
    .nav-link{
        font-size: 17px;
    }
    .io{
        position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    color: white;
        text-align: center;
    }
</style>

<?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

$jsondata = json_decode($jsonString, true); ?>

<section class="mb-0" ><!--style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;"-->
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
  <a class="navbar-brand" href="#"><img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>"  style="margin-bottom:1rem;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    
<a type="button" class="btn btn-primary mr-3">Become a Partner</a>
      <a class="btn btn-success  my-2 mr-2 my-sm-0" href="{{ route('login') }}" >Join Now</a>
     
    
  </div>
</div></nav>
<div class="position-relative" style="margin-top:-70px;background-image:url('<?php echo  URL::to('/assets/img/ban33.png')?>');background-repeat: no-repeat;background-size: cover;">
<div class="fixe">
    <div class="row m-0  p-0" >
        <div class="col-md-12 col-lg-12 p-0 text-center h-100" style="padding: 17% 0 17% 0!important;">
            <h1 class="mb-3">Welcome to <span class="nem">Nemisa Tv</span></h1>
            <h2 class="dig mt-1 mb-5">The home of 4IR and digital knowledge.</h2>
            <p class="text-white">South Africa’s first free video sharing social platform where we mix knowledge <br>and entertainment for unique learning experience</p>
        </div>
        
      
    </div>
    </div></div>
    <section class="sec-2">
        <div class="container">
            <div class="div1" >
            <div class="row m-0 p-0 justify-content-around align-items-center">
                <div class="col-lg-6 p-0">
                    <h2 class=" text-black">Nemisa Tv - Bringing the world of digital technology to you.</h2>
                     <ul class="tune mt-3">
                         <li> Be transformed by the entertaining learning opportunities offered.</li>
                         <li>Thousands of videos available.</li>
                         <li>Get connected to communities of experts.</li>
                        

                       

                    </ul>
                </div>
                <div class="col-lg-6">
                    
                  
                   
                   <div class="row p-0">
                       <div class="col-md-4 p-0"> <img class="img-lan" src="<?php echo  URL::to('/assets/img/v1.png')?>" style=""></div>
                       <div class="col-md-4 p-0" style="">   <img class="mt-4 img-lan" src="<?php echo  URL::to('/assets/img/v2.png')?>" style=""></div>
                       <div class="col-md-4 p-0"  style="">  <img class="mt-5 img-lan" src="<?php echo  URL::to('/assets/img/v3.png')?>" style=""></div>
                    </div>
                </div>
            </div>
        </div>
            </div>
    </section>
    <section class="sec-3">
        <div class="container-fluid">
            
            <h2 class="text-center mt-5 ">Explore More With Nemisa Tv</h2>
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
      <div class="row favorites-slider1">
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
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r3.png')?>" style="">
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
   <img class="w-100 " src="<?php echo  URL::to('/assets/img/r4.png')?>" style="">
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
          </div>
      </div>   
      <div class="row mt-2">
         </div></div>
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
     <div class="text-center mt-5 mb-5">
                    <a class="btn btn-success my-2 my-sm-0" style="font-weight:600;font-size: 20px;" herf="#">Explore More</a>
            </div>
</div>
                
            </div>
               </div>
           
    </section>
    <section class="sec-4 mt-5">
       
        <div class="container-fluid mb-5">
            <h2 class="text-center text-black">Top Picks for You </h2>
            <div id="slide">
                <div>    
            <div class="row align-items-center justify-content-center mt-5" >
                <div class="col-lg-2 position-relative p-0">
                    <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r1.png')?>" style=>
                    <p class="io">Radio</p>
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn"> <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r2.png')?>" style=>
                       <p class="io">Education</p></div>
                    <div class="position-relative mn">  <img class="w-100 mt-3" src="<?php echo  URL::to('/assets/img/lan/r3.png')?>" style=>
                       <p class="io">Live <br>Streaming</p></div>
                    
                   
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r4.png')?>" style=>
                     <p class="io">Pod Cast</p>
                    
                </div>
                <div class="col-lg-2 p-0">
                    <div class="position-relative mn">
                        <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r2.png')?>" style=>
                      <p class="io">Online <br>Streaming </p>
                    </div>
                    <div class="position-relative mn">
                        <img class="w-100 mt-3" src="<?php echo  URL::to('/assets/img/lan/r6.png')?>" style=>
                      <p class="io">Movies</p>
                    </div>
                     
                     
                </div>
                <div class="col-lg-2 position-relative p-0">
                     <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r7.png')?>" style=>
                     <p class="io">Animation</p>
                </div>
            </div></div>
            <div>
                 <div class="row align-items-center justify-content-center mt-5" >
                <div class="col-lg-2">
                    <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r1.png')?>" style=>
                </div>
                <div class="col-lg-2">
                     <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r2.png')?>" style=>
                     <img class="w-100 mt-3" src="<?php echo  URL::to('/assets/img/lan/r3.png')?>" style=>
                </div>
                <div class="col-lg-2">
                     <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r4.png')?>" style=>
                </div>
                <div class="col-lg-2">
                     <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r5.png')?>" style=>
                     <img class="w-100 mt-3" src="<?php echo  URL::to('/assets/img/lan/r6.png')?>" style=>
                </div>
                <div class="col-lg-2">
                     <img class="w-100" src="<?php echo  URL::to('/assets/img/lan/r7.png')?>" style=>
                </div>
            </div>
                </div>
               
        </div>
            </div>
    </section>
    <section class="sec-3 p-0" style="background:#003C3C
!important;">
         <div style="background-image:url('<?php echo  URL::to('/assets/img/lan/ntv.png')?>');background-repeat: no-repeat;
    background-position: right bottom;
   padding:30px;">
       
        <div class="container">
             <h2 class="mb-4">Benefits you Can’t <br>
Resist</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="row mt-5 ">
                    <div class="col-lg-6">
                        <div>
                             <img class="mb-1" src="<?php echo  URL::to('/assets/img/lan/v1.png')?>" style=>
                        <h4 class="">Hours of content</h4>
                        <p style="color:#00DADA;">Watch your favorite content across Languages & topics</p>
                        </div>
                        <div class=" lan" style="margin-top:65px;">
                             <img class="mb-1" src="<?php echo  URL::to('/assets/img/lan/v3.png')?>" style=>
                        <h4 class="">User Feedback and<br> Interaction</h4>
                        <p style="color:#00DADA;">Learn by interacting with experts and other users.</p>
                        </div>
                       
                    </div>
                    <div class="col-lg-6 p-0">
                        <div>
                        <img class="mb-1" src="<?php echo  URL::to('/assets/img/lan/v2.png')?>" style=>
                        <h4 class="">Audience Tested</h4>
                        <p style="color:#00DADA;">Enjoy the wide variety of movies & Educations Content much more choice of Audience</p>
                        </div>
                        <div class="lan ">
                             <img class="mb-1" src="<?php echo  URL::to('/assets/img/lan/v4.png')?>" style=>
                        <h4 class="">Aggregated User generated content</h4>
                        <p style="color:#00DADA;">Create and contribute your own digital content to empower other users.</p>
                        </div>
                         
                    </div>
                    <div class="lan col-lg-6 " style="margin-top:20px;">
                             <img class="mb-1" src="<?php echo  URL::to('/assets/img/lan/v5.png')?>" style=>
                        <h4 class="">Curated multiformat<br> training content</h4>
                        <p style="color:#00DADA;">Diverse learning content that focuses on the visual, audio, social, solitary, verbal and logical.</p>
                        </div>
                </div>
            </div>
            
            </div></div></div>
    </section>
    <section class="sec-4 mt-5">
        <div class="container-fluid">
            <h2 class="text-center text-black mb-5">Members Endorsement</h2>
          
            <div class="">
                <p class="ital nem"> <img class="w-20" src="<?php echo  URL::to('/assets/img/comma.png')?>" style="margin-top:-35px;">I come to Nemisa tv for the curation and class quality. That's really worth the cost of membership to me.</p>
                <p class="text-center mt-4">—Jason R, Nemisa Student</p>
            </div>
              <div class="text-center mt-5 mb-3">
                <img  src="<?php echo  URL::to('/assets/img/cli.png')?>" style=""></div>
        </div>
    </section>
    <section class="sec-3" style="padding:80px 30px 80px 30px;">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                 <img class="img-lan" src="<?php echo  URL::to('/assets/img/m1.png')?>" style="">
            </div>
            <div class="col-lg-5">
                <h2>Free edutainment for the digital warrior</h2>
                <p class="text-white adv mt-4">Advancing South Africans for the future with content that is missioned to deliver tangible digital skills to bridge the digital divide.</p>
                <p class="text-white adv mt-4">WATCH EVERYWHERE, STREAM LIVE, QUALITY VIDEOS</p>
                <a class="btn btn-lg btn-success  my-2 mr-2 my-sm-0 btn-block" style="color:#fff!important;padding:12px;width:70%;" href="{{ route('login') }}" >Get Started</a>
            </div>
            
        </div></div>
    </section>

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

<section style="background:url('<?php echo URL::to('/').'/public/uploads/settings/'.$settings->login_content; ?>') no-repeat scroll 0 0;;background-size: cover;">
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?php $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); ?>
<?php 
    $ref = Request::get('ref');
    $coupon = Request::get('coupon');
    // dd($SignupMenu);
?>

<!-- Modal -->
  <div class="modal fade" id="terms" role="dialog" >
    <div class="modal-dialog" style="width: 90%;color: #000;">
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header" style="border:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:#000;"><?php echo __('Terms and Conditions');?></h4>
        </div>
        <div class="modal-body" >
            <?php
                $terms_page = App\Page::where('slug','terms-and-conditions')->pluck('body');
             ?>
            <p><?php echo $terms_page[0];?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
        </div>
      </div>
    </div>
  </div>
<style>
    .modal-content {
        background-color: #000000;
    }
</style>

<div class="modal fade" id="loginModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center;">
        <h5 class="modal-title" id="exampleModalLongTitle"><h1><?=__('Enter the 4-digit Verification code sent');?></h1></h5>
        
      </div>
      <div class="modal-body">
              <form action="" method="POST" id="confirm" >
               
                <!--<label for="username" class="col-md-4 col-sm-offset-1 col-form-label text-md-right"><=__('Enter OTP');?></label>-->
                    <p style="color:green" id="success"></p>
            @csrf
               <div class="well row col-xs-12">
					<div class="otp_width">
						<input type="text" class="form-control" maxlength="4" name="otp" id="otp" value="" style="background-color: #000;" />
						<input type="hidden" class="form-control" name="verify" id="verify_id" value="" />
						<div class="row timerco" >
						 	<p> OTP will Expire in <span id="countdowntimer"></span>
					 	</div>
						<div class="text-center"> 
							<input type="button" value="{{ __('Verify') }}" id="checkotp"  placeholder="Please Enter OTP" class="btn btn-primary btn-login" style="">
						</div>
					 </div> 
				</div>
                  
                <div class="well row col-xs-12" style="padding: 0;">
                   <div class="col-sm-8  col-sm-offset-1">
                   <div class="verify-buttons">
                            
                    </div>
                  </div>
                  </div>
          </form>
      </div>
   
      <div class="modal-footer" style="border:none;">
        
      </div>
    </div>
  </div>
</div>
    </section>
       
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>






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
       <script src="<?= URL::to('/'). '/assets/js/jquery.lazy.js';?>"></script>
      <script src="<?= URL::to('/'). '/assets/js/jquery.lazy.min.js';?>"></script>

@php
    include(public_path('themes/theme2/views/footer.blade.php'));
@endphp

@endsection 
