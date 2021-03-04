<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="HelloVideo Admin Panel" />
	<meta name="author" content="" />

	<title><?php $settings = App\Setting::first(); echo $settings->website_name;?></title>

	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css'; ?>">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/font-icons/entypo/css/entypo.css'; ?>">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/font-icons/font-awesome/css/font-awesome.min.css'; ?>">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/bootstrap.css'; ?>">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/animate.min.css'; ?>">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/core.css'; ?>">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/theme.css'; ?>">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/forms.css'; ?>">
	<link rel="stylesheet" href="<?= THEME_URL .'/assets/admin/admin/css/custom.css'; ?>">
    <script src="<?= THEME_URL ?>/assets/js/admin-homepage.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	@yield('css')

	<script src="<?= THEME_URL .'/assets/admin/admin/js/jquery-1.11.0.min.js'; ?>"></script>
	<script src="<?= THEME_URL .'/assets/admin/admin/js/bootstrap-colorpicker.min.js'; ?>" id="script-resource-13"></script>
	<script src="<?= THEME_URL .'/assets/admin/admin/js/vue.min.js'; ?>"></script>
	
	<script>$.noConflict();</script>

	<!--[if lt IE 9]><script src="<?= THEME_URL .'/assets/admin/admin/js/ie8-responsive-file-warning.js'; ?>"></script><![endif]-->

	<!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js') }}/1.4.2/respond.min.js') }}"></script>
	<![endif]-->
<style>

    .top-left-logo img {
        opacity: 0.9;
        overflow: hidden;
    }
    
    
</style>

</head>
<body class="page-body skin-black">


