@php 
    include(public_path("themes/default/views/header.php"));
@endphp


    <div class="col-md-12 text-center mt-4"
        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
        <p>
        <h3 class="text-center">{{ __('No Tv-Show Videos Available') }}</h3>
    </div>


@php 
    include(public_path("themes/default/views/footer.blade.php"))
@endphp