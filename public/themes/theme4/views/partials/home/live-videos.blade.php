@if (!empty($data) && $data->isNotEmpty())
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid pl-0" id="home-live-videos-container">
            <div class="row">
                <div class="col-sm-12">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title mar-left"><a href="{{ $order_settings_list[3]->url ? URL::to($order_settings_list[3]->url) : null }} ">{{ optional($order_settings_list[3])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[3]->url ? URL::to($order_settings_list[3]->url) : null }} ">{{ 'View all' }}</a></h4>
                    </div>

                    <div class="channels-list">
                        <div class="channel-row">
                            <div id="trending-slider-nav" class="video-list live-stream-video flickity-slider">
                                @foreach ($data as $key => $livestream_videos)
                                    <div id="live-top-img" class="item" data-index="{{ $key }}" data-live-id="{{ $livestream_videos->id}}">
                                        <div>
                                            <img data-flickity-lazyload="{{ $livestream_videos->image ?  $BaseURL.('/images/'.$livestream_videos->image) : $default_vertical_image_url }}" class="flickity-lazyloaded" alt="{{$livestream_videos->title}}"  width="300" height="200">
                                            @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                                <div ><img class="blob lazy" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" width="100%"></div>
                                            @elseif( $livestream_videos->recurring_program_live_animation  == true )
                                                <div ><img class="blob lazy" src="public\themes\theme4\views\img\Live-Icon.webp" alt="livestream_videos" width="100%"></div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="videoInfo" class="live-stream-dropdown" style="display:none;">
                            <button class="drp-close">×</button>
                            <div class="vib" style="display:flex;">
                                @foreach ($data as $key => $livestream_videos )
                                    <div class="caption" data-index="{{ $key }}">
                                        <h2 class="caption-h2">{{ optional($livestream_videos)->title }}</h2>

                                        @if ($livestream_videos->publish_type == "publish_now" || ($livestream_videos->publish_type == "publish_later" && Carbon\Carbon::today()->now()->greaterThanOrEqualTo($livestream_videos->publish_time))) 
                                            
                                            <ul class="vod-info">
                                                <li><span></span> LIVE NOW</li>
                                            </ul>

                                        @elseif ($livestream_videos->publish_type == "publish_later")
                                            <span class="trending"> {{ 'Live Start On '. Carbon\Carbon::createFromFormat('Y-m-d\TH:i',$livestream_videos->publish_time)->format('j F Y g:ia') }} </span>

                                        @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program != "custom" )
                                                    
                                            @php
                                                switch ($livestream_videos->recurring_program_week_day) {

                                                    case 1 :
                                                        $recurring_program_week_day =  'Monday' ;
                                                    break;

                                                    case 2:
                                                        $recurring_program_week_day =  'Tuesday' ;
                                                    break;

                                                    case 3 :
                                                        $recurring_program_week_day = 'Wednesday' ;
                                                    break;

                                                    case 4:
                                                        $recurring_program_week_day =  'Thrusday' ;
                                                    break;

                                                    case 5:
                                                        $recurring_program_week_day =  'Friday' ;
                                                    break;

                                                    case 6:
                                                        $recurring_program_week_days =  'Saturday' ;
                                                    break;

                                                    case 7:
                                                        $recurring_program_week_day = 'Sunday' ;
                                                    break;

                                                    default:
                                                        $recurring_program_week_day =  null ;
                                                    break;
                                                }
                                            @endphp

                                            @if ( $livestream_videos->recurring_program == "daily")

                                                <span class="trending"> {{ 'Live Streaming Starts daily from '. Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
                                                
                                            @elseif( $livestream_videos->recurring_program == "weekly" )
                                                
                                                <span class="trending"> {{ 'Live Streaming Starts On Every '. $livestream_videos->recurring_program . " " . $recurring_program_week_day . $livestream_videos->recurring_program_month_day ." from ". Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>

                                            @elseif( $livestream_videos->recurring_program == "monthly" )
                                                
                                                <span class="trending"> {{ 'Live Streaming Starts On Every '. $livestream_videos->recurring_program . " " . $livestream_videos->recurring_program_month_day ." from ". Carbon\Carbon::parse($livestream_videos->program_start_time)->isoFormat('h:mm A') ." to ". Carbon\Carbon::parse($livestream_videos->program_end_time)->isoFormat('h:mm A') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>

                                            @endif


                                        @elseif ( $livestream_videos->publish_type == "recurring_program" && $livestream_videos->recurring_program == "custom" )
                                            <span class="trending"> {{ 'Live Streaming On '. Carbon\Carbon::parse($livestream_videos->custom_start_program_time)->format('j F Y g:ia') . ' - ' . App\TimeZone::where('id', $livestream_videos->recurring_timezone)->pluck('time_zone')->first() }} </span>
                                        @endif

                                        <div class="d-flex align-items-center p-0 mt-3">
                                            <img id="live-drop-img-{{$livestream_videos->id}}" class="live-2img" style="height: 30%; width:30%" > 
                                        </div>

                                        <div class="trending-dec">{{ html_entity_decode(strip_tags($livestream_videos->description), ENT_QUOTES) }}</div>

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('live/'.$livestream_videos->slug) }}" class="button-groups btn btn-hover mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a href="#" id="data-modal-live" class="button-groups btn btn-hover mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="#Home-LiveStream-videos-Modal" data-live-id="{{ $livestream_videos->id}}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumbnail" data-index="{{ $key }}">
                                        <img id="live_player_img-{{ $livestream_videos->id }}" class="flickity-lazyloaded" alt="{{ $livestream_videos->title }}" width="300" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


            <div class="modal fade info_model" id="Home-LiveStream-videos-Modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none; background:transparent;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  id="live_modal_img" alt="modal">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="modal-title caption-h2"></h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                                <div class="modal-desc trending-dec mt-4"></div>

                                            <a href="" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
@endif



<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Initialize Flickity
    const elem = document.querySelector('.live-stream-video');
    if (elem) {
        const flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: false,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyLoad: 7
        });
        flkty.reloadCells();

        // Add click event listener to items
        document.querySelectorAll('.live-stream-video .item').forEach(item => {
            item.addEventListener('click', function () {
                // Remove 'current' class from all items
                document.querySelectorAll('.live-stream-video .item').forEach(item => {
                    item.classList.remove('current');
                });
                // Add 'current' class to the clicked item
                this.classList.add('current');

                // Get the data index of the clicked item
                const index = this.getAttribute('data-index');

                // Hide all captions and thumbnails
                document.querySelectorAll('.live-stream-dropdown .caption').forEach(caption => {
                    caption.style.display = 'none';
                });
                document.querySelectorAll('.live-stream-dropdown .thumbnail').forEach(thumbnail => {
                    thumbnail.style.display = 'none';
                });

                // Show the corresponding caption and thumbnail
                const selectedCaption = document.querySelector(`.live-stream-dropdown .caption[data-index="${index}"]`);
                const selectedThumbnail = document.querySelector(`.live-stream-dropdown .thumbnail[data-index="${index}"]`);
                if (selectedCaption) selectedCaption.style.display = 'block';
                if (selectedThumbnail) selectedThumbnail.style.display = 'block';

                // Show the dropdown
                const dropdown = document.querySelector('.live-stream-dropdown');
                if (dropdown) dropdown.style.display = 'flex';
            });
        });
    }

    // Handle dropdown close button
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('drp-close')) {
            const dropdown = document.querySelector('.live-stream-dropdown');
            if (dropdown) dropdown.style.display = 'none';
        }
    });
});

