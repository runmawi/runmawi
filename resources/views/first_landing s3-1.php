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
	        
             <section class="mt-5 pt-4 Step33">
                <div class="text-center">
                                <p>STEP 3 To 3</p>
                                <h2 class="mt-3 font-weight-bold">STEP UP YOUR CREDIT OR <br>DEBIT CARD.</h2>
                                
                            </div>
                 <div class="col-sm-4 mt-2 tyk">
                                     <form>
                          <div class="form-group">

                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="NAME">
                          </div>
                                          <div class="form-group">

                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="lAST NAME">
                          </div>
                                          <div class="form-group">

                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="CARD NUMBER">
                          </div>
                                          <div class="form-group">

                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="EXPIRY DATE(MM/YY)">
                          </div>
                                          <div class="form-group">

                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="SECURITY CODE(CVV)">
                          </div>
                     </form>
                </div>
                     <div class="d-flex lk1 col-sm-4 justify-content-around p-0 ">
                         <div>
                              <p class="stk">Premium plan:$799.00</p>
                         </div>
                         <div class="">
                            <a>Change plan</a>
                     </div></div>
                 <div class="d-fle check justify-content-center">
                      <input type="checkbox" id="" name="vehicle1" value="">
                     <labe>In many cases, the signup page is the last step in a business’s conversion funnel. It’s where prospects navigate after they’ve evaluated a brand and decided its service offers what they need
                     </labe>
                 </div>
                       <div class="tyk step2 text-center">
                      
					<a type="button" herf="">START WATCHING NOW</a>
                    
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

