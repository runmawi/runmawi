<?php
   include(public_path('themes/default/views/header.php'));
   include(public_path('themes/default/views/episode_ads.blade.php'));

   $autoplay  = $episode_ads == null ? 'autoplay' : "" ;    

   $series = App\series::first();
?>

<!-- video-js Style  -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="<?= asset('public/themes/default/assets/css/video-js/videojs.min.css') ?>" rel="stylesheet">
<!-- <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css"
    rel="stylesheet">
<link href="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/default/assets/css/video-js/videos-player.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/default/assets/css/video-js/video-end-card.css') ?>" rel="stylesheet">
<link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

<!-- video-js Script  -->

<script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/video.min.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs-contrib-quality-levels.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs-http-source-selector.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs.ads.min.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs.ima.min.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/videojs-hls-quality-selector.min.js') ?>"></script>
<script src="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') ?>"></script>
<script src="<?= asset('public/themes/default/assets/js/video-js/end-card.js') ?>"></script>
<script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>

<style>
    
    /* <!-- BREADCRUMBS  */
   
   .bc-icons-2 .breadcrumb-item + .breadcrumb-item::before {
             content: none; 
   } 
   
   ol.breadcrumb {
      color: white;
      background-color: transparent !important  ;
      font-size: revert;
   }
      
   #series_container .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1; left:1%; color: white; border: none; cursor: pointer;  font-size:25px; }
   .vjs-icon-hd:before{display:none;}

   div.next-episode{
        position: absolute;
        bottom: 19%;
        right: 0;
        z-index: 9;
        background-color: #fff !important;
        color: #000 !important;
        border: none;
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
        font-size: 15px;
    }

    .cancel_card{
        position: absolute;
        /* top: 30%; */
        /* left: 30%; */
        z-index: 999;
        height: 100%;
        /* background-color: #f5f5f5; */
    }
    .cancel_card .d-flex{height: 70%;flex-direction: column;gap: 2rem;}
    .cancel_card h5{color: red !important;}
    button.next-epi-cancel{
        width: 20%;
        align-items: center;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        margin-top: 1em;
        z-index: 999;
        cursor: pointer;
    }
    a.epi-name.mt-3.mb-0.btn i{color: #fff !important;}
    #subscribers_only{
      height: calc(100vh - 55px);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    #subscribers_only h2{font-size: 30px;font-weight: 900;color: #fff !important;}
    #subscribers_only h6{font-size: 20px;font-weight: 500;color: #fff !important;}
</style>

<?php
   $series= App\series::where('id',$episode->series_id)->first();
   $SeriesSeason= App\SeriesSeason::where('id',$episode->season_id)->first();
   // dd($SeriesSeason);
?>
<input type="hidden" value="<?php echo URL::to('/');?>" id="base_url" >
<input type="hidden" value="<?php echo URL::to('/'); ?>" id="base_url" >
<input type="hidden" id="videoslug" value="<?php if (isset($episode->path))
   {
       echo $episode->path;
   }
   else
   {
       echo "0";
   } ?>">

@if(!empty($next_episode))
   @php
      $next_episode_slug = URL::to('episode/'.$series->slug.'/'.$next_episode->slug)
   @endphp
@endif


<input type="hidden" value="<?php echo $episode->type; ?>" id='episode_type'>
<div id="series_bg">
   <div class="">
      <?php
         if (Auth::guest()){
         
            if ($episode_play_access > 0 ){
                  // dd($free_episode);
                  if ($series->access == 'guest' ||  $episode_play_access > 0): ?>

                        <div id="series_container" class="fitvid" style="position: relative;">
                           <button class="staticback-btn" onclick="history.back()" title="Back Button">
                                 <i class="fa fa-chevron-left" aria-hidden="true"></i>
                           </button>
   
                           <div class="vjs-title-bar">{{$episode_details->title}}</div>
   
                           <button class="custom-skip-forward-button">
                                 <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                           </button>
   
                           <button class="custom-skip-backward-button">
                                 <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                           </button>

                           @if(!empty($next_episode))
                              <div class="next-episode" onclick="window.location.href = ' {{ $next_episode_slug }}' " style="display:none;">
                                 Next Episode
                              </div>

                              <div class="card cancel_card container-fluid" style="display: none;">
                                 <div class="d-flex align-items-center justify-content-center">
                                       <h5 style="color: red !important;">{{ "Next Episode" }}</h5>
                                       <h2 class="text-white" style="color: #fff !important;">{{ $next_episode->title }}</h2>
                                       {{-- <button class="next-epi-cancel">Cancel</button> --}}
                                 </div>
                                 
                              </div>
                           @endif

                           <video id="episode-player" class="vjs-big-play-centered vjs-theme-city my-video video-js vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive"
                              controls preload="auto" width="auto" height="auto" playsinline="playsinline"
                              muted="muted" preload="yes" autoplay="autoplay"
                              poster="<?= $episode_details->Player_thumbnail ?>">
                              <source src="<?= $episode_details->Episode_url ?>"
                                 type="<?= $episode_details->Episode_player_type ?>">
                           </video>
                        </div>

                     <?php if ($episode->type == 'embed'): ?>
                           <div id="series_container" class="fitvid">
                              <?=$episode->embed_code ?>
                           </div>
                               
                        <?php
                     endif; ?>

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
                     <div id="subscribers_only"style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)) , url(<?=URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover;">
                        <div class="container-fluid">
                           <h4 class=""><?php echo $episode->title ; ?></h4>
                           <p class=" text-white col-lg-8" style="margin:0 auto";><?php echo ($episode->episode_description) ; ?></p>
                           <h4 class=""><?php if ($series->access == 'subscriber'): ?><?php
                              elseif ($series->access == 'registered'): ?><?php echo __('Registered Users'); ?><?php
                              endif; ?>
                           </h4>
                           <div class="clear"></div>
                           <?php if (!Auth::guest() && $series->access == 'subscriber'): ?>
                              <form method="get" action="<?=URL::to('/') ?>/user/<?=Auth::user()->username ?>/upgrade_subscription">
                                 <div class="">
                                 <button id="button"><?php echo __('Become a subscriber to watch this episode'); ?></button></div>
                              </form>
                           <?php else: ?>
                              <form method="get" action="<?=URL::to('signup') ?>">
                                 <div class="container-fluid mt-3">
                                    <button id="button" class="btn btn-primary"><?php echo __('Become a Subscribe to Watch This Episode'); ?> 
                                       <?php if ($series->access == 'subscriber'): ?>
                                       <?php elseif ($series->access == 'registered'): ?>
                                          <?php echo __('for Free!'); ?>
                                       <?php endif; ?>
                                    </button>
                                 </div>
                              </form>
                           <?php endif; ?>
                        </div>
                     </div>
                  <?php endif;
               }
               else{ //dd($season);
               // dd($free_episode);
               
                  ?>
               <div id="series_container">
                     <!-- <video id="videoPlayer"  <?= $autoplay ?> class="video-js vjs-default-skin" controls preload="auto" poster="<?=URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>"  data-setup="{}" width="100%" style="width:100%;" data-authenticated="<?=!Auth::guest() ?>">
                        <source src="<?=$season[0]->trailer; ?>" type='video/mp4' label='auto' >
                        <?php  if(@$playerui_settings['subtitle'] == 1 ){ if(isset($episodesubtitles)){
                                                foreach ($episodesubtitles as $key => $episodesubtitles_file) { ?>
                           <track kind="captions" src="<?= $episodesubtitles_file->url ?>"
                              srclang="<?= $episodesubtitles_file->sub_language ?>"
                              label="<?= $episodesubtitles_file->shortcode ?>" default>
                           <?php } } } ?>
                     </video> -->
                  <div id="subscribers_only"style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)) , url(<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover;">
                        <div class="container-fluid 1">
                           <div class="col-12 p-0">
                              <h2 class=""><?php echo $episode->title; ?></h2>
                              <div class="d-flex align-items-center">
                                 <p class="mt-3 text-white mr-3" style="opacity:0.7;";>{{ $SeriesSeason->series_seasons_name }}</p>
                                 <i class="fa fa-circle" aria-hidden="true" style="color: #fff !important;opacity:0.7; font-size:8px;"></i>
                                 <p class="mt-3 text-white ml-3" style="opacity:0.7;";>{{ 'Episode ' . $episode->episode_order }}</p>
                              </div>
                              <p class="mt-3 text-white col-lg-6 col-md-6 col-12 pl-0" style="opacity:0.7;";>{{ \Illuminate\Support\Str::limit($episode->episode_description,180) }}</p>
                           </div>
                           <div class="col-6"></div>
                              <div class="clear"></div>
                           </div>
                           <?php if( Auth::guest() && $SeriesSeason->access == 'ppv' && $series->access != 'subscriber' 
                              || Auth::guest() && $SeriesSeason->access == 'ppv' && $series->access == 'registered'  ):  ?>
                           <div class="container-fluid mt-3">
                              <!-- <button type="button"
                                 class="btn2  btn-outline-primary"><?php echo __('Purchase Now'); ?></button> -->
                              <form method="get" action="<?= URL::to('/signup') ?>">
                                    <button class="btn btn-primary" id="button"><?php echo __('▶ Purchase Now to Watch This Episode!'); ?></button>
                              </form>
                           </div>
                           <?php elseif( !Auth::guest() && $series->access == 'subscriber'):  ?>
                           <div class="container-fluid mt-3">
                           <form method="get" action="<?= URL::to('/signup') ?>">
                                    <button class="btn btn-primary" id="button"><?php echo __('▶ Become a Subscriber to Watch This Episode!'); ?></button>
                              </form>
                           </div>
                           <?php else: ?>
                           <div class="container-fluid mt-3">
                              <form method="get" action="<?= URL::to('signup') ?>" class="mt-4">
                                    <button id="button" class="btn bd"> <?php if($series->access == 'subscriber'): ?><?php echo __('▶ Become a Subscriber to Watch This Episode!'); ?>
                                       <?php elseif($series->access == 'registered'): ?><?php echo __('▶ Become a Register to Watch This Episode!'); ?><?php endif; ?></button>
                              </form>
                           </div>
                           <?php endif; ?>
               
                        </div>
                  </div>
               <?php
            }
         }
      ?>
   </div>
