@php
    include(public_path('themes/default/views/header.php'));

@endphp

<section id="iq-favorites">
    <div class="container">

                    {{-- Showing Audio --}}
        @if( count($Search_audio) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">
                        <h3 class="vid-title"> Showing  Audios for "{{  $search_value }}"</h3>                     
                    </div>
                    
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                        
                        @if(isset($Search_audio)) 
                        @foreach($Search_audio as $audio_search)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{  URL::to('audio') .'/'.$audio_search->slug  }} ">

                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio_search->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($audio_search->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$audio_search->ppv_price}}
                                                    </p>
                                                @elseif( !empty($audio_search->global_ppv || !empty($audio_search->global_ppv) && $audio_search->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $audio_search->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($audio_search->global_ppv == null && $audio_search->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            

                                        <div class="block-description" style="bottom:-38px!important;">
                                        
                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                    {{  $audio_search->age_restrict.' '.'+' }}
                                                    </div>
                                                @endif

                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $audio_search->duration)}}
                                                    </span>
                                                @endif
                                            </div>


                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($audio_search->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($audio_search->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 &&  $audio_search->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="hover-buttons">
                                                <a  href="<?php echo URL::to('audio') ?><?= '/' . $audio_search->slug ?>">		
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $audio_search->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div>   </div>
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
    include(public_path('themes/default/views/footer.blade.php'));
@endphp