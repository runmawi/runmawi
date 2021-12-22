<?php include('videolayout/episode_header.php');?>
<?php include('header.php'); ?>

<input type="hidden" value="<?php echo URL::to('/');?>" id="base_url" >
<input type="hidden" id="videoslug" value="<?php if(isset($episode->path)) { echo $episode->path; } else{ echo "0";}?>">
	<div id="series_bg">
		<div class="">
			
			<?php 
			if(!Auth::guest()){
			if($episode->access == "ppv" && !empty($episode->ppv_price) || !empty($episode->ppv_price) && Auth::user()->role == 'registered'
			|| !empty($episode->ppv_price) && Auth::user()->role == 'subscriber' || !empty($episode->ppv_price) && Auth::guest()){
			if($episode->access == 'guest' || ( ($episode->access == 'subscriber' || $episode->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $episode->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>

				
					<?php if($episode->type == 'embed'): ?>
						<div id="series_container" class="fitvid">
							<?= $episode->embed_code ?>
						</div>
					<?php  elseif($episode->type == 'file'): ?>
						<div id="series_container">
						<video id="Player"   class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $episode->image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

							<source src="<?= $episode->mp4_url; ?>" type='video/mp4' label='auto' >
							<source src="<?= $episode->webm_url; ?>" type='video/webm' label='auto' >
							<source src="<?= $episode->ogg_url; ?>" type='video/ogg' label='auto' >
							<?php  if(isset($episodesubtitles)){
							foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
							<track kind="captions" src="<?= $episodesubtitles_file->url; ?>" srclang="<?= $episodesubtitles_file->sub_language; ?>" label="<?= $episodesubtitles_file->shortcode; ?>" default>
							<?php } } ?>
							<p class="vjs-no-js">To view this series please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 series</a></p>
						</video>
						</div>
					<?php  else: ?>
						<div id="series_container">
						<video id="Player"    class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
                           
							<source src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '_1_500.m3u8'; ?>" type='application/x-mpegURL' label='360p' res='360' />
								<source src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '_0_250.m3u8'; ?>" type='application/x-mpegURL' label='480p' res='480'/>
									<source src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/> 
<!--
						<php foreach ($episoderesolutions as $key => $episoderesolution_file) { ?>
							<source src="<= $episoderesolution_file->url; ?>" type='video/mp4' label='<= $episoderesolution_file->quality; ?>p' res='<= $episoderesolution_file->quality; ?>p'/>
						<php } ?>
						
						<php if(isset($episodesubtitles)){
						foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
							<track kind="captions" src="<= $episodesubtitles_file->url; ?>" srclang="<= $episodesubtitles_file->sub_language; ?>" label="<= $episodesubtitles_file->shortcode; ?>" default>
						<php }  }
						?>
-->
						
						</video>
						</div>
					<?php endif; ?>
				

			<?php else: ?>

				<div id="subscribers_only">
					<h2>Sorry, this series is only available to <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
					<div class="clear"></div>
					<?php if(!Auth::guest() && $series->access == 'subscriber'): ?>
						<form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
							<button id="button">Become a subscriber to watch this episode</button>
						</form>
					<?php else: ?>
						<form method="get" action="<?= URL::to('signup') ?>">
							<button id="button">Signup Now <?php if($series->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($series->access == 'registered'): ?>for Free!<?php endif; ?></button>
						</form>
					<?php endif; ?>
				</div>
			
			<?php endif; 
			}else{ ?>
 <div id="subscribers_only"style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $episode->image ?>);background-position:center; background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
					<div id="ppv">
				<h2>Purchase to Watch the Episodes <?php if($episode->access == 'subscriber'): ?>Subscribers<?php elseif($episode->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
				<div class="clear"></div>
				<?php if(!Auth::guest() ): ?>
					<form method="get" action="<?= URL::to('/')?>/user/<?= Auth::user()->username ?>/upgrade_subscription">
						<button id="button">Purchase to Watch <?php $currency->symbol.' '.$episode->ppv_price ?></button>
					</form>
				<?php else: ?>

				<?php endif; ?>
			</div>
		<?php } }
			?>
		</div>
	</div>

<input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $episode->genre_id ?>" value="<?= $episode->genre_id ?>">
<br>

	<div class="container series-details">
	<div id="series_title">
		<div class="container">
            <div class="row">
                <div class="col-md-6">
			<span class="text-white" style="font-size: 129%;font-weight: 700;">You're watching:</span> <p style=";font-size: 130%;color: white;"><?= $episode->title ?></p>
		
	</div>
                
		<!---<h3 style="color:#000;margin: 10px;"><?= $episode->title ?>
            

		</h3>-->
                <div class="col-md-2 text-center text-white">
<span class="view-count" style="float:right;"><i class="fa fa-eye"></i> <?php if(isset($view_increment) && $view_increment == true ): ?><?= $episode->views + 1 ?><?php else: ?><?= $episode->views ?><?php endif; ?> Views </span></div>
                <div class="col-md-4">
           <div class="watchlater btn btn-default text-white <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-episodeid="<?= $episode->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div>
			<div class="mywishlist btn btn-default text-white  <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-episodeid="<?= $episode->id ?>" style="margin-left:10px;"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>
			
            <br>
			</div>
			
        </div>
<!-- <div class="clear" style="display:flex;justify-content: space-between;
    align-items: center;">
    <div> -->
		<h2 id="tags">Tags: 
		<?php if(isset($episode->tags)) {
		foreach($episode->tags as $key => $tag): ?>

			<span><a href="/episode/tag/<?= $tag->name ?>"><?= $tag->name ?></a></span><?php if($key+1 != count($episode->tags)): ?>,<?php endif; ?>

		<?php endforeach; }
		?>
            
		</h2>
        </div>

		
		<div class="series-details-container"><?= $episode->details ?></div>

		<?php if(isset($episodenext)){ ?>
		<div class="next_episode" style="display: none;"><?= $episodenext->id ?></div>
		<div class="next_url" style="display: none;"><?= $url ?></div>
		<?php }elseif(isset($episodeprev)){ ?>
		<div class="prev_episode" style="display: none;"><?= $episodeprev->id ?></div>
		<div class="next_url" style="display: none;"><?= $url ?></div>
		<?php } ?>

		<div class="iq-main-header container d-flex align-items-center justify-content-between">
  <h4 class="main-title">Season</h4>                      
</div>
<div class="favorites-contens">
  <ul class="favorites-slider list-inline  row p-0 mb-0">
    <?php  
	foreach($season as $key => $seasons):
      foreach($seasons->episodes as $key => $episodes):
		if($episodes->id != $episode->id): ?>
        <li class="slide-item p-2">
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('episodes') : URL::to('episode').'/'.@$episodes->series_title->title.'/'.$episodes->title; ?>">
				<div class="thumbnail-overlay"></div>
<!--				<img src="<= ImageHandler::getImage($episodes->image, 'medium')  ?>">-->
				<img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" width="200">
				<div class="details">
				<h4><?= $episodes->title; ?> <span><br><?= gmdate("H:i:s", $episodes->duration); ?></span></h4>
				</div></a>
              <div class="block-contents">
			  <p class="date" style="color:#fff;"><?= date("F jS, Y", strtotime($episodes->created_at)); ?>
				<?php if($episodes->access == 'guest'): ?>
				<span class="label label-info">Free</span>
				<?php elseif($episodes->access == 'subscriber'): ?>
				<span class="label label-success">Subscribers Only</span>
				<?php elseif($episodes->access == 'registered'): ?>
				<span class="label label-warning">Registered Users</span>
				<?php endif; ?>
				</p>
				<p class="desc"><?php if(strlen($episodes->description) > 90){ echo substr($episodes->description, 0, 90) . '...'; } else { echo $episodes->description; } ?></p>
                <!-- <div class="movie-time d-flex align-items-center my-2"> -->
                  <!-- <div class="badge badge-secondary p-1 mr-2">13+</div>
                  <span class="text-white"><i class="fa fa-clock-o"></i> <?// gmdate('H:i:s', $latest_serie->duration); ?></span>
                </div> -->
                <!-- <div class="hover-buttons">
                  <a class="btn btn-primary btn-hover" href="<?php //echo URL::to('/play_series'.'/'.$latest_serie->title) ?>/<?// $latest_serie->id ?>" >
                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                    Play Now
                  </a>
                </div> -->
				<!-- </div> -->
          <!-- </a> -->
        </li>
		<?php endif; endforeach; ?>
      <?php endforeach; 
     ?>
  </ul>
</div>
</div>
 </div>
		<div class="clear">
		<h2 id="tags">
		<?php if(isset($episode->tags)) {
		foreach($episode->tags as $key => $tag): ?>

			<span><a href="/episode/tag/<?= $tag->name ?>"><?= $tag->name ?></a></span><?php if($key+1 != count($episode->tags)): ?>,<?php endif; ?>

		<?php endforeach; }
		?>
		</h2>

		<div class="clear"></div>
		<div id="social_share">
	    	<!--<p>Share This episode:</p>
			<?php /*include('partials/social-share.php'); */?>-->
		</div>
            </div>
			

           

       
		<div class="clear"></div>

		
    
	
	
	    <script type="text/javascript"> 
        videojs('Player').videoJsResolutionSwitcher(); 
    </script>
  
	<script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'Flicknexs';

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    
<?php include('footer.blade.php'); ?>

