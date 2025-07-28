<?php 
    include(public_path('themes/theme1/views/header.php'));
?>

 <!-- MainContent -->
<section id="iq-favorites">
      <h3 class="vid-title text-center mt-4 mb-5"> {{ __('Live Artist Event') }} </h3> 
            <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
               <div class="row">
                  
                  <div class="col-sm-12 page-height">
                     <div class="iq-main-header align-items-center justify-content-between">
                                           
                     </div>
                     <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(isset($artist_live_event['artist_live_event'])) 
                            @foreach($artist_live_event['artist_live_event'] as $artist_live_events)
                           <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <a  href="{{ route('live_event_play',$artist_live_events->slug ) }}" >	
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_live_events->image;  ?>" class="img-fluid w-100" alt="">
                                    </div>

                                    <div class="block-description">
                                       <div class="hover-buttons">
                                        <a  href="{{ route('live_event_play',$artist_live_events->slug ) }}" >		
                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                           </a>
                                        <div>
                                    </div>

                                </div> </div>
                                      
                                 </div>

                                <div>

                                    <div class="mt-2 d-flex justify-content-between p-0">
                                       <?php if($artist_live_event['ThumbnailSetting']->title == 1) { ?>
                                           <h6><?php  echo (strlen($artist_live_events->title) > 17) ? substr($artist_live_events->title,0,18).'...' : $artist_live_events->title; ?></h6>
                                       <?php } ?>

                                       <?php if($artist_live_event['ThumbnailSetting']->age == 1) { ?>
                                           <div class="badge badge-secondary"><?php echo $artist_live_events->age_restrict.' '.'+' ?></div>
                                       <?php } ?>
                                    </div>

                                    <div class="movie-time my-2">
                                       <!-- Duration -->
                  
                                       <?php if($artist_live_event['ThumbnailSetting']->duration == 1) { ?>
                                       <span class="text-white">
                                          <i class="fa fa-clock-o"></i>
                                          <?= gmdate('H:i:s', $artist_live_events->duration); ?>
                                       </span>
                                       <?php } ?>
                                       <!-- Rating -->
                  
                                       <?php if($artist_live_event['ThumbnailSetting']->rating == 1 && $artist_live_events->rating != null) { ?>
                                       <span class="text-white">
                                          <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                          <?php echo __($artist_live_events->rating); ?>
                                       </span>
                                       <?php } ?>
                  
                                       <?php if($artist_live_event['ThumbnailSetting']->featured == 1 && $artist_live_events->featured == 1) { ?>
                                          <!-- Featured -->
                                          <span class="text-white">
                                             <i class="fa fa-flag" aria-hidden="true"></i>
                                          </span>
                                       <?php }?>
                                    </div>
                                     
                                    <div class="movie-time my-2">
                                          <!-- published_year -->
                                          <?php  if ( ($artist_live_event['ThumbnailSetting']->published_year == 1) && ( $artist_live_events->year != null ) ) { ?>
                                          <span class="text-white">
                                             <i class="fa fa-calendar" aria-hidden="true"></i>
                                             <?php echo __($artist_live_events->year); ?>
                                          </span>
                                          <?php } ?>
                                    </div>
                                  </div>
                              </a>
                           </li>
                           
                           @endforeach
                           @endif
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

<?php include(public_path('themes/theme1/views/footer.blade.php'));  ?>
                                