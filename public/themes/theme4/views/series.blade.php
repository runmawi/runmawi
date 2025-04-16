@php
    include public_path('themes/theme4/views/header.php');
    
@endphp


<?php if(Auth::check() && !Auth::guest()): ?>
   <?php
        $user_name = Auth::user()->username;
        $user_img = Auth::user()->avatar;
        $user_avatar = $user_img !== 'default.png' ? URL::to('public/uploads/avatars/') . '/' . $user_img : URL::to('/assets/img/placeholder.webp');
    ?>
<?php endif; ?>

<style type="text/css">
    .nav-pills li a {
        color: #fff !important;
    }

    nav {
        margin: 0 auto;
        align-items: center;
    }

    .desc {
        font-size: 14px;
    }

    h1 {
        font-size: 50px !important;
        font-weight: 500;
    }

    select:invalid {
        color: grey !important;
    }

    /* select:valid {
        color: #fff !important;
    } */

    .plyr__video-wrapper::before {
        display: none;
    }

    .img-fluid {
        min-height: 0px !important;
    }

    .form-control {
        line-height: 25px !important;
        font-size: 18px !important;

    }

    .sea {
        font-size: 14px;
    }

    .pls i {
        font-size: 25px;
        font-size: 25px;
    }

    .pls ul {
        list-style: none;
    }

    .close {
        /* float: right; */
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #FF0000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        display: flex !important;
        justify-content: end !important;
    }

    .modal-content {
        background-color: transparent;
    }

    .modal-dialog {
        max-width: 900px !important;
    }

    .modal {
            top: 40px;
        }

    .ply {
        width: 40px;
    }
    .model_close-button{
        border: 2px solid;
        width: 30px;
        height: 30px;
        font-size: 27px;
    }
    .model_close-button:hover{
        background:white;
        color:black;

    }
    .drp-close.model_close-button:hover {
        transform: none;
    }
    .trending-dec.mt-2 span.text-primary{
        cursor: pointer;
    }

    /* <!-- BREADCRUMBS  */

    .bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
        content: none;
    }

    ol.breadcrumb {
        color: white;
        background-color: transparent !important;
        font-size: revert;
    }

    body.dark-theme .block-description {
        background-image: none;
        backdrop-filter: none;
    }
    .form-control:focus{
        background-color: transparent;
        box-shadow:none;
    }
     .form-control option {
        background: #121111!important;
        color: #ffffff!important;
    }
    .favorites-slider .slick-prev, #trending-slider-nav .slick-prev, .favorites-slider .slick-next, #trending-slider-nav .slick-next{top:40%;}

  /* payment modal */
  #purchase-modal-dialog{max-width: 100% !important;margin: 0;}
  #purchase-modal-dialog .modal-content{height: 100vh;}
  #purchase-modal-dialog .modal-header.align-items-center{height: 70px;border: none;}
  #purchase-modal-dialog .modal-header.align-items-center .col-12{height: 50px;}
  #purchase-modal-dialog .modal-header.align-items-center .d-flex.align-items-center.justify-content-end{height: 50px;}
  #purchase-modal-dialog .modal-header.align-items-center img{height: 100%;width: 100%;}
  .col-sm-7.col-12.details{border-radius: 10px;padding: 0 1.5rem;}
  .modal-open .modal{overflow-y: hidden;}
  div#video-purchase-now-modal{padding-right: 0 !important;}
  .movie-rent.btn{width: 100%;padding: 10px 15px;background-color: #000 !important;}
  .col-md-12.btn {margin-top: 2rem;}
  .d-flex.justify-content-between.title{border-bottom: 1px solid rgba(255, 255, 255, .5);padding: 10px 0;}
  .btn-primary-dark {
      background-color: rgba(var(--btn-primary-rgb), 0.8); /* Darker version */
  }

  .btn-primary-light {
      background-color: rgba(var(--btn-primary-rgb), 0.3); /* Lighter version */
  }
  .close-btn {color: #fff;background: #000;padding: 0;border: 2px solid #fff;border-radius: 50%;line-height: 1;width: 30px;height: 30px;cursor: pointer;outline: none;}
  .payment_btn {width: 20px;height: 20px;margin-right: 10px;}
  .quality_option {width: 15px;height: 15px;margin-right: 10px;}
  span.descript::before {content: '•';margin-right: 5px;color: white;font-size: 16px;}
  input[type="radio"].payment_btn,input[type="radio"].quality_option {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      width: 20px;
      height: 20px;
      border: 2px solid white;
      border-radius: 50%;
      background-color: transparent;
      cursor: pointer;
      position: relative;
  }

  input[type="radio"].payment_btn:checked,input[type="radio"].quality_option:checked {
      background-color: black;
      border-color: white;
  }

  input[type="radio"].payment_btn:checked::before, input[type="radio"].quality_option:checked::before {
      content: '';
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background-color: white;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
  }
  .modal-dialog {
    max-width: 695px !important;
}
div#video-js-trailer-player {
    height: 65vh !important;
}
#trailer_season{display: none;}
</style>

<?php
    $series = $series_data;
    $media_url = URL::to('play_series/' . $series->slug);
    $ThumbnailSetting = App\ThumbnailSetting::first();
?>

@php
    $season_count = App\SeriesSeason::where('series_id', $series->id)->count();
    $episode_count = App\Episode::where('series_id', $series->id)->count();
@endphp

<div id="myImage" style="background:linear-gradient(90deg, rgba(0, 0, 0, 1.3)47%, rgba(0, 0, 0, 0.3))40%, url(<?=URL::to('/') . '/public/uploads/images/' . $series->player_image ?>);background-position:right; background-repeat: no-repeat; background-size:contain; ">
    <div class="container-fluid" >
	    <div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
            <div class="row pt-3 align-items-center">
                <div class="col-md-7 pl-0">
                    <div id="series_title">
                        <div class="container-fluid pl-0">
                            <h3> {{ $series->title }} </h3>
                            <div class="row p-0 mt-3 text-white">
                                <div class="col-md-10">
                                    <?= __('Season') ?>  <span class="sea"> 1 </span>
                                    <div class="trending-dec mt-2" data-bs-toggle="modal" data-bs-target="#discription-Modal" style="cursor: pointer;">
                                        <p style="cursor: pointer;">{!! substr($series->details, 0, 250) ? html_entity_decode(substr($series->details, 0, 250)) . "..." . " <span class='text-primary'> See More </span>": html_entity_decode($series->details ) !!} </p>
                                    </div>
                                    <!-- Model for banner discription -->
                                        <div class="modal fade info_model" id='discription-Modal' tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                                <div class="container">
                                                    <div class="modal-content" style="border:none;">
                                                        <div class="modal-body">
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <img  src="<?=URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" width="100%" alt="">
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                                                <h2 class="caption-h2">{{ $series->title }}</h2>

                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                                                <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                            {{-- <span class="season_episode_numbers" style="opacity: 0.8;font-size:90%;">{{ $season_count ." Seasons - ".$episode_count. ' Episodes'  }}</span> <br> --}}
                                                                        </p>
                                                                        <div class="trending-dec mt-4">{{ html_entity_decode(strip_tags($series->details )) }}</div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="d-flex p-0 mt-3 align-items-center">
                                        

                                        <div class="pls  d-flex text-center mt-2">
                                            <ul class="p-0">
                                                <li class="share">
                                                    <span><i class="ri-share-fill"></i></span>
                                                    <div class="share-box">
                                                        <div class="d-flex align-items-center"> 
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>"
                                                                class="share-ico"><i class="ri-facebook-fill"></i>
                                                            </a>
                                                            <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>"
                                                                class="share-ico"><i class="ri-twitter-fill"></i>
                                                            </a>
                                                            <a href="#"onclick="Copy();" class="share-ico"><i
                                                                    class="ri-links-fill"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?= __('Share') ?>
                                            </ul>
                                        </div>
                                        
                                        
                                        <div class="trailerbutton pl-4" id="trailer_season">  
                                            <a class="btn btn-hover" data-video="<?= $series->trailer;?>" data-toggle="modal" data-target="#videoModal">	
                                                <?= __("Play Trailer") ?>
                                            </a>
                                        </div>

                                        <?php if( Auth::guest() && $series->access == 'guest' || $ppv_exits > 0 || $video_access == "free" || $series->access == 'guest' && $series->ppv_status != 1 || ( ($series->access == 'subscriber' && $series->ppv_status != 1 || $series->access == 'registered' && $series->ppv_status != 1 ) 
                                            && !Auth::guest() && Auth::user()->subscribed()) && $series->ppv_status != 1 || (!Auth::guest() && (Auth::user()->role == 'demo' && $series->ppv_status != 1 || 
                                            Auth::user()->role == 'admin') ) || (!Auth::guest() && $series->access == 'registered' && 
                                            $settings->free_registration && !Auth::guest() && Auth::user()->role != 'registered' && $series->ppv_status != 1) 
                                            || $series->access == 'subscriber' && !Auth::guest() && Auth::user()->role == 'subscriber' || !Auth::guest() && $settings->enable_ppv_rent == 1 && Auth::user()->role == 'subscriber'):  ?>
                                    
                                                <?php foreach($season as $key => $seasons): ?>
                                                    <div id="season_ppv_status_btns_" class="ml-4 episodes_div season_<?= $seasons->id;?>">
                                                        <?php
                                                        // Calculate episode play access inside the loop
                                                        if (Auth::check()) {
                                                            $ppv_purchase_user = App\PpvPurchase::where('season_id','=',$seasons->id)->where('user_id', Auth::user()->id)
                                                                                ->select('user_id', 'season_id')
                                                                                ->first();
                
                
                                                                $ppv_purchase = App\PpvPurchase::where('season_id','=',$seasons->id)->orderBy('created_at', 'desc')
                                                                ->where('user_id', Auth::user()->id)
                                                                ->first();
                                                        
                                                                if(!empty($ppv_purchase) && !empty($ppv_purchase->to_time)){
                                                                    $new_date = \Carbon\Carbon::parse($ppv_purchase->to_time)->format('M d , y H:i:s');
                                                                    $currentdate = date("M d , y H:i:s");
                                                                    $ppv_exists_check_query = $new_date > $currentdate ?  1 : 0;
                                                                }
                                                                else{
                                                                    $ppv_exists_check_query = 0;
                                                                }    
                                                    
                                            
                                                        } else {
                                                            $ppv_purchase_user = null; 
                                                        }
                                                        $setting_subscirbe_series_access = App\Setting::pluck('enable_ppv_rent_series')->first();
                                                        $season_access_ppv = App\SeriesSeason::where('id', $seasons->id)->pluck('access')->first();
                                                        
                                                        if($season_access_ppv == "free" || Auth::check() && Auth::user()->role == "admin") {
                                                            $episode_play_access = 1;
                                                        } else {
                
                                                            if(Auth::guest()) {
                                                                $episode_play_access = 0;
                                                            } elseif(Auth::user()->role == "registered") {
                                                                if($ppv_purchase_user && $ppv_purchase_user->season_id == $seasons->id || $ppv_exists_check_query > 0) {
                                                                    $episode_play_access = 1;
                                                                } else {
                                                                    $episode_play_access = 0;
                                                                }
                                                            } elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 1) {
                                                                $episode_play_access = 1;
                                                            } elseif(Auth::user()->role == "subscriber" && $setting_subscirbe_series_access == 0) {
                                                                if($ppv_purchase_user && $ppv_purchase_user->season_id == $seasons->id || $ppv_exists_check_query > 0) {
                                                                    $episode_play_access = 1;
                                                                } else {
                                                                    $episode_play_access = 0;
                                                                }
                                                            }
                                                        }
                                                        ?>
                
                                                        <?php if($episode_play_access == 0): ?>
                                                            <?php if($series->access == "guest" && $seasons->access == "ppv"): ?>
                                                                <?php if(Auth::guest() && $seasons->access == "ppv"): ?>
                                                                    <div class="d-flex">
                                                                    <?php if($subscribe_btn == 1): ?>
                                                                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                                            <button id="button" class="view-count rent-video btn btn-hover mr-4 text-white"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                                        </form>
                                                                        <?php endif; ?>
                                                                        <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn btn-hover">
                                                                            <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?>
                                                                        </button>
                                                                    </div>
                                                                <?php elseif(Auth::check() && Auth::user()->role == "registered" && $seasons->access == "ppv"): ?>
                                                                    <div class="d-flex">
                                                                    <?php if($subscribe_btn == 1): ?>
                                                                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                                        <button id="button" class="view-count rent-video btn text-white bd mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                                        </form>
                                                                    <?php endif; ?>
                                                                        <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn btn-hover">
                                                                            <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?>
                                                                        </button>
                                                                    </div>
                                                                <?php elseif(Auth::check() && Auth::user()->role == "subscriber" && $settings->enable_ppv_rent_series == 0 && $seasons->access == "ppv"): ?>
                                                                    <div class="d-flex">
                                                                        <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn btn-hover">
                                                                            <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?>
                                                                        </button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php elseif($series->access == "registered" && $seasons->access == "ppv"): ?>
                                                                <?php if(Auth::check() && Auth::user()->role == "registered" && $seasons->access == "ppv"): ?>
                                                                    <div class="d-flex">
                                                                    <?php if($subscribe_btn == 1): ?>
                                                                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                                        <button id="button" class="view-count rent-video btn btn-hover text-white mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                                        </form>
                                                                    <?php endif; ?>
                                                                        <a class="btn btn-hover" data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>">
                                                                            <div class="playbtn text-white" style="gap:5px">
                                                                                <span class="text pr-2"> <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?> </span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                <?php elseif(Auth::check() && Auth::user()->role == "subscriber" && $settings->enable_ppv_rent_series == 0 && $seasons->access == "ppv"): ?>
                                                                    <div class="d-flex">
                                                                        <a class="btn btn-hover" data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>">
                                                                            <div class="playbtn text-white" style="gap:5px">
                                                                                <span class="text pr-2"> <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?> </span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php elseif($series->access == "subscriber" && $seasons->access == "ppv"): ?>
                                                                <?php if($settings->enable_ppv_rent_series == 0 && $seasons->access == "ppv"): ?>
                                                                    <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn btn-hover">
                                                                        <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?>
                                                                    </button>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>

                                        <?php endif; ?>
                                        
                                    </div>
                                    
                                    <!-- Season Trailer -->
                                    <div class="modal fade modal-xl videoModal" id="videoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <button type="button" class="close videoModalClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="modal-body videoModalbody">
                                                    <video id="video-js-trailer-player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls 
                                                        width="auto" height="auto">
                                                    </video>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if( Auth::guest() && $series->access == 'guest' || $ppv_exits > 0 || $video_access == "free" || $series->access == 'guest' && $series->ppv_status != 1 || ( ($series->access == 'subscriber' && $series->ppv_status != 1 || $series->access == 'registered' && $series->ppv_status != 1 ) 
                                    && !Auth::guest() && Auth::user()->subscribed()) && $series->ppv_status != 1 || (!Auth::guest() && (Auth::user()->role == 'demo' && $series->ppv_status != 1 || 
                                    Auth::user()->role == 'admin') ) || (!Auth::guest() && $series->access == 'registered' && 
                                    $settings->free_registration && !Auth::guest() && Auth::user()->role != 'registered' && $series->ppv_status != 1) 
                                    || $series->access == 'subscriber' && !Auth::guest() && Auth::user()->role == 'subscriber' || !Auth::guest() && $settings->enable_ppv_rent == 1 && Auth::user()->role == 'subscriber'):  ?>
                            
                                    

                                <?php elseif( Auth::guest() && $series->access == "subscriber"): ?>
                                    <div class="container">
                                        <h2 class="text"> 
                                            <form method="get" action="<?= URL::to('signup') ?>">
                                                <button id="button" class="view-count rent-video btn btn-hover"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                            </form>
                                        </h2>
                                    </div>

                                <?php elseif(!Auth::guest() && $series->ppv_status == 1 ||!Auth::guest() && Auth::User()->role == "subscriber"  || !Auth::guest() && Auth::User()->role == "registered" ):  ?>
                                    <div class="container">
                                        <h2 class="text" > 
                                            <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
                                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                    <button id="button" class="view-count rent-video btn btn-hover mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                </form>
                                            <?php elseif($series->ppv_status == 1 &&  Auth::User()->role == "subscriber" ): ?>
                                                <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?>
                                                <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-hover">
                                                    <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                                </button>
                                            <?php elseif($series->ppv_status == 1 ): ?>
                                                <div class="d-flex">
                                                    <?php if($subscribe_btn == 1): ?>
                                                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                            <button id="button"  class="view-count rent-video btn btn-hover mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-hover">
                                                        <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </h2>
                                    </div>

                                <?php elseif(Auth::guest() && $series->ppv_status == 1  || Auth::guest() && $series->access == "registered" ):  ?>
                                    <div class="container">
                                        <h2 class="text" > 
                                            <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
                                                <form method="get" action="<?= URL::to('/signup') ?>">
                                                    <button id="button" class="view-count rent-video btn btn-hover mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                </form>
                                            <?php elseif($series->ppv_status == 1 &&  $series->access == 'subscriber'): ?>
                                                <div class="d-flex">
                                                    <form method="get" action="<?= URL::to('/signup') ?>">
                                                        <button id="button"  class="view-count rent-video btn btn-hover mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                    </form>
                                                    <form action="<?= URL::to('/signup') ?>">
                                                        <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn btn-hover">
                                                            <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php elseif($series->ppv_status == 1 &&  $series->access == 'registered' ): ?>
                                                <div class="d-flex">
                                                    <form method="get" action="<?= URL::to('/signup') ?>">
                                                        <button id="button"  class="view-count rent-video btn btn-hover mr-4"><?php echo __(!empty($button_text->registered_text) ? $button_text->registered_text : 'Register Now'); ?></button>
                                                    </form>
                                                    <form action="<?= URL::to('/signup') ?>">
                                                        <button  data-toggle="modal" data-target="#exampleModalCenter"  class="view-count rent-video btn btn-hover">
                                                            <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php elseif($series->ppv_status == 1 &&  $series->access == 'subscriber'): ?>
                                                <div class="d-flex">
                                                    <form method="get" action="<?= URL::to('/signup') ?>">
                                                        <button id="button"  class="view-count rent-video btn btn-hover mr-4">
                                                            <?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?>
                                                        </button>
                                                    </form>
                                                    <form action="<?= URL::to('/signup') ?>">
                                                        <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter"  class="view-count rent-video btn btn-hover">
                                                            <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php elseif($series->ppv_status == 0 &&  $series->access == 'registered' ): ?>
                                                <div class="d-flex">
                                                    <form method="get" action="<?= URL::to('/signup') ?>">
                                                        <button id="button"  class="view-count rent-video btn btn-hover mr-4"><?php echo __(!empty($button_text->registered_text) ? $button_text->registered_text : 'Register Now'); ?></button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </h2>
                                    </div>

                                <?php endif; ?>

                            </div>
                        </div>
                    
                    </div>
                </div>
	        </div>
        </div>
    </div>
    <section id="tabs" class="project-tab">
	    <div class="mar-left">
            <div class="video-list you-may-like overflow-hidden">
                <div class="col-md-12 mt-4 p-0">
                    <nav class="nav-justified p-0 m-0 w-100">
                        <div class="nav mar-left" id="nav-tab" role="tablist">
                            <h4 class=""> {{ 'Episode' }} </h4>
                        </div>
                    </nav>
                </div>

                <div class="">
                    <div class="channels-list favorites-contens">
                        <div class="mar-left col-md-3 p-0 mt-4">
                            <select class="form-control" id="season_id" name="season_id">
                                @foreach ($season as $key => $seasons)
                                    <option data-key="{{ $key + 1 }}" value={{ 'season_' . $seasons->id }}>
                                        {{ $seasons->series_seasons_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="channel-row trending-contens sub_dropdown_image mt-3">
                            <div class="video-list episodes-videos" id="episodes-container">
                                @foreach ($season as $key => $seasons)
                                    @forelse ($seasons->episodes as $key => $episodes)
                                        @if ($seasons->ppv_interval > $key)
                                            <div class="item depends-row season_{{ $seasons->id }}">
                                                <a href="{{ URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug }}">
                                                    <div class=" position-relative">
                                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class="flickity-lazyloaded" alt="{{ $episodes->title}}">
                                                        <div class="controls">
                                                            <a href="{{ URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug }}">
                                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                            </a>
                                                            <!-- <nav>
                                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                                            </nav> -->
                                                                                                            
                                                            <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                {{-- <span class="season_episode_numbers" style="opacity: 0.8;font-size:90%;">{{ $seasons->series_seasons_name ." - Episode ".$episodes->episode_order  }}</span> <br> --}}
                                                                {!! (strip_tags(substr(optional($episodes)->title, 0, 150))) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @else
                                            <div class="item depends-row season_{{ $seasons->id }}"">
                                                <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                                    <div class=" position-relative">
                                                        <img src="{{ URL::to('public/uploads/images/' . $episodes->image) }}" class="flickity-lazyloaded" >
                                                        <div class="controls">
                                                            <a href="{{ URL::to('episode') . '/' . $series->slug . '/' . $episodes->slug }}">
                                                                <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                            </a>
                                                            <!-- <nav>
                                                                <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="fas fa-info-circle"  ></i><span>More info</span></button>
                                                            </nav> -->
                                                                                                            
                                                            <p class="trending-dec" style="font-weight: 600;height:auto;">
                                                                {{-- <span class="season_episode_numbers" style="opacity: 0.8;font-size:90%;">{{ $seasons->series_seasons_name ." - Episode ".$episodes->episode_order  }}</span> <br> --}}
                                                                {!! (strip_tags(substr(optional($episodes)->title, 0, 150))) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @empty
                                        <li class="slide-item col-sm-2 col-md-2 col-xs-12 episodes_div season_{{ $seasons->id }}">
                                            <div class="e-item col-lg-3 col-sm-12 col-md-6">
                                                <div class="block-image position-relative">
                                                    <img src="{{ URL::to('assets\images\episodes\No-data-amico.svg')}}" class="img-fluid transimga img-zoom" alt="">
                                                </div>
                                            </div>
                                        </li>
                                    @endforelse
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
	</section>
</div>

    @php
        include public_path('themes/theme4/views/footer.blade.php');
    @endphp
		
    <?php $payment_type = App\PaymentSetting::get(); 
        $CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first() ;
        $Paystack_payment_settings = App\PaymentSetting::where('payment_type', 'Paystack')->first();
        $Razorpay_payment_settings = App\PaymentSetting::where('payment_type', 'Razorpay')->first();
        $CinetPay_payment_settings = App\PaymentSetting::where('payment_type', 'CinetPay')->first();
    ?>



        <?php 
          foreach($season as $key => $seasons): ?>
             <div class="modal fade" 
            id="season-purchase-now-modal-<?= $seasons->id; ?>" tabindex="-1" 
            role="dialog" aria-labelledby="season-purchase-now-modal-<?= $seasons->id; ?>-Title" 
            aria-hidden="true" style="top: 0;">
            <div id="purchase-modal-dialog" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content container-fluid bg-dark">

                    <div class="modal-header align-items-center">
                        <div class="row">
                            <div class="col-12">
                                <img src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <?php if (Auth::check() && (Auth::user()->role == 'registered' || Auth::user()->role == 'subscriber' || Auth::user()->role == 'admin')): ?>
                                <img src="<?php echo $user_avatar; ?>" alt="<?php echo $user_name; ?>">
                                <h5 class="pl-4"><?php echo $user_name; ?></h5>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="row justify-content-between m-0">
                            <h3 class="font-weight-bold"><?php echo $seasons->series_seasons_name; ?></h3>
                            <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <p class="text-white">You are currently on plan.</p>
                        <div class="row justify-content-between m-0" style="gap: 4rem;">
                            <div class="col-sm-4 col-12 p-0">
                                <img class="img__img w-100" src="<?php echo $seasons->image; ?>" class="img-fluid" alt="<?php echo $seasons->series_seasons_name; ?>" style="border-radius: 10px;">
                            </div>

                            <div class="col-sm-7 col-12 details">
                                <div class="movie-rent btn">
                                    <div class="d-flex justify-content-between title">
                                        <h3 class="font-weight-bold"><?php echo $seasons->series_seasons_name; ?></h3>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="col-8 d-flex justify-content-start p-0">
                                            <span class="descript text-white"><?php echo $ppv_series_description; ?></span>
                                        </div>
                                        <div class="col-4">
                                            <h3 class="pl-2" style="font-weight:700;" id="price-display">
                                                <?php echo $currency->enable_multi_currency == 1 ? Currency_Convert($seasons->ppv_price) : $currency->symbol .$seasons->ppv_price; ?>
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="mb-0 mt-3 p-0 text-left">
                                        <input type="radio" id="stripe_radio" name="roku_tvcode" value="Stripe">
                                        <label for="roku_tvcode">Roku Tvcode</label><br>
                                        <input type="text" id="roku_tvcode_input" name="roku_tvcode" placeholder="Enter Roku TV code" style="display: none;">
                                    </div>

                                    <div class="mb-0 mt-3 p-0 text-left">
                                        <h5 style="font-size:17px;line-height: 23px;" class="text-white mb-2">Select payment method:</h5>
                                    </div>

                                    <!-- Stripe Button -->
                                    <?php if ($stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe'): ?>
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                            <input type="radio" class="payment_btn" id="tres_important" name="payment_method" value="<?php echo $stripe_payment_setting->payment_type; ?>" data-value="stripe">
                                            <?php echo !empty($stripe_payment_setting->stripe_lable) ? $stripe_payment_setting->stripe_lable : 'Stripe'; ?>
                                        </label>
                                    <?php endif; ?>

                                    <!-- PayPal Button -->
                                    <?php if ($paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                            <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $paypal_payment_setting->payment_type; ?>" data-value="PayPal">
                                            <?php echo !empty($paypal_payment_setting->paypal_lable) ? $paypal_payment_setting->paypal_lable : 'Paypal'; ?>
                                        </label>
                                    <?php endif; ?>

                                    <!-- Razorpay Button -->
                                    <?php if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay'): ?>
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                            <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $Razorpay_payment_setting->payment_type; ?>" data-value="Razorpay">
                                            <?php echo !empty($Razorpay_payment_setting->razorpay_lable) ? $Razorpay_payment_setting->razorpay_lable : 'Razorpay'; ?>
                                        </label>
                                    <?php endif; ?>

                                    <!-- Paystack Button -->
                                    <?php if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack'): ?>
                                        <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                            <input type="radio" class="payment_btn" name="payment_method" value="<?php echo $Paystack_payment_setting->payment_type; ?>" data-value="Paystack">
                                            <?php echo $Paystack_payment_setting->payment_type; ?>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="becomesubs-page">
                                    <div class="Stripe_button row mt-3 justify-content-around">  
                                        <div class="Stripe_button col-md-6 col-6 btn text-white stripe_season_value" data-season-id="<?= $seasons->id ?>" data-ppv-price="<?= $seasons->ppv_price ?>">
                                           <?= ("Continue") ?>
                                       </div>
                                        <div class="Stripe_button col-md-5 col-5 btn text-white" type="button" data-dismiss="modal" aria-label="Close">
                                            <?= ("Cancel") ?>
                                        </div>
                                    </div>

                                    <div class="row mt-3 justify-content-around"> <!-- Paystack Button -->
                                        <?php if (!Auth::guest() && $paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                            <div class="paypal_button col-md-6 col-6 btn text-white paypal_pay_now" type="button" id="paypal_pay_now" onclick="paypal_checkout(<?php echo $seasons->id; ?>, <?php echo $seasons->ppv_price; ?>)">
                                                <?= ("Continue") ?>
                                            </div>
                                        <?php else :?>
                                            <a href="<?= URL::to('/login') ?>" >  <div style='#fff !important;'class="paypal_button col-md-6 col-6 btn text-white paypal_pay_now" type="button" id="paypal_pay_now" >
                                            <?= ("Continue") ?>
                                            </div></a>
                                        <?php endif; ?>

                                        <div class="paypal_button col-md-5 col-5 btn" id="paypal_pay_cancel">
                                            <button type="button" class="btn text-white paypal_pay_now" data-dismiss="modal" aria-label="Close">
                                            <?= ("Cancel") ?>
                                            </button>
                                        </div>
                                    </div>
                                        <!-- PayPal Button Container -->
                                        <div id="paypal-button-container"></div>

                                    <div div class="row mt-3 justify-content-around">  <!-- Razorpay Button -->
                                        <?php if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay'): ?>
                                        <div class="Razorpay_button col-md-6 col-6 btn text-white" type="button" onclick="location.href ='<?= URL::to('RazorpayVideoRent/' . $seasons->id . '/' . $seasons->ppv_price) ?>' ;">
                                            <?= ("Continue") ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="Razorpay_button col-md-5 col-5 btn text-white" type="button" data-dismiss="modal" aria-label="Close">
                                            <?= ("Cancel") ?>
                                        </div>
                                    </div>

                                    <div class="row mt-3 justify-content-around"> <!-- Paystack Button -->
                                        <?php if ($Paystack_payment_setting && $Paystack_payment_setting->payment_type == 'Paystack'): ?>
                                        <div class="paystack_button col-md-6 col-6 btn text-white" onclick="location.href ='<?= route('Paystack_Video_Rent', ['video_id' => $seasons->id, 'amount' => $SeriesSeason->ppv_price]) ?>' ;"> 
                                                <?= ("Continue") ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="paystack_button col-md-5 col-5 btn">
                                            <button type="button" class="btn text-white" data-dismiss="modal" aria-label="Close">
                                            <?= ("Cancel") ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

        <div class="clear"></div>
        <input type="hidden" id="episode_id" value="<?php echo @$episode->id; ?>">
        <input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key; ?>">
        <script src="https://checkout.stripe.com/checkout.js"></script>


        
<script>
    $(document).ready(function () {
        $('#roku_tvcode_input').hide();

        $(document).on('change', '#stripe_radio', function () {
            const paymentMethod = $(this).val();

            if (paymentMethod === 'Stripe') {
                $('#roku_tvcode_input').show();
            } else {
                $('#roku_tvcode_input').hide();
            }
        });
        $(document).on('click', '.stripe_season_value', function () {
            const tvCode = $('#roku_tvcode_input').val();
            const seriesSeasonId = $(this).data('season-id'); // Use $(this) to get the correct season ID
            const ppvPrice = $(this).data('ppv-price'); // Use $(this) to get the correct price

            // console.log('seriesSeasonId :' + seriesSeasonId);
            // console.log('ppvPrice :' + ppvPrice);

            const url = `<?= URL::to('Stripe_payment_series_season_PPV_Purchase') ?>/${seriesSeasonId}/${ppvPrice}?roku_tvcode=${tvCode}`;
            window.location.href = url;
        });
    });
</script>


<script>
    function paypal_checkout(seasons_id, amount) {
        $('#paypal-button-container').empty();
            $('#paypal_pay_cancel').hide();
            $('.paypal_pay_now').hide();

            paypal.Buttons({
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: amount,
                            }
                        }]
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (details) {
                        console.log(details);
                        $.ajax({
                            url: '<?= URL::to('paypal-ppv-series-season') ?>',
                            method: 'post',
                            data: {
                                _token: '<?= csrf_token() ?>',
                                amount: amount,
                                SeriesSeason_id: seasons_id,
                            },
                            success: function(response) {
                                console.log("Server response:", response);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            },
                            error: function(error) {
                                swal('error');
                            }
                        });
                    });
                },
                onError: function (err) {
                    console.error(err);
                }
            }).render('#paypal-button-container'); 
        }


    $(document).ready(function() {

        $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button,.paypal_button').hide();

        $(".payment_btn").click(function() {

            $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button,.paypal_button').hide();

            let payment_gateway = $('input[name="payment_method"]:checked').val();

            if (payment_gateway == "Stripe") {

                $('.Stripe_button').show();

            } else if (payment_gateway == "Razorpay") {

                $('.Razorpay_button').show();

            } else if (payment_gateway == "Paystack") {

                $('.paystack_button').show();

            } else if (payment_gateway == "CinetPay") {

                $('.cinetpay_button').show();
            }
            else if (payment_gateway == "PayPal") {

                $('.paypal_button').show();

            }
        });


    });

</script>

        <script>
                        window.onload = function() {
                            $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.paypal_button').hide();
                        }

                        $(document).ready(function() {

                            $(".payment_btn").click(function() {

                                $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.paypal_button').hide();

                                let payment_gateway = $('input[name="payment_method"]:checked').val();
                                // alert(payment_gateway);
                                if (payment_gateway == "Stripe") {

                                    $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.paypal_button').hide();

                                    $('.Stripe_button').show();


                                } else if (payment_gateway == "Razorpay") {

                                    $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.paypal_button').hide();

                                    $('.Razorpay_button').show();

                                } else if (payment_gateway == "Paystack") {

                                    $('.Stripe_button,.Razorpay_button,.cinetpay_button').hide();
                                    $('.paystack_button').show();
                                } else if (payment_gateway == "CinetPay") {

                                    $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.paypal_button').hide();

                                    $('.cinetpay_button').show();

                                } else if (payment_gateway == "CinetPay") {

                                    $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.paypal_button').hide();

                                    $('.cinetpay_button').show();

                                } else if (payment_gateway == "Paydunya") {

                                    $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.paypal_button').hide();

                                    $('.Paydunya_button').show();

                                } else if (payment_gateway == "PayPal") {

                                    $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button,.Paydunya_button,.Paydunya_button').hide();

                                    $('.paypal_button').show();

                                }
                            });
                        });
                    </script>
                                 
   <input type="hidden" name="publishable_key" id="publishable_key" value="<?= $publishable_key ?>">
   <input type="hidden" name="series_id" id="series_id" value="<?= $series->id ?>">
   
   <input type="hidden" name="m3u8url_datasource" id="m3u8url_datasource" value="">


   <script src="https://checkout.stripe.com/checkout.js"></script>
	
<input type="hidden" id="purchase_url" name="purchase_url" value="<?php echo URL::to("/purchase-series") ?>">
<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>


 <!-- video-js Style  -->

 <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
<link href="<?= asset('public/themes/default/assets/css/video-js/videojs.min.css') ?>" rel="stylesheet" >
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
<link href="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') ?>" rel="stylesheet" >
<link href="<?= asset('public/themes/default/assets/css/video-js/videos-player.css') ?>" rel="stylesheet" >

<!--  video-js Script  -->

<script src="<?= asset('assets/js/video-js/video.min.js') ?>"></script>
<script src="<?= asset('assets/js/video-js/videojs-contrib-quality-levels.js') ?>"></script>
<script src="<?= asset('assets/js/video-js/videojs-http-source-selector.js') ?>"></script>
<script src="<?= asset('assets/js/video-js/videojs-hls-quality-selector.min.js') ?>"></script>
<script src="<?= URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') ?>"></script>

<!-- trailer modal video pause -->
<script>
    var video = document.getElementsByClassName('vjs-tech'); 
    if (video) {
        $('.videoModalClose').on('click', function() {
            console.log('closed');
            video[0].pause();
            video[0].removeAttribute('autoplay');
        });
    }
</script>



<script>
  window.onload = function() {
        $('.Razorpay_button,.paystack_button,.Stripe_button,.cinetpay_button').hide();
    }

    $(document).ready(function() {

        $(".payment_btn").click(function() {

            $('.Razorpay_button,.Stripe_button,.paystack_button,.cinetpay_button').hide();

            let payment_gateway = $('input[name="payment_method"]:checked').val();
            // alert(payment_gateway);
            if (payment_gateway == "Stripe") {

                $('.Stripe_button').show();
                $('.Razorpay_button,.paystack_button,.cinetpay_button').hide();

            } else if (payment_gateway == "Razorpay") {

                $('.paystack_button,.Stripe_button,.cinetpay_button').hide();
                $('.Razorpay_button').show();

            } else if (payment_gateway == "Paystack") {

                $('.Stripe_button,.Razorpay_button,.cinetpay_button').hide();
                $('.paystack_button').show();
            } else if (payment_gateway == "CinetPay") {

                $('.Stripe_button,.Razorpay_button,.paystack_button').hide();
                $('.cinetpay_button').show();
            }
        });
    });
</script>


<script type="text/javascript">
var purchase_series = $('#purchase_url').val();
var publishable_key = $('#publishable_key').val();

$(document).ready(function () { 
    
    var season_trailer = '<?= $season[0]->trailer ?>';
    if(season_trailer){
        // alert('trailer: '+ season_trailer);
        $('#trailer_season').show();
    }else{
        // alert('empty: '+ season_trailer);
        $('#trailer_season').hide();
    }

	var imageseason = '<?= $season_trailer ?>' ;
var obj = JSON.parse(imageseason);
var season_id = $('#season_id').val();
$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
	// console.log('season_'+$val.id)
 
}
});


$('#season_id').change(function(){

	var season_id = $('#season_id').val();

  $.each(obj, function(i, $val){
    if('season_'+$val.id == season_id){

      let player_url = $val.trailer ;
      const parts = player_url.split('.');
      const extension = parts[parts.length - 1];
      const player_type = extension === "mp4" ? "video/mp4" : (extension === "m3u8" ? "application/x-mpegURL" : "unknown");

      if(player_url){
        $('#trailer_season').show();
      }else{
        $('#trailer_season').hide();
      }

      var player = videojs('video-js-trailer-player', {  // Video Js Player  - Trailer
          aspectRatio: '16:9',
          fluid: true,

          controlBar: {
              volumePanel: {
                  inline: false
              },

              children: {
                  'playToggle': {},
                  'liveDisplay': {},
                  'flexibleWidthSpacer': {},
                  'progressControl': {},
                  'remainingTimeDisplay': {},
                  'fullscreenToggle': {}, 
              }
          }
      });

      player.src({
        type: player_type,
        src: player_url,
      });
      
      $("#myImage").attr("src", $val.image);

      $(".sea").empty();
      var id = $val.id;
      $(".sea").html(i+1);
    }
  });

})



$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
});

