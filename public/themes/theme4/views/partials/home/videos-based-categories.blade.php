
@if (!empty($data) && $data->isNotEmpty())

@foreach($data as $section_key => $video_category)
    @if (!empty($video_category->category_videos) && $video_category->category_videos->isNotEmpty())
        <section id="iq-trending-{{ $section_key }}" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title mar-left"><a href="{{ route('video_categories', [$video_category->slug]) }}">{{ $video_category->name }}</a></h4>
                            <h4 class="main-title "><a href="{{ route('video_categories', [$video_category->slug]) }}">{{ "View All" }}</a></h4>
                        </div>

                        <div id="based-videos" class="channels-list">
                            <div class="channel-row">
                                <div id="trending-slider-nav-{{ $section_key }}" class="video-list videos-based-network-video" data-flickity>
                                    @foreach ($video_category->category_videos as $key => $videos)
                                        <div class="item" data-index="{{ $key }}" data-section-index="{{ $section_key }}">
                                            <div>
                                                @if ($multiple_compress_image == 1)
                                                    <img class="flickity-lazyloaded" alt="{{ $videos->title }}" src="{{ $videos->image ? URL::to('public/uploads/images/' . $videos->image) : $default_vertical_image_url }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/' . $videos->responsive_image . ' 860w') }},
                                                                {{ URL::to('public/uploads/Tabletimages/' . $videos->responsive_image . ' 640w') }},
                                                                {{ URL::to('public/uploads/mobileimages/' . $videos->responsive_image . ' 420w') }}">
                                                @else
                                                    <img src="{{ $videos->image ? URL::to('public/uploads/images/' . $videos->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{ $videos->title }}">
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div id="categoryInfo-{{ $section_key }}" class="videos-based-network-dropdown" style="display:none;">
                                <button class="drp-close">×</button>
                                <div class="vib" style="display:block;">
                                    @foreach ($video_category->category_videos as $key => $videos)
                                        <div class="caption" data-index="{{ $key }}" data-section-index="{{ $section_key }}">
                                            <h2 class="caption-h2">{{ $videos->title }}</h2>

                                            @if ($videos->description)
                                                <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($videos->description)), 500) }}</div>
                                            @endif

                                            <div class="p-btns">
                                                <div class="d-flex align-items-center p-0">
                                                    <a href="{{ URL::to('category/videos/'.$videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now</a>
                                                    <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{'#Home-based-videos-Modal-'.$section_key.'-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="thumbnail" data-index="{{ $key }}" data-section-index="{{ $section_key }}">
                                            @if ($multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{ $videos->title }}" width="300" height="200" src="{{ $videos->player_image ? URL::to('public/uploads/images/' . $videos->player_image) : $default_horizontal_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/' . $videos->responsive_player_image . ' 860w') }},
                                                            {{ URL::to('public/uploads/Tabletimages/' . $videos->responsive_player_image . ' 640w') }},
                                                            {{ URL::to('public/uploads/mobileimages/' . $videos->responsive_player_image . ' 420w') }}">
                                            @else
                                                <img src="{{ $videos->Player_image_url }}" class="flickity-lazyloaded" alt="{{ $videos->title }}" width="300" height="200">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                @foreach ($video_category->category_videos as $key => $videos)
                    <div class="modal fade info_model" id="{{ 'Home-based-videos-Modal-'.$section_key.'-'.$key }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                            <div class="container">
                                <div class="modal-content" style="border:none; background:transparent;">
                                    <div class="modal-body">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    @if ($multiple_compress_image == 1)
                                                        <img width="100%" alt="{{ $videos->title }}" src="{{ $videos->player_image ? URL::to('public/uploads/images/' . $videos->player_image) : $default_horizontal_image_url }}"
                                                            srcset="{{ URL::to('public/uploads/PCimages/' . $videos->responsive_player_image . ' 860w') }},
                                                                    {{ URL::to('public/uploads/Tabletimages/' . $videos->responsive_player_image . ' 640w') }},
                                                                    {{ URL::to('public/uploads/mobileimages/' . $videos->responsive_player_image . ' 420w') }}">
                                                    @else
                                                        <img src="{{ $videos->player_image ? URL::to('public/uploads/images/' . $videos->player_image) : $default_horizontal_image_url }}" alt="{{ $videos->title }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                                            <h2 class="caption-h2">{{ $videos->title }}</h2>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                                            <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    @if ($videos->description)
                                                        <div class="trending-dec mt-4">{!! html_entity_decode($videos->description) !!}</div>
                                                    @endif

                                                    <a href="{{ URL::to('category/videos/' . $videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0"><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
        </section>
    @endif
    @endforeach
@endif


<script>
    document.querySelectorAll('.videos-based-network-video').forEach(function(elem) {
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: true,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyload:true,
        });
    
        elem.querySelectorAll('.item').forEach(function(item) {
            item.addEventListener('click', function() {
                var sectionIndex = this.getAttribute('data-section-index');
                var index = this.getAttribute('data-index');
    
                elem.querySelectorAll('.item').forEach(function(item) {
                    item.classList.remove('current');
                });
                this.classList.add('current');
    
                document.querySelectorAll('#categoryInfo-' + sectionIndex + ' .caption').forEach(function(caption) {
                    caption.style.display = 'none';
                });
                document.querySelectorAll('#categoryInfo-' + sectionIndex + ' .thumbnail').forEach(function(thumbnail) {
                    thumbnail.style.display = 'none';
                });
    
                var selectedCaption = document.querySelector('#categoryInfo-' + sectionIndex + ' .caption[data-index="' + index + '"]');
                var selectedThumbnail = document.querySelector('#categoryInfo-' + sectionIndex + ' .thumbnail[data-index="' + index + '"]');
                if (selectedCaption && selectedThumbnail) {
                    selectedCaption.style.display = 'block';
                    selectedThumbnail.style.display = 'block';
                }
    
                document.getElementById('categoryInfo-' + sectionIndex).style.display = 'flex';
            });
        });
    });
    
    document.querySelectorAll('.drp-close').forEach(function(closeButton) {
        closeButton.addEventListener('click', function() {
            var dropdown = this.closest('.videos-based-network-dropdown');
            dropdown.style.display = 'none';
        });
    });
    </script>
    