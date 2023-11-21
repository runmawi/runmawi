@php
   include(public_path('themes/theme7/views/header.php'));
@endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($latestvideo['latest_videos']) && count($latestvideo['latest_videos']) > 0 )

            <div class="iq-main-header align-items-center justify-content-between">
               <h3 class="vid-title">{{ __('Latest Videos') }}</h3>
            </div>
            
            <div class="favorites-contens">
               <ul class="category-page list-inline row p-0 mb-0">
                     @forelse($latestvideo['latest_videos'] as $latest_video)

                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                              <div class="block-images position-relative">
                                 <div class="img-box">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid w-100" alt="">
                                    @if( $latestvideo['ThumbnailSetting']->free_or_cost_label == 1)
                                       @if(!empty($latest_video->ppv_price))
                                          <p class="p-tag1" ><?php echo $latestvideo['currency']->symbol.' '.$latest_video->ppv_price; ?></p>
                                       @elseif( !empty($latest_video->global_ppv || !empty($latest_video->global_ppv) && $latest_video->ppv_price == null)) 
                                          <p class="p-tag1"><?php echo $latest_video->global_ppv.' '. $latestvideo['currency']->symbol; ?></p>
                                       @elseif($latest_video->global_ppv == null && $latest_video->ppv_price == null )
                                          <p class="p-tag" ><?php echo __("Free"); ?></p>
                                       @endif
                                    @endif
                                 </div>

                                 <div class="block-description">
                                    @if( $latestvideo['ThumbnailSetting']->title == 1)  <!-- Title -->
                                       <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                                          <h6><?php  echo (strlen($latest_video->title) > 17) ? substr($latest_video->title,0,18).'...' : $latest_video->title; ?></h6>
                                       </a>
                                    @endif  

                                    <div class="movie-time d-flex align-items-center pt-1">
                                       @if($latestvideo['ThumbnailSetting']->age == 1) 
                                                   <!-- Age -->
                                          <div class="badge badge-secondary p-1 mr-2"><?php echo $latest_video->age_restrict.' '.'+' ?></div>
                                       @endif

                                       @if($latestvideo['ThumbnailSetting']->duration == 1) 
                                                   <!-- Duration -->
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $latest_video->duration); ?></span>
                                       @endif
                                    </div>

                                    @if(($latestvideo['ThumbnailSetting']->published_year == 1) || ($latestvideo['ThumbnailSetting']->rating == 1))
                                       <div class="movie-time d-flex align-items-center pt-1">
                                          @if($latestvideo['ThumbnailSetting']->rating == 1) <!--Rating  -->
                                             <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                   <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                      {{ $latest_video->rating }}
                                                </span>
                                             </div>
                                          @endif

                                          @if($latestvideo['ThumbnailSetting']->published_year == 1)   <!-- published_year -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                                         {{ ($latest_video->year) }}
                                                   </span>
                                                </div>
                                          @endif

                                          @if($latestvideo['ThumbnailSetting']->featured == 1 &&  $latest_video->featured == 1) <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                   </span>
                                                </div>
                                          @endif
                                       </div>
                                    @endif

                                    <div class="hover-buttons">
                                       <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                          <span class="text-white">
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Now') }}
                                          </span>
                                       </a>
                                    <div>
                                 </div>
                              </div>

                              <div>
                                 <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_video->id;?>">
                                    <span class="text-center thumbarrow-sec">
                                       <!-- <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">-->
                                    </span>
                                 </button>
                              </div>
                              </div>
                              </div>
                           </a>
                        </li>
                     @empty
                        <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                           <p ><h3 class="text-center">{{ __('No Latest Video Available') }}</h3>
                        </div>
                     @endforelse
               </ul>

               <div class="col-md-12 pagination justify-content-end" >
                  {!! $latestvideo['latest_videos']->links() !!}
               </div>

            </div>
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">{{ __('No Latest Video Available') }}</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/theme7/views/footer.blade.php'));  ?>