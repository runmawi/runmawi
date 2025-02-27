@if (!empty($data) && $data->isNotEmpty())

    <section id="iq-favorites">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 overflow-hidden">

                    {{-- Header --}}
                    <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="<?php echo URL::to('continue-watching-list') ?>">{{ (__(ucwords('continue watching'))) }}</a></h4>
                        <h4 class="main-title"><a href="<?php echo URL::to('continue-watching-list') ?>">{{ (__(ucwords('View all'))) }}</a></h4>
                    </div>

                    <div class="favorites-contens">
                        <ul class="favorites-slider list-inline p-0 mb-0">
                            @foreach ($data as $key => $video_details)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <a href="{{ URL::to('category/videos/'.$video_details->slug ) }}">
                                            <div class="img-box">
                                                <img src="{{ $video_details->image ?  URL::to('public/uploads/images/'.$video_details->image) : default_vertical_image_url() }}" class="img-fluid" alt="">
                                            </div>

                                            <div class="block-description">
                                                

                                                <div class="hover-buttons">
                                                    <a class="" href="{{ URL::to('category/videos/'.$video_details->slug ) }}">
                                                        <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                            <span class="text pr-2"> {{ (__('Play')) }} </span>
                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                                <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                                <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
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

<script>
    $(document).ready(function(){
    $('.favorites-slider').slick({
        dots: false,
			slidesToShow: 6,
			slidesToScroll: 1,
			arrows: true,
			infinite: false,
			speed: 300,
			autoplay: false,		
			// appendArrows: $('#sm-slick-arrow'),
			
			nextArrow: '<a href="#" class="slick-arrow slick-next"><i class= "fa fa-chevron-right"></i></a>',
			prevArrow: '<a href="#" class="slick-arrow slick-prev"><i class= "fa fa-chevron-left"></i></a>',
			responsive: [
			{
				breakpoint: 1200,
				settings: {
				slidesToShow: 5,
				slidesToScroll: 1,
				infinite: true,
				dots: false,
				}
			},
			{
				breakpoint: 768,
				settings: {
				slidesToShow: 4,
				slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
				// arrows: false,
				slidesToShow: 2,
				slidesToScroll: 1
				}
			},
			{
				breakpoint: 320,
				settings: {
				slidesToShow: 2,
				slidesToScroll: 1
				}
			}
			]
    });
});
</script>