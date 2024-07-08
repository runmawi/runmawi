<?php  
    if(isset($videodetail->Reels_videos)) :
        foreach($videodetail->Reels_videos as $reel): 
?>

    <div class="sectionArtists broadcast">
        <div class="block-images position-relative" data-toggle="modal" data-target="#Reels" data-name=<?php echo $reel->reels_videos; ?>
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

<div class="modal fade" id="Reels" tabindex="-1" role="dialog" aria-labelledby="Reels" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body" id="Reels">
                <video id="Reels_player" class="vjs-theme-city my-video video-js vjs-big-play-centered vjs-play-control vjs-fluid vjs_video_1462 vjs-controls-enabled vjs-picture-in-picture-control vjs-workinghover vjs-v7 vjs-quality-selector vjs-has-started vjs-paused vjs-layout-x-large vjs-user-inactive" controls preload="auto" width="640" height="264">
                    <source id="video_source" src="" type="video/mp4">
                </video>
                <button type="button" class="close reelsclose video-js-trailer-modal-close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <div class="modal-footer" style="">
                <button type="button" class="btn btn-secondary reelsclose" data-dismiss="modal"><?= __('Close') ?></button>
            </div> -->
        </div>
    </div>
</div>

<!-- Reels Player -->

<?php $ReelVideos = URL::to('public/uploads/reelsVideos/shorts') . '/'; ?>

{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="{{ asset('public/themes/default/assets/css/video-js/videojs.min.css') }}" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/default/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

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
            console.log("Reels",Reels);
            
            var player = videojs('Reels_player');
            player.src({
                src: Reels,
                type: 'video/mp4'
            });
            player.play();
            console.log("player",player.src());
        }

        $(document).ready(function() {
            $(".reelsclose").click(function() {
                var player = videojs('Reels_player');
                player.pause();
            });
        });

        var player = videojs('Reels_player', { // Video Js Player 
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,
            controlBar: {
                volumePanel: { inline: false },
                children: {
                    'playToggle': {},
                    // 'currentTimeDisplay': {},
                    // 'liveDisplay': {},
                    // 'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    // 'subtitlesButton': {},
                    // 'playbackRateMenuButton': {},
                    'fullscreenToggle': {},    
                    // 'audioTrackButton': {}               
                },
                // pictureInPictureToggle: true,
            }
        });
</script>

<style>
    .modal-body {
        position: unset;
    }

    .modal-footer {
        background: black;
    }
</style>
