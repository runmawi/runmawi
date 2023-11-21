
@if (!empty($data) && $data->isNotEmpty())

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 overflow-hidden">

                {{-- Header --}}
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title">{{ 'Featured Episodes' }}</a></h4>
                </div>

                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                        @foreach ($data as $key => $episode_details)
                            <li class="slide-item">
                                <a href="{{ URL::to('episode/'. $episode_details->series_title->slug.'/'.$episode_details->slug ) }}">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="{{ $episode_details->image ? URL::to('public/uploads/images/'.$episode_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                        </div>
                                        <div class="block-description">
                                            <h6> {{ strlen($episode_details->title) > 17 ? substr($episode_details->title, 0, 18) . '...' : $episode_details->title }}
                                            </h6>
                                            <div class="movie-time d-flex align-items-center my-2">

                                                <div class="badge badge-secondary p-1 mr-2">
                                                    {{ optional($episode_details)->age_restrict.'+' }}
                                                </div>

                                                <span class="text-white">
                                                    {{ $episode_details->duration != null ? gmdate('H:i:s', $episode_details->duration) : null }}
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endif