<style>
    .playvid {
        display: block;
        width: 280%;
        height: auto !important;
        margin-left: -410px;
    }

    .btn.btn-primary.close {
        margin-right: -17px;
        background-color: #4895d1 !important;
    }

    button.close {
        padding: 9px 30px !important;
        border: 0;
        -webkit-appearance: none;
    }

    .close {
        margin-right: -429px !important;
        margin-top: -1461px !important;
    }

    .modal-footer {
        border-bottom: 0px !important;
        border-top: 0px !important;

    }
</style>
<style>
  .p-tag1 {
    color: #000000!important;
    position: absolute;
    top: 8px;
    left: 55px;
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
<div class="">
    <div class="row">
        <div class="col-sm-12 overflow-hidden">
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading"
                    style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php 
                          echo __($category->name);?>
                    </h4>
                </a>
            </div>
            <div class="favorites-contens">
                <ul class="favorites-slider list-inline  row p-0 mb-0">
                    <?php  if(isset($videos)) :
                       foreach($videos as $category_video):
                        
                        ?>
                    <li class="slide-item">
                            <div class="block-images position-relative">
                                    <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"
                                        class="img-fluid" alt=""> -->
                                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"  data-play="hover" >
                                            <source src="<?php echo $category_video->trailer;  ?>" type="video/mp4">
                                            </video>
                                <div class="corner-text-wrapper">
                                    <div class="corner-text">
                                        <p class="p-tag1">
                                            
                                            <?php if(!empty($category_video->ppv_price)) {
                                                   echo $category_video->ppv_price.' '.$currency->symbol ; 
                                                } elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                    echo $category_video->global_ppv .' '.$currency->symbol;
                                                } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                                    echo "Free"; 
                                                }
                                            ?>
                                        
                                        </p>
                                    </div>
                                </div>
                                <div class="block-description">
                                    <a href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">
                                        <h6>
                                            <?php echo __($category_video->title); ?>
                                        </h6>
                                    </a>
                                    <div class="movie-time d-flex align-items-center my-2">
                                        <div class="badge badge-secondary p-1 mr-2"><?php echo $category_video->age_restrict ?></div>
                                        <span class="text-white"><i class="fa fa-clock-o"></i>
                                            <?= gmdate('H:i:s', $category_video->duration); ?>
                                        </span>
                                    </div>
                                    <div class="hover-buttons">
                                        <a type="button" class="text-white"
                                            href="<?php echo URL::to('category') ?><?= '/videos/' . $category_video->slug ?>">

                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                            Watch Now

                                        </a>
                                        <div>
                                       <a   href="<?php echo URL::to('category') ?><?= '/wishlist/' . $cont_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist
                       </a></div>
                                    </div>

                        <!--
                           <div>
                               <button class="show-details-button" data-id="<?= $category_video->id;?>">
                                   <span class="text-center thumbarrow-sec">
                                       <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                   </span>
                                       </button></div>
                        -->
                                </div>
                              
                            </div>
                    </li>
                    <?php           
                          endforeach; 
                     endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php  if(isset($videos)) :
                                  foreach($videos as $latest_video): ?>

<div class="modal fade bd-example-modal-xl4<?= $latest_video->id;?>" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">


        <div class="modal-content" style="background-color: transparent !important;">


            <div class="modal-body playvid">
                <?php if($latest_video->type == 'embed'): ?>
                <div id="video_container" class="fitvid">
                    <?= $latest_video->embed_code ?>
                </div>
                <?php  elseif($latest_video->type == 'file'): ?>
                <div id="video_container" class="fitvid">
                    <video id="videojs-seek-buttons-player" width="100%" height="auto" class="play-video" poster="<?= URL::to('/public/') . '/uploads/images/' . $latest_video->image ?>"
                         data-play="hover"  data-authenticated="<?= !Auth::guest() ?>">

                        <source src="<?= $latest_video->trailer; ?>" type='video/mp4' label='auto'>
                        <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$latest_video->webm_url; ?>" type='video/webm' label='auto' >
                                           <source src="<?php echo URL::to('/storage/app/public/').'/'.$latest_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a
                            web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
                                HTML5 video</a></p>
                    </video>
                    <div class="playertextbox hide">
                        <h2>Up Next</h2>
                        <p>
                            <?php if(isset($videonext)){ ?>
                            <?= $latest_video::where('id','=',$videonext->id)->pluck('title'); ?>
                            <?php }elseif(isset($videoprev)){ ?>
                            <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                            <?php } ?>

                            <?php if(isset($videos_category_next)){ ?>
                            <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                            <?php }elseif(isset($videos_category_prev)){ ?>
                            <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                            <?php } ?>
                        </p>
                    </div>
                </div>
                <?php  else: ?>
                <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                    <video id="videojs-seek-buttons-player" width="100%" height="auto" class="play-video" poster="<?= Config::get('site.uploads_url') . '/images/' . $latest_video->image ?>" data-play="hover"  data-authenticated="<?= !Auth::guest() ?>">

                        <source src="<?= $latest_video->trailer; ?>" type='video/mp4' label='auto'>

                    </video>


                    <div class="playertextbox hide">
                        <h2>Up Next</h2>
                        <p>
                            <?php if(isset($videonext)){ ?>
                            <?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
                            <?php }elseif(isset($videoprev)){ ?>
                            <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                            <?php } ?>

                            <?php if(isset($videos_category_next)){ ?>
                            <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                            <?php }elseif(isset($videos_category_prev)){ ?>
                            <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                            <?php } ?>
                        </p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer" align="center">
                <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-hidden="true"
                    onclick="document.getElementById('framevid').pause();" id="<?= $latest_video->id;?>"><span
                        aria-hidden="true">X</span></button>

            </div>

        </div>
    </div>
