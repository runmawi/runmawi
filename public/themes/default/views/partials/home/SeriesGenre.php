<?php
   include(public_path('themes/default/views/header.php'));
        // dd($Live_Category);
        ?>
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="movie-title">Series Genre</h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      <?php if(isset($SeriesGenre)) {
                        foreach($SeriesGenre as $Series_Genre){ ?>
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="<?php echo URL::to('/series/category/'.$SeriesGenre->slug ) ?>">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$LiveCategory->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <a href="<?php echo URL::to('/series/category').'/'.$LiveCategory->slug  ?>">
                                                    <h6><?php  echo (strlen(@$LiveCategory->title) > 17) ? substr(@$LiveCategory->title,0,18).'...' : @$LiveCategory->title; ?></h6>
                                                </a>
                                            <div class="hover-buttons"><div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= @$LiveCategory->id;?>">
                                            <span class="text-center thumbarrow-sec"></span>
                                        </button>
                                    </div> </div> </div>
                                </a>
                            </li>
                            
                           <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
   include(public_path('themes/default/views/footer.blade.php'));
   ?>