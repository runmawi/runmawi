@php
    include(public_path('themes/default/views/header.php'));
@endphp

<section id="iq-favorites">
    <div class="container">

            {{-- Showing  videos--}}
        @if( count($all_videos) > 0 )
            <div class="row">

                <div class="col-sm-12 page-height">
                    <div class="favorites-contens">
                        <ul class="category-page list-inline row p-0 mb-0">
                            @if(isset($all_videos)) 
                                @foreach($all_videos as $video_search)
                                    <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                        <a href="{{ URL::to('category') . '/videos/' . $video_search->slug }}">
                                            <div class="block-images position-relative">
                                                <div class="img-box">
                                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video_search->image;  ?>" class="img-fluid" alt="">
                                                        
                                                        @if(!empty($video_search->ppv_price))
                                                            <p class="p-tag1" >
                                                                {{  $currency->symbol.' '.$video_search->ppv_price}}
                                                            </p>
                                                        @elseif( !empty($video_search->global_ppv || !empty($video_search->global_ppv) && $video_search->ppv_price == null))
                                                            <p class="p-tag1">
                                                                {{ $video_search->global_ppv.' '.$currency->symbol }}
                                                            </p>
                                                        @elseif($video_search->global_ppv == null && $video_search->ppv_price == null )
                                                            <p class="p-tag" > 
                                                                {{  "Free"}} 
                                                            </p>
                                                        @endif
                                                    </div>
                                        

                                                    <div class="block-description" style="bottom:-38px!important;">
                                                        @if($ThumbnailSetting->title == 1)        <!-- Title -->
                                                            <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video_search->slug ?>">
                                                                <h6><?php  echo (strlen($video_search->title) > 17) ? substr($video_search->title,0,18).'...' : $video_search->title; ?></h6>
                                                            </a>
                                                        @endif

                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                            @if($ThumbnailSetting->age == 1)  <!-- Age -->
                                                                <div class="badge badge-secondary p-1 mr-2">
                                                                {{  $video_search->age_restrict.' '.'+' }}
                                                                </div>
                                                            @endif

                                                            @if($ThumbnailSetting->duration == 1) <!-- Duration -->
                                                                <span class="text-white"><i class="fa fa-clock-o"></i>
                                                                    {{ gmdate('H:i:s', $video_search->duration)}}
                                                                </span>
                                                            @endif
                                                        </div>


                                                        @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if($ThumbnailSetting->rating == 1)   <!--Rating  -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                        {{ ($video_search->rating)}}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->published_year == 1)  <!-- published_year -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                            {{ ($video_search->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                @if($ThumbnailSetting->featured == 1 &&  $video_search->featured == 1)   <!-- Featured -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <div class="movie-time my-2"> <!-- Category Thumbnail  setting -->
                                                            @php
                                                                $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                            ->where('categoryvideos.video_id',$video_search->id)
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

                                                        <div class="hover-buttons">
                                                            <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $video_search->slug ?>">	
                                                                <span class="text-white">
                                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                        {{ "Watch Now" }}
                                                                </span>
                                                            </a>
                                                        <div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $video_search->id;?>">
                                                        <span class="text-center thumbarrow-sec"></span>
                                                    </button>
                                            </div> </div>   </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp