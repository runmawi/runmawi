@php include public_path('themes/theme5-nemisha/views/header.php'); @endphp

<!-- MainContent -->

<section id="iq-favorites">
    @if (isset($respond_data['Series']) && count($respond_data['Series']) > 0)

        <div class="container-fluid"
            style="padding: 0px 40px!important;background: linear-gradient(135.05deg, rgba(136, 136, 136, 0.48) 1.85%, rgba(64, 32, 32, 0.13) 38.53%, rgba(81, 57, 57, 0.12) 97.89%);">
            <div class="row">

                <div class="col-sm-12 page-height">

                    <div class="iq-main-header align-items-center justify-content-between">
                        <h4 class="main-title mt-3">                  
                            <b>Channel Series Videos in:</b> {{{ $respond_data['channel_slug'] }}} 
                        </h4>                   
                    </div>

                    @if (count($respond_data['Series']) > 0)
                        <div class="favorites-contens">
                            <ul class="list-inline row p-0 mb-0">
                                @if (isset($respond_data['Series']))

                                    @forelse ($respond_data['Series'] as $key => $Serie)

                                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">

                                        <a  href="{{ URL::to('play_series/'. $Serie->slug ) }}">
                                                <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <img src="{{ $Serie->image ? URL::to('/public/uploads/images/'.$Serie->image) : $default_vertical_image_url }}" class="img-fluid" alt="Channel-Video-Image">
                                                    </div>

                                                    <div class="block-description">
                                                        <div class="hover-buttons">
                                                            <a href="{{ URL::to('play_series/'. $Serie->slug ) }}">
                                                                <img class="ply" src="{{ URL::to('assets/img/play.svg') }} ">
                                                            </a>
                                                        <div>
                                                    </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="mt-2 d-flex justify-content-between p-0">
                                                        @if ($respond_data['ThumbnailSetting']->title == 1)
                                                            <h6>{{ strlen($Serie->title) > 17 ? substr($Serie->title, 0, 18) . '...' : $Serie->title }}</h6>
                                                        @endif

                                                        @if ($respond_data['ThumbnailSetting']->age == 1 && $Serie->age_restrict != null )
                                                            <div class="badge badge-secondary">
                                                                {{ $Serie->age_restrict . ' ' . '+' }}
                                                            </div>
                                                        @endif
                                                    </div>


                                                    <div class="movie-time my-2">

                                                        <!-- Rating -->

                                                        @if ($respond_data['ThumbnailSetting']->rating == 1 && $Serie->rating != null)
                                                            <span class="text-white">
                                                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                {{ $Serie->rating }}
                                                            </span>
                                                        @endif

                                                        <!-- Featured -->
                                                        @if ($respond_data['ThumbnailSetting']->featured == 1 && $Serie->featured != null && $Serie->featured == 1)
                                                            <span class="text-white">
                                                                <i class="fa fa-flag" aria-hidden="true"></i>
                                                            </span>
                                                        @endif
                                                    </div>

                                                        {{-- Source --}}
                                                    <div class="movie-time my-2">
                                                        <span class="text-white">
                                                            {{ $Serie->source }}
                                                        </span>
                                                    </div>

                                                        <!-- published_year -->
                                                    @if ($respond_data['ThumbnailSetting']->published_year == 1 && $Serie->year != null)
                                                        <div class="movie-time my-2">
                                                            <span class="text-white">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ $Serie->year }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <div class="col-md-12 text-center mt-4"
                                            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                            <p>
                                            <h3 class="text-center">{{ __('No Series Available') }}</h3>
                                        </div>
                                    @endforelse
                                @endif
                            </ul>

                            <div class="col-md-12 pagination justify-content-end">
                                {!! $respond_data['Series']->links() !!}
                            </div>

                        </div>
                    @else
                        <div class="col-md-12 text-center mt-4"
                            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                            <p>
                            <h3 class="text-center">{{ __('No Series Available') }}</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 text-center mt-4"
            style="background: url(<?= URL::to('/assets/img/watch.png') ?>);background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
            <h3 class="text-center">{{ __('No Series Available') }}</h3>
        </div>
    @endif
</section>

<?php include public_path('themes/theme5-nemisha/views/footer.blade.php'); ?>