@php
    include public_path('themes/theme3/views/header.php');
@endphp

<div class="main-content">
    <section id="">
               
        <div class="container-fluid">
            <div class="row pageheight">
                <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="vid-title">{{ 'Audios' }}</h4>                     
                </div>
                    <div class="data">
                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                @if (count($audios) > 0)
                                    @foreach($audios as $key => $audios_data)
                                        <li class="slide-item">
                                            <a href="{{ URL::to('audio/' . $audios_data->slug) }}">
                                                <div class="block-images position-relative">
                                                    <div class="img-box">
                                                        <img src="{{ URL::to('public/uploads/images/' . $audios_data->image) }}" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="block-description">

                                                        <div class="hover-buttons">
                                                            <a class="" href="{{ URL::to('audio/' . $audios_data->slug) }}">
                                                                <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                                    <span class="text pr-2"> Play </span>
                                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                                    </svg>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                @endforeach
                                @elseif(count($audios) == 0)
                                    <div class="col-md-12 text-center mt-4"
                                        style="background: url(<?= URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat:
                                    no-repeat;background-size:contain;height: 500px!important;">
                                        <p>
                                        <h3 class="text-center">No Audios Available</h3>
                                    </div>
                                @endif
                            </ul>
                        </div>
                        





                       

                        <div class="col-md-12 pagination justify-content-end">
                            {!! count($audios) != 0 ? $audios->links() : ' ' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@php
    include public_path('themes/theme3/views/footer.blade.php');
@endphp
