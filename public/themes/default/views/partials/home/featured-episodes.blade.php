@if (!empty($data) && $data->isNotEmpty())
 
    <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
          <div class="row">
              <div class="col-sm-12 ">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">{{ __('Featured Episodes') }}</h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h4 class="main-title view-all"><a href="{{URL::to('/Featured_episodes')}}"> {{ __('View all') }}</a> </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="featured-episodes home-sec list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $featured_episodes)
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('episode/'. $featured_episodes->series_title->slug.'/'.$featured_episodes->slug ) }}">
                                                        <img class="img-fluid w-100" data-flickity-lazyload="{{ $featured_episodes->image ? URL::to('public/uploads/images/'.$featured_episodes->image) : $default_vertical_image_url }}" data-src="{{ $featured_episodes->image ? URL::to('public/uploads/images/'.$featured_episodes->image) : $default_vertical_image_url }}" alt="{{ $featured_episodes->title }}">
                                                    </a>
                                                </div>
                                            </div>
                                                    
                                            <div class="block-description">

                                                <div class="hover-buttons text-white">
                                                    <a href="{{ URL::to('episode/'. $featured_episodes->series_title->slug.'/'.$featured_episodes->slug ) }}">
                                                        @if($ThumbnailSetting->title == 1)
                                                            <p class="epi-name text-left m-0">
                                                                {{ strlen($featured_episodes->title) > 17 ? substr($featured_episodes->title, 0, 18) . '...' : $featured_episodes->title }}
                                                            </p>
                                                        @endif
                                                        @if($ThumbnailSetting->enable_description == 1)
                                                            <p class="desc-name text-left m-0 mt-1">
                                                                {{ strlen($featured_episodes->episode_description) > 75 ? substr(html_entity_decode(strip_tags($featured_episodes->episode_description)), 0, 75) . '...' : strip_tags($featured_episodes->episode_description) }}
                                                            </p>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1 && !($featured_episodes->age_restrict == 0))
                                                            <span class="position-relative badge p-1 mr-2">{{ $featured_episodes->age_restrict}}</span>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($featured_episodes->duration / 3600) > 0 ? floor($featured_episodes->duration / 3600) . 'h ' : '') . floor(($featured_episodes->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                            @endif
                                                            @if($ThumbnailSetting->published_year == 1 && !($featured_episodes->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($featured_episodes->year) }}
                                                            </span>
                                                            @endif
                                                            @if($ThumbnailSetting->featured == 1 && $featured_episodes->featured == 1)
                                                            <span class="position-relative text-white">
                                                                {{ __('Featured') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                
                                                    <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('episode/'. $featured_episodes->series_title->slug.'/'.$featured_episodes->slug ) }}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Watch Now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                  
              </div>
          </div>
      </div>
    </section>

@endif

<script>
  var elem = document.querySelector('.featured-episodes');
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
