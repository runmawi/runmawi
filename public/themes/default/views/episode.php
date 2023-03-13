<?php 
   include('header.php');
   include('episode_ads.blade.php');

   $autoplay = $episode_ads == null ? "autoplay" : "" ;    
   $series= App\series::first();
   $series= App\series::where('id',$episode->series_id)->first();
   $SeriesSeason= App\SeriesSeason::where('id',$episode->season_id)->first();
?>

                  <!-- free content - hide & show -->

   <!-- <div class="row free_content">
      <div class="col-md-12">
         <p class="Subscribe">Subscribe to watch</p>
      </div>

      <div class="col-md-12">
         <form method="get" action="<?= URL::to('/stripe/billings-details') ?>">
               <button style="margin-left: 34%;margin-top: 0%;" class="btn btn-primary"id="button">Become a subscriber to watch this video</button>
         </form>
      </div>

      <div class="col-md-12"> <p class="Subscribe">Play Again</p>
         <div class="play_icon">
            <a href="#" onclick="window.location.reload(true);"><i class="fa fa-play-circle" aria-hidden="true"></i></a>
         </div>
      </div>
   </div> -->

   <input type="hidden" value="<?php echo URL::to('/');?>" id="base_url" >
   <input type="hidden" id="videoslug" value="<?php if(isset($episode->path)) { echo $episode->path; } else{ echo "0";}?>">
   <input type="hidden" value="<?php echo $episode->type; ?>" id='episode_type'>

	<div id="series_bg">
		<div class="">
			<?php 
			   if(!Auth::guest()){
			      if($free_episode > 0 ||  $ppv_exits > 0 || Auth::user()->role == 'admin' ||  Auth::guest()){ 

                  if($episode->access == 'guest' || $video_access == 'free' || ( ($episode->access == 'subscriber' || 
                     $episode->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && 
                     (Auth::user()->role == 'demo'  || Auth::user()->role == 'admin')) || (!Auth::guest() && $episode->access == 'registered' 
                     && $settings->free_registration && Auth::user()->role == 'registered') || Auth::user()->role == 'subscriber'): 
                  ?>
				
                     <?php if($episode->type == 'embed'): ?>
                        <div id="series_container" class="fitvid">
                           <?= $episode->embed_code ?>
                        </div>

					<?php  elseif( $episode->type == 'file' || $episode->type == 'upload' ): ?>

						<div id="series_container">
                     <video id="videoPlayer" <?= $autoplay ?> class="video-js vjs-default-skin" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' width="100%" style="width:100%;" type="video/mp4"  data-authenticated="<?= !Auth::guest() ?>">
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

						<?php  elseif( $episode->type == 'm3u8' ): ?>
							<div id="series_container">
								 <video id="video" <?= $autoplay ?> controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>"  controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                           
                           <source type="application/x-mpegURL" src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '.m3u8'; ?>">
                           
                           <?php  if(isset($episodesubtitles)){
                              foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
                                 <track kind="captions" src="<?= $episodesubtitles_file->url; ?>" srclang="<?= $episodesubtitles_file->sub_language; ?>" label="<?= $episodesubtitles_file->shortcode; ?>" default>
                           <?php } } ?>
								</video>
							</div>

                     <?php  elseif( $episode->type == 'aws_m3u8' ): ?>
							<div id="series_container">
								 <video id="video" <?= $autoplay ?> controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>"  controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                           
                           <source type="application/x-mpegURL" src="<?php echo $episode->path; ?>">
                           
                           <?php  if(isset($episodesubtitles)){
                              foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
                                 <track kind="captions" src="<?= $episodesubtitles_file->url; ?>" srclang="<?= $episodesubtitles_file->sub_language; ?>" label="<?= $episodesubtitles_file->shortcode; ?>" default>
                           <?php } } ?>
								</video>
							</div>

					   <?php  else: ?>    

						<div id="series_container">
						   <video id="videoPlayer"  autoplay  class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
                        <source src="<?php echo URL::to('/storage/app/public/').'/'.'TfLwBgA62jiyfpce_2_1000_00018'; ?>" type='application/x-mpegURL' label='360p' res='360' />
                        <source src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '_0_250.m3u8'; ?>" type='application/x-mpegURL' label='480p' res='480'/>
                        <source src="<?php echo URL::to('/storage/app/public/').'/'.$episode->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/> 

                                 <!-- <php foreach ($episoderesolutions as $key => $episoderesolution_file) { ?>
                                    <source src="<= $episoderesolution_file->url; ?>" type='video/mp4' label='<= $episoderesolution_file->quality; ?>p' res='<= $episoderesolution_file->quality; ?>p'/>
                                 <php } ?>
                                 
                                 <php if(isset($episodesubtitles)){
                                 foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
                                    <track kind="captions" src="<= $episodesubtitles_file->url; ?>" srclang="<= $episodesubtitles_file->sub_language; ?>" label="<= $episodesubtitles_file->shortcode; ?>" default>
                                 <php }  }
                                 ?> -->
						   </video>
						</div>
					<?php endif; ?>
					 <div class="logo_player"> </div>
	                                 <!-- Intro Skip and Recap Skip -->
                  <div class="col-sm-12 intro_skips">
                     <input type="button" class="skips" value="Skip Intro" id="intro_skip">
                     <input type="button" class="skips" value="Auto Skip in 5 Secs" id="Auto_skip">
                  </div>	

                  <div class="col-sm-12 Recap_skip">
                     <input type="button" class="Recaps" value="Recap Intro" id="Recaps_Skip" style="display:none;">
                  </div>

  	               <!-- Intro Skip and Recap Skip -->

			   <?php else: ?>

               <div id="subscribers_only"style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)) , url(<?=URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 450px; padding-top: 150px;">
                  <h4 class=""><?php echo $episode->title ; ?></h4>
                  <p class=" text-white col-lg-8" style="margin:0 auto";><?php echo ($episode->episode_description) ; ?></p>
                  <h2 class="">Subscribe to view more<?php if ($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
                  <div class="clear"></div>
                  
                  <?php if( !Auth::guest() && Auth::user()->role == 'registered'):  ?>
                     <div class=" mt-3">
                     <form method="get" action="<?= URL::to('/stripe/billings-details')?>">
                        <button class="btn btn-primary" id="button">Subscribe to view more</button>
                     </form>
                     </div>
                  <?php else: ?>
                  <div class=" mt-3">
                     <form method="get" action="<?= URL::to('signup') ?>" class="mt-4">
                        <button id="button" class="btn bd">Signup Now <?php if($series->access == 'subscriber'): ?>to Become a Subscriber<?php elseif($series->access == 'registered'): ?>for Free!<?php endif; ?></button>
                     </form>
                     </div>
                  <?php endif; ?>
                  
				   </div>
			
			   <?php endif; 
			}else{  ?>

			<div id="series_container">
            <video id="videoPlayer"  autoplay class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>"  data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">
               <source src="<?= $season[0]->trailer; ?>" type='video/mp4' label='auto' >
               
               <?php  if(isset($episodesubtitles)){
                  foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
                  <track kind="captions" src="<?= $episodesubtitles_file->url; ?>" srclang="<?= $episodesubtitles_file->sub_language; ?>" label="<?= $episodesubtitles_file->shortcode; ?>" default>
               <?php } } ?>
            </video>

            <!-- <div id=""style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;">
					<div id="ppv">
				      <h2>Purchase to Watch the Episodes <?php if($episode->access == 'subscriber'): ?>Subscribers<?php elseif($episode->access == 'registered'): ?>Registered Users<?php endif; ?></h2>
				         <div class="clear"></div>
                        <?php //if(!Auth::guest() ): ?>
                           <form method="get" action="<?// URL::to('/')?>/user/<?// Auth::user()->username ?>/upgrade_subscription">
                              <button id="button">Purchase to Watch <?php //$currency->symbol.' '.$episode->ppv_price ?></button>
                           </form>
                        <?php //else: ?>

				            <?php //endif; ?>
			            </div>
			      <div>
			   </div> -->
            
		   <?php } } ?>
		</div>
	</div>

