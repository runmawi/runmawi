<!--<?php include('header.php');?>-->
<!doctype html>
<html lang="en-US">
   <head>
      <!-- Required meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/fl-logo.png" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />


<script src="https://www.paypalobjects.com/api/checkout.js"></script>
 
<meta name="csrf-token" content="<?php echo csrf_token();?>">

<style type="text/css">
.video-js{height: 500px !important;}
.video-js *, .video-js :after, .video-js :before {box-sizing: inherit;display: grid;}
.vjs-big-play-button{
top: 50% !important;
left: 50% !important;
margin: -25px 0 0 -25px;
width: 50px !important;
height: 50px !important;
border-radius: 25px !important;
}
.vjs-texttrack-settings { display: none; }
.video-js .vjs-big-play-button{ border: none !important; }
    #video_container{height: auto;padding: 15px 0 !important;width: 95%;margin: 0 auto;}
/*    #video_bg_dim {background: #1a1b20;}*/
    .video-js .vjs-tech {outline: none;}
    
    .video-details{margin: 0 auto;padding-bottom: 30px;}
    .video-details h1{margin: 0 0 10px;color: #fff;}
    .vid-details{margin-bottom: 20px;}
    #tags{margin-bottom: 10px;}
    .share{display: flex;align-items: center;}
    .share span, .share a{display: inline-block;text-align: center;font-size: 20px;padding-right: 20px;color: #fff;}
    .share a{padding: 0 20px;}
    .cat-name span{margin-right: 10px;}
    .video-js .vjs-seek-button.skip-back.skip-10::before,
    .video-js.vjs-v6 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before,
    .video-js.vjs-v7 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before {
      content: '\e059'
    }

</style>

  
  <link href="<?php echo URL::to('/').'/assets/dist/video-js.min.css';?>" rel="stylesheet">
	<link href="<?php echo URL::to('/').'/assets/dist/videojs-watermark.css';?>" rel="stylesheet">
	<link href="<?php echo URL::to('/').'/assets/dist/videojs-resolution-switcher.css';?>" rel="stylesheet">
  <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.css" rel="stylesheet">
  <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet">
  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
  <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>
    <style>
    
        .vjs-skin-hotdog-stand { color: #FF0000; }
        .vjs-skin-hotdog-stand .vjs-control-bar { background: #FFFF00; }
        .vjs-skin-hotdog-stand .vjs-play-progress { background: #FF0000; }
        .rent-card{
            width: 120% !important;
             height: 30px !important;
        }
    
		/*.video-js .vjs-watermark-top-right {right:<=Right();?> ;top: <=Top();?>;bottom: <=Bottom();?>;left;<=Left();?>;}
		.video-js .vjs-watermark-content {opacity: <=Opacity();?>;}
		.vjs-menu-button-popup .vjs-menu {width: auto;}*/
	</style>
	   </head>
    <body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      <!-- Header -->
      <header id="main-header">
         <div class="main-header">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12">
                     <nav class="navbar navbar-expand-lg navbar-light p-0">
                        <a href="#" class="navbar-toggler c-toggler" data-toggle="collapse"
                           data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                           aria-expanded="false" aria-label="Toggle navigation">
                           <div class="navbar-toggler-icon" data-toggle="collapse">
                              <span class="navbar-menu-icon navbar-menu-icon--top"></span>
                              <span class="navbar-menu-icon navbar-menu-icon--middle"></span>
                              <span class="navbar-menu-icon navbar-menu-icon--bottom"></span>
                           </div>
                        </a>
                        <a class="navbar-brand" href="index.html"> <img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs"> </a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                           <div class="menu-main-menu-container">
<!--                              <ul id="top-menu" class="navbar-nav ml-auto">
                                 <li class="menu-item">
                                    <a href="index.html">Home</a>
                                 </li>
                                 <li class="menu-item">
                                    <a href="show-category.html">Tv Shows</a>
                                 </li>
                                 <li class="menu-item">
                                    <a href="movie-category.html">Movies</a>
                                 </li>
                              </ul>-->
                               <ul id="top-menu" class="nav navbar-nav <?php if ( Session::get('locale') == 'arabic') { echo "navbar-right"; } else { echo "navbar-left";}?>">
                                          <?php
                                        $stripe_plan = SubscriptionPlan();
                                        $menus = App\Menu::all();
                                        $languages = App\Language::all();
                                        foreach ($menus as $menu) { 
                                        if ( $menu->in_menu == "video") { 
                                        $cat = App\VideoCategory::all();
                                        ?>
                                          <li class="dropdown menu-item">
                                            <a class="dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
                                              <?php echo __($menu->name);?> <!--<i class="fa fa-angle-down"></i>-->
                                            </a>
                                            <ul class="dropdown-menu categ-head">
                                              <?php foreach ( $cat as $category) { ?>
                                              <li>
                                                <a class="dropdown-item cont-item" href="<?php echo URL::to('/').'/category/'.$category->slug;?>"> 
                                                  <?php echo $category->name;?> 
                                                </a>
                                              </li>
                                              <?php } ?>
                                            </ul>
                                          </li>
                                          <?php } else { ?>
                                          <li class="menu-item">
                                            <a href="<?php echo URL::to('/').$menu->url;?>">
                                              <?php echo __($menu->name);?>
                                            </a>
                                          </li>
                                          <?php } } ?>
                                          <li class="nav-item dropdown menu-item">
                                            <a class="dropdown-toggle" href="<?php echo URL::to('/').$menu->url;?>" data-toggle="dropdown">  
                                              Movies <!--<i class="fa fa-angle-down"></i>-->
                                            </a>
                                              <ul class="dropdown-menu categ-head">
                                                  <?php foreach ( $languages as $language) { ?>
                                                  <li>
                                                    <a class="dropdown-item cont-item" href="<?php echo URL::to('/').'/language/'.$language->id.'/'.$language->name;?>"> 
                                                      <?php echo $language->name;?> 
                                                    </a>
                                                  </li>

                                                <?php } ?>
                                                </ul>
                                            </li>
                                          <li class="blink_me">
                                            <a href="<?php echo URL::to('refferal') ?>" style="color: #fd1b04;list-style: none;
                                                                                               font-weight: bold;
                                                                                               font-size: 16px;">
                                              <?php echo __('Refer and Earn');?>
                                            </a>
                                          </li>
                                        </ul>
                           </div>
                        </div>
                        <div class="mobile-more-menu">
                           <a href="javascript:void(0);" class="more-toggle" id="dropdownMenuButton"
                              data-toggle="more-toggle" aria-haspopup="true" aria-expanded="false">
                           <i class="ri-more-line"></i>
                           </a>
                           <div class="more-menu" aria-labelledby="dropdownMenuButton">
                              <div class="navbar-right position-relative">
                                 <ul class="d-flex align-items-center justify-content-end list-inline m-0">
                                    
                                <li class="hidden-xs">
                                          <div id="navbar-search-form">
                                            <form role="search" action="<?php echo URL::to('/').'/searchResult';?>" method="POST">
                                              <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
                                              <div>
                                                <i class="fa fa-search">
                                                </i>
                                                <input type="text" name="search" class="searches" id="searches" autocomplete="off" placeholder="Search">
                                              </div>
                                            </form>
                                          </div>
                                          <div id="search_list" class="search_list" style="position: absolute;">
                                          </div> 
                                        </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="navbar-right menu-right">
                           <ul class="d-flex align-items-center list-inline m-0">
                              <li class="nav-item nav-icon">
                                 <a href="#" class="search-toggle device-search">
                                 <i class="ri-search-line"></i>
                                 </a>
                                 <div class="search-box iq-search-bar d-search">
                                    <form action="#" class="searchbox">
                                       <div class="form-group position-relative">
                                          <input type="text" class="text search-input font-size-12"
                                             placeholder="type here to search...">
                                          <i class="search-link ri-search-line"></i>
                                       </div>
                                    </form>
                                 </div>
                              </li>
                              <li class="nav-item nav-icon">
                                 <a href="#" class="search-toggle" data-toggle="search-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                       class="noti-svg">
                                       <path fill="none" d="M0 0h24v24H0z" />
                                       <path
                                          d="M18 10a6 6 0 1 0-12 0v8h12v-8zm2 8.667l.4.533a.5.5 0 0 1-.4.8H4a.5.5 0 0 1-.4-.8l.4-.533V10a8 8 0 1 1 16 0v8.667zM9.5 21h5a2.5 2.5 0 1 1-5 0z" />
                                    </svg>
                                    <span class="bg-danger dots"></span>
                                 </a>
                                 <div class="iq-sub-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body">
                                          <a href="#" class="iq-sub-card">
                                             <div class="media align-items-center">
                                                <img src="assets/images/notify/thumb-1.jpg" class="img-fluid mr-3"
                                                   alt="streamit" />
                                                <div class="media-body">
                                                   <h6 class="mb-0 ">Boot Bitty</h6>
                                                   <small class="font-size-12"> just now</small>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="#" class="iq-sub-card">
                                             <div class="media align-items-center">
                                                <img src="assets/images/notify/thumb-2.jpg" class="img-fluid mr-3"
                                                   alt="streamit" />
                                                <div class="media-body">
                                                   <h6 class="mb-0 ">The Last Breath</h6>
                                                   <small class="font-size-12">15 minutes ago</small>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="#" class="iq-sub-card">
                                             <div class="media align-items-center">
                                                <img src="assets/images/notify/thumb-3.jpg" class="img-fluid mr-3"
                                                   alt="streamit" />
                                                <div class="media-body">
                                                   <h6 class="mb-0 ">The Hero Camp</h6>
                                                   <small class="font-size-12">1 hour ago</small>
                                                </div>
                                             </div>
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="nav-item nav-icon">
                                 <a href="#" class="iq-user-dropdown search-toggle p-0 d-flex align-items-center"
                                    data-toggle="search-toggle">
                                 <img src="assets/images/user/user.jpg" class="img-fluid avatar-40 rounded-circle" alt="user">
                                 </a>
                                 <div class="iq-sub-dropdown iq-user-dropdown">
                                    <div class="iq-card shadow-none m-0">
                                       <div class="iq-card-body p-0 pl-3 pr-3">
                                          <a href="manage-profile.html" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-file-user-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Manage Profile</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="setting.html" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-settings-4-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Settings</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="pricing-plan.html" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-settings-4-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Pricing Plan</h6>
                                                </div>
                                             </div>
                                          </a>
                                          <a href="login.html" class="iq-sub-card setting-dropdown">
                                             <div class="media align-items-center">
                                                <div class="right-icon">
                                                   <i class="ri-logout-circle-line text-primary"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                   <h6 class="mb-0 ">Logout</h6>
                                                </div>
                                             </div>
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </nav>
                     <div class="nav-overlay"></div>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- Header End -->
   <input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
   <input type="hidden" name="current_time" id="current_time" value="<?php if(isset($watched_time)) { echo $watched_time; } else{ echo "0";}?>">
   
<?php
    // print_r($watched_time);
   if(!Auth::guest()) {  
   if ( $ppv_exist > 0  || Auth::user()->subscribed() || Auth::user()->role == 'admin' || Auth::user()->role =="subscriber" || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered')) { ?>

	<div id="video_bg">
		<div class="container page-height">
			<?php 
            $paypal_id = Auth::user()->paypal_id;
            if (!empty($paypal_id) && !empty(PaypalSubscriptionStatus() )  ) {
            $paypal_subscription = PaypalSubscriptionStatus();
            } else {
              $paypal_subscription = "";  
            }
            if($ppv_exist > 0  || Auth::user()->subscribed() || $paypal_subscription =='CANCE' || $video->access == 'guest' || ( ($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() ) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>
          <?php if($video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $video->embed_code ?>
						</div>
					<?php  elseif($video->type == 'file'): ?>
						<div id="video_container" class="fitvid">
						<video id="videojs-seek-buttons-player"  autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/public/') . '/uploads/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

							<source src="<?php echo URL::to('/storage/app/public/').'/'.$video->mp4_url; ?>" type='video/mp4' label='auto' >
							<source src="<?php echo URL::to('/storage/app/public/').'/'.$video->webm_url; ?>" type='video/webm' label='auto' >
							<source src="<?php echo URL::to('/storage/app/public/').'/'.$video->ogg_url; ?>" type='video/ogg' label='auto' >
							
							<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
						</video>
						<div class="playertextbox hide">
						<h2>Up Next</h2>
						<p><?php if(isset($videonext)){ ?>
						<?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
						<?php }elseif(isset($videoprev)){ ?>
						<?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
						<?php } ?>

						<?php if(isset($videos_category_next)){ ?>
						<?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
						<?php }elseif(isset($videos_category_prev)){ ?>
						<?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
						<?php } ?></p>
						</div>
						</div>
					<?php  else: ?>
						<div id="video_container" class="fitvid" atyle="z-index: 9999;">
						<video id="videojs-seek-buttons-player" onplay="playstart()" onended="autoplay1()" autoplay class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
						
						<source src="<?php echo URL::to('/storage/app/public/').'/'.$video->mp4_url; ?>" type='video/mp4' label='auto' >
						
						</video>
							

						<div class="playertextbox hide">
						<h2>Up Next</h2>
						<p><?php if(isset($videonext)){ ?>
						<?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
						<?php }elseif(isset($videoprev)){ ?>
						<?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
						<?php } ?>

						<?php if(isset($videos_category_next)){ ?>
						<?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
						<?php }elseif(isset($videos_category_prev)){ ?>
						<?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
						<?php } ?></p>
						</div>
						</div>
					<?php endif; ?>
				

			<?php else: ?>

				<div id="subscribers_only">
					<h2>Sorry, this video is only available to <?php if($video->access == 'subscriber'): ?>Subscribers<?php elseif($video->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
					<div class="clear"></div>
					<?php if(!Auth::guest() && $video->access == 'subscriber'): ?>
						<form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
							<button id="button">Become a subscriber to watch this video</button>
						</form>
					<?php else: ?>
						<form method="get" action="<?= URL::to('signup') ?>">
							<button id="button">Signup Now <?php if($video->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($video->access == 'registered'): ?>for Free!<?php endif; ?></button>
						</form>
					<?php endif; ?>
				</div>
			
			<?php endif; ?>            
		</div>
	</div>

  <?php }  
    else { ?>       
		<div id="video_container" class="fitvid">
			<video id="videojs-seek-buttons-player" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/public/uploads/') . '/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
				<source src="<?= $video->trailer; ?>" type='video/mp4' label='auto' >
			</video> 
						
		</div>
	<?php } } ?>
	<?php if(Auth::guest()) {  ?>
		<div id="video_container" class="fitvid">
				<video id="videojs-seek-buttons-player" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/public/uploads/') . '/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

			 <source src="<?= $video->trailer; ?>" type='video/mp4' label='auto' >
			  </video>  
		</div>
	<?php } ?>
            

	<input type="hidden" class="videocategoryid" data-videocategoryid="<?= $video->video_category_id ?>" value="<?= $video->video_category_id ?>">
		<div class="container video-details">
			<div id="video_title">
				<h1><?php echo __($video->title);?> <?php if( Auth::guest() ) { ?>  <?php } ?></h1>
			</div>
        
   <?php if(!Auth::guest()) { ?>

		<div class="row">
			<div class="col-sm-6 col-md-6 col-xs-12">     
			<!-- Watch Later -->
			<div class="watchlater btn btn-default <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div>

			<!-- Wish List -->            
			<div class="mywishlist btn btn-default <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>

			<!-- Share -->
			<div class="social_share">
			  <p><i class="fa fa-share-alt"></i> <?php echo __('Share');?>: </p>
			  <div id="social_share">
				<?php include('partials/social-share.php'); ?>
			  </div>
			</div>
        </div>
			<div class="col-sm-6 col-md-6 col-xs-12">
			<!-- Views -->
			 <div class="btn btn-default views">
				<span class="view-count"><i class="fa fa-eye"></i> 
				<?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> </span>
			</div> 
                <?php     
                    $user = Auth::user(); 
                    if (  ($user->role!="subscriber" && $user->role!="admin") ) { ?>
                        <div class="views" style="margin: 0 12px;">
                            <a href="<?php echo URL::to('/becomesubscriber');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                         </div>
                    <?php } ?>
                
                <?php if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin")  ) { ?>
                
                    <div class="views" style="margin: 0 12px;"> 
                      
                    <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                     <?php echo __('Rent');?> </button>
                   </div> 
<!--                  <div id="paypal-button"></div>-->
                <?php } ?>
                
              
		</div> 
       </div>
        <?php   }?> 
            
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">Rent Now</h4>
           
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-sm-2" style="width:52%;">
                    <span id="paypal-button"></span> 
                  </div>
                  
                  <div class="col-sm-4">
                    <a onclick="pay(<?php echo PvvPrice();?>)">
                        <img src="<?php echo URL::to('/assets/img/card.png');?>" class="rent-card">
                    </a>
                  </div>
              </div>                    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"  data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
        
   <?php if(Auth::guest()) { ?>
  
		<div class="row">
			<div class="col-sm-8 col-md-8 col-xs-12">     
			<!-- Watch Later -->
			<div class="watchlater btn btn-default <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div>

			<!-- Wish List -->            
			<div class="mywishlist btn btn-default <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>

			<!-- Share -->
			<div class="social_share">
			  <p><i class="fa fa-share-alt"></i> <?php echo __('Share');?>: </p>
			  <div id="social_share">
				<?php include('partials/social-share.php'); ?>
			  </div>
			</div>
        </div>
			<div class="col-sm-4 col-md-4 col-xs-12">
			<!-- Views -->
			 <div class="btn btn-default views">
				<span class="view-count"><i class="fa fa-eye"></i> 
				<?php if(isset($view_increment) && $view_increment == true ): ?><?= $movie->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> </span>
			</div> 
                
                        <div class="btn views" style="margin: 0 12px; padding: 0;">
                            <a href="<?php echo URL::to('/login');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                         </div>
               
                    <div class="btn views" style="margin: 0 12px;padding: 0;">
                     <a class="view-count btn btn-primary rent-video" href="<?php echo URL::to('/login');?>">
                     <?php echo __('Rent');?> </a>
<!--                    <div id="paypal-button"></div>-->
                   </div> 
                
              
		</div> 
       </div>
        <?php   }?>
		<div class="row">
        <div class="vid-details col-sm-12 col-md-12 col-xs-12">
            <p class="cat-name">
                <span><?php echo __($video->title); ?></span> <span><?php if ($video->year == 0) { echo ""; } else { echo $video->year;} ?></span>
            </p>
        </div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="video-details-container"><?php echo __($video->description); ?></div>
			</div>
		</div>
		<?php if(isset($videonext)){ ?>
		<div class="next_video" style="display: none;"><?= $videonext->slug ?></div>
		<div class="next_url" style="display: none;"><?= $url ?></div>
		<?php }elseif(isset($videoprev)){ ?>
		<div class="prev_video" style="display: none;"><?= $videoprev->slug ?></div>
		<div class="next_url" style="display: none;"><?= $url ?></div>
		<?php } ?>

		<?php if(isset($videos_category_next)){ ?>
		<div class="next_cat_video" style="display: none;"><?= $videos_category_next->slug ?></div>
		<?php }elseif(isset($videos_category_prev)){ ?>
		<div class="prev_cat_video" style="display: none;"><?= $videos_category_prev->slug ?></div>
		<?php } ?>

		<div class="clear"></div>
<!--
		<div id="tags">Tags: 
		<php foreach($video->tags as $key => $tag): ?>
			<span><a href="/videos/tag/<= $tag->name ?>"><= $tag->name ?></a></span><php if($key+1 != count($video->tags)): ?>,<php endif; ?>
		<php endforeach; ?>
		</div>
-->
        
    <div class="video-list you-may-like">
            <h4 class="Continue Watching" style="color:#fffff;"><?php echo __('Recomended Videos');?></h4>
                <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>   
                <?php include('partials/video-loop.php');?>
                </div>
		
    </div>

		<div class="clear"></div>
        <script>
            //$(".share a").hide();
            $(".share").on("mouseover", function() {
            $(".share a").show();
            }).on("mouseout", function() {
            $(".share a").hide();
            });
        </script>

		<!--<div class="clear"></div>

		<div id="comments">
			<div id="disqus_thread"></div>
		</div>-->
    
	</div>
	
    <noscript>Please enable JavaScript to view the comments</noscript> 

	<script src="<?= THEME_URL . '/assets/js/jquery.fitvid.js'; ?>"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			$('#video_container').fitVids();
			$('.favorite').click(function(){
				if($(this).data('authenticated')){
					$.post('<?= URL::to('favorite') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');
				} else {
					window.location = '<?= URL::to('login') ?>';
				}
			});
			//watchlater
			$('.watchlater').click(function(){
                
                         toastr.options = {
                              "closeButton": true,
                              "newestOnTop": true,
                              "positionClass": "toast-top-right"
                            };
				if($(this).data('authenticated')){
					$.post('<?= URL::to('watchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){
                         toastr.success(data.success);
                    });
					$(this).toggleClass('active');
					$(this).html("");
			        if($(this).hasClass('active')){
			          $(this).html('<a><i class="fa fa-check"></i>Watch Later</a>');
			        }else{
			          $(this).html('<a><i class="fa fa-clock-o"></i>Watch Later</a>');
			        }
				} else {
					window.location = '<?= URL::to('login') ?>';
				}
			});

			//My Wishlist
			$('.mywishlist').click(function(){
                       toastr.options = {
                              "closeButton": true,
                              "newestOnTop": true,
                              "positionClass": "toast-top-right"
                            };
                
				if($(this).data('authenticated')){
					$.post('<?= URL::to('mywishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){
                        toastr.success(data.success);
                    });
					$(this).toggleClass('active');
					$(this).html("");
			        if($(this).hasClass('active')){
			          $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
			        }else{
			          $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
			        }
			        
				} else {
					window.location = '<?= URL::to('login') ?>';
				}
			});

		});

	</script>

	<!-- RESIZING FLUID VIDEO for VIDEO JS -->
	

	<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
	<script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
	<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>


  <script>
     var player = videojs('video_player').videoJsResolutionSwitcher({
        default: '480p', // Default resolution [{Number}, 'low', 'high'],
        dynamicLabel: true
      })
	$(".playertextbox").appendTo($('#video_player'));

  // var res = player.currentResolution();
  // player.currentResolution(res);
 
    function autoplay1() {
    	
    	var playButton = document.getElementsByClassName("vjs-big-play-button")[0];
		playButton.setAttribute("id", "myPlayButton");
	    var next_video_id = $(".next_video").text();
	    var prev_video_id = $(".prev_video").text();
	    var next_cat_video = $(".next_cat_video").text();
	    var prev_cat_video = $(".prev_cat_video").text();
	    var url = $(".next_url").text();
	    if(next_video_id != ''){

	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/"+url+"/"+next_video_id;
         }, 3000);
	    }else if(prev_video_id != ''){
	    	
	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/"+url+"/"+prev_video_id;
         }, 3000);
	    
	    }

	    if(next_cat_video != ''){

	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/videos_category/"+next_cat_video;
         }, 3000);
	    }else if(prev_cat_video != ''){
	    	
	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/videos_category/"+prev_cat_video;
         }, 3000);
	    
	    }
 	}

 	/*on video Play*/
 	function playstart() {
 		// if($("#video_player").data('authenticated')){
		// 	$.post('<?= URL::to('watchhistory');?>', { video_id : '<?= $video->id ?>', _token: '<?= csrf_token(); ?>' }, function(data){});
		// 	$.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});

		// } else {
		// 	$.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});
		// }
    $(".vjs-big-play-button").hide();
 	}
  </script>


     <script type="text/javascript">

            $(document).ready(function(){
                $('a.block-thumbnail').click(function(){
                    var myPlayer = videojs('video_player');
                    var duration = myPlayer.currentTime();

                    $.post('<?= URL::to('watchhistory');?>', { video_id : '<?= $video->id ?>', _token: '<?= csrf_token(); ?>', duration : duration }, function(data){});
                }); 
            });

      </script>
