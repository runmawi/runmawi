<?php include('header.php'); ?>
<style type="text/css">
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
    .plyr__video-wrapper::before{
        display: none;
    }
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
    color: #FF0000	;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
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
        background-color: #fff;
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
    
</style>

<?php 
$series = $series_data ;
$media_url = URL::to('/play_series/') . '/' . $series->slug ;
 $ThumbnailSetting = App\ThumbnailSetting::first();
 // dd($series);
 ?>
     <div id="myImage" style="background:linear-gradient(90deg, rgba(0, 0, 0, 1.3)47%, rgba(0, 0, 0, 0.3))40%, url(<?=URL::to('/') . '/public/uploads/images/' . $series->player_image ?>);background-position:right; background-repeat: no-repeat; background-size:contain;padding:0px 0px 20px; ">
     <div class="row">
        <div class="nav nav-tabs nav-fill container-fluid m-0" id="nav-tab" role="tablist">
            <div class="bc-icons-2 mt-3">
                <ol class="breadcrumb m-0">
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
      </div>
    
    
     <div class="container-fluid pt-2" >
	<div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>

	<div class="row mt-3 align-items-center">
		<?php if( $ppv_exits > 0 || $video_access == "free" || $series->access == 'guest' && $series->ppv_status != 1 || ( ($series->access == 'subscriber' && $series->ppv_status != 1 || $series->access == 'registered' && $series->ppv_status != 1 ) 
		&& !Auth::guest() && Auth::user()->subscribed()) && $series->ppv_status != 1 || (!Auth::guest() && (Auth::user()->role == 'demo' && $series->ppv_status != 1 || 
	 	Auth::user()->role == 'admin') ) || (!Auth::guest() && $series->access == 'registered' && 
		$settings->free_registration && Auth::user()->role != 'registered' && $series->ppv_status != 1) ):  ?>
		<div class="col-md-7">
			<div id="series_title">
				<div class="container">
					 <h3><?= $series->title ?></h3>
                  
					<!--<div class="col-md-6 p-0">
						<select class="form-control" id="season_id" name="season_id">
							<?php foreach($season_trailer as $key => $seasons): ?>
								<option value="season_<?= $seasons->id;?>">Season <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select>
					</div>-->
					<div class="row p-2 text-white">
                        <div class="col-md-7">
                        <?php echo __('Season'); ?>  <span class="sea"> 1 </span> - <?php echo __('U/A English'); ?>
                            <p  style="color:#fff!important;"><?php echo $series->details;?></p>
						<b><p  style="color:#fff;"><?php echo $series->description;?></p></b>
                            <div class="row p-0 mt-3 align-items-center">
                                <div class="col-md-2">  <a data-video="<?php echo $series->trailer;  ?>" data-toggle="modal" data-target="#videoModal">	
                                          <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> </a></div>
                              <!--  <div class="col-md-4 text-center pls">  <a herf="">  <i class="fa fa-plus" aria-hidden="true"></i> <br>Add Wishlist</a></div>-->
                                <div class="col-md-1 pls  d-flex text-center mt-2">
                                    <div></div><ul>
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
                                    </ul></div>
                                          
                                          
                              
                              


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
       <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
      
      <script>  const player = new Plyr('#videoPlayer1'); </script>
                        </div>
					</div>
				</div>
               
			</div>
	
    <h2 class="text"> 
              <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
              <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary"><?php echo __('Become a subscriber to watch this video'); ?></button>
              </form>
          <?php elseif($series->access == 'registered'): ?>
            <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary">
                    <?php echo __('Become a Registered User to watch this video'); ?></button>
              </form>
          <?php elseif($series->ppv_status == 1): ?>
          <div class="d-flex">
            <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
              </form>

            <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary">
                    <?php echo __('Purchase Now'); ?></button>
              </form>
          </div>
            <?php endif; ?></h2>
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

		<div class="row">
			<div class="col-md-12 mt-4">
				<nav class="nav-justified">
					<div class="nav nav-tabs nav-fill container-fluid " id="nav-tab" role="tablist">
                        <h4 class="ml-3"><?php echo __('Episode'); ?></h4>
						<!--<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Episode</a>
						<!--<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Related</a>
						<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Detail</a>-->
					</div>
				</nav>
            </div>
