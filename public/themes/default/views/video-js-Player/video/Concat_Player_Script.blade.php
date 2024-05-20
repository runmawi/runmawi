<script>


document.addEventListener("DOMContentLoaded", function() {
            // Initialize Video.js player
            var player = videojs('my-video', {
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
                            entries: ['subtitlesButton', 'playbackRateMenuButton']
                        },
                        'fullscreenToggle': {}
                    }
                }
            });


            // HLS Quality Selector
            player.hlsQualitySelector({
                displayCurrentQuality: true,
            });

            // Example video URLs
        let videoList = <?php echo json_encode($videoURl); ?>;


            var manifests = videoList.map(function(item) {
                return {
                    url: item.videos_url,
                    mimeType: item.video_player_type,
                };
            });

           
            var manifests = videoList.map(function(item) {
                return {
                    url: item.videos_url,
                    mimeType: item.video_player_type,
                };
            });

            player.concat({
                manifests: manifests,
                targetVerticalResolution: 720,
                callback: function(err, result) {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    player.src({
                        src: `data:application/vnd.videojs.vhs+json,${JSON.stringify(result.manifestObject)}`,
                        type: 'application/vnd.videojs.vhs+json',
                    });
                }
            });
            });
// document.addEventListener("DOMContentLoaded", function() {
//     // Initialize Video.js player
//     var player = videojs('my-video', {
//         aspectRatio: '16:9',
//         fill: true,
//         playbackRates: [0.5, 1, 1.5, 2, 3, 4],
//         fluid: true,
//         controlBar: {
//             volumePanel: {
//                 inline: false
//             },
//             children: {
//                 'playToggle': {},
//                 'currentTimeDisplay': {},
//                 'timeDivider': {},
//                 'durationDisplay': {},
//                 'liveDisplay': {},
//                 'flexibleWidthSpacer': {},
//                 'progressControl': {},
//                 'settingsMenuButton': {
//                     entries: ['subtitlesButton', 'playbackRateMenuButton']
//                 },
//                 'fullscreenToggle': {}
//             }
//         }
//     });

//        // Hls Quality Selector - M3U8 

//     //    player.hlsQualitySelector({
//     //         displayCurrentQuality: true,
//     //     });

// //     let videoList = <?php echo json_encode($videoURl); ?>;


// //     var manifests = videoList.map(function(item) {
// //         return {
// //             url: item.videos_url,
// //             mimeType: item.video_player_type,
// //         };
// //     });

// //     player.concat({
// //         manifests: manifests,
// //         targetVerticalResolution: 720,
// //         callback: function(err, result) {
// //             if (err) {
// //                 console.error(err);
// //                 return;
// //             }
// //             player.src({
// //                 src: `data:application/vnd.videojs.vhs+json,${JSON.stringify(result.manifestObject)}`,
// //                 type: 'application/vnd.videojs.vhs+json',
// //             });
// //         }
// //     });

// player.concat({
//   manifests: [{
//     url: 'https://s3.amazonaws.com/_bc_dml/example-content/bipbop-advanced/bipbop_16x9_variant.m3u8',
//     mimeType: 'application/x-mpegURL'
//   }, {
//     url: 'https://s3.amazonaws.com/_bc_dml/example-content/bipbop-advanced/bipbop_16x9_variant.m3u8',
//     mimeType: 'application/x-mpegURL'
//   }],
//   targetVerticalResolution: 720,
//   callback: (err, result) => {
//     if (err) {
//       console.error(err);
//       return;
//     }
//     console.log(result);
//     player.src({
//       src: `data:application/vnd.videojs.vhs+json,${JSON.stringify(result.manifestObject)}`,
//       type: 'application/vnd.videojs.vhs+json'
//     });
//   }
// });
// });
</script>