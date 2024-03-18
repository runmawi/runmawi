@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"> {{ "Suggested for you"}} </h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $videos)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <a href="{{ URL::to('category/videos/'.$videos->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{  $videos->image ? URL::to('public/uploads/images/'.$videos->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                <p> {{ strlen($videos->title) > 17 ? substr($videos->title, 0, 18) . '...' : $videos->title }}
                                                </p>
                                                <div class="movie-time d-flex align-items-center my-2">

                                                    <div class="badge badge-secondary p-1 mr-2">
                                                        {{ optional($videos)->age_restrict.'+' }}
                                                    </div>

                                                    <span class="text-white">
                                                        {{ $videos->duration != null ? gmdate('H:i:s', $videos->duration) : null }}
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
                                                'source_id'     => $videos->id ,
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