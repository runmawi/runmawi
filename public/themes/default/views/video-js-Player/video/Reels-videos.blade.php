<?php  
    if(isset($videodetail->Reels_videos)) :
        foreach($videodetail->Reels_videos as $reel): 
?>
    <div class="sectionArtists broadcast">
        <div class="block-images position-relative" data-bs-toggle="modal" data-bs-target="#reelsmodal" data-name=<?php echo $reel->reels_videos; ?>
            onclick="addvidoes(this)">
            <div class="listItem">
                <div class="profileImg">
                    <span class="lazy-load-image-background blur lazy-load-image-loaded"
                        style="color: transparent; display: inline-block;">
                        <img src="<?= optional($videodetail)->Reels_Thumbnail ?>">
                    </span>
                </div>
                <div class="name"><?= __('Reels') ?></div>
            </div>
        </div>
    </div>

<?php endforeach; endif; ?>


<!-- Reels Modal -->

<div class="modal fade" id="reelsmodal" tabindex="-1" aria-labelledby="reelsmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close close video-js-reels-modal-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <video id="Reels_player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls width="auto" height="auto">
                    <!-- <source id="video_source" src="" type="video/mp4"> -->
                </video>
            </div>
        </div>
    </div>
</div>

<!-- Reels Player -->

<?php $ReelVideos = URL::to('public/uploads/reelsVideos/shorts') . '/'; ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="{{ asset('public/themes/default/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

    <!-- <script src="{{ asset('assets/js/video-js/video.min.js') }}"></script> -->
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

<script>
        function addvidoes(ele) {
            var Reels_videos = $(ele).attr('data-name');
            var Reels_url = <?php echo json_encode($ReelVideos); ?>;
            var Reels = Reels_url + Reels_videos;
            // console.log("Reels",Reels);
            
            var player = videojs('Reels_player');
            player.src({
                src: Reels,
                type: 'video/mp4'
            });
            player.play();
            // console.log("player",player.src());
        }

        $(document).ready(function() {
            $(".reelsclose").click(function() {
                var player = videojs('Reels_player');
                player.pause();
            });
        });

    document.addEventListener("DOMContentLoaded", function() {
        var player = videojs('Reels_player', { // Video Js Player 
            aspectRatio: '16:9',
            fluid: true,

            controlBar: {
                volumePanel: { inline: false },
                children: {
                    'playToggle': {},
                    // 'currentTimeDisplay': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'fullscreenToggle': {},    
                }
            }
        });

        $(".btn-close").click(function(){
            player.pause();  
        });
    });
    $(".video-js-reels-modal-close").click(function(){
        $('#Reels_player').attr('src'," ");
        $('#Reels').modal('hide');
    });
</script>

<style>
    .modal-body {
        position: unset;
    }

    .modal-footer {
        background: black;
    }
    .video-js-reels-modal-close {
        position: absolute;
        right: -30px;
        top: 0;
        z-index: 999;
        font-size: 2rem;
        font-weight: normal;
        color: #fff;
        opacity: 1;
    }
    #Reels .modal-content{
        background: transparent !important;
        border: none !important;
    }
</style>
