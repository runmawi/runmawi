@php
    $check_Kidmode = 0 ;

    $data =  App\Artist::limit(15)->get()->map(function($item) use($check_Kidmode,$videos_expiry_date_status,$getfeching,$default_vertical_image_url,$default_horizontal_image_url){

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

        $item['artist_depends_videos'] = $item['artist_depends_videos']->latest()->limit(15)->get()->map(function ($item) use ($default_horizontal_image_url,$default_vertical_image_url) {
                                        $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                        $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : $default_horizontal_image_url ;
                                        $item['source']           = 'series';
                                        return $item;
                                    });

        // Series 
        
        $Seriesartist = App\Seriesartist::where('artist_id',$item->id)->groupBy('series_id')->pluck('series_id'); 

        $item['artist_depends_series'] = App\Series::select('id','title','slug','access','active','ppv_status','featured','duration','image','embed_code',
                                    'mp4_url','webm_url','ogg_url','url','tv_image','player_image','details','description')
                                    ->where('active', '1')->whereIn('id',$Seriesartist)->latest()->limit(15)->get()
                                    ->map(function ($item) use ($default_horizontal_image_url,$default_vertical_image_url) {
                                        $item['image_url']        = $item->image != null ?  URL::to('public/uploads/images/'.$item->image) : $default_vertical_image_url ;
                                        $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) : $default_horizontal_image_url ;
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

            $item['artist_depends_audios'] = $item['artist_depends_audios']->limit(15)->latest()->get()->map(function ($item) use ($default_horizontal_image_url,$default_vertical_image_url) {
                            $item['image_url'] = $item->image != null ? URL::to('/public/uploads/audios/'.$item->image) : $default_vertical_image_url ;
                            $item['Player_image_url'] = $item->player_image != null ? URL::to('public/uploads/audios/'.$item->player_image) : $default_horizontal_image_url ; 
                            return $item;
                        });

        return $item;
    });

@endphp


@if(!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            <a href="{{ $order_settings_list[8]->header_name ? URL::to('/') . '/' . $order_settings_list[8]->url : '' }}">
                                {{ $order_settings_list[8]->header_name ? __($order_settings_list[8]->header_name) : '' }}
                            </a>
                        </h4>
                        @if($settings->homepage_views_all_button_status == 1)
                            <h5 class="main-title view-all">
                                <a>{{ __('View all') }}</a>
                            </h4>
                        @endif
                    </div>

                    <div class="favorites-contens">
                        <div class="artist-video home-sec list-inline row p-0 mb-0">
                            @if(isset($data))
                                @foreach($data as $artist_details)
                                    <div class="items">
                                        <div class="block-images position-relative">
                                            <div class="border-bg">
                                                <div class="img-box">
                                                    <a class="playTrailer" href="{{ URL::to('artist') . '/' . $artist_details->artist_slug }}" aria-label="ArtistPlayTrailer">
                                                        <img loading="lazy" data-src="{{ $artist_details->image ? URL::to('/public/uploads/artists/' . $artist_details->image) : $default_vertical_image_url }}" data-flickity-lazyload="{{ $artist_details->image ? URL::to('/public/uploads/artists/' . $artist_details->image) : $default_vertical_image_url }}" class="img-fluid loading w-100" alt="{{ $artist_details->artist_name }}">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <a class="playTrailer" href="{{ URL::to('artist') . '/' . $artist_details->artist_slug }}" aria-label="ArtistPlayTrailer">
                                                    <img loading="lazy" data-src="{{ $artist_details->player_image ? URL::to('/public/uploads/artists/' . $artist_details->player_image) : $default_vertical_image_url }}" data-flickity-lazyload="{{ $artist_details->player_image ? URL::to('/public/uploads/artists/' . $artist_details->player_image) : $default_vertical_image_url }}" class="img-fluid loading w-100" alt="{{ $artist_details->artist_name }}">
                                                </a>
                                                <div class="hover-buttons text-white">
                                                    @if($ThumbnailSetting->title == 1)
                                                        <a href="{{ URL::to('artist') . '/' . $artist_details->artist_slug }}">
                                                            <p class="epi-name text-left mt-2 m-0">
                                                                {{ strlen($artist_details->artist_name) > 17 ? substr($artist_details->artist_name, 0, 18) . '...' : $artist_details->artist_name }}
                                                            </p>
                                                        </a>
                                                    @endif  

                                                    <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('artist') . '/' . $artist_details->artist_slug }}">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Watch Now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif


<script>
    var elem = document.querySelector('.artist-video');
    var flkty = new Flickity(elem, {
        cellAlign: 'left',
        contain: true,
        groupCells: false,
        pageDots: false,
        draggable: true,
        freeScroll: true,
        imagesLoaded: true,
        lazyLoad: 7,
    });
 </script>