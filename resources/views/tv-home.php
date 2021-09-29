<!-- Header Start -->
<?php include('header.php');?>
<!-- Header End -->
<section id="home" class="iq-main-slider p-0">
    <div id="home-slider" class="slider m-0 p-0">
        <?php include('partials/home/slider.php'); ?>
    </div>
 <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
       fill="none" stroke="currentColor">
       <circle r="20" cy="22" cx="22" id="test"></circle>
    </symbol>
 </svg>
</section>

<!-- MainContent -->
<div class="main-content">
    
<section id="iq-favorites">
    <div class="fluid">
      <div class="row">
        <div class="col-sm-12 overflow-hidden">
          <?php include('partials/home/latest-series.php'); ?>
        </div>
      </div>
    </div>
  </section>

  <section id="iq-favorites">
    <div class="fluid">
      <div class="row">
        <div class="col-sm-12 overflow-hidden">
          <?php include('partials/home/latest-episodes.php'); ?>
        </div>
      </div>
    </div>
  </section>

  <section id="iq-tvthrillers" class="s-margin">
         <div class="fluid">
        <?php
        $parentCategories = App\Genre::all();
        foreach($parentCategories as $category) {
          $series = App\Series::where('genre_id','=',$category->id)->get();
          ?>
          <?php if (count($series) > 0) { 
           include('partials/category-seriesloop.php');
          } else { ?>
            <p class="no_video"> <!--<?php echo __('No Series Found');?>--></p>
          <?php } ?>
        <?php }?>
      </div>
  </section> 
</div>
<?php include('footer.blade.php');?>