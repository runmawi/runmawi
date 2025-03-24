@php include public_path('themes/theme5-nemisha/views/header.php');  @endphp

@php
    $isSubscribed = auth()->check() ? auth()->user()->subscribers->contains($profileUser->id) : false;
@endphp

    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- video-js Style --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="{{ asset('public/themes/theme5-nemisha/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme5-nemisha/assets/css/video-js/ugc-videos-player.css') }}" rel="stylesheet" >

    {{-- video-js Script --}}
    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') }}"></script>

<style>
   .ugc-videos img{
        width: 100%;
        height: 180px;
        border-radius: 15px;
    }

    .ugc-tabs {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        overflow-y: auto;
        padding-top: 10px;
    }

    .description-text {
    max-height: 100px;
    overflow: hidden;
    }

    .desc {
    overflow: hidden;
    max-height: 100px; /* Initial max height, adjust as needed */
    transition: max-height 0.5s ease;
    }

    .ugc-playlist {
        display: inline-block;
        padding: 5px 30px;
        margin: 0 5px;
        background-color: #ed1c24 ;
        color: #fff;
        font-weight: bold;
        border-radius: 8px;
        white-space: nowrap;
        cursor: pointer;
    }

    .ugc-playlist.ring {
        border: 2px solid #848880;
    }

    .read-button{
        cursor: pointer;
        color: #fff;
        font-weight: 500;
        font-size: 15px;
    }

    i#dislike {
        padding: 10px !important;
    }
    i#like {
        padding: 10px;
    }
    .share-box{
        width: 100px;
    }

    .ugc-subscriber{
        margin: 5px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        background: #ed1c24!important;
        color: #fff!important;
        padding: 5px 100px!important;
        margin:0%; 
        cursor:pointer;"
    }

    .ugc-description {
            width: auto;
            max-width: auto;
            border-radius: 10px;
            background-color: #848880;
            color: white;
            padding: 15px;
            border: none;
            resize: none;
            font-size: 16px;
        }

    .ugc-commentsection textarea {
            background-color: #848880;
            color: white;
            border-radius: 10px;
            width: 100%;
            padding: 15px;
            border: none;
            resize: none;
            font-size: 16px;
            margin: 10px;
        }

        .my-video.vjs-fluid {
        padding-top: 0px !important;
        height: 70vh !important;
    }

    .vjs-control-bar{
        border-radius: 20px;
    }

    .related-video-item{
        background: #848880;
		color: #fff;
        border-radius: 7px;
        padding: 7px;
        margin: 7px;
    }

    .trending-video-item{
        background: #848880;
		color: #fff;
        border-radius: 7px;
        padding: 7px;
        margin: 7px;
    }

    .music-play-lists li:hover span{
        background-color: transparent !important;
    }

    @media only screen and (max-width: 600px) {
    .my-video.vjs-fluid {
        padding-top: 0 !important;
        height: 45vh !important;
    }
    }

    #my-video_ima-ad-container div{ overflow:hidden;}
    #my-video{ position:relative; }
    /* .staticback-btn{display:none;} */
    .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; font-size:25px; }
    .custom-skip-backward-button .custom-skip-forward-button{font-size: 45px;color: white;}
    
</style>

