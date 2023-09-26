<style>
    .video-js-trailer-modal-dialog {
        max-width: 800px;
        margin: 30px auto;
    }

    .video-js-trailer-modal-body {
        position: relative;
        padding: 0px;
    }

    .video-js-trailer-modal-close {
        position: absolute;
        right: -30px;
        top: 0;
        z-index: 999;
        font-size: 2rem;
        font-weight: normal;
        color: #fff;
        opacity: 1;
    }
</style>

<div class="modal fade" id="video-js-trailer-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="video-js-trailer-modalLabel" aria-hidden="true">
    <div class="modal-dialog video-js-trailer-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body video-js-trailer-modal-body">

                <button type="button" class="close video-js-trailer-modal-close" >
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="embed-responsive embed-responsive-16by9">

                    <?php if($videodetail->trailer_type != "embed_url" ) : ?>

                        <video id="video-js-trailer-player" class="video-js vjs-theme-fantasy vjs-icon-hd embed-responsive-item video-btn" controls
                                preload="auto" width="100%" height="auto" poster="<?= $videodetail->player_image_url ?>" >
                                <source src="<?= $videodetail->videos_url ?>" type="<?= $videodetail->video_player_type ?>">
                        </video>

                    <?php else: ?>

                        <video id="video-js-trailer-player" class="video-js vjs-theme-fantasy vjs-icon-hd embed-responsive-item video-btn" controls
                                preload="auto" width="100%" height="auto" poster="<?= $videodetail->player_image_url ?>" >
                                <source src="<?= $videodetail->videos_url ?>" type="<?= $videodetail->video_player_type ?>">
                        </video>       

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        var player = videojs('video-js-trailer-player', {  // Video Js Player  - Trai
            aspectRatio: '16:9',
            fluid: true,

            controlBar: {
                volumePanel: {
                    inline: false
                },

                children: {
                    'playToggle': {},
                    'currentTimeDisplay': {},
                    'timeDivider': {},
                    'durationDisplay': {},
                    'liveDisplay': {},

                    'flexibleWidthSpacer': {},
                    'progressControl': {},

                    'settingsMenuButton': {
                        entries: [
                            'playbackRateMenuButton'
                        ]
                    },
                    'fullscreenToggle': {}
                }
            }
        });

        player.hlsQualitySelector({ // Hls Quality Selector - M3U8 
            displayCurrentQuality: true,
        });

        
        $(".video-js-trailer-modal-close").click(function(){
                player.pause();  
                $('#video-js-trailer-modal').modal('hide');
        });
    });
</script>