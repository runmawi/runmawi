
@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[15]->url ? URL::to($order_settings_list[15]->url) : null }} ">{{ optional($order_settings_list[15])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[15]->url ? URL::to($order_settings_list[15]->url) : null }} ">{{ "View all" }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list latest-viewed-video">
                                @foreach ($data as $key => $latest_view_video)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ( $multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{ $latest_view_video->title }}" src="{{ $latest_view_video->image ?  URL::to('public/uploads/images/'.$latest_view_video->image) : $default_vertical_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$latest_view_video->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$latest_view_video->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$latest_view_video->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $latest_view_video->image ? URL::to('public/uploads/images/'.$latest_view_video->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{ $latest_view_video->title}}">
                                            @endif  
                                            @if ($videos_expiry_date_status == 1 && optional($latest_view_video)->expiry_date)
                                                <p style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit;">{{ 'Leaving Soon' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="latest-viewed-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $latest_view_video)
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($latest_view_video)->title }}</h2>

                                        @if ($videos_expiry_date_status == 1 && optional($latest_view_video)->expiry_date)
                                            <ul class="vod-info">
                                                <li>{{ "Expiry In ". Carbon\Carbon::parse($latest_view_video->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                            </ul>
                                        @endif

                                        @if (optional($latest_view_video)->description)
                                            <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode(optional($latest_view_video)->description)), 500) }}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('category/videos/'.$latest_view_video->slug ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Latest-viewed_videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $latest_view_video->player_image ?  URL::to('public/uploads/images/'.$latest_view_video->player_image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @foreach ($data as $key => $latest_view_video )
            <div class="modal fade info_model" id="{{ "Home-Latest-viewed_videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                        @if ( $multiple_compress_image == 1)
                                            <img  alt="" width="100%" src="{{ $latest_view_video->player_image ?  URL::to('public/uploads/images/'.$latest_view_video->player_image) : $default_horizontal_image_url }}"
                                                srcset="{{ URL::to('public/uploads/PCimages/'.$latest_view_video->responsive_player_image.' 860w') }},
                                                {{ URL::to('public/uploads/Tabletimages/'.$latest_view_video->responsive_player_image.' 640w') }},
                                                {{ URL::to('public/uploads/mobileimages/'.$latest_view_video->responsive_player_image.' 420w') }}" >
                                        @else
                                            <img  src="{{ $latest_view_video->player_image ?  URL::to('public/uploads/images/'.$latest_view_video->player_image) : $default_horizontal_image_url }}" alt="" width="100%">
                                        @endif 
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($latest_view_video)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($latest_view_video)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($latest_view_video)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$latest_view_video->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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

    var elem = document.querySelector('.latest-viewed-video');
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
    document.querySelectorAll('.latest-viewed-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.latest-viewed-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.latest-viewed-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.latest-viewed-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.latest-viewed-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.latest-viewed-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('latest-viewed-dropdown')[0].style.display = 'flex';
        });
    });
  
  
    $('body').on('click', '.drp-close', function() {
        $('.latest-viewed-dropdown').hide();
    });
</script>