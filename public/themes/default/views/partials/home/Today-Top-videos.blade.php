@if (!is_null($data))
    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">

                    <div class="text-left">

                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h2 class="main-title">
                                <a href="{{ $order_settings_list[1]->header_name ? URL::to('/').'/'.$order_settings_list[1]->url : '' }}">
                                    {{ $order_settings_list[1]->header_name ? __($order_settings_list[1]->header_name) : '' }}
                                </a>
                            </h2>  
                            @if($settings->homepage_views_all_button_status == 1)
                                <h2 class="main-title">
                                    <a href="{{ $order_settings_list[1]->header_name ? URL::to('/').'/'.$order_settings_list[1]->url : '' }}">
                                        {{ __('View All') }}
                                    </a>
                                </h2>                    
                            @endif
                        </div>

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
                    <div class="col-lg-8">
                        <div class="parallax-img">
                            <a href="{{ URL::to('category/videos/'.$data->slug ) }}">
                                <img src="{{ URL::to('public/uploads/images/' . $data->image) }}"
                                    class="img-fluid w-100" alt="bailey">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif