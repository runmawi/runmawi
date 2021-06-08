<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
	}
		</style>
</head>
	<section class="landing-page" >
       
			<div class="row main-head d-flex justify-content-between">
				<div class="col-sm-8">
        <?php
        $settings = App\Setting::find(1);
      ?>
        <!--<img class="logo" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">-->
                    <img class="logo" src="<?php echo URL::to('/').'/assets/img/logo.png';?>">
				</div>
				<div class="col-sm-4 button">
        <a class="loginbut" href="<?= URL::to('/login')?>"> 
        	<button class="btn btn-primary inway" type="submit">Sign In</button>
    </a>
				</div>
			</div>
           
			<div class="bandetails">
			<h1 class="banhead">Watch On! <br>Entertainment at your Desk</h1>
			   <p class="watch" style="padding-top: 21px">Watch TV Anytime,Anywhere.</p>
				<P class="prime">Prime Yourself-Get Ready to Keep eye's on!!!</P>
				<div class="col-md-6 offset-md-3 input-group mb-3 started">
				  <input type="text" class="form-control subtext" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
				  <div class="input-group-append">
                      <a href="<?= URL::to('/signup')?>"> 
					<button class="btn btn-outline-secondary subbut" type="button">GET STARTED</button>
                      </a>
				  </div>
				</div>
			</div>
        
	</section>
	<section class="tvsec">
        <div class="container pt-5">
		<div class="row align-items-center">
			<div class="col-md-6 col-sm-6 tvdetail ">
				<h2 class="tvtag">Enjoy on your Tv.</h2>
				<p class="tvscene">Watch on smartTvs, PlayStation, Xbox, ChromeCast, Apple Tv. Blu-Ray Players <br>and more.</p>
			</div>
			<div class="col-md-6 col-sm-6 tvimg">
				<img src="<?php echo URL::to('/').'/assets/img/land.png';?>" width="550">
			</div>
		</div>
		</div>
		
	</section>
	<section class="downsec">
		<div class="row  align-items-center">
			<div class="col-md-6 col-sm-6 downimg">
				<img src="<?php echo URL::to('/').'/assets/img/landown.png';?>" width="500">
			</div>
			<div class="col-md-6 col-sm-6 downdetail">
				<h2 class="downtag">Download Your Shows to Watch Offline.</h2>
				<p class="downscene">Save your favourites easily and always have something to watch.</p>
			</div>
			
		</div>
	</section>
	<section class="devicesec">
		<div class="row  align-items-center">
			<div class="col-md-6 col-sm-6 devicedetail">
				<h2 class="devicetag">Across all devices.</h2>
				<p class="devicescene">Stream Unlimited movies and tv shows on your phone, tablet, laptop and Tv.</p>
			</div>
			<div class="col-md-6 col-sm-6 deviceimg">
				<img src="<?php echo URL::to('/').'/assets/img/landevice.png';?>" >
			</div>
		</div>
		</section>
	 <section class="mt-5 pt-3">
		<div class="faqsec">
			<h2 class="freq">Frequently Asked Questions</h2>
			<div class="col-md-8 offset-md-2" id="accordion">
  <div class="card mt-5">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          What is Netflix Clone?<span class="plus1">+</span>
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
       Our Netflix Clone script is a splendid Video Streaming script that empowers you to put your leg forward and lead the right direction on the path of building your Video Streaming website.
       <br>
       <br>
       Our Netflix Clone script is a splendid Video Streaming script that empowers you to put your leg forward and lead the right direction on the path of building your Video Streaming website.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Does the videos are categorized?<span class="plus2">+</span>
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        This Video Streaming website lets your users explore various TV shows, movies, video trailers, etc. from large stack of video categories and watch them at their convenience.
        <br>
        <br>
        This Video Streaming website lets your users explore various TV shows, movies, video trailers, etc. from large stack of video categories and watch them at their convenience.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          How does search made easier?<span class="plus3">+</span>
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Users can search various videos, movies, video trailers etc. with auto suggestion options provided.
      </div>
    </div>
  </div>
	<div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
          What media format does the player support?<span class="plus4">+</span>
        </button>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
      <div class="card-body">
        To assure high-quality video playback over multiple devices, we have integrated FFMPEG Player, video player software that lets users watch videos smoothly, fast across various browsers and media types.
      </div>
    </div>
  </div>
	<div class="card">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
         What fascinates the Admin Panel?<span class="plus5">+</span>
        </button>
      </h5>
    </div>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
      <div class="card-body">
        On the upper hand, admin has all the rights to manage membership plans, videos, reported users, payment history, and video categories, export various details of videos, users, payment etc. with CSV and XLS seamlessly and many more.
      </div>
    </div>
  </div>
</div>
			<P class="primebot">Prime Yourself-Get Ready to Keep eye's on!!!</P>
				<div class="col-md-6 p-5 offset-md-3 input-group mb-3">
				  <input type="text" class="form-control subtext" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
				  <div class="input-group-append">
                      <a href="<?= URL::to('/signup')?>"> 
					<button class="btn btn-outline-secondary subbut pt-2" type="button">GET STARTED</button>
                      </a>
				  </div>
				</div>
			
		</div>
	</section>
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

