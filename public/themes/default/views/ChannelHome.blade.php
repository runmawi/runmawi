<!-- Header Start -->
<?php
include public_path('themes/default/views/header.php');

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
$order_settings_list = App\OrderHomeSetting::get();
$continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();
?>

<!-- Favicon -->
<link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />


<section class="channel-header"
    style="background:url('<?php echo @$channel->channel_banner; ?>') no-repeat scroll 0 0;;background-size: cover;height:450px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
</section>

<div class="container-fluid">
    <div class="position-relative">
        <div class="channel-img">
            <img src="<?php echo @$channel->channel_logo; ?>" class=" " width="150" alt="user">
        </div>
    </div>
</div>

<section class="mt-5 mb-5">
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-2 col-lg-2">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    <?php
                    include public_path('themes/default/views/partials/channel-social-share.php    ');
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="">
    <div class="sec-3">
        <div class="container-fluid mt-5">
            <div class="mt-3 ">
                <ul class="nav nav-pills   m-0 p-0" id="pills-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" role="tab"
                            aria-controls="pills-profile" aria-selected="false">
                            All
                        </a>
                    </li>

                    <li class="nav-item videonav">
                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='video' data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Videos
                        </a>

                        <div class="Video_Categorynav">
                            <ul>
                                  @foreach ($VideoCategory as $key => $videos_category)
                                <li>
                                    <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                    data-category-id=<?php echo $videos_category->id; ?> onclick="Videos_Category(this)"
                                    href="#pills-kids" role="tab" aria-controls="pills-kids"
                                    aria-selected="false"><?php echo $videos_category->name; ?></a>
                                </li>
                                 @endforeach 
                            </ul>
                          
                            
                                

                                   
                        </div>

                        &nbsp;&nbsp;
                        
                    <li class="nav-item livenav">

                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='live' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Live
                            Stream
                        </a>

                        <div class="Live_Categorynav">
                            <?php foreach ($LiveCategory as $key => $live_category) { ?>
                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                data-category-id=<?php echo $live_category->id; ?> onclick="Live_Category(this)" href="#pills-kids"
                                role="tab" aria-controls="pills-kids" aria-selected="false"><?php echo $live_category->name; ?></a>

                            <?php }  ?>
                        </div>


                    <li class="nav-item seriesnav">

                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='series' data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Series
                        </a>

                        <div class="Series_Categorynav">
                            <?php foreach ($VideoCategory as $key => $videos_category) { ?>

                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                data-category-id=<?php echo $videos_category->id; ?> onclick="Series_Category(this)" href="#pills-kids"
                                role="tab" aria-controls="pills-kids" aria-selected="false"><?php echo $videos_category->name; ?></a>
                            <?php }  ?>
                        </div>

                        &nbsp;&nbsp;
                    <li class="nav-item audionav">

                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='audio' data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Audios
                        </a>

                        <div class="Audio_Categorynav">
                            <?php foreach ($AudioCategory as $key => $audios_category) { ?>

                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                data-category-id=<?php echo $audios_category->id; ?> onclick="Audios_Category(this)"
                                href="#pills-kids" role="tab" aria-controls="pills-kids"
                                aria-selected="false"><?php echo $audios_category->name; ?></a>

                            <?php }  ?>
                        </div>
                    </li>
                     </ul>
            </div>
        </div>
    </div>

   
  
   
</section>


<div class='channel_home'>
    <?php 
if(count($latest_video) > 0 || count($livetream) > 0 || count($latest_series) > 0 || count($audios) > 0){
      if(count($latest_video) > 0 ){
      
       ?>
    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <?php include public_path('themes/default/views/partials/home/latest-videos.php');  ?>
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
                    <?php
                    include public_path('themes/default/views/partials/home/live-videos.php');
                    ?>
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
                    <?php
                    include public_path('themes/default/views/partials/home/latest-series.php');
                    ?>
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
                    <?php
                    include public_path('themes/default/views/partials/home/latest-audios.php');
                    ?>
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
    $(document).ready(function() {
        $('.Video_Categorynav').hide();
        $('.Live_Categorynav').hide();
        $('.Series_Categorynav').hide();
        $('.Audio_Categorynav').hide();

        $('.videonav').click(function() {
            $('.Video_Categorynav').show();
            $('.Live_Categorynav').hide();
            $('.Series_Categorynav').hide();
            $('.Audio_Categorynav').hide();
        });
        $('.livenav').click(function() {
            $('.Video_Categorynav').hide();
            $('.Live_Categorynav').show();
            $('.Series_Categorynav').hide();
            $('.Audio_Categorynav').hide();
        });
        $('.seriesnav').click(function() {
            $('.Video_Categorynav').hide();
            $('.Live_Categorynav').hide();
            $('.Series_Categorynav').show();
            $('.Audio_Categorynav').hide();
        });
        $('.audionav').click(function() {
            $('.Video_Categorynav').hide();
            $('.Live_Categorynav').hide();
            $('.Series_Categorynav').hide();
            $('.Audio_Categorynav').show();
        });

    });


    function Videos_Category(ele) {
        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "<?php echo URL::to('/channel_category_videos'); ?>",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
    }

    function Series_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('channel_category_series') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
    }

    function Audios_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('channel_category_audios') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
        }

        function Live_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('channel_category_live') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
        }
</script>

<?php
    include public_path('themes/default/views/footer.blade.php');
?>
