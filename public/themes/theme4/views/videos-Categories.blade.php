<?php include public_path('themes/theme4/views/header.php'); ?>

<style>
    .card-image {
        background: #1c2933;
        height: 124px;
        width: 124px;
        padding: 24px 8px 16px;
        -webkit-margin-end: 12px;
        margin-inline-end: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background: #1c2933;
        border-radius: 8px;
        overflow: hidden;
    }

    @media (min-width: 550px) {
        .card-image {
            height: 146px;
            width: 146px;
            -webkit-margin-end: 16px;
            margin-inline-end: 16px;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
    }

    @media (min-width: 550px) {
        .card__text {
            font-size: 16px;
            line-height: 19px;
        }
    }

    .card_image {
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card_text {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font-size: 16px;
        font-weight: 400;
        line-height: 18px;
        text-align: center;
        max-height: 38px;
        color: #c6c8cd;
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
</style>

<div class="main-content"
    style="background-image:linear-gradient(90deg, black, transparent), url({{ $VideosCategory->image ? URL::to('public/uploads/videocategory/' . $VideosCategory->image) : default_vertical_image_url() }}); background-repeat: no-repeat;background-size: cover;" >
    <section id="iq-trending" class="s-margin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 overflow-hidden">

                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h3 class="main-title">{{ optional($VideosCategory)->name }}</h4>
                </div>

                <div class="trending-contens">

                    <ul id="trending-slider-nav"
                        class="latest-videos-slider-nav list-inline p-0 mb-0 row align-items-center">
                        @foreach ($Parent_videos_categories as $key => $Parent_videos_category)
                            <li class="card-image">
                                <a href="{{ route('video_categories', $Parent_videos_category->slug) }}">
                                    <div class="movie-slick position-relative">
                                        <div class="card_image">
                                            <img src="{{ $Parent_videos_category->image ? URL::to('public/uploads/videocategory/' . $Parent_videos_category->image) : default_vertical_image_url() }}"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                </a>
                                <p class="card_text">{{ optional($Parent_videos_category)->name }} </p>
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