<input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $episode->genre_id ?>" value="<?= $episode->genre_id ?>">
<br>

	<div class="container-fluid series-details">
	   <div id="series_title">
		   <div class="">
            <div class="row align-items-center justify-content-between">
               <?php if($free_episode > 0 ||  $ppv_exits > 0 || Auth::user()->role == 'admin' ||  Auth::guest()){ } else{ ?>
                  <div class="col-md-6 p-0">
                     <span class="text-white" style="font-size: 129%;font-weight: 700;">Purchase to Watch the Series:</span>
                  <?php 
                  if($series->access == 'subscriber'): ?> Subscribers <?php elseif($series->access == 'registered'): ?> Registered Users <?php endif; ?>
                  </p>
	         </div>

            <?php if (!empty($season)) {   ;?>
               <div class="col-md-6">
                  <input type="hidden" id="season_id" name="season_id" value="<?php echo $season[0]->id; ?>">
                     <button class="btn btn-primary" onclick="pay(<?php echo $season[0]->ppv_price; ?>)" >
                     Purchase For <?php echo $currency->symbol.' '.$season[0]->ppv_price; ?></button>
               </div>
	         <?php	} } ?>
	
         <div class="col-md-6">
            <span class="text-white" style="font-size: 120%;font-weight: 700;">You're watching:</span>
               <p class="mb-0" style=";font-size: 80%;color: white;">
            <?php 
               $seasons = App\SeriesSeason::where('series_id','=',$SeriesSeason->series_id)->with('episodes')->get();
               foreach($seasons as $key=>$seasons_value){
            ?>

            <?php
            if(!empty($SeriesSeason) && $SeriesSeason->id == $seasons_value->id){ echo 'Season'.' '. ($key+1)   .' ';}  }

               $Episode = App\Episode::where('season_id','=',$SeriesSeason->id)->where('series_id','=',$SeriesSeason->series_id)->get();

               foreach($Episode as $key=> $Episode_value){  ?>
                  <?php if(!empty($episode) && $episode->id == $Episode_value->id){ echo 'Episode'.' '. ($episode->episode_order)   .' ';} ?>
               <?php } ?>

            <p class="" style=";font-size: 100%;color: white;font-weight: 700;"><?= $episode->title ?></p>
            <p class="desc"><?php echo $series->details;?></p>
         </div>
               
			<!-- <div class="col-md-2 text-center text-white">
			   <span class="view-count  " style="float:right;">
			      <i class="fa fa-eye"></i> 
               <?php if(isset($view_increment) && $view_increment == true ): ?><?= $episode->views + 1 ?>
               <?php else: ?><?= $episode->views ?><?php endif; ?> Views 
			   </span>
			</div> -->
				          
			<!-- <div>
			   <?php //if ( $episode->ppv_status != null && Auth::User()!="admin" || $episode->ppv_price != null  && Auth::User()->role!="admin") { ?>
			      <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-episode">
			      <?php // echo __('Purchase for').' '.$currency->symbol.' '.$episode->ppv_price;?> </button>
			      <?php //} ?>
            <br>
			</div> -->

        </div>
         <!-- <div class="clear" style="display:flex;justify-content: space-between; align-items: center;"> <div> -->


	      <!-- Watchlater & Wishlist -->

		   <?php
            $media_url = URL::to('/episode/').'/'.$series->title.'/'.$episode->slug;
            $embed_media_url = URL::to('/episode/embed').'/'.$series->title.'/'.$episode->slug;
            $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'"  allowfullscreen></iframe>';
         ?>
		  
		   <div class="col-md-5">
		  		<ul class="list-inline p-0 mt-4 share-icons music-play-lists">
				 	<li>
						<?php if($episode_watchlater == null){ ?>
							<span id="<?php echo 'episode_add_watchlist_'.$episode->id ; ?>" class="slider_add_watchlist"  aria-hidden="true" data-list="<?php echo $episode->id ; ?>" data-myval="10" data-video-id="<?php echo $episode->id ; ?>" onclick="episodewatchlater(this)" > <i class="fa fa-plus-circle" aria-hidden="true"></i>  </span>
						<?php }else{?>
							<span id="<?php echo 'episode_add_watchlist_'.$episode->id ; ?>" class="slider_add_watchlist"  aria-hidden="true" data-list="<?php echo $episode->id ; ?>" data-myval="10"  data-video-id="<?php echo $episode->id ; ?>"  onclick="episodewatchlater(this)"> <i class="fa fa-minus-circle" aria-hidden="true"></i> </span>
						<?php } ?>
					</li>

               <li>
						<?php if($episode_Wishlist == null){ ?>
							<span id="<?php echo 'episode_add_wishlist_'.$episode->id ; ?>" class="episode_add_wishlist_"  aria-hidden="true" data-list="<?php echo $episode->id ; ?>" data-myval="10" data-video-id="<?php echo $episode->id ; ?>" onclick="episodewishlist(this)" ><i class="fa fa-heart-o" aria-hidden="true"></i>   </span>
						<?php }else{?>
							<span id="<?php echo 'episode_add_wishlist_'.$episode->id ; ?>" class="episode_add_wishlist_"  aria-hidden="true" data-list="<?php echo $episode->id ; ?>" data-myval="10"  data-video-id="<?php echo $episode->id ; ?>"  onclick="episodewishlist(this)"> <i class="fa  fa-heart" aria-hidden="true"></i></span>
						<?php } ?>
					</li>

					<li>
						<?php if(empty($like_dislike->liked) || !empty($like_dislike->liked) && $like_dislike->liked == 0){ ?>
							<span id="<?php echo 'episode_like_'.$episode->id ; ?>" class="episode_like_"  aria-hidden="true" data-list="<?php echo $episode->id ; ?>" data-myval="10" data-video-id="<?php echo $episode->id ; ?>" onclick="episodelike(this)" ><i class="ri-thumb-up-line" aria-hidden="true"></i>   </span>
						<?php }else{?>
							<span id="<?php echo 'episode_like_'.$episode->id ; ?>" class="episode_like_"  aria-hidden="true" data-list="remove" data-myval="10"  data-video-id="<?php echo $episode->id ; ?>"  onclick="episodelike(this)"> <i class="ri-thumb-up-fill" aria-hidden="true"></i></span>
						<?php } ?>
					</li>

					<li>
						<?php if(empty($like_dislike->disliked) ||  !empty($like_dislike->disliked) &&  $like_dislike->disliked == 0){ ?>
							<span id="<?php echo 'episode_dislike_'.$episode->id ; ?>" class="episode_dislike_"  aria-hidden="true" data-list="<?php echo $episode->id ; ?>" data-myval="10" data-video-id="<?php echo $episode->id ; ?>" onclick="episodedislike(this)" ><i class="ri-thumb-down-line" aria-hidden="true"></i>   </span>

						<?php }else{?>
							<span id="<?php echo 'episode_dislike_'.$episode->id ; ?>" class="episode_dislike_"  aria-hidden="true" data-list="remove" data-myval="10"  data-video-id="<?php echo $episode->id ; ?>"  onclick="episodedislike(this)"> <i class="ri-thumb-down-fill" aria-hidden="true"></i></span>

						<?php } ?>
					</li>
					<li class="share">
						<span><i class="ri-share-fill"></i></span>
							<div class="share-box">
							<div class="d-flex align-items-center"> 
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>
								<a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a>
								<a href="#"onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
							</div>
							</div>
						</li>
					<li>
						<a href="#"onclick="EmbedCopy();" class="share-ico"><span><i class="ri-links-fill mt-1"></i></span></a>
					</li>
            </ul>
			</div>
       
      </div>
      <div></div>
   </div>
