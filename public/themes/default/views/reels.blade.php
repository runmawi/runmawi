
@php
    include(public_path($header_link));
@endphp

<style>
    .plyr__controls{
        top: 0px !important;
        bottom: 100% !important;
    }
    .plyr__progress{
        top: 0px !important;
        bottom: 100% !important;
    }
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .favorites-contens {
        display: grid !important;
        justify-content: center;
    }

    .reels-video {
        margin: 10px;
        position: relative;
        width: 20%;
        he
    }

    .video-controls {
        position: absolute;
        bottom: 10px;
        left: 10px;
        display: flex;
        align-items: center;
        color: #fff;
    }
    .play-video{
        height: 100vh !important;
    }
    .control-button,
    .share-button {
        margin-right: 10px;
        cursor: pointer;
        color: #fff; /* Add color for the icons */
    }
</style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
</head>
<body>

<div class="favorites-contens">
    @foreach ($Reels_videos as $video)
        <div class="reels-video" data-src="{{ URL::to('public/uploads/reelsVideos/shorts') . '/' . $video->reels_videos }}">
            <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" alt="Video Thumbnail">
            <div class="video-controls">
                <!-- <span class="share-button" onclick="shareVideo('{{ URL::to('public/uploads/reelsVideos/shorts') . '/' . $video->reels_videos }}')">&#128279;</span> -->
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reelsVideos = document.querySelectorAll('.reels-video');
        let currentVideoIndex = 0;

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const visibleVideoIndex = Array.from(reelsVideos).indexOf(entry.target);
                    playVideo(visibleVideoIndex);
                }
            });
        });

        reelsVideos.forEach(videoContainer => {
            observer.observe(videoContainer);
        });

        function playVideo(index) {
            const videoContainers = document.querySelectorAll('.reels-video');
            videoContainers.forEach((container, i) => {
                const video = container.querySelector('video');
                if (i === index) {
                    if (!video) {
                        const videoSrc = container.getAttribute('data-src');
                        const videoElement = document.createElement('video');
                        videoElement.controls = false;
                        videoElement.width = '100%';
                        videoElement.height = 'auto';
                        videoElement.classList.add('play-video');
                        videoElement.poster = '{{ URL::to('/') }}/public/uploads/images/{{ @$Reels_videos[$index]->reels_thumbnail }}';
                        videoElement.innerHTML = `<source src="${videoSrc}" type="video/mp4" label='720p' res='720'/>`;

                        container.innerHTML = '';
                        container.appendChild(videoElement);

                        const player = new Plyr(videoElement, {
                            controls: ['progress'], // Only show the progress bar
                            autoplay: true,
                        });
                    } else {
                        video.play();
                    }
                } else {
                    const otherVideo = container.querySelector('video');
                    if (otherVideo) {
                        otherVideo.pause();
                    }
                }
            });
        }

        window.togglePlayPause = function (button) {
            const videoContainer = button.closest('.reels-video');
            const video = videoContainer.querySelector('video');
            if (video) {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            }
        };

        window.shareVideo = function (videoSrc) {
            // Implement your share functionality here
            console.log('Share video:', videoSrc);
        };
    });
</script>

@php
  include(public_path($footer_link));
@endphp