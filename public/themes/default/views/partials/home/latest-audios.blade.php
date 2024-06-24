@if(!empty($data) && $data->isNotEmpty())

   <section id="iq-favorites">
         <div class="container-fluid overflow-hidden">
            <div class="row">
               <div class="col-sm-12 ">
                  <div class="iq-main-header d-flex align-items-center justify-content-between">
                     <h4 class="main-title">
                           <a href="{{ $order_settings_list[5]->header_name ? URL::to('/') . '/' . $order_settings_list[5]->url : '' }}">
                              {{ $order_settings_list[5]->header_name ? __($order_settings_list[5]->header_name) : '' }}
                           </a>
                     </h4>
                     <h4 class="main-title">
                           <a href="{{ $order_settings_list[5]->header_name ? URL::to('/') . '/' . $order_settings_list[5]->url : '' }}">
                              {{ __('View All') }}
                           </a>
                     </h4>
                  </div>

                  <div class="favorites-contens">
                     <ul class="favorites-slider list-inline row p-0 mb-0">
                           @if(isset($data))
                              @foreach($data as $audio)
                                 <li class="slide-item">
                                       <div class="block-images position-relative">
                                          <div class="border-bg">
                                             <div class="img-box">
                                                   <a href="{{ URL::to('audio/' . $audio->slug) }}">
                                                      <img class="img-fluid w-100" loading="lazy" data-src="{{ $audio->image ? URL::to('/public/uploads/images/' . $audio->image) : $default_vertical_image_url }}" src="{{ $audio->image ? URL::to('/public/uploads/images/' . $audio->image) : $default_vertical_image_url }}" alt="{{ $audio->title }}">
                                                   </a>
                                             </div>
                                          </div>

                                          <div class="block-description mt-3">
                                             <div class="hover-buttons text-white">
                                                   <a class="epi-name mt-5 mb-0 text-center" href="{{ URL::to('audio/' . $audio->slug) }}">
                                                      <i class="ri-play-fill"></i>
                                                   </a>

                                                   <a href="{{ URL::to('audio/' . $audio->slug) }}">
                                                      <p class="epi-name text-left mt-3">{{ $audio->title }}</p>
                                                   </a>

                                                   <div class="d-flex align-items-center justify-content-between">
                                                      <span class="text-white"><small>{{ get_audio_artist($audio->id) }}</small></span>
                                                      <span class="text-primary"><small>{{ gmdate('H:i:s', $audio->duration) }}m</small></span>
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
