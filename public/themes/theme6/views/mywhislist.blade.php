@php
    include public_path('themes/theme6/views/header.php')
@endphp

<!-- MainContent -->
<div class="main-content">
    <div class="container">

        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="Continue Watching">Media in My Wishlist</h4>
                </div>
            </div>
        </div>

        <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
                @if(count($channelwatchlater) > 0)
                    @foreach($channelwatchlater as $channelwatchlater_videos)
                        <li class="slide-item">
                            <div class="block-images position-relative">
                                <a href="{{ URL::to('category/videos/'.$channelwatchlater_videos->slug ) }}">
                                    <div class="img-box">
                                        <img src="{{ $channelwatchlater_videos->image ?  URL::to('public/uploads/images/'.$channelwatchlater_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                    </div>

                                    <div class="block-description">
                                        <span> {{ strlen($channelwatchlater_videos->title) > 17 ? substr($channelwatchlater_videos->title, 0, 18) . '...' : $channelwatchlater_videos->title }}
                                        </span>
                                        <div class="movie-time d-flex align-items-center my-2">

                                            <span class="text-white">
                                                @if($channelwatchlater_videos->duration != null)
                                                    @php
                                                        $duration = Carbon\CarbonInterval::seconds($channelwatchlater_videos->duration)->cascade();
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
                        </li>
                    @endforeach
                @endif

                    <!-- Episode -->

                @if(count($episode_videos) > 0) 
                    @foreach($episode_videos as $episode_videos)
                        <li class="slide-item">
                            <div class="block-images position-relative">
                                <a href="{{ URL::to('episode/'. $episode_videos->series_slug.'/'.$episode_videos->slug ) }}">

                                    <div class="img-box">
                                        <img src="{{ $episode_videos->image ? URL::to('public/uploads/images/'.$episode_videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                    </div>
                        
                                    <div class="block-description">
                                        <p> {{ strlen($episode_videos->title) > 17 ? substr($episode_videos->title, 0, 18) . '...' : $episode_videos->title }}</p>

                                        <div class="movie-time d-flex align-items-center my-2">

                                            <span class="text-white">
                                                @if($episode_videos->duration != null)
                                                    @php
                                                        $duration = Carbon\CarbonInterval::seconds($episode_videos->duration)->cascade();
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
                                                {{ __("Play Now") }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        @if((is_countable($channelwatchlater) && count($channelwatchlater) == 0) && 
            (is_countable($episode_videos) && count($episode_videos) == 0))

            <h4 class="text-center">No Media in My Wishlists</h4>
            <div class="col-md-12 text-center mt-4">
                <img class="w-50" style="width: 50%!important;" src="<?php echo  URL::to('/assets/img/sub.png')?>">
            </div>
        @endif

    </div>
 </div>

 <script>
$('.mywishlist').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/mywishlist');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Wishlist"){
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Wishlist');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
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

@php
    include public_path('themes/theme6/views/footer.blade.php')
@endphp