@php
   include(public_path("themes/default/views/header.php"));
@endphp

<section id="iq-favorites">
   <div class="fluid">
       <div class="row">
           @if(count($ppv) > 0 || count($ppvlive) > 0 || count($ppvseries) > 0)
               <div class="col-sm-12 overflow-hidden">
                  <div class="iq-main-header d-flex align-items-center justify-content-between">
                     <h4 class="main-title"><a href="#">{{ __('Rental Videos') }}</a></h4>
                  </div>
                  <div class="favorites-contens">
                     <ul class="favorites-slider list-inline row p-0 mb-0">
                        @isset($ppv)
                              @foreach($ppv as $video)
                                 <li class="slide-item">
                                    <div class="block-images position-relative">
                                       <div class="border-bg">
                                          <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category') . '/videos/' . $video->slug }}">
                                                   <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $video->image ? URL::to('/public/uploads/images/'.$video->image) : $default_vertical_image_url }}" alt="{{ $video->title }}">
                                                </a>
                                          </div>
                                       </div>
                                       <div class="block-description">

                                          <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category') . '/videos/' . $video->slug }}" aria-label="movie">
                                                   @if($ThumbnailSetting->title == 1)
                                                      <p class="epi-name text-left mt-2 m-0">
                                                            {{ strlen($video->title) > 17 ? substr($video->title, 0, 18).'...' : $video->title }}
                                                      </p>
                                                   @endif

                                                   <p class="desc-name text-left m-0 mt-1">
                                                      {{ strlen($video->description) > 75 ? substr(html_entity_decode(strip_tags($video->description)), 0, 75) . '...' : strip_tags($video->description) }}
                                                   </p>

                                                   <div class="movie-time d-flex align-items-center pt-2">
                                                      @if($ThumbnailSetting->age == 1 && !($video->age_restrict == 0))
                                                            <span class="position-relative badge p-1 mr-2">{{ $video->age_restrict}}</span>
                                                      @endif

                                                      @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                               {{ (floor($video->duration / 3600) > 0 ? floor($video->duration / 3600) . 'h ' : '') . floor(($video->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                      @endif
                                                      @if($ThumbnailSetting->published_year == 1 && !($video->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                               {{ __($video->year) }}
                                                            </span>
                                                      @endif
                                                      @if($ThumbnailSetting->featured == 1 && $video->featured == 1)
                                                            <span class="position-relative text-white">
                                                               {{ __('Featured') }}
                                                            </span>
                                                      @endif
                                                   </div>

                                                   <div class="movie-time d-flex align-items-center pt-1">
                                                      @php
                                                            $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                               ->where('categoryvideos.video_id', $video->id)
                                                               ->pluck('video_categories.name');        
                                                      @endphp

                                                      @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                            <span class="text-white">
                                                               <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                               {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                            </span>
                                                      @endif
                                                   </div>
                                                </a>

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category') . '/videos/' . $video->slug }}">
                                                   <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Watch Now') }}
                                                </a>
                                          </div>
                                       </div>
                                    </div>
                              </li>
                              @endforeach
                        @endisset
                     </ul>
                  </div>
               </div>

               @if(count($ppvseries) > 0)
                   <div class="col-sm-12 overflow-hidden">
                       <div class="iq-main-header d-flex align-items-center justify-content-between">
                           <h4 class="main-title"><a href="#">{{ __('Rental Series Seasons') }}</a></h4>
                       </div>
                       <div class="favorites-contens">
                           <ul class="favorites-slider list-inline row p-0 mb-0">
                               @isset($ppvseries)
                                   @foreach($ppvseries as $series)
                                       <li class="slide-item">
                                           <a href="{{ url('home') }}">
                                               <div class="position-relative">
                                                   <div class="img-box">
                                                       <a href="{{ url('play_series/' . $series->slug) }}">
                                                           <img src="{{ url('/public/uploads/images/' . $series->image) }}" class="img-fluid" alt="">
                                                       </a>
                                                   </div>
                                                   <div class="block-description">
                                                      <div class="hover-buttons text-white">
                                                         <a href="{{ URL::to('/play_series/' . $series->slug) }}" aria-label="movie">
                                                             @if($ThumbnailSetting->title == 1)
                                                                 <p class="epi-name text-left mt-2 m-0">
                                                                     {{ strlen($series->title) > 17 ? substr($series->title, 0, 18).'...' : $series->title }}
                                                                 </p>
                                                             @endif
         
                                                             <p class="desc-name text-left m-0 mt-1">
                                                                 {{ strlen($series->description) > 75 ? substr(html_entity_decode(strip_tags($series->description)), 0, 75) . '...' : strip_tags($series->description) }}
                                                             </p>
         
                                                             <div class="movie-time d-flex align-items-center pt-2">
                                                                 @if($ThumbnailSetting->age == 1 && !($series->age_restrict == 0))
                                                                     <span class="position-relative badge p-1 mr-2">{{ $series->age_restrict}}</span>
                                                                 @endif
         
                                                                 @if($ThumbnailSetting->duration == 1)
                                                                     <span class="position-relative text-white mr-2">
                                                                         {{ (floor($series->duration / 3600) > 0 ? floor($series->duration / 3600) . 'h ' : '') . floor(($series->duration % 3600) / 60) . 'm' }}
                                                                     </span>
                                                                 @endif
                                                                 @if($ThumbnailSetting->published_year == 1 && !($series->year == 0))
                                                                     <span class="position-relative badge p-1 mr-2">
                                                                         {{ __($series->year) }}
                                                                     </span>
                                                                 @endif
                                                                 @if($ThumbnailSetting->featured == 1 && $series->featured == 1)
                                                                     <span class="position-relative text-white">
                                                                        {{ __('Featured') }}
                                                                     </span>
                                                                 @endif
                                                             </div>
         
                                                             <div class="movie-time d-flex align-items-center pt-1">
                                                                 @php 
                                                                     $SeriesSeason = App\SeriesSeason::where('series_id', $series->id)->count(); 
                                                                     echo $SeriesSeason . ' Season';
                                                                 @endphp
                                                             </div>
                                                         </a>
         
                                                         <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/play_series/' . $series->slug) }}">
                                                             <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%"/> {{ __('Watch Now') }}
                                                         </a>
                                                     </div>
                                                   </div>
                                               </div>
                                           </a>
                                       </li>
                                   @endforeach
                               @endisset
                           </ul>
                       </div>
                   </div>
               @endif

               @if(count($ppvlive) > 0)
                   <div class="col-sm-12 overflow-hidden">
                       <div class="iq-main-header d-flex align-items-center justify-content-between">
                           <h4 class="main-title"><a href="#">{{ __('Rental Live Videos') }}</a></h4>
                       </div>
                       <div class="favorites-contens">
                           <ul class="favorites-slider list-inline row p-0 mb-0">
                               @isset($ppvlive)
                                   @foreach($ppvlive as $watchlater_video)
                                       <li class="slide-item">
                                           <a href="{{ url('home') }}">
                                               <div class="position-relative">
                                                   <div class="img-box">
                                                       <a href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                           <video width="100%" height="auto" class="play-video" poster="{{ url('/public/uploads/images/' . $watchlater_video->image) }}" data-play="hover">
                                                               <source src="{{ $watchlater_video->trailer }}" type="video/mp4">
                                                           </video>
                                                       </a>
                                                       <div class="corner-text-wrapper">
                                                           <div class="corner-text">
                                                               @if(!empty($watchlater_video->ppv_price))
                                                                   <p class="p-tag1">{{ $currency->symbol . ' ' . $watchlater_video->ppv_price }}</p>
                                                               @elseif(!empty($watchlater_video->global_ppv) && is_null($watchlater_video->ppv_price))
                                                                   <p class="p-tag1">{{ $watchlater_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                               @else
                                                                   <p class="p-tag">{{ __('Free') }}</p>
                                                               @endif
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="block-description">
                                                       <a href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                           <h6>{{ __($watchlater_video->title) }}</h6>
                                                       </a>
                                                       <div class="movie-time d-flex align-items-center my-2">
                                                           <div class="badge badge-secondary p-1 mr-2">{{ $watchlater_video->age_restrict }}</div>
                                                           <span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $watchlater_video->duration) }}</span>
                                                       </div>
                                                       <div class="hover-buttons d-flex">
                                                           <a class="text-white" href="{{ url('category/videos/' . $watchlater_video->slug) }}">
                                                               <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Watch Now') }}
                                                           </a>
                                                           <span style="color: white;" class="livemywishlist {{ isset($mywishlisted->id) ? 'active' : '' }}" data-authenticated="{{ !Auth::guest() }}" data-videoid="{{ $watchlater_video->id }}">
                                                               <i class="{{ isset($mywishlisted->id) ? 'ri-heart-fill' : 'ri-heart-line' }}" style=""></i>
                                                               <span id="addwatchlist">{{ __('Add to Watchlist') }}</span>
                                                           </span>
                                                       </div>
                                                   </div>
                                               </div>
                                           </a>
                                       </li>
                                   @endforeach
                               @endisset
                           </ul>
                       </div>
                   </div>
               @endif
           @else
               <p><h2>{{ __('No Videos Rented') }}</h2></p>
               <div class="col-md-12 text-center mt-4">
                   <img class="w-50" src="{{ url('/assets/img/sub.png') }}">
               </div>
           @endif
       </div>
   </div>
</section>

<style>
   .i{
      text-decoration: none;
      text-decoration-line: none;
      text-decoration-style: initial;
      text-decoration-color: initial;
      outline-color: initial;
      outline-style: none;
      outline-width: medium;
      outline: medium none;
   }
</style>


<script>
$('.mywishlist').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/mywishlist');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Wishlist"){
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Wishlist');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
                          setTimeout(function() {
                          $('.remove_watch').slideUp('fast');
                          }, 3000);
                          }               
                    }
                });
            }                
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });
</script>

@php
   include(public_path("themes/default/views/footer.blade.php"));
@endphp