</script>

<script>
    $(document).on('click', '#live-top-img', function () {
        const liveId = $(this).data('live-id');
        // console.log("liveId: " + liveId);

        $.ajax({
            url: '{{ route("getLiveDropImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                live_id: liveId
            },
            success: function (response) {
                // console.log('live img: ' + response.live_images);

                $('#live_player_img-' + liveId).attr('src', response.live_images);
                $('#live-drop-img-' + liveId).attr('src', response.live_images);
                $('#live-drop-img-' + liveId).css("height", "30%");
                $('#live-drop-img-' + liveId).css("width", "30%");
              
            },
            error: function () {
                console.log('Failed to load images. Please try again.');
            }
        });
    });
</script>

<script>
    $(document).on('click', '#data-modal-live', function() {
        const LiveId = $(this).data('live-id');
        // console.log("modal opened.");
        $.ajax({
            url: '{{ route("getLiveModal") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                live_id : LiveId
            },
            success: function (response) {
                // console.log("image: " + response.image);
                // console.log("title: " + response.title);
                // console.log("description: " + response.description);
                const slug = 'live/' + response.slug;
                // console.log("slug: " + slug);
                $('#live_modal_img').attr('src', response.image);
                $('.modal-title').text(response.title);
                $('.modal-desc').text(response.description);
                $('.btn.btn-hover').attr('href', slug);
                

            },
            error: function () {
                console.log('Failed to load images. Please try again.');
            }
        });

        $('.btn-close-white').on('click', function () {
            $('#live_modal_img').attr('src', '');
            $('.modal-title').text('');
            $('.modal-desc').text('');
            $('.btn.btn-hover').attr('href', '');
        });


    });
</script>



<!-- /* pulsing animation */ -->
<style>
.blob {
    margin: 10px;
    width: 59px !important;
    aspect-ratio: 59 / 22;
    height: auto !important;
    border-radius: 25px;
    box-shadow: 0 0 0 0 rgba(255, 0, 0, 1);
    transform: scale(1);
    animation: pulse 2s infinite;
    position: absolute;
    top: 0;
    opacity: 1 !important;
}
.live-2img{width: 200px;height: 100px;}

@keyframes pulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
    }
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
    }
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
    }
}

</style>