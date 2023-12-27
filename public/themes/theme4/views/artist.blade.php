@php
    include public_path('themes/theme4/views/header.php');
@endphp

<style>
    .main-title {
        padding-bottom: 0px !important;
    }

    /* #removefollow {
        color: #ff4444;
    } */

    /* #follow {
        color: #007E33;
    } */

    .abu h2 {
        color: #fff !important;
    }
    #followingone, #removefollowingone, #following, #removefollowing, #beforesigninfollowing{
        display: inline-flex;
        margin: 0 15px 0 0;
        width: 40px;
        height: 40px;
        background: #5c5c5c54;
        border-radius: 3px;
    }
    #followingone span, #removefollowingone span, #following span, #removefollowing span, #beforesigninfollowing span{
        height:40px;
        width:40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-dialog-centered .modal-content{
        background:transparent;
    }
</style>

<div class="mt-5 container-fluid pl-0 mar-left">

    <div class="row justify-content-between  align-items-center">

        <div class="col-md-3">
            <img src="{{ URL::to('public/uploads/artists/' . $artist->image) }}" alt="" class="w-100">
        </div>

        <div class=" col-md-9 abu">
            <h2> {{ 'About' }} </h2>
            <p> {!! html_entity_decode(optional($artist)->description) !!} </p>

            <div class=" mt-3 mb-5">

                <div class="d-flex align-items-center">

                    @if (Auth::User() != null)

                        @if ($artist_following == 0)
                            <div class="flw mt-2" id="followingone">
                                <span>
                                    <i class="fa fa-user" id="follow" aria-hidden="true"></i>
                                </span>
                            </div>
                        @endif

                        @if ($artist_following > 0)
                            <div class="flw mt-2" id="removefollowingone">
                                <span>
                                    <i class="fa fa-user-plus" id="removefollow" aria-hidden="true"></i>
                                </span>
                            </div>
                        @endif

                        <div class="flw mt-2" id="following">
                            <span>
                                <i class="fa fa-user" id="follow" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="flw mt-2" id="removefollowing">
                            <span>
                                <i class="fa fa-user-plus" id="removefollow" aria-hidden="true"></i>
                            </span>
                        </div>
                    @else
                        <div class="flw mt-2" id="beforesigninfollowing">
                            <span>
                                <i class="fa fa-user" id="sign_in_follow" aria-hidden="true"></i>
                            </span>
                        </div>
                    @endif

                    <div class="flw">
                        <?php $media_url = URL::to('artist/' . $artist->artist_slug); ?>

                        <input type="hidden" value="<?= $media_url ?>" id="media_url">

                        <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                            <li class="share">
                                <span><i class="ri-share-fill"></i></span>
                                <div class="share-box">
                                    <div class="d-flex align-items-center">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>"
                                            class="share-ico"><i class="ri-facebook-fill"></i></a>
                                        <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>"
                                            class="share-ico"><i class="ri-twitter-fill"></i></a>
                                        <a href="#"onclick="Copy();" class="share-ico"><i
                                                class="ri-links-fill"></i></a>
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

@if (count($latest_audios) > 0)
    <div class="container-fluid mt-3 pl-0 mar-left">
        <h4 class="main-title iq-main-header"><?php echo __('Latest Release'); ?></h4>
    </div>

    <div class="container-fluid mt-2 pl-0 mar-left">
        <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
                @foreach ($latest_audios as $key => $latest_audio)
                    <li class="slide-item">
                        <a href="{{ URL::to('audio/' . $latest_audio[0]['slug']) }}">
                            <div class="block-images position-relative">
                                <!-- block-images -->
                                <div class="img-box">
                                    <img loading="lazy" data-src="<?php echo URL::to('/') . '/public/uploads/images/' . $latest_audio[0]['image']; ?>" alt=""
                                        class="img-fluid loading w-100">
                                </div>

                                <div class="block-description">
                                    <div class="hover-buttons text-white">
                                        <a href="{{ URL::to('audio/' . $latest_audio[0]['slug']) }}">
                                            <h6 class="dc">{{ $latest_audio[0]['title'] }}</h6>
                                            <p>{{ $latest_audio[0]['year'] }}</p>
                                        </a>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<!-- Album Videos -->

@if (count($albums) > 0)

    <div class="container-fluid mt-3 pl-0 mar-left">
        <h4 class="main-title iq-main-header">{{ __('Album') }}</h4>
    </div>

    <div class="container-fluid mt-2 pl-0 mar-left">
        <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
                @foreach ($albums as $key => $album)
                    <li class="slide-item">
                        <a href="{{ URL::to('album/' . $album->slug) }}">
                            <div class="block-images position-relative">

                                <div class="img-box">
                                    <img loading="lazy"
                                        data-src="{{ URL::to('public/uploads/albums/' . $album->album) }}"
                                        alt="" class="img-fluid loading w-100">
                                </div>

                                <div class="block-description">

                                    <div class="hover-buttons text-white">
                                        <a href="<?php echo URL::to('/') . '/album/' . $album->slug; ?>">
                                            <h6 class=""><?php echo $album->albumname; ?></h6>
                                        </a>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<!-- Artist Audios -->

