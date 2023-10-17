<!-- Header Start -->
<?php include 'header.php'; ?>

<?php  if (Session::has('message')){ ?>
   <div id="successMessage" class="alert alert-info"><?php echo Session::get('message'); ?></div>
<?php } ?>

   <?php
   
     $slider_choosen = App\HomeSetting::pluck('slider_choosen')->first();  
     $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
     $order_settings_list = App\OrderHomeSetting::get();  
     $home_settings = App\HomeSetting::first() ;
     $ThumbnailSetting =  App\ThumbnailSetting::first();
     
      if(count($errors) > 0){
         foreach( $errors->all() as $message ){ ?>
            <div class="alert alert-danger display-hide" id="successMessage">
               <button id="successMessage" class="close" data-close="alert"></button>
               <span><?php echo $message; ?></span>
            </div>
   <?php } } ?>

   <section id="home" class="iq-main-slider p-0">
      <div id="home-slider" class="slider m-0 p-0">
         <?php
               if($slider_choosen == 2){
                  include('partials/home/slider-2.php'); 
               }
               else{
                  include('partials/home/slider-1.blade.php'); 
               }
         ?>
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
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <?php include 'partials/home/latest-series.blade.php'; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <?php include 'partials/home/free_content.blade.php'; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <?php include 'partials/home/latest-episodes.php'; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <?php include 'partials/home/featured-episodes.php'; ?>
                </div>
            </div>
        </div>
    </section>
   <?php foreach($order_settings as $key => $value){  
    

    if($value->video_name == 'Series_Genre'){
    
    if($home_settings->SeriesGenre == 1){ ?>
            <section id="iq-favorites">
                    <div class="container-fluid overflow-hidden">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <?php include 'partials/home/SeriesGenre.php'; ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } } ?>
            <?php
            if($value->video_name == 'Series_Genre_videos'){

            if($home_settings->SeriesGenre_videos == 1){ ?>
                <section id="iq-tvthrillers" class="s-margin">

            <?php
               $parentCategories = App\SeriesGenre::all();
               foreach($parentCategories as $category) {

                $Episode_videos =  App\Series::select('episodes.*','series.title as series_name','series.slug as series_slug')
                ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                ->join('episodes', 'episodes.series_id', '=', 'series.id')
                ->where('series_categories.category_id','=',$category->id)
                ->where('episodes.active', '=', '1')
                ->where('series.active', '=', '1')
                ->groupBy('episodes.id')
                ->latest('episodes.created_at')
                ->get();
                
               $series = App\Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                 ->where('category_id','=',$category->id)->where('active', '=', '1')
                                 ->where('active', '=', '1');
                $series = $series->latest('series.created_at')->get();
                // dd($series);
            ?>

            <?php 
               if (count($series) > 0) { 
                  include('partials/home/seriescategoryloop.php');
               } 
               else { 
            ?>
               <p class="no_video"></p>
            <?php } }?>
    </section>
            <?php } } ?>

        <?php } ?>
    <section id="iq-tvthrillers" class="s-margin">
        <div class="container-fluid overflow-hidden">

            <?php
               $parentCategories = App\SeriesGenre::all();
               foreach($parentCategories as $category) {
               $series = App\Series::where('genre_id','=',$category->id)->get();
            ?>

            <?php 
               if (count($series) > 0) { 
                  include('partials/category-seriesloop.php');
               } 
               else { 
            ?>
               <p class="no_video"></p>
            <?php } }?>
        </div>
    </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);

        $(".main-content , .main-header , .container-fluid").click(function() {
            $(".home-search").hide();
        });
    })
</script>

<?php include 'footer.blade.php'; ?>