@if (!empty($data) && $data->isNotEmpty())

<section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <div class="iq-main-header d-flex align-items-center justify-content-between">
                  <h4 class="main-title">
                     <a href="{{ $order_settings_list[6]->header_name ? URL::to('/').'/'.$order_settings_list[6]->url : '' }}">
                           {{ $order_settings_list[6]->header_name ? __($order_settings_list[6]->header_name) : '' }}
                           <!-- Albums -->
                     </a>
                  </h4>  
                  @if($settings->homepage_views_all_button_status == 1)
                     <h4 class="main-title">
                           <a href="{{ $order_settings_list[6]->header_name ? URL::to('/').'/'.$order_settings_list[6]->url : '' }}">
                              {{ __('View All') }}
                           </a>
                     </h4>   
                  @endif
               </div>
               <div class="favorites-contens">
                  <ul class="favorites-slider list-inline row p-0 mb-0">
                        @if(isset($data))
                           @foreach($data as $album) 
                              <li class="slide-item">
                                    <div class="block-images position-relative">
                                       <!-- block-images -->
                                       <div class="border-bg">
                                          <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('album/'.$album->slug) }}">
                                                   <img class="img-fluid w-100" loading="lazy" data-src="{{ $album->album ? URL::to('public/uploads/albums/'.$album->album) : $default_vertical_image_url }}" class="img-fluid w-100" alt="{{ $album->albumname }}">
                                                </a>   
                                          </div>
                                       </div>
                                       <div class="block-description">
                                          <!-- <a class="playTrailer" href="{{ URL::to('album/'.$album->slug) }}">
                                                <img src="{{ URL::to('/public/uploads/albums/'.$album->album) }}" class="img-fluid w-100" alt="album">
                                          </a>  -->
                                          <div class="hover-buttons text-white">
                                                <a class="epi-name mt-5 mb-0" href="{{ URL::to('album/'.$album->slug) }}">
                                                   <i class="ri-play-fill"></i>
                                                </a>                         
                                                <a href="{{ URL::to('album/'.$album->slug) }}">
                                                   <p class="epi-name text-left m-0 mt-3">{{ $album->albumname }}</p>
                                                </a>
                                                <div class="d-flex align-items-center justify-content-between">
                                                   <span class="text-white"><small>{{ get_audio_artist($album->id) }}</small></span>
                                                </div>
                                          </div>
                                       </div>
                                    </div>
                              </li>
                           @endforeach
                        @endif
                  </ul>
               </div>
            </div>
         </div>
      </div>
</section>
@endif
