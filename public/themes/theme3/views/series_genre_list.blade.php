@php
    include(public_path('themes/theme2/views/header.php'));
@endphp
    
<section id="iq-tvthrillers" class="s-margin">
    <div class="container-fluid">

            <div class="">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                            <div class="iq-main-header d-flex align-items-center justify-content-between">
                                <a href="#" class="category-heading" style="text-decoration: none; color: #fff;">
                                    <h4 class="movie-title"> {{ $Series_Genre_name }} </h4>
                                </a>
                            </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                                @php  if(!empty($data['password_hash'])) { 
                                    $id = Auth::user()->id ; } else { $id = 0 ; } @endphp

                                @if(isset($videos)) 
                                    @forelse($videos as $category_video)
                                        <li class="slide-item">
                                            <div class="block-images position-relative">
                                                <!-- block-images -->
                                                <a href="<?php echo URL::to('play_series') ?><?= '/' . $category_video->slug ?>">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid" alt=""> 
                                                </a>
                                            </div>

                                            <div class="block-description">
                                                <div class="hover-buttons">
                                                    <a type="button" class="text-white btn-cl" href="<?php echo URL::to('play_series') ?><?= '/' . $category_video->slug ?>">
                                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                @if($ThumbnailSetting->title == 1)          <!-- Title -->
                                                    <h6>
                                                        <?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?>
                                                    </h6>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if($ThumbnailSetting->duration == 1)  <!-- Duration -->
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= gmdate('H:i:s', $category_video->duration); ?>
                                                    </span>
                                                @endif

                                                @if($ThumbnailSetting->rating == 1 && $category_video->rating != null)  <!-- Rating -->
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $category_video->rating}}
                                                    </span>
                                                @endif

                                                @if($ThumbnailSetting->featured == 1 && $category_video->featured == 1)   <!-- Featured -->
                                                    <span class="text-white">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ( ($ThumbnailSetting->published_year == 1) && ( $category_video->year != null ) )   <!-- published_year -->
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ ($category_video->year) }}
                                                    </span>
                                                @endif
                                            </div>

                                        </li>
                                    @empty
                                            {{  " No data Videos" }}
                                    @endforelse
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>

@php
    include(public_path('themes/theme2/views/footer.blade.php'));
@endphp