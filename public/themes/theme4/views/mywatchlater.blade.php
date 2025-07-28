 @php 
    include public_path('themes/theme4/views/header.php');
@endphp

  
<!-- MainContent -->
 <div class="main-content">
    <div class="container-fluid pl-0">

        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header align-items-center justify-content-between">
                <h4 class="main-title mar-left">{{ __('Media in My Watchlater') }}</h4>
                </div>
            </div>
        </div>

        <div class="trending-contens sub_dropdown_image mt-3">
            <div id="trending-slider-nav" class="series-networks-slider-nav list-inline p-0 mar-left row align-items-center">
                @if(isset($channelwatchlater))
                    @foreach($channelwatchlater as $key => $channelwatchlater_videos)
                        <div class="network-image">
                            <div class="movie-sdivck position-relative">
                                <img src="{{ $channelwatchlater_videos->image ? URL::to('public/uploads/images/'.$channelwatchlater_videos->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                               
                                <div class="controls">     
                                    <a href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>">
                                        <button class="playBTN"> <i class="fas fa-play"></i></button>
                                    </a>
                                    <nav>
                                        <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#watchlater-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade info_model" id="watchlater-{{ $key }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                <div class="container">
                                    <div class="modal-content" style="border:none; background:transparent;">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <img src="{{ $channelwatchlater_videos->image ? URL::to('public/uploads/images/'.$channelwatchlater_videos->player_image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                                <h2 class="caption-h2">{{ optional($channelwatchlater_videos)->title }}</h2>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                                <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    <div class="trending-dec">{!! html_entity_decode( $channelwatchlater_videos->description ) ??  $livestream_videos->description  !!}</div>
                                                
                                                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $channelwatchlater_videos->slug ?>" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
                                                            <i class="far fa-eye mr-2" aria-hidden="true"></i> {{ "View Content" }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                    <!-- Episode -->

                    @if(isset($episode_videos))
                        @foreach($episode_videos as $key => $episode_videos)
                            <div class="network-image">
                                <div class="movie-sdivck position-relative">
                                    <img src="{{ $episode_videos->image ? URL::to('public/uploads/images/'.$episode_videos->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                
                                    <div class="controls">     
                                        <a href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $episode_videos->slug ?>">
                                            <button class="playBTN"> <i class="fas fa-play"></i></button>
                                        </a>
                                        <nav>
                                            <button class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#watchlater-episode-{{ $key }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade info_model" id="watchlater-episode-{{ $key }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                                    <div class="container">
                                        <div class="modal-content" style="border:none; background:transparent;">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <img src="{{ $episode_videos->image ? URL::to('public/uploads/images/'.$episode_videos->image) : $default_vertical_image_url }}" class="img-fluid w-100" alt="Videos" width="300" height="200">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                                    <h2 class="caption-h2">{{ optional($episode_videos)->title }}</h2>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                                    <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        <div class="trending-dec">{!! html_entity_decode( $episode_videos->episode_description ) ??  $episode_videos->episode_description  !!}</div>
                                                    
                                                            <a href="<?php echo URL::to('episode') ?><?= '/'.$series_slug .'/'. $episode_videos->slug ?>" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0">
                                                                <i class="far fa-eye mr-2" aria-hidden="true"></i> {{ "View Content" }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if( (is_countable($channelwatchlater) && count($channelwatchlater) == 0) && (is_countable($episode_videos) && count($episode_videos) == 0) )
                        <div class="col-md-12 text-center mt-4">
                            <img class="w-50" style="width: 50%!important;" src="{{ URL::to('/assets/img/sub.png') }}">
                        </div>
                    @endif
            </div>
        </div>

    </div>
 </div>

 <!-- watchlater -->
 <script>
$('.watchlater').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/addwatchlater');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Watchlater"){
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Watchlater');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to Watchlater</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Watchlater');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from Watchlater</div>');
                          setTimeout(function() {
                          $('.remove_watch').slideUp('fast');
                          }, 3000);
                          }               
                    }
                });
            }                
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });
</script>
<script>
// Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
$('.dropdown-menu a').click(function(e){
 e.preventDefault();
 if($(this).next('.submenu').length){
   $(this).next('.submenu').toggle();
 }
 $('.dropdown').on('hide.bs.dropdown', function () {
   $(this).find('.submenu').hide();
 }
                  )
}
                          );
}
</script>
   
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
if (window.pageYOffset > sticky) {
header.classList.add("sticky");
} else {
header.classList.remove("sticky");
}
}
</script>
<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
<script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
<link href=”//vjs.zencdn.net/7.0/video-js.min.css” rel=”stylesheet”>
<script src=”//vjs.zencdn.net/7.0/video.min.js”></script>

<script src="<?= THEME_URL .'/assets/dist/video.js'; ?>"></script>
 <script src="<?= THEME_URL .'/assets/dist/videojs-resolution-switcher.js'; ?>"></script>
 <script src="<?= THEME_URL .'/assets/dist/videojs-watermark.js'; ?>"></script>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>
<script src="<?php echo URL::to('/').'/assets/js/videojs.hotkeys.js';?>"></script>

<style>
    div#trending-slider-nav{display: flex;
        flex-wrap: wrap;}
        .network-image{flex: 0 0 16.666%;max-width: 16.666%;}
        /* .network-image img{width: 100%; height:auto;} */
        .movie-sdivck{padding:2px;}
        #trending-slider-nav div.slick-slide{padding:2px;}
        div#trending-slider-nav .slick-slide.slick-current .movie-sdivck.position-relative{border:2px solid red}
        .sub_dropdown_image .network-image:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
    }
</style>
@php 
    include public_path('themes/theme4/views/footer.blade.php');
@endphp