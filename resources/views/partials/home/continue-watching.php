<!--  Continue watching -->
<?php  if(isset($cnt_watching)) : ?>
<div class="iq-main-header d-flex align-items-center justify-content-between">
<h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Continue Watching</a></h4>                      
</div>
<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">
         <?php 
               foreach($cnt_watching as $cont_video): 
                if(!empty($cont_video->ppv_price || !empty($ppv_gobal_price))){
               
               ?>
       <li class="slide-item">
          <a href="<?php echo URL::to('home') ?>">
             <div class="block-images position-relative">
                <div class="img-box">
                   <img  data-src="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" class="img-fluid lazy" alt=""> 
                  <!-- <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>"  data-play="hover" >
                    <source src="<?php echo $cont_video->trailer;  ?>" type="video/mp4">
                    </video>-->
                </div>
                <div class="block-description">
                    
                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">   <h6><?php echo __($cont_video->title); ?></h6></a>
                   <div class="movie-time d-flex align-items-center my-2">
                      <div class="badge badge-secondary p-1 mr-2">13+</div>
                      <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $cont_video->duration); ?></span>
                   </div>
                   <div class="hover-buttons">
                      <a  class="btn btn-primary btn-hover" href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">
                      
                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                      Play Now
                      
                          </a> 
                        

                   </div>
                    <div class="block-social-info mt-3">
                   <ul class=" music-play-lists d-flex justify-content-around">
                      <!-- <li><span><i class="ri-volume-mute-fill"></i></span></li>
                      <li><span><i class="ri-heart-fill"></i></span></li> -->
                      <li><span><i class="ri-add-line"><?php echo $cont_video->ppv_price ; ?></i></span></li>
                   </ul>
                </div>

                    <!--<div >
                        <button class="show-details-button hover" data-id="<?= $cont_video->id;?>">
                            <span class="text-center thumbarrow-sec">
                                <!--<img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                <p style="color:#fff;font-size:12px;text-align:center;">More Details</p>
                            </span>
                                </button></div>-->

                    </div>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $cont_video->cnt_watch[0]->watch_percentage;?>%">
                  </div>
              </div>  
             </div>
          </a>
       </li>

        <?php } elseif(!empty($ppv_gobal_price) && $cont_video->ppv_price == null  ){ 
                          // dd($watchlater_video->id);
                          ?>
                                 <li class="slide-item">
          <a href="<?php echo URL::to('home') ?>">
             <div class="block-images position-relative">
                <div class="img-box">
                   <img  data-src="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" class="img-fluid lazy" alt=""> 
                  <!-- <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>"  data-play="hover" >
                    <source src="<?php echo $cont_video->trailer;  ?>" type="video/mp4">
                    </video>-->
                </div>
                <div class="block-description">
                    
                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">   <h6><?php echo __($cont_video->title); ?></h6></a>
                   <div class="movie-time d-flex align-items-center my-2">
                      <div class="badge badge-secondary p-1 mr-2">13+</div>
                      <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $cont_video->duration); ?></span>
                   </div>
                   <div class="hover-buttons">
                      <a  class="btn btn-primary btn-hover" href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">
                      
                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                      Play Now
                      
                          </a> 
                        

                   </div>
                    <div class="block-social-info mt-3">
                   <ul class=" music-play-lists d-flex justify-content-around">
                      <!-- <li><span><i class="ri-volume-mute-fill"></i></span></li>
                      <li><span><i class="ri-heart-fill"></i></span></li> -->
                      <li><span><i class="ri-add-line"><?php echo $ppv_gobal_price ; ?></i></span></li>
                   </ul>
                </div>

                    <!--<div >
                        <button class="show-details-button hover" data-id="<?= $cont_video->id;?>">
                            <span class="text-center thumbarrow-sec">
                                <!--<img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                <p style="color:#fff;font-size:12px;text-align:center;">More Details</p>
                            </span>
                                </button></div>-->

                    </div>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $cont_video->cnt_watch[0]->watch_percentage;?>%">
                  </div>
              </div>  
             </div>
          </a>
       </li>

        <?php }elseif(empty($ppv_gobal_price) && $cont_video->ppv_price == null  ){ 
                          // dd($watchlater_video->id);
                          ?>
                                                        <li class="slide-item">
          <a href="<?php echo URL::to('home') ?>">
             <div class="block-images position-relative">
                <div class="img-box">
                   <img  data-src="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" class="img-fluid lazy" alt=""> 
                  <!-- <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>"  data-play="hover" >
                    <source src="<?php echo $cont_video->trailer;  ?>" type="video/mp4">
                    </video>-->
                </div>
                <div class="block-description">
                    
                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">   <h6><?php echo __($cont_video->title); ?></h6></a>
                   <div class="movie-time d-flex align-items-center my-2">
                      <div class="badge badge-secondary p-1 mr-2">13+</div>
                      <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $cont_video->duration); ?></span>
                   </div>
                   <div class="hover-buttons">
                      <a  class="btn btn-primary btn-hover" href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">
                      
                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                      Play Now
                      
                          </a> 
                        

                   </div>
                    <div class="block-social-info mt-3">
                   <ul class=" music-play-lists d-flex justify-content-around">
                      <!-- <li><span><i class="ri-volume-mute-fill"></i></span></li>
                      <li><span><i class="ri-heart-fill"></i></span></li> -->
                      <li><span><i class="ri-add-line"><?php echo "Free"; ?></i></span></li>
                   </ul>
                </div>

                    <!--<div >
                        <button class="show-details-button hover" data-id="<?= $cont_video->id;?>">
                            <span class="text-center thumbarrow-sec">
                                <!--<img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                <p style="color:#fff;font-size:12px;text-align:center;">More Details</p>
                            </span>
                                </button></div>-->

                    </div>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $cont_video->cnt_watch[0]->watch_percentage;?>%">
                  </div>
              </div>  
             </div>
          </a>
       </li>

        <?php }
                          endforeach; 
               ?>
    </ul>
