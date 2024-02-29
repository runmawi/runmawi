<!DOCTYPE html>
<html lang="en">

<style>
    body{
        background: #000 !important;
        font-family: 'Futura Condensed PT', sans-serif !important;
    }
    section.header{
        background-color:#000;
    }
    section.header .container{
        padding: 20px 0;
    }
    button.login-button {
        padding: 9px;
        border-radius: 11px;
        height: 50%;
        background: #fe9c03;
        border:none;
        color:#fff;
        font-weight:bold;
    }
    h1{
        -webkit-text-stroke-width: 2px;
        -webkit-text-stroke-color: #00000070;
        font-stretch: 39%;
        font-weight:bold !important;
    }
    h1,h2,h3,h4,h5,h6,p,li{
        color:#fff;
    }
    /* ul li:before{
        content: "\e69c";
    } */
    ul li{
        text-align:left;
    }
    section.main-content{
        margin-bottom:5rem;
    }
    .col-xl-5.col-lg-5.col-md-6.col-sm-6.col-12 .card{
        background: #000;
        border-radius: 11px;
        padding: 10px;
    }
    .container.position-absolute{
        top:30%;
        margin-right:90px;
        margin-left:90px;
    }
    button.card-buttons.w-40 {
        padding: 7px 20px;
        border: none;
        border-radius: 10px;
        color:#fff;
        background: #f9ab03;
        font-weight:bold;
    }
    button.inscrivez {
        padding: 15px 11px;
        border: none;
        border-radius: 10px;
        color: #fff;
        background: #042c58;
        font-weight: bold;
        font-size: 20px;
    }
    .ins-btun{
        margin-top:2rem !important;
    }
    .col-3 img{
        width:100%;
    }
    button.join-reg {
        padding: 5px 32px;
        border: none;
        border-radius: 10px;
        background: #161f26;
        color: white;
        font-weight: bold;
    }
    section.footer-sec {
        background: #292b2a;
        padding-top: 4rem;
        padding-bottom: 7rem;
    }
    .footer-img img{
        width:100%;
    }
    button a {
        color: white;
        text-decoration: none;
    }
    .back-img .container{
        padding-top:5rem;
    }

    .col-xs-12{
        width:100%!important
    }
   
    @media (min-width: 768px){
        
    }
    
    @media(max-width:1200px){
        .back-img .container {
            padding-top: 1rem;
        }
    }
    @media(max-width:768px){
        .back-img .container{
            padding-top:10px;
            max-width:700px;
        }
        button.inscrivez{
            padding: 7px 1px;
            font-size: 14px;
        }
    }
    @media(max-width:768px){
        button.inscrivez{
            padding: 7px 1px;
            font-size: 14px;
        }
    }
    @media(max-width:640px){
        h2{
            font-size:20px !important;
        }
        ul li {
            text-align: left;
            font-size: 12px;
        }
    }

    @media(max-width:460px){
        .col-xs-12{
            text-align:center
        }
        .d-sm-none{
            display:none
        }
        .ins-btun{
            margin-top:10px!important
        }
        .back-img{
            height:600px!important
        }
        .slider-inner .card{
            margin-top:20px
        }
        section.header .container {
            padding: 20px 10px;
        }
        button.login-button{
            font-size:12px;
        }
        h6{
            font-size:14px;
        }
        .col-lg-4.col-md-4.col-12{
            margin-top:1rem;
        }
    }
</style>
<style>
                            @import url('https://fonts.cdnfonts.com/css/futura-condensed-pt');
