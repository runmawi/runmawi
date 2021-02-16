<?php include('header.php'); ?>
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
    #video_container{height: auto;overflow: auto;padding: 15px 0 !important;width: 80%;margin: 0 auto;}
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
    

</style>

<!-- unpkg : use the latest version of Video.js -->
<link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
<script src="https://unpkg.com/video.js/dist/video.min.js"></script>

<!-- unpkg : use a specific version of Video.js (change the version numbers as necessary) -->
<link href="https://unpkg.com/video.js@7.8.2/dist/video-js.min.css" rel="stylesheet">
<script src="https://unpkg.com/video.js@7.8.2/dist/video.min.js"></script>

<!-- cdnjs : use a specific version of Video.js (change the version numbers as necessary) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video-js.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video.min.js"></script>
    <style>
    
        .vjs-skin-hotdog-stand { color: #FF0000; }
        .vjs-skin-hotdog-stand .vjs-control-bar { background: #FFFF00; }
        .vjs-skin-hotdog-stand .vjs-play-progress { background: #FF0000; }
    
    </style>
	<div id="series_title">
		<div class="container">
			<span class="label">You're watching:</span> <h1><?= $series->title ?></h1>
		</div>
	</div>


	<div id="series_bg">
		<div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
		<div class="container">
			
			<?php if($series->access == 'guest' || ( ($series->access == 'subscriber' || $series->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $series->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>

				
					<?php if($series->type == 'embed'): ?>
						<div id="series_container" class="fitvid">
							<?= $series->embed_code ?>
						</div>
					<?php  elseif($series->type == 'file'): ?>
						<div id="series_container">
<!--						<video id="video_player"  autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<= URL::to('/') . '/public/uploads/images/' . $series->image; ?>" data-setup="{}" width="100%" style="width:100%;">-->
                            
                            <video id="video_player" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $series->image; ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

							<source src="<?= URL::to('/').'/storage/app/public/'.$series->mp4_url; ?>" type='video/mp4' label='auto' >
							<source src="<?= URL::to('/').'/storage/app/public/'.$series->webm_url; ?>" type='video/webm' label='auto' >
							<source src="<?= URL::to('/').'/storage/app/public/'.$series->ogg_url; ?>" type='video/ogg' label='auto' >
							<?php foreach ($seriessubtitles as $key => $seriessubtitles_file) { ?>
							<track kind="captions" src="<?= $seriessubtitles_file->url; ?>" srclang="<?= $seriessubtitles_file->sub_language; ?>" label="<?= $seriessubtitles_file->shortcode; ?>" default>
							<?php } ?>
							<p class="vjs-no-js">To view this series please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 series</a></p>
						</video>
						<div class="playertextbox hide">
						<h2>Up Next</h2>
						<p><?php if(isset($episodenext)){ ?>
						      <?= Episode::where("id","=",$episodenext->id)->pluck('title'); ?>
						<?php }?></p>
						</div>
						</div>
					<?php  else: ?>
						<div id="series_container">
						<video id="video_player" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $series->image; ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
                            
                            <source src="<?= URL::to('/').'/storage/app/public/'.$series->mp4_url; ?>" type='video/mp4' label='auto' >
<!--
						<php foreach ($seriesresolution as $key => $seriesresolution_file) { ?>
							<source src="<= $seriesresolution_file->url; ?>" type='video/mp4' label='<= $seriesresolution_file->quality; ?>p' res='<= $seriesresolution_file->quality; ?>p'/>
						<php } ?>
-->
						
						<?php if(isset($seriessubtitles)){
						foreach ($seriessubtitles as $key => $seriessubtitles_file) { ?>
							<track kind="captions" src="<?= $seriessubtitles_file->url; ?>" srclang="<?= $seriessubtitles_file->sub_language; ?>" label="<?= $seriessubtitles_file->shortcode; ?>" default>
						<?php }  }
						?>
						
						</video>
						<div class="playertextbox hide">
						<h2>Up Next</h2>
						<p><?php if(isset($episodenext)){ ?>
						<?= App\Episode::where("id","=",$episodenext->id)->pluck('title'); ?>
						<?php }?></p>
						</div>
						</div>
					<?php endif; ?>
				

			<?php else: ?>

				<div id="subscribers_only">
					<h2>Sorry, this series is only available to <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
					<div class="clear"></div>
					<?php if(!Auth::guest() && $series->access == 'subscriber'): ?>
						<form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
							<button id="button">Become a subscriber to watch this series</button>
						</form>
					<?php else: ?>
						<form method="get" action="<?= URL::to('signup') ?>">
							<button id="button">Signup Now <?php if($series->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($series->access == 'registered'): ?>for Free!<?php endif; ?></button>
						</form>
					<?php endif; ?>
				</div>
			
			<?php endif; ?>
		</div>
	</div>
<input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $series->genre_id ?>" value="<?= $series->genre_id ?>">

	<div class="container series-details">


		<div class="series-details-container"><?= $series->details ?></div>
		<?php if(isset($episodenext)){ ?>
		<div class="next_episode" style="display: none;"><?= $episodenext->id ?></div>
		<div class="next_url" style="display: none;"><?= $url ?></div>
		<?php }?>

		<?php
		foreach($season as $key => $seasons): ?>
			<h4 style="color:#000;">Season <?= $key+1; ?></h4>
			<?php foreach($seasons->episodes as $key => $episodes): ?>
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
				<article class="block">
				<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('episodes') : URL::to('episodes') ?><?= '/' . $episodes->id ?>">
				<div class="thumbnail-overlay"></div>
				<span class="play-button"></span>
				<img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>">
				<div class="details">
				<h2><?= $episodes->title; ?> <span><?= gmdate("H:i:s", $episodes->duration); ?></span></h2>
				</div>
				</a>
				<div class="block-contents">
				<p class="date"><?= date("F jS, Y", strtotime($episodes->created_at)); ?>
				<?php if($episodes->access == 'guest'): ?>
				<span class="label label-info">Free</span>
				<?php elseif($episodes->access == 'subscriber'): ?>
				<span class="label label-success">Subscribers Only</span>
				<?php elseif($episodes->access == 'registered'): ?>
				<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
				</p>
				<p class="desc"><?php if(strlen($episodes->description) > 90){ echo substr($episodes->description, 0, 90) . '...'; } else { echo $episodes->description; } ?></p>
				</div>
				</article>
				</div>
			<?php endforeach; ?>
				<div class="clear"></div>

		<?php endforeach; ?>
		<div class="clear"></div>
<!--
		<h2 id="tags">Tags: 
		<php if(isset($series->tags)) {
		foreach($series->tags as $key => $tag): ?>

			<span><a href="/series/tag/<= $tag->name ?>"><= $tag->name ?></a></span><php if($key+1 != count($series->tags)): ?>,<php endif; ?>

		<php endforeach; }
		?>
		</h2>
-->

		<div class="clear"></div>
		<div id="social_share">
	    	<p>Share This series:</p>
			<?php include('partials/social-share.php'); ?>
		</div>

		<div class="clear"></div>

		<div id="comments">
			<div id="disqus_thread"></div>
		</div>
    
	</div>
	
		
	<script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'cosman';

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the comments</noscript> 

	<script src="<?= URL::to('/assets/js/jquery.fitvid.js'); ?>"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			$('#series_container').fitVids();
			$('.favorite').click(function(){
				if($(this).data('authenticated')){
					$.post('/favorite', { series_id : $(this).data('seriesid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');
				} else {
					window.location = '<?= URL::to('signup') ?>';
				}
			});
			//watchlater
			$('.watchlater').click(function(){
				if($(this).data('authenticated')){
					$.post('/watchlater', { series_id : $(this).data('seriesid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');

				} else {
					window.location = '<?= URL::to('signup') ?>';
				}
			});

			//My Wishlist
			$('.mywishlist').click(function(){
				if($(this).data('authenticated')){
					$.post('/mywishlist', { series_id : $(this).data('seriesid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');

				} else {
					window.location = '<?= URL::to('signup') ?>';
				}
			});

		});

	</script>

	<!-- RESIZING FLUID series for series JS -->
	<script type="text/javascript">
	  // Once the series is ready
	  _V_("video_player").ready(function(){

	    var myPlayer = this;    // Store the series object
	    var aspectRatio = 9/16; // Make up an aspect ratio

	    function resizeVideoJS(){
	    	console.log(myPlayer.id);
	      // Get the parent element's actual width
	      var width = document.getElementById('series_container').offsetWidth;
	      // Set width to fill parent element, Set height
	      myPlayer.width(width).height( width * aspectRatio );
	    }

	    resizeVideoJS(); // Initialize the function
	    window.onresize = resizeVideoJS; // Call the function on resize
	  });
	</script>

	<script src="<?= URL::to('/assets/js/rrssb.min.js'); ?>"></script>
	<script src="<?= URL::to('/assets/js/videojs-resolution-switcher.js');?>"></script>
	<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>


  	<script>
	   var player = videojs('video_player').videoJsResolutionSwitcher({
	        default: '480p', // Default resolution [{Number}, 'low', 'high'],
	        dynamicLabel: true
	      })
	  $(".playertextbox").appendTo($('#video_player'));
	  var res = player.currentResolution();
	  player.currentResolution(res);
	  function autoplay1() {
    	
    	var playButton = document.getElementsByClassName("vjs-big-play-button")[0];
		playButton.setAttribute("id", "myPlayButton");
	    var next_episode_id = $(".next_episode").text();
	    var prev_episode_id = $(".prev_episode").text();
	    
	    var url = $(".next_url").text();
	    if(next_episode_id != ''){

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
         	window.location = "http://localhost/saka/"+url+"/"+next_episode_id;
         }, 3000);
	    }else if(prev_episode_id != ''){
	    	
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
         	window.location = "http://localhost/cosman/"+url+"/"+prev_episode_id;
         }, 3000);
	    
	    }

	    
 	}

 	/*on episode Play*/
// 	function playstart() {
// 		if($(this).data('authenticated')){
//			$.post('/watchedvideos', { episode_id : '<= $episodes->id ?>', _token: '<= csrf_token(); ?>' }, function(data){});
//			$.post('/recommendedcategories', { seriescategoryid : $('.seriescategoryid').data('seriescategoryid'), _token: '<= csrf_token(); ?>' }, function(data){});
//
//		} else {
//			$.post('/recommendedcategories', { seriescategoryid : $('.seriescategoryid').data('seriescategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});
//		}
// 	}
  </script>
<?php include('footer.blade.php'); ?>