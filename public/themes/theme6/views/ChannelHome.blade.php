<!-- Header Start -->
<?php
include public_path('themes/theme6/views/header.php');

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
$order_settings_list = App\OrderHomeSetting::get();
$continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();
?>
<style>
    hr{
        border-top:none!important;
        height: 1px;
         background-image: linear-gradient(90deg, white, transparent);
    }
    .lkn{
        cursor: pointer;
    }
    .nav-tabs {border: 0;margin-top: 20px;text-align: center;}
    .channel_nav .nav-tabs>li {padding: 5px !important;}
    .nav-tabs .nav-item {
    margin-bottom: -2px;
    font-family: 'Roboto', sans-serif;
}
.channel_nav .nav-link.active {
    border-bottom: none !important;
    background-color: red !important;
    color: #fff !important;
}
.channel_nav .nav-link {
    padding: 5px 15px;
    background-color: #fff;
    border-bottom: none !important;
    border-radius: 5px;
    color: #000 !important;
    text-transform: capitalize;
}
.tab-pane .nav-link {
    margin: 5px;
    max-width: 175px;
    padding: 6px 15px;
    text-align: center;
}
.Live_Categorynav {
    display: flex;
}
</style>

<!-- Favicon -->
<link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script  src="<?= URL::to('/'). '/assets/js/plyr.polyfilled.js';?>"></script>
<script  src="<?= URL::to('/'). '/assets/js/hls.js';?>"></script>

@if(!empty($channel_partner->channel_banner) && $channel_partner->channel_banner != null)
<section class="channel-header"
    style="background:url('<?php echo @$channel_partner->channel_banner; ?>') no-repeat scroll 0 0;;background-size: cover;height:350px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
</section>
@else
<section class="channel-header"
    style="background:url('<?= URL::to('/') . '/public/uploads/images/' . $settings->default_horizontal_image ?>') no-repeat scroll 0 0;;background-size: cover;height:350px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
</section>
@endif
<div class="container">
    <div class="position-relative">
        <div class="channel-img">
            @if(!empty($channel_partner->channel_logo) && $channel_partner->channel_logo != null)
                <img src="<?php echo $channel_partner->channel_logo;  ?>"  class=" " width="150" alt="user">
            @else
                <img src="<?= URL::to('/') . '/public/uploads/images/' . $settings->default_video_image ?>"  class=" " width="150" alt="user">
            @endif
        </div>
    </div>
</div>

<section class="mt-5 mb-5">
    <div class="container">
        <div class="row ">
            <div class="col-2 col-lg-2">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    @php
                        include(public_path('themes/theme6/views/partials/channel-social-share.php'));
                    @endphp
                </ul>
            </div>
            @if(!empty(@$channel_partner) && $channel_partner->intro_video != null):
            <div class="col-2 col-lg-2">
            <a class="lkn" data-video="{{ @$channel_partner->intro_video }}" data-toggle="modal" data-target="#videoModal" data-backdrop="static" data-keyboard="false"  style="cursor: pointer;">	
                <span class="text-white">
                <i class="fa fa-play mr-1" aria-hidden="true"></i> About Channel Partner
                </span>
            </a>


            <div class="modal fade modal-xl" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog"  style='max-width: 800px;'>
                    <div class="modal-content" style="background-color: transparent;border:none;">
                    <button type="button" class="close" style='color:red;' data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                        <video id="videoPlayer1" 
                            controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                            type="video/mp4" src="{{ @$channel_partner->intro_video }}">
                        </video>
                    </div>
                </div>
                </div>
            </div>
      
        </div>
        @endif
            </div>
        </div>
    </div>
