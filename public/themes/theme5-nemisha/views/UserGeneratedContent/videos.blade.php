@php include public_path('themes/theme5-nemisha/views/header.php');  @endphp

    {{-- video-js Style --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <!-- <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" /> -->
    <link href="{{ asset('public/themes/theme5-nemisha/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme5-nemisha/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme5-nemisha/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


    {{-- video-js Script --}}
    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/@videojs/plugin-concat/dist/videojs-plugin-concat.min.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<style>
   .ugc-videos img{
        width: 100%;
        height: 200px;
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
        background-color: #ED563C;
        color: #fff;
        border-radius: 8px;
        white-space: nowrap;
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
        padding: 3px 30px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
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
        padding-top: 0 !important;
        /* height: 100vh; */
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
            <div class="container-fluid p-0" style="position:relative">

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
        
                        <button class="custom-skip-forward-button">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M20.8888889,7.55555556 C19.3304485,4.26701301 15.9299689,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 L12,22 C17.5228475,22 22,17.5228475 22,12 M22,4 L22,8 L18,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                        </button>  
        
                        <button class="custom-skip-backward-button">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="font-size: 38px;"><path fill="none" stroke-width="2" d="M3.11111111,7.55555556 C4.66955145,4.26701301 8.0700311,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 L12,22 C6.4771525,22 2,17.5228475 2,12 M2,4 L2,8 L6,8 M9,16 L9,9 L7,9.53333333 M17,12 C17,10 15.9999999,8.5 14.5,8.5 C13.0000001,8.5 12,10 12,12 C12,14 13,15.5000001 14.5,15.5 C16,15.4999999 17,14 17,12 Z M14.5,8.5 C16.9253741,8.5 17,11 17,12 C17,13 17,15.5 14.5,15.5 C12,15.5 12,13 12,12 C12,11 12.059,8.5 14.5,8.5 Z"></path></svg>
                        </button>  
        
                        <video id="my-video" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls 
                          style="border-radius:20px; height:50% !important; "   width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                            autoplay>
                            <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">
        
                                            {{-- Subtitle --}}
                                {{-- @if(isset($playerui_settings['subtitle']) && $playerui_settings['subtitle'] == 1 && isset($subtitles) && count($subtitles) > 0)
                                    @foreach($subtitles as $subtitles_file)
                                        <track kind="subtitles" src="{{ $subtitles_file->url }}" srclang="{{ $subtitles_file->sub_language }}"
                                            label="{{ $subtitles_file->shortcode }}" @if($loop->first) default @endif >
                                    @endforeach
                                @endif --}}
                        </video>
                    @endif
        
                    {{-- <div class="video" id="visibilityMessage" style="color: white; display: none; background: linear-gradient(333deg, rgba(4, 21, 45, 0) 0%, #050505 100.17%), url('{{  $videodetail->player_image_url  }}');background-size: cover; height:100vh;">
                        <div class="row container" style="padding-top:4em;">
                            <div class="col-2"></div>
        
                            <div class="col-lg-3 col-6 mt-5">
                                <img class="posterImg w-100"  src="{{ $videodetail->image_url }}" >
                            </div>
        
                            <div class="col-lg-6 col-6 mt-5">
        
                                <h2 class="title">{{ optional($videodetail)->title }} </h2><br>
                                <h5 class="title"> {{ $videodetail->users_video_visibility_status_message }}</h5><br>
                                <a class="btn" href="{{ $videodetail->users_video_visibility_redirect_url }}">
        
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                                    </div>
                                </a>
        
                            </div>
                        </div>
                    </div> --}}
        
               
        
                    {{-- <div class="video" style="background: linear-gradient(333deg, rgba(4, 21, 45, 0) 0%, #050505 100.17%), url('{{  $videodetail->player_image_url  }}');background-size: cover; height:100vh;">
                        <div class="row container" style="padding-top:4em;">
                            <button class="staticback-btn" onclick="history.back()" title="Back Button">
                                <i class="fa fa-arrow-left" aria-hidden="true" style="font-size:25px;"></i>
                            </button>
        
                            <div class="col-2"></div>
        
                            <div class="col-lg-3 col-6 mt-5">
                                <img class="posterImg w-100"  src="{{ $videodetail->image_url }}" >
                            </div>
        
                            <div class="col-lg-6 col-6 mt-5">
        
                                <h2 class="title">{{ optional($videodetail)->title }} </h2><br>
        
                                <h5 class="title"> {{ $videodetail->users_video_visibility_status_message }}</h5><br>
        
                                <a class="btn" href="{{ $videodetail->users_video_visibility_redirect_url }}">
                                    <div class="playbtn" style="gap:5px">
                                        {!! $play_btn_svg !!}
                                        <span class="text pr-2"> {{ __( $videodetail->users_video_visibility_status_button ) }} </span>
                                    </div>
                                </a>
        
                            </div>
                        </div>
                    </div> --}}
                @endif
            </div>
           
            @php 
            include public_path('themes/theme5-nemisha/views/video-js-Player/video/videos_script_file.blade.php');
            // include public_path('themes/theme5-nemisha/views/video-js-Player/video/videos_ads.blade.php');
            // include public_path('themes/theme5-nemisha/views/footer.blade.php'); 
            @endphp

            {{-- @if(isset($setting) && $setting->video_clip_enable == 1 && count($videoURl) > 0)
            @php include public_path('themes/theme5-nemisha/views/video-js-Player/video/Concat_Player_Script.blade.php'); @endphp
            @else --}}
            {{-- @php include public_path('themes/theme5-nemisha/views/video-js-Player/video/player_script.blade.php'); @endphp --}}
            {{-- @endif --}}

        </div>
        <div class="py-2" style="font-size: 30px; font-weight:bold; color:white;" >
            <p>{{$videodetail->title}}</p>
        </div>
        <div class="d-flex flex-column flex-lg-row justify-content-between" >
            <div class="d-flex align-items-center">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists d-flex justify-content-end" style="align-items: self-end;">
                    <li class="share">
                        <span data-toggle="modal"  data-video-id={{ $videodetail->id }}   onclick="video_watchlater(this)" >
                            <i class="video-watchlater {{ !is_null($videodetail->watchlater_exist) ? "fal fa-minus" : "fal fa-plus "  }}"></i>
                        </span>
                        <div class="share-box box-watchtrailer " onclick="video_watchlater(this)" style="top:41px">
                            <div class="playbtn"  data-toggle="modal">  
                                <span class="text" style="background-color: transparent; font-size: 14px; width:100%;">{{ __('Add To Watchlist') }}</span>
                            </div>
                        </div>
                    </li>
                     <!-- Wishlist  -->
                    <li class="share">
                        <span class="mywishlist " data-video-id={{ $videodetail->id }} onclick="video_wishlist(this)" >
                            <i class="video-wishlist {{ !is_null( $videodetail->wishlist_exist ) ? 'ri-heart-fill' : 'ri-heart-line'  }}"></i>
                        </span>
                        <div class="share-box box-watchtrailer " onclick="video_wishlist(this)" style="top:41px">
                            <div class="playbtn"  data-toggle="modal">  
                                <span class="text" style="background-color: transparent; font-size: 14px; width:100%;">{{ __('Add To Wishlist') }}</span>
                            </div>
                        </div>
                    </li>

                    @php include public_path('themes/theme5-nemisha/views/UserGeneratedContent/social-share.php'); @endphp 
    
                    <li>
                    <span data-video-id={{ $videodetail->id }}  onclick="video_like(this)" >
                        <i class="video-like {{ !is_null( $videodetail->Like_exist ) ? 'ri-thumb-up-fill' : 'ri-thumb-up-line'  }}"></i>
                    </span>
                    </li>
                    <li>
                    <span data-video-id={{ $videodetail->id }}  onclick="video_dislike(this)" >
                        <i class="video-dislike {{ !is_null( $videodetail->dislike_exist ) ? 'ri-thumb-down-fill' : 'ri-thumb-down-line'  }}"></i>
                    </span>
                    </li>
                    <li>
                    <span><a href="#" onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a></span>
                    </li>
                    <input type="hidden" value="181" id="videoid">    <input type="hidden" value="1" id="user_id">                                   
                 </ul>
            </div>

            <div class="d-flex align-items-center text-white">
                <div class="p-1" style="border-radius: 7px; line-height: 25px;  background-color: #848880;" >
                                @if(isset($view_increment) && $view_increment == true )
                                {{ ( $movie->views + 1) . " views" }}
                                @else
                                {{ $videodetail->views . " views" }} 
                                @endif | 12k Liked |10 Disliked | {{ $videodetail->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-start mx-3">
        <div >
        <img class="rounded-circle img-fluid text-center mb-3 mt-4"
        src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile-bg" style="height: 80px; width: 80px;">
        </div>
       <div class="col" style="padding-top: 40px;" >
        <div>
        <h4>{{$user->username}}</h4>
        </div>
        {{-- <div>
           <h5>Entertainmnt channel </h5>
        </div> --}}
       </div>
    </div>
    <div class="mx-3" >
        <button style="background:#ED563C!important;color: #ffff!important; padding: 5px 100px !important; margin:0% "  class="ugc-subscriber" >Subscribe</button>
    </div>
  

    @if($videodetail->description)
    <div class="ugc-description m-3"  style="overflow-y: scroll; max-height: 180px; scrollbar-width: none; color:#fff !important;">

        <p class="desc" id="description" class="description-text">
            {{ $videodetail->description }}
        </p>

        @if(strlen($videodetail->description) > 300)
            <span class="des-more-less-btns p-0 read-button" id="read-more-btn" onclick="toggleReadMore()">{{ __('...SHOW MORE') }}</span>
            <span class="des-more-less-btns p-0 read-button" id="read-less-btn" onclick="toggleReadMore()" style="display: none;">{{ __('SHOW LESS') }}</span>
        @endif

    </div>
    @endif

    {{-- <div class="row mx-3">
        <div class="col-2" >
        <a class="edit-button Text-white"href="javascript:;" onclick="jQuery('#ugc-profile-modal').modal('show');">
        <img class="rounded-circle img-fluid text-center mb-3 mt-4"
        src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile-bg" style="height: 80px; width: 80px;">
        </a>
        </div>
       <div class=" ugc-commentsection col-10 my-auto">
        <textarea name="" id="" rows="2"></textarea>
        </div>
     
    </div> --}}

     <div class="mx-3">
        {{-- @if( $CommentSection != null && $CommentSection->videos == 1 ) --}}
        <div class="sectionArtists">   
                <div >
                    @php include public_path('themes/theme5-nemisha/views/ugc-comments/index.blade.php') @endphp
                </div>
        </div>
        {{-- @endif --}}
    </div>

    {{-- <div class="mx-4 text-white">
        <div class="p-1" style="line-height: 25px;" >
            <h6> Joseph Khumalo | 2 Months Ago  </h6>
            <p class="pt-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
        </div>
        <div>

            <ul class="p-0 share-icons music-play-lists d-flex justify-content-start">
                <li>
                    <span><i class="ri-thumb-up-line active" aria-hidden="true" style="cursor:pointer;" data-like-val="1" like="1" id="like" data-authenticated="1"></i></span>
                </li>
                <li>
                    <span><i class="ri-thumb-down-line" aria-hidden="true" style="cursor:pointer;" data-like-val="1" dislike="1" id="dislike" data-authenticated="1"></i></span>
                </li>
            </ul>
        </div>
    </div> --}}

    </div>
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
             <div class="ugc-tabs">
                 <div class="ugc-playlist">New</div>
                 <div class="ugc-playlist">Related</div>
                 <div class="ugc-playlist">Your Playlist</div>  
                 <div class="ugc-playlist">Watch Now</div>
                 <div class="ugc-playlist">Trending</div>
                 <div class="ugc-playlist">Watch Now</div>
             </div>     

           
      <div class="mx-3">
         @foreach ($ugcvideos as $eachugcvideos)
         <div class="px-3" >
              <a  href="{{ url('ugc/video-player/' . $eachugcvideos->slug) }}" class="m-1">
                         <div class="ugc-videos">
                             <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
                         </div>
                         <div class="text-white pt-3">
                             <h6>{{$eachugcvideos->title}}</h6>
                             <p style="margin:5px 0px;">{{$user->name}}</p>
                             <p>        
                                {{ $eachugcvideos->created_at->diffForHumans() }} | {{ $eachugcvideos->views ?  $eachugcvideos->views : '0' }} Views | 90k Likes
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
    $('#like').click(function(){
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                var like = 1;
                //$(this).css('color','#34c1d8');
                $.ajax({
                url: "https://localhost/flicknexs/like-video",
                type: "POST",
                data: {like: like,videoid:videoid,user_id:user_id, _token: '0I3W3oqEa79ehGp5x4dsergE7ZlnfOwHogiPB843'},
                dataType: "html",
                success: function(data) {
                    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">you have liked this media</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
                    
                }
            });
            // $(this).html('<i class="ri-thumb-up-fill"></i>');
    
            // $(this).replaceClass('ri-thumb-up-line ri-thumb-up-fill');
    
            }else{
                var like = 0;
                //$(this).css('color','#4895d1');
                $.ajax({
                url: "https://localhost/flicknexs/like-video",
                type: "POST",
                data: {like: like,videoid:videoid,user_id:user_id, _token: '0I3W3oqEa79ehGp5x4dsergE7ZlnfOwHogiPB843'},
                dataType: "html",
                success: function(data) {
               $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">you have removed from liked this media </div>');
                setTimeout(function() {
                    $('.remove_watch').slideUp('fast');
                     }, 3000);
                }
            });
            // $(this).html('<i class="ri-thumb-up-line"></i>');
    
                // $(this).replaceClass('ri-thumb-up-fill ri-thumb-up-line');
            }
           
        } else {
          window.location = 'https://localhost/flicknexs/login';
      }
    });
    
    
    
    $('#dislike').click(function(){
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                var dislike = 1;
                //$(this).css('color','#34c1d8');
                
                    $.ajax({
                        url: "https://localhost/flicknexs/dislike-video",
                        type: "POST",
                        data: {dislike: dislike,videoid:videoid,user_id:user_id, _token: '0I3W3oqEa79ehGp5x4dsergE7ZlnfOwHogiPB843'},
                        dataType: "html",
                        success: function(data) {
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">you have disliked this media</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
                //     $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Removed From Dislike </div>');
                // setTimeout(function() {
                //     $('.remove_watch').slideUp('fast');
                //      }, 300);
                
                    }
                });

            }else{
                var dislike = 0;
                //$(this).css('color','#4895d1');
                $.ajax({
            url: "https://localhost/flicknexs/dislike-video",
            type: "POST",
            data: {dislike: dislike,videoid:videoid,user_id:user_id, _token: '0I3W3oqEa79ehGp5x4dsergE7ZlnfOwHogiPB843'},
            dataType: "html",
            success: function(data) {
                    $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">you have removed from disliked this media</div>');
                setTimeout(function() {
                    $('.remove_watch').slideUp('fast');
                     }, 3000);
                
            }
        });
            }
            // alert('test');
        
          
        } else {
          window.location = 'https://localhost/flicknexs/login';
      }
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
        // console.log(url);
        // console.log(media_path);
        // console.log(path);
    }
    function EmbedCopy() {
    // var media_path = $('#media_url').val();
    var media_path = '<iframe width="853" height="480" src="https://localhost/flicknexs/category/videos/embed/little-dog" frameborder="0" allowfullscreen></iframe>';
    var url =  navigator.clipboard.writeText(window.location.href);
    var path =  navigator.clipboard.writeText(media_path);
    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embedded URL</div>');
           setTimeout(function() {
            $('.add_watch').slideUp('fast');
           }, 3000);
    // console.log(url);
    // console.log(media_path);
    // console.log(path);
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
    function Copy() {
        var media_path = $('#media_url').val();
      var url =  navigator.clipboard.writeText(window.location.href);
      var path =  navigator.clipboard.writeText(media_path);
      $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
                   setTimeout(function() {
                    $('.add_watch').slideUp('fast');
                   }, 3000);
    // console.log(url);
    // console.log(media_path);
    // console.log(path);
    }
    
</script>

@php
 include public_path('themes/theme5-nemisha/views/UserGeneratedContent/videos-details-script-file.blade.php');
@endphp

