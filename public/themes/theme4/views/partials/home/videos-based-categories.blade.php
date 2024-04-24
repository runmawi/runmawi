<?php 
    $check_Kidmode = 0 ;

    $data = App\VideoCategory::query()->limit(15)->whereHas('category_videos', function ($query) use ($check_Kidmode,$videos_expiry_date_status) {
        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $query->whereNotIn('videos.id', Block_videos());
        }
        
        if ($videos_expiry_date_status == 1 ) {
            $query->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
        }

        if ($check_Kidmode == 1) {
            $query->whereBetween('videos.age_restrict', [0, 12]);
        }
    })

    ->with(['category_videos' => function ($videos) use ($check_Kidmode,$videos_expiry_date_status) {
        $videos->select('videos.id', 'title', 'slug', 'year', 'rating', 'access', 'publish_type', 'global_ppv', 'publish_time', 'ppv_price', 'duration', 'rating', 'image', 'featured', 'age_restrict','player_image','description','videos.trailer','videos.trailer_type','videos.expiry_date','responsive_image','responsive_player_image','responsive_tv_image')
            ->where('videos.active', 1)
            ->where('videos.status', 1)
            ->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $videos->whereNotIn('videos.id', Block_videos());
        }

        if ($videos_expiry_date_status == 1 ) {
            $videos->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
        }

        if ($check_Kidmode == 1) {
            $videos->whereBetween('videos.age_restrict', [0, 12]);
        }

        $videos->latest('videos.created_at')->limit(15)->get();
    }])
    ->select('video_categories.id', 'video_categories.name', 'video_categories.slug', 'video_categories.in_home', 'video_categories.order')
    ->where('video_categories.in_home', 1)
    ->whereHas('category_videos', function ($query) use ($check_Kidmode,$videos_expiry_date_status) {
        $query->where('videos.active', 1)->where('videos.status', 1)->where('videos.draft', 1);

        if (Geofencing() != null && Geofencing()->geofencing == 'ON') {
            $query->whereNotIn('videos.id', Block_videos());
        }

        if ($videos_expiry_date_status == 1 ) {
            $query->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
        }

        if ($check_Kidmode == 1) {
            $query->whereBetween('videos.age_restrict', [0, 12]);
        }
    })
    ->orderBy('video_categories.order')
    ->get()
    ->map(function ($category) {
        $category->category_videos->map(function ($video) {
            $video->image_url = URL::to('/public/uploads/images/'.$video->image);
            $video->Player_image_url = URL::to('/public/uploads/images/'.$video->player_image);
            return $video;
        });
        $category->source =  "category_videos" ;
        return $category;
    });
?>

@if (!empty($data) && $data->isNotEmpty())

    @foreach( $data as $key => $video_category )
        <section id="iq-trending" class="s-margin">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                                        
                                        {{-- Header --}}
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title mar-left"><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ optional($video_category)->name }}</a></h4>
                            <h4 class="main-title "><a href="{{ route('video_categories',[$video_category->slug] )}}">{{ "view all" }}</a></h4>
                        </div>

                        <div class="trending-contens">
                            <ul id="trending-slider-nav" class="{{ 'category-videos-slider-nav list-inline p-0 mar-left row align-items-center' }}" data-key-id="{{$key}}">

                                @foreach ($video_category->category_videos as $videos )
                                    <li class="slick-slide">
                                        <a href="javascript:void(0);">
                                            <div class="movie-slick position-relative">
                                                @if ( $multiple_compress_image == 1)
                                                <img class="img-fluid position-relative" alt="{{ $videos->title }}" src="{{ $videos->image ?  URL::to('public/uploads/images/'.$videos->image) : default_vertical_image_url() }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$videos->responsive_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$videos->responsive_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$videos->responsive_image.' 420w') }}" >
                                                @else
                                                    <img src="{{ $videos->image ?  URL::to('public/uploads/images/'.$videos->image) : default_vertical_image_url() }}" class="img-fluid position-relative" alt="Videos">
                                                @endif  

                                                @if ($videos_expiry_date_status == 1 && optional($videos)->expiry_date)
                                                    <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;">{{ 'Leaving Soon' }}</span>
                                                @endif
                                            
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <ul id="trending-slider" class= "{{ 'category-videos-slider list-inline p-0 m-0 align-items-center category-videos-'.$key }}" >
                                @foreach ($video_category->category_videos as $key => $videos )
                                    <li class="slick-slide">
                                        <div class="tranding-block position-relative trending-thumbnail-image" >
                                            <button class="drp-close">×</button>

                                            <div class="trending-custom-tab">
                                                <div class="trending-content">
                                                    <div id="" class="overview-tab tab-pane fade active show">
                                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                            <div class="caption pl-4">
                                                                <h2 class="caption-h2">{{ optional($videos)->title }}</h2>

                                                                @if ($videos_expiry_date_status == 1 && optional($videos)->expiry_date)
                                                                    <ul class="vod-info">
                                                                        <li>{{ "Expiry In ". Carbon\Carbon::parse($videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                                                    </ul>
                                                                @endif

                                                                @if ( optional($videos)->description )
                                                                    <p class="trending-dec">{!! html_entity_decode( optional($videos)->description) !!}</p>
                                                                @endif

                                                                <div class="p-btns">
                                                                    <div class="d-flex align-items-center p-0">
                                                                        <a href="{{ URL::to('category/videos/'.$videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                        <a class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-videos-based-category-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown_thumbnail">
                                                                
                                                                @if ( $multiple_compress_image == 1)
                                                                    <img  alt="" width="100%" src="{{ $videos->player_image ?  URL::to('public/uploads/images/'.$videos->player_image) : default_horizontal_image_url() }}"
                                                                        srcset="{{ URL::to('public/uploads/PCimages/'.$videos->responsive_player_image.' 860w') }},
                                                                        {{ URL::to('public/uploads/Tabletimages/'.$videos->responsive_player_image.' 640w') }},
                                                                        {{ URL::to('public/uploads/mobileimages/'.$videos->responsive_player_image.' 420w') }}" >

                                                                @else
                                                                    <img  src="{{ $videos->player_image ?  URL::to('public/uploads/images/'.$videos->player_image) : default_horizontal_image_url() }}" alt="Videos">
                                                                @endif 
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
            
        @foreach ($video_category->category_videos as $key => $videos )
            <div class="modal fade info_model" id="{{ "Home-videos-based-category-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                                                                                            
                                            @if ( $multiple_compress_image == 1)
                                                <img width="100%" alt="" width="100%" src="{{ $videos->player_image ?  URL::to('public/uploads/images/'.$videos->player_image) : default_horizontal_image_url() }}"
                                                    srcset="{{ URL::to('public/uploads/PCimages/'.$videos->responsive_player_image.' 860w') }},
                                                    {{ URL::to('public/uploads/Tabletimages/'.$videos->responsive_player_image.' 640w') }},
                                                    {{ URL::to('public/uploads/mobileimages/'.$videos->responsive_player_image.' 420w') }}" >

                                            @else
                                                <img  src="{{ $videos->player_image ?  URL::to('public/uploads/images/'.$videos->player_image) : default_horizontal_image_url() }}" alt="Videos" width="100%">
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($videos)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>

                                            @if (optional($videos)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($videos)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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
@endif

<script>
    
    $( window ).on("load", function() {
        $('.category-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.category-videos-slider').slick({
            slidesToShow: 6,
            slidesToScroll: 4,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.category-videos-slider-nav',
        });

        $('.category-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.category-videos-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-prev"></a>',
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
        
        $('.category-videos-slider-nav').click(function() {

            $( ".drp-close" ).trigger( "click" );

             let category_key_id = $(this).attr("data-key-id");
             $('.category-videos-slider').hide();
             $('.category-videos-' + category_key_id).show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.category-videos-slider').hide();
        });
    });
</script>