</div>
<input type="hidden" class="seriescategoryid" data-seriescategoryid="<?=$episode->genre_id
   ?>" value="<?=$episode->genre_id
   ?>">
<br>

<div class="row">
      <div class=" container-fluid " id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb pl-2">
                    <li class="breadcrumb-item"><a class="black-text"
                            href="<?= route('series.tv-shows') ?>"><?= ucwords(__('Series')) ?></a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    <?php foreach ($category_name as $key => $series_category_name) { ?>
                    <?php $category_name_length = count($category_name); ?>
                    <li class="breadcrumb-item">
                        <a class="black-text"
                            href="<?= route('SeriesCategory', [$series_category_name->categories_slug]) ?>">
                            <?= ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?>
                        </a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>
                    <?php } ?>

                    

                    <li class="breadcrumb-item"><a class="black-text" href="<?= route('play_series',[@$series->slug]) ?>"><?php echo strlen(@$series->title) > 50 ? ucwords(substr(@$series->title, 0, 120) . '...') : ucwords(@$series->title); ?> </a><i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i></li>

                    

                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen(@$episode->title) > 50 ? ucwords(substr(@$episode->title, 0, 120) . '...') : ucwords($episode->title); ?> </a></li>
                </ol>
            </div>
   </div>
</div>


<div class="container-fluid series-details">
   <div id="series_title">
      <div class="">
         <div class="row align-items-center">
            <?php if ($episode_play_access > 0 || $ppv_exits > 0  || Auth::guest()){
            }
            else{ ?>
               <div class="col-md-6">
                  <span class="text-white" style="font-size: 129%;font-weight: 700;"><?php echo __('Purchase to Watch the Series'); ?>:</span>
                  <?php if ($series->access == 'subscriber'): ?><?php echo __('Subscribers'); ?><?php
                     elseif ($series->access == 'registered'): ?><?php echo __('Registered Users'); ?><?php
                     endif; ?>
                  </p>
               </div>
               <div class="col-md-6">
                  <?php if (!empty($season))
                     { // dd($season[0]->ppv_price) ;
                              ?>
                        <input type="hidden" id="season_id" name="season_id" value="<?php echo $season[0]->id; ?>">
                        <button class="btn btn-primary" onclick="pay(<?php echo $season[0]->ppv_price; ?>)" >
                        <?php echo __('Purchase For'); ?> <?php echo $currency->symbol . ' ' . $season[0]->ppv_price; ?></button>
               </div>
               <?php
             }
            } ?>
            <br>
            <br>
            <br>
            <div class="col-md-6">
               <span class="your_watching" style="font-size: 120%;font-weight: 700;"><?php echo __("You're watching"); ?>:</span> 
               <p class="mb-0" style=";font-size: 80%;"><?php 
                $seasons = App\SeriesSeason::where('series_id','=',$SeriesSeason->series_id)->with('episodes')->get();
                foreach($seasons as $key=>$seasons_value){ ?>
                               <?php
                if(!empty($SeriesSeason) && $SeriesSeason->id == $seasons_value->id){ echo 'Season'.' '. ($key+1)   .' ';}  }
                $Episode = App\Episode::where('season_id','=',$SeriesSeason->id)->where('series_id','=',$SeriesSeason->series_id)->get();
                foreach($Episode as $key=>$Episode_value){  ?>
                  <?php if (!empty($episode) && $episode->id == $Episode_value->id) {
                     echo 'Episode' . ' ' . $episode->episode_order . ' ';
                  } ?>
                  <?php } ?>
               </p>
               <p class="" style=";font-size: 100%;font-weight: 700;"><?=$episode->title
                  ?></p>
               <p class="desc"><?php echo $episode->episode_description;?></p>
            </div>
            
            <div class="col-md-12">
                  <ul class="list-inline p-0 mt-4 share-icons music-play-lists">

                        <li>
                            <?php if($episode_watchlater == null){ ?>
                            <span id="<?php echo 'episode_add_watchlist_' . $episode->id; ?>" class="slider_add_watchlist" aria-hidden="true"
                                data-list="<?php echo $episode->id; ?>" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodewatchlater(this)"> <i class="fa fa-plus-circle"
                                    aria-hidden="true"></i> </span>
                            <?php }else{?>
                            <span id="<?php echo 'episode_add_watchlist_' . $episode->id; ?>" class="slider_add_watchlist" aria-hidden="true"
                                data-list="<?php echo $episode->id; ?>" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodewatchlater(this)"> <i class="fa fa-minus-circle"
                                    aria-hidden="true"></i> </span>
                            <?php } ?>
                        </li>

                        <li>
                            <?php if($episode_Wishlist == null){ ?>
                            <span id="<?php echo 'episode_add_wishlist_' . $episode->id; ?>" class="episode_add_wishlist_" aria-hidden="true"
                                data-list="<?php echo $episode->id; ?>" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodewishlist(this)"><i class="fa ri-heart-line" aria-hidden="true"></i>
                            </span>
                            <?php }else{?>
                            <span id="<?php echo 'episode_add_wishlist_' . $episode->id; ?>" class="episode_add_wishlist_" aria-hidden="true"
                                data-list="<?php echo $episode->id; ?>" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodewishlist(this)"> <i class="fa  fa-heart"
                                    aria-hidden="true"></i></span>
                            <?php } ?>
                        </li>

                        <li>
                           <?php if(empty($like_dislike->liked) || !empty($like_dislike->liked) && $like_dislike->liked == 0){ ?>
                            <span id="<?php echo 'episode_like_' . $episode->id; ?>" class="episode_like_" aria-hidden="true"
                                data-list="<?php echo $episode->id; ?>" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodelike(this)"><i class="ri-thumb-up-line" aria-hidden="true"></i>
                            </span>
                            <?php }else{?>
                            <span id="<?php echo 'episode_like_' . $episode->id; ?>" class="episode_like_" aria-hidden="true"
                                data-list="remove" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodelike(this)"> <i class="ri-thumb-up-fill"
                                    aria-hidden="true"></i></span>
                            <?php } ?>
                        </li>

                        <li>
                            <?php if(empty($like_dislike->disliked) ||  !empty($like_dislike->disliked) &&  $like_dislike->disliked == 0){ ?>
                            <span id="<?php echo 'episode_dislike_' . $episode->id; ?>" class="episode_dislike_" aria-hidden="true"
                                data-list="<?php echo $episode->id; ?>" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodedislike(this)"><i class="ri-thumb-down-line" aria-hidden="true"></i>
                            </span>

                            <?php }else{?>
                            <span id="<?php echo 'episode_dislike_' . $episode->id; ?>" class="episode_dislike_" aria-hidden="true"
                                data-list="remove" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                onclick="episodedislike(this)"> <i class="ri-thumb-down-fill"
                                    aria-hidden="true"></i></span>

                            <?php } ?>
                        </li>

                  </ul>
                </div>
               <!-- <div>
               <?php //if ( $episode->ppv_status != null && Auth::User()!="admin" || $episode->ppv_price != null  && Auth::User()->role!="admin") {
                  ?>
               <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-episode">
               <?php // echo __('Purchase for').' '.$currency->symbol.' '.$episode->ppv_price;
                  ?> </button>
               <?php //}
                  ?>
                        <br>
               </div> -->
            </div>
            <!-- <div class="clear" style="display:flex;justify-content: space-between;
               align-items: center;">
               <div> -->
               
            <div class="col-sm-12 d-flex row">
               <?php if($episode->search_tags != null ) : ?>
                  <h4 ><?php echo __('Tags'); ?>  : </h4>
                  <span class="mb-0" style=";font-size: 100%;color: white;"> <?= $episode->search_tags ?> </span>
		         <?php  endif;?>
            </div>
       

         </div>
      <div class="series-details-container"><?=$episode->details
         ?>
      </div>
      <?php if (isset($episodenext)){ ?>
            <div class="next_episode" style="display: none;"><?=$episodenext->id
               ?></div>
            <div class="next_url" style="display: none;"><?=$url
               ?></div>
            <?php
      }
      elseif (isset($episodeprev)){ ?>
         <div class="prev_episode" style="display: none;"><?=$episodeprev->id
            ?></div>
         <div class="next_url" style="display: none;"><?=$url
            ?></div>
         <?php
      } ?>

                        <!-- Comment Section -->
               
      <?php if( App\CommentSection::first() != null && App\CommentSection::pluck('episode')->first() == 1 ): ?>
         <div class="row">
            <div class="pl-3 video-list you-may-like overflow-hidden">
                  <h4 class="" style="color:#fffff;"><?php echo __('Comments');?></h4>
                  <?php include public_path('themes/default/views/comments/index.blade.php'); ?>
            </div>
         </div>
      <?php endif; ?>

      @if(count($season) > 0)
         @php
               include public_path('themes/default/views/partials/Episode/Other_episodes_list.blade.php');
         @endphp
      @endif
      @if(count($series_lists) > 0)
         @php
               include public_path('themes/default/views/partials/Episode/Recommend_series_episode_page.blade.php');
         @endphp
      @endif
      

   </div>
