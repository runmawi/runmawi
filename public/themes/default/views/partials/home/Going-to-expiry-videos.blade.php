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
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach($data as $Going_to_expiry_videos) 
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $Going_to_expiry_videos->image_url ?  $Going_to_expiry_videos->image_url : $default_vertical_image_url }}" alt="{{ $Going_to_expiry_videos->title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                <img class="img-fluid w-100" loading="lazy" data-src="{{ $Going_to_expiry_videos->Player_image_url ? $Going_to_expiry_videos->Player_image_url : $default_vertical_image_url }}" alt="{{ $Going_to_expiry_videos->title }}">
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <p class="epi-name text-left m-0">{{ strlen($Going_to_expiry_videos->title) > 17 ? substr($Going_to_expiry_videos->title, 0, 18) . '...' : $Going_to_expiry_videos->title }}</p>
                                                    @endif

                                                    <div class="movie-time d-flex align-items-center pt-1">
                                                        @if($ThumbnailSetting->age == 1)
                                                            <div class="badge badge-secondary p-1 mr-2">{{ $Going_to_expiry_videos->age_restrict . ' +' }}</div>
                                                        @endif

                                                        @if($ThumbnailSetting->duration == 1)
                                                            <span class="text-white">
                                                                <i class="fa fa-clock-o"></i>
                                                                {{ gmdate('H:i:s', $Going_to_expiry_videos->duration) }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if($ThumbnailSetting->published_year == 1 || $ThumbnailSetting->rating == 1)
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->rating == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                        {{ __($Going_to_expiry_videos->rating) }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                             
                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                <span class="text-white">
                                                                    {{ "Expiry In ". Carbon\Carbon::parse($Going_to_expiry_videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}
                                                                </span>
                                                            </div>

                                                            @if($ThumbnailSetting->featured == 1 && $Going_to_expiry_videos->featured == 1)
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                    <span class="text-white">
                                                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </a>
                                                <a class="epi-name mt-1 mb-0 btn" href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug) }}">
                                                    <img class="d-inline-block ply" alt="ply" src="{{ url('assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />{{ __('Play Now') }}
                                                </a>
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