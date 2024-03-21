<?php
    use Carbon\Carbon;

    $settings = App\Setting::first();
    $user     = App\User::where('id', '=', 1)->first();
    $session  = session()->all();
    $cmspages = App\Page::where('active', 1)->get();
    $theme_mode = App\SiteTheme::pluck('theme_mode')->first();
    $theme = App\SiteTheme::first();
    $app_settings = App\AppSetting::where('id', '=', 1)->first(); 

?>
<style>
    .row.m-0 {
        border-top: 1px solid;
        border-bottom: 1px solid;
        margin: 20px 0 !important;
    }

    li.list-inline-item{
        height: 100%;
        border-left: 1px solid;
        padding: 20px;
    }
    ul.list-inline.m-0 {
        height: 100%;
    }
    #join-com input[type="text"] {
        border-radius: 50px 0 0 50px !important;
        border-right: none;
        padding: 5px;
        border:none;
        height:auto;
    }
    input[type="text"]::placeholder{
        color: #000;
    }
    button.join {
        border-radius: 0 50px 50px 0 !important;
        border-left: none;
        padding: 5px 22px;
        border:none;
    }
    .music-text{
        font-size:11px;
    }
    @media(max-width:420px){
        .music-text{
            display:none;
        }
        .logo-content .col-lg-3.col-md-3.col-sm-3.col-3{
            display:flex;
            align-items:center;
        }
    }


