@php
    include(public_path('themes/theme1/views/header.php'));
@endphp

<section id="iq-favorites">
    <h3 class="vid-title text-center mt-4 mb-5">{{ __('Showing Result of') }} "{{  $search_value }}" {{ __('Episode') }}</h3>
    <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
 
            {{-- Episode  --}}
        @if( count($Search_Episode) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">

                    <div class="iq-main-header align-items-center justify-content-between"> 
                        <h3 class="vid-title"> {{ __('Showing  Episode for') }} "{{  $search_value }}"</h3>              
                    </div>
                        <div class="favorites-contens">
                            <ul class="category-page list-inline row p-0 mb-0">
                                @if(isset($Search_Episode)) 
                                    @foreach($Search_Episode as $episode_search)
                                        @if( $episode_search->slug != null )
                                        
                                            @php $series_slug = App\Series::where('id',$episode_search->series_id)->pluck('slug')->first(); @endphp

                                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                                <a href="<?php echo URL::to('home') ?>">
                                                    <div class="block-images position-relative">
                                                        <div class="img-box">
                                                            <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$episode_search->image;  ?>" class="img-fluid" alt="">
                                                        </div>

                                                        <div class="block-description">
                                                            <div class="hover-buttons">
                                                                <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}">	
                                                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                                </a>
                                                            <div>
                                                        </div>
                                                    </div> </div> </div>
                    
                                                    <div class="">
                                                        <div class="mt-2 d-flex justify-content-between p-0">
                                                            @if($ThumbnailSetting->title == 1) 
                                                                <h6><?php  echo (strlen($episode_search->title) > 17) ? substr($episode_search->title,0,18).'...' : $episode_search->title; ?></h6>
                                                            @endif

                                                            @if($ThumbnailSetting->age == 1)
                                                                <div class="badge badge-secondary">
                                                                    {{ $episode_search->age_restrict.' '.'+' }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time my-2"> 
                                                            @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                                <span class="text-white">
                                                                        <i class="fa fa-clock-o"></i>
                                                                        {{ gmdate('H:i:s', $episode_search->duration)}}
                                                                </span>
                                                            @endif
                                    
                                                            @if($ThumbnailSetting->rating == 1 && $episode_search->rating != null)  <!-- Rating -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                    {{ $episode_search->rating }}
                                                                </span>
                                                            @endif
                                    
                                                            @if($ThumbnailSetting->featured == 1 && $episode_search->featured == 1)  <!-- Featured -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    
                                                        <div class="movie-time my-2">                   
                                                            @if ( ($ThumbnailSetting->published_year == 1) && ( $episode_search->year != null ) )  <!-- published_year -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ $episode_search->year }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
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