<link href=”//vjs.zencdn.net/7.0/video-js.min.css” rel=”stylesheet”>
<script src=”//vjs.zencdn.net/7.0/video.min.js”></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
   <!-- <script src="https://vjs.zencdn.net/7.8.3/video.js"></script> -->
    <script src="<?= THEME_URL .'/assets/dist/video.js'; ?>"></script>
  	<script src="<?= THEME_URL .'/assets/dist/videojs-resolution-switcher.js'; ?>"></script>
  	<script src="<?= THEME_URL .'/assets/dist/videojs-watermark.js'; ?>"></script>
<script>
	videojs('videojs-seek-buttons-player', {
    controls: true,
    plugins: {
      videoJsResolutionSwitcher: {
        default: 'low', // Default resolution [{Number}, 'low', 'high'],
        dynamicLabel: true
      }
    }
  }, function(){
    var player = this;
    window.player = player
    player.updateSrc([
      {
        src: '<?= $video->trailer; ?>',
        type: 'video/mp4',
        label: 'SD',
        res: 360
      },
      {
        src: '<?= $video->trailer; ?>',
        type: 'video/mp4',
        label: 'HD',
        res: 720
      }
    ])
    player.on('resolutionchange', function(){
      console.info('Source changed to %s', player.src())
    })
  })
        
