@php
    $data->map(function($item){
        $item['Series_depends_episodes'] = App\Series::find($item->id)->Series_depends_episodes
                                                    ->map(function ($item) {
                                                        $item['image_url']  = !is_null($item->image) ? URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                                        return $item;
                                                });

            return $item;
    });
@endphp


@if (!empty($data) && $data->isNotEmpty())
    @php
        $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
        $order_settings_list = App\OrderHomeSetting::get();
        $ThumbnailSetting = App\ThumbnailSetting::first();
    @endphp

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        @if (!preg_match('/^channel\/.+$/', request()->path()))
                            <h4 class="main-title">
                                <a href="{{ $order_settings_list[4]->header_name ? URL::to('/') . '/' . $order_settings_list[4]->url : '' }}">
                                    {{ $order_settings_list[4]->header_name ? __($order_settings_list[4]->header_name) : '' }}
                                </a>
                            </h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title view-all text-primary">
                                    <a href="{{ $order_settings_list[4]->header_name ? URL::to('/') . '/' . $order_settings_list[4]->url : '' }}">
                                        {{ __('View all') }}
                                    </a>
                                </h4>
                            @endif
                        @else
                            <h4 class="main-title fira-sans-condensed-regular"><a href="{{ URL::to('channel/Series_list/'.$channel_partner_slug) }}">{{ optional($order_settings_list[4])->header_name }}</a></h4>
                            @if($settings->homepage_views_all_button_status == 1)
                                <h4 class="main-title view-all fira-sans-condensed-regular text-primary"><a href="{{ URL::to('channel/Series_list/'.$channel_partner_slug) }}">{{ 'View all' }}</a></h4>
                            @endif
                        @endif
                    </div>
                    <div class="tvthrillers-contens">
                        <ul class="favorites-slider list-inline">
                            @foreach ($data as $latest_series)
                                <li class="slide-item">
                                    <a href="{{ URL::to('play_series/'.$latest_series->slug) }}">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="{{ $latest_series->image ? URL::to('public/uploads/images/' . $latest_series->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">

                                                <p>{{ strlen($latest_series->title) > 17 ? substr($latest_series->title, 0, 18) . '...' : $latest_series->title }}</p>

                                                <div class="movie-time d-flex align-items-center my-2">
                                                    <span class="text-white"> 
                                                        {{ App\SeriesSeason::where('series_id',$latest_series->id)->count() . " Seasons" }}  
                                                        {{ App\Episode::where('series_id',$latest_series->id)->count() . " Episodes" }}  
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        {{ __('Play Now')}}
                                                    </span>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