</div>

<input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $episode->genre_id ?>" value="<?= $episode->genre_id ?>">
<br>
<div class="container-fluid series-details">
   <div id="series_title">
      <div class="">
         <div class="row align-items-center justify-content-between">
            <?php if($free_episode > 0 ||  $ppv_exits > 0 || Auth::user()->role == 'admin' ||  Auth::guest()){ 
               }else{ ?>
            <div class="col-md-6 p-0">
               <span class="text-white" style="font-size: 129%;font-weight: 700;">Purchase to Watch the Series:</span>
               <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?>
               </p>
            </div>
            <div class="col-md-6">
               <?php if (!empty($season)) {   ;?>
               <input type="hidden" id="season_id" name="season_id" value="<?php echo $season[0]->id; ?>">
               <button class="btn btn-primary" onclick="pay(<?php echo $season[0]->ppv_price; ?>)" >
               Purchase For <?php echo $currency->symbol.' '.$season[0]->ppv_price; ?></button>
            </div>
            <?php	} } ?>
           
            <!--<div class="col-md-2 text-center text-white">
               <span class="view-count  " style="float:right;">
               <i class="fa fa-eye"></i> 
               <?php if(isset($view_increment) && $view_increment == true ): ?><?= $episode->views + 1 ?>
               <?php else: ?><?= $episode->views ?><?php endif; ?> Views 
               </span>
               </div>-->
            <!-- <div>
               <?php //if ( $episode->ppv_status != null && Auth::User()!="admin" || $episode->ppv_price != null  && Auth::User()->role!="admin") { ?>
               <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-episode">
               <?php // echo __('Purchase for').' '.$currency->symbol.' '.$episode->ppv_price;?> </button>
               <?php //} ?>
                        <br>
               </div> -->
         </div>
         <!-- <div class="clear" style="display:flex;justify-content: space-between;
            align-items: center;">
            <div> -->
         <!-- Watchlater & Wishlist -->
         <?php
            $media_url = URL::to('/episode/').'/'.$series->title.'/'.$episode->slug;
            $embed_media_url = URL::to('/episode/embed').'/'.$series->title.'/'.$episode->slug;
            $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'"  allowfullscreen></iframe>';
         ?>
      </div>

      <div class="series-details-container"><?= $episode->details ?></div>

      <?php if(isset($episodenext)){ ?>
         <div class="next_episode" style="display: none;"><?= $episodenext->id ?></div>
         <div class="next_url" style="display: none;"><?= $url ?></div>
      <?php }elseif(isset($episodeprev)){ ?>
         <div class="prev_episode" style="display: none;"><?= $episodeprev->id ?></div>
         <div class="next_url" style="display: none;"><?= $url ?></div>
      <?php } ?>

      <div class="col-sm-12 d-flex row">
         <?php if($episode->search_tags != null ) : ?>
            <h4 >Tags  : </h4>
            <span class="mb-0" style=";font-size: 100%;color: white;"> <?= $episode->search_tags ?> </span>
		   <?php  endif;?>
      </div>
                              
               <!-- Comment Section -->
               
      <?php if( App\CommentSection::first() != null && App\CommentSection::pluck('livestream')->first() == 1 ): ?>
       <div class="row">
           <div class=" container-fluid video-list you-may-like overflow-hidden">
               <h4 class="" style="color:#fffff;"><?php echo __('Comments');?></h4>
               <?php include('comments/index.blade.php');?>
           </div>
       </div>
      <?php endif; ?>

             <!-- Season -->

      <div class="iq-main-header ">
         <h4 class="main-title"> Season </h4>
      </div>
      
      <div class="col-sm-12 overflow-hidden">
         <div class="favorites-contens ml-2">
            <ul class="favorites-slider list-inline row mb-0">
               <?php  
                  foreach($season as $key => $seasons):
                     foreach($seasons->episodes as $key => $episodes):
                  	   if($episodes->id != $episode->id): ?>
                           <li class="slide-item">
                              <a href="<?= ($settings->enable_https) ? secure_url('episodes') : URL::to('episode').'/'.@$episodes->series_title->title.'/'.$episodes->slug; ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class="w-100">
                                    </div>
                                    <div class="block-description">
                                       <h6><?= $episodes->title; ?> </h6>
                                       <p class="date" style="color:#fff;font-size:14px;"><?= date("F jS, Y", strtotime($episodes->created_at)); ?>
                                          <?php if($episodes->access == 'guest'): ?>
                                             <span class="label label-info">Free</span>
                                          <?php elseif($episodes->access == 'subscriber'): ?>
                                             <span class="label label-success">Subscribers Only</span>
                                          <?php elseif($episodes->access == 'registered'): ?>
                                             <span class="label label-warning">Registered Users</span>
                                          <?php endif; ?>
                                       </p>

                                       <div class="hover-buttons">
                                          <a  href="<?= ($settings->enable_https) ? secure_url('episodes') : URL::to('episode').'/'.@$episodes->series_title->title.'/'.$episodes->slug; ?>">	
                                                <span class="text-white"> <i class="fa fa-play mr-1" aria-hidden="true"></i> Play Now </span>
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                        <?php endif; ?>  
                     <?php endforeach; ?>
                  <?php endforeach; ?>
            </ul>
         </div>
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
<!-- Free content - Video Not display  -->
<?php
   $free_content_duration = $episode->free_content_duration;
   $user_access = $episode->access;
   $Auth = Auth::guest();
   ?>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">Rent Now</h4>
            <img src="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" alt=""width="50" height="60">
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-sm-2" style="width:52%;">
                  <span id="paypal-button"></span> 
               </div>
               <?php $payment_type = App\PaymentSetting::get(); ?>
               <div class="col-sm-4">
                  <span class="badge badge-secondary p-2"><?php echo __($episodes->title);?></span>
                  <span class="badge badge-secondary p-2"><?php echo __($episodes->age_restrict).' '.'+';?></span>
                  <!-- <span class="badge badge-secondary p-2"><?php //echo __($video->categories->name);?></span>
                     <span class="badge badge-secondary p-2"><?php //echo __($video->languages->name);?></span> -->
                  <span class="badge badge-secondary p-2"><?php //echo __($video->duration);?></span>
                  <span class="trending-year"><?php if ($episode->year == 0) { echo ""; } else { echo $episode->year;} ?></span>
                  <button type="button" class="btn btn-primary"  data-dismiss="modal"><?php echo __($currency->symbol.' '.$episodes->ppv_price);?></button>
                  <label for="method">
                     <h3>Payment Method</h3>
                  </label>
                  <label class="radio-inline">
                  <?php  foreach($payment_type as $payment){
                     if($payment->live_mode == 1){ ?>
                  <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
                  </label>
                  <?php }elseif($payment->paypal_live_mode == 1){ ?>
                  <label class="radio-inline">
                  <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                  </label>
                  <?php }elseif($payment->live_mode == 0){ ?><
                  <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if(!empty($payment->stripe_lable)){ echo $payment->stripe_lable ; }else{ echo $payment->payment_type ; } ?>
                  </label><br>
                  <?php 
                     }elseif( $payment->paypal_live_mode == 0){ ?>
                  <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if(!empty($payment->paypal_lable)){ echo $payment->paypal_lable ; }else{ echo $payment->payment_type ; } ?>
                  </label>
                  <?php  } }?>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <a onclick="pay(<?php echo $episode->ppv_price ;?>)">
            <button type="button" class="btn btn-primary" id="submit-new-cat">Continue</button>
            </a>
            <button type="button" class="btn btn-primary"  data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<div class="clear"></div>
