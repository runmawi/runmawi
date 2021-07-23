<!-- Header Start -->
<?php include('header.php');?>
<!-- Header End -->

<!-- MainContent -->
<div class="main-content">
  
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