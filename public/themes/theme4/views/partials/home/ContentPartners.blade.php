@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a
                                href="{{ $order_settings_list[14]->url ? URL::to($order_settings_list[14]->url) : null }} ">{{ optional($order_settings_list[14])->header_name }}</a>
                        </h4>
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[14]->url ? URL::to($order_settings_list[14]->url) : null }} ">{{ 'View all' }}</a>
                        </h4>
                    </div>


                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list cpp-video">
                                @foreach ($data as $key => $CPP_details)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ( $multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{ $CPP_details->title }}" src="{{ $CPP_details->image ?  URL::to('public/uploads/images/'.$CPP_details->image) : $default_vertical_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$CPP_details->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$CPP_details->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$CPP_details->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $CPP_details->picture ?$CPP_details->picture : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{ $CPP_details->title }}">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="cpp-video-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $CPP_details)
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($CPP_details)->username }}</h2>

                                        @if (optional($CPP_details)->description)
                                            <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode(optional($CPP_details)->description)), 500) }}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('contentpartner/' . $CPP_details->slug ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $CPP_details->player_image ?  URL::to('public/uploads/images/'.$CPP_details->player_image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


<script>

    var elem = document.querySelector('.cpp-video');
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
    document.querySelectorAll('.cpp-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.cpp-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.cpp-video-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.cpp-video-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.cpp-video-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.cpp-video-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('cpp-video-dropdown')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.cpp-video-dropdown').hide();
    });
</script>
