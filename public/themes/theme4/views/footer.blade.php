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

<footer>
    <div class="container-fluid">
        <div class="block-space">
            <div class="row">

            <div class="col-lg-3 col-md-12 r-mt-15 p-1">
                    <p class="footer-title">Contact with us:</p>
                    <div class="d-flex footer-title">

                        <?php if (!empty($settings->instagram_page_id)) { ?>
                            <a href="https://www.instagram.com/<?php echo InstagramId(); ?>" target="_blank" class="s-icon" aria-label="insta">
                                <i class="ri-instagram-fill"></i>
                            </a>
                        <?php } ?>

                        <?php if (!empty($settings->twitter_page_id)) { ?>
                            <a href="https://twitter.com/<?php echo TwiterId(); ?>" target="_blank" class="s-icon" aria-label="twitter">
                                <i class="ri-twitter-fill"></i>
                            </a>
                        <?php } ?>

                        <?php if (!empty($settings->facebook_page_id)) { ?>
                            <a href="<?= 'https://www.facebook.com/' . FacebookId() ?>" target="_blank" class="s-icon" aria-label="fb">
                                <i class="ri-facebook-fill"></i>
                            </a>
                        <?php } ?>

                        <?php if (!empty($settings->skype_page_id)) { ?>
                            <a href="<?= 'https://www.skype.com/en/' . SkypeId() ?>" target="_blank" class="s-icon" aria-label="skype">
                                <i class="ri-skype-fill"></i>
                            </a>
                        <?php } ?>

                        <?php if (!empty($settings->linkedin_page_id)) { ?>

                            <a href="<?= 'https://www.linkedin.com/' . linkedinId() ?>" target="_blank" class="s-icon" aria-label="linkedin">
                                <i class="ri-linkedin-fill"></i>
                            </a>

                        <?php } ?>

                        <?php if (!empty($settings->whatsapp_page_id)) { ?>
                            <a href="<?= 'https://www.whatsapp.com/' . WhatsappId() ?>" class="s-icon" aria-label="whatsapp">
                                <i class="ri-whatsapp-fill"></i>
                            </a>
                        <?php } ?>

                        <?php if (!empty($settings->youtube_page_id)) { ?>
                            <a href="https://www.youtube.com/<?php echo YoutubeId(); ?>" target="_blank" class="s-icon" aria-label="youtube">
                                <i class="ri-youtube-fill"></i>
                            </a>
                        <?php } ?>

                        <?php if (!empty($settings->google_page_id)) { ?>
                            <a href="https://www.google.com/<?php echo GoogleId(); ?>" target="_blank" class="s-icon" aria-label="google">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        <?php } ?>

                        <?php if (!empty($settings->tiktok_page_id)) { ?>
                            <a href="https://www.tiktok.com/<?php echo $settings->tiktok_page_id; ?>" target="_blank" class="s-icon" aria-label="tiktok">
                                <i class="ri-tiktok-fill"></i>
                            </a>
                        <?php } ?>
                    </div>
                    
                    <div class="d-flex col-6">
                        <?php if (!empty($app_settings->android_url)) { ?>
                            <a href="<?= $app_settings->android_url ?>" aria-label="android"><img class="apps1 w-100"  alt="apps1" src="<?= URL::to('/assets/img/apps1.webp'); ?>" /></a>
                        <?php } ?>
                        <?php if (!empty($app_settings->ios_url)) { ?>
                            <a href="<?= $app_settings->ios_url ?>" aria-label="ios"><img class="apps1 w-100"  alt="apps" src="<?= URL::to('/assets/img/apps.webp'); ?>" /></a>
                        <?php } ?>
                        <?php if (!empty($app_settings->android_tv)) { ?>
                            <a href="<?= $app_settings->android_tv ?>" aria-label="androidtv"><img class="apps1 w-100"  alt="and" src="<?= URL::to('/assets/img/and.png'); ?>" /></a>
                        <?php } ?>
                    </div>
                </div>


                <?php
                for ($i = 1; $i <= 3; $i++) {

                    $footerLinks = App\FooterLink::where('column_position', $i)
                        ->orderBy('order')
                        ->get();
                ?>

                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <ul class="f-link list-unstyled mb-0">
                            <?php foreach ($footerLinks as $key => $footerLink) { ?>
                                <?php if($footerLink->name == 'Contact-Us' || $footerLink->name == 'Contact Us'): ?>
                                    <li><a href="https://e360tvhosthub.com/contact-us"><?= $footerLink->name ?></a></li>
                                <?php else: ?>
                                    <li><a href="<?= URL::to('/' . $footerLink->link) ?>"><?= $footerLink->name ?></a></li>
                                <?php endif; ?>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                

                
            </div>
        </div>
        <div class="copyright py-2">
            <div class="container-fluid">
                <p class="mb-0 text-center font-size-14 text-body">
                    <?= $settings->website_name . ' <i class="ri-copyright-line"></i> ' . Carbon::now()->year ?> All Rights Reserved
                </p>
            </div>
        </div>
    </div>
    
</footer>



   <!-- jQuery, Popper JS -->
   <script src="https://e360tvmain.b-cdn.net/css/assets/js/popper.min.js" async></script>
   
   <!-- Bootstrap JS -->
   <script src="https://e360tvmain.b-cdn.net/css/assets/js/bootstrap.min.js" async></script>
   

   <!-- select2 Js -->
   <script src="https://e360tvmain.b-cdn.net/css/assets/js/select2.min.js" async></script>
   
   <!-- Magnific Popup-->
   <script src="https://e360tvmain.b-cdn.net/css/assets/js/jquery.magnific-popup.min.js" async></script>
   

    <!-- Custom JS-->
    <script src="https://e360tvmain.b-cdn.net/css/assets/js/custom.js" async></script>


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

        document.getElementById(id).style.display = "block";

    }
</script>

<?php $search_dropdown_setting = App\SiteTheme::pluck('search_dropdown_setting')->first(); ?>
<input type="hidden" value="<?= $search_dropdown_setting ?>" id="search_dropdown_setting">

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
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
    });
    document.addEventListener('DOMContentLoaded', function() {
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

<!-- JavaScript -->
<!-- <link rel="preload" href="<?= URL::to('/') . '/assets/js/ls.bgset.min.js' ?>" as="script">
<link rel="preload" href="<?= URL::to('/') . '/assets/js/lazysizes.min.js' ?>" as="script">
 <link rel="preload" href="<?= URL::to('/') . '/assets/js/plyr.polyfilled.js' ?>" as="script"> -->

<!-- <script src="<?= URL::to('/') . '/assets/js/plyr.polyfilled.js' ?>"></script>  -->
<!-- <script src="<?= URL::to('/') . '/assets/js/hls.min.js' ?>"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/hls.js/0.14.5/hls.min.js" async></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/hls.js/0.14.5/hls.min.js.map"></script> -->
<!-- <script src="<?= URL::to('/') . '/assets/js/hls.js' ?>"></script> -->

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

<?php
    try {
        if (Route::currentRouteName() == 'LiveStream_play') {
            include 'livevideo_player_script.blade.php';
        } elseif (Route::currentRouteName() == 'play_episode' || Route::currentRouteName() == "network_play_episode"  ) {
            include 'episode_player_script.blade.php';
        } else {
            // include 'footerPlayerScript.blade.php';
        }
    } catch (\Throwable $th) {
        // throw $th;
    }
?>

<!-- Lazy load script -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.7/jquery.lazyload.js"></script> -->

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

<!-- scrolling performance -->
<script>
    jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
    };
    jQuery.event.special.touchmove = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };
    jQuery.event.special.wheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("wheel", handle, { passive: true });
        }
    };
    jQuery.event.special.mousewheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("mousewheel", handle, { passive: true });
        }
    };
</script>

<?php } ?>