</div>
<?php endforeach; 
                                          endif; ?>

<div class="thumb-cont" id="<?= $latest_video->id;?>"
    style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>') no-repeat;background-size: cover;">
    <div class="img-black-back">
    </div>
    <div align="right">
        <button type="button" class="closewin btn btn-danger" id="<?= $latest_video->id;?>"><span
                aria-hidden="true">X</span></button>
    </div>
    <div class="tab-sec">
        <div class="tab-content">
            <div id="overview<?= $latest_video->id;?>" class="container tab-pane active"><br>
                <h1 class="movie-title-thumb">
                    <?php echo __($latest_video->title); ?>
                </h1>
                <p class="movie-rating">
                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i>
                        <?= $latest_video->rating;?>
                    </span>
                    <span class="viewers"><i class="fa fa-eye"></i>(
                        <?= $latest_video->views;?>)
                    </span>
                    <span class="running-time"><i class="fa fa-clock-o"></i>
                        <?= gmdate('H:i:s', $latest_video->duration); ?>
                    </span>
                </p>
                <p>Welcome</p>

                <!-- <div class="btn btn-danger btn-right-space br-0">
                                                   <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                               </div>-->
                <a class="btn btn-hover"
                    href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>"><i
                        class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
            </div>
            <div id="trailer<?= $latest_video->id;?>" class="container tab-pane "><br>

                <div class="block expand">

                    <a class="block-thumbnail-trail"
                        href="<? URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">


                        <?php if (!empty($latest_video->trailer)) { ?>
                        <video width="100%" height="auto" class="play-video" 
                            poster="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>"
                            data-play="hover" >
                            <source src="<?= $latest_video->trailer; ?>" type="video/mp4">
                        </video>
                        <?php } else { ?>
                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>"
                            class="thumb-img">

                        <?php } ?>
                        <div class="play-button-trail">

                            <!--			<a  href="<? URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
               <div class="play-block">
                   <i class="fa fa-play flexlink" aria-hidden="true"></i> 
               </div></a>-->
                            <div class="detail-block">
                                <!--					<a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
               <p class="movie-title"><?php echo __($latest_video->title); ?></p>
                   </a>-->

                                <!--<p class="movie-rating">
                   <span class="star-rate"><i class="fa fa-star"></i><?= $latest_video->rating;?></span>
                   <span class="viewers"><i class="fa fa-eye"></i>(<?= $latest_video->views;?>)</span>
                   <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $latest_video->duration); ?></span>
                   </p>-->

                            </div>
                        </div>
                    </a>
                    <div class="block-contents">
                        <!--<p class="movie-title padding"><?php echo __($latest_video->title); ?></p>-->
                    </div>
                </div>

            </div>
            <div id="like<?= $latest_video->id;?>" class="container tab-pane "><br>

                <h2>More Like This</h2>
            </div>
            <div id="details<?= $latest_video->id;?>" class="container tab-pane "><br>
                <h2>Description</h2>

            </div>
        </div>
        <div align="center">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#overview<?= $latest_video->id;?>">OVERVIEW</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#trailer<?= $latest_video->id;?>">TRAILER AND MORE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#like<?= $latest_video->id;?>">MORE LIKE THIS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#details<?= $latest_video->id;?>">DETAILS </a>
                </li>
            </ul>
        </div>

    </div>
</div>