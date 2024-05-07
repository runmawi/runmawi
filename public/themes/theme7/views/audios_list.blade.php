@php
    include public_path('themes/theme7/views/header.php');
@endphp

<div class="main-content">
    <section id="iq-favorites">
        <h2 class="text-center  mb-3"> {{ 'Audios' }} </h2>
        <div class="container-fluid">
            <div class="row pageheight">
                <div class="col-sm-12 overflow-hidden">

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
                                                        <h6> {{ strlen($audios_data->title) > 17 ? substr($audios_data->title, 0, 18) . '...' : $audios_data->title }}
                                                        </h6>
                                                        <div class="movie-time d-flex align-items-center my-2">

                                                            <div class="badge badge-secondary p-1 mr-2">
                                                                {{ $audios_data->age_restrict . ' ' . '+' }}
                                                            </div>

                                                            <span class="text-white">
                                                                {{ $audios_data->duration != null ? gmdate('H:i:s', $audios_data->duration) : null }}
                                                            </span>
                                                        </div>

                                                        <div class="hover-buttons">
                                                            <span class="btn btn-hover">
                                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                                Play Now
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="block-social-info">
                                                        <ul class="list-inline p-0 m-0 music-play-lists">
                                                            {{-- <li><span><i class="ri-volume-mute-fill"></i></span></li> --}}
                                                            <li><span><i class="ri-heart-fill"></i></span></li>
                                                            <li><span><i class="ri-add-line"></i></span></li>
                                                        </ul>
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
    include public_path('themes/theme7/views/footer.blade.php');
@endphp
