<!-- Header Start -->
<?php
include public_path('themes/theme1/views/header.php');

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
$order_settings_list = App\OrderHomeSetting::get();
$continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();
?>

  <!-- Style -->
<link rel="preload" href="<?= URL::to('/'). '/assets/css/style.css';?>" as="style"/>
<link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" />


<style>
    hr{
        border-top:none!important;
        height: 1px;
         background-image: linear-gradient(90deg, white, transparent);
    }
    .lkn{
        cursor: pointer;
    }
    .tab-pane{padding:0;overflow: hidden;height: 100%;}
    /* .channel_home{height:60%;} */
    .tab-pane .nav-link{z-index: 9; position: relative;}
    .Video_Categorynav{display:flex !important}
    .video-category-container {
    display: flex;
    align-items: center;
}

.video-category-wrapper {
    overflow: hidden;
    flex-grow: 1;
    display: flex;
}

.video-category {
    display: flex;
    transition: transform 0.3s ease;
}

.video-category > div {min-width: 150px; margin: 0 5px;}

.prev-btn, .next-btn {background-color: var(--iq-primary);color:#fff;border: none;cursor: pointer;padding: 10px;border-radius: 3px;}
.channel_nav .nav-link.active{background-color: var(--iq-primary) !important;}
.tab-pane .nav-link:hover{background-color: var(--iq-primary) !important;}
.prev-btn:disabled, .next-btn:disabled {cursor: not-allowed;opacity: 0.5;}
.block-images .hover-buttons{width:50%;}

</style>
<!-- Favicon -->
<link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script  src="<?= URL::to('/'). '/assets/js/plyr.polyfilled.js';?>"></script>
<script  src="<?= URL::to('/'). '/assets/js/hls.js';?>"></script>

@if(!empty($channel_partner->channel_banner) && $channel_partner->channel_banner != null)
<section class="channel-header"
    style="background:url('<?php echo @$channel_partner->channel_banner; ?>') no-repeat scroll 0 0;;background-size: cover;height:350px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
</section>
@else
<section class="channel-header"
    style="background:url('<?= URL::to('/') . '/public/uploads/images/' . $settings->default_horizontal_image ?>') no-repeat scroll 0 0;;background-size: cover;height:350px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
</section>
@endif
<div class="container-fluid">
    <div class="position-relative">
        <div class="channel-img">
            @if(!empty($channel_partner->channel_logo) && $channel_partner->channel_logo != null)
                <img src="<?php echo $channel_partner->channel_logo;  ?>"  class=" " width="150" alt="user">
            @else
                <img src="<?= URL::to('/') . '/public/uploads/images/' . $settings->default_video_image ?>"  class=" " width="150" alt="user">
            @endif
        </div>
    </div>
</div>

<section class="mt-5 mb-5">
    <div class="container-fluid">
            <div class="row ">
                <div class="col-6 col-lg-6">

                    <div class="channel-about">
                        @if(!empty($channel_partner->channel_about) && $channel_partner->channel_about != null)
                        <h6>{{ __('About Channel') }} : <?php echo $channel_partner->channel_about;  ?></h6> 
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">

                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    @php
                        include(public_path('themes/theme7/views/partials/channel-social-share.php'));
                    @endphp
                </ul>
            </div>
            @if(!empty(@$channel_partner) && $channel_partner->intro_video != null)
                <div class="col-12 col-lg-6">
                    <a class="lkn" data-video="{{ @$channel_partner->intro_video }}" data-toggle="modal" data-target="#videoModal" data-backdrop="static" data-keyboard="false"  style="cursor: pointer;">	
                        <span class="text-white">
                        <i class="fa fa-play mr-1" aria-hidden="true"></i> {{  __('About Channel Partner')  }}
                        </span>
                    </a>


                    <div class="modal fade modal-xl" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background-color: transparent;border:none;">
                                <button type="button" class="close" style='color:red;' data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="modal-body">
                                    <video id="videoPlayer1" 
                                        controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                                        type="video/mp4" src="{{ @$channel_partner->intro_video }}">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
        
                </div>
            @endif
            </div>
        </div>
    </div>
</section>
<section class="channel_nav">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item Allnav">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{  __('All')  }}</a>
            </li>
            <li class="nav-item videonav">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{  __('Videos')  }}</a>
            </li>
            <li class="nav-item livenav">
                <a class="nav-link" id="live-tab" data-toggle="tab" href="#live" role="tab" aria-controls="profile" aria-selected="false">{{  __('Live Stream')  }}</a>
            </li>
            <li class="nav-item seriesnav">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{  __('Series')  }}</a>
            </li>
            <li class="nav-item audionav">
                <a class="nav-link" id="Audios-tab" data-toggle="tab" href="#Audios" role="tab" aria-controls="contact" aria-selected="false">{{  __('Audio')  }}</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <hr >
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <hr>
                
                <div class="video-category-container">
                    <button class="prev-btn" onclick="scrollCategory(-1)">&#10094;</button>
                    <div class="video-category-wrapper">
                        <div class="video-category">
                            @foreach ($VideoCategory as $key => $videos_category)
                                <div>
                                    <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill" data-category-id={{ $videos_category->id }} onclick="Videos_Category(this)"
                                    href="#pills-kids" role="tab" aria-controls="pills-kids"
                                    aria-selected="false">{{ $videos_category->name }}
                                    </a>
                                </div>
                            @endforeach 
                        </div>
                    </div>
                    <button class="next-btn" onclick="scrollCategory(1)">&#10095;</button>
                </div>

            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <hr>
                <div class="Series_Categorynav ">
                    <?php foreach ($SeriesGenre as $key => $series_category) { ?>
                        <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                            data-category-id=<?php echo $series_category->id; ?> onclick="Series_Category(this)" href="#pills-kids"
                            role="tab" aria-controls="pills-kids" aria-selected="false"><?php echo $series_category->name; ?>
                        </a>
                    <?php }  ?>
                </div>
            </div>
            <div class="tab-pane fade" id="Audios" role="tabpanel" aria-labelledby="Audios-tab">
                <hr>
                <div class="Audio_Categorynav d-flex">
                    <?php foreach ($AudioCategory as $key => $audios_category) { ?>
                        <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                            data-category-id=<?php echo $audios_category->id; ?> onclick="Audios_Category(this)"
                            href="#pills-kids" role="tab" aria-controls="pills-kids"
                            aria-selected="false"><?php echo $audios_category->name; ?>
                        </a>
                    <?php }  ?>
                </div>
            </div>
            <div class="tab-pane fade" id="live" role="tabpanel" aria-labelledby="live-tab">
                <hr>
                <div class="Live_Categorynav">
                    <?php foreach ($LiveCategory as $key => $live_category) { ?>
                        <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                        data-category-id=<?php echo $live_category->id; ?> onclick="Live_Category(this)" href="#pills-kids"
                        role="tab" aria-controls="pills-kids" aria-selected="false"><?php echo $live_category->name; ?>
                        </a>
                    <?php }  ?>
                </div>
            </div>
        </div>
    </div>
   
