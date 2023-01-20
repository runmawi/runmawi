<?php 
   include(public_path('themes/theme3/views/header.php'));
   include(public_path('themes/theme3/views/Rss-feed/Rss_feed_style.blade.php'));
?>

<section id="iq-favorites">

    <div class="pricing-wrapper clearfix">
		<h1 class="pricing-table-title">{{ 'RSS  LIST' }} </h1>

        <a  href="{{ route('Rss-Feed-videos-view') }}" >
            <div class="pricing-table" >
                <h3 class="pricing-title"> {{ 'Videos' }} </h3>
                <div class="price"> {{ $videos_count }} </div>
                <ul class="table-list">
                    <li>{{ $videos_count." count" }} <span> in the videos </span></li>
                    <li> <span class="unlimited">{{strtoupper('Really Simple Syndication')}}</span></li>
                </ul>
                <div class="table-buy">
                    <a href="{{ route('Rss-Feed-videos-view') }}" class="pricing-action"> {{'XML FILE'}} </a>
                </div>
            </div>
        </a>

        <a  href="{{ route('Rss-Feed-Livestream-view') }}" >
            <div class="pricing-table recommended">
                <h3 class="pricing-title"> {{'Live Stream'}}</h3>
                <div class="price"> {{ $livestreams_count }} </div>
                <ul class="table-list">
                    <li>{{ $livestreams_count." count" }} <span> in the Live stream </span></li>
                    <li> <span class="unlimited">{{strtoupper('Really Simple Syndication')}}</span></li>
                </ul>
                <div class="table-buy">
                    <a href="{{ route('Rss-Feed-Livestream-view') }}" class="pricing-action"> {{'XML FILE'}} </a>
                </div>
            </div>
        </a>
        
        <a  href="{{ route('Rss-Feed-episode-view') }}" >
            <div class="pricing-table">
                <h3 class="pricing-title"> {{'Episode'}} </h3>
                <div class="price"> {{ $Episode_count }}</div>
                <ul class="table-list">
                    <li>{{ $Episode_count." count" }} <span> in the Episode </span></li>
                    <li> <span class="unlimited">{{strtoupper('Really Simple Syndication')}}</span></li>
                </ul>
                <div class="table-buy">
                    <a href="{{ route('Rss-Feed-episode-view') }}" class="pricing-action"> {{'XML FILE'}} </a>
                </div>
            </div>
        </a>
	</div>
<section>

<?php
    //  include(public_path('themes/theme3/views/footer.blade.php'));  
     ?>