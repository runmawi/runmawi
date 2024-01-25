<?php 

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $watchlater_exist = App\Watchlater::where($watchlater_where_column, $source_id)

                                                        ->when( $watchlater_where_column == "video_id", function ($query) use($type) {
                                                            $query->where('type', $type);
                                                        })

                                                        ->where(function ($query) use ($geoip) {
                                                            if (!Auth::guest()) {
                                                                $query->where('user_id', Auth::user()->id);
                                                            } else {
                                                                $query->where('users_ip_address', $geoip->getIP());
                                                            }
                                                        })->first();

                                        
        $wishlist_exist = App\Wishlist::where($wishlist_where_column, $source_id)

                                        ->when($wishlist_where_column == "video_id", function ($query) use($type) {
                                            $query->where('type', $type);
                                        })

                                        ->where(function ($query) use ($geoip) {
                                            if (!Auth::guest()) {
                                                $query->where('user_id', Auth::user()->id);
                                            } else {
                                                $query->where('users_ip_address', $geoip->getIP());
                                            }
                                        })->first();

?>

<div class="block-social-info">
    <ul class="list-inline p-0 m-0 music-play-lists">
        
                <!-- Wishlist -->
        <li class="share">
            <span data-source_id={{ $source_id }}  data-type ="{{  $type }}" data-wherecolumn="{{ $wishlist_where_column }}"  onclick="video_wishlist(this)" >
                <i class="video-wishlist {{ !is_null( $wishlist_exist ) ? 'fa fa-heart' : 'fa fa-heart-o'  }}"></i>
            </span>
            <div class="share-box box-watchtrailer ">
                <div class="playbtn"  data-toggle="modal">  
                    <span class="text wishlist-tooltip-text" style="background-color: transparent; font-size: 14px; width:100%;"> {{ is_null( $wishlist_exist ) ? 'Add To Wishlist' : 'Remove from Wishlist'  }} </span>
                </div>
            </div>
        </li>

                    <!-- Watchlater -->
        <li class="share">
            <span  data-toggle="modal"  data-source_id={{ $source_id }}  data-type ="{{  $type }}"  data-wherecolumn="{{ $watchlater_where_column }}"  onclick="video_watchlater(this)" >
                <i class="video-watchlater {{ !is_null($watchlater_exist) ? "fal fa-minus" : "fal fa-plus "  }}"></i>
            </span>
            <div class="share-box box-watchtrailer">
                <div class="playbtn"  data-toggle="modal">  
                    <span class="text watchlater-tooltip-text" style="background-color: transparent; font-size: 14px; width:100%;"> {{ is_null( $watchlater_exist ) ? 'Add To Watchlater' : 'Remove from Watchlater'  }} </span>
                </div>
            </div>
        </li>
    </ul>
</div>

<script>
    function video_watchlater(ele) {
        
        let source_id     = $(ele).data('source_id');
        let where_column  = $(ele).data('wherecolumn');
        let type          = $(ele).data('type');

        $.ajax({
            url: '<?php echo route('home-page.watchlater') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                source_id: source_id,
                type : type ,
                where_column : where_column ,
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
        
        let source_id     = $(ele).data('source_id');
        let where_column  = $(ele).data('wherecolumn');
        let type          = $(ele).data('type');

        $.ajax({
            url: '<?php echo route('home-page.wishlist') ?>',
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                source_id: source_id,
                type : type ,
                where_column : where_column ,
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