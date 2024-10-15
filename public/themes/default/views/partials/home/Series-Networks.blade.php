@php
    $data = App\SeriesNetwork::where('in_home',1)->orderBy('order')->limit(15)->get()->map(function ($item) use ($default_vertical_image_url , $default_horizontal_image_url) {
                $item['image_url'] = $item->image != null ? URL::to('public/uploads/seriesNetwork/'.$item->image ) : $default_vertical_image_url ;
                $item['banner_image_url'] = $item->banner_image != null ?  URL::to('public/uploads/seriesNetwork/'.$item->banner_image ) : $default_horizontal_image_url;

                $item['series'] = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                                                                                                    'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description','network_id')
                                                                                                    ->where('active', '1')->whereJsonContains('network_id',["$item->id"])
                                                                                                    ->latest()->limit(15)->get()->map(function ($item) {
                                                                                                            $item['image_url'] = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                                                                                            $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : $default_horizontal_image_url ;
                                                                                                            $item['TV_image_url'] = $item->tv_image != null ?  URL::to('public/uploads/images/'.$item->tv_image) : @$default_horizontal_image_url ;       
                                                                                                            $item['season_count'] =  App\SeriesSeason::where('series_id',$item->id)->count();
                                                                                                            $item['episode_count'] =  App\Episode::where('series_id',$item->id)->count();
                                                                                                            return $item;
                                                                                                        });  

                return $item;
            });

@endphp

@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ optional($order_settings_list[30])->header_name }}</a></h4>
                        <h4 class="main-title view-all"><a href="{{ $order_settings_list[30]->url ? URL::to($order_settings_list[30]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <div class="series-networks home-sec list-inline row p-0 mb-0">
                            @foreach($data as $key => $series_networks)
                                <div class="items">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ route('Specific_Series_Networks',$series_networks->slug) }}">
                                                    <img class="img-fluid w-100" loading="lazy" data-src="{{ $series_networks->image_url ? $series_networks->image_url : $default_vertical_image_url }}" src="{{ $series_networks->image_url ? $series_networks->image_url : $default_vertical_image_url }}" alt="{{ $series_networks->name }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <a class="playTrailer" href="{{ route('Specific_Series_Networks',$series_networks->slug) }}">
                                                {{-- <img class="img-fluid w-100" loading="lazy" data-src="{{ $series_networks->banner_image_url ? $series_networks->banner_image_url : $default_vertical_image_url }}" src="{{ $series_networks->banner_image_url ? $series_networks->banner_image_url : $default_vertical_image_url }}" alt="{{ $series_networks->name }}"> --}}
                                            </a>
                                            <div class="hover-buttons text-white">
                                                <a href="{{ route('Specific_Series_Networks',$series_networks->slug) }}">
                                                    <p class="epi-name text-left m-0">{{ __($series_networks->name) }}</p>
                                                    <div class="movie-time d-flex align-items-center my-2"></div>
                                                </a>

                                                @if($ThumbnailSetting->enable_description == 1)
                                                    <p class="desc-name text-left m-0 mt-1">
                                                        {{ strlen($series_networks->description) > 75 ? substr(html_entity_decode(strip_tags($series_networks->description)), 0, 75) . '...' : strip_tags($series_networks->description) }}
                                                    </p>
                                                @endif

                                                <a class="epi-name mt-2 mb-0 btn" href="{{ route('Specific_Series_Networks',$series_networks->slug) }}">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    {{ __('Play Now')}}
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
    var elem = document.querySelector('.series-networks');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: true,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyload: true,
    });
 </script>