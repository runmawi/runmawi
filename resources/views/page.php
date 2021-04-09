
  <?php include('header.php');?>
   <head>
      <!-- Required meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
 <!-- Favicon -->
      <link rel="shortcut icon" href="<?= URL::to('/'). '/assets/images/fl-logo.png';?>" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
      <!-- Typography CSS -->
      <link rel="stylesheet"href="<?= URL::to('/'). '/assets/css/typography.css';?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" />
      <!-- Responsive -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/responsive.css';?>" />

<style>
     .h-100 {
    height: 540px !important;
}
           .blink_me {
    animation: blinker 2s linear infinite;
  }
  @keyframes blinker {
    50% {
      opacity: 0;
    }
  }
    .page-height{
        margin-top: 100px;
        min-height: 540px;
    }
   /* a {
    color: var(--iq-body-text) !important;
}*/
   /* .container-fluid, .container-lg, .container-md, .container-sm, .container-xl {
    padding-right: 0px
    }*/
   /* .navbar-right.menu-right {
    margin-right: -150px !important;
}*/


</style></head>
      


	<div class="container">

		<div class="row page-height">
			<div class="col-md-2 page page-height">

				<ul class="nav flex-column">
					<?php foreach($pages as $page): ?>
                        <?php if ( $page->slug != 'promotion' ){ 
								$url = $_SERVER['REQUEST_URI'];
								$id = substr(strrchr(rtrim($url, '/'), '/'), 1);
					?>
							<li class="<?php if ($page->slug == $id ){echo 'active'; } ?> "><a href="<?php echo URL::to('page'); ?><?= '/' . $page->slug ?>"><?= __($page->title) ?></a></li>
                        <?php } ?>
					<?php endforeach; ?>
					
				  </ul>

			</div>

			<div class="col-md-10 page ">

						<h2 class="vid-title text-left"><?php echo __($pager->title); ?></h2>
						<div class="border-line"></div>

						<div class="page-body">
							<?php echo __($pager->body); ?>
						</div>

			</div>

		</div>
    

	</div>     
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
      <!-- Magnific Popup-->
      <script src="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <script src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <script src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>

 <?php include('footer.blade.php');?>

   
    