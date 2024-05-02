@php
    $check_Kidmode = 0 ;

    $data =  App\Artist::limit(15)->get()->map(function($item) use($check_Kidmode,$videos_expiry_date_status,$getfeching){

        // Videos 

        $Videoartist = App\Videoartist::where('artist_id',$item->id)->groupBy('video_id')->pluck('video_id'); 

        $item['artist_depends_videos'] = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price', 'duration','rating','image','featured','age_restrict','video_tv_image','player_image')

                                            ->where('active',1)->where('status', 1)->where('draft',1)->whereIn('id',$Videoartist);

                                            if( $getfeching !=null && $getfeching->geofencing == 'ON')
                                            {
                                                $item['artist_depends_videos'] = $item['artist_depends_videos']->whereNotIn('videos.id',Block_videos());
                                            }
                                            
                                            if ($check_Kidmode == 1) {
                                                $item['artist_depends_videos']->whereBetween('videos.age_restrict', [0, 12]);
                                            }

                                            if ($videos_expiry_date_status == 1 ) {
                                                $item['artist_depends_videos'] = $item['artist_depends_videos']->whereNull('expiry_date')->orwhere('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
                                            }

        $item['artist_depends_videos'] = $item['artist_depends_videos']->latest()->limit(15)->get()->map(function ($item) {
                                        $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
                                        $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() ;
                                        $item['source']           = 'series';
                                        return $item;
                                    });

        // Series 
        
        $Seriesartist = App\Seriesartist::where('artist_id',$item->id)->groupBy('series_id')->pluck('series_id'); 

        $item['artist_depends_series'] = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                                    'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description')
                                    ->where('active', '1')->whereIn('id',$Seriesartist)->latest()->limit(15)->get()
                                    ->map(function ($item) {
                                        $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
                                        $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() ;
                                        $item['season_count']     =  App\SeriesSeason::where('series_id',$item->id)->count();
                                        $item['episode_count']    =  App\Episode::where('series_id',$item->id)->count();
                                        $item['source']           = 'series';
                                        return $item;
                                    });  

                                    
        // Series 
        
        $Seriesartist = App\Seriesartist::where('artist_id',$item->id)->groupBy('series_id')->pluck('series_id'); 

        $item['artist_depends_series'] = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                            'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description')
                            ->where('active', '1')->whereIn('id',$Seriesartist)->latest()->limit(15)->get()
                            ->map(function ($item) {
                                $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : default_vertical_image_url() ;
                                $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : default_horizontal_image_url() ;
                                $item['season_count']     =  App\SeriesSeason::where('series_id',$item->id)->count();
                                $item['episode_count']    =  App\Episode::where('series_id',$item->id)->count();
                                $item['source']           = 'series';
                                return $item;
                            });  

        // Audio 
        
        $Audioartist = App\Audioartist::where('artist_id',$item->id)->groupBy('audio_id')->pluck('audio_id'); 

        $item['artist_depends_audios'] = App\Audio::select('id','title','slug','year','rating','access','ppv_price','duration','rating','image',
                                        'featured','player_image','details','description')

                        ->where('active',1)->where('status', 1)->where('draft',1)->WhereIn('id',$Audioartist);

                if( $getfeching !=null && $getfeching->geofencing == 'ON')
                {
                    $item['artist_depends_audios'] = $item['artist_depends_audios']->whereNotIn('id',Block_audios());
                }

            $item['artist_depends_audios'] = $item['artist_depends_audios']->limit(15)->latest()->get()->map(function ($item) {
                            $item['image_url'] = $item->image != null ? URL::to('/public/uploads/audios/'.$item->image) : default_vertical_image_url() ;
                            $item['Player_image_url'] = $item->player_image != null ? URL::to('public/uploads/audios/'.$item->player_image) : default_horizontal_image_url() ; 
                            return $item;
                        });

        return $item;
    });