<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<div class="sidebar-menu page-right-in">

		<div class="sidebar-menu-inner">
			
			<header class="logo-env">


				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>

								
				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>

			</header>
							
			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<li class="active">
					<a href="{{ URL::to('admin') }}">
						<i class="entypo-gauge"></i>
						<span class="title">Dashboard</span>
					</a>
				</li>
				<li class="">
					<a href="{{ URL::to('admin/videos') }}">
						<i class="entypo-video"></i>
						<span class="title">Video Management</span>
					</a>
					<ul>
			           <li>
							<a href="{{ URL::to('admin/videos') }}">
								<span class="title">All Videos</span>
							</a>
						</li>
						<li>
							<a href="{{ URL::to('admin/videos/create') }}">
								<span class="title">Add New Video</span>
							</a>
						</li>
						
                        <li>
							<a href="{{ URL::to('admin/videos/categories') }}">
								<span class="title">Manage Video Categories</span>
							</a>
						</li>
                        
                    
					</ul>
				</li>
	
                
                
                
                <li class="">
					<a href="{{ URL::to('admin/livestream') }}">
						<i class="fa fa-money"></i>
						<span class="title"> Manage Live Videos</span>
					</a>
					<ul>
			             <li>
							<a href="{{ URL::to('admin/livestream') }}">
								<span class="title">All Live Videos</span>
							</a>
						</li>
						<li>
							<a href="{{ URL::to('admin/livestream/create') }}">
								<span class="title">Add New Live Video</span>
							</a>
						</li>
						
                        <li>
							<a href="{{ URL::to('admin/livestream/categories') }}">
								<span class="title">Manage Live Video Categories</span>
							</a>
						</li>
                        
                        
                    
					</ul>
				</li>

				<li class="">
					<a href="{{ URL::to('admin/menu') }}">
						<i class="entypo-list"></i>
						<span class="title">Menu</span>
					</a>
				</li>
                <li class="">
					<a href="{{ URL::to('admin/languages') }}">
						<i class="entypo-list"></i>
						<span class="title">Manage Languages </span>
					</a>
                    
                    <ul>
			             <li>
							<a href="{{ URL::to('admin/admin-languages') }}">
								<span class="title">Video Languages</span>
							</a>
						 </li> 
                        
                         <li>
							<a href="{{ URL::to('admin/languages') }}">
								<span class="title">Manage Translations</span>
							</a>
						 </li>
                        
                        <li>
							<a href="{{ URL::to('admin/admin-languages-transulates') }}">
								<span class="title">Manage Transulate Languages</span>
							</a>
						</li>
						
                    
					</ul>
                    
                    
				</li>
                 <li>
							<a href="{{ URL::to('admin/countries') }}">
                                <i class="entypo-list"></i>
								<span class="title">Manage Countries</span>
							</a>
				</li>
				<li> 
					<a href="{{ URL::to('admin/sliders') }}">
						<i class="entypo-docs"></i>
						<span class="title">Manage Sliders</span>
					</a>
				</li>
				<li class="">
					<a href="{{ URL::to('admin/users') }}">
						<i class="entypo-users"></i>
						<span class="title">Users</span>
					</a>
					<ul>
						<li>
							<a href="{{ URL::to('admin/users') }}">
								<span class="title">All Users</span>
							</a>
						</li>
						<li>
							<a href="{{ URL::to('admin/user/create') }}">
								<span class="title">Add New User</span>
							</a>
						</li>
                        
                        <li>
							<a href="{{ URL::to('admin/roles') }}">
								<span class="title">Add User Roles</span>
							</a>
						</li>
                        
                       
					</ul>
				</li>
				
				
				<li class="">
					<a href="{{ URL::to('admin/pages') }}">
						<i class="fa fa-file"></i>
						<span class="title">Pages</span>
					</a>
					<ul>
						<li>
							<a href="{{ URL::to('admin/pages') }}">All Pages</a>
						</li>
						
	            	</ul>
				</li>
				<li> 
					<a href="{{ URL::to('admin/plans') }}">
						<i class="entypo-cc-nd"></i>
						<span class="title">Plans</span>
					</a>
					<ul>
                        <li> <a href="{{ URL::to('admin/plans') }}">
								<span class="title">Manage Stripe plans</span>
							</a>
						</li>
                        <li> <a href="{{ URL::to('admin/paypalplans') }}">
								<span class="title">Manage Paypal plans</span>
							</a>
						</li>
                        
                        <li> <a href="{{ URL::to('admin/coupons') }}">
								<span class="title">Manage Stripe Coupons</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="">
					<a href="{{ URL::to('admin/settings') }}">
						<i class="entypo-cog"></i>
						<span class="title">Settings</span>
					</a>
					<ul>
                        <li class="">
							<a href="{{ URL::to('admin/mobileapp') }}">
								<span class="title">Mobile App Settings</span>
							</a>
						</li>
                        
						<li class="">
							<a href="{{ URL::to('admin/settings') }}">
								<span class="title">Site Settings</span>
							</a>
						</li>
                        
						<li class="">
							<a href="{{ URL::to('admin/payment_settings') }}">
								<span class="title">Payment Settings</span>
							</a>
						</li>
                        
                        <li class="">
							<a href="{{ URL::to('admin/home-settings') }}">
								<span class="title">HomePage Settings</span>
							</a>
						</li>
                        
                        <li class="">
							<a href="{{ URL::to('admin/system_settings') }}">
								<span class="title">System Settings</span>
							</a>
						</li>
<!--
                        
                        <li class="">
							<a href="{{ URL::to('admin/mobile_app') }}">
								<span class="title">Mobile App</span>
							</a>
						</li>
