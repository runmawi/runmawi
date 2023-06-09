<?php
include public_path('themes/theme5-nemisha/views/header.php');
?>
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="text-center  mb-3"><?php echo @$CategorySeries->name; ?></h4>
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                        @if(isset($SeriesGenre)) 
                            @forelse($SeriesGenre as $Series_Genre)
                                <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                    <a href="<?php echo URL::to('/play_series/' . $Series_Genre->slug); ?>">
                                        <div class="block-images position-relative">
                                            <div class="img-box">
                                                <img src="<?php echo URL::to('/') . '/public/uploads/images/' . @$Series_Genre->image; ?>" class="img-fluid w-100" alt="">
                                            </div>
    </div>
                                            <div class="block-description">    </div>
                                                <a href="<?php echo URL::to('/play_series/') . '/' . $Series_Genre->slug; ?>">
                                                    <h6><?php echo strlen(@$Series_Genre->title) > 17 ? substr(@$Series_Genre->title, 0, 18) . '...' : @$Series_Genre->title; ?></h6>
                                                </a>
                                                <div class="hover-buttons">
                                                    <div>
                                                    </div>
                                                </div>
                                                <div>
                                                   <!-- <a class="text-white" href="<?php echo URL::to('/play_series' . '/' . $Series_Genre->slug); ?> ">
                                                        <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                        Visit Series
                                                    </a>-->
                                                </div>
                                          
                                    
                                    </a>
                                </li>
                            @empty
                                <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                                    <p ><h3 class="text-center"> {{  "No Series Available" }}</h3>
                                </div>
                            @endforelse
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
include public_path('themes/theme5-nemisha/views/footer.blade.php');
?>