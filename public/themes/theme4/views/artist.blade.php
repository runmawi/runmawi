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

    <div class="d-flex justify-content-between  align-items-center">

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



<!-- Artist Series -->

@if (count($artist_series) > 0)

    <div class="mt-3 mar-left">
        <h4 class="main-title iq-main-header">{{ 'Series' }}</h4>
    </div>

    <div class="channels-list">
        <div class="channel-row">
            <div id="trending-slider-nav" class="video-list latest-series-video" data-flickity>
                @foreach ($artist_series as $key => $artist_serie)
                    <div id="latest-series-slider-img" class="item" data-index="{{ $key }}" data-series-id="{{ $artist_serie->id }}">
                        <div class="movie-sdivck position-relative">
                            <img data-flickity-lazyload="{{ URL::to('public/uploads/images/' . $artist_serie->image) }}"  class="flickity-lazyloaded" alt="{{ $artist_serie->title }}">
                            <div class="controls">        
                                <a href="{{ URL::to('play_series/'.$artist_serie->slug) }}">
                                    <button class="playBTN"> <i class="fas fa-play"></i></button>
                                </a>
                                <nav>
                                    <button id="data-modal-artist-series" class="moreBTN" tabindex="0" data-bs-toggle="modal" data-bs-target="#Artist-series-Modal" data-series-id="{{ $artist_serie->id }}"><i class="fas fa-info-circle"></i><span>More info</span></button>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

       {{-- series modal --}}
       <div class="modal fade info_model" id="Artist-series-Modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width:100% !important;">
                <div class="container">
                    <div class="modal-content" style="border:none; background:transparent;">
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <img id="series_modal-img" src="https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp" width="460" height="259">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                <h2 class="modal-title caption-h2"></h2>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                <button type="button" class="btn-close-white" aria-label="Close" data-bs-dismiss="modal">
                                                    <span aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i></span>
                                                </button>
                                            </div>
                                        </div>

                                            <div class="modal-desc trending-dec mt-4"></div>

                                        <a href="" class="btn btn-hover button-groups mr-2 mt-3" tabindex="0"><i class="far fa-eye mr-2" aria-hidden="true"></i> View Content </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



            
@endif

<script>
    var elem = document.querySelector('.latest-series-video');
        var flkty = new Flickity(elem, {
            cellAlign: 'left',
            contain: true,
            groupCells: false,
            pageDots: false,
            draggable: true,
            freeScroll: true,
            imagesLoaded: true,
            lazyLoad: 6,
            setGallerySize: true,
            resize: true,   
        });
</script>


<script>
    $(document).on('click', '#data-modal-artist-series', function() {
        const SeriesId = $(this).data('series-id');
        // console.log("modal opened.");
        $.ajax({
            url: '{{ route("getSeriesArtistModalImg") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                Series_id : SeriesId
            },
            success: function (response) {
                // console.log("image: " + response.image);
                // console.log("title: " + response.title);
                // console.log("description: " + response.description);
                // const slug = 'live/' + response.slug;
                console.log("slug: " + response.slug);
                $('#series_modal-img').attr('src', response.image);
                $('#series_modal-img').attr('alt', response.title);
                $('.modal-title').text(response.title);
                $('.modal-desc').text(response.description);
                $('.btn.btn-hover').attr('href', response.slug);
                

            },
            error: function () {
                console.log('Failed to load images. Please try again.');
            }
        });

        $('.btn-close-white').on('click', function () {
            $('#series_modal-img').attr('src', 'https://e360tvmain.b-cdn.net/css/assets/img/gradient.webp');
            $('.modal-title').text('');
            $('.modal-desc').text('');
            $('.btn.btn-hover').attr('href', '');
        });


    });
</script>


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

<style>
     #latest-series-slider-img:hover .controls {
        opacity: 1;
        background-image: linear-gradient(0deg, black, transparent);
        border: 2px solid #2578c0 !important;
    }

    .controls {
        position: absolute;
        padding: 4px;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 3;
        opacity: 0;
        -webkit-transition: all .15s ease;
        transition: all .15s ease;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    .controls nav {
        position: absolute;
        -webkit-box-align: end;
        -ms-flex-align: end;
        align-items: flex-end;
        right: 4px;
        top: 4px;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
</style>