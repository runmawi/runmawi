<?php
   include(public_path('themes/theme4/views/header.php'));
        // dd($AudioCategory);
        ?>
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 page-height">
                <div class="iq-main-header align-items-center justify-content-between">
                    <h4 class="movie-title">Audio Genre <?php echo @$CategoryAudio->name ?></h4>                     
                </div>
                <div class="favorites-contens">
                    <ul class="category-page list-inline row p-0 mb-0">
                      <?php if(isset($AudioCategory)) {
                        foreach($AudioCategory as $Audio_Category){ ?>
                            <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                                <a href="<?php echo URL::to('/audio/'.$Audio_Category->slug ) ?>">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.@$Audio_Category->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                            
                                        <div class="block-description" >
                                                <a href="<?php echo URL::to('/audio/').'/'.$Audio_Category->slug  ?>">
                                                    <h6><?php  echo (strlen(@$Audio_Category->title) > 17) ? substr(@$Audio_Category->title,0,18).'...' : @$Audio_Category->title; ?></h6>
                                                </a>
                                            <div class="hover-buttons"><div>
                                        </div>
                                    </div>
                                    <div>
                                    <a class="text-white" href="<?php echo URL::to('/audio'.'/'.$Audio_Category->slug  ) ?> " >
                                            <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                        Visit Audio Player
                                        </a>
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
   include(public_path('themes/theme4/views/footer.blade.php'));
   ?>