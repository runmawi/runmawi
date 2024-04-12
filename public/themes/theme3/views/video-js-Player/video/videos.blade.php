@php
    include public_path('themes/theme3/views/header.php'); 
@endphp


{{-- video-js Style --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/1.11.0/videojs.ima.css" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-hls-quality-selector@1.1.4/dist/videojs-hls-quality-selector.min.css" rel="stylesheet">
    <link href="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme3/assets/css/video-js/videos-player.css') }}" rel="stylesheet" >
    <link href="{{ asset('public/themes/theme3/assets/css/video-js/video-end-card.css') }}" rel="stylesheet" >
    <link href="{{ URL::to('node_modules\@filmgardi\videojs-skip-button\dist\videojs-skip-button.css') }}" rel="stylesheet" >

{{-- video-js Script --}}

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/video.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-contrib-quality-levels.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-http-source-selector.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs.ads.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs.ima.min.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/videojs-hls-quality-selector.min.js') }}"></script>
    <script src="{{ URL::to('node_modules/videojs-settings-menu/dist/videojs-settings-menu.js') }}"></script>
    <script src="{{ asset('public/themes/theme3/assets/js/video-js/end-card.js') }}"></script>
    <script src="{{ URL::to('node_modules/@filmgardi/videojs-skip-button/dist/videojs-skip-button.min.js') }}"></script>

    <div class="container-fluid p-0">

        @if ( $videodetail->type == "embed" )

            <iframe class="responsive-iframe" src="<?= $videodetail->videos_url ?>" poster="<?= $videodetail->player_image_url ?>"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else

            <button class="staticback-btn" onclick="history.back()" title="Back Button">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </button>

            <video id="my-video" class="video-js vjs-theme-fantasy vjs-icon-hd vjs-layout-x-large" controls 
                    preload="auto" width="auto" height="auto" poster="{{ $videodetail->player_image_url }}" playsinline="playsinline"
                    muted="muted" preload="yes" autoplay="autoplay"  >
                <source src="{{ $videodetail->videos_url }}" type="{{ $videodetail->video_player_type }}">
            </video>
        @endif
    </div>

    <section>
        <div class="container-fluid video-details">
             <!-- BREADCRUMBS -->
            <!-- <div class="col-sm-12 col-md-12 col-xs-12 p-0">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="bc-icons-2">
                            
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="trending-info g-border p-0">
                <h1 class="text-white mb-3">{{ \Illuminate\Support\Str::limit($videodetail->title,50) }}</h1>
                <!-- Year, Running time, Age -->
                <?php
                    if (!empty($videodetail->duration)) {
                        $seconds = $videodetail->duration;
                        $H = floor($seconds / 3600);
                        $i = ($seconds / 60) % 60;
                        $s = $seconds % 60;
                        $time = sprintf('%02dh %02dm', $H, $i);
                    } else {
                        $time = 'Not Defined';
                    }
                    //  dd($time);
                ?>
                <div class="d-flex align-items-center text-white text-detail">
                    <?php if (!empty($time)) { ?><span class=""><?php echo $time; ?></span><?php } ?>
                    <?php if (!empty($videodetail->year)) { ?>
                        <span class="trending-year">
                            <?php if ($videodetail->year == 0) {
                            echo '';
                            } else {
                                echo $videodetail->year;
                            } ?>
                        </span>
                    <?php } ?>
                </div>

                
            </div>

            <div class="">
                <div class="col-md-7 p-0" style="margin-top: 2%;">

                    @if (!empty($videodetail->description))
                        <h4>Description</h4>
                    @endif

                    <div class="text-white">

                        <!-- Description -->
                        @if (!empty($videodetail->description))
                            <p class="trending-dec w-100 mb-0 text-white mt-2 text-justify">
                                <?php echo __($videodetail->description); ?>
                            </p>
                        @endif

                        <!-- Artists -->
                        @if ($setting->show_artist == 1 && !$videodetail->artists->isEmpty() ) {{-- Artists --}}
                            <div class="sectionArtists">   
                                <div class="artistHeading">Top Cast</div>
                                <div class="listItems">
                                    @foreach ( $videodetail->artists as $item )
                                        <a href="{{ route('artist',[ $item->artist_slug ])}}">
                                            <div class="listItem">
                                                <div class="profileImg">
                                                    <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                                        <img  src="{{ URL::to('public/uploads/artists/'. $item->image ) }}" />
                                                    </span>
                                                </div>
                                                <div class="name">{{ $item->artist_name }}</div>
                                                <div class="character">{{ str_replace('_', ' ', $item->artist_type) }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Genres -->
                        <?php if ($settings->show_genre == 1): ?>
                            <p class="trending-dec w-100 mb-0 text-white mt-2">Genres :
                                <?php
                                $numItems = count($category_name);
                                $i = 0;

                                foreach ($category_name as $key => $cat_name) { ?>
                                    <a
                                        href="<?php echo URL::to('/category' . '/' . $cat_name->categories_slug); ?>">
                                        <span class="sta">
                                            <?php echo $cat_name->categories_name;
                                            if (++$i === $numItems) {
                                                echo '';
                                            } else {
                                                echo ',';
                                            } ?>
                                        </span>
                                    </a>
                                <?php } ?>
                            </p>
                        <?php endif; ?>

                        <!-- Languages -->
                        @if ( $setting->show_languages == 1 &&  !$videodetail->Language->isEmpty())   {{-- Languages --}}
                            <div class="info">      
                                <span classname="text bold"> Languages:&nbsp;</span> 
                                @foreach( $videodetail->Language as $item )
                                    <span class="text">
                                        <span><a href="{{ URL::to('language/'. $item->language_id . '/' . $item->name ) }} "> {{ $item->name }} </a>   </span>
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- subtitles -->
                        <?php if ($settings->show_subtitle == 1): ?>
                            <p class="trending-dec w-100 mb-0 text-white mt-2">Subtitles :
                                <?php echo $subtitles_name; ?>
                            </p>
                        <?php endif; ?>

                    </div>
                </div>
                <br>
            </div>
        </div>
    </section>
@php 

    include public_path('themes/theme3/views/video-js-Player/video/videos_script_file.blade.php');
    include public_path('themes/theme3/views/video-js-Player/video/videos_ads.blade.php');
    include public_path('themes/theme3/views/video-js-Player/video/player_script.blade.php');
    include public_path('themes/theme3/views/footer.blade.php'); 

@endphp

<style>
    #my-video_ima-ad-container div{ overflow:hidden;}
    #my-video{ position:relative; }
    .staticback-btn{display:none;}
    .container-fluid:hover .staticback-btn{ display: inline-block; position: absolute; background: transparent; z-index: 1;  top: 5%; left:1%; color: white; border: none; cursor: pointer; }
</style>