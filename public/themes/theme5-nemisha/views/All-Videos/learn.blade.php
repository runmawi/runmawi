<?php
    include public_path('themes/theme5-nemisha/views/header.php');
?>
<style>
    body{
        background-color: #fff!important;
    }
    h6{
        color: #000!important;
    }
     h4{
        color: #000!important;
    }
    h3{
        color: #000!important;
    }
    .favorites-slider .slick-arrow, #trending-slider-nav .slick-arrow{
        color: #000!important;
    }
    .s-bg-2:before{
        background-image:linear-gradient(to left, rgba(4,8,15,0)44%, rgb(191 194 198)69%, rgb(109 143 172))!important;
    }
</style>
<!-- Learn Series silder -->

<section id="home" class="iq-main-slider p-0">
    <div class="overflow-hidden ">
        <div id="home-slider" class="slider m-0 p-0">
            @if(isset($respond_data['series_sliders'])) 
                @foreach($respond_data['series_sliders'] as  $key => $series_sliders)

                    <div class="item <?php if($key == 0){echo 'active';}?> header-image">
                        <div onclick="window.location.href='<?php echo URL::to('/') ?><?= '/play_series'.'/'. $series_sliders->slug ?>';" class="slide slick-bg s-bg-2 lazy"
                                style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$series_sliders->player_image;?>'); background-repeat:no-repeat;background-size:cover;background-position:right;cursor: pointer; ">
                        <div class="container-fluid position-relative h-100">
                            <div class="slider-inner h-100">

                                <div class="row align-items-center bl h-100">
                                    <div class="col-xl-5 col-lg-12 col-md-12">
                                        <h1 class=" text-white title text-uppercase mb-3" >
                                           {{ ($series_sliders->title) }}
                                        </h1>

                                        <div class="">
                                        <img class="" src="<?php echo  URL::to('/assets/img/star.png')?>" />
                                        </div>

                                        <div 
                                            style="overflow: hidden !important;text-overflow: ellipsis !important; margin-bottom: 20px;color:#fff;display: -webkit-box;
                                                    -webkit-line-clamp: 3;  -webkit-box-orient: vertical; overflow: hidden;">
                                            <p> {{ ($series_sliders->description) }} </p>
                                        </div>


                                        <div class="justify r-mb-23  p-0" >    
                                            <a href="{{ URL::to('play_series/'.$series_sliders->slug) }}" class="btn bd">
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


@if(isset( $respond_data['series']  )) 
    @forelse( $respond_data['series']  as $key => $series_category)
        <section id="iq-favorites">
            <div class="fluid overflow-hidden">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title">
                                {{ $series_category->name }}
                            </h4>
                        </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                                @foreach (  $series_category['category_series'] as $key => $series)
                                    <li class="slide-item">
                                        <a href="{{ $series->redirect_url }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img loading="lazy"  data-original="{{ $series->image_url }}" class="img-fluid lazyload w-100">
                                                </div>
                                            </div>

                                            <div class="block-description">
                                                <div class="hover-buttons text-white">
                                                    <a class="" href="{{ $series->redirect_url }}"> 
                                                        <img class="ply" src="{{ URL::to('assets/img/default_play_buttons.svg') }}" />
                                                    </a>
                                                    <div></div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <div class="movie-time align-items-center justify-content-between my-2">

                                                    @if($respond_data['ThumbnailSetting']->title == 1)    <!-- Title -->
                                                        <a href="{{ URL::to('play_series/'. $series->slug) }}">
                                                            <h6>  {{ strlen($series->title) > 17 ? substr($series->title, 0, 18) . '...' : $series->title }} </h6>
                                                        </a>
                                                    @endif
                                                    
                                                    <div class="badge badge-secondary p-1 mr-2">          <!-- Season -->
                                                        {{ $series->season_count.' '.'Season' }}
                                                    </div>
                                
                                                    <div class="badge badge-secondary p-1 mr-2">         <!-- Episodes -->
                                                        {{ $series->Episode_count.' '.'Episodes' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="movie-time my-2">

                                                @if($respond_data['ThumbnailSetting']->duration == 1)     <!-- Duration -->
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{ gmdate('H:i:s', $series->duration) }}
                                                    </span>
                                                @endif

                                                @if($respond_data['ThumbnailSetting']->rating == 1 && $series->rating != null)   <!-- Rating -->
                                                    <span class="text-white">  
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                        {{ $series->rating }}
                                                    </span>
                                                @endif

                                                @if($respond_data['ThumbnailSetting']->featured == 1 && $series->featured == 1)  <!-- Featured -->
                                                    <span class="text-white">   
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @empty
        <div class="col-md-12 text-center mt-4" style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
            <h3 class="text-center">No Video Available</h3>
        </div>
    @endforelse
@endif


<?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>