</script>
<!--<script src="https://vjs.zencdn.net/7.7.5/video.js"></script>
<script>
var vid = document.getElementById("videojs-seek-buttons-player");
vid.onloadeddata = function() {

    // get the current players AudioTrackList object
    var player = videojs('videojs-seek-buttons-player')
    let tracks = player.audioTracks();

    alert(tracks.length);

    for (let i = 0; i < tracks.length; i++) {
        let track = tracks[i];
        console.log(track);
        alert(track.language);
    }
};
</script>-->

<script type="text/javascript">
      $(document).ready(function () {  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      });
 
  function pay(amount) {
      var video_id = $('#video_id').val();
      var handler = StripeCheckout.configure({
      key: 'pk_test_hxll2Q2MS8MLeJRXvQNMpob400sNowtGx7',
      locale: 'auto',
      token: function (token) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.
        console.log('Token Created!!');
        console.log(token);
        $('#token_response').html(JSON.stringify(token));
        
        $.ajax({
          url: '<?php echo URL::to("/stripe-payment");?>',
          method: 'post',
          data: { tokenId: token.id, amount: amount , video_id: video_id },
          success: (response) => {
            $("#exampleModalCenter").hide();
            swal("You have done  Payment !");
             
            setTimeout(function() {
                     location.reload();
                }, 2000);
 
          },
          error: (error) => {
            swal(response);
            swal("Oops! Something went wrong");
              
            setTimeout(function() {
                   location.reload();
                }, 2000);
          }
        })
      }
    });
      
  
    handler.open({
      name: 'Finexs',
      description: 'PAY PAR VIEW',
      amount: amount * 100
    });
  }
