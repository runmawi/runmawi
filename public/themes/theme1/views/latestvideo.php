<?php include('header.php'); ?>
 <!-- MainContent -->
<section id="iq-favorites">
     <h3 class="vid-title text-center mt-3 mb-3">Latest Videos</h3>               
            <div class="container-fluid" style="background:#4b4a4b;padding:0px 60px!important;">
               <div class="row">
                  <div class="col-sm-12 page-height">
                     <div class="iq-main-header align-items-center justify-content-between">
                             
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            <?php if(isset($latest_videos)) :
                           foreach($latest_videos as $latest_video): ?>
                           <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                   
                                   
                                </div>
                                     </div>
                                    <div class="block-description" style="left:50px!important;">
                                       
                                       <div class="hover-buttons d-flex justify-content-around">
                                           <div>
                                           <a class=" mr-2" href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                          <span class="text-white">
                                         <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.png';  ?>">     
                                        
                                          </span>
                                           </a></div>
                                          
                                       </div>
                                       <div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                   <!-- <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">-->
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                     <div class="mt-2">
                                         <h6><?php echo __($latest_video->title); ?></h6>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_video->duration); ?></span>
                                       </div>
                                     

                                   <!-- <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                          <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>-->

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