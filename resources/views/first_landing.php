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
		
<style>
	.land{
		background-color: #202224;
		 overflow: hidden;
	}
	.logo{
		    padding: 45px;
            margin-top: -25px;
		    padding-left: 60px;
	}
	.inway{
		background-color: #e50914;
		border-color: #e50914;
		font-size: 1rem;
		float: right;
		width: 90px;
		margin-right: 50px;
	}
	.inway:visited{
		color: #fff;
    background-color: #e50914;
    border-color: #e50914;
		
	}
	.btn-primary:hover {
    color: #e50914;
    background-color: #fff;
    border-color: #fff;
}
	.btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #e50914;
    border-color: #e50914;
}
	.btn-primary.focus, .btn-primary:focus {
    color: #fff;
    background-color: #e50914;
    border-color: #e50914;
   /* box-shadow: 0 0 0 0.2rem rgb(38 143 255 / 50%);*/
}
	.button{
		padding: 45px;
    margin-top: -15px;
	}
	
	.landing-page{
		/*background: url(../assets/img/Landban.png) no-repeat;*/
		background-size: cover;
    height: 665px;
	}
	
	.tvsec{
		height: 480px;
		margin-top: 75px;
	}
	.tvtag{
		font-weight: bold;
		color: #fff;
		font-family: 'Open Sans', sans-serif;
		font-size: 54px;
	}
	.tvscene{
		font-size: 25px;
		font-family: 'Quattrocento Sans', sans-serif;
		color: #fff;
		width: 370px;
		margin-left: 105px;
		margin-top: 35px;
		text-align: left;
	}
	.tvdetail{
		text-align: center;
		top: 90px;
	}
	.tvimg{
		text-align: center;
	}
	section {
		border-bottom: 10px solid #383838;
	}
	.downsec{
		height: 480px;
		margin-top: 75px;
	}
	.downimg{
				text-align: center;
	}
	.downdetail{
		text-align: center;
		top: 90px;
	}
	.downtag{
		font-weight: bold;
		color: #fff;
		font-family: 'Open Sans', sans-serif;
		font-size: 54px;
		text-align: left;
	}
	.downscene{
		font-size: 25px;
		font-family: 'Quattrocento Sans', sans-serif;
		color: #fff;
		width: 370px;
		margin-top: 35px;
		text-align: left;
	}
	.devicesec{
		height: 480px;
		margin-top: 75px;
	}
	.deviceimg{
				text-align: center;
	}
	.devicedetail{
		text-align: center;
		top: 90px;
	}
	.devicetag{
		font-weight: bold;
		color: #fff;
		font-family: 'Open Sans', sans-serif;
		font-size: 54px;
	}
	.devicescene{
		font-size: 25px;
		font-family: 'Quattrocento Sans', sans-serif;
		color: #fff;
		width: 370px;
		margin-top: 35px;
		text-align: left;
		margin-left: 105px;
	}
	.faqsec{
		text-align: center;
		margin-top: 60px;
	}
	.freq{
		font-weight: bold;
		color: #fff;
		font-family: 'Open Sans', sans-serif;
		font-size: 54px;
	}
	.bandetails{
		text-align: center;
		margin-top: 150px;
	}
	.banhead{
		font-weight: bold;
		color: #fff;
		font-family: 'Open Sans', sans-serif;
		font-size: 3.125rem;
	}
	.watch{
		font-size: 1.625rem;
		font-family: 'Quattrocento Sans', sans-serif;
		color: #fff;
	}
	.prime{
		font-size: 1.2rem;
		font-family: 'Quattrocento Sans', sans-serif;
		color: #fff;
		margin-top: 30px;
	}
	.primebot{
		font-size: 1.2rem;
		font-family: 'Quattrocento Sans', sans-serif;
		color: #fff;
		margin-top: 120px;
	}
	.started{
		/*top: 30px;*/
	}
	.subtext{
		height: 55px; 
		border: 1px solid #fff;
		color: #dfdfdf;
		background-color: #fff;
		font-size: 16px;
		border-radius: .07rem !important;
	}
	.subbut{
		width: 200px;
		color: #fff;
		font-size: 1.625rem;
		background-color: #e50914;
        border-color: #e50914;
		border-radius: .07rem !important;
	}
	.subbut:hover {
    color: #fff;
    background-color: #e50914;
    border-color: #e50914;
}
	.subbut:not(:disabled):not(.disabled):active, .show>.btn-outline-secondary.dropdown-toggle {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}
	.card {
		background-color: #202224;
		top: 60px;	}
	.card-header{
		margin-top: 15px;
		text-align: left;
		background-color: #27282a;
	}
	.collapsed{
		text-decoration: none;
		font-size: 35px;
		color: #fff;
		
	}
	.collapsed:hover{
		color: #fff;
		font-size: 35px;
		text-decoration: none;
	}
	.card-body{
		color: #fff;
		font-size: 25px;
		text-align: left;
	}
	.btn-link:not(:disabled):not(.disabled) {
    color: #fff;
		font-size: 35px;
		text-decoration: none;
}
	.plus1{
		margin-left: 434px;
	}
	.plus2{
		margin-left: 262px;
	}
	.plus3{
		margin-left: 298px;
	}
	.plus4{
		margin-left: 80px;
	}
	.plus5{
		margin-left: 251px;
	}
	.loginbut{
		padding: 7px 17px;
       color: #e50914;
       text-decoration: none;
	}
		</style>
