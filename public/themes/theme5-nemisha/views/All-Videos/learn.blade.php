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

                                        <div class="">
                                        <img class="" src="<?php echo  URL::to('/assets/img/star.png')?>" />
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


<!-- Education Episode videos -->

@if(isset( $respond_data['Episode_videos']  )) 
    <section id="iq-favorites">
        <div class="fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12">

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">
                            {{ 'Education' }}
                        </h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">

                            @if(isset( $respond_data['Episode_videos']  )) 
                                @foreach( $respond_data['Episode_videos']  as $key => $Episode_video)

                                    <li class="slide-item">
                                        <a href="<?= URL::to('/episode' . '/' . $Episode_video->series_slug . '/' . $Episode_video->episode_slug); ?>">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy" data-src="{{ URL::to('public/uploads/images/'.$Episode_video->image) }} " class="img-fluid lazyload w-100">
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <div class="hover-buttons text-white">
                                                    <a class="" href="{{ URL::to('episode/' . $Episode_video->series_slug . '/' . $Episode_video->episode_slug) }}"> 
                                                        <img class="ply" src="{{ URL::to('assets/img/default_play_buttons.svg') }}" />
                                                    </a>
                                                    <div></div>
                                                </div>
                                            </div>

                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                @if($respond_data['ThumbnailSetting']->title == 1) 
                                                    <h6>  {{ strlen($Episode_video->title) > 17 ? substr($Episode_video->title, 0, 18) . '...' : $Episode_video->title }} </h6>
                                                @endif

                                                @if($respond_data['ThumbnailSetting']->age == 1) 
                                                    <div class="badge badge-secondary">{{ $Episode_video->age_restrict . ' ' . '+' }}</div>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">

                                                @if($respond_data['ThumbnailSetting']->duration == 1)     <!-- Duration -->
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $Episode_video->duration) }}
                                                    </span>
                                                @endif

                                                @if($respond_data['ThumbnailSetting']->rating == 1 && $Episode_video->rating != null)   <!-- Rating -->
                                                    <span class="text-white">  
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ ($Episode_video->rating) }}
                                                    </span>
                                                @endif

                                                @if($respond_data['ThumbnailSetting']->featured == 1 && $Episode_video->featured == 1)  <!-- Featured -->
                                                    <span class="text-white">   
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


<?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>