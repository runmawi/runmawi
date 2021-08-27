<?php include('videolayout/episode_header.php');?>
<?php include('header.php'); ?>

<input type="hidden" value="<?php echo URL::to('/');?>" id="base_url" >
<input type="hidden" id="videoslug" value="<?php if(isset($episode->path)) { echo $episode->path; } else{ echo "0";}?>">
	<div id="series_bg">
		<div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
		<div class="container">
			
			<?php if($series->access == 'guest' || ( ($series->access == 'subscriber' || $series->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $series->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>

				
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
			
			<?php endif; ?>
		</div>
	</div>

<input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $series->genre_id ?>" value="<?= $series->genre_id ?>">
<br>

	<div class="container series-details">
	<div id="series_title">
		<div class="container">
			<span class="label" style="font-size: 129%;font-weight: 700;">You're watching:</span> <p style="margin-left: 5% !important;font-size: 130%;color: white;"><?= $episode->title ?></p>
		</div>
	</div>
		<h3 style="color:#000;margin: 10px;">

           <div class="watchlater btn btn-default <?php if(isset($watchlatered->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-episodeid="<?= $episode->id ?>"><?php if(isset($watchlatered->id)): ?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-clock-o"></i><?php endif; ?> Watch Later</div>
			<div class="mywishlist btn btn-default <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-episodeid="<?= $episode->id ?>" style="margin-left:10px;"><?php if(isset($mywishlisted->id)): ?><i class="fa fa-check"></i>Wishlisted<?php else: ?><i class="fa fa-plus"></i>Add Wishlist<?php endif; ?> </div>
			<span class="view-count" style="float:right;"><i class="fa fa-eye"></i> <?php if(isset($view_increment) && $view_increment == true ): ?><?= $episode->views + 1 ?><?php else: ?><?= $episode->views ?><?php endif; ?> Views </span>
            <br>
			
			<?= $episode->title ?>
            

		</h3>

<div class="clear" style="display:flex;justify-content: space-between;
    align-items: center;">
    <div>
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

		<?php
		foreach($season as $key => $seasons): ?>
			<h4 style="color:#fff;">Season <?= $key+1; ?></h4>
 <div class="d-flex mt-3">
			<?php foreach($seasons->episodes as $key => $episodes): 
				if($episodes->id != $episode->id):?>
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 new-art">
				<article class="block">
				<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('episodes') : URL::to('episodes') ?><?= '/' . $episodes->id ?>">
				<div class="thumbnail-overlay"></div>
<!--				<img src="<= ImageHandler::getImage($episodes->image, 'medium')  ?>">-->
				<img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" width="250">
				<div class="details">
				<h4><?= $episodes->title; ?> <span><br><?= gmdate("H:i:s", $episodes->duration); ?></span></h4>
				</div>
				</a>
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
				</div>
				</article>
				</div>
			<?php endif; endforeach; ?>
				<div class="clear"></div>
        </div>
		<?php endforeach; ?>
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
		<div id="social_share" style="display:flex;color:#fff;">
	    	<p class="mt-1">Share This episode:</p>
			<?php include('partials/social-share.php'); ?>
		</div>
            </div>

       
		<div class="clear"></div>

		<div id="comments">
			<div id="disqus_thread"></div>
		</div>
    
	</div>
	
	    <script type="text/javascript"> 
        videojs('Player').videoJsResolutionSwitcher(); 
    </script>
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

