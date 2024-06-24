@if (!empty($data) && $data->isNotEmpty())
   @php
      $id = !Auth::guest() && !empty($data['password_hash']) ? Auth::user()->id : 0;
   @endphp

   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <div class="iq-main-header d-flex align-items-center justify-content-between">
                  <h2 class="main-title">
                        <a href="{{ url('continue-watching-list') }}">{{ __('Continue watching') }}</a>
                  </h2>
                  @if($settings->homepage_views_all_button_status == 1)
                        <h2 class="main-title">
                           <a href="{{ url('continue-watching-list') }}">{{ __('View All') }}</a>
                        </h2>
                  @endif
               </div>
               <div class="favorites-contens">
                  <ul class="favorites-slider list-inline row p-0 mb-0">
                        @foreach($data as $cont_video)
                           <li class="slide-item">
                              <div class="block-images position-relative">
                                    <div class="border-bg">
                                       <div class="img-box">
                                          <a class="playTrailer" href="{{ url('category/videos/' . $cont_video->slug) }}" aria-label="Movie">
                                                <img class="img-fluid lazyload w-100" loading="lazy" data-src="{{ url('public/uploads/images/' . $cont_video->image) }}" alt="Thumbnail Image">
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
                                          <img class="img-fluid lazyload w-100" loading="lazy" data-src="{{ url('public/uploads/images/' . $cont_video->player_image) }}" alt="Player Image">
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
                                       <div class="hover-buttons text-white">
                                          <a href="{{ url('category/videos/' . $cont_video->slug) }}" aria-label="movie">
                                                @if($ThumbnailSetting->title == 1)
                                                   <!-- Title -->
                                                   <p class="epi-name text-left m-0">
                                                      {{ strlen($cont_video->title) > 17 ? substr($cont_video->title, 0, 18) . '...' : $cont_video->title }}
                                                   </p>
                                                @endif
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                   @if($ThumbnailSetting->age == 1)
                                                      <!-- Age -->
                                                      <div class="badge badge-secondary mr-2">
                                                            {{ $cont_video->age_restrict . ' +' }}
                                                      </div>
                                                   @endif
                                                   @if($ThumbnailSetting->duration == 1)
                                                      <!-- Duration -->
                                                      <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            {{ gmdate('H:i:s', $cont_video->duration) }}
                                                      </span>
                                                   @endif
                                                </div>
                                                @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1))
                                                   <div class="movie-time d-flex align-items-center pt-1">
                                                      @if($ThumbnailSetting->rating == 1)
                                                            <!-- Rating -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                               <span class="text-white">
                                                                  <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                  {{ __($cont_video->rating) }}
                                                               </span>
                                                            </div>
                                                      @endif
                                                      @if($ThumbnailSetting->published_year == 1)
                                                            <!-- Published Year -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                               <span class="text-white">
                                                                  <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                  {{ __($cont_video->year) }}
                                                               </span>
                                                            </div>
                                                      @endif
                                                      @if($ThumbnailSetting->featured == 1 && $cont_video->featured == 1)
                                                            <!-- Featured -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                               <span class="text-white">
                                                                  <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                               </span>
                                                            </div>
                                                      @endif
                                                   </div>
                                                @endif
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
                                          <a class="epi-name mt-3 mb-0 btn" href="{{ url('category/videos/' . $cont_video->slug) }}">
                                                <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> Watch Now
                                          </a>
                                       </div>
                                    </div>
                              </div>
                           </li>
                        @endforeach
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </section>
@endif
