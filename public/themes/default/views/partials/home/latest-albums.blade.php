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
                     <h4 class="main-title view-all">
                           <a href="{{ $order_settings_list[6]->header_name ? URL::to('/').'/'.$order_settings_list[6]->url : '' }}">
                              {{ __('View all') }}
                           </a>
                     </h4>   
                  @endif
               </div>
               <div class="favorites-contens">
                  <div class="latest-albums home-sec list-inline row p-0 mb-0">
                           @foreach($data as $album)
                              <div class="items">
                                    <div class="block-images position-relative">
                                       <!-- block-images -->
                                       <div class="border-bg">
                                          <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('album/'.$album->slug) }}" aria-label="AlbumPlayTrailer">
                                                   <img class="img-fluid w-100 flickity-lazyloaded" data-flickity-lazyload="{{ $album->album ? URL::to('public/uploads/albums/'.$album->album) : $default_vertical_image_url }}" alt="{{ $album->albumname }}" loading="lazy">
                                                </a>   
                                          </div>
                                       </div>
                                       <div class="block-description">
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
                              </div>
                           @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
</section>
@endif


<script>
   var elem = document.querySelector('.latest-albums');
   var flkty = new Flickity(elem, {
       cellAlign: 'left',
       contain: true,
       groupCells: false,
       pageDots: false,
       draggable: true,
       freeScroll: true,
       imagesLoaded: true,
       lazyLoad: 7,
   });
</script>