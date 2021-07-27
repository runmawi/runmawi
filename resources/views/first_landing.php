<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
    <!-- Favicon -->
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <title>Flicknexs</title>
    <link rel="shortcut icon" href="assets/images/fl-logo.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="assets/css/typography.css" />
    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- Responsive -->
    <link rel="stylesheet" href="assets/css/responsive.css" />

    <style>
        .dropdown::before {
    position: absolute;
    content: " \2193";
    top: 0px;
    right: -8px;
    height: 20px;
    width: 20px;
        }.collapsed{
            font-size: 22px!important;
        }
        .fa{
            float: right;
            font-size: 22px
                font-weight: 400;
        }
        .fa:hover{
           transform: rotate(45deg);
        }
        .card-header{
            font-weight: 400;
            font-size: 22px;
        }
    </style>
</head>
<section class="landing-page">

    <div class="row main-head d-flex justify-content-between">
        <div class="col-sm-8">
            <?php
        $settings = App\Setting::find(1);
      ?>
            <!--<img class="logo" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">-->
            <img class="logo" src="<?php echo URL::to('/').'/assets/img/logo.png';?>">
        </div>
        
        <div class="col-sm-4 button d-flex">
            <div>
              <select  style="padding:6px 0px;background-color:#000000;color:#fff;">
                  <option>English</option>
                  <option>Hindi</option>
                  <option>Tamil</option>
                  <option>French</option>
                 
                </select>
                 
            </div>
            <div>
            <a class="loginbut" href="<?= URL::to('/login')?>">
                <button class="btn btn-primary inway" type="submit">Sign In</button>
            </a>
                </div>
            
        </div>
    </div>

    <div class="bandetails">
        <h1 class="banhead">Watch On! <br>Entertainment at your Desk</h1>
        <p class="watch" style="padding-top: 21px">Watch TV Anytime,Anywhere.</p>
        <P class="prime">Prime Yourself-Get Ready to Keep eye's on!!!</P>
        <div class="col-md-6 offset-md-3 input-group mb-3 mt-4 started">
            <input type="text" class="form-control subtext" placeholder="Email Address"
                aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <a href="<?= URL::to('/signup')?>">
                    <button class="btn btn-outline-secondary subbut" type="button">GET STARTED</button>
                </a>
            </div>
        </div>
    </div>

</section>
<section class="tvsec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6 col-md-5">
                <h2 class="tvtag">Enjoy on your Tv.</h2>
                <p class="tvscene mt-3">Watch on smartTvs, PlayStation, Xbox, ChromeCast, Apple Tv. Blu-Ray Players
                    <br>and more.</p>
            </div>
            <div class=" col-sm-6 col-md-7 tvimg">
                <img src="<?php echo URL::to('/').'/assets/img/land.png';?>">
            </div>
        </div>
    </div>

</section>
<section class="downsec">
    <div class="row  align-items-center">
        <div class="col-md-6 col-sm-6 downimg">
            <img src="<?php echo URL::to('/').'/assets/img/landown.png';?>">
        </div>
        <div class="col-md-6 col-sm-6 downdetail">
            <h2 class="downtag">Download Your Shows <br>to Watch Offline.</h2>
            <p class="downscene mt-3">Save your favourites easily and always have something to watch.</p>
        </div>

    </div>
</section>
<section class="devicesec">
    <div class="container">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-6 devicedetail">
            <h2 class="devicetag">Across all devices.</h2>
            <p class="devicescene mt-3">Stream Unlimited movies and tv shows on your phone, tablet, laptop and Tv.</p>
        </div>
        <div class="col-md- col-sm-6 deviceimg">
            <img src="<?php echo URL::to('/').'/assets/img/landevice.png';?>" >
        </div>
    </div>
        </div>
</section>
        
<section class="mt-5 pt-3">
    <div class="faqsec">
        <h2 class="freq">Frequently Asked Questions</h2>
         <div id="accordion" style="width:60%;margin:0 auto;" itemscope="" itemtype="https://schema.org/FAQPage">
                      
                        <div class="card" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h4 class="card-header" itemprop="name">
                          <a class="card-link" data-toggle="collapse" href="#collapseOne" aria-expanded="true"> What is Netflix Clone?
                             <i class="fa fa-plus" aria-hidden="true"></i></a>
                      </h4>
                        <div id="collapseOne" class="collapse show" data-parent="#accordion" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                      <p class="card-body m-0" itemprop="text">
                          Our Netflix Clone script is a splendid Video Streaming script that empowers you to put your leg
                        forward and lead the right direction on the path of building your Video Streaming website.
 
                          </p>
                        </div>
                      </div>
                        
                    <div class="card" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h4 class="card-header" itemprop="name">
                          <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                            Does the videos are categorized? <i class="fa fa-plus" aria-hidden="true"></i>
                            </a></h4>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                      <div class="card-body m-0" itemprop="text">
                            <p> This Video Streaming website lets your users explore various TV shows, movies, video trailers,
                        etc. from large stack of video categories and watch them at their convenience.</p> 

                          </div>
                        </div>
                        </div>
                        
                       <div class="card" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h4  class="card-header" itemprop="name">
                          <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                         How does search made easier? <i class="fa fa-plus" aria-hidden="true"></i>
                            </a></h4>
                        <div id="collapseThree" class="collapse" data-parent="#accordion" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"> 
                      <div class="card-body m-0" itemprop="text">
                           <p> Users can search various videos, movies, video trailers etc. with auto suggestion options
                        provided.</p> </div>
                        </div>
                        </div>
                        
                    <div class="card" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h4   class="card-header" itemprop="name">
                          <a class="collapsed card-link" data-toggle="collapse" href="#collapsefour">
                          What media format does the player support?<i class="fa fa-plus" aria-hidden="true"></i>
                            </a></h4>
                        <div id="collapsefour" class="collapse" data-parent="#accordion" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"> 
                      <div class="card-body m-0" itemprop="text">
                           <p> To assure high-quality video playback over multiple devices, we have integrated FFMPEG Player,
                        video player software that lets users watch videos smoothly, fast across various browsers and
                        media types. </p>
                          </div>
                        </div>
                    </div>
                        <div class="card" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h4   class="card-header" itemprop="name">
                          <a class="collapsed card-link" data-toggle="collapse" href="#collapsefive">
                         What fascinates the Admin Panel? <i class="fa fa-plus" aria-hidden="true"></i>
                            </a></h4>
                        <div id="collapsefive" class="collapse" data-parent="#accordion" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"> 
                      <div class="card-body m-0" itemprop="text">
                           <p> On the upper hand, admin has all the rights to manage membership plans, videos, reported users,
                        payment history, and video categories, export various details of videos, users, payment etc.
                        with CSV and XLS seamlessly and many more.
 </p>
                          </div>
                        </div>
                    </div>
                        
            </div>        <P class="primebot">Prime Yourself-Get Ready to Keep eye's on!!!</P>
        <div class="col-md-6 offset-md-3 input-group mb-3 mt-4 p-3 started">
            <input type="text" class="form-control subtext" placeholder="Email Address"
                aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <a href="<?= URL::to('/signup')?>">
                    <button class="btn btn-outline-secondary subbut" type="button">GET STARTED<span id=""
                            class="chevron-right-arrow" data-uia=""></span></button>
                </a>
            </div>
        </div>

    </div>
</section>
<sectio>

</sectio>
<?php include('footer.blade.php');?>

<!-- back-to-top End -->
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