<input type="hidden" id="episode_id" value="<?php echo $episode->id ; ?>">
<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">
<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript"> 
   // videojs('videoPlayer').videoJsResolutionSwitcher(); 
   $(document).ready(function () {  
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      });
   
      function pay(amount) {
        var publishable_key = $('#publishable_key').val();
   
        var episode_id = $('#episode_id').val();
        var season_id = $('#season_id').val();
   
       // alert(video_id);
        var handler = StripeCheckout.configure({
   
          key: publishable_key,
          locale: 'auto',
          token: function (token) {
   // You can access the token ID with `token.id`.
   // Get the token ID to your server-side code for use.
   console.log('Token Created!!');
   console.log(token);
   $('#token_response').html(JSON.stringify(token));
   
   $.ajax({
   url: '<?php echo URL::to("purchase-episode") ;?>',
   method: 'post',
   data: {"_token": "<?= csrf_token(); ?>",tokenId:token.id, amount: amount , episode_id: episode_id , season_id: season_id},
   success: (response) => {
   alert("You have done  Payment !");
   setTimeout(function() {
   location.reload();
   }, 2000);
   
   },
   error: (error) => {
   swal('error');
   //swal("Oops! Something went wrong");
   /* setTimeout(function() {
   location.reload();
   }, 2000);*/
   }
   })
   }
   });
   
   
        handler.open({
          name: '<?php $settings = App\Setting::first(); echo $settings->website_name;?>',
          description: 'Rent a Episode',
          amount: amount * 100
        });
      }
