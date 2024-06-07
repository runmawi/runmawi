@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $key => $series_networks )
        @if (!empty($series_networks->Series_depends_Networks) && ($series_networks->Series_depends_Networks)->isNotEmpty() )
        <section id="iq-trending" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                                        
                                                                    {{-- Header --}}
                            <div class="iq-main-header d-flex align-items-center justify-content-between">
                                <h4 class="main-title mar-left"><a href="{{ route('Specific_Series_Networks',[$series_networks->slug] )}}">{{ optional($series_networks)->name }}</a></h4>
                                <h4 class="main-title"><a href="{{ route('Specific_Series_Networks',[$series_networks->slug] )}}">{{ "view all" }}</a></h4>
                            </div>

                        <div class="channels-list">
                            <div class="channel-row">
                                <div id="trending-slider-nav" class="video-list series-based-networks-video">
                                    @foreach ($series_networks->Series_depends_Networks as $key => $series )
                                        <div class="item" data-index="{{ $key }}">
                                            <div>
                                                <img src="{{ $series->image_url }}" class="flickity-lazyloaded" alt="latest_series"  width="300" height="200">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div id="videoInfo" class="series-based-networks-dropdown" style="display:none;">
                                <button class="drp-close">×</button>
                                <div class="vib" style="display:flex;">
                                    @foreach ($series_networks->Series_depends_Networks as $key => $series )
                                        <div class="caption" data-index="{{ $key }}">
                                            <h2 class="caption-h2">{{ optional($series)->title }}</h2>

                                            @if (optional($series)->description)
                                                <div class="trending-dec">{!! html_entity_decode( optional($series)->description) !!}</div>
                                            @endif
                                            <div class="p-btns">
                                                <div class="d-flex align-items-center p-0">
                                                    <a href="{{ route('network.play_series',$series->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumbnail" data-index="{{ $key }}">
                                            <img src="{{ $series->Player_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
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
    @endforeach

    {{-- Networks depends Episode Modal --}}

    @foreach( $data as $key => $series_networks )
        @foreach ($series_networks->Series_depends_Networks as $Series_depends_Networks_key =>  $series )
            @foreach ($series->Series_depends_episodes as $episode_key =>  $episode )
                <div class="modal fade info_model" id="{{ "Home-Networks-based-categories-episode-Modal-".$key.'-'.$Series_depends_Networks_key.'-'.$episode_key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @if ( $multiple_compress_image == 1)
                                                    <img  alt="latest_series" src="{{$series->player_image ?  URL::to('public/uploads/images/'.$series->player_image) : $default_horizontal_image_url }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$series->responsive_player_image.' 860w') }},
                                                        {{ URL::to('public/uploads/Tabletimages/'.$series->responsive_player_image.' 640w') }},
                                                        {{ URL::to('public/uploads/mobileimages/'.$series->responsive_player_image.' 420w') }}" >
                                                @else
                                                    <img  src="{{ $series->Player_image_url }}" alt="Videos">
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($episode)->title }}</h2>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>

                                                @if (optional($episode)->episode_description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode( optional($episode)->episode_description) !!}</div>
                                                @endif

                                                <a href="{{ route('network_play_episode', [$series->slug, $episode->slug]) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    @endforeach
@endif

<script>
    
    var elem = document.querySelector('.series-based-networks-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        adaptiveHeight: true,
        pageDots: false
    });

    document.querySelectorAll('.series-based-networks-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.series-based-networks-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.series-based-networks-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.series-based-networks-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.series-based-networks-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.series-based-networks-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('series-based-networks-dropdown')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.series-based-networks-dropdown').hide();
    });
</script>

