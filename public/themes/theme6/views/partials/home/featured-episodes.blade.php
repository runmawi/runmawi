
@if (!empty($data) && $data->isNotEmpty())

<section id="iq-favorites">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 overflow-hidden">

                {{-- Header --}}
                <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <h4 class="main-title">{{ 'Featured Episodes' }}</a></h4>
                    @if($settings->homepage_views_all_button_status == 1)
                        <h4 class="main-title view-all text-primary"><a href="{{URL::to('/Featured_episodes')}}"> {{ __('View all') }}</a> </h4>
                    @endif
                </div>

                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline">
                        @foreach ($data as $key => $episode_details)
                            <li class="slide-item">
                                <a href="{{ URL::to('episode/'. $episode_details->series_title->slug.'/'.$episode_details->slug ) }}">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="{{ $episode_details->image ? URL::to('public/uploads/images/'.$episode_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                        </div>
                                        <div class="block-description">
                                            <p> {{ strlen($episode_details->title) > 17 ? substr($episode_details->title, 0, 18) . '...' : $episode_details->title }}
                                            </p>
                                            <div class="movie-time d-flex align-items-center my-2">


                                                <span class="text-white">
                                                    @if($episode_details->duration != null)
                                                        @php
                                                            $duration = Carbon\CarbonInterval::seconds($episode_details->duration)->cascade();
                                                            $hours = $duration->totalHours > 0 ? $duration->format('%hhrs:') : '';
                                                            $minutes = $duration->format('%imin');
                                                        @endphp
                                                        {{ $hours }}{{ $minutes }}
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="hover-buttons">
                                                <span class="btn btn-hover">
                                                    <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                    {{ __('Play Now')}}
                                                </span>
                                            </div>
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