<!-- $series->title -->
						<div class="container-fluid">
				<div class="favorites-contens">
                    <div class="col-md-3 p-0">
                    <select class="form-control" id="season_id" name="season_id">
							<?php foreach($season as $key => $seasons): ?>
								<option data-key="<?= $key+1 ;?>" value="season_<?= $seasons->id;?>" ><?php echo __('Season'); ?> <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select></div>
          <ul class="category-page list-inline row p-3 mb-0">
              <?php 
                    foreach($season as $key => $seasons):  
                      foreach($seasons->episodes as $key => $episodes):
                        if($seasons->ppv_interval > $key):
							 ?>
                           
                  <li class="slide-item col-sm-2 col-md-2 col-xs-12 episodes_div season_<?= $seasons->id;?>">
                      <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                           <div class="block-images position-relative episodes_div season_<?= $seasons->id;?>">
                                    <div class="img-box">
                                      <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class="img-fluid w-100" >
                                  <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                   
                                         <?php  if(!empty($series->ppv_price) && $series->ppv_status == 1){ ?>
                                            <p class="p-tag"><?php echo __("Free"); ?></p>
                                                 <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$settings->ppv_price; ?></p> -->
                                          <?php }elseif(!empty($seasons->ppv_price)){?>
                                            <p class="p-tag"><?php echo __("Free"); ?></p>
                                               <!-- <p class="p-tag1"><?php //echo $currency->symbol.' '.$seasons->ppv_price; ?></p> -->
                                          <?php }elseif($series->ppv_status == null && $series->ppv_status == 0 ){ ?>
                                            <p class="p-tag"><?php echo __("Free"); ?></p>
                                            <?php } ?>
                                    <?php } ?>

                               </div></div>
                                 
                               <div class="block-description" ></div>
                                    
                                 
                                         <h6><?= $episodes->title; ?></h6>
                                          <!--  <p class="desc text-white mt-2 mb-0"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>-->
                                                                <!--<p class="date desc text-white mb-0"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>-->
                                            <p class="text-white desc mb-0"><?= gmdate("H:i:s", $episodes->duration); ?></p>
                               
                                   
                                       <!-- <div class="hover-buttons">
                                            <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                          <span class="text-white">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Watch Now
                                          </span>
                                           </a>
                                           <div>
                                           <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> 
                 
                                 </div>
                                        </div>-->
                                    
                                
                              </a>
                            </li>
                           
                           	<?php else : ?>
                             <li class="slide-item col-sm-2 col-md-2 col-xs-12 episodes_div season_<?= $seasons->id;?>">
                              <a href="<?php echo URL::to('episode').'/'.$series->slug.'/'.$episodes->slug;?>">
                                 <div class="block-images position-relative" >
                                    <div class="img-box">
                                      <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" class=" img-fluid w-100" >
                                   
                                  <?php if($ThumbnailSetting->free_or_cost_label == 1) { ?> 
                                   
                                           <?php  if(!empty($series->ppv_price) && $series->ppv_status == 1){ ?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$settings->ppv_price; ?></p>
                                          <?php }elseif(!empty($seasons->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$seasons->ppv_price; ?></p>
                                          <?php }elseif($series->ppv_status == null && $series->ppv_status == 0 ){ ?>
                                            <p class="p-tag"><?php echo __("Free"); ?></p>
                                            <?php } ?>
                                      <?php } ?>
                                     </div></div>
                                 
                                  <div class="block-description" ></div>
                                    
                                         <h6><?= $episodes->title; ?></h6>
										<!--<p class="desc text-white mt-2 mb-0"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>-->
                                       <!-- <p class="date desc text-white mb-0"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>-->
										<p class="text-white desc mb-0"><?= gmdate("H:i:s", $episodes->duration); ?></p>
                               

                                   
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
                           </li>
                           <?php endif;	endforeach; 
						                      endforeach; ?>
                        </ul>
                     </div></div>
			<?php elseif( Auth::guest() && $series->access == "subscriber"):
						
					// }
						?>
				</div> 

          <!-- <div  style="background: url(<?=URL::to('/') . '/public/uploads/images/' . $series->image ?>); background-repeat: no-repeat; background-size: cover; height: 400px; margin-top: 20px;"> -->
			<div class="col-md-7">
				<div id="series_title">
            <div class="container">
              <h3><?= $series->title ?></h3>
              <div class="row p-2 text-white">
                <div class="col-md-7">
                          <?php echo __('Season'); ?>  <span class="sea"> 1 </span> - <?php echo __('U/A English'); ?>
                              <p  style="color:#fff!important;"><?php echo $series->details;?></p>
                                <b><p  style="color:#fff;"><?php echo $series->description;?></p></b>
                                  <div class="row p-0 mt-3 align-items-center">
                                      <div class="col-md-2">  <a data-video="<?php echo $series->trailer;  ?>" data-toggle="modal" data-target="#videoModal">	
                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> </a></div>
                                            <!--  <div class="col-md-4 text-center pls">  <a herf="">  <i class="fa fa-plus" aria-hidden="true"></i> <br>Add Wishlist</a></div>-->
                                              <div class="col-md-1 pls  d-flex text-center mt-2">
                                                  <div></div>
                                                  <ul>
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
                                  <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
                                  
                                  <script>  const player = new Plyr('#videoPlayer1'); </script>


                                  </div>


              </div>
              </div>

            </div>

              <h2 class="text" style="margin-top:80px;"> 
              <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
              <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary"><?php echo __('Become a subscriber to watch this video'); ?></button>
              </form>
          <?php elseif($series->access == 'registered'): ?>
            <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary">
                    <?php echo __('Become a Registered User to watch this video'); ?></button>
              </form>
          <?php elseif($series->ppv_status == 1): ?>
          <div class="d-flex">
            <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
              </form>

            <form method="get" action="<?= URL::to('signup') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary">
                    <?php echo __('Purchase Now'); ?></button>
              </form>
          </div>
            <?php endif; ?></h2>


				
				<div class="clear"></div>
				</div> 
				<!-- </div>  -->


				<div class="col-md-2 text-center text-white">
                <div class="col-md-4">
			<?php if ( $series->ppv_status == 1 && !Auth::guest() && Auth::User()->role !="admin") { ?>
			<button class="btn btn-primary" onclick="pay(<?php echo $settings->ppv_price; ?>)" >
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
				<?php elseif($series->ppv_status == 1 || Auth::User()->role == "subscriber"  || Auth::User()->role == "registered" ): ?>

          <div class="col-md-7">
				    <div id="series_title">
              <div class="container">
                <h3><?= $series->title ?></h3>
                  <div class="row p-2 text-white">
                    <div class="col-md-7">
                      <?php echo __('Season'); ?>  <span class="sea"> 1 </span> - <?php echo __('U/A English'); ?>
                        <p  style="color:#fff!important;"><?php echo $series->details;?></p>
                        <b><p  style="color:#fff;"><?php echo $series->description;?></p></b>
                        <div class="row p-0 mt-3 align-items-center">
                                        <div class="col-md-2">
                                          <a data-video="<?php echo $series->trailer;  ?>" data-toggle="modal" data-target="#videoModal">	
                                            <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                          </a>
                                        </div>
                                            <!--  <div class="col-md-4 text-center pls">  <a herf="">  <i class="fa fa-plus" aria-hidden="true"></i> <br>Add Wishlist</a></div>-->
                                          <div class="col-md-1 pls  d-flex text-center mt-2">
                                            <div></div>
                                            <ul>
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
                                          <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
                                          <script>  const player = new Plyr('#videoPlayer1'); </script>
                        </div>
                    </div>
                </div>

              </div>
            </div>


        <h2 class="text" > 
              <?php if($series->access == 'subscriber' && $series->ppv_status == 0): ?>
          <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                  <button id="button" class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
              </form>
              <?php elseif($series->ppv_status == 1 &&  Auth::User()->role == "subscriber" ): ?>
            <button style="margin-left: 46%;margin-top: 1%;" data-toggle="modal" data-target="#exampleModalCenter"
                    class="view-count rent-video btn btn-primary">
                    <?php echo __('Purchase Now'); ?> </button>
            <?php elseif($series->ppv_status == 1 ): ?>

              <div class="d-flex">
              <form method="get" action="<?= URL::to('/becomesubscriber') ?>">
                  <button id="button"  class="view-count rent-video btn btn-primary mr-4"><?php echo __('Become a subscriber to watch this video'); ?></button>
              </form>
              <form action="">
                  <button  data-toggle="modal" data-target="#exampleModalCenter"
                    class="view-count rent-video btn btn-primary">
                    <?php echo __('Purchase Now'); ?> </button>
                    </form>
                    </div>
            <?php endif; ?></h2>
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
                                                    style=""><?php echo __('Rent Now'); ?></h4>

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
                                                            class="badge badge-secondary   mb-2"><?php // echo __($series->age_restrict) . ' ' . '+'; ?></span>
                                                        <span
                                                            class="badge badge-secondary  mb-2"><?php // echo __(isset($series->categories->name)); ?></span>
                                                        <span
                                                            class="badge badge-secondary  mb-2"><?php // echo __(isset($series->languages->name)); ?></span>
                                                        <span
                                                            class="badge badge-secondary  mb-2 ml-1"><?php echo __($series->duration); ?></span><br>

                                                        <a type="button" class="mb-3 mt-3" data-dismiss="modal"
                                                            style="font-weight:400;"><?php echo __('Amount'); ?>: <span class="pl-2"
                                                                style="font-size:20px;font-weight:700;">
                                                                <?php if($series->ppv_status == 1 && $settings->ppv_price != null && $CurrencySetting == 1){ echo __(Currency_Convert(@$settings->ppv_price)); }else if($series->ppv_status == 1 && $settings->ppv_price != null && $CurrencySetting == 0){ echo __(@$settings->ppv_price) .' '.$currency->symbol ; } ?></span></a><br>
                                                        <label class="mb-0 mt-3 p-0" for="method">
                                                            <h5 style="font-size:20px;line-height: 23px;"
                                                                class="font-weight-bold text-black mb-2"><?php echo __('Payment Method'); ?>
                                                                : </h5>
                                                        </label>

                                                        <?php $payment_type = App\PaymentSetting::get(); ?>

                                                        <!-- RENT PAYMENT Stripe,Paypal,Paystack,Razorpay,CinetPay -->

                                                        <?php  //foreach($payment_type as $payment){
                                        $Stripepayment = App\PaymentSetting::where('payment_type', 'Stripe')->first();
                                        $PayPalpayment = App\PaymentSetting::where('payment_type', 'PayPal')->first();

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
                                                                name="payment_method"
                                                                value="<?= $CinetPay_payment_settings->payment_type ?>"
                                                                data-value="CinetPay">
                                                            <?= $CinetPay_payment_settings->payment_type ?>
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
                                                <div class="Stripe_button">
                                                    <!-- Stripe Button -->
                                                    <!-- Currency_Convert(@$settings->ppv_price) -->
                                                    <a onclick="pay(<?php if($series->ppv_status == 1 && $CurrencySetting == 1){ echo PPV_CurrencyConvert($settings->ppv_price); }else if($series->ppv_status == 1 && $settings->ppv_price != null && $CurrencySetting == 0){ echo __(@$settings->ppv_price) ; } ?>)">
                                                        <button type="button"
                                                            class="btn2  btn-outline-primary"><?php echo __('Continue'); ?></button>
                                                    </a>
                                                </div>

                                                <?php if( $series->ppv_status == 1   ){ ?>
                                                <div class="Razorpay_button">
                                                    <!-- Razorpay Button -->
                                                    <button
                                                        onclick="location.href ='<?= URL::to('RazorpayVideoRent/' . $series->id . '/' . $settings->ppv_price) ?>' ;"
                                                        id="" class="btn2  btn-outline-primary">
                                                        <?php echo __('Continue'); ?></button>
                                                </div>
                                                <?php }?>


                                                <?php if( $series->ppv_status == 1   ){ ?>
                                                <div class="paystack_button">
                                                    <!-- Paystack Button -->
                                                    <button
                                                        onclick="location.href ='<?= route('Paystack_Video_Rent', ['video_id' => $series->id, 'amount' => $settings->ppv_price]) ?>' ;"
                                                        id="" class="btn2  btn-outline-primary">
                                                        <?php echo __('Continue'); ?></button>
                                                </div>
                                                <?php }?>

                                                <?php if( $series->ppv_status == 1 ){ ?>
                                                <div class="cinetpay_button">
                                                    <!-- CinetPay Button -->
                                                    <button onclick="cinetpay_checkout()" id=""
                                                        class="btn2  btn-outline-primary"><?php echo __('Continue'); ?></button>
                                                </div>
                                                <?php }?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

   <input type="hidden" name="publishable_key" id="publishable_key" value="<?= $publishable_key ?>">
   <input type="hidden" name="series_id" id="series_id" value="<?= $series->id ?>">
   
   <input type="hidden" name="m3u8url_datasource" id="m3u8url_datasource" value="">


   <script src="https://checkout.stripe.com/checkout.js"></script>
	
<input type="hidden" id="purchase_url" name="purchase_url" value="<?php echo URL::to("/purchase-series") ?>">
<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>



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


// alert(livepayment);

$(document).ready(function () {  

 $('.videoModalClose').click(function (){
  $('#videoPlayer1')[0].pause();
  $('#videos')[0].pause();

});

	var imageseason = '<?= $season_trailer ?>' ;
// console.log(imageseason)
$("#videoPlayer1").hide();
$("#videos").hide();

var obj = JSON.parse(imageseason);
console.log(obj)
var season_id = $('#season_id').val();
$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
// alert($val.trailer_type)	
	console.log('season_'+$val.id)
  if( $val.trailer_type == 'mp4_url' || $val.trailer_type == null){
    $("#videoPlayer1").show();
    $("#videos").hide();
    $("#videoPlayer1").attr("src", $val.trailer);


    $('.videoModalClose').click(function (){
      $('#videoPlayer1')[0].pause();
    });

  }else{
    $("#videoPlayer1").hide();
    $("#videos").show();
   $("#m3u8urlsource").attr("src", $val.trailer);
  
  
   $('.videoModalClose').click(function (){
      $('#videos')[0].pause();
    });

  }
}
});









$('#season_id').change(function(){
	var season_id = $('#season_id').val();
// alert($('#season_id').val())	

$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
	console.log('season_'+$val.id)
	// $("#theDiv").append("<img id='theImg' src=$val.image/>");
	$("#myImage").attr("src", $val.image);
	// $("#videoPlayer1").attr("src", $val.trailer);
  if( $val.trailer_type == 'mp4_url' || $val.trailer_type == null){
    $("#videoPlayer1").show();
    $("#videos").hide();

    $("#videoPlayer1").attr("src", $val.trailer);
  }else{
    $("#videoPlayer1").hide();
    $("#videos").show();
    $("#m3u8urlsource").attr("src", $val.trailer);
  }

  $(".sea").empty();
  // alert($val.id);
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
// You can access the token ID with `token.id`.
// Get the token ID to your server-side code for use.
console.log('Token Created!!');
console.log(token);
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

	<!-- <script type="text/javascript"> 

	// videojs('Player').videoJsResolutionSwitcher(); 
	$(document).ready(function () {  
		 $.ajaxSetup({
		   headers: {
			 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   }
		 });
	   });

function pay(amount) {
var publishable_key = $('#publishable_key').val();

var series_id = $('#series_id').val();
// alert(series_id);
// alert(publishable_key);

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
description: 'Rent a Episode',
amount: amount * 100
});
}
</script> -->

<script type="text/javascript">
	var first = $('select').val();
	$(".episodes_div").hide();
	$("."+first).show();

	$('select').on('change', function() {
		$(".episodes_div").hide();
		$("."+this.value).show();
	});
</script>

<script>

var imageseason = '<?= $season_trailer ?>' ;
// console.log(imageseason)
$("#videoPlayer1").hide();
$("#videos").hide();

var obj = JSON.parse(imageseason);
console.log(obj)
var season_id = $('#season_id').val();

$.each(obj, function(i, $val)
{

  if( $val.trailer_type == 'm3u8_url'){

    // alert($('#videos').attr("src"));
    // alert(sourcevaltrailer);
  
  document.addEventListener("DOMContentLoaded", () => {

    // alert(sourcevaltrailer);
    var video = document.querySelector('#videos');
    // var sourcess = video.getElementsByTagName("source")[0].src;
    // alert(sourcess);
    var source = $val.trailer;
    // alert(source);

    const defaultOptions = {};
  
    if (!Hls.isSupported()) {
      video.src = source;
      var player = new Plyr(video, defaultOptions);
    } else {
      // For more Hls.js options, see https://github.com/dailymotion/hls.js
      const hls = new Hls();
      hls.loadSource(source);

      // From the m3u8 playlist, hls parses the manifest and returns
                  // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
              hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

                // Transform available levels into an array of integers (height values).
                const availableQualities = hls.levels.map((l) => l.height)
            availableQualities.unshift(0) //prepend 0 to quality array

                // Add new qualities to option
          defaultOptions.quality = {
            default: 0, //Default - AUTO
              options: availableQualities,
              forced: true,        
              onChange: (e) => updateQuality(e),
          }
          // Add Auto Label 
          defaultOptions.i18n = {
            qualityLabel: {
              0: 'Auto',
            },
          }

          hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
              var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
              if (hls.autoLevelEnabled) {
                span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
              } else {
                span.innerHTML = `AUTO`
              }
            })
      
              // Initialize new Plyr player with quality options
          var player = new Plyr(video, defaultOptions);
          });	

    hls.attachMedia(video);
        window.hls = hls;		 
      }

      function updateQuality(newQuality) {
        if (newQuality === 0) {
          window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
        } else {
          window.hls.levels.forEach((level, levelIndex) => {
            if (level.height === newQuality) {
              console.log("Found quality match with " + newQuality);
              window.hls.currentLevel = levelIndex;
            }
          });
        }
      }
});


  }
});