@if (count($artist_audios) > 0)
    <div class="container-fluid mt-3 pl-0 mar-left">
        <h4 class="main-title iq-main-header">{{ __('Audio') }}</h4>
    </div>

    <div class="container-fluid mt-2 pl-0 mar-left">
        <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
                @foreach ($artist_audios as $key => $artist_audio)
                    <li class="slide-item">
                        <a href="{{ URL::to('audio/' . $artist_audio->slug) }}">
                            <div class="block-images position-relative">
                                <!-- block-images -->
                                <div class="img-box">
                                    <img loading="lazy"
                                        data-src="{{ URL::to('/') . '/public/uploads/images/' . $artist_audio->image }}"
                                        alt="" class="img-fluid loading w-100">
                                </div>

                                <div class="block-description">

                                    <div class="hover-buttons text-white">
                                        <a href="{{ URL::to('audio/' . $artist_audio->slug) }}">
                                            <h6 class="dc">{{ $artist_audio->title }}</h6>
                                            <p>{{ $artist_audio->year }}</p>
                                        </a>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<!-- Artist Series -->

@if (count($artist_series) > 0)

    <div class="container-fluid mt-3 pl-0 mar-left">
        <h4 class="main-title iq-main-header">{{ 'Series' }}</h4>
    </div>

   

        <div class="trending-contens">
            <ul id="trending-slider-nav" class="Series-Episode-slider-nav list-inline p-0 mar-left row align-items-center">
                @foreach ($artist_series as $key => $artist_serie)
                    <li>
                        <a href="javascript:void(0);">
                            <div class="movie-slick position-relative">
                                <img src="{{ URL::to('public/uploads/images/' . $artist_serie->image) }}" class="img-fluid" alt="">
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>

            <ul id="trending-slider Series-Episode-slider" class="list-inline p-0 m-0 align-items-center Series-Episode-slider">
                @foreach ($artist_series as $key => $artist_serie)
                    <li>
                        <div class="tranding-block position-relative trending-thumbnail-image">
                            <button class="drp-close">×</button>

                            <div class="trending-custom-tab">
                                <div class="trending-content">
                                    <div id="" class="overview-tab tab-pane fade active show">
                                        <div class="trending-info align-items-center w-100 animated fadeInUp">

                                            <div class="caption pl-4">
                                                <h2 class="caption-h2">{{ $artist_serie->title }}</h2>

                                                @if (optional($artist_serie)->description)
                                                    <div class="trending-dec">{!! html_entity_decode( optional($artist_serie)->description) !!}</div>
                                                @endif


                                                <div class="p-btns">
                                                    <div class="d-flex align-items-center p-0">
                                                        <a href="{{ URL::to('play_series/' . $artist_serie->id) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                        <a class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Home-Series-Episodes-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="dropdown_thumbnail">
                                                <img  src="{{ URL::to('public/uploads/images/' . $artist_serie->player_image) }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>


        @foreach ($artist_series as $key => $artist_serie)
            <div class="modal fade info_model" id="{{ "Home-Series-Episodes-Modal-".$key }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                    <div class="container">
                        <div class="modal-content" style="border:none;">
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <img  src="{{ URL::to('public/uploads/images/' . $artist_serie->player_image) }}" alt="" width="100%">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                    <h2 class="caption-h2">{{ $artist_serie->title }}</h2>

                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                        <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            

                                            @if (optional($artist_serie)->description)
                                                <div class="trending-dec mt-4">{!! html_entity_decode( optional($artist_serie)->description) !!}</div>
                                            @endif

                                            <a href="{{ URL::to('play_series/' . $artist_serie->id) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


            
@endif
<!-- Artist videos -->