<div class="row">
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8  ">
        <div class="mx-3 my-2"> 
        <div>
            <div class="container-fluid p-0" style="position:relative; " >
                @if ( $videodetail->users_video_visibility_status)
        
                    @if ( $videodetail->type == "embed" )
        
                        <iframe class="responsive-iframe" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    @else
        
                        <button class="staticback-btn" onclick="history.back()" title="Back Button">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </button>
        
                        <div style="padding-bottom: 10px;" >
                        <button class="custom-skip-forward-button">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                        </button>  
                     
                        <button class="custom-skip-backward-button">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                        </button>  
                        </div>
                        <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls 
                            poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                            autoplay style="border-radius: 20px;" >
                            <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">

                            {{-- Subtitle --}}
                            {{-- @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1 && isset($subtitles) && count($subtitles) > 0) --}}
                                @foreach($subtitles as $subtitles_file)
                                <track kind="subtitles" src="{{ $subtitles_file->url }}" srclang="{{ $subtitles_file->sub_language }}"
                                    label="{{ $subtitles_file->shortcode }}" @if($loop->first) default @endif >
                                @endforeach
                            {{-- @endif --}}


                        </video>
                    @endif
                @endif
            </div>

        </div>
        <div class="py-2" style="font-size: 30px; font-weight:bold;" >
            <p class="ugc-text" >{{$videodetail->title}}</p>
        </div>
        <div class="d-flex flex-column flex-lg-row justify-content-between" >
            <div class="d-flex align-items-center">
                <ul class="list-inline p-0 share-icons music-play-lists d-flex justify-content-end" style="align-items: self-end;">
                    <li style="display: inline-flex; margin-right: 5px; width: 45px; height: 45px;">
                        <span data-toggle="modal"  data-video-id={{ $videodetail->id }}   onclick="video_watchlater(this)" >
                            <i class="video-watchlater {{ !is_null($videodetail->watchlater_exist) ? "fal fa-minus" : "fal fa-plus "  }}"></i>
                        </span>
                        <div class="share-box box-watchtrailer " onclick="video_watchlater(this)" style="top:41px">
                            <div   data-toggle="modal">  
                                <span class="text" style="background-color: transparent; font-size: 12px; width:100%;">{{ __('Add To Watchlist') }}</span>
                            </div>
                        </div>
                    </li>
                     <!-- Wishlist  -->
                    <li style="display: inline-flex; margin-right: 5px; width: 45px; height: 45px;">
                        <span class="mywishlist " data-video-id={{ $videodetail->id }} onclick="video_wishlist(this)" >
                            <i class="video-wishlist {{ !is_null( $videodetail->wishlist_exist ) ? 'ri-heart-fill' : 'ri-heart-line'  }}"></i>
                        </span>
                        <div class="share-box box-watchtrailer " onclick="video_wishlist(this)" style="top:41px">
                            <div   data-toggle="modal">  
                                <span class="text" style="background-color: transparent; font-size: 12px; width:100%;">{{ __('Add To Wishlist') }}</span>
                            </div>
                        </div>
                    </li>

                    @php include public_path('themes/theme5-nemisha/views/UserGeneratedContent/social-share.php'); @endphp 
    
                    <li style="display: inline-flex; margin-right: 5px; width: 45px; height: 45px;">
                    <span data-video-id={{ $videodetail->id }}  onclick="video_like(this)" >
                        <i class="video-like {{ !is_null( $videodetail->Like_exist ) ? 'ri-thumb-up-fill' : 'ri-thumb-up-line'  }}"></i>
                    </span>
                    </li>
                    <li style="display: inline-flex; margin-right: 5px; width: 45px; height: 45px;">
                    <span data-video-id={{ $videodetail->id }}  onclick="video_dislike(this)" >
                        <i class="video-dislike {{ !is_null( $videodetail->dislike_exist ) ? 'ri-thumb-down-fill' : 'ri-thumb-down-line'  }}"></i>
                    </span>
                    </li>
                    <li style="display: inline-flex; margin-right: 5px; width: 45px; height: 45px;">
                    <span><a href="#" onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a></span>
                    </li>
                    <input type="hidden" value="181" id="videoid">    <input type="hidden" value="1" id="user_id">                                   
                 </ul>
            </div>

            <div class="d-flex align-items-center text-white">
                <div class="p-1" style="border-radius: 7px; line-height: 25px;  background-color: #848880;" >
                    {{ $videodetail->views . " views" }} | {{ $videodetail->like_count }} Liked | {{ $videodetail->dislike_count }} Disliked | {{ $videodetail->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-start mx-3">
        <div >
            <a  href="{{ route('profile.show', ['username' => $videodetail->user->username]) }}" class="m-1">
        <img class="rounded-circle img-fluid text-center mb-3 mt-4"
        src="<?= $videodetail->user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $videodetail->user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="{{$videodetail->user->username}}" style="height: 80px; width: 80px;">
            </a>
        </div>
       <div class="col" style="padding-top: 40px;" >
        <a  href="{{ route('profile.show', ['username' => $videodetail->user->username]) }}" >
        <div>
        <h6>{{$videodetail->user->username}}</h6>
        </div>
        @if(auth()->check())
            @if(auth()->user()->id != $profileUser->id)
                <div class="py-2" >
                    @if($subscriber_count == 0 )
                    <p style="color: white; font-size:18px;" >No Subscribers</p>
                    @elseif($subscriber_count == 1 )
                    <p style="color: white; font-size:18px;" >1 Member Subscribed</p>
                    @else
                    <p style="color: white; font-size:18px;" >
                        <span id="subscriber-count"> {{ $subscriber_count }} </span> Members Subscribed
                    </p>
                    @endif
                </div>
            @endif
        @endif
        </a>
       </div>
    </div>
  
    @if(auth()->check())
        @if(auth()->user()->id != $profileUser->id)
            <div class="mx-3">
                <button 
                    id="subscribe-toggle" 
                    data-user-id="{{ $profileUser->id }}" 
                    data-subscriber-id="{{ auth()->user()->id }}" 
                    class="ugc-subscriber" style="border: none;"
                    aria-pressed="{{ $subscribe_button ? 'true' : 'false' }}" 
                    onclick="toggleSubscription(this)">
                    {{ $subscribe_button ? 'Unsubscribe' : 'Subscribe' }}
                </button>
            </div>
        @endif
    @endif

    @if($videodetail->description)
    <div class="ugc-description m-3"  style="overflow-y: scroll; max-height: 180px; scrollbar-width: none; color:#fff !important;">

        <p class="desc" id="description" class="description-text ugc-text">
            {!! html_entity_decode($videodetail->description) !!} 
        </p>

        @if(strlen($videodetail->description) > 300)
            <span class="des-more-less-btns p-0 read-button ugc-text" id="read-more-btn" onclick="toggleReadMore()">{{ __('...SHOW MORE') }}</span>
            <span class="des-more-less-btns p-0 read-button ugc-text" id="read-less-btn" onclick="toggleReadMore()" style="display: none;">{{ __('SHOW LESS') }}</span>
        @endif

    </div>
    @endif

    @if(auth()->check())
     <div class="mx-3">
        <div class="sectionArtists">   
                <div >
                    @php include public_path('themes/theme5-nemisha/views/ugc-comments/index.blade.php') @endphp
                </div>
        </div>
    </div>
    @endif


    </div>
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
             <div class="ugc-tabs">
                @if($newvideo)
                 <div class="ugc-playlist"><a href="{{ url('ugc/video-player/' . $newvideo->slug) }}" >New</a></div>
                @endif
                @if($relatedVideos->isNotEmpty())
                 <div  id="related-btn" class="ugc-playlist">Related</div>
                @endif
                <div id="trending-btn" class="ugc-playlist">Trending</div>
                 <div class="ugc-playlist"> <a href=" {{url('mywishlists')}} " >Your Wishlist </a></div>  

             </div>     
             <div id="related-videos" style="display: none;">
                @foreach($relatedVideos as $video)
                <a href="{{ url('ugc/video-player/' . $video->slug) }}">
                    <div class="related-video-item" >
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                  </svg>
                                <h6 class="px-1" > {{ $video->title }}</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                {{ $video->views ?  $video->views : '0' }}  Views
                            </div>
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
          
            <div id="trending-videos" style="display: none;">
                @foreach($trendingVideos as $video)
                <a href="{{ url('ugc/video-player/' . $video->slug) }}">
                    <div class="trending-video-item" >
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                                </svg>
                                <h6 class="px-2" > {{ $video->title }}</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                {{ $video->views ?  $video->views : '0' }}  Views
                            </div>
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>

           
      <div class="mx-3">
         @foreach ($ugcvideos as $eachugcvideos)
         <div class="px-3" class="video-item" data-user-id="{{ $eachugcvideos->user->id }}"  >
              <a  href="{{ url('ugc/video-player/' . $eachugcvideos->slug) }}" class="m-1">
                         <div class="ugc-videos">
                             <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
                         </div>
                         <div class="text-white pt-3 ugc-text">
                             <h6>{{$eachugcvideos->title}}</h6>
                             <p style="margin:5px 0px;">{{$eachugcvideos->user->username}}</p>
                             <p>        
                                {{ $eachugcvideos->created_at->diffForHumans() }} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} Views | {{$eachugcvideos->like_count}} likes
                            </p>
                         </div>
             </a>
         </div>
         @endforeach
      </div>
   </div>
</div>


@php
include public_path('themes/theme5-nemisha/views/footer.blade.php');
@endphp

<script>
    let video_url = "<?php echo $videodetail->videos_url; ?>";
    const skipForwardButton = document.querySelector('.custom-skip-forward-button');
    const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
    var remainingDuration = false;

    document.addEventListener("DOMContentLoaded", function() {

        var player = videojs('my-video', { // Video Js Player 
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,
            controlBar: {
                volumePanel: { inline: false },
                children: {
                    'playToggle': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'subtitlesButton': {},
                    'fullscreenToggle': {},
                    'playbackRateMenuButton': {},
                },
                pictureInPictureToggle: true,
            },
        }); 

        // Hls Quality Selector - M3U8 
        player.hlsQualitySelector({ 
            displayCurrentQuality: true,
        });

        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const backButton = document.querySelector('.staticback-btn');
        var hovered = false;
        skipForwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() + 10);
        });

        skipBackwardButton.addEventListener('click', function() {
            player.currentTime(player.currentTime() - 10);
        });

        player.on('userinactive', () => {

            skipForwardButton.addEventListener('mouseenter',handleHover);
            skipBackwardButton.addEventListener('mouseenter',handleHover);
            
            skipForwardButton.addEventListener('mouseleave',handleHover);
            skipBackwardButton.addEventListener('mouseleave',handleHover);

            function handleHover(event) {
                const element = event.target;
                if (event.type === 'mouseenter') {
                    hovered = true;
                    skipButton = true;
                } else if (event.type === 'mouseleave') {
                    hovered = false;
                    skipButton = false;
                }
            }

            // Hide the Play pause, skip forward and backward buttons when the user becomes inactive
            if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
                if(hovered == false && remainingDuration == false){
                    skipForwardButton.style.display = 'none';
                    skipBackwardButton.style.display = 'none';
                    playPauseButton.style.display = 'none';
                }
                backButton.style.display = 'none';
            }
        });

        player.on('useractive', () => {
        // Show the Play pause, skip forward and backward buttons when the user becomes active
            if (skipForwardButton && skipBackwardButton && playPauseButton && backButton) {
                if(player.currentTime != player.duration){
                    skipForwardButton.style.display = 'block';
                    skipBackwardButton.style.display = 'block';
                    playPauseButton.style.display = 'block';
                    backButton.style.display = 'block';
                }
            }
        });

    });
</script>



<script>
    function Copy() {
    var media_path = $('#media_url').val();
    var url =  navigator.clipboard.writeText(window.location.href);
    var path =  navigator.clipboard.writeText(media_path);
    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
           setTimeout(function() {
            $('.add_watch').slideUp('fast');
           }, 3000);
    }
</script>  

<script>
    function toggleReadMore() {
    const description = document.getElementById('description');
    const readMoreBtn = document.getElementById('read-more-btn');
    const readLessBtn = document.getElementById('read-less-btn');

    if (readMoreBtn.style.display === 'none') {
        readMoreBtn.style.display = 'inline';
        readLessBtn.style.display = 'none';
        description.style.maxHeight = '100px';
        if (window.innerWidth <= 500) {
            description.style.maxHeight = '65px';
        }
    } else {
        readMoreBtn.style.display = 'none';
        readLessBtn.style.display = 'inline';
        description.style.maxHeight = 'none';
    }
}

</script>

<script>
    // Read CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Debounce timeout variable
    let debounceTimeout;

    function toggleSubscription(ele) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(function() {
            let userId = $(ele).data('user-id');
            let subscriberId = $(ele).data('subscriber-id');
            let isSubscribed = $(ele).hasClass('btn-active');
            
            let url = isSubscribed ? '{{ route('unsubscribe') }}' : '{{ route('subscribe') }}';

            $.ajax({
                url: url,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    user_id: userId,
                    subscriber_id: subscriberId
                },
                success: function(response) {
                    if (response.success) {
                        const messageClass = isSubscribed ? 'alert-danger' : 'alert-success';
                        const message = isSubscribed ? 'Unsubscribed successfully!' : 'Subscribed successfully!';
                        
                        const messageNote = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${message}</div>`;
                        
                        $('#subscriber-count').text(response.count);
                        $('#message-note').html(messageNote).slideDown('fast');
                        
                        setTimeout(function() {
                            $('#message-note').slideUp('fast');
                        }, 2000);

                        // Toggle button state
                        if (isSubscribed) {
                            $(ele).removeClass('btn-active').addClass('btn-inactive').text('Subscribe');
                            $(ele).attr('aria-pressed', 'false');
                        } else {
                            $(ele).removeClass('btn-inactive').addClass('btn-active').text('Unsubscribe');
                            $(ele).attr('aria-pressed', 'true');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    const errorMessage = 'An error occurred. Please try again.';
                    const messageNote = `<div id="message-note" class="alert alert-danger col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${errorMessage}</div>`;
                    $('#message-note').html(messageNote).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            });
        }, 300); 
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
       
        var relatedBtn = document.getElementById('related-btn');
        var trendingBtn = document.getElementById('trending-btn');
        var relatedVideos = document.getElementById('related-videos');
        var trendingVideos = document.getElementById('trending-videos');

        if (relatedBtn) {
            relatedBtn.addEventListener('click', function() {
                if (relatedVideos.style.display === 'block') {
                    relatedVideos.style.display = 'none';
                    relatedBtn.classList.remove('ring');
                } else {
                    relatedVideos.style.display = 'block';
                    trendingVideos.style.display = 'none';
                    relatedBtn.classList.add('ring');
                    trendingBtn.classList.remove('ring');
                }
            });
        }

        if (trendingBtn) {
            trendingBtn.addEventListener('click', function() {
                if (trendingVideos.style.display === 'block') {
                    trendingVideos.style.display = 'none';
                    trendingBtn.classList.remove('ring');
                } else {
                    trendingVideos.style.display = 'block';
                    relatedVideos.style.display = 'none';
                    trendingBtn.classList.add('ring');
                    relatedBtn.classList.remove('ring');
                }
            });
        }
    });
</script>

@php
 include public_path('themes/theme5-nemisha/views/UserGeneratedContent/videos-details-script-file.blade.php');
@endphp