</script>



  <script>
        $(".slider").slick({

    // normal options...
    infinite: false,

    // the magic
    responsive: [{

        breakpoint: 1024,
        settings: {
            slidesToShow: 3,
            infinite: true
        }

    }, {

        breakpoint: 600,
        settings: {
            slidesToShow: 2,
            dots: true
        }

    }, {

        breakpoint: 300,
    settings: "unslick" // destroys slick

    }]
    });
    </script>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
 <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>
<script>
    
var video_id = $("#video_id").val();
var base_url = $('#base_url').val();
  paypal.Button.render({
    // Configure environment
    env: 'production',
    client: {
      sandbox: 'AV2oMI0qYdrSeWT0_pPlLDndkePRY5VFyLDhu7hPkvzYEVgrLLzFCOsYAMz0K4hOpEPTrMKAadNJwwA9',
      production: 'Aclkx_Wa7Ld0cli53FhSdeDt1293Vss8nSH6HcSDQGHIBCBo42XyfhPFF380DjS8N0qXO_JnR6Gza5p2'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,
    // Set up a payment
   payment: function(data, actions) {
          return actions.payment.create({
            transactions: [{
              amount: {
                total: '0.01',
                currency: 'USD'
              }
            }]
          });
        },
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
            // Show a confirmation message to the buyer
            //window.alert('Thank you for your purchase!');
             $.post(base_url+'/rentpaypal', {
                 video_id:video_id , _token: '<?= csrf_token(); ?>' 
               }, 
                function(data){
                    $("#exampleModalCenter").hide();
                    setTimeout(function() {
                    location.reload();
                        //window.location.replace(base_url+'/login');
                        
                  }, 2000);
            });
      });
    }
  }, '#paypal-button');