@endphp

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[8]->url ? URL::to($order_settings_list[8]->url) : null }} ">{{ optional($order_settings_list[8])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[8]->url ? URL::to($order_settings_list[8]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="trending-contens">
                        <ul id="trending-slider-nav" class="artist-slider-nav list-inline p-0 mar-left row align-items-center">
                            @foreach ($data as $artist_details)
                                <li class="slick-slide">
                                    <a href="javascript:;">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $artist_details->image ?  URL::to('public/uploads/artists/'.$artist_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="artist_details">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <ul id="trending-slider artist-slider" class="list-inline p-0 m-0 align-items-center artist-slider theme4-slider">
                            @foreach ($data as $key => $artist_details )
                                <li class="slick-slide">
                                    <div class="tranding-block position-relative trending-thumbnail-image" >
                                        <button class="drp-close">×</button>

                                        <div class="trending-custom-tab">
                                            <div class="trending-content">
                                                <div id="" class="overview-tab tab-pane fade active show">
                                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                                        <div class="caption pl-4">
                                                            <h2 class="caption-h2">{{ optional($artist_details)->artist_name }}</h2>

                                                            @if (optional($artist_details)->description)
                                                                <div class="trending-dec">{!! html_entity_decode( optional($artist_details)->description) !!}</div>
                                                            @endif

                                                            <div class="p-btns">
                                                                <div class="d-flex align-items-center p-0">
                                                                    <a href="{{ URL::to('artist/'.$artist_details->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                                    {{-- <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a> --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="trending-contens sub_dropdown_image mt-3">
                                                            <ul id="{{ 'trending-slider-nav' }}"  class= "artist-depends-content pl-4 m-0">

                                                                @foreach ($artist_details->artist_depends_videos as $artist_content )
                                                                    <li>
                                                                        <a href="{{ URL::to('category/videos/'.$artist_content->slug) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $artist_content->image_url }}" class="img-fluid" alt="artist_details">                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ URL::to('category/videos/'.$artist_content->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
                                                                                    <p class="trending-dec" >
                                                                                        {{ optional($artist_content)->title   }} 
                                                                                        {!! (strip_tags(substr(optional($artist_content)->description, 0, 50))) !!}
                                                                                    </p>
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach

                                                                @foreach ($artist_details->artist_depends_series as $artist_series_content )
                                                                    <li>
                                                                        <a href="{{ URL::to('play_series/'.$artist_series_content->slug) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $artist_series_content->image_url }}" class="img-fluid" alt="artist_details">  

                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ URL::to('play_series/'.$artist_series_content->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
                                                                                    <p class="trending-dec" >
                                                                                        {{ $artist_series_content->season_count ." S ".$artist_series_content->episode_count .' E' }} <br>
                                                                                        {{ optional($artist_series_content)->title   }} <br>
                                                                                        {!! (strip_tags(substr(optional($artist_series_content)->description, 0, 50))) !!}
                                                                                    </p>
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach

                                                                @foreach ($artist_details->artist_depends_audios as $artist_audios_content )
                                                                    <li>
                                                                        <a href="{{ URL::to('category/videos/'.$artist_audios_content->slug) }}">
                                                                            <div class=" position-relative">
                                                                                <img src="{{ $artist_audios_content->image_url }}" class="img-fluid" >                                                                                <div class="controls">
                                                                                   
                                                                                    <a href="{{ URL::to('audio/'.$artist_audios_content->slug) }}">
                                                                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                                                                    </a>

                                                                                    <nav><button class="moreBTN"><i class="fas fa-info-circle"></i><span>More info</span></button></nav>
                                                                                    
                                                                                    <p class="trending-dec" >
                                                                                        {{ optional($artist_audios_content)->title   }} 
                                                                                        {!! (strip_tags(substr(optional($artist_audios_content)->description, 0, 50))) !!}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach

                                                            </ul>
                                                        </div>

                                                        <div class="dropdown_thumbnail">
                                                            <img  src="{{ $artist_details->image ?  URL::to('public/uploads/artists/'.$artist_details->image) : default_horizontal_image_url() }}" alt="artist_details">
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
        $('.artist-slider').fadeOut();
    });

    $(document).ready(function() {

        $('.artist-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.artist-slider-nav',
        });

        $('.artist-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.artist-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        
        $('.artist-depends-content').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" aria-label="arrow" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
        

        $('.artist-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.artist-slider').fadeIn();
        });

        $('body').on('click', '.drp-close', function() {
            $('.artist-slider').hide();
        });
    });
</script>