-->

						<li class="">
							<a href="{{ URL::to('admin/theme_settings') }}">
								<span class="title">Theme Settings</span>
							</a>
						</li>
					</ul>
				</li>
						
				
			</ul>
    
			
		</div>

	</div>

	<div class="main-content">
				
		<div class="row">
		
			<!-- Profile Info and Notifications -->
			<div class="col-md-6 col-sm-8 clearfix">
                <!-- logo -->
                <?php
                $settings = App\Setting::first();
                ?>
				    <a href="{{ URL::to('/') }}">
	                   <img src="{{ Url::to('/public/uploads/settings') }}/{{ $settings->logo ?? '' }}" />
					</a>
		
			</div>

		
			<!-- Raw Links -->
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
				<ul class="list-inline links-list pull-right">
					<li class="profile">
							<span>Hello, <?php echo Auth::user()->username;?></span>
					</li>

					<li>
						<a href="{{ URL::to('/') }}" target="_blank">
							<span class="label label-info" style="font-size:12px">View My Site <i class="entypo-export right"></i></span>
						</a>
					</li>

					<li class="sep"></li>
		
					<li>
						<a href="{{ URL::to('logout') }}">
							Log Out <i class="entypo-logout right"></i>
						</a>
					</li>
				</ul>
		
			</div>
		
		</div>
		
		<hr />

		<div id="main-admin-content">

			@yield('content')

		</div>
		
		<!-- Footer -->
		<footer class="main">
			
			Copyright © <?php echo date("Y"); ?> <strong><?php  echo $settings->website_name;?></strong>, Inc
		
		</footer>
	</div>
	
	
</div>

	<!-- Sample Modal (Default skin) -->
	<div class="modal fade" id="sample-modal-dialog-1">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Widget Options - Default Modal</h4>
				</div>
				
				<div class="modal-body">
					<p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Sample Modal (Skin inverted) -->
	<div class="modal invert fade" id="sample-modal-dialog-2">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Widget Options - Inverted Skin Modal</h4>
				</div>
				
				<div class="modal-body">
					<p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Sample Modal (Skin gray) -->
	<div class="modal gray fade" id="sample-modal-dialog-3">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Widget Options - Gray Skin Modal</h4>
				</div>
				
				<div class="modal-body">
					<p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>




	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ Url::to('/assets/admin/js/jvectormap/jquery-jvectormap-1.2.2.css') }}">
	<link rel="stylesheet" href="{{ Url::to('/assets/admin/js/rickshaw/rickshaw.min.css') }}">

	<!-- Bottom scripts (common) -->
	<script src="{{ Url::to('/assets/admin/js/gsap/main-gsap.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/bootstrap.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/joinable.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/resizeable.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>


	<!-- Imported scripts on this page -->
	<script src="{{ Url::to('/assets/admin/js/jvectormap/jquery-jvectormap-europe-merc-en.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/jquery.sparkline.min.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/rickshaw/vendor/d3.v3.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/rickshaw/rickshaw.min.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/raphael-min.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/morris.min.js') }}"></script>
	<script src="{{ Url::to('/assets/admin/js/toastr.js') }}"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="{{ Url::to('/assets/admin/js/custom.js') }}"></script>


	<!-- Demo Settings -->
	<script src="{{ Url::to('/assets/admin/js/main.js') }}"></script>

	<!-- Notifications -->
	<script>
		var opts = {
			"closeButton": true,
			"debug": false,
			"positionClass": "toast-top-right",
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};

		<?php if(Session::get('note') != '' && Session::get('note_type') != ''): ?>
	        
	        if('<?= Session::get("note_type") ?>' == 'success'){
	        	toastr.success('<?= Session::get("note") ?>', "Sweet Success!", opts);
	        } else if('<?= Session::get("note_type") ?>' == 'error'){
	        	toastr.error('<?= Session::get("note") ?>', "Whoops!", opts);
	        }
	        <?php Session::forget('note');
	              Session::forget('note_type');
	        ?>
	    <?php endif; ?>

	    function display_mobile_menu(){
	    	if($(window).width() < 768){
	    		$('.sidebar-collapsed').removeClass('sidebar-collapsed');
	    	}
	    }

	    $(document).ready(function(){
	    	display_mobile_menu();
	    });
		
	</script>
	<!-- End Notifications -->

	@yield('javascript')


</body>
</html>