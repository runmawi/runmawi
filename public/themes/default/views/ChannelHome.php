<!-- Header Start -->
<?php include('header.php'); 
   $order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();  
   $order_settings_list = App\OrderHomeSetting::get();  
   $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();  
   
   ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link href="<?php //echo URL::to('public/themes/theme5-nemisha/assets/fonts/font.css'); ?>" rel="stylesheet">

    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?php //echo URL::to('public/themes/theme5-nemisha/assets/css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php //echo URL::to('public/themes/theme5-nemisha/assets/css/bootstrap.min.css'); ?>" />

    <!-- Style -->
    <link rel="stylesheet" href="<?= typography_link() ?>" />

    <!-- Responsive -->
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />
    <link rel="stylesheet" href="{{ URL::to('assets/css/channel.css'); }}" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<section class="channel-header" style="background:url('<?php echo  @$channel->channel_banner ; ?>') no-repeat scroll 0 0;;background-size: cover;height:450px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
         
</section>
 <div class="container-fluid">
       <div class="position-relative">
    <div class="channel-img">
      <img src="<?php echo @$channel->channel_logo ?>" class=" " width="150" alt="user">
    </div>
              </div> </div>
<section class="mt-5 mb-5">
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-2 col-lg-2">
                
                 <!-- <a href="#"onclick="Copy();" class="outline-share" ><i class="ri-links-fill"></i></a>/ -->
                <!--<a href="" class="outline-danger">Follow</a>-->
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                        <?php include('partials/channel-social-share.php'); ?>                     
                 </ul>



            </div>
        </div>
    </div>
</section>
<section class="">
            <div class="sec-3">
                <div class="container mt-5">

                    <div class="mt-3 ">
                        <ul class="nav nav-pills   m-0 p-0" id="pills-tab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                                            role="tab" aria-controls="pills-profile" aria-selected="false">
                                            All
                                        </a>
                                    </li>

                                    &nbsp;&nbsp;
                            <li class="nav-item videonav">

                                <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                data-id-type='video' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Videos 
                                    <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> -->
                                </a>

                                <div class="Video_Categorynav">

                                    <?php foreach ($VideoCategory as $key => $videos_category) { ?> 
                                        
                                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill" 
                                            data-category-id=<?php  echo $videos_category->id ?>
                                                onclick="Videos_Category(this)" href="#pills-kids" role="tab" aria-controls="pills-kids"
                                                aria-selected="false"><?php  echo $videos_category->name  ?></a>
                                        
                                                <?php }  ?>
                                </div>

                                &nbsp;&nbsp;
                            <li class="nav-item livenav">

                                <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                data-id-type='live' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Live Stream 
                                    <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> -->
                                </a>

                                <div class="Live_Categorynav">

                                    <?php foreach ($LiveCategory as $key => $live_category) { ?> 
                                        
                                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill" 
                                            data-category-id=<?php  echo $live_category->id ?>
                                                onclick="Live_Category(this)" href="#pills-kids" role="tab" aria-controls="pills-kids"
                                                aria-selected="false"><?php  echo $live_category->name  ?></a>
                                        
                                                <?php }  ?>
                                </div>


                                &nbsp;&nbsp;
                            <li class="nav-item seriesnav">

                                <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                data-id-type='series' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Series 
                                    <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> -->
                                </a>

                                <div class="Series_Categorynav">

                                    <?php foreach ($VideoCategory as $key => $videos_category) { ?> 
                                        
                                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill" 
                                            data-category-id=<?php  echo $videos_category->id ?>
                                                onclick="Series_Category(this)"  href="#pills-kids" role="tab" aria-controls="pills-kids"
                                                aria-selected="false"><?php  echo $videos_category->name  ?></a>
                                        
                                                <?php }  ?>
                                </div>

                                &nbsp;&nbsp;
                            <li class="nav-item audionav">

                                <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                data-id-type='audio' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Audios 
                                    <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> -->
                                </a>

                                <div class="Audio_Categorynav">

                                    <?php foreach ($AudioCategory as $key => $audios_category) { ?> 
                                        
                                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill" 
                                            data-category-id=<?php  echo $audios_category->id ?>
                                                onclick="Audios_Category(this)" href="#pills-kids" role="tab" aria-controls="pills-kids"
                                                aria-selected="false"><?php  echo $audios_category->name  ?></a>
                                        
                                                <?php }  ?>
                                </div>
                    </div>
                </div>
            </div>

            </ul>
            </div>
            <div class="container">

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">

                        <div class="row favorites-sli1 data">
                        </div>


                        <div class="row mt-2"></div>
                    </div>

                    <div class="text-center mt-3 mb-5 pb-2 col-lg-3 all-video">
                        <!-- <a class="btn btn-success my-2 my-sm-0 w-100" style="font-weight:600;font-size: 20px;"
                            herf="#"><span>All Videos <i class="fa fa-angle-right"
                                    aria-hidden="true"></i></span>
                        </a> -->
                    </div>
                </div>
            </div>
        </section>


