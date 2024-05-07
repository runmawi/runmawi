@php

    $order_settings_list = App\OrderHomeSetting::get();  

    $check_Kidmode = 0 ;

    $data = App\Video::select('id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price',
                                        'duration','rating','image','featured','age_restrict','video_tv_image','player_image','details','description',
                                        'expiry_date','active','status','draft')

        ->where('active',1)->where('status', 1)->where('draft',1);

        if( videos_expiry_date_status() == 1 ){
            $data = $data->whereNotNull('expiry_date')->where('expiry_date', '>=', Carbon\Carbon::now()->format('Y-m-d\TH:i') );
        }

        if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
        {
            $data = $data->whereNotIn('videos.id',Block_videos());
        }

        if( !Auth::guest() && $check_Kidmode == 1 )
        {
            $data = $data->whereNull('age_restrict')->orwhereNotBetween('age_restrict',  [ 0, 12 ] );
        }

        $data = $data->latest()->limit(30)->get()->map(function ($item) {
            $item['image_url']          =  $item->image != null ?  URL::to('/public/uploads/images/'.$item->image) :  default_vertical_image_url() ;
            $item['Player_image_url']   =  $item->player_image != null ?  URL::to('public/uploads/images/'.$item->player_image) :  default_horizontal_image_url() ;
            $item['TV_image_url']       =  $item->video_tv_image != null ?  URL::to('public/uploads/images/'.$item->video_tv_image) :  default_horizontal_image_url() ;
            $item['source_type']        = "Videos" ;
            return $item;
        });

@endphp


@if (!empty($data) && $data->isNotEmpty())


    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[32]->url ? URL::to($order_settings_list[32]->url) : null }} ">{{ optional($order_settings_list[32])->header_name }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $Going_to_expiry_videos)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        
                                        <a href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $Going_to_expiry_videos->image ?  URL::to('public/uploads/images/'.$Going_to_expiry_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                <span style="background: {{ button_bg_color() . '!important' }}; text-align: center; font-size: inherit; position: absolute; width:100%; bottom: 0;" class="p-tag">{{ "Expiry In ". Carbon\Carbon::parse($Going_to_expiry_videos->expiry_date)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</span>
                                            </div>

                                            <div class="block-description">
                                                

                                                <div class="hover-buttons">
                                                    <a class="" href="{{ URL::to('category/videos/'.$Going_to_expiry_videos->slug ) }}">
                                                        <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                            <span class="text pr-2"> Play </span>
                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </a>

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