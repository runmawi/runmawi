@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ route( 'ContinueWatchingList' ) }}">{{ ucwords('continue watching') }}</a></h4>
                        <h4 class="main-title"><a href="{{ route( 'ContinueWatchingList' ) }}">{{ ucwords('view all') }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $video_details)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="border-bg">
                                            <div class="img-box">
                                                <a class="playTrailer" href="{{ URL::to('category/videos/'.$video_details->slug ) }}">
                                                    <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

