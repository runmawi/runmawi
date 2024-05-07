<?php
   include(public_path('themes/theme1/views/header.php'));
?>

<style>
/* <!-- BREADCRUMBS  */
.bc-icons-2 .breadcrumb-item+.breadcrumb-item::before {
    content: none;
}

ol.breadcrumb {
    color: white;
    background-color: transparent !important;
    font-size: revert;
}

.nav-div.container-fluid {
    padding: 0;
}
</style>

<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                

                <!-- BREADCRUMBS -->
                <div class="row d-flex">
                    <div class="nav-fill container-fluid nav-div" id="nav-tab" role="tablist">
                        <div class="bc-icons-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('series.tv-shows') ?>"><?= ucwords(__('Series')) ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a class="black-text"
                                        href="<?= route('SeriescategoryList') ?>"><?= ucwords(__('Category')) ?></a>
                                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                                </li>

                                <li class="breadcrumb-item"><a
                                        class="black-text"><?php echo strlen($CategorySeries->name) > 50 ? __(ucwords(substr($CategorySeries->name, 0, 120) . '...')) : __(ucwords($CategorySeries->name)); ?>
                                    </a></li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="movie-title"> <?php echo __(@$CategorySeries->name) ?></h4>
                </div>

                <div class="favorites-contens">
                    <ul class="category-page seriescategf list-inline row p-0 mb-0">
                        <?php if(isset($SeriesGenre)) {
                        foreach($SeriesGenre as $Series_Genre){ ?>
                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                            <a href="<?php echo URL::to('/play_series/'.$Series_Genre->slug ) ?>">
                                <div class="block-images position-relative">
                                    <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Series_Genre->image;  ?>"
                                            class="img-fluid w-100" alt="">
                                    </div>

                                    <div class="block-description">
                                        <!-- <a href="<?php echo URL::to('/play_series/').'/'.$Series_Genre->slug  ?>">
                                            <h6><?php  echo (strlen(@$Series_Genre->title) > 17) ? substr(@$Series_Genre->title,0,18).'...' : @$Series_Genre->title; ?>
                                            </h6>
                                        </a>
                                        <div class="hover-buttons">
                                            <div>
                                            </div>
                                        </div> -->
                                        <div>
                                            <a class="text-white"
                                                href="<?php echo URL::to('/play_series'.'/'.$Series_Genre->slug  ) ?> ">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                                <?= (__('Visit Series'))  ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
   $(document).ready(function(){
      $('.seriescategf').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        dots: false,
        speed: 300,
        infinite: true,
        autoplaySpeed: 5000,
        autoplay: true,
        responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 534,
        settings: {
          slidesToShow: 2,
        }
      }
    ]
      });
    });
</script>


<?php
   include(public_path('themes/theme1/views/footer.blade.php'));
   ?>