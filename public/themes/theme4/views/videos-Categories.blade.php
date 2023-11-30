<?php include public_path('themes/theme4/views/header.php'); ?>

<div class="main-content">
    <section id="iq-trending" class="s-margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">
                                    
                                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">{{ optional($VideosCategory)->name }}</h4>
                    </div>

                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title">{{ optional($VideosCategory)->home_genre }}</h4>
                    </div>

                    <div class="trending-contens">

                        <ul id="trending-slider-nav" class="latest-videos-slider-nav list-inline p-0 mb-0 row align-items-center">
                            @foreach ($Parent_videos_categories as $key => $Parent_videos_category )
                                <li>
                                    <a href="{{ route('video_categories',$Parent_videos_category->slug )}}">
                                        <div class="movie-slick position-relative">
                                            <img src="{{ $Parent_videos_category->image ?  URL::to('public/uploads/images/'.$Parent_videos_category->image) : default_vertical_image_url() }}" class="img-fluid" >
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
</div>

@php include public_path('themes/theme4/views/footer.blade.php'); @endphp
