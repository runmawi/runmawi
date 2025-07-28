@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left">
                            <a href="{{ URL::to('latest_episodes')}}">{{ "Latest Episodes" }}</a>
                        </h4>                   
                        <h4 class="main-title mar-left">
                            <a href="{{ URL::to('latest_episodes')}}">{{ "View all" }}</a>
                        </h4>                   
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list latest-episodes">
                                @foreach ($data as $key => $episode_details)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            @if ($multiple_compress_image == 1)
                                                <img class="flickity-lazyloaded" alt="{{ $episode_details->title }}" src="{{ $episode_details->image ?  URL::to('public/uploads/images/'.$episode_details->image) : $default_vertical_image_url }}"
                                                    srcset="{{ $episode_details->responsive_image ? (URL::to('public/uploads/PCimages/'.$episode_details->responsive_image.' 860w')) : URL::to('public/uploads/images/'.$episode_details->image) }},
                                                    {{ $episode_details->responsive_image ? URL::to('public/uploads/Tabletimages/'.$episode_details->responsive_image.' 640w') : URL::to('public/uploads/images/'.$episode_details->image) }},
                                                    {{ $episode_details->responsive_image ? URL::to('public/uploads/mobileimages/'.$episode_details->responsive_image.' 420w') : URL::to('public/uploads/images/'.$episode_details->image) }}" >
                                            @else
                                                <img src="{{ $episode_details->image ? URL::to('public/uploads/images/'.$episode_details->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{ $episode_details->title }}"  width="300" height="200">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="latest-episodes-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $episode_details )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($episode_details)->title }}</h2>

                                        @php
                                            $series_seasons_name = App\SeriesSeason::where('id',$episode_details->season_id)->pluck('series_seasons_name')->first() ;
                                        @endphp

                                        @if (!is_null($series_seasons_name))
                                            <div class="d-flex align-items-center text-white text-detail">
                                                {{ "Season - ". $series_seasons_name  }}  
                                            </div>
                                        @endif

                                        @if (optional($episode_details)->episode_description)
                                            <div class="trending-dec">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode(optional($episode_details)->episode_description)), 500) }}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('episode/'. $episode_details->series_title->slug.'/'.$episode_details->slug ) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Latest-episodes-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $episode_details->player_image ?  URL::to('public/uploads/images/'.$episode_details->player_image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>


        @foreach ($data as $key => $episode_details )
            <div class="modal fade info_model" id="{{ "Home-Latest-episodes-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $episode_details->player_image ?  URL::to('public/uploads/images/'.$episode_details->player_image) : $default_horizontal_image_url }}" alt="episode_details">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($episode_details)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($episode_details)->episode_description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($episode_details)->episode_description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('episode/'. $episode_details->series_title->slug.'/'.$episode_details->slug ) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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

    var elem = document.querySelector('.latest-episodes');
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
    document.querySelectorAll('.latest-episodes .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.latest-episodes .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.latest-episodes-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.latest-episodes-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.latest-episodes-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.latest-episodes-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('latest-episodes-dropdown')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.latest-episodes-dropdown').hide();
    });
</script>