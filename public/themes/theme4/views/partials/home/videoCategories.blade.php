@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-4"><a href="{{ $order_settings_list[11]->url ? URL::to($order_settings_list[11]->url) : null }} ">{{ optional($order_settings_list[11])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[11]->url ? URL::to($order_settings_list[11]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="videos-category-slider-nav list-inline p-0 ml-4 row align-items-center">
                            @foreach ($data as $videocategories)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $videocategories->image ?  URL::to('public/uploads/videocategory/'.$videocategories->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider" class="list-inline p-0 m-0 align-items-center videos-category-slider">
                            @foreach ($data as $key => $videocategories )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($videocategories)->name }}</h2>

                                                            @if (optional($videocategories)->home_genre)
                                                                <div class="trending-dec">{!! htmlspecialchars(substr(optional($videocategories)->home_genre, 0, 100)) !!}</div>
                                                            @endif

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{route('video_categories',$videocategories->slug )}}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="trending-contens sub_dropdown_image mt-3">
                                                            <ul id="{{ 'trending-slider-nav' }}"  class= "Category-depends-videos pl-5 m-0">

                                                                <?php
                                                                    
                                                                    $VideoCategory = App\CategoryVideo::where('category_id',$videocategories->id)->groupBy('video_id')->pluck('video_id'); 

                                                                    $videos = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','player_image')

                                                                                            ->where('active',1)->where('status', 1)->where('draft',1)->whereIn('id',$VideoCategory);

                                                                                            if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
                                                                                            {
                                                                                                $videos = $videos->whereNotIn('videos.id',Block_videos());
                                                                                            }

                                                                    $videos = $videos->latest()->limit(30)->get();
                                                                    
                                                                ?>

                                                                @foreach ($videos as $video_details )
                                                                    <li>
                                                                        <a href="{{ URL::to('category/videos/'.$video_details->slug) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : default_vertical_image_url() }}" class="img-fluid" >                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ URL::to('category/videos/'.$video_details->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
                                                                                    <p class="trending-dec" >
                                                                                        {{ optional($video_details)->title   }} 
                                                                                        {!! (strip_tags(substr(optional($video_details)->description, 0, 50))) !!}
                                                                                    </p>
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $videocategories->banner_image ?  URL::to('public/uploads/videocategory/'.$videocategories->banner_image) : default_horizontal_image_url() }}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<script>

    $(window).on("load", function() {
        $('.videos-category-slider').fadeOut();
    });

    $(document).ready(function() {

        $('.videos-category-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.videos-category-slider-nav',
        });

        $('.videos-category-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.videos-category-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.Category-depends-videos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.videos-category-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.videos-category-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.videos-category-slider').fadeIn();
        });

        $('body').on('click', '.drp-close', function() {
            $('.videos-category-slider').hide();
        });
    });
</script>