</script>
<script type="text/javascript">
   $(".free_content").hide();
   var duration = <?php echo json_encode($free_content_duration); ?>;
   var access = <?php echo json_encode($user_access); ?>;
   var Auth = <?php echo json_encode($Auth); ?>;
   var pause = document.getElementById("videoPlayer");
   
   pause.addEventListener('timeupdate',function(){
   if(Auth != false){
   	if( access  ==  'guest' && duration !== null){
   		if(pause.currentTime >=  duration ) {
   			pause.pause();    
   				$("video#videoPlayer").hide();
   				$(".free_content").show();
   		}
   	}
   }
   },false);
</script>
<style>
   p{
   color: #fff;
   }
   .free_content{	
   margin: 100px;
   border: 1px solid red;
   padding: 5% !important;
   border-radius: 5px;
   }
   p.Subscribe {
   font-size: 48px !important; 
   font-family: emoji;
   color: white;
   margin-top: 3%;
   text-align: center;
   }
   .play_icon {
   text-align: center;
   color: #c5bcbc;
   font-size: 51px !important;
   }
   .intro_skips,.Recap_skip {
   position: absolute;
   margin-top: -10%;
   margin-bottom: 0;
   /* z-index: -1; */
   margin-right: 0;
   }
   .plyr--video {
   height: calc(100vh - 80px - 75px);
   max-width: none;
   width: 100%;}
   #videoPlayer{
   }
   input.skips,input#Recaps_Skip{
   background-color: #21252952;
   color: white;
   padding: 15px 32px;
   text-align: center;
   margin: 4px 2px;
   }
   #intro_skip{
   display: none;
   }
   #Auto_skip{
   display: none;
   }
