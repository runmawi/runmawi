<!-- Header Start -->
<?php
include public_path('themes/theme1/views/header.php');

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
$order_settings_list = App\OrderHomeSetting::get();
$continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();
?>
<style>
    hr{
        border-top:none!important;
        height: 1px;
         background-image: linear-gradient(90deg, white, transparent);
    }
    
</style>
<!-- Favicon -->
<link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script  src="<?= URL::to('/'). '/assets/js/plyr.polyfilled.js';?>"></script>
<script  src="<?= URL::to('/'). '/assets/js/hls.js';?>"></script>

@if(!empty($Content_Partner->banner) && $Content_Partner->banner != null)
<section class="ContentPartner-header"
    style="background:url('<?php echo URL::to('/') . '/public/uploads/moderator_albums/' . @$Content_Partner->banner; ?>') no-repeat scroll 0 0;;background-size: cover;height:350px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
</section>            
@else
<section class="ContentPartner-header"
    style="background:url('<?= URL::to('/') . '/public/uploads/images/' . $settings->default_horizontal_image ?>') no-repeat scroll 0 0;;background-size: cover;height:350px;background-color: rgba(0, 0, 0, 0.45);
    background-blend-mode: multiply;">
</section> 
@endif

<div class="container-fluid">
    <div class="position-relative">
        <div class="ContentPartner-img">
            @if(!empty($Content_Partner->picture) && $Content_Partner->picture != null)
                <img src="<?php echo  URL::to('/') . '/public/uploads/moderator_albums/'. @$Content_Partner->picture; ?>" class=" " width="150" alt="user">
            @else
                <img src="<?= URL::to('/') . '/public/uploads/images/' . $settings->default_video_image ?>"  class=" " width="150" alt="user">
            @endif
        </div>
    </div>
</div>

<section class="mt-5 mb-5">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-2 col-lg-2">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                    @php
                        include(public_path('themes/default/views/partials/content-user-social-share.php'));
                    @endphp
                </ul>
            </div>
            @if(!empty(@$Content_Partner) && $Content_Partner->intro_video != null):
            <div class="col-2 col-lg-2">
            <a data-video="{{ @$Content_Partner->intro_video }}" data-toggle="modal" data-target="#videoModal" data-backdrop="static" data-keyboard="false" >	
                <span class="text-white">
                <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('About Content Partner') }}  
                </span>
            </a>


            <div class="modal fade modal-xl" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog"  style='max-width: 800px;'>
                    <div class="modal-content" style="background-color: transparent;border:none;">
                    <button type="button" class="close" style='color:red;' data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                        <video id="videoPlayer1" 
                            controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  
                            type="video/mp4" src="{{ @$Content_Partner->intro_video }}">
                        </video>
                    </div>
                </div>
                </div>
            </div>
      
        </div>
        @endif
        </div>
    </div>
</section>
<section class="channel_nav">
    <div class="container-fluid">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item Allnav">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('All') }}</a>
  </li>
  <li class="nav-item videonav">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('Videos') }}</a>
  </li>
        <li class="nav-item livenav">
    <a class="nav-link" id="live-tab" data-toggle="tab" href="#live" role="tab" aria-controls="profile" aria-selected="false">{{ __('Live Stream') }}</a>
  </li>
  <!-- <li class="nav-item seriesnav">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Series</a>
  </li> -->
         <li class="nav-item audionav">
    <a class="nav-link" id="Audios-tab" data-toggle="tab" href="#Audios" role="tab" aria-controls="contact" aria-selected="false">{{ __('Audios') }}</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><hr ></div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><hr>
      
      <div class=" Video_Categorynav ">
                            @foreach ($VideoCategory as $key => $videos_category)
                                <div>
                                <a class="nav-link dropdown-item " id="pills-kids-tab" data-toggle="pill"
                                    data-category-id=<?php echo $videos_category->id; ?> onclick="Videos_Category(this)"
                                    href="#pills-kids" role="tab" aria-controls="pills-kids"
                                    aria-selected="false"><?php echo $videos_category->name; ?></a>
</div>
                                    @endforeach 
                        </div></div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"><hr><div class="Series_Categorynav ">
                            <?php foreach ($VideoCategory as $key => $videos_category) { ?>

                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                data-category-id=<?php echo $videos_category->id; ?> onclick="Series_Category(this)" href="#pills-kids"
                                role="tab" aria-controls="pills-kids" aria-selected="false"><?php echo $videos_category->name; ?></a>
                            <?php }  ?>
      
                        </div></div>
  <div class="tab-pane fade" id="Audios" role="tabpanel" aria-labelledby="Audios-tab"><hr>
     
      <div class="Audio_Categorynav">
                            <?php foreach ($AudioCategory as $key => $audios_category) { ?>

                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                data-category-id=<?php echo $audios_category->id; ?> onclick="Audios_Category(this)"
                                href="#pills-kids" role="tab" aria-controls="pills-kids"
                                aria-selected="false"><?php echo $audios_category->name; ?></a>

                            <?php }  ?>
                        </div></div>
    <div class="tab-pane fade" id="live" role="tabpanel" aria-labelledby="live-tab"><hr>
     
      <div class="Live_Categorynav">
                            <?php foreach ($LiveCategory as $key => $live_category) { ?>
                            <a class="nav-link dropdown-item" id="pills-kids-tab" data-toggle="pill"
                                data-category-id=<?php echo $live_category->id; ?> onclick="Live_Category(this)" href="#pills-kids"
                                role="tab" aria-controls="pills-kids" aria-selected="false"><?php echo $live_category->name; ?></a>

                            <?php }  ?>
                        </div>
</div></div>
</div>
   
</section>

<div class='Content_home'>
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
        <h4 class="main-title mb-4">{{ __('Sorry! There are no contents under this genre at this moment') }}.</h4>
        <a href="{{ URL::to('/') }}" class="outline-danger1">{{ __('Home') }}</a>
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
        //     url: "<?php echo URL::to('/all_Channel_videos'); ?>",
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //         channel_slug:"{{ @$channel->channel_slug }}",
        //     },
        //     success: function(data) {
        //         $(".Content_home").html(data);
        //     },
        // });
        location.reload();
        });

    });


    function Live_Category(ele) {

        var category_id = $(ele).attr('data-category-id');
        
        $.ajax({
            type: "get",
            url: "{{ route('Content_category_live') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$Content_Partner->id }}",
            },
            success: function(data) {
                $(".Content_home").html(data);
            },
        });
    }
    function Videos_Category(ele) {
        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "<?php echo URL::to('/Content_category_videos'); ?>",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$Content_Partner->id }}",
            },
            success: function(data) {
                $(".Content_home").html(data);
            },
        });
    }

    function Series_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('Content_category_series') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$Content_Partner->id }}",
            },
            success: function(data) {
                $(".Content_home").html(data);
            },
        });
    }

    function Audios_Category(ele) {

        var category_id = $(ele).attr('data-category-id');

        $.ajax({
            type: "get",
            url: "{{ route('Content_category_audios') }}",
            data: {
                _token: "{{ csrf_token() }}",
                category_id: category_id,
                user_id:"{{ @$Content_Partner->id }}",
            },
            success: function(data) {
                $(".Content_home").html(data);
            },
        });
        }

</script>



<?php
    include public_path('themes/theme1/views/footer.blade.php');
?>
