@php
    include(public_path('themes/default/views/header.php'));
@endphp

<section id="iq-favorites">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h3 class="vid-title">Search Result of "{{  $search_value }}" Videos</h3>                     
                </div>
                
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      @if(isset($videos)) 
                        @foreach($videos as $latest_video)
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href=" {{ URL::to('home') }} ">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                            
                                                @if(!empty($latest_video->ppv_price))
                                                    <p class="p-tag1" >
                                                        {{  $currency->symbol.' '.$latest_video->ppv_price}}
                                                    </p>
                                                @elseif( !empty($latest_video->global_ppv || !empty($latest_video->global_ppv) && $latest_video->ppv_price == null))
                                                    <p class="p-tag1">
                                                        {{ $latest_video->global_ppv.' '.$currency->symbol }}
                                                    </p>
                                                @elseif($latest_video->global_ppv == null && $latest_video->ppv_price == null )
                                                    <p class="p-tag" > 
                                                        {{  "Free"}} 
                                                    </p>
                                                @endif
                                        </div>
                            

                                        <div class="block-description" style="bottom:-38px!important;">
                                            @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">
                                                    <h6><?php  echo (strlen($latest_video->title) > 17) ? substr($latest_video->title,0,18).'...' : $latest_video->title; ?></h6>
                                                </a>
                                            @endif

                                            <div class="movie-time d-flex align-items-center pt-1">
                                                @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                    <div class="badge badge-secondary p-1 mr-2">
                                                    {{  $latest_video->age_restrict.' '.'+' }}
                                                    </div>
                                                @endif

                                                @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                    <span class="text-white"><i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $latest_video->duration)}}
                                                    </span>
                                                @endif
                                            </div>


                                            @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ ($latest_video->rating)}}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                {{ ($latest_video->year) }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if($ThumbnailSetting->featured == 1 &&  $latest_video->featured == 1)   <!-- Featured -->
                                                        <div class="badge badge-secondary p-1 mr-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="hover-buttons">
                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                                    <span class="text-white">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ "Watch Now" }}
                                                    </span>
                                                </a>
                                            <div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $latest_video->id;?>">
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
    </div>
</section>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp