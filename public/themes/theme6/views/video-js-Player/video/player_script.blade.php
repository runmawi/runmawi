<script>

    let video_url = "<?php echo $videodetail->videos_url ?>" ; 

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
                    // 'currentTimeDisplay': {},
                    'liveDisplay': {},
                    'flexibleWidthSpacer': {},
                    'progressControl': {},
                    'remainingTimeDisplay': {},
                    'fullscreenToggle': {},
                    // 'audioTrackButton': {},
                },
                pictureInPictureToggle: true,
            },
            html5: {
                vhs: {
                    overrideNative: true,
                }
            }
        });

        const playPauseButton = document.querySelector('.vjs-big-play-button');
        const skipForwardButton = document.querySelector('.custom-skip-forward-button');
        const skipBackwardButton = document.querySelector('.custom-skip-backward-button');
        const backButton = document.querySelector('.staticback-btn');
        const titleButton = document.querySelector('.vjs-title-bar');
        var controlBar = player.getChild('controlBar');

        player.el().appendChild(skipForwardButton);
        player.el().appendChild(skipBackwardButton);
        player.el().appendChild(titleButton);
        player.el().appendChild(backButton);
        
        function updateControls() {
            var isMobile = window.innerWidth <= 768;
            var controlBar = player.controlBar;

            if (controlBar.getChild('subtitlesButton')) {
                controlBar.removeChild('subtitlesButton');
            }
            if (controlBar.getChild('playbackRateMenuButton')) {
                controlBar.removeChild('playbackRateMenuButton');
            }
            if (controlBar.getChild('settingsMenuButton')) {
                controlBar.removeChild('settingsMenuButton');
            }

            if (!isMobile){
                controlBar.addChild('subtitlesButton');
                controlBar.addChild('playbackRateMenuButton');
            } 
            else{
                controlBar.addChild('settingsMenuButton', {
                    entries: [
                        'subtitlesButton',
                        'playbackRateMenuButton',
                    ]
                });
            }
        }

        player.on('loadedmetadata', function() {
            updateControls();
        });

        window.addEventListener('resize', function() {
            updateControls();
        });

    
        player.hlsQualitySelector({                     // Hls Quality Selector - M3U8 
            displayCurrentQuality: true,
        });    
                                                        
        var vastTagPreroll  =  '<?= $pre_advertisement ?>' ;  // Advertisement
        var vastTagPostroll =  '<?= $post_advertisement ?>' ;

        var prerollTriggered = false;
        var postrollTriggered = false;

        const vastTagMidroll_array = '<?php echo $mid_advertisement ?>' ;
        const vastTagMidrollArray = vastTagMidroll_array != "" ? JSON.parse(vastTagMidroll_array) : null ;
    
        var midrollRequested = false;
        var midrollInterval = '<?= $video_js_mid_advertisement_sequence_time ?>' ; 
        var lastMidrollTime = 0;        
    
        if (!prerollTriggered) {

            player.ima({
                adTagUrl: vastTagPreroll,
                showControlsForAds: true,
                debug: false,
            });
        } else {
            player.ima({
                adTagUrl: '',
                showControlsForAds: true,
                debug: false,
            });
        }
    
        player.ima.initializeAdDisplayContainer();
    
        function requestMidrollAd  ( vastTagMidroll ) {

            midrollRequested = true;

            player.ima.changeAdTag(vastTagMidroll);

            player.ima.requestAds();
        }
    
        player.on("timeupdate", function () {

            var currentTime = player.currentTime();

            var timeSinceLastMidroll = currentTime - lastMidrollTime;
    
            if (timeSinceLastMidroll >= midrollInterval && !midrollRequested) {

                lastMidrollTime = currentTime;
                // console.log("Midroll triggered");
                
                const random_array_index = Math.floor(Math.random() * vastTagMidrollArray.length);

                const vastTagMidroll = vastTagMidrollArray[random_array_index];

                requestMidrollAd(vastTagMidroll);
            }
        });
    
        player.on("ended", function () {

            if (!postrollTriggered) {

                postrollTriggered = true;

                player.ima.requestAds({
                    adTagUrl: vastTagPostroll,
                });
                
                // console.log("Postroll ads requested");
            }
        });
    
        player.on("adsready", function () {

            if (midrollRequested) {
              // console.log("Ads ready - midroll");
            } else {
              // console.log("Ads ready - preroll");
                player.src(video_url);
            }

        });
    
        player.on("aderror", function () {

          console.log("Ads aderror");
          player.play();

        });
    
        player.on("adend", function () {

            if (lastMidrollTime > 0) {
            //   console.log("A midroll ad has finished playing.");
                midrollRequested = false;
            } else {
            //   console.log("The preroll ad has finished playing.");
                prerollTriggered = true;
            }
            player.play();

        });

        // player.endcard({
        //     getRelatedContent: getRelatedContent,
        //     // getNextVid: getNextVid, 
        //     count: 20
        // });

    });

    // function createRelatedContent(title, url) {

    //     var sdiv = document.createElement('div');
    //     sdiv.setAttribute('class', 'col-lg-12');

    //     var div = document.createElement('div');
    //     div.setAttribute('class', 'col-4 col-sm-4 col-md-4 col-lg-4');

    //     var a = document.createElement('a');
    //     var p = document.createElement('p');

    //     p.innerHTML = title;
    //     a.href = url;
    //     a.appendChild(p);
    //     div.appendChild(a);

    //     return div;
    // }

    // // Creating related content boxes
    // var rel_content_1 = createRelatedContent("Video JS Website, For All Your HTML5 Needs.... AND MORE!", "http://www.videojs.com/");
    // var rel_content_2 = createRelatedContent("This Man Found a LinkBait LinkBait. You Won't Believe What the LinkBait Did Next!", "http://www.youtube.com/watch?v=6k3--GPk-l4");

    // // Asynchronous function to get related content
    // function getRelatedContent(callback) {
    //     var list = [rel_content_1, rel_content_2];

    //     setTimeout(function () {
    //         callback(list);
    //     }, 0);
    // }

    // var next_video = document.createElement('div');
    // var a3 = document.createElement('a');
    // var p3 = document.createElement('p');
    // p3.innerHTML = "ABOUT TO GO HERE!!";
    // a3.href = "http://www.youtube.com/watch?v=KAv500Q6bfA";
    // a3.appendChild(p3);
    // next_video.appendChild(a3);

    // function getNextVid(callback) {
    //     setTimeout(function(){
    //         callback(next_video);
    //     }, 0);
    // }

</script>
<style>
    .vjs-fg-skip-button{
	    background: #2971ea !important;
	    border-radius: 10px !important;
    }
</style>