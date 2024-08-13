@php
      include(public_path('themes/default/views/header.php'));

      $ThumbnailSetting = App\ThumbnailSetting::first();
      $currency = App\CurrencySetting::first();
   @endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($respond_data['videos']) && count($respond_data['videos']) > 0 )


            <div class="iq-main-header align-items-center justify-content-between">
               <h4 class="main-title fira-sans-condensed-regular"> {{ __('Continue Watching List') }} </h4>
            </div>
             
             
            <div class="favorites-contens">
               <ul class="category-page list-inline row p-0 mb-0">
                     @forelse($respond_data['videos'] as $key => $cont_video)

                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $cont_video->slug ?>">
                              <div class="block-images position-relative">
                                 <div class="border-bg">
                                       <div class="img-box">
                                          <a class="playTrailer" href="{{ url('category/videos/' . $cont_video->slug) }}" aria-label="Movie">
                                             <img class="img-fluid w-100 flickity-lazyloaded" src="{{ url('public/uploads/images/' . $cont_video->image) }}" alt="{{ $cont_video->title}}">
                                          </a>
                                          <!-- PPV price -->
                                          @if($ThumbnailSetting->free_or_cost_label == 1)
                                                @if($cont_video->access == 'subscriber')
                                                   <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                                @elseif($cont_video->access == 'registered')
                                                   <p class="p-tag">{{ __('Register Now') }}</p>
                                                @elseif(!empty($cont_video->ppv_price))
                                                   <p class="p-tag1">{{ $currency->symbol . ' ' . $cont_video->ppv_price }}</p>
                                                @elseif(!empty($cont_video->global_ppv) && $cont_video->ppv_price == null)
                                                   <p class="p-tag1">{{ $cont_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                @elseif($cont_video->global_ppv == null && $cont_video->ppv_price == null)
                                                   <p class="p-tag">{{ __('Free') }}</p>
                                                @endif
                                          @endif
                                       </div>
                                 </div>
                                 <div class="block-description">
                                    <a class="playTrailer" href="{{ url('category/videos/' . $cont_video->slug) }}" aria-label="Movie">
                                       <!-- PPV price -->
                                       @if($ThumbnailSetting->free_or_cost_label == 1)
                                             @if($cont_video->access == 'subscriber')
                                                <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                             @elseif($cont_video->access == 'registered')
                                                <p class="p-tag">{{ __('Register Now') }}</p>
                                             @elseif(!empty($cont_video->ppv_price))
                                                <p class="p-tag">{{ $currency->symbol . ' ' . $cont_video->ppv_price }}</p>
                                             @elseif(!empty($cont_video->global_ppv) && $cont_video->ppv_price == null)
                                                <p class="p-tag">{{ $cont_video->global_ppv . ' ' . $currency->symbol }}</p>
                                             @elseif($cont_video->global_ppv == null && $cont_video->ppv_price == null)
                                                <p class="p-tag">{{ __('Free') }}</p>
                                             @endif
                                       @endif
                                    </a>
                                    <div class="hover-buttons text-white">
                                       <a href="{{ url('category/videos/' . $cont_video->slug) }}" aria-label="movie">
                                             @if($ThumbnailSetting->title == 1)
                                                <!-- Title -->
                                                <p class="epi-name text-left mt-2 m-0">
                                                   {{ strlen($cont_video->title) > 17 ? substr($cont_video->title, 0, 18) . '...' : $cont_video->title }}
                                                </p>
                                             @endif
                                             <p class="desc-name text-left m-0 mt-1">
                                                {{ strlen($cont_video->description) > 75 ? substr(html_entity_decode(strip_tags($cont_video->description)), 0, 75) . '...' : strip_tags($cont_video->description) }}
                                          </p>
                                             <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1 && !($cont_video->age_restrict == 0))
                                                   <!-- Age -->
                                                   <span class="position-relative badge p-1 mr-2">{{ $cont_video->age_restrict }}</span>
                                                @endif
                                                @if($ThumbnailSetting->duration == 1)
                                                <span class="position-relative text-white mr-2">
                                                   {{ (floor($cont_video->duration / 3600) > 0 ? floor($cont_video->duration / 3600) . 'h ' : '') . floor(($cont_video->duration % 3600) / 60) . 'm' }}
                                             </span>
                                                @endif

                                                @if($ThumbnailSetting->published_year == 1 && !($cont_video->year == 0))
                                                   <span class="position-relative badge p-1 mr-2">
                                                         {{ __($cont_video->year) }}
                                                   </span>
                                                @endif
                                                @if($ThumbnailSetting->featured == 1 && $cont_video->featured == 1)
                                                   <span class="position-relative text-white">
                                                         {{ __('Featured') }}
                                                   </span>
                                                @endif
                                             </div>
                                             
                                             <div class="movie-time d-flex align-items-center pt-1">
                                                <!-- Category Thumbnail Setting -->
                                                @php
                                                   $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                         ->where('categoryvideos.video_id', $cont_video->id)
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
                                       <a class="epi-name mt-2 mb-0 btn" href="{{ url('category/videos/' . $cont_video->slug) }}">
                                             <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />{{ __('Watch Now') }}
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </a>
                        </li>
                     @empty
                        <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                           <p ><h3 class="text-center">{{ __('No video Available') }}</h3>
                        </div>
                     @endforelse
               </ul>

               <div class="col-md-12 pagination justify-content-end" >
                  {!!  $respond_data['videos']->links() !!}
               </div>

            </div>
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">{{ __('No video Available') }}</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/default/views/footer.blade.php'));  ?>