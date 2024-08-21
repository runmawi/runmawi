@php
    include public_path('themes/theme4/views/header.php');

    $slider_choosen = App\HomeSetting::pluck('slider_choosen')->first();
    $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
    $order_settings_list = App\OrderHomeSetting::get();
    $home_settings = App\HomeSetting::first();
    $ThumbnailSetting = App\ThumbnailSetting::first();
    $SeriesGenre = App\SeriesGenre::all();

    $Slider_array_data = [
        'Episode_sliders' => App\Episode::where('active', '1')->where('status', '1')->where('banner', '1')->latest()->limit(15)->get(),
        'multiple_compress_image' => $multiple_compress_image,
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

<section id="home" class="iq-main-slider p-0">
    <div id="home-slider" class="slider m-0 p-0">
        {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/slider-1', $Slider_array_data)->content() !!}
    </div>
</section>

<div class="main-content">

    @php
        $sections = array(
                        ['view' => 'latest-series','data' => !empty($latest_series) ? $latest_series->slice(0,15) : $latest_series  ],
                        ['view' => 'free_content', 'data' => !empty($free_Contents) ? $free_Contents->slice(0,15) : $free_Contents ], 
                        ['view' => 'latest-episodes', 'data' => !empty($latest_episodes) ? $latest_episodes->slice(0,15) : $latest_episodes  ], 
                        ['view' => 'featured-episodes', 'data' => !empty($featured_episodes) ? $featured_episodes->slice(0,15): $featured_episodes ]
                    );
                    
    @endphp


    @foreach ($sections as $section)
        <section id="iq-favorites">
            <div class="container-fluid overflow-hidden pl-0">
                <div class="row">
                    <div class="col-sm-12">
                        {!! Theme::uses('theme4')->load("public/themes/theme4/views/partials/home/{$section['view']}", [
                                'data' => $section['data'],
                                'order_settings_list' => $order_settings_list,
                                'multiple_compress_image' => $multiple_compress_image,
                            ])->content() !!}
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    @foreach ($order_settings as $key => $value)
        @if ( ($value->video_name == 'Series_Genre' && $home_settings->SeriesGenre == 1) || ($value->video_name == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1))
            <section id="iq-favorites">
                <div class="container-fluid overflow-hidden pl-0">
                    <div class="row">
                        <div class="col-sm-12">

                            @if ($value->video_name == 'Series_Genre')
                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/SeriesGenre', [ 'data' => !empty($SeriesGenre) ? $SeriesGenre->slice(0,15) : $SeriesGenre , 'order_settings_list' => [$order_settings_list,$data], ])->content() !!}
                            @endif

                            @if ($value->video_name == 'Series_Genre_videos')
                                {!! Theme::uses('theme4')->load('public/themes/theme4/views/partials/home/series-based-categories', ['order_settings_list' => $order_settings_list, ])->content() !!}
                            @endif

                        </div>
                    </div>
                </div>
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
    include public_path('themes/theme4/views/footer.blade.php'); 
@endphp