@php include public_path('themes/default/views/header.php');  @endphp

    <div class="container-fluid p-0" style="position:relative">

        <iframe
        src="https://player.vdocipher.com/v2/?otp={{ $videodetail->otp }}&playbackInfo={{ $videodetail->playbackInfo }}&primaryColor=4245EF"
        frameborder="0"
        allow="encrypted-media"
        style="border:0;width:100%;height:100vh"
        allowfullscreen
        ></iframe>

    </div>

    <style>
        #main-header{display: none;}
        .container-fluid.p-0{height: 100vh;overflow: hidden;}
    </style>