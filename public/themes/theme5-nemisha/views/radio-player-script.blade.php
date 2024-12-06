<script type="text/javascript">
    var base_url = $('#base_url').val();
    var indexAudio = 0;
    var currentAudio = document.getElementById("myAudio");
    var playListItems = document.querySelectorAll(".playlist-track-ctn");
    var progressbar = document.querySelector('#myProgress');
    var barProgress = document.getElementById("myBar");
    var timer = document.getElementsByClassName('timer')[0];
    var width = 0;

    $(document).ready(function() {
        // Favorite functionality
        $('.favorite').click(function() {
            handleAuthenticatedAction('favorite', $(this), 'audio_id', '<i class="fa fa-heart"></i>', '<i class="fa fa-heart-o"></i>');
        });

        // Watch Later functionality
        $('.watchlater').click(function() {
            handleAuthenticatedAction('watchlater', $(this), 'audio_id', '<i class="fa fa-check"></i>Watch Later', '<i class="fa fa-clock-o"></i>Watch Later');
        });

        // My Wishlist functionality
        $('.mywishlist').click(function() {
            handleAuthenticatedAction('mywishlist', $(this), 'audio_id', '<i class="fa fa-check"></i>Wishlisted', '<i class="fa fa-plus"></i>Add Wishlist');
        });

        // Playlist track click event
        playListItems.forEach(function(item, i) {
            item.addEventListener("click", getClickedElement.bind(this, i));
        });

        // Audio setup
        currentAudio.onloadedmetadata = function() {
            document.getElementsByClassName('duration')[0].innerHTML = getMinutes(this.currentAudio.duration);
        };

        // Initial audio setup
        loadNewTrack(indexAudio);

        // Progress bar click event
        progressbar.addEventListener("click", seek.bind(this));

        // Event listeners for audio control
        document.querySelector('#icon-play').addEventListener("click", toggleAudio.bind(this));
        document.querySelector('#icon-pause').addEventListener("click", toggleAudio.bind(this));
        document.querySelector('#toggleMute').addEventListener("click", toggleMute.bind(this));
    });

    // Handle authenticated actions (favorite, watchlater, mywishlist)
    function handleAuthenticatedAction(action, element, dataAttribute, activeHtml, inactiveHtml) {
        if (element.data('authenticated')) {
            $.post(`<?= URL::to('${action}') ?>`, {
                [dataAttribute]: element.data(dataAttribute),
                _token: '<?= csrf_token() ?>'
            }, function(data) {});
            element.toggleClass('active').html(element.hasClass('active') ? activeHtml : inactiveHtml);
        } else {
            window.location = base_url + '/signup';
        }
    }

    // Handle playlist track click and audio change
    function getClickedElement(index) {
        if (index === indexAudio) {
            toggleAudio();
        } else {
            loadNewTrack(index);
        }
    }

    // Load new track based on the index
    function loadNewTrack(index) {
        var player = document.querySelector('#source-audio');
        player.src = listAudio[index].mp3_url;
        document.querySelector('.title').innerHTML = listAudio[index].title;
        document.querySelector('#audio_img').src = '<?php echo URL::to('/public/uploads/images/'); ?>' + '/' + listAudio[index].image;
        
        var divElement = document.getElementById("player-ctn");
        divElement.style.backgroundImage = "linear-gradient(to left, rgba(0, 0, 0, 0.25)0%, rgba(117, 19, 93, 1))," +
            "url('" + '<?php echo URL::to('/public/uploads/images/'); ?>' + '/' + listAudio[index].player_image + "')";
        
        currentAudio.load();
        toggleAudio();
        updateStylePlaylist(indexAudio, index);
        indexAudio = index;
    }

    // Toggle play/pause functionality
    function toggleAudio() {
        if (currentAudio.paused) {
            document.querySelector('#icon-play').style.display = 'none';
            document.querySelector('#icon-pause').style.display = 'block';
            document.querySelector('#ptc-' + indexAudio).classList.add("active-track");
            playToPause(indexAudio);
            currentAudio.play();
        } else {
            document.querySelector('#icon-play').style.display = 'block';
            document.querySelector('#icon-pause').style.display = 'none';
            pauseToPlay(indexAudio);
            currentAudio.pause();
        }
    }

    // Update playlist style on track change
    function updateStylePlaylist(oldIndex, newIndex) {
        document.querySelector('#ptc-' + oldIndex).classList.remove("active-track");
        pauseToPlay(oldIndex);
        document.querySelector('#ptc-' + newIndex).classList.add("active-track");
        playToPause(newIndex);
    }

    // Convert seconds to minutes:seconds format
    function getMinutes(t) {
        var min = parseInt(t / 60);
        var sec = parseInt(t % 60);
        if (sec < 10) sec = "0" + sec;
        if (min < 10) min = "0" + min;
        return min + ":" + sec;
    }

    // Seek functionality for progress bar
    function seek(event) {
        var percent = event.offsetX / progressbar.offsetWidth;
        currentAudio.currentTime = percent * currentAudio.duration;
        barProgress.style.width = percent * 100 + "%";
    }

    // Mute/unmute functionality
    function toggleMute() {
        var volUp = document.querySelector('#icon-vol-up');
        var volMute = document.querySelector('#icon-vol-mute');
        currentAudio.muted = !currentAudio.muted;
        volUp.style.display = currentAudio.muted ? "none" : "block";
        volMute.style.display = currentAudio.muted ? "block" : "none";
    }

    // Play to Pause functionality
    function playToPause(index) {
        var ele = document.querySelector('#p-img-' + index);
        ele.classList.remove("fa-play");
        ele.classList.add("fa-pause");
    }

    // Pause to Play functionality
    function pauseToPlay(index) {
        var ele = document.querySelector('#p-img-' + index);
        ele.classList.remove("fa-pause");
        ele.classList.add("fa-play");
    }
</script>
