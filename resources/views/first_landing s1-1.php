<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
		<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
              <!-- Favicon -->
    <!--<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <title>Flicknexs</title>
      <link rel="shortcut icon" href="assets/images/fl-logo.png" />-->
              <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
    </head>
        <body style="background-color:#fff;">
            <section class="pt-4 bk">
             <div class="container pt-5">
                 <div class="row main-head d-flex justify-content-between">
				<div class="col-sm-8">
        <?php
        $settings = App\Setting::find(1);
      ?>
        <!--<img class="logo" src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">-->
                    <img class="" src="<?php echo URL::to('/').'/assets/img/logo.png';?>">
				</div>
				<div class="col-sm-4 but">
        <a class="" href="<?= URL::to('/login')?>"> 
Sign In
    </a>
				</div>
                     </div>

			</div>
            </section>
         
	        <section class="mt-5 pt-2 p-5 step">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 align-items-center lmk">
                            <div class="text-center">
                                <p>STEP 1 To 3</p>
                                <h2 class="mt-3 font-weight-bold">SELECT YOUR PLAN THATS RIGHT FOR YOU</h2>
                                <p class="st">Downgrade or upgrade at any time</p>
                            </div>
                </div>
                            
                        </div>
                    <div class="row text-center">
                    <table style="width:100%;">
    <tr colspan="3" style="background-color:#f3f3f3;padding:10px;">
      <th></th>
      <th>Basic</th>
      <th>Standard</th>
      <th>Premium</th>
      
    </tr>
                        <tr>
                            <td>Monthly price</td>
                            <td>$199</td>
                            <td>$499</td>
                            <td>$799</td>
                            
                        </tr>
                        
                        <tr>
                            <td>HD available</td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                        </tr>
                        <hr>
                        <tr>
                            <td>Ultra HD available</td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>Watch on your laptop and TV</td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                        </tr>
                         <tr>
                            <td>Watch on your moblie phone and tablet</td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                        </tr>
                         <tr>
                            <td>Screens you can watch on at the same time</td>
                            <td>1</td>
                            <td>3</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Umlimited movies and tv shows</td>
                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                        </tr>
                         <tr>
                            <td>Cancel anytime</td>
                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                        </tr>
                       
                    </table>
                         <hr>
                        </div>
                  <!--  <div class="row">
                        <div class="col-sm-6 p-0">
                            <p class="mt-5"></p>
                            <p>Monthly price</p>
                            <p>HD available</p>
                            <p>Ultra HD available </p>
                            <p>Watch on your laptop and TV</p>
                            <p>Watch on your moblie phone and tablet</p>
                            <p>Screens you can watch on at the same time</p>
                            <p>Umlimited movies and tv shows</p>
                            <p>Cancel anytime</p>
                            <p></p>
                        </div>
                        <div class="col-sm-2 xv ">
                            <p>Basic</p>
                            <p>$199</p>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <div class="d-flex flex-column">
                            <i class="fa fa-times" aria-hidden="true"></i>
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <p class="pt-3 mt-2">1</p>
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <i class="fa fa-times" aria-hidden="true"></i>
                               
                                
                            </div>
                        </div>
                        <div class="col-sm-2 xv">
                            <p>Standard</p>
                            <p>$499</p>
                            <i class="fa fa-times" aria-hidden="true"></i>
                             <div class="d-flex flex-column">
                            <i class="fa fa-times" aria-hidden="true"></i>
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <i class="fa fa-times" aria-hidden="true"></i>
                               <p class="pt-3 mt-2">2</p>
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <i class="fa fa-times" aria-hidden="true"></i>
                               
                                
                            </div>
                        </div>
                        <div class="col-sm-2 xv">
                            <p>Premium</p>
                            <p>$499</p>
                            <i class="fa fa-check" aria-hidden="true"></i>
                             <div class="d-flex flex-column">
                           <i class="fa fa-check" aria-hidden="true"></i>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                   <i class="fa fa-check" aria-hidden="true"></i>
                                   <p class="pt-3 mt-2">5</p>
                                   <i class="fa fa-check" aria-hidden="true"></i>
                                   <i class="fa fa-check" aria-hidden="true"></i>
                               
                                
                            </div>
                        </div>
                        
                    </div>-->
                    <p class="st">HD and Ultra HD avaliblity subject to your internet service and device capabilities.Not all content available in HD or Ultra HD. See Terms of Use for more details.</p>
                    <div class="tyk1 text-center">
                      
					<a type="button" herf="">CONTINUE</a>
                    
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
</body>

</html> 

