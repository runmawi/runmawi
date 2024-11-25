<?php

include public_path('themes/theme5-nemisha/views/header.php');
include public_path('themes/theme5-nemisha/views/episode_ads.blade.php');

$series = App\series::first();
?>

<!-- video-js Style  -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
<!-- <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css"
    rel="stylesheet">
<link href="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/videos-player.css') ?>" rel="stylesheet">
<link href="<?= asset('public/themes/theme4/assets/css/video-js/video-end-card.css') ?>" rel="stylesheet">
<link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

<!-- video-js Script  -->

<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<!-- Video.js IMA plugin newly added-->
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-ads@6.6.4/dist/videojs.ads.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-ima@1.8.0/dist/videojs.ima.min.js"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/video.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-contrib-quality-levels.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-http-source-selector.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs.ads.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs.ima.min.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/videojs-hls-quality-selector.min.js') ?>"></script>
<script src="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') ?>"></script>
<script src="<?= asset('public/themes/theme4/assets/js/video-js/end-card.js') ?>"></script>
<script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>


<style>
    .desc p {
        color: #fff !important;
    }
    textarea.form-control {
    border: none!important;
    border-bottom: 1px solid #fff!important;
    line-height: 25px;
}
textarea.form-control {
    background-color: #fff!important;
    height: 100px;
    font-size: 18px;
    font-family: 'futurabook';
}

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
      #series_container { position: relative;}
      
</style>

<?php if (Session::has('message')): ?>
    <div id="successMessage" class="alert alert-info col-md-4" style="z-index: 999; position: fixed !important; right: 0;" ><?php  echo Session::get('message') ?></div>
<?php endif ;?>

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
 <div class="col-md-12">
 <p class="Subscribe">Play Again</p>
  <div class="play_icon">
   <a href="#" onclick="window.location.reload(true);"><i class="fa fa-play-circle" aria-hidden="true"></i></a>
  </div>
 </div>
</div> -->

<?php
$series = App\series::where('id', $episode->series_id)->first();
$SeriesSeason = App\SeriesSeason::where('id', $episode->season_id)->first();
?>