</div>
<?php endif; ?>
 <?php  /* if(isset($videos)) :
           foreach($videos as $cont_video): ?>
            <div class="modal fade bd-example-modal-xl<?= $cont_video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="background-color: transparent !important;">
                         <div class="modal-body playvid">
                             <?php if($cont_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <iframe  width="100%" height="500" src="https://www.youtube.com/embed/<?= $cont_video->embed_code ?>" frameborder="0" allowfullscreen></iframe> <!-- <?= $cont_video->embed_code ?> -->
                                        </div>
                                    <?php  elseif($cont_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"   onplay="playstart()"  class="video-js vjs-default-skin" controls poster="<?= URL::to('/public/') . '/uploads/images/' . $cont_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $cont_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$cont_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$cont_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $cont_video::where('id','=',$videonext->id)->pluck('title'); ?>
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
                                        <video id="videojs-seek-buttons-player" onplay="playstart()"   class="video-js vjs-default-skin" controls  poster="<?= Config::get('site.uploads_url') . '/images/' . $cont_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                        <source src="<?= $cont_video->trailer; ?>" type='video/mp4' label='auto' >

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
                        onclick="document.getElementById('videojs-seek-buttons-player').pause();" id="<?= $cont_video->id;?>"  ><span aria-hidden="true">X</span></button>
                        </div>
                    </div>
                </div>
            </div>
      <?php endforeach; 
            endif; */?>
<!--<div class="mod">
      <?php if(isset($videos)) :
            foreach($videos as $cont_video): ?>
            <!--    <div class="thumb-cont" id="<?= $cont_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>') no-repeat;background-size: cover;"> 
                    <div class="img-black-back"></div>
                        <div align="right">
                            <button type="button" class="closewin btn btn-danger" id="cont_vid<?= $cont_video->id;?>"><span aria-hidden="true">X</span></button>
                        </div>
                        <div class="tab-sec">
                            <div class="tab-content">
                                <div id="overview<?= $cont_video->id;?>" class="container tab-pane active"><br>
                                   <h1 class="movie-title-thumb"><?php echo __($cont_video->title); ?></h1>
                                   <p class="movie-rating">
                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i> <?= $cont_video->rating;?></span>
                                    <span class="viewers"><i class="fa fa-eye"></i> (<?= $cont_video->views;?>)</span>
                                    <span class="running-time"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $cont_video->duration); ?></span>
                                   </p>
                                   <p>Welcome</p>
                                    <!-- <div class="btn btn-danger btn-right-space br-0">
                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                    </div>-->
                                  <!--  <a class="btn black"  href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now</a>
                                     <a class=" btn black" href="https://flicknexui.webnexs.org/" class="btn btn-link"><i class="fa fa-plus" aria-hidden="true"></i> Watchlater</a>
                                <a class=" btn black" href="https://flicknexui.webnexs.org/" class="btn btn-link"><i class="fa fa-info" aria-hidden="true"></i> More details</a>
                                </div>
                                <div id="trailer<?= $cont_video->id;?>" class="container tab-pane ">
                                    <div class="block expand">
                                        <a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>" >
                                            <?php if (!empty($cont_video->trailer)) { ?>
                                                <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>"  muted="muted">
                                                <source src="<?= $cont_video->trailer; ?>" type="video/mp4">
                                                </video>
                                            <?php } else { ?>
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$cont_video->image;  ?>" class="thumb-img">
                                            <?php } ?>  
                                            <div class="play-button-trail" >

                                                <!--<a  href="<? URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">  
                                                <div class="play-block">
                                                <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                                                </div></a>-->
                                                <div class="detail-block">
                                                <!--<a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">
                                                <p class="movie-title"><?php echo __($cont_video->title); ?></p>
                                                </a>-->

                                                <!--<p class="movie-rating">
                                                <span class="star-rate"><i class="fa fa-star"></i><?= $cont_video->rating;?></span>
                                                <span class="viewers"><i class="fa fa-eye"></i>(<?= $cont_video->views;?>)</span>
                                                <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $cont_video->duration); ?></span>
                                                </p>-->
                                                <!--</div>
                                            </div>-->
                                     <!--   </a>
                                        <div class="block-contents">
                                            <!--<p class="movie-title padding"><?php echo __($cont_video->title); ?></p>-->
                                       <!-- </div>
                                    </div> 
                                </div>
                                <div id="like<?= $cont_video->id;?>" class="container tab-pane "><br>
                                   <h2>More Like This</h2>
                                </div>
                                <div id="details<?= $cont_video->id;?>" class="container tab-pane ">
                                    <p><?php echo __($cont_video->description); ?></p>
                                </div>
                            </div>
                            <div align="center">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $cont_video->id;?>">OVERVIEW</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $cont_video->id;?>">TRAILER AND MORE</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#like<?= $cont_video->id;?>">MORE LIKE THIS</a>
                                    </li>
                                     <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#details<?= $cont_video->id;?>">DETAILS </a>        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
    <?php endforeach; 
          endif; ?>
</div>
<!--  \Continue watching -->