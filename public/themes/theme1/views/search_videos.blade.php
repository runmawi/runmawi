@php
    include(public_path('themes/theme1/views/header.php'));
@endphp

<section id="iq-favorites">
    <h3 class="vid-title text-center mt-4 mb-5">Showing Result of "{{  $search_value }}" Videos</h3>
    <div class="container-fluid" style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">


            {{-- Videos --}}
        @if( count($all_videos) > 0 )
            <div class="row">
                <div class="col-sm-12 page-height">

                        <div class="favorites-contens">
                            <ul class="category-page list-inline row p-0 mb-0">
                                @if(count($all_videos) > 0)
                                    @if(isset($all_videos)) 
                                        @foreach($all_videos as $latest_video)
                                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                                <a href="<?php echo URL::to('home') ?>">
                                                    <div class="block-images position-relative">
                                                        <div class="img-box">
                                                            <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_video->image;  ?>" class="img-fluid" alt="">
                                                        </div>

                                                        <div class="block-description">
                                                            <div class="hover-buttons">
                                                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $latest_video->slug ?>">	
                                                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>">                                  
                                                                </a>
                                                            <div>
                                                        </div>
                                                    </div> </div> </div>
                    
                                                    <div class="">
                                                        <div class="mt-2 d-flex justify-content-between p-0">
                                                            @if($ThumbnailSetting->title == 1) 
                                                                <h6><?php  echo (strlen($latest_video->title) > 17) ? substr($latest_video->title,0,18).'...' : $latest_video->title; ?></h6>
                                                            @endif

                                                            @if($ThumbnailSetting->age == 1)
                                                                <div class="badge badge-secondary">
                                                                    {{ $latest_video->age_restrict.' '.'+' }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time my-2"> 
                                                            @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                                <span class="text-white">
                                                                        <i class="fa fa-clock-o"></i>
                                                                        {{ gmdate('H:i:s', $latest_video->duration)}}
                                                                </span>
                                                            @endif
                                    
                                                            @if($ThumbnailSetting->rating == 1 && $latest_video->rating != null)  <!-- Rating -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                    {{ $latest_video->rating }}
                                                                </span>
                                                            @endif
                                    
                                                            @if($ThumbnailSetting->featured == 1 && $latest_video->featured == 1)  <!-- Featured -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    
                                                        <div class="movie-time my-2">                   
                                                            @if ( ($ThumbnailSetting->published_year == 1) && ( $latest_video->year != null ) )  <!-- published_year -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ $latest_video->year }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="movie-time my-2"> <!-- Category Thumbnail  setting -->
                                                            @php
                                                                $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                            ->where('categoryvideos.video_id',$latest_video->id)
                                                                            ->pluck('video_categories.name');        
                                                            @endphp

                                                            @if( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) 
                                                                <span class="text-white">
                                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                        @php
                                                                            $Category_Thumbnail = array();
                                                                                foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                                                $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                                                }
                                                                            echo implode(','.' ', $Category_Thumbnail);
                                                                        @endphp
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                @else
                                    <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;height: 500px!important;">
                                        <p><h2 style="position: absolute;top: 50%;left: 50%;color: white;">No video Available</h2>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>
            </div>
        @endif

    </div>
</section>
@php
    include(public_path('themes/theme1/views/footer.blade.php'));
@endphp