</div>

<div class="clear">
   <h2 id="tags">
      <?php if (isset($episode->tags))
         {
             foreach ($episode->tags as $key => $tag): ?>
      <span><a href="/episode/tag/<?=$tag->name
         ?>"><?=$tag->name
         ?></a></span><?php if ($key + 1 != count($episode->tags)): ?>,<?php
         endif; ?>
      <?php
         endforeach;
         }
         ?>
   </h2>
   <div class="clear"></div>
   <div id="social_share">
      <!--<p>Share This episode:</p>
         <?php /*include('partials/social-share.php'); */ ?>-->
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
            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;"><?php echo __('Rent Now'); ?></h4>
            <img src="<?=URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>" alt=""width="50" height="60">
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-sm-2" style="width:52%;">
                  <span id="paypal-button"></span> 
               </div>
               <?php $payment_type = App\PaymentSetting::get(); ?>
               <div class="col-sm-4">
                  <span class="badge badge-secondary p-2"><?php echo __($episodes->title); ?></span>
                  <span class="badge badge-secondary p-2"><?php echo __($episodes->age_restrict) . ' ' . '+'; ?></span>
                  <!-- <span class="badge badge-secondary p-2"><?php //echo __($video->categories->name);
                     ?></span>
                     <span class="badge badge-secondary p-2"><?php //echo __($video->languages->name);
                        ?></span> -->
                  <span class="badge badge-secondary p-2"><?php //echo __($video->duration);
                     ?></span>
                  <span class="trending-year"><?php if ($episode->year == 0)
                     {
                         echo "";
                     }
                     else
                     {
                         echo $episode->year;
                     } ?></span>
                  <button type="button" class="btn btn-primary"  data-dismiss="modal"><?php echo __($currency->symbol . ' ' . $episodes->ppv_price); ?></button>
                  <label for="method">
                     <h3><?php echo __('Payment Method'); ?></h3>
                  </label>
                  <label class="radio-inline">
                  <?php foreach ($payment_type as $payment)
                     {
                         if ($payment->live_mode == 1)
                         { ?>
                  <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if (!empty($payment->stripe_lable))
                     {
                         echo $payment->stripe_lable;
                     }
                     else
                     {
                         echo $payment->payment_type;
                     } ?>
                  </label>
                  <?php
                     }
                     elseif ($payment->paypal_live_mode == 1)
                     { ?>
                  <label class="radio-inline">
                  <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if (!empty($payment->paypal_lable))
                     {
                         echo $payment->paypal_lable;
                     }
                     else
                     {
                         echo $payment->payment_type;
                     } ?>
                  </label>
                  <?php
                     }
                     elseif ($payment->live_mode == 0)
                     { ?><
                  <input type="radio" id="tres_important" checked name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if (!empty($payment->stripe_lable))
                     {
                         echo $payment->stripe_lable;
                     }
                     else
                     {
                         echo $payment->payment_type;
                     } ?>
                  </label><br>
                  <?php
                     }
                     elseif ($payment->paypal_live_mode == 0)
                     { ?>
                  <input type="radio" id="important" name="payment_method" value="{{ $payment->payment_type }}">
                  <?php if (!empty($payment->paypal_lable))
                     {
                         echo $payment->paypal_lable;
                     }
                     else
                     {
                         echo $payment->payment_type;
                     } ?>
                  </label>
                  <?php
                     }
                     } ?>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <a onclick="pay(<?php echo $episode->ppv_price; ?>)">
            <button type="button" class="btn btn-primary" id="submit-new-cat"><?php echo __('Continue'); ?></button>
            </a>
            <button type="button" class="btn btn-primary"  data-dismiss="modal"><?php echo __('Close'); ?></button>
         </div>
      </div>
   </div>
