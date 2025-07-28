@php
    include public_path("themes/{$current_theme}/views/header.php");
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
             
            <div class="trending-contens sub_dropdown_image mt-3" id="home-latest-videos-container">
                <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
            
                        <!-- Video Loop -->
                        @foreach ($Video_cnt as $key => $video_details)
                            <div class="network-image">
                                <div class="movie-sdivck position-relative">
                                    <img src="{{ $video_details->image ? URL::to('public/uploads/images/'.$video_details->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">                                        
                                    
                                    <div class="controls">        
                                        <a href="{{ URL::to('category/videos/'.$video_details->slug) }}">
                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                        </a>
                                        <nav>
                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#video-list-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade info_model" id="video-list-{{ $key }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                    <div class="container">
                                        <div class="modal-content" style="border:none;background:transparent;">
                                            <div class="res-view-hide position-absolute mb-2">
                                                <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-3">
                                                            <img  src="{{ $video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : $default_vertical_image_url }}" alt="modal">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                                    <h2 class="caption-h2">{{ optional($video_details)->title }}</h2>
                                                                </div>
                                                                <div class="res-view-show col-lg-2 col-md-2 col-sm-2">
                                                                    <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                
                                                            <div class="trending-dec">{!! html_entity_decode( $video_details->description ) ??  $video_details->description  !!}</div>
                                                        
                                                                <a href="{{ URL::to('category/videos/'.$video_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
                                                                    <i class="far fa-eye mr-2" aria-hidden="true"></i> {{ "View Content" }}
                                                                </a>
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
                        @foreach ($episode_cnt as $episode_key => $latest_view_episode)
                            <div class="network-image">
                                <div class="movie-sdivck position-relative">
                                    <img src="{{ $latest_view_episode->image ? URL::to('public/uploads/images/'.$latest_view_episode->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">                                        
                                    
                                    <div class="controls">        
                                        <a href="{{ URL::to('episode/'. $latest_view_episode->series->slug.'/'.$latest_view_episode->slug ) }}">
                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                        </a>
                                        <nav>
                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#continue_watching_episodes-Modal-{{ $episode_key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                        </nav>
                                    </div>
                                </div>
                            </div>
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
</section>

<style>

    div#trending-slider-nav{display: flex;
        flex-wrap: wrap;}
        .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
        /* .network-image img{width: 100%; height:auto;} */
        .movie-sdivck{padding:2px;}
        .sub_dropdown_image .network-image:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
    }

    .controls {
        position: absolute;
        padding: 4px;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all .15s ease;
        transition: all .15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    .controls nav {
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .blob {
        margin: 10px;
        height: 22px;
        width: 59px;
        border-radius:25px;
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 1);
        transform: scale(1);
        animation: pulse 2s infinite;
        position:absolute;
        top:0;
    }

    @media (max-width:1024px){
        .modal-body{padding:0 !important;}
    }
    @media (max-width:768px){
        .network-image{flex: 0 0 33.333%;max-width:33.333%;}
    }
    @media (max-width:500px){
        .network-image{flex: 0 0 50%;max-width:50%;}
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }
    }
</style>
<?php include(public_path('themes/theme4/views/footer.blade.php'));  ?>