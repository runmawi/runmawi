@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="{{ $order_settings_list[1]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ optional($order_settings_list[1])->header_name }}</a></h4>
                        <h4 class="main-title"><a href="{{ $order_settings_list[1]->url ? URL::to($order_settings_list[1]->url) : null }} ">{{ 'view all' }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            @foreach ($data as $key => $latest_video)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        
                                        <a href="{{ URL::to('category/videos/'.$latest_video->slug ) }}">

                                            <div class="img-box">
                                                <img src="{{ $latest_video->image ?  URL::to('public/uploads/images/'.$latest_video->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            
                                        </a>
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





<style>
  
 .favorites-contens .favorites-slider {
    background: conic-gradient(at 50% var(--s),#222 75%,#0000 0) 0 0/calc(2*var(--s)) calc(100% - var(--s)) padding-box;
    border: var(--s) solid #222;
    --s: 10px;
    padding: 38px 0 !important;
}
</style>