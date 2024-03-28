@php
      include(public_path('themes/theme6/views/header.php'));
   @endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($respond_data['Series']) && count($respond_data['Series']) > 0 )


             <div class="iq-main-header align-items-center justify-content-between">
               <h3 class="vid-title"> Series List</h3>
            </div>

            <div class="favorites-contens">
               <ul class="favorites-slider list-inline  row p-0 mb-0">
                  @foreach($respond_data['Series'] as $key => $Serie)
                        <li class="slide-item">
                           <a href="<?php echo URL::to('') ?><?= '/play_series/' . $Serie->slug ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$Serie->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                       <h6> <?php  echo (strlen($Serie->title) > 17) ? substr($Serie->title,0,18).'...' : $Serie->title; ?> </h6>
                                       <div class="movie-time d-flex align-items-center my-2">

                                             <div class="badge badge-secondary p-1 mr-2">
                                                <?php echo $Serie->age_restrict.' '.'+' ?>
                                             </div>

                                             <span class="text-white">
                                                <?= gmdate('H:i:s', $Serie->duration); ?>
                                             </span>
                                       </div>

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
                  @endforeach
               </ul>
            </div>
            
             
            <!-- <div class="favorites-contens">
               <ul class="category-page list-inline row p-0 mb-0">
                     @forelse($respond_data['Series'] as $key => $Serie)

                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a  href="<?php echo URL::to('') ?><?= '/play_series/' . $Serie->slug ?>">
                              <div class="block-images position-relative">
                                 <div class="img-box">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$Serie->image;  ?>" class="img-fluid w-100" alt="">
                                       @if(!empty($Serie->ppv_price))
                                          <p class="p-tag1" ><?php echo $respond_data['currency']->symbol.' '.$Serie->ppv_price; ?></p>
                                       @elseif( !empty($Serie->global_ppv || !empty($Serie->global_ppv) && $Serie->ppv_price == null)) 
                                          <p class="p-tag1"><?php echo $Serie->global_ppv.' '. $respond_data['currency']->symbol; ?></p>
                                       @elseif($Serie->global_ppv == null && $Serie->ppv_price == null )
                                          <p class="p-tag" ><?php echo "Free"; ?></p>
                                       @endif
                                 </div>

                                 <div class="block-description">
                                    @if( $respond_data['ThumbnailSetting']->title == 1) 
                                       <a  href="<?php echo URL::to('') ?><?= '/play_series/' . $Serie->slug ?>">
                                          <h6><?php  echo (strlen($Serie->title) > 17) ? substr($Serie->title,0,18).'...' : $Serie->title; ?></h6>
                                       </a>
                                    @endif  

                                    <div class="movie-time d-flex align-items-center pt-1">
                                       @if($respond_data['ThumbnailSetting']->age == 1) 
                                                  
                                          <div class="badge badge-secondary p-1 mr-2"><?php echo $Serie->age_restrict.' '.'+' ?></div>
                                       @endif

                                       @if($respond_data['ThumbnailSetting']->duration == 1) 
                                                  
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $Serie->duration); ?></span>
                                       @endif
                                    </div>

                                    @if(($respond_data['ThumbnailSetting']->published_year == 1) || ($respond_data['ThumbnailSetting']->rating == 1))
                                       <div class="movie-time d-flex align-items-center pt-1">
                                          @if($respond_data['ThumbnailSetting']->rating == 1) 
                                             <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                   <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                      {{ $Serie->rating }}
                                                </span>
                                             </div>
                                          @endif

                                          @if($respond_data['ThumbnailSetting']->published_year == 1)   
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                                         {{ ($Serie->year) }}
                                                   </span>
                                                </div>
                                          @endif

                                          @if($respond_data['ThumbnailSetting']->featured == 1 &&  $Serie->featured == 1) 
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                   </span>
                                                </div>
                                          @endif
                                       </div>
                                    @endif

                                    <div class="hover-buttons">
                                       <a  href="<?php echo URL::to('') ?><?= '/play_series/' . $Serie->slug ?>">	
                                          <span class="text-white">
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> Watch Now
                                          </span>
                                       </a>
                                    <div>
                                 </div>
                              </div>

                              <div>
                                 <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $Serie->id;?>">
                                    <span class="text-center thumbarrow-sec">
                                       <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                    </span>
                                 </button>
                              </div>
                              </div>
                              </div>
                           </a>
                        </li>
                     @empty
                        <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                           <p ><h3 class="text-center">No Series Available</h3>
                        </div>
                     @endforelse
               </ul>

               <div class="col-md-12 pagination justify-content-end" >
                  {!!  $respond_data['Series']->links() !!}
               </div>

            </div> -->
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">No Series Available</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/theme6/views/footer.blade.php'));  ?>