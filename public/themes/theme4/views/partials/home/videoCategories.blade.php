@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[11]->url ? URL::to($order_settings_list[11]->url) : null }} ">{{ optional($order_settings_list[11])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[11]->url ? URL::to($order_settings_list[11]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div id="tv-networks" class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list video_cate-video" data-flickity>
                                @foreach ($data as $key => $videocategories)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ $videocategories->image ?  URL::to('public/uploads/videocategory/'.$videocategories->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{$videocategories->name}}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="video_cate-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:block;">
                                @foreach ($data as $key => $videocategories )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($videocategories)->name }}</h2>
                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{route('video_categories',$videocategories->slug )}}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $videocategories->banner_image ?  URL::to('public/uploads/videocategory/'.$videocategories->banner_image) : $default_horizontal_image_url }}" class="flickity-lazyloaded" alt="{{$videocategories->name}}" width="300" height="200">
                                    </div>

                                    <div id="{{ 'trending-slider-nav' }}" class="{{ 'network-depends-slider networks-depends-series-slider-'.$key .' content-list'}}" data-index="{{ $key }}" >
                                        <?php
                                            $check_Kidmode = 0;

                                            $VideoCategory = App\CategoryVideo::where('category_id',$videocategories->id)->groupBy('video_id')->pluck('video_id'); 

                                            $videos = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','player_image','expiry_date')

                                                                    ->where('active',1)->where('status', 1)->where('draft',1)->whereIn('id',$VideoCategory);

                                                                    if( $getfeching !=null && $getfeching->geofencing == 'ON')
                                                                    {
                                                                        $videos = $videos->whereNotIn('videos.id',Block_videos());
                                                                    }

                                                                    if ($videos_expiry_date_status == 1 ) {
                                                                        $videos = $videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                                                                    }
                                                                    
                                                                    if ($check_Kidmode == 1) {
                                                                        $videos = $videos->whereBetween('videos.age_restrict', [0, 12]);
                                                                    }
                                            

                                            $videos = $videos->latest()->limit(30)->get();
                                            $video = $videos->filter(function ($video) {
                                                return $video->access == 'ppv';
                                            });
                                            
                                        ?>
                                        @foreach ($video as $cate_key => $video_details )
                                            <div class="depends-row">
                                                <div class="depend-items">
                                                    <a href="{{ URL::to('category/videos/'.$video_details->slug) }}">
                                                        <div class=" position-relative">
                                                            <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : $default_vertical_image_url }}" class="img-fluid" alt="Videos">                                                                                <div class="controls">
                                                                
                                                                <a href="{{ URL::to('category/videos/'.$video_details->slug) }}">
                                                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                </a>
                                                                
                                                                {{-- <nav ><button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Home-SeriesNetwork-series-Modal"><i class="fas fa-info-circle"></i><span>More info</span></button></nav> --}}
                                                                
                                                                <p class="trending-dec" >
                                                                    {!! (strip_tags(substr(optional($video_details)->description, 0, 50))) !!}
                                                                </p>
                                                                
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($data as $key => $videocategories)
            @foreach ($videos as $cate_key => $video_details)
                <div class="modal fade info_model" id="Home-SeriesNetwork-series-Modal-{{$key}}-{{$cate_key}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                        <div class="container">
                            <div class="modal-content" style="border:none; background:transparent;">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @if ($multiple_compress_image == 1)
                                                    <img alt="latest_series" src="{{$video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : $default_horizontal_image_url }}"
                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$video_details->responsive_player_image.' 860w') }},
                                                        {{ URL::to('public/uploads/Tabletimages/'.$video_details->responsive_player_image.' 640w') }},
                                                        {{ URL::to('public/uploads/mobileimages/'.$video_details->responsive_player_image.' 420w') }}">
                                                @else
                                                    <img src="{{ $video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : $default_horizontal_image_url }}" alt="Videos">
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <h2 class="caption-h2">{{ optional($video_details)->title }}</h2>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                            <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                @if (optional($video_details)->description)
                                                    <div class="trending-dec mt-4">{!! html_entity_decode(optional($video_details)->description) !!}</div>
                                                @endif

                                                <a href="{{ URL::to('category/videos/'.$video_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0"><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content</a>
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




    </section>
@endif

<script>

    var elem = document.querySelector('.video_cate-video');
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
        document.querySelectorAll('.video_cate-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.video_cate-video .item').forEach(function(item) {
                item.classList.remove('current');
            });
    
            this.classList.add('current');
    
            var index = this.getAttribute('data-index');
    
            document.querySelectorAll('.video_cate-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.video_cate-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });
    
            // Hide all sliders
            document.querySelectorAll('.video_cate-dropdown .network-depends-slider').forEach(function(slider) {
                slider.style.display = 'none';
            });
    
                    
            var selectedSlider = document.querySelector('.video_cate-dropdown .network-depends-slider[data-index="' + index + '"]');
                if (selectedSlider) {
                    selectedSlider.style.display = 'block';
                    setTimeout(function() { // Ensure the element is visible before initializing Flickity
                        var flkty = new Flickity(selectedSlider, {
                            cellAlign: 'left',
                            contain: true,
                            groupCells: true,
                            adaptiveHeight: true,
                            pageDots: false,
                        });
                    }, 0);
                }
    
            var selectedCaption = document.querySelector('.video_cate-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.video_cate-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }
    
            document.getElementsByClassName('video_cate-dropdown')[0].style.display = 'flex';
        });
    });
    
    $('body').on('click', '.drp-close', function() {
        $('.video_cate-dropdown').hide();
    });
    </script>