</style>
<footer class="mb-3" style="margin-top:5rem;">
        <div class="logo-content">
            
            <div class="row m-0">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-center">
                        <a class="navbar-brand" href="<?= URL::to('/home') ?>"> <img class="img-fluid logo" src="<?= front_end_logo() ?>" width="80%"/> </a>
                        <p class="music-text" style="font-size:11px;"> <?= 'Created by Music Fans for Music Fans' ?></p>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9 text-right m-0">
                    <ul class="list-inline m-0">
                        <?php if (!empty($settings->instagram_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="https://www.instagram.com/<?php echo InstagramId(); ?>" target="_blank" class="s-icon">
                                    <i class="ri-instagram-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->twitter_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="https://twitter.com/<?php echo TwiterId(); ?>" target="_blank" class="s-icon">
                                    <i class="ri-threads-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->facebook_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="<?= 'https://www.facebook.com/' . FacebookId() ?>" target="_blank" class="s-icon">
                                    <i class="ri-facebook-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->skype_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="<?= 'https://www.skype.com/en/' . SkypeId() ?>" target="_blank" class="s-icon">
                                    <i class="ri-skype-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->linkedin_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="<?= 'https://www.linkedin.com/' . linkedinId() ?>" target="_blank" class="s-icon">
                                    <i class="ri-linkedin-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->whatsapp_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="<?= 'https://www.whatsapp.com/' . WhatsappId() ?>" class="s-icon">
                                    <i class="ri-whatsapp-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->youtube_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="https://www.youtube.com/<?php echo YoutubeId(); ?>" target="_blank" class="s-icon">
                                    <i class="ri-youtube-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->google_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="https://www.google.com/<?php echo GoogleId(); ?>" target="_blank" class="s-icon">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (!empty($settings->tiktok_page_id)) { ?>
                            <li class="list-inline-item">
                                <a href="https://www.tiktok.com/<?php echo $settings->tiktok_page_id; ?>" target="_blank" class="s-icon">
                                    <i class="ri-tiktok-fill"></i>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>

        </div>
    <div class="container-fluid">
        
        <div class="block-space">
            <div class="row">
                <?php
                for ($i = 1; $i <= 3; $i++) {

                    $footerLinks = App\FooterLink::where('column_position', $i)
                        ->orderBy('order')
                        ->get();
                ?>

                    <div class="col-lg-3 col-md-4">
                        <ul class="f-link list-unstyled mb-0">
                            <?php foreach ($footerLinks as $key => $footerLink) { ?>
                                <li><a href="<?= URL::to('/' . $footerLink->link) ?>"><?= $footerLink->name ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                    <div class="col-lg-3 col-md-12 r-mt-15 p-1 text-right">

                        <h5><?= "Join the community" ?></h5>
                        <p class="font-size-12"><?= "For the latest news and offers signup below" ?></p>
                        <div class="d-flex justify-content-end" id="join-com">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-7 col-7 p-0">
                                    <input type="text" placeholder="Your Email">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-3 col-3 p-0">
                                    <button class="join btn text-white">Join</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- <div class="d-flex">
                            <?php if (!empty($app_settings->android_url)) { ?>
                                <a href="<?= $app_settings->android_url ?>"><img class="" height="60" width="100" src="<?= URL::to('/assets/img/apps1.png'); ?>" /></a>
                            <?php } ?>
                            <?php if (!empty($app_settings->ios_url)) { ?>
                                <a href="<?= $app_settings->ios_url ?>"><img class="" height="60" width="100" src="<?= URL::to('/assets/img/apps.png'); ?>" /></a>
                            <?php } ?>
                            <?php if (!empty($app_settings->android_tv)) { ?>
                                <a href="<?= $app_settings->android_tv ?>"><img class="" height="60" width="100" src="<?= URL::to('/assets/img/and.png'); ?>" /></a>
                            <?php } ?>
                        </div> -->
                    </div>

                
            </div>
        </div>
    </div>
    <!-- <div class="copyright py-2">
        <div class="container-fluid">
            <p class="mb-0 text-center font-size-14 text-body">
                <?= $settings->website_name . ' - ' . Carbon::now()->year ?> All Rights Reserved
            </p>
        </div>
    </div> -->
</footer>

   <!-- jQuery, Popper JS -->
   <script src="<?= asset('public/themes/theme3/assets/js/jquery-3.4.1.min.js') ?>"></script>
   <script src="<?= asset('public/themes/theme3/assets/js/popper.min.js') ?>"></script>
   
   <!-- Bootstrap JS -->
   <script src="<?= asset('public/themes/theme3/assets/js/bootstrap.min.js') ?>"></script>
   
   <!-- Slick JS -->
   <script src="<?= asset('public/themes/theme3/assets/js/slick.min.js') ?>"></script>
   
   <!-- owl carousel Js -->
   <script src="<?= asset('public/themes/theme3/assets/js/owl.carousel.min.js') ?>"></script>
   
   <!-- select2 Js -->
   <script src="<?= asset('public/themes/theme3/assets/js/select2.min.js') ?>"></script>
   
   <!-- Magnific Popup-->
   <script src="<?= asset('public/themes/theme3/assets/js/jquery.magnific-popup.min.js') ?>"></script>
   
   <!-- Slick Animation-->
    <script src="<?= asset('public/themes/theme3/assets/js/slick-animation.min.js') ?>"></script>
   
   <!-- Custom JS-->
    <script src="<?= asset('public/themes/theme3/assets/js/custom.js') ?>"></script>
    <script src="<?= URL::to('/') . '/assets/js/jquery.lazy.js' ?>"></script>
    <script src="<?= URL::to('/') . '/assets/js/jquery.lazy.min.js' ?>"></script>

<script>
    $(document).ready(function () {
        $(".thumb-cont").hide();
        $(".show-details-button").on("click", function () {
            var idval = $(this).attr("data-id");
            $(".thumb-cont").hide();
            $("#" + idval).show();
        });
        $(".closewin").on("click", function () {
            var idval = $(this).attr("data-id");
            $(".thumb-cont").hide();
            $("#" + idval).hide();
        });
    });

    function about(evt, id) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {

        }

        document.getElementById(id).style display = "block";

    }
</script>

<?php $search_dropdown_setting = App\SiteTheme::pluck('search_dropdown_setting')->first(); ?>
<input type="hidden" value="<?= $search_dropdown_setting ?>" id="search_dropdown_setting">

<script type="text/javascript">
    $(document).ready(function () {

        $('.searches').on('keyup', function () {
            var query = $(this).val();

            if (query != '') {

                $.ajax({
                    url: "<?php echo URL::to('/search'); ?>",
                    type: "GET",
                    data: {
                        'country': query
                    },
                    success: function (data) {
                        $(".home-search").hide();
                        $('.search_list').html(data);
                    }
                })
            } else {
                $('.search_list').html("");
            }
        });

        $(document).on('click', 'li', function () {

            var value = $(this).text();
            let search_dropdown_setting = $('#search_dropdown_setting').val();

            $('.search').val(value);
            $('.search_list').html("");

            if (search_dropdown_setting == 1) {
                $(".home-search").show();
            } else {
                $(".home-search").hide();
            }
        });
    });
</script>

<?php 
    $footer_script = App\Script::pluck('footer_script')->toArray();
    if (count($footer_script) > 0) {
        foreach ($footer_script as $Scriptfooter) { ?>
            <?= $Scriptfooter ?>
        <?php } 
    }
?>

<script src="<?= URL::to('/') . '/assets/js/ls.bgset.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/js/lazysizes.min.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/js/plyr.polyfilled.js' ?>"></script>
<script src="<?= URL::to('/') . '/assets/js/hls.min.js' ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hls.js/0.14.5/hls.min.js.map"></script>
<script src="<?= URL::to('/') . '/assets/js/hls.js' ?>"></script>

<script>
    function loadJS(u) {
        var r = document.getElementsByTagName("script")[0],
            s = document.createElement("script");
        s.src = u;
        r.parentNode.insertBefore(s, r);
    }
    if (!window.HTMLPictureElement) {
        loadJS("https://afarkas.github.io/lazysizes/plugins/respimg/ls.respimg.min.js");
    }
</script>
<script defer src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>

<?php
    try {
        if (Route::currentRouteName() == 'LiveStream_play') {
            include 'livevideo_player_script.blade.php';
        } elseif (Route::currentRouteName() == 'play_episode') {
            include 'episode_player_script.blade.php';
        } else {
            include 'footerPlayerScript.blade.php';
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
?>

<script>
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        const script = document.createElement('script');
        script.src =
            'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
</script>

<?php  
$Prevent_inspect = App\SiteTheme::pluck('prevent_inspect')->first();
if ($Prevent_inspect == 1) { ?>
    <script>
        $(document).keydown(function (event) {
            if (event.keyCode == 123) {
                alert("This function has been disabled"); // Prevent F12
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 'I'.charCodeAt(0)) {
                alert("This function has been disabled "); // Prevent Ctrl + Shift + I
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 'J'.charCodeAt(0)) {
                alert("This function has been disabled "); // Prevent Ctrl + Shift + J
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 'C'.charCodeAt(0)) {
                alert("This function has been disabled "); // Prevent Ctrl + Shift + c
                return false;
            } else if (event.ctrlKey && event.keyCode == 'U'.charCodeAt(0)) {
                alert("This function has been disabled "); // Prevent Ctrl + U
                return false;
            }
        });

        $(document).on("contextmenu", function (e) {
            alert("This function has been disabled");
            e.preventDefault();
        });
    </script>
<?php } ?>

<?php if (get_image_loader() == 1) { ?>
    <script>
        const loaderEl = document.getElementsByClassName('fullpage-loader')[0];
        document.addEventListener('readystatechange', (event) => {
            const readyState = "complete";
            if (document.readyState == readyState) {
                loaderEl.classList.add('fullpage-loader--invisible');
                setTimeout(() => {
                    loaderEl.parentNode.removeChild(loaderEl);
                }, 100)
            }
        });
    </script>
    
<?php } ?>