@if (count($artist_videos) > 0)

    <div class="container-fluid mt-3 pl-0 mar-left">
        <h4 class="main-title iq-main-header">{{ 'Videos' }}</h4>
    </div>


    <div class="trending-contens">
        <ul id="trending-slider-nav" class="artist-videos-slider-nav list-inline p-0 mar-left row align-items-center">
            @foreach ($artist_videos as $key => $artist_video)
                <li>
                    <a href="javascript:void(0);">
                        <div class="movie-slick position-relative">
                            <img src="{{ URL::to('public/uploads/images/' . $artist_video->image) }}" class="img-fluid" >
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

    <ul id="trending-slider artist-videos-slider" class="list-inline p-0 m-0 align-items-center artist-videos-slider">
        @foreach ($artist_videos as $key => $artist_video)
                <li>
                    <div class="tranding-block position-relative trending-thumbnail-image" >
                        <button class="drp-close">×</button>

                        <div class="trending-custom-tab">
                            <div class="trending-content">
                                <div id="" class="overview-tab tab-pane fade active show">
                                    <div class="trending-info align-items-center w-100 animated fadeInUp">

                                    <div class="caption pl-4">
                                            <h2 class="caption-h2">{{ $artist_video->title }}</h2>


                                        @if (optional($artist_video)->description)
                                            <div class="trending-dec">{!! html_entity_decode( optional($artist_video)->description) !!}</div>
                                        @endif

                                        <div class="p-btns">
                                            <div class="d-flex align-items-center p-0">
                                                <a href="{{ URL::to('category/videos/' . $artist_video->slug) }}" class="button-groups btn btn-hover  mr-2" tabindex="0"><i class="fa fa-play mr-2" aria-hidden="true"></i> Play Now </a>
                                                <a class="btn btn-hover button-groups mr-2" tabindex="0" data-bs-toggle="modal" data-bs-target="{{ '#Artist-videos-Modal-'.$key }}"><i class="fas fa-info-circle mr-2" aria-hidden="true"></i> More Info </a>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="dropdown_thumbnail">
                                            <img  src="{{ URL::to('public/uploads/images/' . $artist_video->image) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    @foreach ($artist_videos as $key => $artist_video)
        <div class="modal fade info_model" id="{{ "Artist-videos-Modal-".$key }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                <div class="container">
                    <div class="modal-content" style="border:none;">
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <img  src="{{ URL::to('public/uploads/images/' . $artist_video->image) }}" alt="" width="100%">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                <h2 class="caption-h2">{{ $artist_video->title }}</h2>

                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                <button type="button" class="btn-close-white" aria-label="Close"  data-bs-dismiss="modal">
                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                        

                                        @if (optional($artist_video)->description)
                                            <div class="trending-dec mt-4">{!! html_entity_decode( optional($artist_video)->description) !!}</div>
                                        @endif

                                        <a href="{{ URL::to('category/videos/' . $artist_video->slug) }}" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0" ><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach




    <!-- <div class="container-fluid mt-2">
        <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
                @foreach ($artist_videos as $key => $artist_video)
                    <li class="slide-item">
                        <a href="{{ URL::to('category/videos/' . $artist_video->slug) }}">
                            <div class="block-images position-relative">
                                <div class="img-box">
                                    <img loading="lazy"
                                        data-src="{{ URL::to('public/uploads/images/' . $artist_video->image) }}"
                                        class="img-fluid loading w-100">
                                </div>

                                <div class="block-description">
                                    <div class="hover-buttons text-white">
                                        <a href="{{ URL::to('category/videos/' . $artist_video->slug) }}">
                                            <h6 class="dc">{{ $artist_video->title }}</h6>
                                            <p> {{ $artist_video->year }}</p>
                                        </a>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div> -->

@endif

@php
    include public_path('themes/theme4/views/footer.blade.php');
@endphp

<script>
    function Copy() {
        var media_path = $('#media_url').val();
        var url = navigator.clipboard.writeText(window.location.href);
        var path = navigator.clipboard.writeText(media_path);
        $("body").append(
            '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>'
        );
        setTimeout(function() {
            $('.add_watch').slideUp('fast');
        }, 3000);
    }

    $('#following').hide();
    $('#removefollowing').hide();
    $('#follow').click(function() {
        var artist_id = '<?= $artist->id ?>';
        $.post('<?= URL::to('artist/following') ?>', {
                artist_id: artist_id,
                following: 1,
                _token: '<?= csrf_token() ?>'
            },
            function(data) {
                $('#following').hide();
                $('#followingone').hide();
                $('#removefollowing').show();
            });
        $("body").append(
            '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Artist Added To Your Following List </div>'
        );
        setTimeout(function() {
            $('.add_watch').slideUp('fast');
        }, 3000);
    });

    $('#removefollow').click(function() {
        var artist_id = '<?= $artist->id ?>';
        $.post('<?= URL::to('artist/following') ?>', {
                artist_id: artist_id,
                following: 0,
                _token: '<?= csrf_token() ?>'
            },
            function(data) {
                $('#following').show();
                $('#removefollowing').hide();
                $('#removefollowingone').hide();
            });
        $("body").append(
            '<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Artist Removed To Your Following List</div>'
        );
        setTimeout(function() {
            $('.add_watch').slideUp('fast');
        }, 3000);
    });

    $("#sign_in_follow").click(function() {
        window.location.href = "<?php echo URL::to('/login'); ?>";
    });
</script>

<script>
    
    $( window ).on("load", function() {
        $('.Series-Episode-slider').hide();
    });

    $(document).ready(function() {

        $('.Series-Episode-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            draggable: false,
            asNavFor: '.Series-Episode-slider-nav',
        });

        $('.Series-Episode-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.Series-Episode-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.Series-Episode-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.Series-Episode-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.Series-Episode-slider').hide();
        });
    });
</script>
<script>
    
    $( window ).on("load", function() {
        $('.artist-videos-slider').hide();
    });

    $(document).ready(function() {

        $('.artist-videos-slider').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            draggable: false,
            asNavFor: '.artist-videos-slider-nav',
        });

        $('.artist-videos-slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.artist-videos-slider',
            dots: false,
            arrows: true,
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>',
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $('.artist-videos-slider-nav').on('click', function() {
            $( ".drp-close" ).trigger( "click" );
            $('.artist-videos-slider').show();
        });

        $('body').on('click', '.drp-close', function() {
            $('.artist-videos-slider').hide();
        });
    });
</script>