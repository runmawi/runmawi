@php
    include public_path("themes/{$current_theme}/views/header.php");
@endphp

<section id="iq-favorites" class="pagelist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header d-flex align-items-center justify-content-center">
                    <h4 class="main-title fira-sans-condensed-regular">
                        {{ $header_name ?? '' }}
                    </h4>  
                </div>

                @if (!empty($page_list))
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @forelse($page_list as $page_list_video)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="{{ url($base_url . '/' . $page_list_video->slug) }}" aria-label="video">
                                        <div class="block-images position-relative"> 
                                            <div class="img-box">
                                                <a href="{{ url($base_url . '/' . $page_list_video->slug) }}">
                                                    <img src="{{ url('/public/uploads/images/' . $page_list_video->image) }}" 
                                                         class="img-fluid w-100 h-50 flickity-lazyloaded" 
                                                         alt="{{ $page_list_video->title }}">
                                                </a>
                                                @if ($ThumbnailSetting->published_on)
                                                    <p class="published_on1">{{ $publish_time }}</p>
                                                @endif
                                            </div>
                                        </div>
            
                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a href="{{ url($base_url . '/' . $page_list_video->slug) }}" aria-label="Latest-Video"> 
                                                    <img class="ply" src="{{ url('/assets/img/default_play_buttons.svg') }}" alt="play" /> 
                                                </a>
                                            </div>
                                        </div>
            
                                        <div class="p-0">
                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                @if ($ThumbnailSetting->title)
                                                    <h6>{{ Str::limit($page_list_video->title, 18, '...') }}</h6>
                                                @endif

                                                @if ($ThumbnailSetting->age)
                                                    <div class="badge badge-secondary">{{ $page_list_video->age_restrict }}+</div>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ($ThumbnailSetting->duration)
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $page_list_video->duration) }}
                                                    </span>
                                                @endif

                                                @if ($ThumbnailSetting->rating && $page_list_video->rating)
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ $page_list_video->rating }}
                                                    </span>
                                                @endif

                                                @if ($ThumbnailSetting->featured && $page_list_video->featured)
                                                    <span class="text-white">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ($ThumbnailSetting->published_year && $page_list_video->year)
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        {{ $page_list_video->year }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @php
                                                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                        ->where('categoryvideos.video_id', $page_list_video->id)
                                                        ->pluck('video_categories.name');
                                                @endphp

                                                @if ($ThumbnailSetting->category && $CategoryThumbnail_setting->isNotEmpty())
                                                    <span class="text-white">
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        {{ $CategoryThumbnail_setting->implode(', ') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4"
                                    style="background: url({{ url('/assets/img/watch.png') }});height: 500px;background-position: center;background-repeat: no-repeat;background-size: contain;">
                                    <h3 class="text-center">{{ __('No Video Available') }}</h3>
                                </div>
                            @endforelse
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $page_list->links() !!}
                        </div>
                    </div>
                @else
                    <div class="col-md-12 text-center mt-4"
                        style="background: url({{ url('/assets/img/watch.png') }});height: 500px;background-position: center;background-repeat: no-repeat;background-size: contain;">
                        <h3 class="text-center">{{ __('No Video Available') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<?php include public_path("themes/$current_theme/views/footer.blade.php"); ?>