</style>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{  $title ? $title.' | '.GetWebsiteName() : 'Landing-page'.' | '.GetWebsiteName() }}</title>

                            {{-- Boostrap --}}
         <?php  echo  $bootstrap_link ;  ?>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
         <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
         
                            {{--Google fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800&display=swap" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/futura-condensed-pt" rel="stylesheet">
                
                            {{-- Favicon icon --}}
        <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">

                            {{-- custom css --}}
        <?php  echo  ( $custom_css);  ?>
        <section class="header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <img src="<?= front_end_logo() ?>" class="c-logo" alt="" width="80px">
                    <button class="login-button"><a href="<?php echo URL::to('login') ?>"> LOGIN/S'identifier </a></button>
                    
                </div>
            </div>
        </section>
        
    </head>


    <body>

           <section class="main-content">
           <div class="back-img" style="background: url('<?php echo URL::to('public/themes/theme6/views/img/landing-page.png'); ?>');height: calc(100vh - 60px);  background-repeat: no-repeat;background-size: cover;">
                <div class="container ">
                    <div class="slider-inner">
                        <div class="row align-items-center bl">
                            <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-12">
                                <div class="row">
                                    <div class="col-8 col-md-12 col-xs-12 ">
                                        <h1>Le site de streaming de séries télévisées et de films en Afrique</h1>
                                    </div>
                                </div>
                                
                                <div class="row ins-btun">
                                    <div class="col-2 d-md-none d-sm-none "></div>
                                    <div class="col-10 col-md-12 col-xs-12">
                                        <button class="inscrivez">INSCRIVEZ-VOUS GRATUITEMENT MAINTENANT</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                <div class="card text-center align-items-center">
                                    <h2>REJOIGNEZ GRATUITEMENT JOIN FOR FREE</h2>
                                    <ul>
                                        <li><i class="bi bi-check-lg"></i>Obtenez un accès exclusif aux nouvelles séries et films africains</li>
                                        <li><i class="bi bi-check-lg"></i>Du nouveau contenu chaque jour</li>
                                        <li><i class="bi bi-check-lg"></i>Aucun engagement, choisissez de partir à tout moment.</li>
                                        <li><i class="bi bi-check-lg"></i>Access exclusive new African series and films</li>
                                        <li><i class="fa-solid fa-check"></i>New content every day</li>
                                        <li>No committment, choose to leave at any time</li>
                                    </ul>
                                    <button class="card-buttons w-40"><a href="<?php echo URL::to('signup') ?>"> JOIN / REGISTRE </a>   </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="container">
                    <h2>Regardez toutes ces séries et bien plus encore...</h2>
                    <div class="row">
                        <div class="col-3">
                            <a href="<?php echo URL::to('tv-shows') ?>">
                                <img src="<?php echo URL::to('public\themes\theme6\views\img\landing-page-1.png'); ?>" alt="">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo URL::to('tv-shows') ?>">
                                <img src="<?php echo URL::to('public\themes\theme6\views\img\landing-page-2.png'); ?>" alt="">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo URL::to('tv-shows') ?>">
                                <img src="<?php echo URL::to('public\themes\theme6\views\img\landing-page-3.png'); ?>" alt="">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo URL::to('tv-shows') ?>">
                                <img src="<?php echo URL::to('public\themes\theme6\views\img\landing-page-4.png'); ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
           
           


           </section>
           <section class="footer-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <h4>Discover TEEFA TV</h4>
                            <h6>TEEFA TV is all about exciting new TV series and films. From action adventures through to family dramas and comedies. Here you can discover brand new shows and epic new films for all the family.</h6>
                            <button class="join-reg"><a href="<?php echo URL::to('signup') ?>"> JOIN / REGISTRE </a>                
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <h4>Discover TEEFA TV</h4>
                            <h6>TEEFA TV est une nouvelle télévision passionnante séries et films. Aventures d'action à travers des drames familiaux et des comédies. Ici vous pouvez découvrir de nouveaux spectacles et de nouveaux films épiques pour toute la famille.</h6>
                            <button class="join-reg"><a href="<?php echo URL::to('signup') ?>"> JOIN / REGISTRE </a>                 
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <h4>Discover TEEFA TV</h4>
                            <div class="row">
                                <div class="col-4 footer-img">
                                    <img src="<?php echo URL::to('public\themes\theme6\views\img\landing-page-5.png'); ?>" alt="">
                                </div>
                                <div class="col-8">
                                    <h6>NDARY - This epic drama follows the trials of love that should not be chased.</h6>
                                    <h6>NDARY - Ce drame épique suit les procès d'amour qu'il ne faut pas chasser.</h6>
                                    <button class="join-reg"><a href="<?php echo URL::to('signup') ?>"> JOIN / REGISTRE </a>                  
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

           </section>

    </body>
</html>
