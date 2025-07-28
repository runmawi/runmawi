

                     <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                           <?php if(isset($audios)) :
                              foreach($audios as $audio): ?>
                                <li class="slide-item">
                                    <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fluid" alt="">
                                            </div>
                                            <div class="block-description">
                                                <h6> <?php echo $audio->title; ?>  </h6>
                                                <!-- <div class="movie-time d-flex align-items-center my-2">

                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($latest_video)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $latest_video->duration != null ? gmdate('H:i:s', $latest_video->duration) : null }}
                                                    </span>
                                                </div> -->

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="block-social-info">
                                                <ul class="list-inline p-0 m-0 music-play-lists">
                                                    <li><span><i class="ri-heart-fill"></i></span></li>
                                                    <li><span><i class="ri-add-line"></i></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                              <?php  endforeach;  endif; ?>
                        </ul>
                    </div>





                  <!-- <div class="favorites-contens">
                     <ul class="favorites-slider list-inline  row p-0 mb-0 ">
                        <?php if(isset($audios)) :
                              foreach($audios as $audio): ?>
                                 <li class="slide-item ">
                                    <a href="<? URL::to('album') ?><?= '/' . $audio->albumslug ?>">
                                    <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                       <div class="block-images position-relative">
                                          <div class="img-box">
                                             <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fliud w-100" alt="">
                                          </div>
                                                
                                          <div class="block-description">
                                          <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                                <h6 class="epi-name text-white mb-0"><?php echo $audio->title; ?></h6>
                                             </a>   
                                                
                                             <div class="hover-buttons text-white">
                                                <a class="d-flex align-items-center" href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                                                   <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" /> Play Now
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                           <?php  endforeach;  endif; ?>
                     </ul>
                  </div> -->


