@php 
    include(public_path("themes/{$current_theme}/views/header.php"));

    $homepage_array_data = [ 'order_settings_list' => $order_settings_list, 
                                'multiple_compress_image' => $multiple_compress_image, 
                                'settings' => $settings,
                                'ThumbnailSetting' => $ThumbnailSetting,
                                'currency' => $currency,
                                'default_vertical_image_url' => $default_vertical_image_url,
                                'default_horizontal_image_url' => $default_horizontal_image_url,
                            ]; 

    $slider_choosen = $home_settings->slider_choosen == 2 ? "slider-2" : "slider-1 ";
@endphp

                {{-- Session Note --}}

@if(Session::has('message'))
    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
@endif

                {{-- Error Note --}}
@if(count($errors) > 0)
    @foreach( $errors->all() as $message )
        <div class="alert alert-danger display-hide" id="successMessage">
            <button id="successMessage" class="close" data-close="alert"> </button>
            <span>{{ $message }}</span>
        </div>
    @endforeach
@endif

                {{-- Slider --}}
<section id="home" class="iq-main-slider p-0">
    <div id="home-slider" class="slider m-0 p-0">
        {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/{$slider_choosen}", $Slider_array_data )->content() !!}
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
        {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-series", array_merge($homepage_array_data, ['data' => $latest_series]) )->content() !!}
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

    <!-- **************Don't Enable this section We don't have Access for episodes**************  -->
    
    <!-- <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    @php include(public_path('themes/default/views/partials/home/latest-episodes.php')) @endphp
                </div>
            </div>
        </div>
    </section> -->

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    @php include(public_path('themes/default/views/partials/home/featured-episodes.php')) @endphp
                </div>
            </div>
        </div>
    </section>

    @foreach($order_settings_list as $value)  

        @if($value->video_name == 'Series_Genre' && $home_settings->SeriesGenre == 1)
            <section id="iq-favorites">
                <div class="container-fluid overflow-hidden">
                    <div class="row">
                        <div class="col-sm-12 ">
                            {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/SeriesGenre", array_merge($homepage_array_data, ['data' => $SeriesGenre]) )->content() !!}
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($value->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1)
            <section id="iq-tvthrillers" class="s-margin">
                {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/series-based-categories", array_merge($homepage_array_data , ['data' => $Series_based_on_category ]) )->content() !!}
            </section>
        @endif

        @if($value->video_name == 'Series_based_on_Networks' && $home_settings->Series_based_on_Networks == 1 )
            <section id="iq-tvthrillers" class="s-margin">
                {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/Series-based-on-Networks", array_merge($homepage_array_data , ['data' => $Series_based_on_Networks ]) )->content() !!}
            </section>
        @endif

    @endforeach
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
    include(public_path("themes/{$current_theme}/views/footer.blade.php"))
@endphp