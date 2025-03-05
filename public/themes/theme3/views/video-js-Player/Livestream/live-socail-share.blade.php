
<style>
    i#dislike {
        padding: 10px !important;
    }
    i#like {
        padding: 10px;
    }
</style>

<?php

    if(isset($Livestream_details)):
        $media_title = $Livestream_details->title;
        $url = URL::to('/live');
        $embed_url = URL::to('/live/embed');
        $media_url = $url . '/' . $Livestream_details->slug;
        $embed_media_url = $embed_url . '/' . $Livestream_details->slug;
    else:
        $media_title = '';
        $media_url = '';
    endif;

    $embed_media_url = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
?>

<li class="share">
    <span><i class="ri-share-fill"></i></span>
    <div class="share-box">
        <div class="d-flex align-items-center">
            <a href={{ "https://www.facebook.com/sharer/sharer.php?u=". $media_url }} class="share-ico"><i class="ri-facebook-fill"></i></a>
            <a href={{ "https://twitter.com/intent/tweet?text=".$media_url}} class="share-ico"><i class="ri-twitter-fill"></i></a>
            <a href={{ "https://www.linkedin.com/shareArticle?mini=true&url=".$media_url }} class="share-ico"><i class="ri-linkedin-fill"></i></a>
        </div>
    </div>
</li>


<li class="share">
    <span  data-toggle="modal"  data-live-id={{ $Livestream_details->id }} onclick="live_watchlater(this)" >
        <i class="video-watchlater {{ !is_null($Livestream_details->watchlater_exist) ? "fal fa-minus" : "fal fa-plus "  }}"></i>
    </span>
    <div class="share-box box-watchtrailer " onclick="live_watchlater(this)" style="top:41px">
        <div class="playbtn"  data-toggle="modal">  
            <span class="text" style="background-color: transparent; font-size: 14px; width:124px; height:21px">
            {{ !is_null($Livestream_details->watchlater_exist) ? "Remove from Watchlist" : "Add To Watchlist"  }}
            </span>
        </div>
    </div>
</li>


<!-- Like -->
<li>
    <span data-live-id={{ $Livestream_details->id }}  onclick="live_like(this)" >
        <i class="video-like {{ !is_null( $Livestream_details->Like_exist ) ? 'ri-thumb-up-fill' : 'ri-thumb-up-line'  }}"></i>
    </span>
</li>

<!-- Dislike -->
<li>
    <span data-live-id={{ $Livestream_details->id }}  onclick="live_dislike(this)" >
        <i class="video-dislike {{ !is_null( $Livestream_details->dislike_exist ) ? 'ri-thumb-down-fill' : 'ri-thumb-down-line'  }}"></i>
    </span>
</li>

@if( $Livestream_details->access != 'ppv' || ( !Auth::guest() && Auth::user()->role == "admin") ) 
    <!-- Copy Link  -->
    <li><a href="#" onclick="EmbedCopy();"  title="Embed Copy Link"><span><i class="ri-links-line mt-1"></i></span></a></li>

    <!-- Copy Link  -->
    <li><a href="#" onclick="Copy();"  title="Copy Link"><span><i class="ri-links-line mt-1"></i></span></a></li>
@endif

<script>

    function Copy() {   

        var media_path = '<?= $media_url ?>'; 
        var url = navigator.clipboard.writeText(window.location.href);
        var path = navigator.clipboard.writeText(media_path);

        $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
        
        setTimeout(function() {
            $('.add_watch').slideUp('fast');
        }, 3000);
    }

    function EmbedCopy() {

        var media_path = '<?= $embed_media_url ?>';
        var url = navigator.clipboard.writeText(window.location.href);
        var path = navigator.clipboard.writeText(media_path);

        $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
        
        setTimeout(function() {
            $('.add_watch').slideUp('fast');
        }, 3000);
    }

    function live_watchlater(ele) {
        
        let live_id = $(ele).data('live-id');

        $.ajax({
            url: '<?php echo route('videojs.live.watchlater') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                live_id: live_id,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.watchlater_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.watchlater_status == "Add" ? 'fal fa-minus' : 'fal fa-plus';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-watchlater').removeClass('fal fa-minus fal fa-plus').addClass(iconClass);

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });
    }

    function live_like(ele){
        
        let live_id = $(ele).data('live-id');

        $.ajax({
            url: '<?php echo route('videojs.live.like') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                live_id: live_id ,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.like_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.like_status == "Add" ? 'ri-thumb-up-fill' : 'ri-thumb-up-line';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-like').removeClass('ri-thumb-up-fill ri-thumb-up-line').addClass(iconClass);

                    $('.video-dislike').removeClass('ri-thumb-down-fill ri-thumb-down-line').addClass('ri-thumb-down-line');

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });
    }
    
    function live_dislike(ele){
        
        let live_id = $(ele).data('live-id');

        $.ajax({
            url: '<?php echo route('videojs.live.dislike') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                live_id: live_id ,
            },
            success: function(response) {

                if (response.data.status == true) {

                    const messageClass = response.data.dislike_status == "Add" ? 'alert-success' : 'alert-danger';

                    const iconClass = response.data.dislike_status == "Add" ? 'ri-thumb-down-fill' : 'ri-thumb-down-line';

                    const message_note = `<div id="message-note" class="alert ${messageClass} col-md-4" style="z-index: 999; position: fixed !important; right: 0;">${response.data.message}</div>`;
                        
                    $('.video-dislike').removeClass('ri-thumb-down-fill ri-thumb-down-line').addClass(iconClass);

                    $('.video-like').removeClass('ri-thumb-up-fill ri-thumb-up-line').addClass('ri-thumb-up-line');

                    $('#message-note').html(message_note).slideDown('fast');

                    setTimeout(function() {
                        $('#message-note').slideUp('fast');
                    }, 2000);
                }
            },
        });
    }
</script>