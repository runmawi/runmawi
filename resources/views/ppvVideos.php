<?php include('header.php'); ?>


<style>

.pagination>li>a, .pagination>li>span {
    position: relative;
    float: left;
    padding: 11px 15px;
    line-height: 1.42857143;
    text-decoration: none;
    color: #eff2f5;
    background-color: #000;
    border: 1px solid #34383a;
    margin-left: -1px;
}
.pagination a {
    display: inline-block;
    width: 32px;
    height:     36px;
    margin: 0 10px;
    text-indent: -9999px;
}
    .pagination li a {
        color:#ffff;
    }
.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
    z-index: 2;
    color: #fff;
    background-color: #8c8c8c;
    border-color: #428bca;
    cursor: default;
    width: 32px;
    height: 36px;
    text-align: center;
}
.pagination>.disabled>span, .pagination>.disabled>span:hover, .pagination>.disabled>span:focus, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus {
    color: #fff;
    background-color: #0a0a0a;
    border-color: #ddd;
    cursor: not-allowed;
    height: 36px;
}


</style>


<div class="container movlistt">
    
    <div class="new-art">
        <h4 class="Continue Watching text-left padding-top-40">PAY PER VIEW</h4>
	    <div class="border-line" style="margin-bottom:15px;margin-top:20px;"></div>
    </div>
    
    <div class="row">
        <?php if(isset($data)) :
            foreach($data as $video): ?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
                <article class="block expand">
                    <a class="block-thumbnail" href="<?= URL::to('/') ?><?= '/ppvVideos/play_videos/' . $video->id ?>">
                        <div class="play-button">
                            <div class="play-block">
                                <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                            </div>
                            <div class="detail-block">
                            <p class="movie-title"><?= ucfirst($video->title); ?></p>
                            <p class="movie-rating">
                                <span class="star-rate"><i class="fa fa-star"></i><?= $video->rating;?></span>
                                <span class="viewers"><i class="fa fa-eye"></i>(<?= $video->views;?>)</span>
                                <span class="running-time"><i class="fa fa-clock-o"></i><?=$video->duration; ?></span>
                            </p>
                            </div>
                            <!-- <div class="thriller"> <p><?// $video->genre->name;?></p></div> -->
                        </div>
                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->player_image;  ?>">
                    </a>
                     <div class="block-contents">
                        <p class="movie-title padding"><?php echo $video->title; ?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; 
        endif; ?>
        
    </div>
    <?php echo $data->links("pagination::bootstrap-4");?>
    
</div>

<?php include('footer.blade.php');?>