</style>
<!-- INTRO SKIP  -->
<?php
   $Auto_skip = App\HomeSetting::first();
   $Intro_skip = App\Episode::where('id',$episode->id)->first();
   $start_time = $Intro_skip->intro_start_time;
   $end_time = $Intro_skip->intro_end_time;
   $SkipIntroPermission = App\Playerui::pluck('skip_intro')->first();
   
   $StartParse = date_parse($start_time);
   $startSec = $StartParse['hour']  * 60 *  60  + $StartParse['minute']  * 60  + $StartParse['second'];
   
   $EndParse = date_parse($end_time);
   $EndSec = $EndParse['hour'] * 60 * 60 + $EndParse['minute'] * 60 + $EndParse['second'];
   
   $SkipIntroParse = date_parse($Intro_skip['skip_intro']);
   $skipIntroTime =  $SkipIntroParse['hour'] * 60 * 60 + $SkipIntroParse['minute'] * 60 + $SkipIntroParse['second'];
   
   // dd($SkipIntroPermission);
   ?>
<script>
   var SkipIntroPermissions = <?php echo json_encode($SkipIntroPermission); ?>;
   var video = document.getElementById("videoPlayer");
   var button = document.getElementById("intro_skip");
   var Start = <?php echo json_encode($startSec); ?>;
   var End = <?php echo json_encode($EndSec); ?>;
   var AutoSkip = <?php echo json_encode($Auto_skip['AutoIntro_skip']); ?>;
   var IntroskipEnd = <?php echo json_encode($skipIntroTime); ?>;
   //   alert(SkipIntroPermissions);
   
   if( SkipIntroPermissions == 0 ){
   button.addEventListener("click", function(e) {
     video.currentTime = IntroskipEnd;
        $("#intro_skip").remove();  // Button Shows only one tym
     video.play();
   })
     if(AutoSkip != 1){
   // alert(AutoSkip);
   
           this.video.addEventListener('timeupdate', (e) => {
             document.getElementById("intro_skip").style.display = "none";
             document.getElementById("Auto_skip").style.display = "none";
             var RemoveSkipbutton = End + 1;
   
             if (Start <= e.target.currentTime && e.target.currentTime < End) {
                     document.getElementById("intro_skip").style.display = "block"; // Manual skip
             } 
             if(RemoveSkipbutton  <= e.target.currentTime){
                   $("#intro_skip").remove();   // Button Shows only one tym
             }
         });
     }
     else{
       this.video.addEventListener('timeupdate', (e) => {
             document.getElementById("Auto_skip").style.display = "none";
             document.getElementById("intro_skip").style.display = "none";
   
             var before_Start = Start - 5;
             var trigger = Start - 1;
   
             if (before_Start <= e.target.currentTime && e.target.currentTime < Start) {
                 document.getElementById("Auto_skip").style.display = "block";
                   if(trigger  <= e.target.currentTime){
                     document.getElementById("intro_skip").click();    // Auto skip
                   }
             }
         });
     }
   }
