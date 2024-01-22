@if (!is_null($data))
    <section id="parallax" class="parallax-window" style="background: url('{{ URL::to('public/uploads/images/' . $data->player_image) }}') center center;background-repeat:no-repeat;background-size:cover;">
        <div class="container-fluid h-100">
            <div class="row align-items-center justify-content-center h-100 parallaxt-details">
                <div class="col-lg-4 r-mb-23">
                    <div class="text-left">


                        <a href="{{ URL::to('category/videos/'.$data->slug ) }}">
                            <h3 class="trending-text big-title text-uppercase">{{ optional($data)->title }}</h3>
                        </a>

                        <div class="parallax-ratting d-flex align-items-center mt-3 mb-3">
                            @if( optional($data)->rating )
                                <ul class="ratting-start p-0 m-0 list-inline text-primary d-flex align-items-center justify-content-left">
                                    @php $rating = ($data->rating / 2) ; @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($rating >= $i)
                                            <li><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        @elseif ($rating + 0.5 == $i)
                                            <li><i class="fa fa-star-half-o" aria-hidden="true"></i></a></li>
                                        @else
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                                        @endif
                                    @endfor
                                </ul>
                            @endif
                            
                            <span class="text-white ml-3">{{ $data->rating ? ( $data->rating / 2 ) : " "  }}</span>
                        </div>
                        <div class="movie-time d-flex align-items-center mb-3">
                            <div class="badge badge-secondary mr-3">{{ optional($data)->age_restrict.'+' }}</div>
                            <h6 class="text-white"> {{ $data->duration !=null ? Carbon\CarbonInterval::seconds($data->duration)->cascade()->format('%im %ss') : null }}
                            </h6>
                        </div>
                        <p> {!! html_entity_decode( optional($data)->description ) !!}</p>
                        <div class="parallax-buttons">
                            <a href="{{ URL::to('category/videos/'.$data->slug ) }}" class="btn btn-hover">Play Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="parallax-img">
                        <a href="{{ URL::to('category/videos/'.$data->slug ) }}">
                            <img src="{{ URL::to('public/uploads/images/' . $data->image) }}"
                                class="img-fluid" alt="bailey">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif