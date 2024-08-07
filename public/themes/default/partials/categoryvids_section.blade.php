@php
    $ThumbnailSetting = App\ThumbnailSetting::first();
    $currency = App\CurrencySetting::first();
@endphp

<div class="favorites-contens data" >
    <ul class="category-page list-inline  row p-0 mb-4">
        <?php if (count($categoryVideos['categoryVideos']) > 0) { ?>         
                @forelse($categoryVideos['categoryVideos'] as $key => $videos) 

                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $videos->slug ?>">
                            <div class="block-images position-relative">
                               <div class="border-bg">
                                     <div class="img-box">
                                        <a class="playTrailer" href="{{ url('category/videos/' . $videos->slug) }}" aria-label="Movie">
                                           <img class="img-fluid w-100 flickity-lazyloaded" src="{{ url('public/uploads/images/' . $videos->image) }}" alt="{{ $videos->title}}">
                                        </a>
                                        <!-- PPV price -->
                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                              @if($videos->access == 'subscriber')
                                                 <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                              @elseif($videos->access == 'registered')
                                                 <p class="p-tag">{{ __('Register Now') }}</p>
                                              @elseif(!empty($videos->ppv_price))
                                                 <p class="p-tag1">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                              @elseif(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                                 <p class="p-tag1">{{ $videos->global_ppv . ' ' . $currency->symbol }}</p>
                                              @elseif($videos->global_ppv == null && $videos->ppv_price == null)
                                                 <p class="p-tag">{{ __('Free') }}</p>
                                              @endif
                                        @endif
                                     </div>
                               </div>
                               <div class="block-description">
                                  <a class="playTrailer" href="{{ url('category/videos/' . $videos->slug) }}" aria-label="Movie">
                                     <!-- PPV price -->
                                     @if($ThumbnailSetting->free_or_cost_label == 1)
                                           @if($videos->access == 'subscriber')
                                              <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                           @elseif($videos->access == 'registered')
                                              <p class="p-tag">{{ __('Register Now') }}</p>
                                           @elseif(!empty($videos->ppv_price))
                                              <p class="p-tag">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                           @elseif(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                              <p class="p-tag">{{ $videos->global_ppv . ' ' . $currency->symbol }}</p>
                                           @elseif($videos->global_ppv == null && $videos->ppv_price == null)
                                              <p class="p-tag">{{ __('Free') }}</p>
                                           @endif
                                     @endif
                                  </a>
                                  <div class="hover-buttons text-white">
                                     <a href="{{ url('category/videos/' . $videos->slug) }}" aria-label="movie">
                                           @if($ThumbnailSetting->title == 1)
                                              <!-- Title -->
                                              <p class="epi-name text-left mt-2 m-0">
                                                 {{ strlen($videos->title) > 17 ? substr($videos->title, 0, 18) . '...' : $videos->title }}
                                              </p>
                                           @endif
                                           <p class="desc-name text-left m-0 mt-1">
                                              {{ strlen($videos->description) > 75 ? substr(html_entity_decode(strip_tags($videos->description)), 0, 75) . '...' : strip_tags($videos->description) }}
                                        </p>
                                           <div class="movie-time d-flex align-items-center pt-1">
                                              @if($ThumbnailSetting->age == 1 && !($videos->age_restrict == 0))
                                                 <!-- Age -->
                                                 <span class="position-relative badge p-1 mr-2">{{ $videos->age_restrict }}</span>
                                              @endif
                                              @if($ThumbnailSetting->duration == 1)
                                              <span class="position-relative text-white mr-2">
                                                 {{ (floor($videos->duration / 3600) > 0 ? floor($videos->duration / 3600) . 'h ' : '') . floor(($videos->duration % 3600) / 60) . 'm' }}
                                           </span>
                                              @endif

                                              @if($ThumbnailSetting->published_year == 1 && !($videos->year == 0))
                                                 <span class="position-relative badge p-1 mr-2">
                                                       {{ __($videos->year) }}
                                                 </span>
                                              @endif
                                              @if($ThumbnailSetting->featured == 1 && $videos->featured == 1)
                                                 <span class="position-relative text-white">
                                                       {{ __('Featured') }}
                                                 </span>
                                              @endif
                                           </div>
                                           
                                           <div class="movie-time d-flex align-items-center pt-1">
                                              <!-- Category Thumbnail Setting -->
                                              @php
                                                 $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                       ->where('categoryvideos.video_id', $videos->id)
                                                       ->pluck('video_categories.name');
                                              @endphp
                                              @if(($ThumbnailSetting->category == 1) && (count($CategoryThumbnail_setting) > 0))
                                                 <span class="text-white">
                                                       <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                       {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                 </span>
                                              @endif
                                           </div>
                                     </a>
                                     <a class="epi-name mt-2 mb-0 btn" href="{{ url('category/videos/' . $videos->slug) }}">
                                           <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />{{ __('Watch Now') }}
                                     </a>
                                  </div>
                               </div>
                            </div>
                         </a>
                    </li>
                @empty

                @endforelse
        <?php } elseif( count($categoryVideos['categoryVideos']) == 0) { ?>
                <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                    <p ><h3 class="text-center">  {{ __('No video Available') }}</h3>
                </div>
         <?php } ?>

    </ul>

    <div class="col-md-12 pagination justify-content-end">
        {!! count($categoryVideos['categoryVideos']) != 0 ? $categoryVideos['categoryVideos']->links() : " "!!}
    </div>
    
 </div>