</script>

  <script>
    // fire up the plugin
    videojs('video_player', {
	  playbackRates: [0.5, 1, 1.5, 2],
      controls: true,
      muted: true,
      width: 991,
      fluid: true,
      plugins: {
        videoJsResolutionSwitcher: {
		  ui: true,
          default: 'low', // Default resolution [{Number}, 'low', 'high'],
          dynamicLabel: true
        }
      }
    }, function(){
      var player = this;
      window.player = player
	  player.watermark({
        image: '',
		fadeTime: null,
        url: ''
      });
    });
  </script>


      <script>
        (function(window, videojs) {
            
          var examplePlayer = window.examplePlayer = videojs('videojs-seek-buttons-player');
          var seekButtons = window.seekButtons = examplePlayer.seekButtons({
            forward: 10,
            back: 10
          });
        }(window, window.videojs));
      </script>

    <script src="<?php echo URL::to('/').'/assets/js/videojs.hotkeys.js';?>"></script>
    <script>
        
      videojs('videojs-seek-buttons-player').ready(function() {
        this.hotkeys({
          volumeStep: 0.1,
          seekStep: 10,
          enableMute: true,
          enableFullscreen: true,
          enableNumbers: false,
          enableVolumeScroll: true,
          enableHoverScroll: true,

          // Mimic VLC seek behavior, and default to 5.
          seekStep: function(e) {
            if (e.ctrlKey && e.altKey) {
              return 5*60;
            } else if (e.ctrlKey) {
            
              return 60;
            } else if (e.altKey) {
              return 10;
            } else {               
              return 5;
            }
          },

          // Enhance existing simple hotkey with a complex hotkey
          fullscreenKey: function(e) {
            // fullscreen with the F key or Ctrl+Enter
            return ((e.which === 70) || (e.ctrlKey && e.which === 13));
          },

          // Custom Keys
          customKeys: {

            // Add new simple hotkey
            simpleKey: {
              key: function(e) {
                // Toggle something with S Key
                return (e.which === 83);
              },
              handler: function(player, options, e) {
                // Example
                if (player.paused()) {
                  player.play();
                } else {
                  player.pause();
                }
              }
            },

            // Add new complex hotkey
            complexKey: {
              key: function(e) {
                // Toggle something with CTRL + D Key
                return (e.ctrlKey && e.which === 68);
              },
              handler: function(player, options, event) {
                // Example
                if (options.enableMute) {
                  player.muted(!player.muted());
                }
              }
            },

            // Override number keys example from https://github.com/ctd1500/videojs-hotkeys/pull/36
            numbersKey: {
              key: function(event) {
                // Override number keys
                return ((event.which > 47 && event.which < 59) || (event.which > 95 && event.which < 106));
              },
              handler: function(player, options, event) {
                // Do not handle if enableModifiersForNumbers set to false and keys are Ctrl, Cmd or Alt
                if (options.enableModifiersForNumbers || !(event.metaKey || event.ctrlKey || event.altKey)) {
                  var sub = 48;
                  if (event.which > 95) {
                    sub = 96;
                  }
                  var number = event.which - sub;
                  player.currentTime(player.duration() * number * 0.1);
                }
              }
            },

            emptyHotkey: {
              // Empty
            },

            withoutKey: {
              handler: function(player, options, event) {
                  console.log('withoutKey handler');
              }
            },

            withoutHandler: {
              key: function(e) {
                  return true;
              }
            },

            malformedKey: {
              key: function() {
                console.log('I have a malformed customKey. The Key function must return a boolean.');
              },
              handler: function(player, options, event) {
          
              }
            }
          }
        });
      });
        
    var video = videojs('videojs-seek-buttons-player');

    video.on('pause', function() {
      this.bigPlayButton.show();
        $(".vjs-big-play-button").show();
        video.one('play', function() {
        this.bigPlayButton.hide();
      });
    });
 
$(document).ready(function () { 
    $(window).on("beforeunload", function() { 

        var vid = document.getElementById("videojs-seek-buttons-player_html5_api");
        var currentTime = vid.currentTime;
        var videoid = video_id;
            $.post('<?= URL::to('continue-watching') ?>', { video_id : videoid,currentTime:currentTime, _token: '<?= csrf_token(); ?>' }, function(data){
                      //    toastr.success(data.success);
            });
      // localStorage.setItem('your_video_'+video_id, currentTime);
        return;
    }); });

    var current_time = $('#current_time').val();
    var myPlayer = videojs('videojs-seek-buttons-player_html5_api');
    var duration = myPlayer.currentTime(current_time);
    </script>
    <script type=”text/javascript” src=”//cdn.jsdelivr.net/afterglow/latest/afterglow.min.js”></script>
    </body>
</html>

<?php include('footer.blade.php');?>