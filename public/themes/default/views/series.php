<?php include('header.php'); ?>

<?php if(Auth::check() && !Auth::guest()): ?>
   <?php
        $user_name = Auth::user()->username;
        $user_img = Auth::user()->avatar;
        $user_avatar = $user_img !== 'default.png' ? URL::to('public/uploads/avatars/') . '/' . $user_img : URL::to('/assets/img/placeholder.webp');
    ?>
<?php endif; ?>
<style type="text/css">
  body{
    height:auto;
    min-height:660px; 
    max-height:1000px;
  }
	.nav-pills li a {color: #fff !important;}
    nav{
       margin: 0 auto;
        align-items: center;
    }
    .desc{
        font-size: 14px;
    }
    
    h1{
        font-size: 50px!important;
        font-weight: 500;
    }
    select:invalid { color:grey!important; }
    select:valid { color:#808080!important; }
   
    .img-fluid {
  min-height: 0px!important;
}
    .form-control{
        line-height: 25px!important;
        font-size: 18px!important;
        
    }
    .sea{
        font-size: 14px;
    }
    .pls i{
        font-size: 25px;
        font-size: 25px;
    }
    
    .pls ul{
        list-style: none;
    }
      .close {
    /* float: right; */
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #fff	;
    text-shadow: 0 1px 0 #fff;
    opacity: 1;
    display: flex!important;
    justify-content: end!important;
}
     .modal-content{
          background-color: transparent;
      }
      .modal-dialog{
          max-width:900px!important;
      }
      .modal {
          top:40px;
      }
    .ply{
        width: 40px;
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

      .modal-header {
        padding: 10px !important;

    }

    .modal-title {
        color: #000;
        font-weight: 700;
        font-size: 24px !important;
        line-height: 33px;

    }
    .modal-body {
        border-top: 1px solid rgba(0, 0, 0, 0.2) !important;
        border: none;
    }

    .modal-footer {

        border-top: 1px solid rgba(0, 0, 0, 0.2) !important;
        border: none;
    }
    .modal-body a {
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        color: #000 !important;
    }

    .modal-content {
        /* background-color: #fff; */
        border: 0px solid #F1F1F1;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        padding: 0;
    }

    .modal-dialog {
        max-width: 695px !important;
    }

    .modal {
        top: 2%;
    }
    div#myImage{height: auto;}
    #descriptionContainer p{color:#fff;margin:0;}
    div#video-js-trailer-player{height:65vh !important;}
    #series_title h1{color:#fff !important;}
    @media (min-width: 1400px) and (max-width: 2565px) {
      div#video-js-trailer-player {
            height: 50vh !important;
        }
        .modal-dialog-centered {
            max-width: 1400px !important;
        }
  }
  @media(max-width:720px){
    div#video-js-trailer-player {
        height: 25vh !important;
    }
  }

   
  /* payment modal */
  #purchase-modal-dialog{max-width: 100% !important;margin: 0;}
  #purchase-modal-dialog .modal-content{min-height: 100vh;max-height: 245vh;}
  #purchase-modal-dialog .modal-header.align-items-center{height: 70px;border: none;}
  #purchase-modal-dialog .modal-header.align-items-center .col-12{height: 50px;}
  #purchase-modal-dialog .modal-header.align-items-center .d-flex.align-items-center.justify-content-end{height: 50px;}
  #purchase-modal-dialog .modal-header.align-items-center img{height: 100%;width: 100%;}
  .col-sm-7.col-12.details{border-radius: 10px;padding: 0 1.5rem;}
  /* .modal-open .modal{overflow-y: hidden;} */
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
</style>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypal_signature; ?>"></script>

<?php 
$series = $series_data ;
$media_url = URL::to('/play_series/') . '/' . $series->slug ;
 $ThumbnailSetting = App\ThumbnailSetting::first();
 // dd($series);
 ?>
     <div id="myImage" style="background:linear-gradient(90deg, rgba(0, 0, 0, 1.3)47%, rgba(0, 0, 0, 0.3))40%, url(<?=URL::to('/') . '/public/uploads/images/' . $series->player_image ?>);background-position:right; background-repeat: no-repeat; background-size:contain; ">
     <div class="container-fluid" >
	<div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>

     <div class="row mt-3 align-items-center">
		<?php if( Auth::guest() && $series->access == 'guest' || $ppv_exits > 0 || $video_access == "free" || $series->access == 'guest' && $series->ppv_status != 1 || ( ($series->access == 'subscriber' && $series->ppv_status != 1 || $series->access == 'registered' && $series->ppv_status != 1 ) 
		&& !Auth::guest() && Auth::user()->subscribed()) && $series->ppv_status != 1 || (!Auth::guest() && (Auth::user()->role == 'demo' && $series->ppv_status != 1 || 
	 	Auth::user()->role == 'admin') ) || (!Auth::guest() && $series->access == 'registered' && 
		$settings->free_registration && !Auth::guest() && Auth::user()->role != 'registered' && $series->ppv_status != 1) 
    || $series->access == 'subscriber' && !Auth::guest() && Auth::user()->role == 'subscriber' || !Auth::guest() && $settings->enable_ppv_rent == 1 && Auth::user()->role == 'subscriber'):  ?>
		<div class="col-md-7 p-0">
			<div id="series_title">
				<div class="container-fluid" style="background: #cfcece3d;border-radius: 20px;padding: 20px;margin: 10px 0;">
					 <h1 class=""><?= $series->title ?></h1>
                  
					<!--<div class="col-md-6 p-0">
						<select class="form-control" id="season_id" name="season_id">
							<?php foreach($season_trailer as $key => $seasons): ?>
								<option value="season_<?= $seasons->id;?>">Season <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select>
					</div>-->
					<div class="row p-0 mt-3 text-white">
                        <div class="col-md-10">
                        <?= __('Season') ?>  <span class="sea"> 1 </span>
                            <!-- <p class="desc" style="color:#fff!important;"><?php echo $series->details;?></p> -->
                            <!-- <p class="trending-dec mt-2" data-bs-toggle="modal" data-bs-target="#discription-Modal"> {!! substr($series->description, 0, 200) ? html_entity_decode(substr($series->description, 0, 200)) . "..." . " <span class='text-primary'> See More </span>": html_entity_decode($series->description ) !!} </p> -->
                              

                           

                                <?php
                                  $description = $series->details;

                                  if (strlen($description) > 200) {
                                      $shortDescription = html_entity_decode(substr($description, 0, 200)) . "<span class='more-text' style='display:none;'>" . substr($description, 200) . "</span> <span class='text-primary see-more' onclick='toggleDescription()'> See More </span>";
                                  } else {
                                      $shortDescription = html_entity_decode($description);
                                  }
                                  ?>

                                  <div id="descriptionContainer" class="description-container" style="cursor:pointer;">
                                      <?php echo $shortDescription; ?>
                                  </div>


                                    <script>
                                        function toggleDescription() {
                                            var descriptionContainer = document.querySelector('.description-container');
                                            var moreText = descriptionContainer.querySelector('.more-text');
                                            var seeMoreButton = descriptionContainer.querySelector('.see-more');
                                            var myImage = document.querySelector('#myImage');

                                            if (moreText.style.display === 'none' || moreText.style.display === '') {
                                                moreText.style.display = 'inline';
                                                seeMoreButton.innerText = ' See Less ';
                                                myImage.style.height = 'auto';
                                            } else {
                                                moreText.style.display = 'none';
                                                seeMoreButton.innerText = ' See More ';
                                                
                                            }
                                        }
                                    </script>

                            <div class="d-flex p-0 mt-3 align-items-center" style="gap:3rem;">
                                <?php if(!empty($season->first()->trailer)) {?>
                                  <div class="trailerbutton">  
                                      <a class="btn" data-video="<?= $series->trailer;?>" data-toggle="modal" data-target="#videoModal">	
                                        <?= __("Play Trailer") ?>
                                      </a>
                                    </div>
                                  <?php } ?>

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
                        <div class="col-6 mb-3">
                              <?php foreach($season as $key => $seasons): ?>
                                  <div class="episodes_div season_<?= $seasons->id;?>">
                                      <?php
                                      // Calculate episode play access inside the loop
                                        if (Auth::check()) {
                                            $ppv_purchase_user = App\PpvPurchase::where('user_id', Auth::user()->id)
                                                                ->select('user_id', 'season_id')
                                                                ->get()
                                                                ->map(function ($item) {
                                                                    $payment_status = null;

                                                                    if ($item->payment_gateway == "Stripe") {
                                                                        $payment_status = 'succeeded';
                                                                    } elseif ($item->payment_gateway == "razorpay") {
                                                                        $payment_status = 'captured';
                                                                    }

                                                                    // Include the record only if status matches and it's not failed
                                                                    if ($payment_status !== null && $item->status === $payment_status) {
                                                                        return $item;
                                                                    }

                                                                    return null;
                                                                })->first();

                                                // $ppv_purchase = App\PpvPurchase::where('season_id','=',$seasons->id)->orderBy('created_at', 'desc')
                                                // ->where('user_id', Auth::user()->id)
                                                // ->first();
                                        
                                                // if(!empty($ppv_purchase) && !empty($ppv_purchase->to_time)){
                                                //     $new_date = \Carbon\Carbon::parse($ppv_purchase->to_time)->format('M d , y H:i:s');
                                                //     $currentdate = date("M d , y H:i:s");
                                                //     $ppv_exists_check_query = $new_date > $currentdate ?  1 : 0;
                                                // }
                                                // else{
                                                //     $ppv_exists_check_query = 0;
                                                // }    


                                                $current_date = \Carbon\Carbon::now()->format('Y-m-d H:i:s a');
                                                $ppv_purchase = App\PpvPurchase::where('season_id', $seasons->id)
                                                                                ->where('user_id', Auth::user()->id)
                                                                                ->where('to_time', '>', $current_date)
                                                                                ->orderBy('created_at', 'DESC')
                                                                                ->get()
                                                                                ->map(function ($item) {
                                                                                    $payment_status = null;
                                                                                    if ($item->payment_gateway == "Stripe") {
                                                                                        $payment_status = 'succeeded';
                                                                                    } elseif ($item->payment_gateway == "razorpay") {
                                                                                        $payment_status = 'captured';
                                                                                    }
                                                                                    if ($payment_status !== null) {
                                                                                        if ($item->status === $payment_status) {
                                                                                            return $item;
                                                                                        }
                                                                                        return null; 
                                                                                    }
                                                                                    return $item;
                                                                                })->first();

                                                // dd($ppv_purchase);

                                            
                                            $ppv_exists_check_query = !empty($ppv_purchase) ? 1 : 0;

                                    
                                                // dd($ppv_exists_check_query);
                           
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
                                                            <button id="button" class="view-count rent-video btn bd mr-4 text-white"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                        </form>
                                                      <?php endif; ?>
                                                      <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn bd">
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
                                                      <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn bd">
                                                          <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?>
                                                      </button>
                                                  </div>
                                              <?php elseif(Auth::check() && Auth::user()->role == "subscriber" && $settings->enable_ppv_rent_series == 0 && $seasons->access == "ppv"): ?>
                                                  <div class="d-flex">
                                                      <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn bd">
                                                          <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?>
                                                      </button>
                                                  </div>
                                              <?php endif; ?>
                                          <?php elseif($series->access == "registered" && $seasons->access == "ppv"): ?>
                                              <?php if(Auth::check() && Auth::user()->role == "registered" && $seasons->access == "ppv"): ?>
                                                  <div class="d-flex">
                                                    <?php if($subscribe_btn == 1): ?>
                                                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                                        <button id="button" class="view-count rent-video btn bd text-white mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                                        </form>
                                                    <?php endif; ?>
                                                      <a class="btn mr-3" data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>">
                                                          <div class="playbtn text-white" style="gap:5px">
                                                              <span class="text pr-2"> <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?> </span>
                                                          </div>
                                                      </a>
                                                  </div>
                                              <?php elseif(Auth::check() && Auth::user()->role == "subscriber" && $settings->enable_ppv_rent_series == 0 && $seasons->access == "ppv"): ?>
                                                  <div class="d-flex">
                                                      <a class="btn mr-3" data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>">
                                                          <div class="playbtn text-white" style="gap:5px">
                                                              <span class="text pr-2"> <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?> </span>
                                                          </div>
                                                      </a>
                                                  </div>
                                              <?php endif; ?>
                                          <?php elseif($series->access == "subscriber" && $seasons->access == "ppv"): ?>
                                              <?php if($settings->enable_ppv_rent_series == 0 && $seasons->access == "ppv"): ?>
                                                  <button data-toggle="modal" data-target="#season-purchase-now-modal-<?= $seasons->id; ?>" class="view-count rent-video btn bd">
                                                      <?=  __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now ') ?>
                                                  </button>
                                              <?php endif; ?>
                                          <?php endif; ?>
                                      <?php endif; ?>
                                  </div>
                              <?php endforeach; ?>
                          </div>
					</div>
				</div>
               
			</div>
		</div>
		<div class="col-md-6 text-center" id="theDiv">
			<!-- <img id="myImage" src="<? //URL::to('/') . '/public/uploads/images/' . $series->image; ?>" class="w-100"> -->
			<!--<img id="myImage" class="w-100" >-->
          <!--  <div id="series_container">

						 <video id="videoPlayer"  class="video-js vjs-default-skin" 
             poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" 
             controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' width="100%"
              style="width:100%;" type="video/mp4"  data-authenticated="<?= !Auth::guest() ?>">

							<p class="vjs-no-js">To view this series please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 series</a></p>
						</video>
						</div>-->
		</div>
	</div>
</div>
</div>
<section id="tabs" class="project-tab">
	<div class="container-fluid p-0">

                        <!-- BREADCRUMBS -->

    <!-- <div class="row">
        <div class="nav nav-tabs nav-fill container-fluid " id="nav-tab" role="tablist">
            <div class="bc-icons-2">
                <ol class="breadcrumb">
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
                    </li>
                    <?php } ?>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>

                    <li class="breadcrumb-item"><a class="black-text"><?php echo strlen($series->title) > 50 ? ucwords(substr($series->title, 0, 120) . '...') : ucwords($series->title); ?> </a></li>
                </ol>
            </div>
        </div>
      </div> -->

		<div class="row container-fluid mt-4">
            <div class="container-fluid mb-4">
			    <h4 class=""><?php echo __('Episode'); ?></h4>
            </div>
<!-- $series->title -->
						<div class="container-fluid">
				        <div class="favorites-contens">
                  <div class="row justify-content-between m-0">
                    <div class="col-md-3 col-6 p-0">
                      <select class="form-control" id="season_id" name="season_id">
                        <?php foreach($season as $key => $seasons): ?>
                          <option data-key="<?= $key+1 ;?>" value="season_<?= $seasons->id;?>" ><?php echo __('Season'); ?> <?= $key+1; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    
                  </div>


          <div class="series-slider home-sec list-inline row p-0 mb-0">
              <?php 
                    foreach($season as $key => $seasons):
                      foreach($seasons->episodes as $key => $episodes):
                        if($seasons->ppv_interval > $key):
							 ?>
                           
                  <div class="items episodes_div season_<?= $seasons->id;?>">
                      <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                           <div class="block-images position-relative episodes_div season_<?= $seasons->id;?>">
                              <div class="img-box">
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class="img-fluid w-100" >
                               
                              </div>
                            </div>
                            <div class="block-description" >
                              <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                  

                                  <div class="hover-buttons text-white">
                                            <a class="text-white" href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?> ">
                                                <p class="epi-name text-left m-0 mt-4">
                                                  <?php echo __(strlen($episodes->title) > 17 ? substr($episodes->title, 0, 18) . '...' : $episodes->title); ?>
                                                </p>

                                                <?php if($ThumbnailSetting->enable_description == 1 ) { ?>
                                                    <p class="desc-name text-left m-0 mt-1">
                                                        <?= strlen($episodes->episode_description) > 75 ? substr(html_entity_decode(strip_tags($episodes->episode_description)), 0, 75) . '...' : strip_tags($episodes->episode_description) ?>
                                                    </p>
                                                <?php } ?>
                                                  
                                                  <div class="movie-time d-flex align-items-center my-2">
                                                    <div class="badge p-1 mr-2"><?php echo $episodes->age_restrict ?></div>
                                                    <span class="text-white"><?= (floor($episodes->duration / 3600) > 0 ? floor($episodes->duration / 3600) . 'h ' : '') . floor(($episodes->duration % 3600) / 60) . 'm' ?></span>
                                                  </div>
                                                  <?php if($ThumbnailSetting->published_year == 1 && !($episodes->year == 0)) { ?>
                                                    <span class="position-relative badge p-1 mr-2">
                                                        <?= __($episodes->year) ?>
                                                    </span>
                                                  <?php } ?>
                                                  <?php if($ThumbnailSetting->featured == 1 && $episodes->featured == 1) { ?>
                                                            <span class="position-relative text-white">
                                                                <?= __('Featured') ?>
                                                            </span>
                                                  <?php } ?>
                                            </a>

                                        
                                              <a class="epi-name mt-3 mb-0 btn" href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?> ">
                                                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                <?= ('Watch Now') ?>
                                                </a>
                                          </div>
                            
                            </div>   
                          </a>
                        </div>
                           
                           	<?php else : ?>
                             <div class="items episodes_div season_<?= $seasons->id;?>">
                              <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                 <div class="block-images position-relative" >
                                    <div class="img-box">
                                      <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class=" img-fluid w-100" >
                                   
                                     </div>
                                    </div>
                                 
                                  <div class="block-description" >
                                    <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                        

                                        <div class="hover-buttons text-white">
                                            <a class="text-white" href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?> ">
                                                <p class="epi-name text-left m-0 mt-4">
                                                  <?php echo __(strlen($episodes->title) > 17 ? substr($episodes->title, 0, 18) . '...' : $episodes->title); ?>
                                                </p>

                                                <?php if($ThumbnailSetting->enable_description == 1 ) { ?>
                                                    <p class="desc-name text-left m-0 mt-1">
                                                        <?= strlen($episodes->episode_description) > 75 ? substr(html_entity_decode(strip_tags($episodes->episode_description)), 0, 75) . '...' : strip_tags($episodes->episode_description) ?>
                                                    </p>
                                                <?php } ?>
                                                  
                                                  <div class="movie-time d-flex align-items-center my-2">
                                                    <div class="badge p-1 mr-2"><?php echo $episodes->age_restrict ?></div>
                                                    <span class="text-white"><?= (floor($episodes->duration / 3600) > 0 ? floor($episodes->duration / 3600) . 'h ' : '') . floor(($episodes->duration % 3600) / 60) . 'm' ?></span>
                                                  </div>
                                                  <?php if($ThumbnailSetting->published_year == 1 && !($episodes->year == 0)) { ?>
                                                    <span class="position-relative badge p-1 mr-2">
                                                        <?= __($episodes->year) ?>
                                                    </span>
                                                  <?php } ?>
                                                  <?php if($ThumbnailSetting->featured == 1 && $episodes->featured == 1) { ?>
                                                            <span class="position-relative text-white">
                                                                <?= __('Featured') ?>
                                                            </span>
                                                  <?php } ?>
                                            </a>

                                        
                                              <a class="epi-name mt-3 mb-0 btn" href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?> ">
                                                  <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                <?= ('Watch Now') ?>
                                                </a>
                                          </div>
                                  
                                  </div>
                                    
                                         <!-- <h6><?= $episodes->title; ?></h6> -->
										<!--<p class="desc text-white mt-2 mb-0"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>-->
                                       <!-- <p class="date desc text-white mb-0"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>-->
										<!-- <p class="text-white desc mb-0"><?= gmdate("H:i:s", $episodes->duration); ?></p> -->
                               

                                   
                                       <div class="hover-buttons">
                                                                       <!-- <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">

                                          <span class="text-white">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Watch Now
                                          </span>
                                           </a>-->
                                           <div>
                                           <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                 
                                 </div>
                                        </div>
                                    
                              </a>
                                          </div>
                           <?php endif;	endforeach; 
						                      endforeach; ?>
                        </div>
                     </div></div>
			<?php elseif( Auth::guest() && $series->access == "subscriber"):
						
					// }
						?>
				</div> 

          <!-- <div  style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $series->image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;"> -->
			<div class="col-md-7 p-0">
				<div id="series_title">
            <div class="container">
              <h1><?= $series->title ?></h1>
              <div class="row p-0 mt-3 text-white">
                <div class="col-md-7">
                          <?php echo __('Season'); ?>  <span class="sea"> 1 </span>


                          <?php
                                  $description = $series->details;

                                  if (strlen($description) > 200) {
                                      $shortDescription = html_entity_decode(substr($description, 0, 200)) . "<span class='more-text' style='display:none;'>" . substr($description, 200) . "</span> <span class='text-primary see-more' onclick='toggleDescription()'> See More </span>";
                                  } else {
                                      $shortDescription = html_entity_decode($description);
                                  }
                                  ?>

                                  <div id="descriptionContainer" class="description-container" style="cursor:pointer;">
                                      <?php echo $shortDescription; ?>
                                  </div>

                                    <script>
                                        function toggleDescription() {
                                            var descriptionContainer = document.querySelector('.description-container');
                                            var moreText = descriptionContainer.querySelector('.more-text');
                                            var seeMoreButton = descriptionContainer.querySelector('.see-more');
                                            var myImage = document.querySelector('#myImage');

                                            if (moreText.style.display === 'none' || moreText.style.display === '') {
                                                moreText.style.display = 'inline';
                                                seeMoreButton.innerText = ' See Less ';
                                                myImage.style.height = 'auto';
                                            } else {
                                                moreText.style.display = 'none';
                                                seeMoreButton.innerText = ' See More ';
                                                
                                            }
                                        }
                                    </script>




                              <!-- <p  style="color:#fff!important;"><?php echo $series->details;?></p>
                                <b><p  style="color:#fff;"><?php echo $series->description;?></p></b> -->
                                  <div class="row ml-1 mt-3 align-items-center">
                                      <!-- <div class="col-md-2"> 
                                         <a data-video="<?php echo $series->trailer;  ?>" data-toggle="modal" data-target="#videoModal">	
                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> </a></div> -->
                                            <!--  <div class="col-md-4 text-center pls">  <a herf="">  <i class="fa fa-plus" aria-hidden="true"></i> <br>Add Wishlist</a></div>-->
                                              <div class="pls mt-2">                                             
                                                  <ul class="p-0">
                                                    <li class="share">
                                                      <span><i class="ri-share-fill"></i></span>
                                                        <div class="share-box">
                                                          <div class="d-flex align-items-center"> 
                                                          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>"
                                                                  class="share-ico"><i class="ri-facebook-fill"></i></a>
                                                              <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>"
                                                                  class="share-ico"><i class="ri-twitter-fill"></i></a>
                                                              <a href="#"onclick="Copy();" class="share-ico"><i
                                                                      class="ri-links-fill"></i></a>
                                                          </div>
                                                        </div>
                                                    </li>Share                      
                                                  </ul>
                                                </div>

                                        <div class="modal fade modal-xl" id="videoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                <button type="button" class="close videoModalClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                  <div class="modal-body">
                                                    <video id="videoPlayer1" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src=""  type="video/mp4" >
                                                    </video>
                                                    <video  id="videos" class=""  
                                                      poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>"
                                                                        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                                                                        type="application/x-mpegURL">

                                                                        <source id="m3u8urlsource"
                                                                          type="application/x-mpegURL" 
                                                                          src=""
                                                                        >

                                        </video>
                                      </div>
                                  </div>
                                </div>
                              </div>
                                
                                  </div>


              </div>
              </div>

            </div>

            <div class="container">
                <h2 class="text"> 
                    <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
                        <form method="get" action="<?= URL::to('signup') ?>">
                            <button id="button" class="view-count rent-video btn bd"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                        </form>
                    <?php elseif($series->access == 'registered'): ?>
                        <form method="get" action="<?= URL::to('signup') ?>">
                            <button id="button" class="view-count rent-video btn bd">
                                <?php echo __(!empty($button_text->registered_text) ? $button_text->registered_text : 'Register Now'); ?>
                            </button>
                        </form>
                    <?php elseif($series->ppv_status == 1): ?>
                        <div class="d-flex">
                            <form method="get" action="<?= URL::to('signup') ?>">
                                <button id="button" class="view-count rent-video btn bd mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                            </form>

                            <form method="get" action="<?= URL::to('signup') ?>">
                                <button id="button" class="view-count rent-video btn bd">
                                    <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?>
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </h2>
            </div>


				
				<div class="clear"></div>
				</div> 
				<!-- </div>  -->


				<div class="col-md-2 text-center text-white">
                <div class="col-md-4">
			<?php if ( $series->ppv_status == 1 && !Auth::guest() && Auth::User()->role !="admin") { ?>
			<button class="btn bd" onclick="pay(<?php echo $settings->ppv_price; ?>)" >
			Purchase For <?php echo $currency->symbol.' '.$settings->ppv_price; ?></button>
			<?php } ?>
            <br>
			<!-- </div> -->

        <!-- </div> -->
				</div>
				</div>
                </div>
            </div>
        </div>
        </div>
				<?php elseif(!Auth::guest() && $series->ppv_status == 1 ||!Auth::guest() && Auth::User()->role == "subscriber"  || !Auth::guest() && Auth::User()->role == "registered" ):  ?>

          <div class="col-md-7 p-0">
				    <div id="series_title">
              <div class="container">
                <h1><?= $series->title ?></h1>
                  <div class="row p-0 mt-3 text-white">
                    <div class="col-md-7">
                      <?php echo __('Season'); ?>  <span class="sea"> 1 </span>

                      <?php
                                  $description = $series->details;

                                  if (strlen($description) > 200) {
                                      $shortDescription = html_entity_decode(substr($description, 0, 200)) . "<span class='more-text' style='display:none;'>" . substr($description, 200) . "</span> <span class='text-primary see-more' onclick='toggleDescription()'> See More </span>";
                                  } else {
                                      $shortDescription = html_entity_decode($description);
                                  }
                                  ?>

                                  <div id="descriptionContainer" class="description-container" style="cursor:pointer;">
                                      <?php echo $shortDescription; ?>
                                  </div>

                                    <script>
                                        function toggleDescription() {
                                            var descriptionContainer = document.querySelector('.description-container');
                                            var moreText = descriptionContainer.querySelector('.more-text');
                                            var seeMoreButton = descriptionContainer.querySelector('.see-more');
                                            var myImage = document.querySelector('#myImage');

                                            if (moreText.style.display === 'none' || moreText.style.display === '') {
                                                moreText.style.display = 'inline';
                                                seeMoreButton.innerText = ' See Less ';
                                                myImage.style.height = 'auto';
                                            } else {
                                                moreText.style.display = 'none';
                                                seeMoreButton.innerText = ' See More ';
                                                
                                            }
                                        }
                                    </script>



                        <!-- <p  style="color:#fff!important;"><?php echo $series->details;?></p>
                        <b><p  style="color:#fff;"><?php echo $series->description;?></p></b> -->
                        <div class="row ml-1 mt-3 align-items-center">
                                        <!-- <div class="col-md-2">
                                          <a data-video="<?php echo $series->trailer;  ?>" data-toggle="modal" data-target="#videoModal">	
                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                          </a>
                                        </div> -->
                                            <!--  <div class="col-md-4 text-center pls">  <a herf="">  <i class="fa fa-plus" aria-hidden="true"></i> <br>Add Wishlist</a></div>-->
                                          <div class="pls mt-2">
                                            <div></div>
                                            <ul class="p-0">
                                              <li class="share">
                                                <span><i class="ri-share-fill"></i></span>
                                                <div class="share-box">
                                                  <div class="d-flex align-items-center"> 
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>
                                                    <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a>
                                                    <a href="#"onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
                                                  </div>
                                                </div>
                                              </li>Share                      
                                            </ul>
                                          </div>

                                          <div class="modal fade modal-xl" id="videoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <button type="button" class="close videoModalClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                  <div class="modal-body">
                                                    <video id="videoPlayer1" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src=""  type="video/mp4" > </video>
                                                    <video  id="videos" class=""  poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                                                                                        type="application/x-mpegURL">

                                                                                        <source id="m3u8urlsource"
                                                                                          type="application/x-mpegURL" 
                                                                                          src=""
                                                                                        >

                                                    </video>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                        
                        </div>
                    </div>
                </div>

              </div>
            </div>


            <div class="container">
                <h2 class="text" > 
                    <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
                        <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                            <button id="button" class="view-count rent-video btn bd mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                        </form>
                    <?php elseif($series->ppv_status == 1 &&  Auth::User()->role == "subscriber" ): ?>
                        <!-- <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter"
                                class="view-count rent-video btn btn-primary">
                            </button> -->
                        <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?>
                        <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn bd">
                            <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                        </button>
                    <?php elseif($series->ppv_status == 1 ): ?>
                        <div class="d-flex">
                            <?php if($subscribe_btn == 1): ?>
                                <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                                    <button id="button"  class="view-count rent-video btn bd mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                </form>
                            <?php endif; ?>
                            <button data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn bd">
                                <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                            </button>
                        </div>
                    <?php endif; ?>
                </h2>
            </div>
          </div>
          </div>
         
          <?php elseif(Auth::guest() && $series->ppv_status == 1  || Auth::guest() && $series->access == "registered" ):  ?>

              <div class="col-md-7 p-0">
                <div id="series_title">
                  <div class="container">
                    <h1><?= $series->title ?></h1>
                      <div class="row p-0 mt-3 text-white">
                        <div class="col-md-7">
                          <?php echo __('Season'); ?>  <span class="sea"> 1 </span>

                          <?php
                                  $description = $series->details;

                                  if (strlen($description) > 200) {
                                      $shortDescription = html_entity_decode(substr($description, 0, 200)) . "<span class='more-text' style='display:none;'>" . substr($description, 200) . "</span> <span class='text-primary see-more' onclick='toggleDescription()'> See More </span>";
                                  } else {
                                      $shortDescription = html_entity_decode($description);
                                  }
                                  ?>

                                  <div id="descriptionContainer" class="description-container" style="cursor:pointer;">
                                      <?php echo $shortDescription; ?>
                                  </div>

                                  <div class="details-show mt-3">
                                    <span><?= nl2br($series->description) ?></span>
                                  </div>

                                    <script>
                                        function toggleDescription() {
                                            var descriptionContainer = document.querySelector('.description-container');
                                            var moreText = descriptionContainer.querySelector('.more-text');
                                            var seeMoreButton = descriptionContainer.querySelector('.see-more');
                                            var myImage = document.querySelector('#myImage');

                                            if (moreText.style.display === 'none' || moreText.style.display === '') {
                                                moreText.style.display = 'inline';
                                                seeMoreButton.innerText = ' See Less ';
                                                myImage.style.height = 'auto';
                                            } else {
                                                moreText.style.display = 'none';
                                                seeMoreButton.innerText = ' See More ';
                                                
                                            }
                                        }
                                    </script>

                            <!-- <p  style="color:#fff!important;"><?php echo $series->details;?></p>
                            <b><p  style="color:#fff;"><?php echo $series->description;?></p></b> -->
                            <div class="row ml-1 mt-3 align-items-center">
                                            <!-- <div class="col-md-2">
                                              <a data-video="<?php echo $series->trailer;  ?>" data-toggle="modal" data-target="#videoModal">	
                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                              </a>
                                            </div> -->
                                                <!--  <div class="col-md-4 text-center pls">  <a herf="">  <i class="fa fa-plus" aria-hidden="true"></i> <br>Add Wishlist</a></div>-->
                                              <div class="pls mt-2">
                                                <div></div>
                                                <ul class="p-0">
                                                  <li class="share">
                                                    <span><i class="ri-share-fill"></i></span>
                                                    <div class="share-box">
                                                      <div class="d-flex align-items-center"> 
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>
                                                        <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a>
                                                        <a href="#"onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
                                                      </div>
                                                    </div>
                                                  </li>Share                      
                                                </ul>
                                              </div>

                                              <div class="modal fade modal-xl" id="videoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <button type="button" class="close videoModalClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                      <div class="modal-body">
                                                        <video id="videoPlayer1" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src=""  type="video/mp4" > </video>
                                                        <video  id="videos" class=""  poster="<?= URL::to('/') . '/public/uploads/images/' . $series->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                                                                                            type="application/x-mpegURL">

                                                                                            <source id="m3u8urlsource"
                                                                                              type="application/x-mpegURL" 
                                                                                              src=""
                                                                                            >

                                                        </video>
                                                      </div>
                                                  </div>
                                                </div>
                                              </div>
                                           
                            </div>
                        </div>
                    </div>

                  </div>
                </div>


                <div class="container">
                    <h2 class="text" > 
                        <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
                            <form method="get" action="<?= URL::to('/signup') ?>">
                                <button id="button" class="view-count rent-video btn bd mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                            </form>
                        <?php elseif($series->ppv_status == 1 &&  $series->access == 'subscriber'): ?>
                            <div class="d-flex">
                                <form method="get" action="<?= URL::to('/signup') ?>">
                                    <button id="button"  class="view-count rent-video btn bd mr-4"><?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?></button>
                                </form>
                                <form action="<?= URL::to('/signup') ?>">
                                    <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter" class="view-count rent-video btn bd">
                                        <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                    </button>
                                </form>
                            </div>
                        <?php elseif($series->ppv_status == 1 &&  $series->access == 'registered' ): ?>
                            <div class="d-flex">
                                <form method="get" action="<?= URL::to('/signup') ?>">
                                    <button id="button"  class="view-count rent-video btn bd mr-4"><?php echo __(!empty($button_text->registered_text) ? $button_text->registered_text : 'Register Now'); ?></button>
                                </form>
                                <form action="<?= URL::to('/signup') ?>">
                                    <button  data-toggle="modal" data-target="#exampleModalCenter"  class="view-count rent-video btn bd">
                                        <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                    </button>
                                </form>
                            </div>
                        <?php elseif($series->ppv_status == 1 &&  $series->access == 'subscriber'): ?>
                            <div class="d-flex">
                                <form method="get" action="<?= URL::to('/signup') ?>">
                                    <button id="button"  class="view-count rent-video btn bd mr-4">
                                        <?php echo __(!empty($button_text->subscribe_text) ? $button_text->subscribe_text : 'Subscribe Now'); ?>
                                    </button>
                                </form>
                                <form action="<?= URL::to('/signup') ?>">
                                    <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter"  class="view-count rent-video btn bd">
                                        <?php echo __(!empty($button_text->purchase_text) ? ($button_text->purchase_text) : ' Purchase Now '); ?> 
                                    </button>
                                </form>
                            </div>
                        <?php elseif($series->ppv_status == 0 &&  $series->access == 'registered' ): ?>
                            <div class="d-flex">
                                <form method="get" action="<?= URL::to('/signup') ?>">
                                    <button id="button"  class="view-count rent-video btn bd mr-4"><?php echo __(!empty($button_text->registered_text) ? $button_text->registered_text : 'Register Now'); ?></button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </h2>
                </div>
              </div>
              </div>

				<?php endif;?>
        </div>
        </div>

		</section>
<?php include('footer.blade.php');?>
		
				<?php $payment_type = App\PaymentSetting::get(); 
              $CurrencySetting = App\CurrencySetting::pluck('enable_multi_currency')->first() ;
              $Paystack_payment_settings = App\PaymentSetting::where('payment_type', 'Paystack')->first();
              $Razorpay_payment_settings = App\PaymentSetting::where('payment_type', 'Razorpay')->first();
              $CinetPay_payment_settings = App\PaymentSetting::where('payment_type', 'CinetPay')->first();

          ?>

    
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title text-center" id="exampleModalLongTitle"
                style="">Rent Now</h4>

            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

        <div class="modal-body">
            <div class="row justify-content-between">
                <div class="col-sm-4 p-0" style="">
                    <img class="img__img w-100" src="<?php echo URL::to('/') . '/public/uploads/images/' . $series->image; ?>"
                        class="img-fluid" alt="">
                </div>

                <div class="col-sm-8">
                    <h4 class=" text-black movie mb-3"><?php echo __($series->title); ?> ,
                        <span
                            class="trending-year mt-2"><?php if ($series->year == 0) {
                                echo '';
                            } else {
                                echo $series->year;
                            } ?></span>
                    </h4>
                    <span
                        class="badge badge-secondary   mb-2"><?php echo __($series->age_restrict) . ' ' . '+'; ?></span>
                    <span
                        class="badge badge-secondary  mb-2"><?php echo __(isset($series->categories->name)); ?></span>
                    <span
                        class="badge badge-secondary  mb-2"><?php echo __(isset($series->languages->name)); ?></span>
                    <span
                        class="badge badge-secondary  mb-2 ml-1"><?php echo __($series->duration); ?></span><br>

                    <a type="button" class="mb-3 mt-3" data-dismiss="modal"
                        style="font-weight:400;">Amount: <span class="pl-2"
                            style="font-size:20px;font-weight:700;">
                            <?php if(@$series->access == 'ppv' && @$settings->ppv_price != null && $CurrencySetting == 1){ echo __(Currency_Convert(@$settings->ppv_price)); }else if(@$series->access == 'ppv' && @$settings->ppv_price != null && $CurrencySetting == 0){ echo __(  currency_symbol() . @$settings->ppv_price) ; } ?></span></a><br>
                    <label class="mb-0 mt-3 p-0" for="method">
                        <h5 style="font-size:20px;line-height: 23px;"
                            class="font-weight-bold text-black mb-2">Payment Method
                            : </h5>
                    </label>

                    <?php $payment_type = App\PaymentSetting::get(); ?>

                    <!-- RENT PAYMENT Stripe,Paypal,Paystack,Razorpay,CinetPay -->

                    <?php  //foreach($payment_type as $payment){
                        $Stripepayment = App\PaymentSetting::where('payment_type', 'Stripe')->first();
                        $PayPalpayment = App\PaymentSetting::where('payment_type', 'PayPal')->first();
                        $Paydunyapayment =  App\PaymentSetting::where('payment_type','=','Paydunya')->where('paydunya_status',1)->first();
                        $Razorpay_payment_settings = App\PaymentSetting::where('payment_type', 'Razorpay')->first();
                        $CinetPay_payment_settings = App\PaymentSetting::where('payment_type', 'CinetPay')->first();
                        $Paystack_payment_settings = App\PaymentSetting::where('payment_type', 'Paystack')->first();



                            if( @$Razorpay_payment_settings->payment_type == "Razorpay"  || @$Stripepayment->payment_type == "Stripe" ||  @$PayPalpayment->payment_type == "PayPal" 
                            || @$CinetPay_payment_settings->payment_type == "CinetPay" ||  @$Paystack_payment_settings->payment_type == "Paystack" ){ 

                                if( $Stripepayment != null && $Stripepayment->live_mode == 1 && $Stripepayment->stripe_status == 1){ ?>
                                                            <!-- Stripe -Live Mode -->

                                                            <label
                                                                class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                                <input type="radio" class="payment_btn"
                                                                    id="tres_important" name="payment_method"
                                                                    value=<?= $Stripepayment->payment_type ?>
                                                                    data-value="stripe">
                                                                <?php if (!empty($Stripepayment->stripe_lable)) {
                                                                    echo $Stripepayment->stripe_lable;
                                                                } else {
                                                                    echo $Stripepayment->payment_type;
                                                                } ?>
                                                            </label> <?php }

                                elseif( $Stripepayment != null && $Stripepayment->live_mode == 0 && $Stripepayment->stripe_status == 1){ ?>
                                                            <!-- Stripe - Test Mode -->

                                                            <label
                                                                class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                                                <input type="radio" class="payment_btn"
                                                                    id="tres_important" name="payment_method"
                                                                    value="<?= $Stripepayment->payment_type ?>"
                                                                    data-value="stripe">
                                                                <!--<img class="" height="20" width="40" src="<?php echo URL::to('/assets/img/stripe.png'); ?>" style="margin-top:-5px" >-->
                                                                <?php if (!empty($Stripepayment->stripe_lable)) {
                                                                    echo $Stripepayment->stripe_lable;
                                                                } else {
                                                                    echo $Stripepayment->payment_type;
                                                                } ?>
                                                            </label> <?php }
                    
                                if(  $PayPalpayment != null &&  $PayPalpayment->paypal_live_mode == 1 && $PayPalpayment->paypal_status == 1){ ?>
                                                            <!-- paypal - Live Mode -->

                                                            <label
                                                                class="radio-inline mb-0 mt-3 d-flex align-items-center">
                                                                <input type="radio" class="payment_btn" id="important"
                                                                    name="payment_method"
                                                                    value="<?= $PayPalpayment->payment_type ?>"
                                                                    data-value="paypal">
                                                                <?php if (!empty($PayPalpayment->paypal_lable)) {
                                                                    echo $PayPalpayment->paypal_lable;
                                                                } else {
                                                                    echo $PayPalpayment->payment_type;
                                                                } ?>
                                                            </label> <?php }

                                elseif( $PayPalpayment != null &&  $PayPalpayment->paypal_live_mode == 0 && $PayPalpayment->paypal_status == 1){ ?>
                                                            <!-- paypal - Test Mode -->

                                        <label
                                            class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                            <input type="radio" class="payment_btn" id="important"
                                                name="payment_method"
                                                value="<?= $PayPalpayment->payment_type ?>"
                                                data-value="paypal">
                                            <?php if (!empty($PayPalpayment->paypal_lable)) {
                                                echo $PayPalpayment->paypal_lable;
                                            } else {
                                                echo $PayPalpayment->payment_type;
                                            } ?>
                                </label> <?php  } ?>

                                                            <!-- Razorpay -->
                                    <?php if( $Razorpay_payment_settings != null && $Razorpay_payment_settings->payment_type == "Razorpay" && $Razorpay_payment_settings->status == 1){?>
                                        <label
                                            class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                            <input type="radio" class="payment_btn" id="important"
                                                name="payment_method"
                                                value="<?= $Razorpay_payment_settings->payment_type ?>"
                                                data-value="Razorpay">
                                            <?php echo $Razorpay_payment_settings->payment_type; ?>
                                        </label>
                                    <?php } 
                                                                                // <!-- Paystack -->
                                if ( $Paystack_payment_settings != null && $Paystack_payment_settings->payment_type == 'Paystack'  && $Paystack_payment_settings->status == 1 ){  ?>

                                        <label
                                            class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                            <input type="radio" class="payment_btn" id=""
                                                name="payment_method"
                                                value="<?= $Paystack_payment_settings->payment_type ?>"
                                                data-value="Paystack">
                                            <?= $Paystack_payment_settings->payment_type ?>
                                        </label>
                                    <?php } 
                                                                            // <!-- CinetPay -->
                                if ( $CinetPay_payment_settings != null && $CinetPay_payment_settings->payment_type == 'CinetPay'  && $CinetPay_payment_settings->status == 1 ){  ?>

                                    <label
                                        class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn" id="" name="payment_method"  
                                            value="<?= $CinetPay_payment_settings->payment_type ?>"
                                            data-value="CinetPay">
                                        <?= $CinetPay_payment_settings->payment_type ?>
                                    </label>
                                <?php }

                                    if ( $Paydunyapayment != null && $Paydunyapayment->payment_type == 'Paydunya'  && $Paydunyapayment->status == 1 ){  ?>

                                    <label
                                        class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center ">
                                        <input type="radio" class="payment_btn"  name="payment_method"  value="<?= $Paydunyapayment->payment_type ?>" data-value="Paydunya">
                                        <?= $Paydunyapayment->payment_type ?>
                                    </label>
                                <?php }


                                }
                            else{
                                    echo "<small>Please Turn on Payment Mode to Purchase</small>";
                                    // break;
                            // }
                        }?>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">

                        <?php if( @$settings->ppv_price !=null &&  @$settings->ppv_price != " "  ){ ?>

                            <div class="Stripe_button">
                                    <button class="btn2  btn-outline-primary " onclick="location.href ='<?= URL::to('Stripe_payment_series_PPV_Purchase/'.@$series->id.'/'.@$settings->ppv_price) ?>' ;" > Continue </button>
                            </div>
                            
                        <?php } ?>

                        <?php if( @$settings->ppv_price !=null &&  @$settings->ppv_price != " "  ){ ?>
                            <div class="Razorpay_button">
                                <!-- Razorpay Button -->
                                <button onclick="location.href ='<?= URL::to('RazorpaySeriesSeasonRent/' . @$series->id . '/' . @$settings->ppv_price) ?>' ;"
                                    id="" class="btn2  btn-outline-primary"> Continue</button>
                            </div>
                        <?php }?>


                        <?php if( @$settings->ppv_price !=null &&  @$settings->ppv_price != " "  ){ ?>
                            <div class="paystack_button">
                                <!-- Paystack Button -->
                                <button
                                    onclick="location.href ='<?= route('Paystack_Video_Rent', ['video_id' => @$series->id, 'amount' => @$settings->ppv_price]) ?>' ;"
                                    id="" class="btn2  btn-outline-primary"> Continue</button>
                            </div>
                        <?php }?>

                        <?php if( @$settings->ppv_price !=null &&  @$settings->ppv_price != " " || @$settings->ppv_price !=null  || @$series->global_ppv == 1){ ?>
                            <div class="cinetpay_button">
                                <!-- CinetPay Button -->
                                <button onclick="cinetpay_checkout()" id="" class="btn2  btn-outline-primary">Continue</button>
                            </div>
                        <?php }?>

                        <?php if( @$settings->ppv_price !=null &&  @$settings->ppv_price != " "  ){ ?>
                            <div class="Paydunya_button">   <!-- Paydunya Button -->
                                <button class="btn2  btn-outline-primary " onclick="location.href ='<?= URL::to('Paydunya_series_checkout_Rent_payment/'.@$series->id.'/'.@$series->ppv_price) ?>' ;" > Continue </button>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>


        <?php 
          foreach($season as $key => $seasons): ?>
             <div class="modal fade" 
            id="season-purchase-now-modal-<?= $seasons->id; ?>" tabindex="-1" 
            role="dialog" aria-labelledby="season-purchase-now-modal-<?= $seasons->id; ?>-Title" 
            aria-hidden="true">
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
                                          <h5 style="font-size:17px;line-height: 23px;" class="text-white mb-2">Select payment method:</h5>
                                      </div>

                                      <!-- Stripe Button -->
                                      <?php if ($stripe_payment_setting && $stripe_payment_setting->payment_type == 'Stripe'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="tres_important" name="payment_method" value="<?php echo $stripe_payment_setting->payment_type; ?>" data-value="stripe">
                                              <?php echo $stripe_payment_setting->payment_type; ?>
                                          </label>
                                      <?php endif; ?>

                                        <!-- PayPal Button -->
                                        <?php if ($paypal_payment_setting && $paypal_payment_setting->payment_type == 'PayPal'): ?>
                                            <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                                <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $paypal_payment_setting->payment_type; ?>" data-value="PayPal">
                                                <?php echo $paypal_payment_setting->payment_type; ?>
                                            </label>
                                        <?php endif; ?>

                                      <!-- Razorpay Button -->
                                      <?php if ($Razorpay_payment_setting && $Razorpay_payment_setting->payment_type == 'Razorpay'): ?>
                                          <label class="radio-inline mb-0 mt-2 mr-2 d-flex align-items-center">
                                              <input type="radio" class="payment_btn" id="important" name="payment_method" value="<?php echo $Razorpay_payment_setting->payment_type; ?>" data-value="Razorpay">
                                              <?php echo $Razorpay_payment_setting->payment_type; ?>
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
                                            <div class="Stripe_button col-md-6 col-6 btn text-white" type="button" onclick="location.href ='<?= URL::to('Stripe_payment_series_season_PPV_Purchase/'.$seasons->id.'/'.$seasons->ppv_price) ?>' ;"> <!-- Stripe Button -->
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
                                            <div class="Razorpay_button col-md-6 col-6 btn text-white" type="button" onclick="location.href ='<?= URL::to('RazorpaySeriesSeasonRent/' . $seasons->id . '/' . $seasons->ppv_price) ?>' ;">
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

// Need to Change - 2 (Manivel)

  $('#season_id').change(function(){

    var season_id = $('#season_id').val();
    
    $.each(obj, function(i, $val)
    {
      if('season_'+$val.id == season_id){

        $("#myImage").attr("src", $val.image);

        $(".sea").empty();
        var id = $val.id;
        $(".sea").html(i+1);
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
        
         // banner slider
         let flkty; // Define a global variable to hold the Flickity instance

          function initFlickity() {
              const elem = document.querySelector('.series-slider');
              flkty = new Flickity(elem, {
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

          // Initialize Flickity on page load
          setTimeout(initFlickity, 0);

          // Event listener for the season dropdown
          document.getElementById('season_id').addEventListener('change', function() {
              const selectedSeason = this.value;

              // Hide all season sliders
              document.querySelectorAll('.episodes_div').forEach(function(div) {
                  div.style.display = 'none';
              });

              // Show the selected season's episodes
              document.querySelectorAll('.' + selectedSeason).forEach(function(div) {
                  div.style.display = 'block';
              });

              // Destroy and reinitialize Flickity to update the slider
              if (flkty) {
                  flkty.destroy(); // Destroy the old Flickity instance
              }
              initFlickity(); // Reinitialize Flickity
          });


</script>
