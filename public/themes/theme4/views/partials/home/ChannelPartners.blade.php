@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">

                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a
                                href="{{ $order_settings_list[13]->url ? URL::to($order_settings_list[13]->url) : null }} ">{{ optional($order_settings_list[13])->header_name }}</a>
                        </h4>
                        <h4 class="main-title"><a
                                href="{{ $order_settings_list[13]->url ? URL::to($order_settings_list[13]->url) : null }} ">{{ 'View all' }}</a>
                        </h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list channel-video">
                                @foreach ($data as $key => $channel)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ( $multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{ $channel->title }}" src="{{ $channel->image ?  URL::to('public/uploads/images/'.$channel->image) : $default_vertical_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$channel->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$channel->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$channel->responsive_image.' 420w') }}" >
                                            @else
                                                <img src="{{ $channel->channel_logo ? $channel->channel_logo : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="channel">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="channel-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $channel)
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($channel)->channel_name }}</h2>

                                        @if (optional($channel)->description)
                                            <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode(optional($channel)->description)), 500) }}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('channel/' . $channel->channel_slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-channel-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        @if ( $multiple_compress_image == 1)
                                            <img  alt="latest_series" src="{{$channel->player_image ?  URL::to('public/uploads/images/'.$channel->player_image) : $default_horizontal_image_url }}"
                                                srcset="{{ URL::to('public/uploads/PCimages/'.$channel->responsive_player_image.' 860w') }},
                                                {{ URL::to('public/uploads/Tabletimages/'.$channel->responsive_player_image.' 640w') }},
                                                {{ URL::to('public/uploads/mobileimages/'.$channel->responsive_player_image.' 420w') }}" >
                                        @else
                                            <img  src="{{ $channel->channel_logo ? $channel->channel_logo : $default_vertical_image_url }}" alt="channel">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($data as $key => $channel )
            <div class="modal fade info_model" id="{{ "Home-channel-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $channel->channel_logo ? $channel->channel_logo : $default_vertical_image_url }}" alt="channel">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($channel)->channel_name }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>


                                            @if (optional($channel)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($channel)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('channel/' . $channel->channel_slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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

    var elem = document.querySelector('.channel-video');
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
    document.querySelectorAll('.channel-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.channel-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.channel-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.channel-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.channel-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.channel-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('channel-dropdown')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.channel-dropdown').hide();
    });
</script>
