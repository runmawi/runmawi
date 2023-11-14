<?php
    include public_path('themes/theme1/views/header.php');
    include public_path('themes/theme1/views/Rss-feed/Rss_feed_style.blade.php');
?>

<section id="iq-favorites">

    <div class="pricing-wrapper clearfix">
        <h1 class="pricing-table-title">{{ __('RSS  LIST') }} </h1>

        <div class="row d-flex col-md-12">

            <div class="col-md-3">
                <a href="{{ route('Rss-Feed-videos-view') }}">
                    <div class="pricing-table">
                        <h3 class="pricing-title"> {{ __('Videos') }} </h3>
                        <div class="price"> {{ $videos_count }} </div>
                        <ul class="table-list">
                            <li>{{ $videos_count . ' count' }} <span> {{ __('in the videos') }} </span></li>
                            <li> <span class="unlimited">{{ strtoupper( __('Really Simple Syndication')) }}</span></li>
                        </ul>
                        <div class="table-buy">
                            <a href="{{ route('Rss-Feed-videos-view') }}" class="pricing-action"> {{ __('XML FILE') }}
                            </a>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('Rss-Feed-Livestream-view') }}">
                    <div class="pricing-table recommended">
                        <h3 class="pricing-title"> {{ __('Live Stream') }}</h3>
                        <div class="price"> {{ $livestreams_count }} </div>
                        <ul class="table-list">
                            <li>{{ $livestreams_count . ' count' }} <span> {{ __('in the Live stream') }} </span></li>
                            <li> <span class="unlimited">{{ strtoupper( __('Really Simple Syndication')) }}</span></li>
                        </ul>
                        <div class="table-buy">
                            <a href="{{ route('Rss-Feed-Livestream-view') }}" class="pricing-action">
                                {{ __('XML FILE') }}
                            </a>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('Rss-Feed-episode-view') }}">
                    <div class="pricing-table">
                        <h3 class="pricing-title-episode"> {{ __('Episode') }} </h3>
                        <div class="price"> {{ $Episode_count }}</div>
                        <ul class="table-list">
                            <li>{{ $Episode_count . ' count' }} <span> {{ __('in the Episode') }} </span></li>
                            <li> <span class="unlimited">{{ strtoupper( __('Really Simple Syndication') ) }}</span></li>
                        </ul>
                        <div class="table-buy">
                            <a href="{{ route('Rss-Feed-episode-view') }}" class="pricing-action episode"> {{ __('XML FILE') }}
                            </a>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('Rss-Feed-audios-view') }}">
                    <div class="pricing-table price1">
                        <h3 class="pricing-title-audios "> {{ __('Audios') }} </h3>
                        <div class="price"> {{ $audios_count }}</div>
                        <ul class="table-list">
                            <li>{{ $audios_count . ' count' }} <span> {{ __('in the Audios') }} </span></li>
                            <li> <span class="unlimited">{{ strtoupper( __('Really Simple Syndication') ) }}</span></li>
                        </ul>
                        <div class="table-buy">
                            <a href="{{ route('Rss-Feed-audios-view') }}" class="pricing-action audios"> {{ __('XML FILE') }}
                            </a>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
<section>

<?php
        include(public_path('themes/theme1/views/footer.blade.php'));
?>
