@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="#">{{ ucwords('continue watching') }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $video_details)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <a href="{{ URL::to('category/videos/'.$video_details->slug ) }}">
                                            <div class="img-box">
                                                <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <p> {{ strlen($video_details->title) > 17 ? substr($video_details->title, 0, 18) . '...' : $video_details->title }}</p>
                                                
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($video_details)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $video_details->duration != null ? gmdate('H:i:s', $video_details->duration) : null }}
                                                    </span>
                                                </div>

                                                <div class="hover-buttons">
                                                    <span class="btn btn-hover">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Play Now
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                        {{-- WatchLater & wishlist --}}

                                        @php
                                            $inputs = [
                                                'source_id'     => $video_details->id ,
                                                'type'          => 'channel',  // for videos - channel
                                                'wishlist_where_column'    => 'video_id',
                                                'watchlater_where_column'  => 'video_id',
                                            ];
                                        @endphp

                                        {!! Theme::uses('theme6')->load('public/themes/theme6/views/partials/home/HomePage-wishlist-watchlater', $inputs )->content() !!}

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

