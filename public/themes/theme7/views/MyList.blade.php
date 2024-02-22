@php
   include(public_path('themes/theme7/views/header.php'));
@endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($MyList['Watchlater_videos']) && count($MyList['Watchlater_videos']) > 0 )

         <div class="iq-main-header align-items-center justify-content-between">
               <h3 class="vid-title">{{ __('My List') }}</h3>
            </div>
            
            <div class="favorites-contens">
               <ul class="category-page list-inline row p-0 mb-0">
                     @forelse($MyList['Watchlater_videos'] as $My_List)

                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $My_List->slug ?>">
                              <div class="block-images position-relative">
                                 <div class="img-box">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$My_List->image;  ?>" class="img-fluid w-100" alt="">
                                    @if( $MyList['ThumbnailSetting']->free_or_cost_label == 1)
                                       @if(!empty($My_List->ppv_price))
                                          <p class="p-tag1" ><?php echo $MyList['currency']->symbol.' '.$My_List->ppv_price; ?></p>
                                       @elseif( !empty($My_List->global_ppv || !empty($My_List->global_ppv) && $My_List->ppv_price == null)) 
                                          <p class="p-tag1"><?php echo $My_List->global_ppv.' '. $MyList['currency']->symbol; ?></p>
                                       @elseif($My_List->global_ppv == null && $My_List->ppv_price == null )
                                          <p class="p-tag" ><?php echo __("Free"); ?></p>
                                       @endif
                                    @endif
                                 </div>

                                 <div class="block-description">
                                    @if( $MyList['ThumbnailSetting']->title == 1)  <!-- Title -->
                                       <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $My_List->slug ?>">
                                          <h6><?php  echo (strlen($My_List->title) > 17) ? substr($My_List->title,0,18).'...' : $My_List->title; ?></h6>
                                       </a>
                                    @endif  

                                    <div class="movie-time d-flex align-items-center pt-1">
                                       @if($MyList['ThumbnailSetting']->age == 1) 
                                                   <!-- Age -->
                                          <div class="badge badge-secondary p-1 mr-2"><?php echo $My_List->age_restrict.' '.'+' ?></div>
                                       @endif

                                       @if($MyList['ThumbnailSetting']->duration == 1) 
                                                   <!-- Duration -->
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $My_List->duration); ?></span>
                                       @endif
                                    </div>

                                    @if(($MyList['ThumbnailSetting']->published_year == 1) || ($MyList['ThumbnailSetting']->rating == 1))
                                       <div class="movie-time d-flex align-items-center pt-1">
                                          @if($MyList['ThumbnailSetting']->rating == 1) <!--Rating  -->
                                             <div class="badge badge-secondary p-1 mr-2">
                                                <span class="text-white">
                                                   <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                      {{ $My_List->rating }}
                                                </span>
                                             </div>
                                          @endif

                                          @if($MyList['ThumbnailSetting']->published_year == 1)   <!-- published_year -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                                         {{ ($My_List->year) }}
                                                   </span>
                                                </div>
                                          @endif

                                          @if($MyList['ThumbnailSetting']->featured == 1 &&  $My_List->featured == 1) <!-- Featured -->
                                                <div class="badge badge-secondary p-1 mr-2">
                                                   <span class="text-white">
                                                      <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                   </span>
                                                </div>
                                          @endif
                                       </div>
                                    @endif

                                    <div class="hover-buttons">
                                       <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $My_List->slug ?>">	
                                          <span class="text-white">
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Now') }}
                                          </span>
                                       </a>
                                    <div>
                                 </div>
                              </div>

                              <div>
                                 <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $My_List->id;?>">
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
                           <p ><h3 class="text-center">{{ __('No Video Available') }}</h3>
                        </div>
                     @endforelse
               </ul>

               <div class="col-md-12 pagination justify-content-end" >
                  {!! $MyList['Watchlater_videos']->links() !!}
               </div>

            </div>
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">{{ __('No Video Available') }}</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/theme7/views/footer.blade.php'));  ?>