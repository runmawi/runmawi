<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{  $title ? $title.' | '.GetWebsiteName() : 'Landing-page'.' | '.GetWebsiteName() }}</title>

        <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/style.css';?>" />
        <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/typography.css';?>" />
        <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800&display=swap" rel="stylesheet">
                
                    {{-- Favicon  --}}
        <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">
        
                    {{--style Page  --}}
        @php include(public_path('themes/default/views/landing/landing_style.blade.php')); @endphp

    </head>

    <body>
        <div class="page_bkgrd_home" >
            <div class="container" >
                <div class="row align-items-center p-3" >
                    <div class="col-md-6 p-0" ><a href="horror-tv.com"><img class="logo" src="http://savagestudiosinc.com/wp-content/uploads/2022/07/full_logo-copy.png"></a></div>
                    <div class="col-md-6" ><a href="#" class="buttonClass" style="float:right;">LOGIN</a></div>
                </div> 

                <div class="row mt-5 pt-5">
                    <div class="col-md-7 p-2" ><h1>Your New<br> Favorite <br><img src="http://savagestudiosinc.com/wp-content/uploads/2022/07/screaming-1.png"><br>Service</h1><br><a href="#" class="buttonClassLarge" >Sign Up Today for $2.45</a></div>
                </div> 

                <div class="col-md-12" style="margin-top: 20%;"><h2 style="text-align: center; line-height:1;">BECOME PART OF HORROR-TV's ORIGIN STORY!</h2><h4 class="col-md-9" style=" color: grey;margin:0 auto;">We are looking for 2,000 beta testers. A one time, low cost of $2.49/month will give you access as a beta tester. Original subscribers keep that price for as long as they are subscribed. You will have access to a private Facebook group where you will be helping curate the film library and be an integral part in creating a user experience that all horror fans will love.</h4>
                    <br/><br/>
                    <center><a href="#" class="buttonClassLarge ">Sign up today and join our origin story for just $2.45!</a></center>
                </div>
            </div>
        </div>

        <div class="container" style="">
            <h2 class="text-center" style=" font-size: 40px;">FEATURED MOVIES</h2>
            <h2 class="text-center" style=" ">PLACE FEATURED MOVIE SLIDER HERE</h2>
    
            <div class="row align-items-center" style="margin-top: 5%">
                <div class="col-md-6" >
                    <h2 style="font-size: 30px;  background-color: #8A0303;">HALF OFF YOUR SUB FOR EVER!</h2>
                    <h4 style="text-align: left; color: grey; margin-top: 10px;">Once you've subscribed during the beta test phase, your subscription will remain at $2.45 for as long as you remain a member. <strong style="color: #fff;">Paying for the year up front saves you even more at $24.95.</strong></h4>
                    <h2 style="margin-top: 30px; background-color: #8A0303;font-size: 30px;">HELP CURATE THE MOVIES!</h2>
                    <h4 style="text-align: left;  color: grey; margin-top: 10px;">As a beta test member of horror-tv.com you will be given special access to a private Facebook group where as a founding member you will be able to help pick future films and TV shows to be added to the site
                        </h4>
                    <h2 style="margin-top: 30px; font-size: 40px; background-color: #8A0303;font-size: 30px;">ALL THE SCREENS!</h2>
                    <h4 style="text-align: left; color: grey; margin-top: 10px;">We are currently developing both the phone apps and the TV apps once these come to market you will be sent an e-mail to help evaluate these as well</h4>
                </div>
                <div class="col-md-6" ><img class="w-100" style="" src="http://savagestudiosinc.com/wp-content/uploads/2022/07/scrensizes.png"></div>
            </div>  
        </div>

        <div class="footer-background-home">
            <div style="height: 200px;"></div>
            <h2 style="margin-top: 150px; text-align: center; font-size: 40px;">TIME IS LIMITED. ACT NOW!</h2>
            <h4 style="padding-left:35%; padding-right: 35%; color: rgb(255, 255, 255); margin-bottom: 100px;">ONCE WE REACH OUR BETA TEST LEVEL OF 2000 USERS THE PRICE WILL DOUBLE. GET STARTED TODAY DON'T MISS OUT.</h4>
            <center><a href="#" class="buttonClassLarge" >Sign Up Today for $2.45</a></center>
            <div style="height: 200px;"></div>
        </div>
        
    </body>
</html>