</section>
<section class="channel_nav">
   <div class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item Allnav">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All</a>
        </li>
        <li class="nav-item videonav">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Videos</a>
        </li>
        <li class="nav-item livenav">
            <a class="nav-link" id="live-tab" data-toggle="tab" href="#live" role="tab" aria-controls="live" aria-selected="false">Live Stream</a>
        </li>
        <li class="nav-item seriesnav">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Series</a>
        </li>
        <li class="nav-item audionav">
            <a class="nav-link" id="Audios-tab" data-toggle="tab" href="#Audios" role="tab" aria-controls="Audios" aria-selected="false">Audios</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="Video_Categorynav">
                @foreach ($VideoCategory as $key => $videos_category)
                    <div>
                        <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                           data-category-id="{{ $videos_category->id }}" onclick="Videos_Category(this)"
                           href="#pills-kids" role="tab" aria-controls="pills-kids"
                           aria-selected="false">{{ $videos_category->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="Series_Categorynav">
                @foreach ($SeriesGenre as $key => $series_category)
                    <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                       data-category-id="{{ $series_category->id }}" onclick="Series_Category(this)"
                       href="#pills-kids" role="tab" aria-controls="pills-kids"
                       aria-selected="false">{{ $series_category->name }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="Audios" role="tabpanel" aria-labelledby="Audios-tab">
            <div class="Audio_Categorynav d-flex">
                @foreach ($AudioCategory as $key => $audios_category)
                    <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                       data-category-id="{{ $audios_category->id }}" onclick="Audios_Category(this)"
                       href="#pills-kids" role="tab" aria-controls="pills-kids"
                       aria-selected="false">{{ $audios_category->name }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="live" role="tabpanel" aria-labelledby="live-tab">
            <div class="Live_Categorynav">
                @foreach ($LiveCategory as $key => $live_category)
                    <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                       data-category-id="{{ $live_category->id }}" onclick="Live_Category(this)"
                       href="#pills-kids" role="tab" aria-controls="pills-kids"
                       aria-selected="false">{{ $live_category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
   
</section>
<!--<section class="">
    <div class="sec-3">
        <div class="container-fluid mt-5">
            <div class="mt-3 ">
                <ul class="nav nav-pills   m-0 p-0" id="pills-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link " id="pills-profile-tab" data-toggle="pill" role="tab"
                            aria-controls="pills-profile" aria-selected="false">
                            All
                        </a>
                    </li>

                    <li class="nav-item videonav">
                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='video' data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Videos
                        </a>
<div class="position-relative">
                       
</div>
                    </li>
                        
                    <li class="nav-item ">

                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='live' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Live
                            Stream
                        </a>

                       

                    <li class="nav-item ">

                      
                       

                        &nbsp;&nbsp;
                    <li class="nav-item ">

                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='audio' data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Audios
                        </a>

                        <div class="Audio_Categorynav">
                            <?php foreach ($AudioCategory as $key => $audios_category) { ?>

                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                data-category-id=<?php echo $audios_category->id; ?> onclick="Audios_Category(this)"
                                href="#pills-kids" role="tab" aria-controls="pills-kids"
                                aria-selected="false"><?php echo $audios_category->name; ?></a>

                            <?php }  ?>
                        </div>
                    </li>
                     </ul>
            </div>
        </div>
    </div>

   
  
   
</section>-->

@php 

    $homepage_array_data = [ 'order_settings_list' => $order_settings_list, 
                                'multiple_compress_image' => $multiple_compress_image, 
                                'videos_expiry_date_status' => $videos_expiry_date_status,
                                'getfeching' => $getfeching,
                                'settings' => $settings,
                                'ThumbnailSetting' => $ThumbnailSetting,
                                'currency' => App\CurrencySetting::first(),
                                'default_vertical_image_url' => $default_vertical_image_url,
                                'default_horizontal_image_url' => $default_horizontal_image_url,
                            ];
@endphp

<div class='channel_home' >
     
    @forelse ($order_settings as $key => $item)
        
        @if( $item->video_name == 'latest_videos' && $home_settings->latest_videos == '1') {{-- latest videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-videos", array_merge($homepage_array_data, ['data' => $latest_video]) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'featured_videos' && $home_settings->featured_videos == 1 )     {{-- featured videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/trending-videoloop", array_merge($homepage_array_data, ['data' => $featured_videos]) )->content() !!} </div>
        @endif     


        
        @if(  $item->video_name == 'videoCategories' && $home_settings->videoCategories == 1 )     {{-- video Categories --}} 
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/videoCategories",  array_merge($homepage_array_data, ['data' => $genre_video_display]) )->content() !!}</div>
        @endif

        @if(  $item->video_name == 'artist' && $home_settings->artist == 1 )        {{-- Artist --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/artist-videos",  array_merge($homepage_array_data) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'series' && $home_settings->series == 1 )        {{-- series  --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-series", array_merge($homepage_array_data, ['data' => $latest_series]) )->content() !!} </div>
        @endif

        @if ( $item->video_name == 'series' && $home_settings->series == 1) {{-- latest-series  --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/featured-episodes", array_merge($homepage_array_data, ['data' => $featured_episodes]) )->content() !!} </div>
        @endif

        @if ( $item->video_name == 'series' && $home_settings->series == 1 ) {{-- featured-episodes  --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/Latest-episodes", array_merge($homepage_array_data, ['data' => $latest_episode]) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/live-videos", array_merge($homepage_array_data, ['data' => $livetream]) )->content() !!}</div>
        @endif
        
        @if(  $item->video_name == 'live_videos' && $home_settings->live_videos == 1 )             {{-- live Artist videos --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/live-videos", array_merge($homepage_array_data, ['data' => $artist_live_event]) )->content() !!}</div>
        @endif
        
        @if(  $item->video_name == 'liveCategories' && $home_settings->liveCategories == 1 )       {{-- Live Categories --}} 
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/liveCategories", array_merge($homepage_array_data, ['data' => $LiveCategory]) )->content() !!} </div>
        @endif

        @if(  $item->video_name == 'audios' && $home_settings->audios == 1 )        {{-- Audios --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-audios", array_merge($homepage_array_data, ['data' => $latest_audios]) )->content() !!}</div>
        @endif

        @if(  $item->video_name == 'albums' && $home_settings->albums == 1 )        {{-- Albums --}}
            <div> {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-albums", array_merge($homepage_array_data, ['data' => $albums]) )->content() !!}</div>
        @endif

        @if( $item->video_name == 'category_videos' && $home_settings->category_videos == 1 ) {{-- Videos Based on Category  --}}
            {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-videos-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

        @if(  $item->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1 ) {{-- series Based on Category  --}}
        {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-series-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

        @if(  $item->video_name == 'Audio_Genre_audios' && $home_settings->AudioGenre_audios == 1 ) {{-- Audios Based on Category  --}}
            {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/channel-Audios-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

        @if(  $item->video_name == 'live_category' && $home_settings->live_category == 1 ) {{-- LiveStream Based on Category  --}}
            {!! Theme::uses($current_theme)->load("public/themes/theme6/views/partials/home/channel-livestreams-based-categories", array_merge($homepage_array_data,['order_settings_list' => $order_settings_list,'channel_partner' => $channel_partner ]) )->content() !!}
        @endif

    @empty
    
        <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
            <h4 class="main-title mb-4 ">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
            <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
        </div>
    @endforelse
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
  const player = new Plyr('#videoPlayer1'); 

      $(document).ready(function(){
        $(".close").click(function(){
            $('#videoPlayer1')[0].pause();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.Video_Categorynav').hide();
        $('.Live_Categorynav').hide();
        $('.Series_Categorynav').hide();
        $('.Audio_Categorynav').hide();

        $('.videonav').click(function() {
            $('.Video_Categorynav').show();
            $('.Live_Categorynav').hide();
            $('.Series_Categorynav').hide();
            $('.Audio_Categorynav').hide();
        });
        $('.livenav').click(function() {
            $('.Video_Categorynav').hide();
            $('.Live_Categorynav').show();
            $('.Series_Categorynav').hide();
            $('.Audio_Categorynav').hide();
        });
        $('.seriesnav').click(function() {
            $('.Video_Categorynav').hide();
            $('.Live_Categorynav').hide();
            $('.Series_Categorynav').show();
            $('.Audio_Categorynav').hide();
        });
        $('.audionav').click(function() {
            $('.Video_Categorynav').hide();
            $('.Live_Categorynav').hide();
            $('.Series_Categorynav').hide();
            $('.Audio_Categorynav').show();
        });

        $('.Allnav').click(function() {
        //     $.ajax({
        //     type: "get",
        //     url: "<?php echo URL::to('/all_Channel_videos'); ?>",
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //         channel_slug:"{{ @$channel_partner->channel_slug }}",
        //     },
        //     success: function(data) {
        //         $(".channel_home").html(data);
        //     },
        // });
        location.reload();
        });

    });


    function Videos_Category(ele) {
        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "<?php echo URL::to('/channel_category_videos'); ?>",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$channel_partner->id }}",
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
    }

    function Series_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('channel_category_series') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$channel_partner->id }}",
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
    }

    function Audios_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('channel_category_audios') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$channel_partner->id }}",
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
        }

        function Live_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('channel_category_live') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$channel_partner->id }}",
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
        }
</script>



<?php
    include public_path('themes/theme6/views/footer.blade.php');
?>
