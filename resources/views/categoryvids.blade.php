<!-- Header -->
@include('header')   
<!-- Header End -->
<!-- MainContent -->
<style>
  .p-tag1 {
    color: #000000!important;
    position: absolute;
    top: 8px;
    left: 48px;
    background-color: #00a8e1;
    padding: 5px;
    font-size: 12px;
    border: 3px solid #000000;
    border-radius: 3px;
    font-family: "HelveticaNeue-CondensedBold", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
    font-weight: 700;
    border-top: none;
    border-right: none;
    border-bottom-left-radius: 15px;
}

</style>
      <div class="main-content">
         <section id="iq-favorites">
            <div class="container-fluid">
               <div class="row pageheight">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header align-items-center">
                        <h2 class=""><?php echo __($data['category_title']);?></h2>
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-4">
                            <?php if (count($data['categoryVideos']) > 0) { ?>         
                                    @foreach($data['categoryVideos']  as $category_video) 
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid" alt="" width="">
                                                <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                          <?php  if(!empty($category_video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $category_video->ppv_price.' '.$data['currency']->symbol; ?></p>
                                          <?php }elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $category_video->global_ppv.' '.$data['currency']->symbol; ?></p>
                                                    <?php }elseif($category_video->global_ppv == null && $category_video->ppv_price == null ){ ?>
                                                    <p class="p-tag"><?php echo "Free"; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                                <!-- </div> -->

                                                <div class="block-description">
                                                    
                                                        <h6><?php echo __($category_video->title); ?></h6>
                                                    
                                                    <div class="movie-time d-flex align-items-center my-2">
                                                        <div class="badge badge-secondary p-1 mr-2">13+</div>
                                                        <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $category_video->duration); ?></span>
                                                    </div>
                                                    <div class="hover-buttons">
                                                        <a  class="text-white"  href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                                            <span class=""><i class="fa fa-play mr-1" aria-hidden="true"></i>Watch Now</span>
                                                        </a>
                                                         <div>
                                       <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist
                       </a></div>
                                                    </div>
<!--
                                                    <div>
                                                        <button type="buttonbtn btn-primary btn-hover" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $category_video->id;?>">
                                                            <span class="text-center thumbarrow-sec">
                                                                <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                            </span>
                                                        </button>
                                                    </div>
-->
                                                </div>
<!--
                                                <div class="block-social-info">
                                                    <ul class="list-inline p-0 m-0 music-play-lists">
                                                        <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                                        <li><span><i class="ri-heart-fill"></i></span></li>
                                                        <li><span><i class="ri-add-line"></i></span></li>
                                                    </ul>
                                                </div>
-->
                                            </div>
                                        </a>
                                    </li>
                            @endforeach
 <?php } else { ?>
                                        <p class="no_video"> <?php echo __('No Video Found');?></p>
      <?php } ?>
                    
                                                              
                           
                        </ul>
                         
                     </div>
                      
                  </div>
               </div>
            </div>
<?php /*
<!-- Modal Starts -->
<div class="modal fade bd-example-modal-xl<?= $category_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
        
       
    <div class="modal-content" style="background-color: transparent !important;">
       
         
          <div class="modal-body playvid">
                             <?php if($category_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <?= $category_video->embed_code ?>
                                        </div>
                                    <?php  elseif($category_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"   onplay="playstart()"  class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/public/') . '/uploads/images/' . $category_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $category_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$category_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$category_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $category_video::where('id','=',$videonext->id)->pluck('title'); ?>
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
                                        <video id="videojs-seek-buttons-player" onplay="playstart()"  class="video-js vjs-default-skin" controls  poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                        <source src="<?= $category_video->trailer; ?>" type='video/mp4' label='auto' >

                                        </video>


                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
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
                        </div>
        <div class="modal-footer" align="center" >
                <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
 onclick="document.getElementById('framevid').pause();" id="<?= $category_video->id;?>"  ><span aria-hidden="true">X</span></button>
                  
                    </div>
         
  </div>
</div>
</div>
             <div class="modal fade thumb-cont" id="myModal<?= $category_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                     <button type="button" class="btn btn-danger closewin" data-dismiss="modal"><span aria-hidden="true">X</span></button>
                                        </div>
                                <div class="tab-sec">
                                    <div class="tab-content">
                                    <div id="overview<?= $category_video->id;?>" class="container tab-pane active"><br>
                                           <h1 class="movie-title-thumb"><?php echo __($category_video->title); ?></h1>
                                                   <p class="movie-rating">
                                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $category_video->rating;?></span>
                                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $category_video->views;?>)</span>
                                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $category_video->duration); ?></span>
                                                    </p>
                                                  <p>Welcome</p>
                                         <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $category_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
		
		<a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $category_video->slug ?>" >

		
				<?php if (!empty($category_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $category_video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
			            <div class="play-button-trail" >
				
<!--			<a  href="<? URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>-->
                <div class="detail-block">
<!--					<a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                <p class="movie-title"><?php echo __($category_video->title); ?></p>
					</a>-->
					
                <!--<p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $category_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $category_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $category_video->duration); ?></span>
					</p>-->

				</div>
		</div>
		</a>
		<div class="block-contents">
			<!--<p class="movie-title padding"><?php echo __($category_video->title); ?></p>-->
        </div>
	</div> 
	            
    </div>
    <div id="like<?= $category_video->id;?>" class="container tab-pane "><br>
     
           <h2>More Like This</h2>
    </div>
     <div id="details<?= $category_video->id;?>" class="container tab-pane "><br>
        <h2>Description</h2>

    </div>
	</div>
    <div align="center">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $category_video->id;?>">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $category_video->id;?>">TRAILER AND MORE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#like<?= $category_video->id;?>">MORE LIKE THIS</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#details<?= $category_video->id;?>">DETAILS </a>           
                    </li>
              </ul>
        </div>
	</div>
</div>   */ ?>                     
</section>
</div>
    <!-- Modal Starts -->
<!-- MainContent End-->

     @extends('footer')  
