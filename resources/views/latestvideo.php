<?php include('header.php'); ?>

 <!-- MainContent -->
<section id="iq-favorites">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 page-height">
                     <div class="iq-main-header align-items-center justify-content-between">
                        <h1 class="vid-title">Latest Videos</h1>                     
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            <?php if(isset($latest_videos)) :
                           foreach($latest_videos as $latest_video): ?>
                           <li class="slide-item col-sm-3 col-md-3 col-xs-12">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                       <h6><?php echo __($latest_video->title); ?></h6>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                          <span class="btn btn-hover">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Play Now
                                          </span>
                                           </a>
                                       </div>
                                       <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                            </button>
                                        </div>
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
                           
                            <?php endforeach; 
		                          endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

<?php include('footer.blade.php'); ?>