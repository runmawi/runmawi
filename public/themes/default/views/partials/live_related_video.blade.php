    <section id="">
        <div class="row">
          <div class="col-sm-12 ">
                <div class="iq-main-header align-items-center justify-content-between">
            </div>

            <div class="favorites-contens">
                <div class="live-rel-video home-sec list-inline row p-0 mb-0">
                    @if(isset($data))
                        @foreach($data as $video)

                            <div class="items">
                                <div class="block-images position-relative">
                                    <div class="border-bg">
                                        <div class="img-box">
                                            <a class="playTrailer" href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $video->image ? URL::to('/public/uploads/images/' . $video->image) : $default_vertical_image_url }}" alt="{{ $video->title }}" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="block-description">

                                        <div class="hover-buttons text-white">
                                            <a href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                @if($ThumbnailSetting->title == 1)
                                                    <p class="epi-name text-left m-0 mt-2">{{ strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : strip_tags($video->title) }}</p>
                                                @endif

                                                <p class="desc-name text-left m-0 mt-1">
                                                    {{ strlen($video->description) > 75 ? (strip_tags($video->description)) . '...' : strip_tags($video->description) }}
                                                </p>

                                                <div class="movie-time d-flex align-items-center my-2 pt-2">
                                                    @if($ThumbnailSetting->age == 1 && !($video->age_restrict == 0))
                                                        <span class="position-relative badge p-1 mr-2">{{ $video->age_restrict}}</span>
                                                    @endif

                                                    @if($ThumbnailSetting->duration == 1)
                                                        <span class="position-relative text-white mr-2">
                                                            {{ (floor($video->duration / 3600) > 0 ? floor($video->duration / 3600) . 'h ' : '') . floor(($video->duration % 3600) / 60) . 'm' }}
                                                        </span>
                                                    @endif
                                                    @if($ThumbnailSetting->published_year == 1 && !($video->year == 0))
                                                        <span class="position-relative badge p-1 mr-2">
                                                            {{ __($video->year) }}
                                                        </span>
                                                    @endif
                                                    @if($ThumbnailSetting->featured == 1 && $video->featured == 1)
                                                        <span class="position-relative text-white">
                                                        {{ __('Featured') }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time d-flex align-items-center my-2">
                                                    @php
                                                        $CategoryThumbnail_setting = App\LiveCategory::join('livecategories', 'livecategories.category_id', '=', 'live_categories.id')
                                                            ->where('livecategories.live_id', $video->id)
                                                            ->pluck('live_categories.name');
                                                    @endphp
                                                    @if($ThumbnailSetting->category == 1 && count($CategoryThumbnail_setting) > 0)
                                                        <span class="text-white">
                                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </a>

                                            <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/') . '/live/' . $video->slug }}">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                {{ __('Live Now') }}
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
    </section>

