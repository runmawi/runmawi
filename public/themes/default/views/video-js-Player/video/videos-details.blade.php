@php  include public_path('themes/default/views/header.php'); @endphp

{{-- Style Link--}}

<link rel="stylesheet" href="{{ asset('public/themes/default/assets/css/video-js/video-details.css') }}">

<div class="vpageBanner">
    <div class="backdrop-img">    {{-- Background image --}}
        <span class=" lazy-load-image-background blur lazy-load-image-loaded"  style="color: transparent; display: inline-block;">
            <img src="{{ optional($videodetail)->player_image_url }}">
        </span>
    </div>

    <div class="opacity-layer"></div>

    <div class="pageWrapper">
        <div class="content">
            <div class="left">
                <span class=" lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                    <img class="posterImg"  src="{{ $videodetail->image_url }}" >
                </span>
            </div>

            <div class="right">
                <div class="title">    {{--  Title & Year--}}
                    {{ optional($videodetail)->title }} {{ $videodetail->year ? '('. $videodetail->year .')' : " "}}
                </div>

                @if ( $setting->show_Links_and_details == 1 &&  optional($videodetail)->details )  {{-- Details --}}
                    <div class="subtitle">  
                        {!! html_entity_decode(optional($videodetail)->details) !!}
                    </div>
                @endif

                @if ($setting->show_genre == 1 && !$videodetail->categories->isEmpty() )        {{-- categories --}}
                    <div class="genres">  
                        @foreach ( $videodetail->categories as $item )
                            <div class="genre">
                                <a href="{{ route('video_categories',[ $item->slug ]) }}"> {{ $item->name }} </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="row">  
                    <div class="circleRating">  {{-- Rating --}}
                        <svg class="CircularProgressbar " viewBox="0 0 100 100" data-test-id="CircularProgressbar">
                            <path class="CircularProgressbar-trail" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 0px;"></path>
                            <path class="CircularProgressbar-path" d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8" fill-opacity="0" style="stroke: orange; stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 101.159px;"></path>
                            <text class="CircularProgressbar-text" x="50" y="50"> {{ optional($videodetail)->rating }}  </text>
                        </svg>
                    </div>

                    <div class="playbtn">     {{-- Trailer --}}
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
                            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
                        </svg>
                        <span class="text">Watch Trailer</span>
                    </div>

                    <div class="playbtn">    {{-- Play --}}
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
                            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
                        </svg>
                        <span class="text"> Play </span>
                    </div>

                </div>

                @if( $setting->show_description == 1 && optional($videodetail)->description )   {{-- Description --}}
                    <div class="overviewd">
                        <div class="heading">Description</div>
                        <div class="description">
                            {!!  html_entity_decode( optional($videodetail)->description ) !!}
                        </div>
                    </div>
                @endif

                <div class="info">       {{-- publish_status --}}
                    <div classname="infoItem">
                        <span classname="text bold">Status: </span>
                        <span class="text">Released</span>
                    </div>
                </div>

                @if ( $setting->show_languages == 1 &&  !$videodetail->Language->isEmpty())   {{-- Languages --}}
                    <div class="info">      
                        <span classname="text bold"> Languages : </span>
                        @foreach( $videodetail->Language as $item )
                            <span class="text">
                                <span> <a href="{{ URL::to('language/'. $item->language_id . '/' . $item->name ) }} "> {{ $item->name }} </a>   </span>
                            </span>
                        @endforeach
                    </div>
                @endif

                <div class="info">      {{-- E-Paper --}}
                    <span classname="text bold"> E-Paper : </span>
                    <span class="text">
                        <a href="{{ $videodetail->pdf_files_url }}" style="font-size:45px; color: #a51212 !important;" class="fa fa-file-pdf-o " download></a>
                    </span>
                </div>
            </div>
        </div>
 
        @if ($setting->show_artist == 1 && !$videodetail->artists->isEmpty() ) {{-- Artists --}}
            <div class="sectionArtists">   
                <div class="artistHeading">Top Cast</div>
                <div class="listItems">
                    @foreach ( $videodetail->artists as $item )
                        <a href="{{ route('artist',[ $item->artist_slug ])}}">
                            <div class="listItem">
                                <div class="profileImg">
                                    <span class="lazy-load-image-background blur lazy-load-image-loaded" style="color: transparent; display: inline-block;">
                                        <img  src="{{ URL::to('public/uploads/artists/'. $item->image ) }}" />
                                    </span>
                                </div>
                                <div class="name">{{ $item->artist_name }}</div>
                                <div class="character">{{ str_replace('_', ' ', $item->artist_type) }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

                    {{-- comment Section --}}

        @if( $CommentSection != null && $CommentSection->videos == 1 )
            <div class="sectionArtists">   
                <div class="artistHeading"> Comments </div>
                    <div class="overflow-hidden">
                        @php include public_path('themes/default/views/comments/index.blade.php') @endphp
                    </div>
            </div>
        @endif

                    {{-- Recomended videos Section --}}

         {{-- <div class=" container-fluid video-list  overflow-hidden">
            <h4 class="Continue Watching" style="color:#fffff;">{{ ucwords('recomended videos') }}</h4> 
            <div class="slider"
                data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
                @php include public_path('themes/default/views/video-js-Player/video/videos_related.blade.php'); @endphp
            </div> 
         </div> --}}

    </div>

    <div class="videoPopup ">
        <div class="opacityLayer"></div>
        <div class="videoPlayer">
            <span class="closeBtn">Close</span>
            <div style="width: 100%; height: 100%;">
                <!-- Placeholder for video player -->
            </div>
        </div>
    </div>
</div>

@php include public_path('themes/default/views/footer.blade.php'); @endphp