</head>
<div class="land">
	<section >
		<div class="landing-page" style="background:url(<?php echo URL::to('/').'/assets/img/Landban.png';?>) no-repeat;	background-size: cover;
    height: 665px;">
			<div class="row">
				<div class="col-sm-8">
        <?php
        $settings = App\Setting::find(1);
      ?>
        <!--<img class="logo" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">-->
                    <img class="logo" src="<?php echo URL::to('/').'/assets/img/home/finexs.png';?>">
				</div>
				<div class="col-sm-4 button">
        <a class="loginbut" href="<?= URL::to('/login')?>"> 
        	<button class="btn btn-primary inway" type="submit">SIGN IN</button>
    </a>
				</div>
			</div>
			<div class="bandetails">
			<h1 class="banhead">Watch On! <br>Entertainment at your Desk</h1>
			   <p class="watch">Watch TV Anytime,Anywhere.</p>
				<P class="prime">Prime Yourself-Get Ready to Keep eye's on!!!</P>
				<div class="col-md-6 offset-md-3 input-group mb-3 started">
				  <input type="text" class="form-control subtext" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
				  <div class="input-group-append">
					<button class="btn btn-outline-secondary subbut" type="button">GET STARTED</button>
				  </div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="row tvsec">
			<div class="col-md-6 tvdetail">
				<h2 class="tvtag">Enjoy on your Tv.</h2>
				<p class="tvscene">Watch on smartTvs, PlayStation, Xbox, ChromeCast, Apple Tv. Blu-Ray Players and more.</p>
			</div>
			<div class="col-md-6 tvimg">
				<img src="<?php echo URL::to('/').'/assets/img/land1.png';?>" height="100%" width="100%">
			</div>
		</div>
		
		
	</section>
	<section>
		<div class="row downsec">
			<div class="col-md-6 downimg">
				<img src="<?php echo URL::to('/').'/assets/img/landown.png';?>" height="100%" width="100%">
			</div>
			<div class="col-md-6 downdetail">
				<h2 class="downtag">Download Your Shows to Watch Offline.</h2>
				<p class="downscene">Save your favourites easily and always have something to watch.</p>
			</div>
			
		</div>
	</section>
	<section>
		<div class="row devicesec">
			<div class="col-md-6 devicedetail">
				<h2 class="devicetag">Across all devices.</h2>
				<p class="devicescene">Stream Unlimited movies and tv shows on your phone, tablet, laptop and Tv.</p>
			</div>
			<div class="col-md-6 deviceimg">
				<img src="<?php echo URL::to('/').'/assets/img/landevice.png';?>" height="80%" width="80%">
			</div>
		</div>
		
		
	</section>
	<section>
		<div class="faqsec">
			<h2 class="freq">Frequently Asked Questions</h2>
			<div class="col-md-8 offset-md-2" id="accordion">
  <div class="card">
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
				<div class="col-md-6 offset-md-3 input-group mb-3">
				  <input type="text" class="form-control subtext" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
				  <div class="input-group-append">
					<button class="btn btn-outline-secondary subbut" type="button">GET STARTED</button>
				  </div>
				</div>
			
		</div>
	</section>
	<?php /*include('footer.blade.php');*/ ?>
	</div>
	
</html> 

