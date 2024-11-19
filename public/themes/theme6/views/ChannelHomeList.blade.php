<?php include public_path("themes/{$current_theme}/views/header.php"); ?>

<style>
    .flickity-slider .items{width:14.444%;padding:10px 5px}
    .home-sec{padding:10px 0 1% 1%;list-style:none;margin:0;position:relative;z-index:12;display:block}
    .flickity-button{background:#fff0;color:#fff}
    .flickity-button:disabled{opacity:0}
    .fa-crown:before{content:"\f521"}
    .flickity-slider .items:before{content:'';display:block;position:absolute;background-color:#555;background-image:url(https://watch.e360tv.com/img/placeholder.jpg);background-size:cover;background-position:center;top:2px;bottom:2px;left:2px;right:2px;z-index:0;margin:10px 5px}
    .flickity-button:hover{background:transparent!important}
    .flickity-slider .items:hover .block-images{z-index:99;transform:scale3d(1.1,1.1,1.1) translate3d(0,0,0) perspective(500px);transform-origin:50% 50%;transition:all .6s ease 0;-webkit-transition:all .6s ease 0;-moz-transition:all .6s ease 0;-o-transition:all .6s ease 0;box-shadow:0 0 12px rgb(0 0 0 / .9);border-radius:10px}
    .flickity-slider .items:hover .block-description{animation:fadeIn .6s ease-in-out;opacity:1}
    .flickity-slider .block-description .playTrailer{height:0}
    .block-description p.desc-name{font-size:12px;-webkit-line-clamp:3;line-height:1.4}
    .movie-time span.position-relative:before{content:"";width:5px;height:5px;top:5px;background-color:#fff;border-radius:50%;display:inline-block;vertical-align:baseline;right:-10px;margin-bottom:2px}
    /* flickity.css */
    .flickity-enabled{position:relative}
    .flickity-enabled:focus{outline:none}
    .flickity-viewport{overflow:hidden;position:relative;height:100%}
    .flickity-slider{position:absolute;width:100%;height:100%}
    .flickity-enabled.is-draggable{-webkit-tap-highlight-color:transparent;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
    .flickity-enabled.is-draggable .flickity-viewport{cursor:move;cursor:-webkit-grab;cursor:grab}
    .flickity-enabled.is-draggable .flickity-viewport.is-pointer-down{cursor:-webkit-grabbing;cursor:grabbing}
    .flickity-button{position:absolute;background:hsla(0, 0%, 100%, 0);border:none;color:#333}
    .flickity-button:hover{background:#fff;cursor:pointer}
    .flickity-button:focus{outline:none;box-shadow:0 0 0 5px #19F}
    .flickity-button:active{opacity:.6}
    .flickity-button:disabled{opacity:.3;cursor:auto;pointer-events:none}
    .flickity-button-icon{fill:rgb(255 255 255)}
    .flickity-prev-next-button{top:50%;width:44px;height:44px;border-radius:50%;transform:translateY(-50%)}
    .flickity-prev-next-button.previous{left:10px}.flickity-prev-next-button.next{right:10px}.flickity-rtl .flickity-prev-next-button.previous{left:auto;right:10px}
    .flickity-rtl .flickity-prev-next-button.next{right:auto;left:10px}.flickity-prev-next-button .flickity-button-icon{position:absolute;left:20%;top:0%;width:60%;height:60%}.flickity-page-dots{position:absolute;width:100%;bottom:-25px;padding:0;margin:0;list-style:none;text-align:center;line-height:1}
    .flickity-rtl .flickity-page-dots{direction:rtl}.flickity-page-dots .dot{display:inline-block;width:10px;height:10px;margin:0 8px;background:#333;border-radius:50%;opacity:.25;cursor:pointer}.flickity-page-dots .dot.is-selected{opacity:1}
</style>

<link rel="shortcut icon" href="{{ URL::to('public/uploads/settings/' . $settings->favicon) }}" />
<link rel="stylesheet" href="<?= URL::to('/') . 'assets/css/variable-boots-flick.css' ?>">
<script defer src="<?= URL::to('/assets/js/flick-popper-magnific.js') ;?>"></script>
<script src="<?= URL::to('/assets/js/flick-popper-magnific.js') ;?>"></script>

<section id="iq-favorites">

    @if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error('{{ session('error') }}', 'Error Message');
            });
        </script>
    @endif

    <div class="container">
        <div class="row">

            {{-- All Channels --}}
            
            <div class="col-sm-12 overflow-hidden">
                <div class="d-flex mt-5 mb-2 justify-content-between">
                    <div class="channel_heading">
                        <h4>{{ "Channels" }}</h4>
                    </div>
                </div>
                
                <div class="favorites-contens"> 
                    <div class="channel-videos home-sec list-inline row p-0 mb-0">
                        
                        @foreach ($all_channels as $media)

                            @php
                                $UserChannelSubscription = null ;

                                if (!Auth::guest()) {
                                    $UserChannelSubscription = App\UserChannelSubscription::where('user_id',auth()->user()->id)
                                                                    ->where('channel_id',$media->id)->where('status','active')
                                                                    ->where('subscription_start', '<=', Carbon\Carbon::now())
                                                                    ->where('subscription_ends_at', '>=', Carbon\Carbon::now())
                                                                    ->latest()->first();
                                                                    
                                }
                            @endphp

                            <div class="items">
                                <div class="block-images position-relative">

                                        @if ($settings->user_channel_plans_page_status == 1)
                                            @if (!Auth::guest() && Auth::user()->role != "admin")
                                                <a href="{{ is_null($UserChannelSubscription) ? route('channel.payment', $media->channel_slug) : route('ChannelHome', $media->channel_slug) }}" style="color:white;font-weight:600">
                                            @else
                                                <a href="{{ route('login') }}" style="color:white;font-weight:600">
                                            @endif
                                        @else
                                            <a href="{{ route('ChannelHome', $media->channel_slug) }}" style="color:white;font-weight:600">
                                        @endif


                                        <div class="img-box">
                                            <img src="{{ $media->channel_image ?  URL::to('public/uploads/images/'.$media->channel_image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                        </div>

                                        <div class="block-description" style="background: #8080803d;">
                                            <span> {{ strlen($media->channel_name) > 17 ? substr($media->channel_name, 0, 18) . '...' : $media->channel_name }}</span>
                                            
                                            <div class="hover-buttons">
                                                <span class="btn btn-hover">
                                                    @if ($settings->user_channel_plans_page_status == 1)
                                                        @if (!Auth::guest() && Auth::user()->role != "admin")
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                            {{ is_null($UserChannelSubscription) ? "subscribe" : "Play Now" }}
                                                        @else
                                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Login') }}
                                                        @endif
                                                    @else
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>{{ __('Play Now') }}
                                                    @endif
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </a>            
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @foreach ($channel_data as $channels)
                @if($channels->all_data->isNotEmpty())
                    <div class="col-sm-12 overflow-hidden">
                        <div class="d-flex mt-5 mb-2 justify-content-between">
                            <div class="channel_heading">
                                <h4>{{ $channels->channel_name }}</h4>
                            </div>

                            @php
                                $UserChannelSubscription = null ;

                                if (!Auth::guest()) {
                                    $UserChannelSubscription = App\UserChannelSubscription::where('user_id',auth()->user()->id)
                                                                    ->where('channel_id',$channels->id)->where('status','active')
                                                                    ->where('subscription_start', '<=', Carbon\Carbon::now())
                                                                    ->where('subscription_ends_at', '>=', Carbon\Carbon::now())
                                                                    ->latest()->first();
                                                                    
                                }
                            @endphp

                            @if ( $settings->user_channel_plans_page_status == 1 )

                                @if ( !Auth::guest() && Auth::user()->role != "admin" && is_null($UserChannelSubscription) )
                                    <div class="subscribe">
                                        <a class="btn btn-primary" href="{{ route('channel.payment',$channels->id)  }}"><span> {{ "Subscribe" }} </span></a>
                                    </div>
                                @elseif(Auth::guest())
                                    <div class="subscribe">
                                        <a class="btn btn-primary" href="{{ route('login')  }}"><span> {{ "Subscribe" }} </span></a>
                                    </div>
                                @endif
                            @endif
                        </div>
                        
                        <div class="favorites-contens"> 
                            <div class="channel-videos home-sec list-inline row p-0 mb-0">
                                
                                @foreach ($channels->all_data as $media)
                                    @if ($media instanceof App\Video)
                                    
                                        <div class="items">
                                            <div class="block-images position-relative">
                                                
                                                <a href="{{ URL::to('category/videos/'.$media->slug ) }}" style="color:white;font-weight:600">
        
                                                    <div class="img-box">
                                                        <img src="{{ $media->image ?  URL::to('public/uploads/images/'.$media->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                    </div>
        
                                                    <div class="block-description" style="background: #8080803d;">
                                                        <span> {{ strlen($media->title) > 17 ? substr($media->title, 0, 18) . '...' : $media->title }}
                                                        </span>
                                                        <div class="movie-time d-flex align-items-center my-2" style="font-weight: 600">
        
                                                            <span class="text-white">
                                                                @if($media->duration != null)
                                                                    @php
                                                                        $duration = Carbon\CarbonInterval::seconds($media->duration)->cascade();
                                                                        $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                                        $minutes = $duration->format('%imin');
                                                                    @endphp
                                                                    {{ $hours }}{{ $minutes }}
                                                                @endif
                                                            </span>
                                                        </div>
        
                                                        <div class="hover-buttons">
                                                            <span class="btn btn-hover">
                                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                {{ __('Play Now')}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </a>            
                                            </div>
                                        </div>

                                    @elseif ($media instanceof App\LiveStream)
                                        <div class="items">
                                            <div class="block-images position-relative">
                                                <a href="{{ URL::to('live/'.$media->slug ) }}" style="color:white;font-weight:600">
        
                                                    <div class="img-box">
                                                        <img src="{{ $media->image ? URL::to('public/uploads/images/'.$media->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                    </div>
        
                                                    <div class="block-description" style="background: #8080803d;">
                                                        <p> {{ strlen($media->title) > 17 ? substr($media->title, 0, 18) . '...' : $media->title }}</p>
                                                        
                                                        <div class="movie-time d-flex align-items-center my-2" style="font-weight: 600">
        
                                                            <span class="text-white">
                                                                @if($media->duration != null)
                                                                    @php
                                                                        $duration = Carbon\CarbonInterval::seconds($media->duration)->cascade();
                                                                        $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                                        $minutes = $duration->format('%imin');
                                                                    @endphp
                                                                    {{ $hours }}{{ $minutes }}
                                                                @endif
                                                            </span>
                                                        </div>
        
                                                        <div class="hover-buttons">
                                                            <span class="btn btn-hover">
                                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                {{ __('Play Now')}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                    @elseif ($media instanceof App\Episode)
                                        <div class="items">
                                            <a href="{{ URL::to('episode/'. $media->series_title->slug.'/'.$media->slug ) }}" style="color:white;font-weight:600">
                                                <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <img src="{{ $media->image ? URL::to('public/uploads/images/'.$media->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="block-description" style="background: #8080803d;">
                                                        <p> {{ strlen($media->title) > 17 ? substr($media->title, 0, 18) . '...' : $media->title }}
                                                        </p>
                                                        <div class="movie-time d-flex align-items-center my-2" style="font-weight: 600">
        
                                                            <span class="text-white">
                                                                @if($media->duration != null)
                                                                    @php
                                                                        $duration = Carbon\CarbonInterval::seconds($media->duration)->cascade();
                                                                        $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                                        $minutes = $duration->format('%imin');
                                                                    @endphp
                                                                    {{ $hours }}{{ $minutes }}
                                                                @endif
                                                            </span>
                                                        </div>
        
                                                        <div class="hover-buttons">
                                                            <span class="btn btn-hover">
                                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                {{ __('Play Now')}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" defer></script>

<script>
    var elem = document.querySelector('.channel-videos');
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

@php include(public_path("themes/{$current_theme}/views/footer.blade.php"));@endphp