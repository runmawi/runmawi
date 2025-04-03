@php
    include public_path('themes/theme4/views/header.php');

    $slider_choosen = App\HomeSetting::pluck('slider_choosen')->first();
    $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
    $order_settings_list = App\OrderHomeSetting::get();
    $home_settings = App\HomeSetting::first();
    $ThumbnailSetting = App\ThumbnailSetting::first();
    $SeriesGenre = App\SeriesGenre::all();

    $homepage_array_data = [ 'order_settings_list' => $order_settings_list, 
                                'multiple_compress_image' => $multiple_compress_image, 
                                'settings' => $settings,
                                'ThumbnailSetting' => $ThumbnailSetting,
                                'currency' => $currency,
                                'default_vertical_image_url' => $default_vertical_image_url,
                                'default_horizontal_image_url' => $default_horizontal_image_url,
                                'BaseURL'                      => $BaseURL
                            ]; 

@endphp

@if (count($errors) > 0)
    @foreach ($errors->all() as $message)
        <div class="alert alert-danger display-hide" id="successMessage">
            <button id="successMessage" class="close" data-close="alert"> </button>
            <span><?php echo $message; ?></span>
        </div>
    @endforeach
@endif

@if (Session::has('message'))
    <div id="successMessage" class="alert alert-info"><?php echo Session::get('message'); ?></div>
@endif


<div class="main-content">

    @php
        $sections = array(
                        ['view' => 'latest-series','data' => !empty($latest_series) ? $latest_series->slice(0,15) : $latest_series  ],
                        ['view' => 'latest-episodes', 'data' => !empty($latest_episodes) ? $latest_episodes->slice(0,15) : $latest_episodes  ], 
                        ['view' => 'featured-episodes', 'data' => !empty($featured_episodes) ? $featured_episodes->slice(0,15): $featured_episodes ]
                    );
                    
    @endphp


    <div>
        {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/latest-episodes", array_merge(['data' => $latest_episodes, 'multiple_compress_image' => $multiple_compress_image]) )->content() !!}
    </div>

    @foreach ($order_settings as $key => $value)

                            @if( $value->video_name == 'Series_Networks')      {{-- Series Networks --}} 
                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Series-Networks', $homepage_array_data )->content() !!}
                            @endif
                            
                            @if( $value->video_name == 'Series_based_on_Networks')
                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/Series-based-on-Networks', array_merge($homepage_array_data , ['data' => $Series_based_on_Networks ]) )->content() !!}
                            @endif

                            @if ($value->video_name == 'Series_Genre')
                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/SeriesGenre', [ 'data' => !empty($SeriesGenre) ? $SeriesGenre->slice(0,15) : $SeriesGenre , 'order_settings_list' => [$order_settings_list,$data], 'order_settings_list_header' => $order_settings_list,'default_horizontal_image_url' => $default_horizontal_image_url,'default_vertical_image_url' => $default_vertical_image_url, 'multiple_compress_image' => $multiple_compress_image])->content() !!}
                            @endif

                            @if ($value->video_name == 'Series_Genre_videos')
                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/series-based-categories', ['order_settings_list' => $order_settings_list, ])->content() !!}
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
    include public_path('themes/theme4/views/footer.blade.php'); 
@endphp