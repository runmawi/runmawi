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
            <span data-source_id={{ $source_id }}  data-type ="{{  $type }}" data-wherecolumn="{{ $wishlist_where_column }}"  data-wishlist-unique-key="{{ $wishlist_where_column.'-'.$source_id }}" onclick="video_wishlist(this)" >
                <i class="video-wishlist {{ 'home-page-wishlist-'.$wishlist_where_column.'-'.$source_id }} {{ !is_null($wishlist_exist) ? 'ri-heart-fill' : 'ri-heart-line' }}"></i>
            </span>
           
        </li>
                    <!-- Watchlater -->
        <li class="share">
            <span  data-toggle="modal"  data-source_id={{ $source_id }}  data-type ="{{  $type }}"  data-wherecolumn="{{ $watchlater_where_column }}"  data-watchlater-unique-key = "{{ $watchlater_where_column.'-'.$source_id }}" onclick="video_watchlater(this)" >
                <i class="video-watchlater  {{ 'home-page-watchlater-'.$watchlater_where_column.'-'.$source_id }}  {{ !is_null($watchlater_exist) ? 'ri-subtract-line' : 'ri-add-line' }}"></i>
            </span>
        </li>
    </ul>
</div>