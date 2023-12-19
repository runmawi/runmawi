@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title pl-5"><a href="{{ $order_settings_list[12]->url ? URL::to($order_settings_list[12]->url) : null }} ">{{ optional($order_settings_list[12])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[12]->url ? URL::to($order_settings_list[12]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="live-category-slider-nav list-inline p-0 ml-5 row align-items-center">
                            @foreach ($data as $livecategories)
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $livecategories->image ?  URL::to('public/uploads/livecategory/'.$livecategories->image) : default_vertical_image_url() }}" class="img-fluid" >
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider live-category-slider" class="list-inline p-0 m-0 align-items-center live-category-slider">
                            @foreach ($data as $key => $livecategories )
                                <li>
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-5">
                                                                <h2 class="caption-h2">{{ optional($livecategories)->name }}</h2>

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('LiveCategory/'.$livecategories->slug)  }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Visit </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="trending-contens sub_dropdown_image mt-3">
                                                            <ul id='trending-slider-nav'  class= "Category-depends-live-stream pl-5 m-0">

                                                                <?php
                                                                    
                                                                    $liveCategory = App\CategoryLive::where('category_id',$livecategories->id)->groupBy('live_id')->pluck('live_id'); 

                                                                    $live_stream_videos = App\LiveStream::select('id','title','slug','year','rating','access','ppv_price','publish_type','publish_status','publish_time','duration','rating','image','player_image','Tv_live_image','featured','details','description')
                                                                                            ->limit(30)->where('active',1)->where('status', 1)->whereIn('id',$liveCategory)->latest()->limit(30)
                                                                                            ->get();
                                                                            
                                                                ?>

                                                                @foreach ($live_stream_videos as $livestream_details )
                                                                    <li>
                                                                        <a href="{{ URL::to('live/'.$livestream_details->slug) }}">
                                                                            <div class=" position-relative">

                                                                                <img src="{{ $livestream_details->image ?  URL::to('public/uploads/images/'.$livestream_details->image) : default_vertical_image_url() }}" class="img-fluid" >                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ URL::to('live/'.$livestream_details->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
                                                                                    @if ($livestream_details->publish_type == "publish_now" || ($livestream_details->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_details->publish_time))) 
                                                                                        <p class="vod-info">
                                                                                            <img src="{{ URL::to('public\themes\theme4\views\img\Live-Icon.png') }}" alt="" width="25%">
                                                                                        </p>
                                                                                    @endif

                                                                                    <p class="trending-dec" style="position: absolute ;bottom: 2px">
                                                                                        
                                                                                        @if ($livestream_details->publish_type == "publish_later")
                                                                                            {{ 'Live Start On '. Carbon\Carbon::parse($livestream_details->publish_time)->isoFormat('YYYY-MM-DD h:mm A') }}  <br>   
                                                                                        @endif

                                                                                        {{ optional($livestream_details)->title   }} 
                                                                                        {!! (strip_tags(substr(optional($livestream_details)->description, 0, 50))) !!}
                                                                                    </p>

                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $livecategories->image ?  URL::to('public/uploads/livecategory/'.$livecategories->image) : default_horizontal_image_url() }}" alt="">
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
    
    $( window ).on("load", function() {
        $('.live-category-slider').fadeOut();
    });

    $(document).ready(function() {

        $('.live-category-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.live-category-slider-nav',
        });

        $('.live-category-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.live-category-slider',
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

        $('.Category-depends-live-stream').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.live-category-slider',
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

        $('.live-category-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.live-category-slider').fadeIn();
        });

        $('body').on('click', '.drp-close', function() {
            $('.live-category-slider').hide();
        });
    });
</script>