


@if (!empty($data) && $data->isNotEmpty())
    @foreach( $data as $key => $video_category )
        <section id="iq-trending iq-favorites-{{ $key }}">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">

                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            @if((!preg_match('/^channel\/.+$/', request()->path())))
                                <h4 class="main-title"><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ optional($video_category)->name }}</a></h4>
                                <h4 class="main-title view-all text-primary"><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ 'View all' }}</a></h4>
                            @else
                                <h4 class="main-title"><a href="{{ URL::to('category/'.$video_category->slug.'/channel/'.$channel_partner_slug) }}">{{ optional($video_category)->name }}</a></h4>
                                <h4 class="main-title view-all text-primary"><a href="{{ URL::to('category/'.$video_category->slug.'/channel/'.$channel_partner_slug) }}">{{ 'View all' }}</a></h4>
                            @endif
                        </div>

                        <div class="favorites-contens">
                            <div class="video-based-categories home-sec list-inline row p-0 mb-0" id="video-category-{{ $key }}">
                                @if (!Auth::guest() && !empty($data['password_hash']))
                                    @php $id = Auth::user()->id; @endphp
                                @else
                                    @php $id = 0; @endphp
                                @endif

                                @if(isset($video_category))
                                    @foreach($video_category->category_videos as $videos )
                                        @php
                                            $currentdate = date("M d , y H:i:s");
                                            date_default_timezone_set('Asia/Kolkata');
                                            $current_date = Date("M d , y H:i:s");
                                            $date = date_create($current_date);
                                            $currentdate = date_format($date, "D h:i");
                                            $publish_time = date("D h:i", strtotime($videos->publish_time));
                                            if ($videos->publish_type == 'publish_later')
                                            {
                                                if ($currentdate < $publish_time)
                                                {
                                                    $publish_time = date("D h:i", strtotime($videos->publish_time));
                                                }
                                                else
                                                {
                                                    $publish_time = 'Published';
                                                }
                                            }
                                            elseif ($videos->publish_type == 'publish_now')
                                            {
                                                $currentdate = date_format($date, "y M D");
                                                $publish_time = date("y M D", strtotime($videos->publish_time));
                                                if ($currentdate == $publish_time)
                                                {
                                                    $publish_time = 'Today'.' '.date("h:i", strtotime($videos->publish_time));
                                                }
                                                else
                                                {
                                                    $publish_time = 'Published';
                                                }
                                            }
                                            else
                                            {
                                                $publish_time = '';
                                            }
                                        @endphp 
                                        <div class="items">
                                            <div class="block-images position-relative">
                                                <div class="border-bg">
                                                    <div class="img-box">
                                                        <a class="playTrailer" href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                            <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $videos->image ? URL::to('public/uploads/images/'.$videos->image) : $default_vertical_image_url }}" alt="{{ $videos->title }}">
                                                        </a>

                                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                                                @switch(true)
                                                                    @case($videos->access == 'subscriber')
                                                                        <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                                    @break
                                                                    @case($videos->access == 'registered')
                                                                        <p class="p-tag">{{ __('Register Now') }}</p>
                                                                    @break
                                                                    @case(!empty($videos->ppv_price))
                                                                        <p class="p-tag">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                                                    @break
                                                                    @case(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                        <p class="p-tag">{{ $videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                                    @break
                                                                    @case(empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                        <p class="p-tag">{{ __('Free') }}</p>
                                                                    @break
                                                                @endswitch
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="block-description">
                                                    <a class="playTrailer" href="{{ URL::to('category/videos/'.$videos->slug) }}">

                                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                                            @switch(true)
                                                                @case($videos->access == 'subscriber')
                                                                    <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                                @break
                                                                @case($videos->access == 'registered')
                                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                                @break
                                                                @case(!empty($videos->ppv_price))
                                                                    <p class="p-tag">{{ $currency->symbol . ' ' . $videos->ppv_price }}</p>
                                                                @break
                                                                @case(!empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                    <p class="p-tag">{{ $videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                                @break
                                                                @case(empty($videos->global_ppv) && $videos->ppv_price == null)
                                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                                @break
                                                            @endswitch
                                                        @endif

                                                    <div class="hover-buttons text-white">
                                                        <a href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                            @if($ThumbnailSetting->title == 1)
                                                                <p class="epi-name text-left m-0 mt-2">
                                                                    {{ strlen($videos->title) > 17 ? substr($videos->title, 0, 18) . '...' : $videos->title }}
                                                                </p>
                                                            @endif

                                                            <p class="desc-name text-left m-0 mt-1">
                                                                {{ strlen($videos->description) > 75 ? substr(html_entity_decode(strip_tags($videos->description)), 0, 75) . '...' : strip_tags($videos->description) }}
                                                            </p>

                                                            <div class="movie-time d-flex align-items-center pt-2">
                                                                @if($ThumbnailSetting->age == 1 && !($videos->age_restrict == 0))
                                                                    <span class="position-relative badge p-1 mr-2">{{ $videos->age_restrict}}</span>
                                                                @endif
                                                                @if($ThumbnailSetting->duration == 1)
                                                                    <span class="position-relative text-white mr-2">
                                                                        {{ (floor($videos->duration / 3600) > 0 ? floor($videos->duration / 3600) . 'h ' : '') . floor(($videos->duration % 3600) / 60) . 'm' }}
                                                                    </span>
                                                                @endif
                                                                @if($ThumbnailSetting->published_year == 1 && !($videos->year == 0))
                                                                    <span class="position-relative badge p-1 mr-2">
                                                                        {{ __($videos->year) }}
                                                                    </span>
                                                                @endif
                                                                @if($ThumbnailSetting->featured == 1 && $videos->featured == 1)
                                                                    <span class="position-relative text-white">
                                                                    {{ __('Featured') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @php
                                                                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                                        ->where('categoryvideos.video_id', $videos->video_id)
                                                                        ->pluck('video_categories.name');
                                                                @endphp
                                                                @if ($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                                    <span class="text-white">
                                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                        {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </a>

                                                        <a type="button" class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category/videos/'.$videos->slug) }}">
                                                            <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" /> {{ __('Watch Now') }} 
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.video-based-categories');
        elems.forEach(function (elem) {
            new Flickity(elem, {
                cellAlign: 'left',
                contain: true,
                groupCells: true,
                pageDots: false,
                draggable: true,
                freeScroll: true,
                imagesLoaded: true,
                lazyLoad: true,
            });
        });
    });
</script>