</section>
<!--<section class="">
    <div class="sec-3">
        <div class="container-fluid mt-5">
            <div class="mt-3 ">
                <ul class="nav nav-pills   m-0 p-0" id="pills-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link " id="pills-profile-tab" data-toggle="pill" role="tab"
                            aria-controls="pills-profile" aria-selected="false">
                            All
                        </a>
                    </li>

                    <li class="nav-item videonav">
                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='video' data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Videos
                        </a>
<div class="position-relative">
                       
</div>
                    </li>
                        
                    <li class="nav-item ">

                        <a class="nav-link" class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-id-type='live' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Live
                            Stream
                        </a>

                       

                    <li class="nav-item ">

                      
                       

                        &nbsp;&nbsp;
                    <li class="nav-item ">

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

   
  
   
</section>-->


<div class='channel_home'>
    <?php 
if(count($latest_video) > 0 || count($livetream) > 0 || count($latest_series) > 0 || count($audios) > 0){
      if(count($latest_video) > 0 ){
      
       ?>
    <section id="iq-favorites">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-sm-12 ">
                    <?php include public_path('themes/theme1/views/partials/home/latest-videos.php');  ?>
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
                    include public_path('themes/theme1/views/partials/home/live-videos.php');
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
                    include public_path('themes/theme1/views/partials/home/latest-series.php');
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
                    include public_path('themes/theme1/views/partials/home/latest-audios.php');
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php } }else{ ?>
    <div class="col-md-12 text-center mt-4 mb-5" style="padding-top:80px;padding-bottom:80px;">
        <h4 class="main-title mb-4">{{  __('Sorry! There are no contents under this genre at this moment')  }}.</h4>
        <a href="{{ URL::to('/') }}" class="outline-danger1">{{  __('Home')  }}</a>
    </div>
    <?php   } ?>
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
  const player = new Plyr('#videoPlayer1'); 

      $(document).ready(function(){
        $(".close").click(function(){
            $('#videoPlayer1')[0].pause();
        });
    });
</script>
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

        $('.Allnav').click(function() {
        //     $.ajax({
        //     type: "get",
        //     url: "<?php echo URL::to('public/themes/theme1/views/partials/channel/all_Channel_videos'); ?>",
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //         channel_slug:"{{ @$channel_partner->channel_slug }}",
        //     },
        //     success: function(data) {
        //         $(".channel_home").html(data);
        //     },
        // });
        location.reload();
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
                user_id:"{{ @$channel_partner->id }}",
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
                user_id:"{{ @$channel_partner->id }}",
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
                user_id:"{{ @$channel_partner->id }}",
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
                user_id:"{{ @$channel_partner->id }}",
            },
            success: function(data) {
                $(".channel_home").html(data);
            },
        });
        }

        let scrollPosition = 0;
const itemWidth = 150; // Adjust this width as per your item size
const visibleItemsCount = 6; // Number of visible items

function scrollCategory(direction) {
    const container = document.querySelector('.video-category');
    const totalItems = container.children.length;
    const maxScrollPosition = itemWidth * (totalItems - visibleItemsCount);
    
    scrollPosition += direction * itemWidth * visibleItemsCount;

    if (scrollPosition < 0) {
        scrollPosition = 0;
    }
    
    if (scrollPosition > maxScrollPosition) {
        scrollPosition = maxScrollPosition;
    }

    container.style.transform = `translateX(-${scrollPosition}px)`;
    
    document.querySelector('.prev-btn').disabled = scrollPosition === 0;
    document.querySelector('.next-btn').disabled = scrollPosition === maxScrollPosition;
}

document.addEventListener('DOMContentLoaded', () => {
    scrollCategory(0); // Initialize the buttons' disabled state
});

</script>



<?php
    include public_path('themes/theme1/views/footer.blade.php');
?>