$('#season_id').change(function(){
	var season_id = $('#season_id').val();
$.each(obj, function(i, $val)
{
if('season_'+$val.id == season_id){
	console.log('season_'+$val.id)
	$("#myImage").attr("src", $val.image);
  if( $val.trailer_type == 'mp4_url' || $val.trailer_type == null){
    $("#videoPlayer1").show();
    $("#videos").hide();
    $("#videoPlayer1").attr("src", $val.trailer);
  }else{
    $("#videoPlayer1").hide();
    $("#videos").show();
    $("#m3u8urlsource").attr("src", $val.trailer);
    
  if( $val.trailer_type == 'm3u8_url'){

// alert($('#videos').attr("src"));
// alert(sourcevaltrailer);

document.addEventListener("DOMContentLoaded", () => {

// alert(sourcevaltrailer);
var video = document.querySelector('#videos');
// var sourcess = video.getElementsByTagName("source")[0].src;
// alert(sourcess);
var source = $val.trailer;
// alert(source);

const defaultOptions = {};

if (!Hls.isSupported()) {
      video.src = source;
      var player = new Plyr(video, defaultOptions);
    } else {
      // For more Hls.js options, see https://github.com/dailymotion/hls.js
      const hls = new Hls();
      hls.loadSource(source);

      // From the m3u8 playlist, hls parses the manifest and returns
                  // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
              hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

                // Transform available levels into an array of integers (height values).
                const availableQualities = hls.levels.map((l) => l.height)
            availableQualities.unshift(0) //prepend 0 to quality array

                // Add new qualities to option
          defaultOptions.quality = {
            default: 0, //Default - AUTO
              options: availableQualities,
              forced: true,        
              onChange: (e) => updateQuality(e),
          }
          // Add Auto Label 
          defaultOptions.i18n = {
            qualityLabel: {
              0: 'Auto',
            },
          }

          hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
              var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
              if (hls.autoLevelEnabled) {
                span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
              } else {
                span.innerHTML = `AUTO`
              }
            })
      
              // Initialize new Plyr player with quality options
          var player = new Plyr(video, defaultOptions);
          });	

    hls.attachMedia(video);
        window.hls = hls;		 
      }

      function updateQuality(newQuality) {
        if (newQuality === 0) {
          window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
        } else {
          window.hls.levels.forEach((level, levelIndex) => {
            if (level.height === newQuality) {
              console.log("Found quality match with " + newQuality);
              window.hls.currentLevel = levelIndex;
            }
          });
        }
      }
});


}
  }

  $(".sea").empty();
  // alert($val.id);
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
        
</script>