<input type="hidden" value="<?php echo $episode->type; ?>" id='episode_type'>
<input type="hidden" value="<?php echo URL::to('/'); ?>" id="base_url">
<input type="hidden" id="videoslug" value="<?php if (isset($episode->path)) {
    echo $episode->path;
} else {
    echo '0';
} ?>">
<div class="">
    <div id="series_bg" class=" mt-3">
        <div class="">
        @if (!Auth::guest())
            @if ( $free_episode > 0)
                @if ( $free_episode > 0)
                        
                    <div id="series_container" class="fitvid">
                        <button class="staticback-btn" onclick="history.back()" title="Back Button">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </button>

                        <button class="custom-skip-forward-button">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                        </button>  

                        <button class="custom-skip-backward-button">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                        </button>

                        <video id="episode-player" class="vjs-big-play-centered vjs-theme-city my-video video-js vjs-play-control customVideoPlayer vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive"
                            controls preload="auto" width="auto" height="auto" playsinline="playsinline"
                            preload="yes" autoplay="autoplay"
                            poster="<?= $episode_details->Player_thumbnail ?>">
                            <source src="<?= $episode_details->Episode_url ?>"
                                type="<?= $episode_details->Episode_player_type ?>">

                                @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1)
                                    @if(isset($episodesubtitles) && count($episodesubtitles) > 0 )
                                        @foreach ($episodesubtitles as $episodesubtitles_file)
                                            <track kind="subtitles" src="{{ $episodesubtitles_file->url }}"
                                                srclang="{{ $episodesubtitles_file->sub_language }}"
                                                label="{{ $episodesubtitles_file->shortcode }}" default>
                                        @endforeach
                                    @endif
                                @endif

                        </video>
                    </div>
                @else
                    <div id="subscribers_only" style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)) , url(<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 450px; padding-top: 150px;">
                        <div class="container-fluid">
                            <h4 class=""> {{ $episode->title }}</h4>
                            <p class=" text-white" style="margin:0 auto" ;>{{ html_entity_decode(strip_tags($episode->episode_description)) }}</p>
                            <h4 class="">
                                <!-- {{ __('Subscribe to view more') }} -->
                                @if ($episode->access == 'subscriber')
                                    {{ __('Purchase to view more') }}
                                @elseif ($episode->access == 'registered')
                                    {{ __('Subscribe to view more') }}
                                @endif
                            </h4>
                            <div class="clear"></div>
                        </div>

                        @if (!Auth::guest() && $episode->access == 'ppv')
                            <div class=" mt-3">
                            <a onclick="pay(@if($episode->access == 'ppv' && $episode->ppv_price != null && $CurrencySetting == 1){{ PPV_CurrencyConvert($episode->ppv_price) }}@elseif($episode->access == 'ppv' && $episode->ppv_price != null && $CurrencySetting == 0){{ $episode->ppv_price }}@endif)">
                                <button type="button"
                                    class="btn2  btn-outline-primary">{{ __('Purchase Now') }}</button>
                                </a>
                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                    <button class="btn btn-primary" id="button">
                                        {{ __('Subscribe to view more') }}</button>
                                </form>
                            </div>
                        @elseif (!Auth::guest() && $episode->access == 'subscriber')
                            <div class=" mt-3">
                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                    <button class="btn btn-primary" id="button">
                                        {{ __('Subscribe to view more') }}</button>
                                </form>
                            </div>
                        @else
                            <div class=" mt-3">
                                <form method="get" action="{{ URL::to('signup') }}" class="mt-4">
                                    <button id="button" class="btn bd">{{ __('Signup Now') }}
                                        @if ($series->access == 'subscriber')
                                            {{ __('to Become a Subscriber') }}
                                        @elseif($series->access == 'registered')
                                            {{ __('for Free!') }}
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif

                @else
                <?php //dd('test'); ?>
                <div id="subscribers_only"
                        style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)) , url(<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 450px; padding-top: 150px;">

                        <div class="container-fluid">
                            <h4 class=""> {{ $episode->title }}</h4>
                            <p class="mt-2 text-white" style="margin:0 auto" ;>{{ html_entity_decode(strip_tags($episode->episode_description)) }}</p>
                           
                            <div class="clear"></div>
                       
                            <!-- <h4 class=""><?php if ($series->access == 'subscriber'): ?><?php echo __('Subscribe to watch'); ?><?php elseif($episode->access == 'registered'): ?><?php echo __('Purchase to view Video'); ?>
                                <?php endif; ?></h4> -->
                            <div class="clear"></div>

                            @if( !Auth::guest()  && $SeriesSeason->access == 'ppv' && $series->access != 'subscriber')
                                <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-primary mt-3">
                                    {{ __('Purchase Now') }}
                                </button>
                            @elseif( !Auth::guest() && $series->access == 'subscriber')
                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                    <button class="btn btn-primary" id="button"><?php echo __('Subscribe to watch'); ?></button>
                                </form>
                            @else
                                <div class=" mt-3">
                                    <form method="get" action="<?= URL::to('signup') ?>" class="mt-4">
                                        <button id="button" class="btn bd"><?php echo __('Signup Now'); ?> <?php if($series->access == 'subscriber'): ?><?php echo __('to Become a Subscriber'); ?>
                                            <?php elseif($series->access == 'registered'): ?><?php echo __('for Free!'); ?><?php endif; ?></button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        

                        </div>
                       
                    </div>
                @endif
            @else
                <?php dd('test'); ?>
                <div id="subscribers_only"
                        style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1.3)) , url(<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>); background-repeat: no-repeat; background-size: cover; height: 450px; padding-top: 150px;">

                        <div class="container-fluid">
                            <h4 class=""> {{ $episode->title }}</h4>
                            <p class=" text-white" style="margin:0 auto" ;>{{ html_entity_decode(strip_tags($episode->episode_description)) }}</p>
                            <h4 class="">
                                <!-- {{ __('Subscribe to view more') }} -->
                                @if ($episode->access == 'subscriber')
                                    {{ __('Purchase to view more') }}
                                @elseif ($episode->access == 'registered')
                                    {{ __('Subscribe to view more') }}
                                @endif
                            </h4>
                            <div class="clear"></div>
                        </div>

                        @if (!Auth::guest() && $episode->access == 'ppv')
                            <div class=" mt-3">
                            <a onclick="pay(@if($episode->access == 'ppv' && $episode->ppv_price != null && $CurrencySetting == 1){{ PPV_CurrencyConvert($episode->ppv_price) }}@elseif($episode->access == 'ppv' && $episode->ppv_price != null && $CurrencySetting == 0){{ $episode->ppv_price }}@endif)">
                                <button type="button"
                                    class="btn2  btn-outline-primary">{{ __('Purchase Now') }}</button>
                                </a>
                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                    <button class="btn btn-primary" id="button">
                                        {{ __('Subscribe to view more') }}</button>
                                </form>
                            </div>
                        @elseif (!Auth::guest() && $episode->access == 'subscriber')
                            <div class=" mt-3">
                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                    <button class="btn btn-primary" id="button">
                                        {{ __('Subscribe to view more') }}</button>
                                </form>
                            </div>
                        @else
                            <div class=" mt-3">
                                <form method="get" action="{{ URL::to('signup') }}" class="mt-4">
                                    <button id="button" class="btn bd">{{ __('Signup Now') }}
                                        @if ($series->access == 'subscriber')
                                            {{ __('to Become a Subscriber') }}
                                        @elseif($series->access == 'registered')
                                            {{ __('for Free!') }}
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
            
        @endif
            
        </div>
    </div>

    <input type="hidden" class="seriescategoryid" data-seriescategoryid="<?= $episode->genre_id ?>"
        value="<?= $episode->genre_id ?>">
    <br>

    <div class="row">
        <div class="nav nav-tabs nav-fill container-fluid " id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="black-text"
                            href="<?= route('series.tv-shows') ?>"><?= ucwords('Series') ?></a>
                        <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    </li>

                    <?php foreach ($category_name as $key => $series_category_name) { ?>
                    <?php $category_name_length = count($category_name); ?>
                    <li class="breadcrumb-item">
                        <a class="black-text"
                            href="<?= route('SeriesCategory', [$series_category_name->categories_slug]) ?>">
                            <?= ucwords($series_category_name->categories_name) . ($key != $category_name_length - 1 ? ' - ' : '') ?>
                        </a>
                    </li>
                    <?php } ?>

                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>

                    <li class="breadcrumb-item"><a class="black-text" href="<?= route('play_series',[@$series->slug]) ?>"><?php echo strlen(@$series->title) > 50 ? ucwords(substr(@$series->title, 0, 120) . '...') : ucwords(@$series->title); ?> </a></li>

                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>

                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen(@$episode->title) > 50 ? ucwords(substr(@$episode->title, 0, 120) . '...') : ucwords($episode->title); ?> </a></li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container-fluid series-details">

        <div id="series_title">
            <div class="">
                <div class="row ">
                    <?php if($free_episode > 0 ||  $ppv_exits > 0 || Auth::user()->role == 'admin' ||  Auth::guest()){ 
			}else{ ?>
                    <div class="col-md-6">
                        <span class="text-white" style="font-size: 129%;font-weight: 700;">Purchase to Watch the
                            Series:</span>
                        <?php if($series->access == 'subscriber'): ?>Subscribers<?php elseif($series->access == 'registered'): ?>Registered Users<?php endif; ?>
                        </p>

                    </div>
                    <div class="col-md-6">
                        <?php if (!empty($season)) { // dd($season[0]->ppv_price) ;?>
                        <input type="hidden" id="season_id" name="season_id" value="<?php echo $season[0]->id; ?>">

                        <button class="btn btn-primary" onclick="pay(<?php echo $season[0]->ppv_price; ?>)">
                            Purchase For <?php echo $currency->symbol . ' ' . $season[0]->ppv_price; ?></button>
                    </div>
                    <?php	} } ?>
                    <br>
                    <br>
                    <br>
                    <div class="col-md-5">
                        <span class="text-white" style="font-size: 129%;font-weight: 700;">You're watching:</span>
                        <p style=";font-size: 130%;color: white;" class="desc">
                            <?php 
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


                    </div>

                    <!---<h3 style="color:#000;margin: 10px;"><?= $episode->title ?>
            

  </h3>-->

                    <div class="col-md-2 text-center text-white">
                        <!--<span class="view-count " style="float:right;">
   <i class="fa fa-eye"></i>
   <?php if(isset($view_increment) && $view_increment == true ): ?><?= $episode->views + 1 ?>
   <?php else: ?><?= $episode->views ?><?php endif; ?> Views
   </span>-->
                    </div>


                    <?php
                    $media_url = URL::to('/episode/') . '/' . $series->slug . '/' . $episode->slug;
                    $embed_media_url = URL::to('/episode/embed') . '/' . $series->slug . '/' . $episode->slug;
                    $url_path = '<iframe width="853" height="480" src="' . $embed_media_url . '"  allowfullscreen></iframe>';
                    ?>
                    <div class="col-md-5 text-right">
                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">

                            <li>
                                <?php if($episode_watchlater == null){ ?>
                                <span id="<?php echo 'episode_add_watchlist_' . $episode->id; ?>" class="slider_add_watchlist" aria-hidden="true"
                                    data-list="<?php echo $episode->id; ?>" data-myval="10"
                                    data-video-id="<?php echo $episode->id; ?>" onclick="episodewatchlater(this)"> <i
                                        class="fa fa-plus-circle" aria-hidden="true"></i> </span>
                                <?php }else{?>
                                <span id="<?php echo 'episode_add_watchlist_' . $episode->id; ?>" class="slider_add_watchlist" aria-hidden="true"
                                    data-list="<?php echo $episode->id; ?>" data-myval="10"
                                    data-video-id="<?php echo $episode->id; ?>" onclick="episodewatchlater(this)"> <i
                                        class="fa fa-minus-circle" aria-hidden="true"></i> </span>
                                <?php } ?>
                            </li>

                            <li>
                                <?php if($episode_Wishlist == null){ ?>
                                <span id="<?php echo 'episode_add_wishlist_' . $episode->id; ?>" class="episode_add_wishlist_" aria-hidden="true"
                                    data-list="<?php echo $episode->id; ?>" data-myval="10"
                                    data-video-id="<?php echo $episode->id; ?>" onclick="episodewishlist(this)"><i
                                        class="fa fa-heart-o" aria-hidden="true"></i> </span>
                                <?php }else{?>
                                <span id="<?php echo 'episode_add_wishlist_' . $episode->id; ?>" class="episode_add_wishlist_" aria-hidden="true"
                                    data-list="<?php echo $episode->id; ?>" data-myval="10"
                                    data-video-id="<?php echo $episode->id; ?>" onclick="episodewishlist(this)"> <i
                                        class="fa  fa-heart" aria-hidden="true"></i></span>
                                <?php } ?>
                            </li>
                            <li>
                                <?php if(empty($like_dislike->liked) ||  !empty($like_dislike->liked) &&  $like_dislike->liked == 0){ ?>
                                <span id="<?php echo 'episode_like_' . $episode->id; ?>" class="episode_like_" aria-hidden="true"
                                    data-list="<?php echo $episode->id; ?>" data-myval="10"
                                    data-video-id="<?php echo $episode->id; ?>" onclick="episodelike(this)"><i
                                        class="ri-thumb-up-line" aria-hidden="true"></i> </span>
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
                                    data-list="<?php echo $episode->id; ?>" data-myval="10"
                                    data-video-id="<?php echo $episode->id; ?>" onclick="episodedislike(this)"><i
                                        class="ri-thumb-down-line" aria-hidden="true"></i> </span>

                                <?php }else{?>
                                <span id="<?php echo 'episode_dislike_' . $episode->id; ?>" class="episode_dislike_" aria-hidden="true"
                                    data-list="remove" data-myval="10" data-video-id="<?php echo $episode->id; ?>"
                                    onclick="episodedislike(this)"> <i class="ri-thumb-down-fill"
                                        aria-hidden="true"></i></span>

                                <?php } ?>
                            </li>
                            <li class="share">
                                <span><i class="ri-share-fill"></i></span>
                                <div class="share-box">
                                    <div class="d-flex align-items-center">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>"
                                            class="share-ico"><i class="ri-facebook-fill"></i></a>
                                        <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>"
                                            class="share-ico"><i class="ri-twitter-fill"></i></a>
                                        <!-- <a href="#"onclick="Copy();" class="share-ico"><i
                                                class="ri-links-fill"></i></a> -->
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#"onclick="Copy();" class="share-ico"><span><i
                                            class="ri-links-fill mt-1"></i></span></a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-12 desc">
                        <h2 class="trending-text big-title text-uppercase mt-3"><?= $episode->title ?></h2>
                        <p class="desc"></p><?php echo $series->details; ?>
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


                <!-- Watchlater & Wishlist -->

                <h2 id="tags">Tags:
                    <?php if(isset($episode->tags)) {
						foreach($episode->tags as $key => $tag): ?>
                    <span><a
                            href="/episode/tag/<?= $tag->name ?>"><?= $tag->name ?></a></span><?php if($key+1 != count($episode->tags)): ?>,<?php endif; ?>
                    <?php endforeach; } ?>
                </h2>
            </div>


            <div class="series-details-container"><?= $episode->details ?></div>
            <p class="desc"><?php if (strlen($episode->description) > 90) {
                echo substr($episode->description, 0, 90) . '...';
            } else {
                echo $episode->description;
            } ?></p>

            <?php if(isset($episodenext)){ ?>
            <div class="next_episode" style="display: none;"><?= $episodenext->id ?></div>
            <div class="next_url" style="display: none;"><?= $url ?></div>
            <?php }elseif(isset($episodeprev)){ ?>
            <div class="prev_episode" style="display: none;"><?= $episodeprev->id ?></div>
            <div class="next_url" style="display: none;"><?= $url ?></div>
            <?php } ?>

            <!-- Comment Section  -->

			<?php if( App\CommentSection::first() != null && App\CommentSection::pluck('episode')->first() == 1 ): ?>
				<div class="row">
					<div class=" container-fluid video-list you-may-like overflow-hidden" style="padding:0px 15px;">
						<h4 class="" style="color:#fffff;"><?php echo __('Comments'); ?> <img class="" height="30" width="30" src="<?php echo  URL::to('/assets/img/qem.png')?>" /> :</h4>
                        <?php include public_path('themes/theme5-nemisha/views/comments/index.blade.php'); ?>
					</div>
				</div>
			<?php endif; ?>

            <!-- Remaing Episodes -->

				<?php  include public_path('themes/theme5-nemisha/views/partials/Episode/Other_episodes_list.blade.php'); ?>

			<!-- Recommend Series Based on Category -->

				<?php  include public_path('themes/theme5-nemisha/views/partials/Episode/Recommend_series_episode_page.blade.php'); ?>

        </div>

        <div class="clear">
            <h2 id="tags">
                <?php if(isset($episode->tags)) {
				foreach($episode->tags as $key => $tag): ?>
                <span>
                    <a href="/episode/tag/<?= $tag->name ?>"><?= $tag->name ?></a>
                </span>

                <?php if($key+1 != count($episode->tags)): ?>,<?php endif; ?>

                <?php endforeach; }?>
            </h2>

            <div class="clear"></div>

            <div id="social_share">
                <!-- <p>Share This episode:</p> -->
                <?php /*include('partials/social-share.php'); */?>
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
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="exampleModalLongTitle"
                            style="color:#000;font-weight: 700;">Rent Now</h4>
                        <img src="<?= URL::to('/') . '/public/uploads/images/' . $episode->player_image ?>"
                            alt=""width="50" height="60">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-2" style="width:52%;">
                                <span id="paypal-button"></span>
                            </div>
                            <?php $payment_type = App\PaymentSetting::get(); ?>

                            <div class="col-sm-4">
                                <span class="badge badge-secondary p-2"><?php echo __($episode->title); ?></span>
                                <span class="badge badge-secondary p-2"><?php echo __($episode->age_restrict) . ' ' . '+'; ?></span>
                                <!-- <span class="badge badge-secondary p-2"><?php //echo __($video->categories->name);
                                ?></span>
                <span class="badge badge-secondary p-2"><?php //echo __($video->languages->name);
                ?></span> -->
                                <span class="badge badge-secondary p-2"><?php //echo __($video->duration);
                                ?></span>
                                <span class="trending-year"><?php if ($episode->year == 0) {
                                    echo '';
                                } else {
                                    echo $episode->year;
                                } ?></span>
                                <button type="button" class="btn btn-primary"
                                    data-dismiss="modal"><?php echo __($currency->symbol . ' ' . $episode->ppv_price); ?></button>
                                <label for="method">
                                    <h3>Payment Method</h3>
                                </label>
                                <label class="radio-inline">
                                    <?php  foreach($payment_type as $payment){
                          if($payment->live_mode == 1){ ?>
                                    <input type="radio" id="tres_important" checked name="payment_method"
                                        value="{{ $payment->payment_type }}">
                                    <?php if (!empty($payment->stripe_lable)) {
                                        echo $payment->stripe_lable;
                                    } else {
                                        echo $payment->payment_type;
                                    } ?>
                                </label>
                                <?php }elseif($payment->paypal_live_mode == 1){ ?>
                                <label class="radio-inline">
                                    <input type="radio" id="important" name="payment_method"
                                        value="{{ $payment->payment_type }}">
                                    <?php if (!empty($payment->paypal_lable)) {
                                        echo $payment->paypal_lable;
                                    } else {
                                        echo $payment->payment_type;
                                    } ?>
                                </label>
                                <?php }elseif($payment->live_mode == 0){ ?>< <input type="radio" id="tres_important" checked
                                    name="payment_method" value="{{ $payment->payment_type }}">
                                    <?php if (!empty($payment->stripe_lable)) {
                                        echo $payment->stripe_lable;
                                    } else {
                                        echo $payment->payment_type;
                                    } ?>
                                    </label><br>
                                    <?php 
						 }elseif( $payment->paypal_live_mode == 0){ ?>
                                    <input type="radio" id="important" name="payment_method"
                                        value="{{ $payment->payment_type }}">
                                    <?php if (!empty($payment->paypal_lable)) {
                                        echo $payment->paypal_lable;
                                    } else {
                                        echo $payment->payment_type;
                                    } ?>
                                    </label>
                                    <?php  } }?>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a onclick="pay(<?php echo $episode->ppv_price; ?>)">
                            <button type="button" class="btn btn-primary" id="submit-new-cat">Continue</button>
                        </a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <input type="hidden" id="episode_id" value="<?php echo $episode->id; ?>">

    <input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key; ?>">

    <script src="https://checkout.stripe.com/checkout.js"></script>

    <script type="text/javascript">
        // videojs('videoPlayer').videoJsResolutionSwitcher(); 
        $(document).ready(function() {
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
                token: function(token) {
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    console.log('Token Created!!');
                    console.log(token);
                    $('#token_response').html(JSON.stringify(token));

                    $.ajax({
                        url: '<?php echo URL::to('purchase-episode'); ?>',
                        method: 'post',
                        data: {
                            "_token": "<?= csrf_token() ?>",
                            tokenId: token.id,
                            amount: amount,
                            episode_id: episode_id,
                            season_id: season_id
                        },
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
                name: '<?php $settings = App\Setting::first();
                echo $settings->website_name; ?>',
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

        pause.addEventListener('timeupdate', function() {
            if (Auth != false) {
                if (access == 'guest' && duration !== null) {
                    if (pause.currentTime >= duration) {
                        pause.pause();
                        $("video#videoPlayer").hide();
                        $(".free_content").show();
                    }
                }
            }
        }, false);
    </script>

    <style>
        .free_content {
            margin: 100px;
            border: 1px solid red;
            padding: 5% !important;
            border-radius: 5px;
        }

        .btn-primary {
            background: rgba(45, 44, 44, 1) !important;
            border-color: #6c757d !important;
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

        .plyr--video {
            height: calc(100vh - 80px - 75px);
            max-width: none;
            width: 100%;
        }

        .intro_skips,
        .Recap_skip {
            position: absolute;
            margin-top: -14%;
            margin-bottom: 0;
            margin-left: 80%;
            margin-right: 0;
            display: none;
        }

        input.skips,
        input#Recaps_Skip {
            background-color: #21252952;
            color: white;
            padding: 15px 32px;
            text-align: center;
            margin: 4px 2px;
            display: none;
        }

        #intro_skip {
            display: none;
        }

        #Auto_skip {
            display: none;
        }

        .slick-track {
            width: 0 auto !important;

        }

        #series_bg {
            padding: 20px;
            background: #202933;
            border-radius: 20px;
        }
    </style>

    <!-- INTRO SKIP  -->

    <?php
    $Auto_skip = App\HomeSetting::first();
    $Intro_skip = App\Episode::where('id', $episode->id)->first();
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

        if (SkipIntroPermissions == 0) {
            button.addEventListener("click", function(e) {
                video.currentTime = IntroskipEnd;
                $("#intro_skip").remove(); // Button Shows only one tym
                video.play();
            })
            if (AutoSkip != 1) {
                this.video.addEventListener('timeupdate', (e) => {
                    document.getElementById("intro_skip").style.display = "none";
                    document.getElementById("Auto_skip").style.display = "none";
                    var RemoveSkipbutton = End + 1;

                    if (Start <= e.target.currentTime && e.target.currentTime < End) {
                        document.getElementById("intro_skip").style.display = "block"; // Manual skip
                    }
                    if (RemoveSkipbutton <= e.target.currentTime) {
                        $("#intro_skip").remove(); // Button Shows only one tym
                    }
                });
            } else {
                this.video.addEventListener('timeupdate', (e) => {
                    document.getElementById("Auto_skip").style.display = "none";
                    document.getElementById("intro_skip").style.display = "none";

                    var before_Start = Start - 5;
                    var trigger = Start - 1;
                    if (before_Start <= e.target.currentTime && e.target.currentTime < Start) {
                        document.getElementById("Auto_skip").style.display = "block";
                        if (trigger <= e.target.currentTime) {
                            document.getElementById("intro_skip").click(); // Auto skip
                        }
                    }
                });
            }
        }
    </script>

    <!-- Recap video skip -->

    <?php
    $Recap_skip = App\Episode::where('id', $episode->id)->first();
    
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
        var RecapValue = $("#Recaps_Skip").val();

        button.addEventListener("click", function(e) {
            videoId.currentTime = RecapskipEnd;
            $("#Recaps_Skip").remove(); // Button Shows only one tym
            videoId.play();
        })
        this.videoId.addEventListener('timeupdate', (e) => {
            document.getElementById("Recaps_Skip").style.display = "none";

            var RemoveRecapsbutton = RecapEnd + 1;
            if (RecapStart <= e.target.currentTime && e.target.currentTime < RecapEnd) {
                document.getElementById("Recaps_Skip").style.display = "block";
            }

            if (RemoveRecapsbutton <= e.target.currentTime) {
                $("#Recaps_Skip").remove(); // Button Shows only one tym
            }
        });
    </script>

    <!-- Watchlater & wishlist -->

    <!-- Watchlater & wishlist -->

    <script>
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
                            '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to Watch Later</div>'
                        );
                        setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                        }, 3000);

                    } else if (data.message == "Add the Watch list") {
                        $(id).data('myval');
                        $(id).data('myval', 'add');
                        $(id).find($(".fa")).toggleClass('fa fa-minus-circle').toggleClass('fa fa-plus-circle');

                        $("body").append(
                            '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from Watch Later</div>'
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
                        $(id).find($(".fa")).toggleClass('fa fa-heart-o').toggleClass('fa fa-heart');

                        $("body").append(
                            '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Episode added to Wish List</div>'
                        );
                        setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                        }, 3000);

                    } else if (data.message == "Add the Watch list") {
                        $(id).data('myval');
                        $(id).data('myval', 'add');
                        $(id).find($(".fa")).toggleClass('fa fa-heart').toggleClass('fa fa-heart-o');

                        $("body").append(
                            '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white; width: 20%;">Episode removed from Wish List</div>'
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
            // alert(key_value);

            // alert(my_value);
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
                    } else if (data.message == "guest") {
                        window.location.replace('<?php echo URL::to('/login'); ?>');
                    }
                }
            })
        }


        function episodedislike(ele) {
            var episode_id = $(ele).attr('data-video-id');
            var key_value = $(ele).attr('data-list');
            var id = '#episode_like_dislike_' + key_value;
            var my_value = $(id).data('myval');
            // alert(key_value);

            // alert(my_value);
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
                    } else if (data.message == "guest") {
                        window.location.replace('<?php echo URL::to('/login'); ?>');
                    }
                }
            })
        }



        function Copy() {
            var media_path = '<?= $media_url ?>';;
            var url = navigator.clipboard.writeText(window.location.href);
            var path = navigator.clipboard.writeText(media_path);
            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>'
            );
            setTimeout(function() {
                $('.add_watch').slideUp('fast');
            }, 3000);
        }

        function EmbedCopy() {
            var media_path = '<?= $url_path ?>';
            var url = navigator.clipboard.writeText(window.location.href);
            var path = navigator.clipboard.writeText(media_path);
            $("body").append(
                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embedded URL</div>'
            );
            setTimeout(function() {
                $('.add_watch').slideUp('fast');
            }, 3000);
        }
    </script>


    <?php 
        include public_path('themes/theme5-nemisha/views/footer.blade.php');
        include public_path('themes/theme5-nemisha/views/episode_player_script.blade.php');
    ?>
