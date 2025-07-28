@php
    include(public_path('themes/theme1/views/header.php'));
@endphp

<section id="iq-favorites">
    <h3 class="vid-title text-center mt-4 mb-5">{{ __('Showing Result of') }} "{{  $search_value }}" {{ __('Livestream') }}</h3>
    <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">

            {{-- Live Stream --}}
        @if( count($Search_livestreams) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">

                        <div class="favorites-contens">
                            <ul class="category-page list-inline row p-0 mb-0">
                                
                                @if(isset($Search_livestreams)) 
                                    @foreach($Search_livestreams as $livestream_search)

                                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                            <a href="<?php echo URL::to('home') ?>">
                                                <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$livestream_search->image;  ?>" class="img-fluid" alt="">
                                                    </div>

                                                    <div class="block-description">
                                                        <div class="hover-buttons">
                                                            <a  href="{{  URL::to('live') .'/' .$livestream_search->slug }} ">	
                                                                <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                            </a>
                                                        <div>
                                                    </div>
                                                </div> </div> </div>
                
                                                <div class="">
                                                    <div class="mt-2 d-flex justify-content-between p-0">
                                                        @if($ThumbnailSetting->title == 1) 
                                                            <h6><?php  echo (strlen($livestream_search->title) > 17) ? substr($livestream_search->title,0,18).'...' : $livestream_search->title; ?></h6>
                                                        @endif
                                                    </div>

                                                    <div class="movie-time my-2"> 
                                                        @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                            <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $livestream_search->duration)}}
                                                            </span>
                                                        @endif
                                
                                                        @if($ThumbnailSetting->rating == 1 && $livestream_search->rating != null)  <!-- Rating -->
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ $livestream_search->rating }}
                                                            </span>
                                                        @endif
                                
                                                        @if($ThumbnailSetting->featured == 1 && $livestream_search->featured == 1)  <!-- Featured -->
                                                            <span class="text-white">
                                                                <i class="fa fa-flag" aria-hidden="true"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                
                                                    <div class="movie-time my-2">                   
                                                        @if ( ($ThumbnailSetting->published_year == 1) && ( $livestream_search->year != null ) )  <!-- published_year -->
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ $livestream_search->year }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                
                            </ul>
                        </div>
                    </div>
            </div>
        @endif
        
    </div>
</section>
@php
    include(public_path('themes/theme1/views/footer.blade.php'));
@endphp