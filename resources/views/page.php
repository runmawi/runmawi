
<?php include('header.php'); ?>
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
    .page{
        margin-top: 100px;
        min-height: 540px;
    }
    a {
    color: var(--iq-body-text) !important;
}
    .container-fluid, .container-lg, .container-md, .container-sm, .container-xl {
    padding-right: 0px
    }
    .navbar-right.menu-right {
    margin-right: -150px !important;
}


</style>

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
      <scriptsrc="<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>
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
      <scriptsrc="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <script src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <script src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>

<?php include('footer.blade.php'); ?>