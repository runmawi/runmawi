@php include public_path('themes/default/views/header.php');  @endphp

    <div class="container-fluid p-0" style="position:relative">
        <button class="staticback-btn" onclick="history.back()" title="Back Button">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </button>

        <div class="vjs-title-bar">{{$videodetail->title}}</div>

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
        .staticback-btn{display:inline-block;position:absolute;background:transparent;z-index:1;top:5%;left:1%;color:#fff;border:none;cursor:pointer;font-size:25px}
        .vjs-title-bar{position:absolute;background:transparent;z-index:1;top:5.6%;left:4%;color:#fff;font-size:20px;font-weight:500;border-top:none;border-bottom:none;border-right:none;border-left:3px solid #fd0000;padding-left:10px;height:25px;display:flex;align-items:center}
    </style>