<!-- <div class='data'> </div> -->
<div class='data'> 
<?php 
if(count($latest_video) > 0 || count($livetream) > 0 || count($latest_series) > 0 || count($audios) > 0){
      if(count($latest_video) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-videos.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php }  ?>

   <?php 
      if(count($livetream) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/live-videos.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php }  ?>


   <?php 
      if(count($latest_series) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-series.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php }  ?>


   <?php 
      if(count($audios) > 0 ){
      
       ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-audios.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } }else{ ?>
      <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
             <h4 class="main-title mb-4">Sorry! There are no contents under this genre at this moment.</h4>
               <a href="https://ssflix.tv/" class="outline-danger1">Home</a>
         </div>
<?php   } ?>
</div>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
$( document ).ready(function() {
    $( '.Video_Categorynav' ).hide();
    $( '.Live_Categorynav' ).hide();
    $( '.Series_Categorynav' ).hide();
    $( '.Audio_Categorynav' ).hide();

    $('.videonav').click(function(){
        $( '.Video_Categorynav' ).show();
        $( '.Live_Categorynav' ).hide();
        $( '.Series_Categorynav' ).hide();
        $( '.Audio_Categorynav' ).hide();
    });
    $('.livenav').click(function(){
        $( '.Video_Categorynav' ).hide();
        $( '.Live_Categorynav' ).show();
        $( '.Series_Categorynav' ).hide();
        $( '.Audio_Categorynav' ).hide();
    });
    $('.seriesnav').click(function(){
        $( '.Video_Categorynav' ).hide();
        $( '.Live_Categorynav' ).hide();
        $( '.Series_Categorynav' ).show();
        $( '.Audio_Categorynav' ).hide();
    });
    $('.audionav').click(function(){
        $( '.Video_Categorynav' ).hide();
        $( '.Live_Categorynav' ).hide();
        $( '.Series_Categorynav' ).hide();
        $( '.Audio_Categorynav' ).show();
    });

});


function Videos_Category(ele) {
    var category_id = $(ele).attr('data-category-id');
    // alert(category_id);

    $.ajax({
        type: "get",
        url: "<?php echo URL::to('/channel_category_videos') ?>",
        data: {
            _token: "{{ csrf_token() }}",
            category_id: category_id,
        },
        success: function(data) {
            $(".ALLdata").empty();
            $(".data").html(data);

        },
    });
}

function Series_Category(ele) {
    var category_id = $(ele).attr('data-category-id');
    // alert(category_id);

    $.ajax({
        type: "get",
        url: "<?php echo URL::to('/channel_category_series') ?>",
        data: {
            _token: "{{ csrf_token() }}",
            category_id: category_id,
        },
        success: function(data) {
            console.log(data);
            // $(".ALLdata").empty();

            $(".data").html(data);

        },
    });
}

</script>

   <?php
//    include(public_path('themes/default/views/partials/home/Trailer-script.php'));
//    include(public_path('themes/default/views/partials/home/home_pop_up.php'));
   ?>
<?php include('footer.blade.php');?>