</div>


<div class="clear"></div>
<input type="hidden" id="episode_id" value="<?php echo $episode->id; ?>">
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
   url: '<?php echo URL::to("purchase-episode"); ?>',
   method: 'post',
   data: {"_token": "<?=csrf_token(); ?>",tokenId:token.id, amount: amount , episode_id: episode_id , season_id: season_id},
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
          name: '<?php $settings = App\Setting::first(); echo $settings->website_name; ?>',
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
   .plyr--video {
   height: calc(90vh - 80px - 75px);
   max-width: none;
   width: 100%;}
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
   margin-top: -14%;
   margin-bottom: 0;
   /*margin-left: 80%;*/
   margin-right: 0;
   }
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
   $Intro_skip = App\Episode::where('id', $episode->id)
       ->first();
   $start_time = $Intro_skip->intro_start_time;
   $end_time = $Intro_skip->intro_end_time;
   $SkipIntroPermission = App\Playerui::pluck('skip_intro')->first();
   
   $StartParse = date_parse($start_time);
   $startSec = $StartParse['hour'] * 60 * 60 + $StartParse['minute'] * 60 + $StartParse['second'];
   
   $EndParse = date_parse($end_time);
   $EndSec = $EndParse['hour'] * 60 * 60 + $EndParse['minute'] * 60 + $EndParse['second'];
   
   $SkipIntroParse = date_parse($Intro_skip['skip_intro']);
   $skipIntroTime = $SkipIntroParse['hour'] * 60 * 60 + $SkipIntroParse['minute'] * 60 + $SkipIntroParse['second'];
   
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
   
   if( SkipIntroPermissions == 0 ){
   button.addEventListener("click", function(e) {
     video.currentTime = IntroskipEnd;
        $("#intro_skip").remove();  // Button Shows only one tym
     video.play();
   })
     if(AutoSkip != 1){
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
   $Recap_skip = App\Episode::where('id', $episode->id)
       ->first();
   
   $RecapStart_time = $Recap_skip->recap_start_time;
   $RecapEnd_time = $Recap_skip->recap_end_time;
   
   $SkipRecapParse = date_parse($Recap_skip['skip_recap']);
   $skipRecapTime = $SkipRecapParse['hour'] * 60 * 60 + $SkipRecapParse['minute'] * 60 + $SkipRecapParse['second'];
   
   $RecapStartParse = date_parse($RecapStart_time);
   $RecapstartSec = $RecapStartParse['hour'] * 60 * 60 + $RecapStartParse['minute'] * 60 + $RecapStartParse['second'];
   
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
   
   function episodewatchlater(ele) {
      var episode_id = $(ele).attr('data-video-id');
      var key_value = $(ele).attr('data-list');
      var id = '#episode_add_watchlist_' + key_value;
      var my_value = $(id).data('myval');

      if (my_value != "remove") {
            var url = '<?= URL::to('/episode_watchlist') ?>';
      } else if (my_value == "remove") {
            var url = '<?= URL::to('/episode_watchlist_remove') ?>';
      }

      $.ajax({
            url: url,
            type: 'get',
            data: {
               episode_id: episode_id,
            },
            success: function(data) {

               if (data.message == "Remove the Watch list") {

                  $(id).data('myval');
                  $(id).data('myval', 'remove');
                  $(id).find($(".fa")).toggleClass('fa fa-plus-circle').toggleClass('fa fa-minus-circle');

                  $("body").append(
                        '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to watchlater</div>'
                        );
                  setTimeout(function() {
                        $('.add_watch').slideUp('fast');
                  }, 3000);

               } else if (data.message == "Add the Watch list") {
                  $(id).data('myval');
                  $(id).data('myval', 'add');
                  $(id).find($(".fa")).toggleClass('fa fa-minus-circle').toggleClass('fa fa-plus-circle');

                  $("body").append(
                        '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from watchlater</div>'
                        );
                  setTimeout(function() {
                        $('.remove_watch').slideUp('fast');
                  }, 3000);
               } 
            }
      })
   }

   function episodewishlist(ele) {

         var episode_id = $(ele).attr('data-video-id');
         var key_value = $(ele).attr('data-list');
         var id = '#episode_add_wishlist_' + key_value;
         var my_value = $(id).data('myval');

         if (my_value != "remove") {
               var url = '<?= URL::to('/episode_wishlist') ?>';
         } else if (my_value == "remove") {
               var url = '<?= URL::to('/episode_wishlist_remove') ?>';
         }

         $.ajax({
               url: url,
               type: 'get',
               data: {
                  episode_id: episode_id,
               },
               success: function(data) {

                  if (data.message == "Remove the Watch list") {

                     $(id).data('myval');
                     $(id).data('myval', 'remove');
                     $(id).find($(".fa")).toggleClass('fa ri-heart-line').toggleClass('fa fa-heart');

                     $("body").append(
                           '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to wishlist</div>'
                           );
                     setTimeout(function() {
                           $('.add_watch').slideUp('fast');
                     }, 3000);

                  } else if (data.message == "Add the Watch list") {
                     $(id).data('myval');
                     $(id).data('myval', 'add');
                     $(id).find($(".fa")).toggleClass('fa fa-heart').toggleClass('fa ri-heart-line');

                     $("body").append(
                           '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from wishlist</div>'
                           );
                     setTimeout(function() {
                           $('.remove_watch').slideUp('fast');
                     }, 3000);
                  } else if (data.message == "guest") {
                     window.location.replace('<?php echo URL::to('/login'); ?>');
                  }
               }
         })
   }

      function episodelike(ele) {

         var episode_id = $(ele).attr('data-video-id');
         var key_value = $(ele).attr('data-list');
         var id = '#episode_like_dislike_' + key_value;
         var my_value = $(id).data('myval');
         
         if (key_value != "remove") {
               var url = '<?= URL::to('/like-episode') ?>';
         } else if (key_value == "remove") {
               var url = '<?= URL::to('/remove_like-episode') ?>';
         }
         $.ajax({
               url: url,
               type: 'post',
               data: {
                  episode_id: episode_id,
                  _token: '<?= csrf_token() ?>'
               },
               success: function(data) {

                  if (data.message == "Removed from Liked Episode") {

                     $(id).data('myval');
                     $(id).data('myval', 'remove');
                     $(id).find($(".fa")).toggleClass('ri-thumb-up-fill').toggleClass('ri-thumb-up-line');


                     $("body").append(
                           '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Removed from Liked Episode</div>'
                           );
                     setTimeout(function() {
                           $('.remove_watch').slideUp('fast');
                     }, 3000);

                  } else if (data.message == "Added to Like Episode") {
                     $(id).data('myval');
                     $(id).data('myval', 'add');
                     $(id).find($(".fa")).toggleClass('ri-thumb-up-line').toggleClass('fri-thumb-up-fill');

                     $("body").append(
                           '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Added to Like Episode</div>'
                           );
                     setTimeout(function() {
                           $('.add_watch').slideUp('fast');
                     }, 3000);
                  } 
               }
         })
      }

      function episodedislike(ele) {

         var episode_id = $(ele).attr('data-video-id');
         var key_value = $(ele).attr('data-list');
         var id = '#episode_like_dislike_' + key_value;
         var my_value = $(id).data('myval');
         
         if (key_value != "remove") {
               var url = '<?= URL::to('/dislike-episode') ?>';
         } else if (key_value == "remove") {
               var url = '<?= URL::to('/remove_dislike-episode') ?>';
         }
         $.ajax({
               url: url,
               type: 'post',
               data: {
                  episode_id: episode_id,
                  _token: '<?= csrf_token() ?>'
               },
               success: function(data) {

                  if (data.message == "Removed from DisLiked Episode") {

                     $(id).data('myval');
                     $(id).data('myval', 'remove');
                     $(id).find($(".fa")).toggleClass('ri-thumb-down-fill').toggleClass(
                     'ri-thumb-down-line');


                     $("body").append(
                           '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Removed from DisLiked Episode</div>'
                           );
                     setTimeout(function() {
                           $('.remove_watch').slideUp('fast');
                     }, 3000);

                  } else if (data.message == "Added to DisLike Episode") {
                     $(id).data('myval');
                     $(id).data('myval', 'add');
                     $(id).find($(".fa")).toggleClass('ri-thumb-down-line').toggleClass(
                           'fri-thumb-down-fill');

                     $("body").append(
                           '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Added to DisLike Episode</div>'
                           );
                     setTimeout(function() {
                           $('.add_watch').slideUp('fast');
                     }, 3000);
                  }
               }
         })
      }

</script>

<?php
   include(public_path('themes/default/views/footer.blade.php'));
?>