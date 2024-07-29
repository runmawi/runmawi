@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[0]->url ? URL::to($order_settings_list[0]->url) : null }} ">{{ optional($order_settings_list[0])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[0]->url ? URL::to($order_settings_list[0]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list featured-video">
                                @foreach ($data as $key => $featured_videos)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ( $multiple_compress_image == 1)
                                                <img class="img-fluid position-relative" alt="{{ $featured_videos->title }}" src="{{ $featured_videos->image ?  URL::to('public/uploads/images/'.$featured_videos->image) : $default_vertical_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$featured_videos->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$featured_videos->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$featured_videos->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $featured_videos->image ?  URL::to('public/uploads/images/'.$featured_videos->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{ $featured_videos->title }}">
                                            @endif
                                        
                                            @if ($videos_expiry_date_status == 1 && optional($featured_videos)->expiry_date)
                                                <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="featured-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $featured_videos )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($featured_videos)->title }}</h2>

                                        @if ($videos_expiry_date_status == 1 && optional($featured_videos)->expiry_date)
                                            <ul class="vod-info">
                                                <li>{{ "Expiry In ". Carbon\Carbon::parse($featured_videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                            </ul>
                                        @endif

                                        @if (optional($featured_videos)->description)
                                            <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode(optional($featured_videos)->description)), 500) }}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('category/videos/'.$featured_videos->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Trending-videoloop-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $featured_videos->player_image ?  URL::to('public/uploads/images/'.$featured_videos->player_image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($data as $key => $featured_videos )
            <div class="modal fade info_model" id="{{ "Home-Trending-videoloop-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @if ( $multiple_compress_image == 1)
                                                <img  alt="latest_series" src="{{$featured_videos->player_image ?  URL::to('public/uploads/images/'.$featured_videos->player_image) : $default_horizontal_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$featured_videos->responsive_player_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$featured_videos->responsive_player_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$featured_videos->responsive_player_image.' 420w') }}" >
                                            @else
                                                <img  src="{{ $featured_videos->player_image ?  URL::to('public/uploads/images/'.$featured_videos->player_image) : $default_horizontal_image_url }}" alt="Videos">
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($featured_videos)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($featured_videos)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($featured_videos)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$featured_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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


<script>

    var elem = document.querySelector('.featured-video');
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
    document.querySelectorAll('.featured-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.featured-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.featured-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.featured-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.featured-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.featured-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('featured-dropdown')[0].style.display = 'flex';
        });
    });
  
  
    $('body').on('click', '.drp-close', function() {
        $('.featured-dropdown').hide();
    });
</script>