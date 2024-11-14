@php
   include(public_path('themes/theme4/views/header.php'));
@endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         <div class="iq-main-header align-items-center justify-content-between">
            <h4 class="main-title fira-sans-condensed-regular"> {{ __('Continue Watching List') }} </h4>
         </div>

         @if(count($Video_cnt) > 0 || count($episode_cnt) > 0)
             
             
         <div class="channels-list">
            <div class="channel-row">
                <div id="trending-slider-nav" class="video-list continue-video">
                    <!-- Video Loop -->
                    @foreach ($Video_cnt as $key => $video_details)
                        <div class="item" data-index="video-{{ $key }}">
                            <div>
                                    <img data-original="{{ $video_details->image ? URL::to('public/uploads/images/'.$video_details->image) : $default_vertical_image_url }}" src="{{ $video_details->image ? URL::to('public/uploads/images/'.$video_details->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{ $video_details->title }}" width="300" height="200">
        
                                @if (@$videos_expiry_date_status == 1 && optional($video_details)->expiry_date)
                                    <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                @endif 
                            </div>
                        </div>
                    @endforeach
                    <!-- Episode Loop -->
                    @foreach ($episode_cnt as $episode_key => $latest_view_episode)
                        <div class="item" data-index="episode-{{ $episode_key }}">
                            <div>
                                    <img src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/'.$latest_view_episode->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_view_episode">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        
            <div id="videoInfo" class="continue-dropdown" style="display:none;">
                <button class="drp-close">×</button>
                <div class="vib" style="display:flex;">
                    <!-- Video Caption Loop -->
                    @foreach ($Video_cnt as $key => $video_details)
                        <div class="caption" data-index="video-{{ $key }}">
                            <h2 class="caption-h2">{{ optional($video_details)->title }}</h2>
                            @if (@$videos_expiry_date_status == 1 && optional($video_details)->expiry_date)
                                <ul class="vod-info">
                                    <li>{{ "Expiry In ". Carbon\Carbon::parse($video_details->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                </ul>
                            @endif
                            @if (optional($video_details)->description)
                                <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode(optional($video_details)->description)), 500) }}</div>
                            @endif
                            <div class="p-btns">
                                <div class="d-flex align-items-center p-0">
                                    <a href="{{ URL::to('category/videos/'.$video_details->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                    <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-continue-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                </div>
                            </div>
                        </div>
                        <div class="thumbnail" data-index="video-{{ $key }}">
                            <img src="{{ $video_details->player_image ? URL::to('public/uploads/images/'.$video_details->player_image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                        </div>
                    @endforeach
                    <!-- Episode Loop -->
                    @foreach ($episode_cnt as $episode_key => $latest_view_episode)
                        <div class="caption" data-index="episode-{{ $episode_key }}">
                            <h2 class="caption-h2">{{ optional($latest_view_episode)->title }}</h2>
                            <div class="d-flex align-items-center text-white text-detail">
                                {{ "Season: ". App\SeriesSeason::where('id',$latest_view_episode->season_id)->pluck('series_seasons_name')->first() }}  
                            </div>
                            @if (optional($latest_view_episode)->episode_description)
                                <div class="trending-dec">{!! html_entity_decode(optional($latest_view_episode)->episode_description) !!}</div>
                            @endif
                            <div class="p-btns">
                                <div class="d-flex align-items-center p-0">
                                    <a href="{{ URL::to('episode/'. $latest_view_episode->series->slug.'/'.$latest_view_episode->slug ) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                    <a href="#" class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#continue_watching_episodes-Modal-'.$episode_key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                </div>
                            </div>
                        </div>
                        <div class="thumbnail" data-index="episode-{{ $episode_key }}">
                            <img src="{{ $latest_view_episode->player_image ? URL::to('public/uploads/images/'.$latest_view_episode->player_image) : $default_horizontal_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

         <!-- Video Loop -->
         @foreach ($Video_cnt as $key => $video_details )
            <div class="modal fade info_model" id="{{ "Home-continue-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                  <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                           <div class="modal-body">
                              <div class="col-lg-12">
                                    <div class="row">
                                       <div class="col-lg-6">
                                          <img  src="{{ $video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : $default_horizontal_image_url }}" alt="video_details">
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                   <h2 class="caption-h2">{{ optional($video_details)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                   <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                      <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                   </button>
                                                </div>
                                          </div>
                                          

                                          @if (optional($video_details)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($video_details)->description) !!}</div>
                                          @endif

                                          <a href="{{ URL::to('category/videos/'.$video_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                       </div>
                                    </div>
                              </div>
                           </div>
                        </div>
                  </div>
               </div>
            </div>
         @endforeach

         <!-- Episode Loop -->
         @foreach ($episode_cnt as $episode_key => $latest_view_episode )
               <div class="modal fade info_model" id="{{ 'continue_watching_episodes-Modal-'.$episode_key }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                     <div class="container">
                           <div class="modal-content" style="border:none; background:transparent;">
                              <div class="modal-body">
                                 <div class="col-lg-12">
                                       <div class="row">
                                          <div class="col-lg-6">
                                             <img  src="{{ $latest_view_episode->player_image ?  URL::to('public/uploads/images/'.$latest_view_episode->player_image) : $default_horizontal_image_url }}" alt="latest_view_episode">
                                          </div>
                                          <div class="col-lg-6">
                                             <div class="row">
                                                   <div class="col-lg-10 col-md-10 col-sm-10">
                                                      <h2 class="caption-h2">{{ optional($latest_view_episode)->title }}</h2>

                                                   </div>
                                                   <div class="col-lg-2 col-md-2 col-sm-2">
                                                      <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                         <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                      </button>
                                                   </div>
                                             </div>
                                             

                                             @if (optional($latest_view_episode)->episode_description)
                                                   <div class="trending-dec mt-4">{!! html_entity_decode( optional($latest_view_episode)->episode_description) !!}</div>
                                             @endif

                                             <a href="{{ URL::to('episode/'. $latest_view_episode->series->slug.'/'.$latest_view_episode->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                          </div>
                                       </div>
                                 </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
         @endforeach


         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">{{ __('No video Available') }}</h3>
            </div>
         @endif
      </div>
   </div>
</div>


<script>

   var elem = document.querySelector('.continue-video');
   var flkty = new Flickity(elem, {
       cellAlign: 'left',
       contain: true,
       groupCells: true,
       pageDots: false,
       draggable: true,
       freeScroll: true,
       imagesLoaded: true,
       lazyload:true,
   });
   document.querySelectorAll('.continue-video .item').forEach(function(item) {
       item.addEventListener('click', function() {
           document.querySelectorAll('.continue-video .item').forEach(function(item) {
               item.classList.remove('current');
           });

           item.classList.add('current');
           
           var index = item.getAttribute('data-index');
           
           document.querySelectorAll('.continue-dropdown .caption').forEach(function(caption) {
               caption.style.display = 'none';
           });
           document.querySelectorAll('.continue-dropdown .thumbnail').forEach(function(thumbnail) {
               thumbnail.style.display = 'none';
           });

           var selectedCaption = document.querySelector('.continue-dropdown .caption[data-index="' + index + '"]');
           var selectedThumbnail = document.querySelector('.continue-dropdown .thumbnail[data-index="' + index + '"]');
           if (selectedCaption && selectedThumbnail) {
               selectedCaption.style.display = 'block';
               selectedThumbnail.style.display = 'block';
           }

           document.getElementsByClassName('continue-dropdown')[0].style.display = 'flex';
       });
   });


   $('body').on('click', '.drp-close', function() {
       $('.continue-dropdown').hide();
   });
</script>


<?php include(public_path('themes/theme4/views/footer.blade.php'));  ?>