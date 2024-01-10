<script>
    document.addEventListener("DOMContentLoaded", function() {

        var player = videojs('live-stream-player', { // Video Js Player 
            aspectRatio: '16:9',
            fill: true,
            playbackRates: [0.5, 1, 1.5, 2, 3, 4],
            fluid: true,
            autoplay: true,


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

                    'fullscreenToggle': {},
                },

            }
        });


        player.hlsQualitySelector({ // Hls Quality Selector - M3U8 
            displayCurrentQuality: true,
        });

        var Advertisement  =  '<?= $live_ads ?>' ;  // Advertisement

        if (!!Advertisement) {

            player.ima({
                adTagUrl: Advertisement,
                showControlsForAds: true,
                debug: false,
            });
        }
    });
</script>