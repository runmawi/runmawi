@php
    include(public_path('themes/theme6/views/header.php')) ; 
    $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->pluck('video_name')->toArray();  
    $order_settings_list = App\OrderHomeSetting::get();  
@endphp

<div>
    {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/videos-based-categories', ['order_settings_list' => $order_settings_list ])->content() !!}
</div>

<style>
    .view-all{display: none;}
</style>

@php
    include(public_path('themes/theme6/views/footer.blade.php'))
@endphp