<script>
    document.addEventListener("DOMContentLoaded", function() {

        var player = videojs('channel-video-scheduler-player', { // Video Js Player 
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
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
                    'fullscreenToggle': {},
                    'progressControl': {},

                }
            }
        });

        // Hls Quality Selector - M3U8 

        player.hlsQualitySelector({
            displayCurrentQuality: true,
        });

        // Concat 

        let videoList = <?php echo json_encode($AdminEPGChannel->ChannelVideoScheduler); ?>;

        let manifests = videoList.map(function(item) {
            return {
                url: item.videos_list.url,
                mimeType: item.videos_list.mimeType,
            };
        });

        // console.log( videoList );

        player.concat({

            manifests: manifests,

            targetVerticalResolution: 720,

            callback: (err, result) => {
                if (err) {
                    console.error(err);
                    return;
                }

                // console.log(result);

                player.src({
                    src: `data:application/vnd.videojs.vhs+json,${JSON.stringify(result.manifestObject)}`,
                    type: 'application/vnd.videojs.vhs+json'
                });
            }
        });
    });
</script>