function pay(amount) {
var series_id = $('#series_id').val();

var handler = StripeCheckout.configure({

key: publishable_key,
locale: 'auto',
token: function (token) {

// console.log('Token Created!!');
// console.log(token);
$('#token_response').html(JSON.stringify(token));
$.ajax({
 url: '<?php echo URL::to("purchase-series") ;?>',
 method: 'post',
 data: {"_token": "<?= csrf_token(); ?>",tokenId:token.id, amount: amount , series_id: series_id },
 success: (response) => {
   alert("You have done  Payment !");
   setTimeout(function() {
     location.reload();
   }, 2000);

 },
 error: (error) => {
   swal('error');
}
})
}
});

handler.open({
name: '<?php $settings = App\Setting::first(); echo $settings->website_name;?>',
description: 'PAY PeR VIEW',
amount: amount * 100
});
}
</script>


<script type="text/javascript">
  
	var first = $('select').val();
	$(".episodes_div").hide();
	$("."+first).show();

	$('select').on('change', function() {
		$(".episodes_div").hide();
		$("."+this.value).show();
	});

  var imageseason = '<?= $season_trailer ?>' ;

  var obj = JSON.parse(imageseason);
  var season_id = $('#season_id').val();

  $.each(obj, function(i, $val){

    if('season_'+$val.id == season_id){

        let player_url = $val.trailer ;
        const parts = player_url.split('.');
        const extension = parts[parts.length - 1];
        const player_type = extension === "mp4" ? "video/mp4" : (extension === "m3u8" ? "application/x-mpegURL" : "unknown");

        var player = videojs('video-js-trailer-player', {  // Video Js Player  - Trailer
            aspectRatio: '16:9',
            fluid: true,

            controlBar: {
                volumePanel: {
                    inline: false
                },

                children: {
                    'playToggle': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'fullscreenToggle': {}, 
                }
            }
        });

        player.on('userinactive', () => {
            $('.vjs-big-play-button').hide();
        });

        player.on('useractive', () => {
            $('.vjs-big-play-button').show();
        });



        player.src({
          type: player_type,
          src: player_url,
        });
        
        $("#myImage").attr("src", $val.image);

        $(".sea").empty();
        var id = $val.id;
        $(".sea").html(i+1);
    }
    
  });


  $('#season_id').change(function(){

    var season_id = $('#season_id').val();
    
    $.each(obj, function(i, $val)
    {
      if('season_'+$val.id == season_id){

        $("#myImage").attr("src", $val.image);

        $(".sea").empty();
        var id = $val.id;
        $(".sea").html(i + 1);
      }
    });
  })

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
</script>

<script>
    $(document).ready(function() {
        var flkty;
        
        // Initialize Flickity
        function initializeFlickity() {
            if (flkty) {
                flkty.destroy(); // Destroy existing instance
            }
            flkty = new Flickity('.episodes-videos', {
                cellAlign: 'left',
                contain: true,
                groupCells: true,
                pageDots: false,
                draggable: true,
                freeScroll: true,
                imagesLoaded: true,
                lazyload: true,
            });
        }

        // Function to show episodes of selected season
        function showEpisodes() {
            var selectedSeason = $('#season_id').val();

            // Hide all episodes
            $('.item.depends-row').hide();

            // Show only the selected season's episodes
            $('.' + selectedSeason).show();

            // Reinitialize Flickity slider
            initializeFlickity();
        }

        // Event listener for dropdown change
        $('#season_id').change(function() {
            showEpisodes();
        });

        // Initial setup on page load
        showEpisodes();
    });
</script>