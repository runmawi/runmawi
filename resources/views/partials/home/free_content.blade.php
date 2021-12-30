<div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">Free content Episodes</h4>                      
</div>

<?php
// echo '<pre>';
// print_r($free_Contents);
// exit();
?>

<div class="favorites-contens">
    <ul class="favorites-slider list-inline  row p-0 mb-0">

        <?php foreach ($free_Contents as $key => $freecontent) { ?>

            <li class="slide-item">
               
                <div class="block-images position-relative">
                    <div class="img-box">
                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$freecontent->image;  ?>" class="img-fluid w-100" alt="">
                </div>

                <div class="block-description">
                            <a href="<?php echo $freecontent->mp4_url;  ?>">
                                <h6><?php echo __($freecontent->title); ?></h6>
                            </a>


                        <div class="movie-time d-flex align-items-center my-2">
                            <div class="badge badge-secondary p-1 mr-2">13+</div>
                            <span class="text-white"><i class="fa fa-clock-o"></i>  <?= gmdate('H:i:s', $freecontent->duration); ?></span>
                        </div>
                </div>

        
            </li>


        <?php  } ?>
    </ul>
<div>