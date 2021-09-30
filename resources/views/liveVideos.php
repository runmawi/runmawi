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


<div class="container-fluid movlistt">
    
    <div class="row">
      <div class="col-sm-12 overflow-hidden">
         <div class="iq-main-header d-flex align-items-center justify-content-between">
            <h4 class="main-title">Live Videos</h4>
<!--            <a href="show-single.html" class="text-primary">View all</a>-->
         </div>
      </div>
   </div>
    
      <!-- MainContent -->
   <div class="main-content">
      <section class="movie-detail ">
         <div class="row">
             <?php if(isset($videos)) :
            foreach($videos as $video): ?>
            <div class="col-1-5 col-md-6 iq-mb-30">
                 <div class="epi-box">
                    <div class="epi-img position-relative">
                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid img-zoom" alt="">
                       <div class="episode-play-info">
                          <div class="episode-play">
                             <a href="<?= URL::to('/') ?><?= '/live/play/' . $video->id ?>">
                                <i class="ri-play-fill"></i>
                             </a>
                          </div>
                       </div>
                    </div>
                    <div class="epi-desc p-3">
                       <div class="d-flex align-items-center justify-content-between">
                          <span class="text-white"><?= ucfirst($video->title); ?></span>
                       </div>
                       <a href="<?= URL::to('/') ?><?= '/live/play/' . $video->id ?>">
                          <h6 class="epi-name text-white mb-0"><i class="fa fa-clock-o"></i> Live Now</h6>
                       </a>
                    </div>
                 </div>
            </div>
              <?php endforeach; 
        endif; ?>
         </div>
      </section>
    </div>
</div>

<?php include('footer.blade.php');?>