</script>
<!-- Recap video skip -->
<?php
   $Recap_skip = App\Episode::where('id',$episode->id)->first();
   
   $RecapStart_time = $Recap_skip->recap_start_time;
   $RecapEnd_time = $Recap_skip->recap_end_time;
   
   $SkipRecapParse = date_parse($Recap_skip['skip_recap']);
   $skipRecapTime =  $SkipRecapParse['hour'] * 60 * 60 + $SkipRecapParse['minute'] * 60 + $SkipRecapParse['second'];
   
   $RecapStartParse = date_parse($RecapStart_time);
   $RecapstartSec = $RecapStartParse['hour']  * 60 *  60  + $RecapStartParse['minute']  * 60  + $RecapStartParse['second'];
   
   $RecapEndParse = date_parse($RecapEnd_time);
   $RecapEndSec = $RecapEndParse['hour'] * 60 * 60 + $RecapEndParse['minute'] * 60 + $RecapEndParse['second'];
   ?>
<script>
   var videoId = document.getElementById("videoPlayer");
   var button = document.getElementById("Recaps_Skip");
   var RecapStart = <?php echo json_encode($RecapstartSec); ?>;
   var RecapEnd = <?php echo json_encode($RecapEndSec); ?>;
   var RecapskipEnd = <?php echo json_encode($skipRecapTime); ?>;
   var RecapValue  = $("#Recaps_Skip").val();
   
   button.addEventListener("click", function(e) {
     videoId.currentTime = RecapskipEnd;
     $("#Recaps_Skip").remove();   // Button Shows only one tym
     videoId.play();
   })
       this.videoId.addEventListener('timeupdate', (e) => {
         document.getElementById("Recaps_Skip").style.display = "none";
   
         var RemoveRecapsbutton = RecapEnd + 1;
               if (RecapStart <= e.target.currentTime && e.target.currentTime < RecapEnd) {
                   document.getElementById("Recaps_Skip").style.display = "block"; 
               }
                
               if(RemoveRecapsbutton  <= e.target.currentTime){
                   $("#Recaps_Skip").remove();   // Button Shows only one tym
               }
     });
