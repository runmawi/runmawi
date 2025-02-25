<?php
    include public_path('themes/theme3/views/header.php');

    $parentCategories = App\SeriesGenre::orderBy('order', 'ASC')->get();

    $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')
        ->pluck('video_name')
        ->toArray();

    $order_settings_list = App\OrderHomeSetting::get();
    $home_settings = App\HomeSetting::first();

    $slider_choosen = $home_settings->slider_choosen == 2 ? "slider-2" : "slider-1 ";
  
?>

@if (Session::has('message'))
    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
@endif

                {{-- Slider --}}

<section id="home" class="iq-main-slider p-0">
    <div id="home-slider" class="home-sliders slider m-0 p-0">
        {!! Theme::uses($current_theme)->load("public/themes/{$current_theme}/views/partials/home/{$slider_choosen}", $Slider_array_data )->content() !!}
    </div>
 </section>

<section>
    <div class="main-content">

                    {{-- Series   --}}

        {!! Theme::uses('theme6')->load('public/themes/theme3/views/partials/home/latest-series', [
                'data' => $latest_series,
                'order_settings_list' => $order_settings_list,
            ])->content() !!}

                    {{-- Free Content  --}}

        {!! Theme::uses('theme6')->load('public/themes/theme3/views/partials/home/free_content', [
                'data' => $free_Contents,
                'order_settings_list' => $order_settings_list,
            ])->content() !!}

                    {{-- Latest Episode  --}}

        {!! Theme::uses('theme6')->load('public/themes/theme3/views/partials/home/latest-episodes', [
                'data' => $latest_episodes,
                'order_settings_list' => $order_settings_list,
            ])->content() !!}

                    {{-- featured Episodes  --}}

        {!! Theme::uses('theme6')->load('public/themes/theme3/views/partials/home/featured-episodes', [
                'data' => $featured_episodes,
                'order_settings_list' => $order_settings_list,
            ])->content() !!}


        @foreach ($order_settings as $key => $item)

                {{-- Series Genre  --}}

            @if ($item == 'Series_Genre' && $home_settings->SeriesGenre == 1)
                {!! Theme::uses('theme6')->load('public/themes/theme3/views/partials/home/SeriesGenre', [
                        'data' => $parentCategories,
                        'order_settings_list' => $order_settings_list,
                    ])->content() !!}
            @endif

                {{-- Series video based on Genre   --}}

            @if ($item == 'Series_Genre_videos' && $home_settings->SeriesGenre_videos == 1)    
                @foreach ($parentCategories as $category)
                    @php
                        $series = App\Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                            ->where('category_id', $category->id)
                            ->where('active', '1')
                            ->latest('series.created_at')
                            ->groupBy('series.id')
                            ->get();
                    @endphp

                    {!! Theme::uses('theme6')->load('public/themes/theme3/views/partials/home/seriescategoryloop', [
                            'data' => $series,
                            'category' => $category,
                            'order_settings_list' => $order_settings_list,
                        ])->content() !!}
                @endforeach
            @endif
        @endforeach
    </div>
</section>

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

<?php include public_path('themes/theme3/views/footer.blade.php'); ?>