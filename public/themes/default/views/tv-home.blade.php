<!-- Header Start -->
@php 
    include(public_path('themes/default/views/header.php'));

@endphp

    @if(Session::has('message'))
    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @php
    $homepage_array_data = [  'settings' => $settings,];

    $slider_choosen = App\HomeSetting::pluck('slider_choosen')->first();  
    $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
    $order_settings_list = App\OrderHomeSetting::get();  
    $home_settings = App\HomeSetting::first();
    $ThumbnailSetting = App\ThumbnailSetting::first();
    @endphp

    @if(count($errors) > 0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-danger display-hide" id="successMessage">
                <button id="successMessage" class="close" data-close="alert"> </button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif


   <section id="home" class="iq-main-slider p-0">
        <div id="home-slider" class="slider m-0 p-0">
            {{-- @if($slider_choosen == 2)
                {!! Theme::uses('default')->load('public/themes/default/views/partials/home/slider-2', $Slider_array_data )->content() !!}
            @else
                {!! Theme::uses('default')->load('public/themes/default/views/partials/home/slider-1', $Slider_array_data )->content() !!}
            @endif --}}
        </div>
      
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
         <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
               fill="none" stroke="currentColor">
               <circle r="20" cy="22" cx="22" id="test"></circle>
         </symbol>
      </svg>
   </section>

                              <!-- MainContent -->

                              <div class="main-content">

   
    <div>
        {!! Theme::uses('default')->load('public/themes/default/views/partials/home/latest-series', array_merge($homepage_array_data, ['data' => $latest_series]) )->content() !!}
    </div>

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    @php include(public_path('themes/default/views/partials/home/free_content.blade.php')) @endphp
                </div>
            </div>
        </div>
    </section>

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    @php include(public_path('themes/default/views/partials/home/latest-episodes.php')) @endphp
                </div>
            </div>
        </div>
    </section>

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    @php include(public_path('themes/default/views/partials/home/featured-episodes.php')) @endphp
                </div>
            </div>
        </div>
    </section>

    @foreach($order_settings as $value)  
        @if($value->video_name == 'Series_Genre' && $home_settings->SeriesGenre == 1)
            <section id="iq-favorites">
                <div class="container-fluid overflow-hidden">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @php //include(public_path('themes/default/views/partials/home/SeriesGenre.blade.php')) @endphp
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($value->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1)
            <section id="iq-tvthrillers" class="s-margin">
                @php
                    $parentCategories = App\SeriesGenre::all();
                @endphp
                @foreach($parentCategories as $category)
                    @php
                        $Episode_videos = App\Series::select('episodes.*', 'series.title as series_name', 'series.slug as series_slug')
                            ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                            ->join('episodes', 'episodes.series_id', '=', 'series.id')
                            ->where('series_categories.category_id', '=', $category->id)
                            ->where('episodes.active', '=', '1')
                            ->where('series.active', '=', '1')
                            ->groupBy('episodes.id')
                            ->latest('episodes.created_at')
                            ->get();
                        
                        $series = App\Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                            ->where('category_id', '=', $category->id)
                            ->where('series.active', '=', '1')
                            ->latest('series.created_at')
                            ->get();
                    @endphp
                    @if ($series->count() > 0)
                        @php include(public_path('themes/default/views/partials/home/seriescategoryloop.php')) @endphp
                    @else
                        <p class="no_video"></p>
                    @endif
                @endforeach
            </section>
        @endif
    @endforeach

    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid overflow-hidden">
            @php
                $parentCategories = App\SeriesGenre::all();
            @endphp
            @foreach($parentCategories as $category)
                @php
                    $series = App\Series::where('genre_id', '=', $category->id)->get();
                @endphp
                @if ($series->count() > 0)
                    @include('partials.category-seriesloop')
                @else
                    <p class="no_video"></p>
                @endif
            @endforeach
        </div>
    </section>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);

        $(".main-content , .main-header , .container-fluid").click(function() {
            $(".home-search").hide();
        });
    })
</script>

@php 
    include(public_path('themes/default/views/footer.blade.php'))
@endphp