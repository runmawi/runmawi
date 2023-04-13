<?php
    include public_path('themes/theme5-nemisha/views/header.php');
?>

<!-- Learn Series silder -->

<section id="home" class="iq-main-slider p-0">
    <div class="overflow-hidden ">
        <div id="home-slider" class="slider m-0 p-0">
            @if(isset($respond_data['learn_series_sliders'])) 
                @foreach($respond_data['learn_series_sliders'] as  $key => $learn_series_sliders)

                    <div class="item <?php if($key == 0){echo 'active';}?> header-image">
                        <div onclick="window.location.href='<?php echo URL::to('/') ?><?= '/play_series'.'/'. $learn_series_sliders->slug ?>';" class="slide slick-bg s-bg-2 lazy"
                                style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$learn_series_sliders->player_image;?>'); background-repeat:no-repeat;background-size:cover;background-position:right;cursor: pointer; ">
                        <div class="container-fluid position-relative h-100">
                            <div class="slider-inner h-100">

                                <div class="row align-items-center bl h-100">
                                    <div class="col-xl-5 col-lg-12 col-md-12">
                                        <h1 class=" text-white title text-uppercase mb-3" >
                                            <?php echo __($learn_series_sliders->title); ?>
                                        </h1>

                                        <div class="mb-3">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>

                                        <div 
                                            style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                                    -webkit-line-clamp: 3;  -webkit-box-orient: vertical; overflow: hidden;">
                                            <p><?php echo __($learn_series_sliders->description); ?></p>
                                        </div>


                                        <div class="justify r-mb-23  p-0" >    
                                            <a href="<?php echo URL::to('/') ?><?= '/play_series'.'/'. $learn_series_sliders->slug ?>" class="btn bd">
                                                <i class="fa fa-play mr-2" aria-hidden="true"></i> Start Watching
                                            </a>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xl-4 col-lg-12 col-md-12 mt-5 pt-5 b2">  </div>
                                    <div class="col-xl-4 col-lg-12 col-md-12 text-center">   </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                
                @endforeach 
            @endif
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
                fill="none" stroke="currentColor">
                <circle r="20" cy="22" cx="22" id="test"></circle>
            </symbol>
        </svg>
    </div>
</section>


<!-- MainContent -->
<section id="iq-favorites">
    @if (isset($respond_data['videos']) && count($respond_data['videos']) > 0)

        {{-- <h3 class="vid-title text-center mt-4 mb-5">Latest Videos</h3> --}}

        <div class="container-fluid"
            style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
            <div class="row">

                <div class="col-sm-12 page-height">
                    <div class="iq-main-header align-items-center justify-content-between">

                    </div>
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if (isset($respond_data['videos']))

                                @foreach ($respond_data['videos'] as $key => $video)
                             
                                    <li class="slide-item col-sm-3 col-md-3 col-xs-12">
                                        <a href="{{  URL::to('episode/'.$video->series_slug.'/'.$video->slug ) }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy"
                                                        data-src="{{ URL::to('public/uploads/images/' . $video->image) }}"
                                                        class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                                                    <div class="hover-buttons">
                                                        <a href="{{  URL::to('episode/'.$video->series_slug.'/'.$video->slug ) }}">
                                                            <img class="ply"
                                                                src="{{ URL::to('assets/img/play.svg') }} ">
                                                        </a>
                                                        <div>
                                                            <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist</a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>

                                                <div class="mt-2 d-flex justify-content-between p-0">
                                                    @if ($respond_data['ThumbnailSetting']->title == 1)
                                                        <h6>{{ strlen($video->title) > 17 ? substr($video->title, 0, 18) . '...' : $video->title }}
                                                        </h6>
                                                    @endif

                                                    @if ($respond_data['ThumbnailSetting']->age == 1)
                                                        <div class="badge badge-secondary">
                                                            {{ $video->age_restrict . ' ' . '+' }}
                                                        </div>
                                                    @endif
                                                </div>


                                                <div class="movie-time my-2">

                                                    <!-- Duration -->

                                                    @if ($respond_data['ThumbnailSetting']->duration == 1)
                                                        <span class="text-white">
                                                            <i class="fa fa-clock-o"></i>
                                                            <?= gmdate('H:i:s', $video->duration) ?>
                                                        </span>
                                                    @endif

                                                    <!-- Rating -->

                                                    @if ($respond_data['ThumbnailSetting']->rating == 1 && $video->rating != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            <?php echo __($video->rating); ?>
                                                        </span>
                                                    @endif

                                                    @if ($respond_data['ThumbnailSetting']->featured == 1 && $video->featured == 1)
                                                        <!-- Featured -->
                                                        <span class="text-white">
                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="movie-time my-2">
                                                    <!-- published_year -->
                                                    @if ($respond_data['ThumbnailSetting']->published_year == 1 && $video->year != null)
                                                        <span class="text-white">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <?php echo __($video->year); ?>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="col-md-12 pagination justify-content-end">
                            {!! $respond_data['videos']->links() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 text-center mt-4"
            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
            <p>
            <h3 class="text-center">No Video Available</h3>
        </div>
    @endif

    <?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>