</script>
<!-- Watchlater & wishlist -->
<script>
   function episodewatchlater(ele) 
   		{
   			var episode_id = $(ele).attr('data-video-id');
   			var key_value = $(ele).attr('data-list');
               var id = '#episode_add_watchlist_'+ key_value;
               var my_value =  $(id).data('myval');
   
   			if(my_value != "remove"){
   				var url = '<?= URL::to('/episode_watchlist');?>';
   			}else if(my_value == "remove"){
   				var url = '<?= URL::to('/episode_watchlist_remove');?>';
   			}
   
               $.ajax({
   					url:url,
   					type:'get',
   					data:{
   						episode_id:episode_id, 
                       },
   					success:function(data){
   
                     if(data.message == "Remove the Watch list"){
   
                        $(id).data('myval'); 
                        $(id).data('myval','remove');
   					 $(id).find($(".fa")).toggleClass('fa fa-plus-circle').toggleClass('fa fa-minus-circle');
   					 
   					$("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to watchlater</div>');
   					setTimeout(function() {
   						$('.add_watch').slideUp('fast');
   					}, 3000);
   
                     }else if(data.message == "Add the Watch list"){
                        $(id).data('myval'); 
                        $(id).data('myval','add');
   					 $(id).find($(".fa")).toggleClass('fa fa-minus-circle').toggleClass('fa fa-plus-circle');
   
   					 $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from watchlater</div>');
   						setTimeout(function() {
   							$('.remove_watch').slideUp('fast');
   						}, 3000);
                     }
                     else if (data.message == "guest"){
                       window.location.replace('<?php echo URL::to('/login'); ?>');
                     }
   					}
   				})
   		}
   
   
   		function episodewishlist(ele) 
   		{
   			var episode_id = $(ele).attr('data-video-id');
   			var key_value = $(ele).attr('data-list');
               var id = '#episode_add_wishlist_'+ key_value;
               var my_value =  $(id).data('myval');
   
   			if(my_value != "remove"){
   				var url = '<?= URL::to('/episode_wishlist');?>';
   			}else if(my_value == "remove"){
   				var url = '<?= URL::to('/episode_wishlist_remove');?>';
   			}
   
               $.ajax({
   					url:url,
   					type:'get',
   					data:{
   						episode_id:episode_id, 
                       },
   					success:function(data){
   
                     if(data.message == "Remove the Watch list"){
   
                        $(id).data('myval'); 
                        $(id).data('myval','remove');
   					 $(id).find($(".fa")).toggleClass('fa fa-heart-o').toggleClass('fa fa-heart');
   
   					 $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to wishlist</div>');
   					setTimeout(function() {
   						$('.add_watch').slideUp('fast');
   					}, 3000);
   
                     }else if(data.message == "Add the Watch list"){
                        $(id).data('myval'); 
                        $(id).data('myval','add');
                        $(id).find($(".fa")).toggleClass('fa fa-heart').toggleClass('fa fa-heart-o');
   
   					 $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from wishlist</div>');
   						setTimeout(function() {
   							$('.remove_watch').slideUp('fast');
   						}, 3000);
                     }
                     else if (data.message == "guest"){
                       window.location.replace('<?php echo URL::to('/login'); ?>');
                     }
   					}
   				})
   		}
   
   
   
   		function episodelike(ele) 
   		{
   			var episode_id = $(ele).attr('data-video-id');
   			var key_value = $(ele).attr('data-list');
               var id = '#episode_like_dislike_'+ key_value;
               var my_value =  $(id).data('myval');
   			// alert(key_value);
   
   			// alert(my_value);
   			if(key_value != "remove"){
   				var url = '<?= URL::to('/like-episode');?>';
   			}else if(key_value == "remove"){
   				var url = '<?= URL::to('/remove_like-episode');?>';
   			}
               $.ajax({
   					url:url,
   					type:'post',
   					data:{
   						episode_id:episode_id, 
   						_token: '<?= csrf_token(); ?>'
                       },
   					success:function(data){
   
                     if(data.message == "Removed from Liked Episode"){
   
                        $(id).data('myval'); 
                        $(id).data('myval','remove');
   					 $(id).find($(".fa")).toggleClass('ri-thumb-up-fill').toggleClass('ri-thumb-up-line');
   
   
   					$("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Removed from Liked Episode</div>');
   						setTimeout(function() {
   							$('.remove_watch').slideUp('fast');
   						}, 3000);
   
                     }else if(data.message == "Added to Like Episode"){
                        $(id).data('myval'); 
                        $(id).data('myval','add');
                        $(id).find($(".fa")).toggleClass('ri-thumb-up-line').toggleClass('fri-thumb-up-fill');
   
   					 $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Added to Like Episode</div>');
   					setTimeout(function() {
   						$('.add_watch').slideUp('fast');
   					}, 3000);
                     }
                     else if (data.message == "guest"){
                       window.location.replace('<?php echo URL::to('/login'); ?>');
                     }
   					}
   				})
   		}
   
   
   		function episodedislike(ele) 
   		{
   			var episode_id = $(ele).attr('data-video-id');
   			var key_value = $(ele).attr('data-list');
               var id = '#episode_like_dislike_'+ key_value;
               var my_value =  $(id).data('myval');
   			// alert(key_value);
   
   			// alert(my_value);
   			if(key_value != "remove"){
   				var url = '<?= URL::to('/dislike-episode');?>';
   			}else if(key_value == "remove"){
   				var url = '<?= URL::to('/remove_dislike-episode');?>';
   			}
               $.ajax({
   					url:url,
   					type:'post',
   					data:{
   						episode_id:episode_id, 
   						_token: '<?= csrf_token(); ?>'
                       },
   					success:function(data){
   
                     if(data.message == "Removed from DisLiked Episode"){
   
                        $(id).data('myval'); 
                        $(id).data('myval','remove');
   					 $(id).find($(".fa")).toggleClass('ri-thumb-down-fill').toggleClass('ri-thumb-down-line');
   
   
   					$("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Removed from DisLiked Episode</div>');
   						setTimeout(function() {
   							$('.remove_watch').slideUp('fast');
   						}, 3000);
   
                     }else if(data.message == "Added to DisLike Episode"){
                        $(id).data('myval'); 
                        $(id).data('myval','add');
                        $(id).find($(".fa")).toggleClass('ri-thumb-down-line').toggleClass('fri-thumb-down-fill');
   
   					 $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Added to DisLike Episode</div>');
   					setTimeout(function() {
   						$('.add_watch').slideUp('fast');
   					}, 3000);
                     }
                     else if (data.message == "guest"){
                       window.location.replace('<?php echo URL::to('/login'); ?>');
                     }
   					}
   				})
   		}
   
   
   
   	function Copy() {
       	var media_path = '<?= $media_url ?>';;
   		var url =  navigator.clipboard.writeText(window.location.href);
   		var path =  navigator.clipboard.writeText(media_path);
   		$("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
   			setTimeout(function() {
   				$('.add_watch').slideUp('fast');
   			}, 3000);
   		}
   	function EmbedCopy() {
   		var media_path = '<?= $url_path ?>';
   		var url =  navigator.clipboard.writeText(window.location.href);
   		var path =  navigator.clipboard.writeText(media_path);
   		$("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
   			setTimeout(function() {
   				$('.add_watch').slideUp('fast');
   			}, 3000);
   		}
</script>

<?php 
   include('footer.blade.php');
 ?>