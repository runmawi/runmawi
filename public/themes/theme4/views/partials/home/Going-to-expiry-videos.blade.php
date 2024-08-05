@php

    $order_settings_list = App\OrderHomeSetting::get();  

    $check_Kidmode = 0 ;

    $data = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description',
                                        'expiry_date','active','status','draft')

        ->where('active',1)->where('status', 1)->where('draft',1);

        if( $videos_expiry_date_status == 1 ){
            $data = $data->whereNotNull('expiry_date')->where('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
        }

        if( $getfeching !=null && $getfeching->geofencing == 'ON')
        {
            $data = $data->whereNotIn('videos.id',Block_videos());
        }

        if( !Auth::guest() && $check_Kidmode == 1 )
        {
            $data = $data->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
        }

        $data = $data->latest()->limit(15)->get()->map(function ($item) {
            $item['image_url']          =  $item->image != null ?  URL::to('/public/uploads/images/'.$item->image) :  @$default_vertical_image_url ;
            $item['Player_image_url']   =  $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) :  @$default_horizontal_image_url ;
            $item['TV_image_url']       =  $item->video_tv_image != null ?  URL::to('public/uploads/images/'.$item->video_tv_image) :  @$default_horizontal_image_url ;
            $item['source_type']        = "Videos" ;
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
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[32]->url ? URL::to($order_settings_list[32]->url) : null }} ">{{ optional($order_settings_list[32])->header_name }}</a></h4>
                        {{-- <h4 class="main-title"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ 'View all' }}</a></h4> --}}
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list expiry-video">
                                @foreach ($data as $key => $Going_to_expiry_videos)
                                    <div class="item" data-index="{{ $key }}">
                                        <div>
                                            <img src="{{ $Going_to_expiry_videos->image ?  URL::to('public/uploads/images/'.$Going_to_expiry_videos->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{$Going_to_expiry_videos->title}}">
                                            @if(!empty($Going_to_expiry_videos->expiry_date))
                                                <div><span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;" class="p-tag">{{ "Expiry In ". Carbon\Carbon::parse($Going_to_expiry_videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</span></div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="videoInfo" class="expiry-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $Going_to_expiry_videos )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($Going_to_expiry_videos)->title }}</h2>

                                        @if ( $videos_expiry_date_status == 1 && optional($Going_to_expiry_videos)->expiry_date)
                                            <ul class="vod-info">
                                                <li>{{ "Expiry In ". Carbon\Carbon::parse($Going_to_expiry_videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</li>
                                            </ul>
                                        @endif

                                        @if (optional($Going_to_expiry_videos)->description)
                                            <div class="trending-dec">{!! html_entity_decode( optional($Going_to_expiry_videos)->description) !!}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Going_to_expiry_videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img src="{{ $Going_to_expiry_videos->player_image ?  URL::to('public/uploads/images/'.$Going_to_expiry_videos->player_image) : $default_horizontal_image_url }}" class="flickity-lazyloaded" alt="latest_series" width="300" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($data as $key => $Going_to_expiry_videos )
            <div class="modal fade info_model" id="{{ "Home-Going_to_expiry_videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ $Going_to_expiry_videos->player_image ?  URL::to('public/uploads/images/'.$Going_to_expiry_videos->player_image) : $default_horizontal_image_url }}" alt="expiry_videos">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ optional($Going_to_expiry_videos)->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($Going_to_expiry_videos)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($Going_to_expiry_videos)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
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

    var elem = document.querySelector('.expiry-video');
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
    document.querySelectorAll('.expiry-video .item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.querySelectorAll('.expiry-video .item').forEach(function(item) {
                item.classList.remove('current');
            });

            item.classList.add('current');

            var index = item.getAttribute('data-index');

            document.querySelectorAll('.expiry-dropdown .caption').forEach(function(caption) {
                caption.style.display = 'none';
            });
            document.querySelectorAll('.expiry-dropdown .thumbnail').forEach(function(thumbnail) {
                thumbnail.style.display = 'none';
            });

            var selectedCaption = document.querySelector('.expiry-dropdown .caption[data-index="' + index + '"]');
            var selectedThumbnail = document.querySelector('.expiry-dropdown .thumbnail[data-index="' + index + '"]');
            if (selectedCaption && selectedThumbnail) {
                selectedCaption.style.display = 'block';
                selectedThumbnail.style.display = 'block';
            }

            document.getElementsByClassName('expiry-dropdown')[0].style.display = 'flex';
        });
    });


    $('body').on('click', '.drp-close', function() {
        $('.expiry-dropdown').hide();
    });
</script>