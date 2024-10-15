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
            $item['image_url']          =  URL::to('/public/uploads/images/'.$item->image) ;
            $item['Player_image_url']   =  URL::to('public/uploads/images/'.$item->player_image) ;
            $item['TV_image_url']       =  URL::to('public/uploads/images/'.$item->video_tv_image) ;
            $item['source_type']        = "Videos" ;
            return $item;
        });

@endphp


@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[32]->url ? URL::to($order_settings_list[32]->url) : null }} ">{{ optional($order_settings_list[32])->header_name }}</a></h4>
                        {{-- <h4 class="main-title"><a href="{{ $order_settings_list[33]->url ? URL::to($order_settings_list[33]->url) : null }} ">{{ 'View all' }}</a></h4> --}}
                    </div>

                    <div class="favorites-contens">
                        <div class="going-to-expiry home-sec list-inline row p-0 mb-0">
                            @foreach($data as $Going_to_expiry_videos) 
                                <div class="items">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" src="{{ $Going_to_expiry_videos->image_url ?  $Going_to_expiry_videos->image_url : $default_vertical_image_url }}" data-src="{{ $Going_to_expiry_videos->image_url ?  $Going_to_expiry_videos->image_url : $default_vertical_image_url }}" alt="{{ $Going_to_expiry_videos->title }}">
                                                </a>
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($Going_to_expiry_videos->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($Going_to_expiry_videos->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($Going_to_expiry_videos->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $Going_to_expiry_videos->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($Going_to_expiry_videos->global_ppv) && $Going_to_expiry_videos->ppv_price == null)
                                                            <p class="p-tag">{{ $Going_to_expiry_videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($Going_to_expiry_videos->global_ppv == null && $Going_to_expiry_videos->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                @if($ThumbnailSetting->free_or_cost_label == 1)
                                                    @switch(true)
                                                        @case($Going_to_expiry_videos->access == 'subscriber')
                                                            <p class="p-tag"><i class="fas fa-crown" style="color:gold"></i></p>
                                                        @break
                                                        @case($Going_to_expiry_videos->access == 'registered')
                                                            <p class="p-tag">{{ __('Register Now') }}</p>
                                                        @break
                                                        @case(!empty($Going_to_expiry_videos->ppv_price))
                                                            <p class="p-tag">{{ $currency->symbol . ' ' . $Going_to_expiry_videos->ppv_price }}</p>
                                                        @break
                                                        @case(!empty($Going_to_expiry_videos->global_ppv) && $Going_to_expiry_videos->ppv_price == null)
                                                            <p class="p-tag">{{ $Going_to_expiry_videos->global_ppv . ' ' . $currency->symbol }}</p>
                                                        @break
                                                        @case($Going_to_expiry_videos->global_ppv == null && $Going_to_expiry_videos->ppv_price == null)
                                                            <p class="p-tag">{{ __('Free') }}</p>
                                                        @break
                                                    @endswitch
                                                @endif   
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0 mt-2">{{ strlen($Going_to_expiry_videos->title) > 17 ? substr($Going_to_expiry_videos->title, 0, 18) . '...' : $Going_to_expiry_videos->title }}</p>
                                                    @endif

                                                    @if($ThumbnailSetting->enable_description == 1)
                                                        <p class="desc-name text-left m-0 mt-1">
                                                            {{ strlen($Going_to_expiry_videos->description) > 75 ? substr(html_entity_decode(strip_tags($Going_to_expiry_videos->description)), 0, 75) . '...' : strip_tags($Going_to_expiry_videos->description) }}
                                                        </p>
                                                    @endif
                                                    
                                                    <div class="movie-time d-flex align-items-center pt-2">
                                                        @if($ThumbnailSetting->age == 1 && !($Going_to_expiry_videos->age_restrict == 0))
                                                            <span class="position-relative badge p-1 mr-2">{{ $Going_to_expiry_videos->age_restrict }}</span>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="position-relative text-white mr-2">
                                                                {{ (floor($Going_to_expiry_videos->duration / 3600) > 0 ? floor($Going_to_expiry_videos->duration / 3600) . 'h ' : '') . floor(($Going_to_expiry_videos->duration % 3600) / 60) . 'm' }}
                                                            </span>
                                                        @endif
                                                        @if($ThumbnailSetting->published_year == 1 && !($Going_to_expiry_videos->year == 0))
                                                            <span class="position-relative badge p-1 mr-2">
                                                                {{ __($Going_to_expiry_videos->year) }}
                                                            </span>
                                                        @endif

                                                        @if($ThumbnailSetting->featured == 1 && $Going_to_expiry_videos->featured == 1)
                                                            <span class="position-relative text-white">
                                                                {{ __('Featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="badge p-1 mr-2">
                                                        <span class="text-white">
                                                            {{ "Expiry In ". Carbon\Carbon::parse($Going_to_expiry_videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}
                                                        </span>
                                                    </div>

                                                    
                                                </a>
                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Watch Now') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endif


<script>
    var elem = document.querySelector('.going-to-expiry');
    if (elem) {
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: true,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: false,
            lazyload: true,
        });
    } else {
        console.error("Carousel element not found");
    }
 </script>