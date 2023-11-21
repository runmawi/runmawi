@php
    include(public_path('themes/theme7/views/header.php'));

@endphp

<section id="iq-favorites">
    <div class="container">

                {{-- Showing Episode  --}}
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
                                    @php
                                        $series_slug = App\Series::where('id',$episode_search->series_id)->pluck('slug')->first();
                                    @endphp
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}"> 
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$episode_search->image;  ?>" class="img-fluid" alt="">
                                                    
                                                        @if(!empty($episode_search->ppv_price))
                                                            <p class="p-tag1" >
                                                                {{  $currency->symbol.' '.$episode_search->ppv_price}}
                                                            </p>
                                                        @elseif( !empty($episode_search->global_ppv || !empty($episode_search->global_ppv) && $episode_search->ppv_price == null))
                                                            <p class="p-tag1">
                                                                {{ $episode_search->global_ppv.' '.$currency->symbol }}
                                                            </p>
                                                        @elseif($episode_search->global_ppv == null && $episode_search->ppv_price == null )
                                                            <p class="p-tag" > 
                                                            {{  __("Free") }} 
                                                            </p>
                                                        @endif
                                                </div>

                                                <div class="block-description" style="bottom:-38px!important;">
                                                    @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                        <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}">
                                                            <h6><?php  echo (strlen($episode_search->title) > 17) ? substr($episode_search->title,0,18).'...' : $episode_search->title; ?></h6>
                                                        </a>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                            {{  $episode_search->age_restrict.' '.'+' }}
                                                            </div>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                            <span class="text-white"><i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $episode_search->duration)}}
                                                            </span>
                                                        @endif
                                                    </div>


                                                    @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                    {{ ($episode_search->rating)}}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        {{ ($episode_search->year) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->featured == 1 &&  $episode_search->featured == 1)   <!-- Featured -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="hover-buttons">
                                                        <a  href="{{ URL::to('episode') .'/'.$series_slug.'/'. $episode_search->slug }}" >	
                                                            <span class="text-white">
                                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                    {{ __("Watch Now") }}
                                                            </span>
                                                        </a>
                                                    <div>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $episode_search->id;?>">
                                                    <span class="text-center thumbarrow-sec"></span>
                                                </button>
                                            </div> </div>   </div>
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
    include(public_path('themes/theme7/views/footer.blade.php'));
@endphp