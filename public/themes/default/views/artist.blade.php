@php
    include(public_path('themes/default/views/header.php'));
    $ThumbnailSetting = App\ThumbnailSetting::first();
    $currency = App\CurrencySetting::first();
@endphp
<style>
    .main-title{
        padding-bottom: 0px!important;
    }
    #removefollow{
        color: #ff4444;
    }
    #follow{
         color: #007E33;
    }
    .abu h2{
        color: #fff!important;
    }
    body.light-theme .share-box a{color:<?php echo $GetLightText; ?> !important;}
</style>

<!--<div class="aud" style="background-image:url(<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>)">
        <h2 class="font-weight-bold"><?php echo $artist->artist_name;?></h2>
        <!-- <p>8,239,0056 Monthly viewers</p>
    </div> -->
    
    <div class="mt-5 container-fluid">
        <div class="row justify-content-between  align-items-center">
            <div class="col-md-3">
                <img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>" alt=""  class="w-100">
            </div>
            <div class=" col-md-9 abu p-0">
                <h2><?php echo __('About');?></h2>
                <p><?php echo $artist->description;?></p>
                <div class=" mt-3 mb-5">
                     
        <div class="d-flex align-items-center">
            <div>
           
                <!-- <i  class="fa fa-play-circle-o" aria-hidden="true" style="color:#fff!important;"></i> -->
            </div>

            @if(Auth::user() !== null)
            <div class="flw mr-3" id="follow-container" data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    title="{{ $artist_following == 0 ? 'Add to Following' : 'Remove from Following' }}">
                    <i class="fa {{ $artist_following == 0 ? 'fa-user-plus' : 'fa-user' }}" id="follow-icon" aria-hidden="true"></i>
                </div>
            @else
                <div class="flw" id="sign-in-prompt">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span>Please Sign In to Follow</span>
                </div>
            @endif

            <!-- Notification message -->
            <div id="follow-message" style="display: none; z-index: 100; position: fixed; top: 73px; right: 0; transform: translateX(-7%); text-align: center; padding: 11px; color: white; font-size: 14px; border-radius: 5px;">
            </div>


            <div class="flw">
                <!-- <i class="fa fa-share-square-o" aria-hidden="true" style="color:#fff!important;"></i> -->
                <?php $media_url = URL::to('/').'/artist/'.$artist->artist_slug; ?>
                <input type="hidden" value="<?= $media_url ?>" id="media_url">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                <li class="share">
                    <span><i class="ri-share-fill"></i></span>
                        <div class="share-box">
                        <div class="d-flex align-items-center"> 
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>
                            <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a>
                            <a href="#"onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
                        </div>
                    </div>
                </li>
                 </ul>

            </div>
        </div>
    </div>
            </div>
        </div>
    </div>

                <!-- Latest Videos -->

        <?php if(count($latest_audios) > 0) { ?>

            <div class="container-fluid mt-3">
                <h4 class="main-title"><?php echo __('Latest Release');?></h4>
            </div>

            <div class="container-fluid mt-2">
                <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            <?php foreach ($latest_audios as $key => $latest_audio) {  ?>
                        <li class="slide-item">
                                <a href="<?php echo URL::to('/').'/audio/'.$latest_audio[0]['slug'];?>">
                                <div class="block-images position-relative">
                                <!-- block-images -->
                                    <div class="img-box">
                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_audio[0]['image'];?>" alt="" class="img-fluid loading w-100">

                                        
                                    </div>
                                

                                    <div class="block-description">
                                    
                                    
                                    <div class="hover-buttons text-white">
                                            <a href="<?php echo URL::to('/').'/audio/'.$latest_audio[0]['slug'];?>">
                                            <h6 class="dc"><?php echo $latest_audio[0]['title'];?></h6>
                                <p><?php echo $latest_audio[0]['year'];?></p>
                                            </a>
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
        <?php } ?>

          <!-- Album Videos -->

        <?php if(count($albums) > 0) { ?>

            <div class="container-fluid mt-3">
                <h4 class="main-title"><?php echo __('Album');?></h4>
            </div>

            <div class="container-fluid mt-2">
                <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                            <?php foreach ($albums as $key => $album) { ?>
                            <li class="slide-item">
                                <a href="<?php echo URL::to('/').'/album/'.$album->slug;?>">
                                    <div class="block-images position-relative">
                                    <!-- block-images -->
                                        <div class="img-box">
                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" alt="" class="img-fluid loading w-100">

                                            
                                        </div>
                                    

                                        <div class="block-description">
                                        
                                        
                                        <div class="hover-buttons text-white">
                                                <a href="<?php echo URL::to('/').'/album/'.$album->slug;?>">
                                                    <h6 class=""><?php echo $album->albumname;?></h6>
                                                </a>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
                            </ul>
                        </div>
            </div>

        <?php } ?>
  
             <!-- Artist Audios -->

        <?php if(count($artist_audios) > 0) { ?>
            <div class="container-fluid mt-3">
                <h4 class="main-title"><?php echo __('Audio');?></h4>
            </div>

            <div class="container-fluid mt-2">
                <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                <?php  foreach ($artist_audios as $key => $artist_audio) { ?>
                            <li class="slide-item">
                                <a href="<?php echo URL::to('/').'/audio/'.$artist_audio->slug;?>">
                                    <div class="block-images position-relative">
                                    <!-- block-images -->
                                        <div class="img-box">
                                        <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_audio->image;?>" alt="" class="img-fluid loading w-100">

                                            
                                        </div>
                                    

                                        <div class="block-description">
                                        
                                        
                                        <div class="hover-buttons text-white">
                                                <a href="<?php echo URL::to('/').'/audio/'.$artist_audio->slug;?>">
                                                    <h6 class="dc"><?php echo $artist_audio->title;?></h6>
                                    <p><?php echo $artist_audio->year;?></p>
                                                </a>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
                            </ul>
                </div>
            </div>
        <?php } ?>

            <!-- Artist Series -->

            @if(count($artist_series) > 0)

                <div class="container-fluid mt-3">
                    <h4 class="main-title">{{ __('Series') }}</h4>
                </div>
            
                <div class="container-fluid mt-2">
                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline row p-0 mb-0">
                            @foreach ($artist_series as $artist_series)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <!-- block-images -->
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('/play_series/' . $artist_series->slug) }}">
                                                    <img class="img-fluid w-100 flickity-lazyloaded" src="{{ $artist_series->image ? URL::to('/public/uploads/images/' . $artist_series->image) : $default_vertical_image_url }}"  alt="{{ $artist_series->title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons text-white"> 
                                                <a class="text-white" href="{{ URL::to('/play_series/' . $artist_series->slug) }}">
                                                    <p class="epi-name text-left m-0 mt-2">{{ __($artist_series->title) }}</p>
                                                      <p class="desc-name text-left m-0 mt-1">
                                                          {{ strlen($artist_series->description) > 75 ? substr(html_entity_decode(strip_tags($artist_series->description)), 0, 75) . '...' : strip_tags($artist_series->description) }}
                                                      </p>
                                                      <div class="movie-time d-flex align-items-center my-2">

                                                          @if($ThumbnailSetting->age == 1 && !($artist_series->age_restrict == 0))
                                                              <span class="position-relative badge p-1 mr-2">{{ $artist_series->age_restrict}}</span>
                                                          @endif
                                                          @if($ThumbnailSetting->published_year == 1 && !($artist_series->year == 0))
                                                              <span class="position-relative badge p-1 mr-2">
                                                                  {{ __($artist_series->year) }}
                                                              </span>
                                                          @endif
                                                          @if($ThumbnailSetting->featured == 1 && $artist_series->featured == 1)
                                                              <span class="position-relative text-white">
                                                                  {{ __('Featured') }}
                                                              </span>
                                                          @endif
                                                      </div>

                                                      <div class="movie-time d-flex align-items-center my-2">
                                                          <span class="position-relative badge p-1 mr-2">
                                                              @php 
                                                                  $SeriesSeason = App\SeriesSeason::where('series_id', $artist_series->id)->count(); 
                                                                  echo $SeriesSeason . ' Season';
                                                              @endphp
                                                          </span>
                                                          <span class="position-relative badge p-1 mr-2">
                                                              @php 
                                                                  $Episode = App\Episode::where('series_id', $artist_series->id)->count(); 
                                                                  echo $Episode . ' Episodes';
                                                              @endphp
                                                          </span>
                                                        <!--<span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $artist_series->duration) }}</span>-->
                                                    </div>
                                                </a>
                                                <a class="epi-name mt-2 mb-0 btn" href="{{ URL::to('/play_series/' . $artist_series->slug) }}">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Series') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            
            @endif
        

          <!-- Artist videos -->

        @if(count($artist_videos) > 0)

            <div class="container-fluid mt-3">
                <h4 class="main-title">{{ __('Videos') }}</h4>
            </div>
        
            <div class="container-fluid mt-2">
                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline row p-0 mb-0">
                        @foreach ($artist_videos as $artist_video)
                            <li class="slide-item">
                                <div class="block-images position-relative">
                                    <div class="border-bg">
                                        <div class="img-box">
                                            <a class="playTrailer" href="{{ url('category/videos/' . $artist_video->slug) }}" aria-label="Movie">
                                                <img class="img-fluid w-100 flickity-lazyloaded" src="{{ url('public/uploads/images/' . $artist_video->image) }}" alt="{{ $artist_video->title}}">
                                            </a>
                                            <!-- PPV price -->
                                            @if($ThumbnailSetting->free_or_cost_label == 1)
                                                @if($artist_video->access == 'subscriber')
                                                    <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                                @elseif($artist_video->access == 'registered')
                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                @elseif(!empty($artist_video->ppv_price))
                                                    <p class="p-tag">{{ $currency->symbol . ' ' . $artist_video->ppv_price }}</p>
                                                @elseif(!empty($artist_video->global_ppv) && $artist_video->ppv_price == null)
                                                    <p class="p-tag">{{ $artist_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                @elseif($artist_video->global_ppv == null && $artist_video->ppv_price == null)
                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="block-description">
                                        <a class="playTrailer" href="{{ url('category/videos/' . $artist_video->slug) }}" aria-label="Movie">
                                        <!-- PPV price -->
                                        @if($ThumbnailSetting->free_or_cost_label == 1)
                                                @if($artist_video->access == 'subscriber')
                                                    <p class="p-tag"><i class="fas fa-crown" style='color:gold'></i></p>
                                                @elseif($artist_video->access == 'registered')
                                                    <p class="p-tag">{{ __('Register Now') }}</p>
                                                @elseif(!empty($artist_video->ppv_price))
                                                    <p class="p-tag">{{ $currency->symbol . ' ' . $artist_video->ppv_price }}</p>
                                                @elseif(!empty($artist_video->global_ppv) && $artist_video->ppv_price == null)
                                                    <p class="p-tag">{{ $artist_video->global_ppv . ' ' . $currency->symbol }}</p>
                                                @elseif($artist_video->global_ppv == null && $artist_video->ppv_price == null)
                                                    <p class="p-tag">{{ __('Free') }}</p>
                                                @endif
                                        @endif
                                        </a>
                                        <div class="hover-buttons text-white">
                                        <a href="{{ url('category/videos/' . $artist_video->slug) }}" aria-label="movie">
                                                @if($ThumbnailSetting->title == 1)
                                                    <!-- Title -->
                                                    <p class="epi-name text-left mt-2 m-0">
                                                    {{ strlen($artist_video->title) > 17 ? substr($artist_video->title, 0, 18) . '...' : $artist_video->title }}
                                                    </p>
                                                @endif
                                                <p class="desc-name text-left m-0 mt-1">
                                                    {{ strlen($artist_video->description) > 75 ? substr(html_entity_decode(strip_tags($artist_video->description)), 0, 75) . '...' : strip_tags($artist_video->description) }}
                                                </p>
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    @if($ThumbnailSetting->age == 1 && !($artist_video->age_restrict == 0))
                                                    <!-- Age -->
                                                    <span class="position-relative badge p-1 mr-2">{{ $artist_video->age_restrict }}</span>
                                                    @endif
                                                    @if($ThumbnailSetting->duration == 1)
                                                    <span class="position-relative text-white mr-2">
                                                    {{ (floor($artist_video->duration / 3600) > 0 ? floor($artist_video->duration / 3600) . 'h ' : '') . floor(($artist_video->duration % 3600) / 60) . 'm' }}
                                                </span>
                                                    @endif

                                                    @if($ThumbnailSetting->published_year == 1 && !($artist_video->year == 0))
                                                    <span class="position-relative badge p-1 mr-2">
                                                            {{ __($artist_video->year) }}
                                                    </span>
                                                    @endif
                                                    @if($ThumbnailSetting->featured == 1 && $artist_video->featured == 1)
                                                    <span class="position-relative text-white">
                                                            {{ __('Featured') }}
                                                    </span>
                                                    @endif
                                                </div>
                                                
                                                <div class="movie-time d-flex align-items-center pt-1">
                                                    <!-- Category Thumbnail Setting -->
                                                    @php
                                                    $CategoryThumbnail_setting = App\CategoryVideo::join('video_categories', 'video_categories.id', '=', 'categoryvideos.category_id')
                                                            ->where('categoryvideos.video_id', $artist_video->id)
                                                            ->pluck('video_categories.name');
                                                    @endphp
                                                    @if(($ThumbnailSetting->category == 1) && (count($CategoryThumbnail_setting) > 0))
                                                    <span class="text-white">
                                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            {{ implode(', ', $CategoryThumbnail_setting->toArray()) }}
                                                    </span>
                                                    @endif
                                                </div>
                                        </a>
                                        <a class="epi-name mt-2 mb-0 btn" href="{{ url('category/videos/' . $artist_video->slug) }}">
                                                <img class="d-inline-block ply" alt="ply" src="{{ URL::to('/assets/img/default_play_buttons.svg') }}" width="10%" height="10%" />{{ __('Watch Now') }}
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        
        @endif
      

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

<script>


function Copy() {
    var media_path = $('#media_url').val();
    var url =  navigator.clipboard.writeText(window.location.href);
    var path =  navigator.clipboard.writeText(media_path);
    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
        setTimeout(function() {
        $('.add_watch').slideUp('fast');
        }, 3000);
    } 

     $("#sign_in_follow").click(function(){
        
        window.location.href = "<?php echo URL::to('/login') ; ?>";

    });

    // <?= URL::to('artist/following') ?>

    
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();

        $('#follow-container').click(function () {
            var artist_id = '{{ $artist->id }}';
            var isFollowing = $('#follow-icon').hasClass('fa-user'); // Check current state

            var following = isFollowing ? 0 : 1;
            var tooltipText = following ? 'Remove from Following' : 'Add to Following';
            var iconClass = following ? 'fa-user' : 'fa-user-plus';
            var message = following
                ? 'Artist Added to Your Following List ✔️'
                : 'Artist Removed from Your Following List ❌';
            var backgroundColor = following ? '#dff0d8' : '#f2dede';
            var Color = following ? '#3c763d' : '#a94442';

            $.post('<?= URL::to('artist/following') ?>', {
                artist_id: artist_id,
                following: following,
                _token: '{{ csrf_token() }}'
            }, function (data) {
                $('#follow-icon').removeClass('fa-user fa-user-plus').addClass(iconClass);
                $('#follow-container').attr('title', tooltipText).tooltip('dispose').tooltip(); // Update tooltip text

                showNotification(message, backgroundColor,Color);
            });
        });

        //  notification
        function showNotification(message, backgroundColor,Color) {
            $('#follow-message')
                .text(message)
                .css({ background: backgroundColor, display: 'block', color: Color })
                .fadeIn();

            setTimeout(function () {
                $('#follow-message').fadeOut();
            }, 3000);
        }
    });




</script>