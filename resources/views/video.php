
<!doctype html>
<html lang="en-US">
   <head>
      <!-- Required meta tags -->
       <meta name="csrf-token" content="<?php echo csrf_token();?>">
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<!--<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
      <!-- Favicon -->
      <link rel="shortcut icon" href="<?php echo URL::to('/'). '/assets/images/fl-logo.png';?>" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/typography.css';?>" />
      <!-- Style -->
      <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/style.css';?>" />
      <!-- Responsive -->
      <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/responsive.css';?>" />
        <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/noty.css';?>" />
        <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/font-awesome.mim.css
        ';?>" />
        <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/hellovideo-fonts.css';?>" />
        <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/rrssb.css';?>" />
        <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/style.css';?>" />
        <link rel="stylesheet" href="<?php echo URL::to('/'). '/assets/css/animate.min.css';?>" />
         
  <link href="<?php echo URL::to('/').'/assets/dist/video-js.min.css';?>" rel="stylesheet">
	<link href="<?php echo URL::to('/').'/assets/dist/videojs-watermark.css';?>" rel="stylesheet">
	<link href="<?php echo URL::to('/').'/assets/dist/videojs-resolution-switcher.css';?>" rel="stylesheet">
  <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.css" rel="stylesheet">
  <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet">
      
       <script src="https://www.paypalobjects.com/api/checkout.js"></script>
 


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
    .social_share {
    display: inline-block !important;
    border-radius: 5px !important;
    vertical-align: middle !important;
}
    .rrssb-buttons.tiny-format li {
    padding-right: 7px;
}
    .rrssb-buttons li {
    float: left;
    height: 100%;
    line-height: 13px;
    list-style: none;
    margin: 0;
    padding: 0 2.5px;
}
    .video-details {
    margin: 0 auto !important;
    padding-bottom: 30px !important;
        padding-left: 40px !important;
}
    .social_share p {
    display: inline-block;
    font-weight: 700;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
}
    .favorites-slider .slick-next, #trending-slider-nav .slick-next {
    color: var(--iq-white);
    right: 20px;
    top: -12px;
}
    #social_share {
    display: inline-block;
    vertical-align: middle;
}
    #video_title h1 {
    color: #fff;
    font-size: 30px;
    margin: 20px 0px;
    line-height: 22px;
}
    .btn.watchlater, .btn.mywishlist {
    font-weight: 600;
    font-family: 'Roboto', sans-serif;
    font-size: 15px;
    background: #000;
    border: 1px solid #000;
    color: #fff;
}
    a.ytp-impression-link {
    display: none !important;
}
    .ytp-impression-link {
        display: none !important;
    }
.vjs-texttrack-settings { display: none; }
.video-js .vjs-big-play-button{ border: none !important; }
    #video_container{height: auto;padding-top: 20px !important;;width: 95%;margin: 0 auto;}
/*    #video_bg_dim {background: #1a1b20;}*/
    .video-js .vjs-tech {outline: none;}
    
   
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
    .btn.btn-default.views {
    color: #fff !important;
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
     <!-- <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
      <!-- loader END -->
        <?php include('header.php');?>
   
   <input type="hidden" name="video_id" id="video_id" value="<?php echo  $video->id;?>">
   <input type="hidden" name="current_time" id="current_time" value="<?php if(isset($watched_time)) { echo $watched_time; } else{ echo "0";}?>">
   
<?php
    // print_r($watched_time);
   if(!Auth::guest()) {  
   if ( $ppv_exist > 0  || Auth::user()->subscribed() || Auth::user()->role == 'admin' || Auth::user()->role =="subscriber" || (!Auth::guest() && $video->access == 'registered' && Auth::user()->role == 'registered')) { ?>

	<div id="video_bg">
		<div class=" page-height">
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
						<!--<h2>Up Next</h2>-->
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
						<!--<h2>Up Next</h2>-->
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
		<div class="container-fluid video-details">
			<div id="video_title">
				<h1><?php echo __($video->title);?> <?php if( Auth::guest() ) { ?>  <?php } ?></h1>
			</div>
        
   <?php if(!Auth::guest()) { ?>

		<div class="row">
			<div class="col-sm-6 col-md-6 col-xs-12 d-flex justify-content-around">     
			<!-- Watch Later -->
                <div>
			<div class="watchlater btn btn-default <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div></div>
<div>
			<!-- Wish List -->            
			<div class="mywishlist btn btn-default <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>
</div>
			<!-- Share -->
			<div class="social_share p-1 d-flex justify-content-around align-items-center">
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
<!--			<div class="social_share">
			  <p><i class="fa fa-share-alt"></i> <?/*php echo __('Share')*/;?>: </p>
			  <div id="social_share">
				<?php/* include('partials/social-share.php');*/ ?>
			  </div>
			</div>-->
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

   <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>-->
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
        $(".slider").not('.slick-initialized').slick({

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
   <!-- <script type=”text/javascript” src=”//cdn.jsdelivr.net/afterglow/latest/afterglow.min.js”></script>-->
        <!-- back-to-top End -->
      <!-- jQuery, Popper JS -->
      <script src="<?php echo URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>
      <script src="<?php echo URL::to('/'). '/assets/js/popper.min.js';?>"></script>
      <!-- Bootstrap JS -->
      <script src="<?php echo URL::to('/'). '/assets/js/bootstrap.min.js';?>"></script>
      <!-- Slick JS -->
      <script src="<?php echo URL::to('/'). '/assets/js/slick.min.js';?>"></script>
      <!-- owl carousel Js -->
      <script src="<?php echo URL::to('/'). '/assets/js/owl.carousel.min.js';?>"></script>
      <!-- select2 Js -->
      <script src="<?php echo URL::to('/'). '/assets/js/select2.min.js';?>"></script>
      <!-- Magnific Popup-->
      <script src="<?php echo URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <script src="<?php echo URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <script src="<?php echo URL::to('/'). '/assets/js/custom.js';?>"></script>
    </body>
</html>

