@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[11]->url ? URL::to($order_settings_list[11]->url) : null }} ">{{ optional($order_settings_list[11])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[11]->url ? URL::to($order_settings_list[11]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="videos-category-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $videocategories)
                                <li class="slick-slide">
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                                <img src="{{ $videocategories->image ?  URL::to('public/uploads/videocategory/'.$videocategories->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider" class="list-inline p-0 m-0 align-items-center videos-category-slider theme4-slider" style="display:none;">
                            @foreach ($data as $key => $videocategories )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show h-100">
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
                                                            <ul id="{{ 'trending-slider-nav' }}"  class= "Category-depends-videos pl-4 m-0">

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
                                                                    
                                                                ?>

                                                                @foreach ($videos as $video_details )
                                                                    <li>
                                                                        <a href="{{ URL::to('category/videos/'.$video_details->slug) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : $default_vertical_image_url }}" class="img-fluid" alt="Videos">                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ URL::to('category/videos/'.$video_details->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Latest-videos-Modal-'.$key }}"><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>

                                                                                    <p class="trending-dec" >
                                                                                        {{ optional($video_details)->title   }} 
                                                                                        {!! (strip_tags(substr(optional($video_details)->description, 0, 50))) !!}
                                                                                    </p>

                                                                                </div>

                                                                                @if ($videos_expiry_date_status == 1 && optional($video_details)->expiry_date)
                                                                                    <p style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit;">{{ 'Leaving Soon' }}</p>
                                                                                @endif
                                                                                
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                                <img  src="{{ $videocategories->banner_image ?  URL::to('public/uploads/videocategory/'.$videocategories->banner_image) : $default_horizontal_image_url }}" alt="Videos">
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

        @foreach ($data as $key => $video_details )
            <div class="modal fade info_model" id="{{ "Home-Latest-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @if ( $multiple_compress_image == 1)
                                                <img  alt="latest_series" src="{{$video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : $default_horizontal_image_url }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$video_details->responsive_player_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$video_details->responsive_player_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$video_details->responsive_player_image.' 420w') }}" >
                                            @else
                                                <img  src="{{ $video_details->player_image ?  URL::to('public/uploads/images/'.$video_details->player_image) : $default_horizontal_image_url }}" alt="Videos" >
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($video_details)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($video_details)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($video_details)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$video_details->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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
            slidesToScroll: 6,
            asNavFor: '.videos-category-slider',
            dots: false,
            arrows: true,
            prevArrow: '<a href="#" class="slick-arrow slick-prev" aria-label="Previous" type="button">Previous</a>',
            nextArrow: '<a href="#" class="slick-arrow slick-next" aria-label="Next" type="button">Next</a>',
            infinite: true,
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
            dots: false,
            arrows: true,
            prevArrow: '<a href="#" class="slick-arrow slick-prev" aria-label="Previous" type="button">Previous</a>',
            nextArrow: '<a href="#" class="slick-arrow slick-next" aria-label="Next" type="button">Next</a>',
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

        $('body').on('click', '.slick-arrow', function() {
            $('.videos-category-slider').hide();
        });

        $('body').on('click', '.drp-close', function() {
            $('.videos-category-slider').hide();
        });
    });
</script>