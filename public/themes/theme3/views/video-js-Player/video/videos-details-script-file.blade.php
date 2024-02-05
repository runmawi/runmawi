<script>
    function video_watchlater(ele) {
        
        let video_id = $(ele).data('video-id');

        $.ajax({
            url: '<?php echo route('video-js.watchlater') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                video_id: video_id,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.watchlater_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.watchlater_status == "Add" ? 'ri-subtract-line' : 'ri-add-line';

                    const Watchlater_tooltip = response.data.watchlater_status == "Add" ? 'Remove To Watchlater' : 'Add To Watchlater';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-watchlater').removeClass('ri-subtract-line ri-add-line').addClass(iconClass);

                    $('.watchlater-tooltip-text').text(Watchlater_tooltip);

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });
    }

    function video_wishlist(ele){
        
        let video_id = $(ele).data('video-id');

        $.ajax({
            url: '<?php echo route('video-js.wishlist') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                video_id: video_id,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.wishlist_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.wishlist_status == "Add" ? 'ri-heart-fill' : 'ri-heart-line';

                    const wishlist_tooltip = response.data.wishlist_status == "Add" ? 'Remove To Watchlater' : 'Add To Watchlater';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-wishlist').removeClass('ri-heart-fill ri-heart-line').addClass(iconClass);

                    $('#message-note').html(message_note).slideDown('fast');

                    $('.wishlist-tooltip-text').text(wishlist_tooltip);

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });

    }
</script>