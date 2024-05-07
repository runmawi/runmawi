<?php include('header.php'); 

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
$order_settings_list = App\OrderHomeSetting::get();  
$currency = App\CurrencySetting::first();

 $parentCategories = App\LiveCategory::get();
                   ?>
                   <div class="main-content">
    <section id="iq-continue">
        <div class="container-fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
              <?php
                    foreach ($parentCategories as $category) {
                        $live_videos = App\LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
                            ->where('livecategories.category_id', '=', $category->id)
                            ->where('active', '=', '1')
                            ->get();

                        if (count($live_videos) > 0) {
                            include('partials/home/livecategory-videos.php');
                        } else {
                    ?>
                            <div class="col-md-12 text-center mt-4">
                                <h1 class="text-white text-center med">Coming Soon......</h1>
                                <img class="text-center" src="<?php echo URL::to('/assets/img/watch.png'); ?>" style="height:500px;">
                            </div>
                    <?php
                        }
                    }
                    ?>

                  <?php //include('partials/home/continue-watching.php'); ?>
              </div>
           </div>
        </div>
    </section>

<?php include('footer.blade.php');?>
