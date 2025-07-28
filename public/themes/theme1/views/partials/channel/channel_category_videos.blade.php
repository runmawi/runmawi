<section id="iq-favorites">

@php 
    $ThumbnailSetting = App\ThumbnailSetting::first();
@endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title"><?= __('Video Category') ?></h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                  
                        @if(isset($videosCategory) && count($videosCategory) > 0 )
                       
                            @foreach($videosCategory as $videos_Category)
                       
                                <li class="slide-item">
                                    <a href="{{ URL::to('category/videos/'. $videos_Category->slug)}}">
                                        <!-- block-images -->
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <a href="{{ URL::to('category/videos/'. $videos_Category->slug)}}">
                                                    <img loading="lazy" src="{{ URL::to('public/uploads/images/'.$videos_Category->image) }}" class="img-fluid w-100" alt="{{ $videos_Category->title}}">
                                                    <!-- <video width="100%" height="auto" class="play-video lazy" poster="{{ URL::to('/') }}/public/uploads/images/{{ $videos_Category->image }}" data-play="hover">
                                                        <source src="{{ $videos_Category->trailer }}" type="video/mp4" />
                                                    </video>-->
                                                </a>
                                            </div>
                                            <div class="block-description">
                                                <div class="hover-buttons">
                                                    <a href="{{ URL::to('category/videos/'. $videos_Category->slug)}}">
                                                        <img class="ply" src="{{ URL::to('/') }}/assets/img/default_play_buttons.svg" />
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- PPV price -->
                                            @if($ThumbnailSetting->free_or_cost_label == 1)
                                                @if($videos_Category->access == 'subscriber')
                                                    <p class="p-tag"> <i class="fas fa-crown" style="color:gold"></i> </p>
                                                @elseif(!empty($videos_Category->ppv_price))
                                                    <p class="p-tag1">{{ $currency->symbol }} {{ $videos_Category->ppv_price }}</p>
                                                @elseif(!empty($videos_Category->global_ppv) && $videos_Category->ppv_price == null)
                                                    <p class="p-tag1">{{ $videos_Category->global_ppv }} {{ $currency->symbol }}</p>
                                                @elseif($videos_Category->global_ppv == null && $videos_Category->ppv_price == null)
                                                    <p class="p-tag">{{ __("Free") }}</p>
                                                @endif
                                            @endif
                                            @if($ThumbnailSetting->published_on == 1)
                                                <p class="published_on1">{{ $publish_time }}</p>
                                            @endif
                                        </div>

                                        <div class="p-0">
                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                @if($ThumbnailSetting->title == 1)
                                                    <h6>{{ (strlen($videos_Category->title) > 17) ? substr($videos_Category->title, 0, 18).'...' : $videos_Category->title }}</h6>
                                                @endif

                                                @if($ThumbnailSetting->age == 1)
                                                    <div class="badge badge-secondary">{{ $videos_Category->age_restrict }} +</div>
                                                @endif
                                            </div>
                                            <div class="movie-time my-2">
                                                <!-- Duration -->
                                                @if($ThumbnailSetting->duration == 1)
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $videos_Category->duration) }}
                                                    </span>
                                                @endif

                                                <!-- Rating -->
                                                @if($ThumbnailSetting->rating == 1 && $videos_Category->rating != null)
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ $videos_Category->rating }}
                                                    </span>
                                                @endif

                                                @if($ThumbnailSetting->featured == 1 && $videos_Category->featured == 1)
                                                    <!-- Featured -->
                                                    <span class="text-white">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                <!-- Published Year -->
                                                @if($ThumbnailSetting->published_year == 1 && $videos_Category->year != null)
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        {{ $videos_Category->year }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                <!-- Category Thumbnail Setting -->
                                                @php
                                                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                        ->where('categoryvideos.video_id', $videos_Category->id)
                                                        ->pluck('video_categories.name');        
                                                @endphp
                                                @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                    <span class="text-white">
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        @foreach($CategoryThumbnail_setting as $CategoryThumbnail)
                                                            {{ $CategoryThumbnail }} 
                                                        @endforeach
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            @endforeach
                        @else
                            <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
                                <h4 class="main-title mb-4">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
                                <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


