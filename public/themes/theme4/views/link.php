<!doctype html>
<html lang="en-US">
   <head>

<!-- Favicon -->
   <link rel="shortcut icon" href="<?= getFavicon();?>" type="image/gif" sizes="16x16">
      
<?php
$data = Session::all();
$theme_mode = App\SiteTheme::pluck('theme_mode')->first();

$uri_path = $_SERVER['REQUEST_URI']; 
$uri_parts = explode('/', $uri_path);
$request_url = end($uri_parts);
$uppercase =  ucfirst($request_url);
if(!empty($data['password_hash']) && empty($uppercase) || empty($data['password_hash']) && empty($uppercase)){
// dd($uppercase);
   $uppercase = "Home" ;
}else{

}
   if(!empty(Auth::User()->id)){
      $id = Auth::User()->id;
      $users = App\User::find($id);
      $date = date_create($users->created_at);
      $created_at = date_format($date,"Y-m-d");
      $filldate = date('Y-m-d', strtotime($created_at. ' + 10 day'));
      $currentdate = date('Y-m-d');
      $DOB = $users->DOB;
   }else{
      $currentdate = null ;
      $filldate = null ;
      $DOB = null;
   }

// exit();UA-42534483-14
$data = Session::all();


      ?>
  <!-- Required meta tags -->
  <?php $settings = App\Setting::first(); //echo $settings->website_name;?>

    
    <?php if(!empty($data['password_hash'])){  $videos_data = App\Video::where('slug',$request_url)->first(); } //echo $settings->website_name; ?>
    <?php if(!empty($data['password_hash'])){ $series = App\Series::where('title',$request_url)->first(); } //echo $settings->website_name; ?>
    <?php if(!empty($data['password_hash'])){ $episdoe = App\Episode::where('title',$request_url)->first(); } //echo $settings->website_name; ?>
    <?php if(!empty($data['password_hash'])){ $livestream = App\LiveStream::where('slug',$request_url)->first(); } //echo $settings->website_name; ?>


    <meta charset="UTF-8">
    <title><?php
   //  dd($data['password_hash']);
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
    elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
    elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
    else{ echo $uppercase .' | ' . $settings->website_name ;} ?></title>
    <meta name="description" content= "<?php 
     if(!empty($videos_data)){ echo $videos_data->description  ;
    }
    elseif(!empty($episdoe)){ echo $episdoe->description  ;}
    elseif(!empty($series)){ echo $series->description ;}
    elseif(!empty($livestream)){ echo $livestream->description  ;}
    else{ echo $settings->website_description   ;} //echo $settings; ?>" />

    <meta property="og:title" content="<?php
   //  dd($data['password_hash']);
      if(!empty($videos_data)){  echo $videos_data->title .' | '. $settings->website_name ;
       }
      elseif(!empty($series)){ echo $series->title .' | '. $settings->website_name ; }
    elseif(!empty($episdoe)){ echo $episdoe->title .' | '. $settings->website_name ; }
    elseif(!empty($livestream)){ echo $livestream->title .' | '. $settings->website_name ; }
    else{ echo $uppercase .' | ' . $settings->website_name ;} ?>" />



   <meta property="og:description" content="<?php 
     if(!empty($videos_data)){ echo $videos_data->description  ;
    }
    elseif(!empty($episdoe)){ echo $episdoe->description  ;}
    elseif(!empty($series)){ echo $series->description ;}
    elseif(!empty($livestream)){ echo $livestream->description  ;}
    else{ echo $settings->website_description   ;} //echo $settings; ?>" />



   <meta property="og:image" content="<?php 
     if(!empty($videos_data)){ echo URL::to('/public/uploads/images').'/'.$videos_data->image  ;
    }
    elseif(!empty($episdoe)){ echo URL::to('/public/uploads/images').'/'.$episdoe->image  ;}
    elseif(!empty($series)){ echo URL::to('/public/uploads/images').'/'.$series->image ;}
    elseif(!empty($livestream)){ echo URL::to('/public/uploads/images').'/'.$livestream->image ;}
    else{  echo URL::to('/').'/public/uploads/settings/'. $settings->logo   ;} //echo $settings; ?>" />

<?php  $Linking_Setting = App\LinkingSetting::first();  
$site_url = \Request::url();
$http_site_url = explode("http://",$site_url);
$https_site_url = explode("https://",$site_url);
if(!empty($http_site_url[1])){
$site_page_url = $http_site_url[1];
}elseif(!empty($https_site_url[1])){
   $site_page_url = $https_site_url[1];
}else{
   $site_page_url = "";
}
 ?>
<?php if(!empty($Linking_Setting->ios_app_store_id)){ ?><meta property="al:ios:app_store_id" content="<?php  echo $Linking_Setting->ios_app_store_id; ?>" /><?php } ?>
<meta property="al:ios:url" content="<?php echo $site_page_url  ; ?>" />
<?php if(!empty($Linking_Setting->ipad_app_store_id)){ ?><meta property="al:ipad:app_store_id" content="<?php  echo $Linking_Setting->ipad_app_store_id  ; ?>" /><?php } ?>
<meta property="al:ipad:url" content="<?php echo $site_page_url  ; ?>" />
<?php if(!empty($Linking_Setting->android_app_store_id)){ ?><meta property="al:android:package" content="<?php  echo $Linking_Setting->android_app_store_id  ; ?>" /><?php } ?>
<meta property="al:android:url" content="<?php echo $site_page_url  ; ?>" />
<meta property="al:windows_phone:url" content="<?php echo $site_page_url  ; ?>" />
<?php if(!empty($Linking_Setting->windows_phone_app_store_id)){ ?><meta property="al:windows_phone:app_id" content="<?php  echo $Linking_Setting->windows_phone_app_store_id;?>" /><?php } ?>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <input type="hidden" value="<?php echo $settings->google_tracking_id ; ?>" name="tracking_id" id="tracking_id">

     
           
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/variable.css';?>" />
    <!-- Style -->
      <link href="<?php echo URL::to('public/themes/theme3/assets/css/style.css') ?>" rel="stylesheet">
    
       <link href="<?php echo URL::to('public/themes/theme3/assets/css/typography.css') ?>" rel="stylesheet">
       <link href="<?php echo URL::to('public/themes/theme3/assets/css/responsive.css') ?>" rel="stylesheet">
     

       <!-- Icon - Remixicon & fontawesome  -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    


    <!-- Responsive -->
 
    <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/slick.css';?>" />
       <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
    <?php 
      $Script = App\Script::pluck('header_script')->toArray();
      if(count($Script) > 0){
         foreach($Script as $Scriptheader){   ?>
        <?= $Scriptheader ?>
         <?php } 
        } ?>
   </head>
    <style>
           .fullpage-loader {
	position: fixed;
	top: 0;
	left: 0;
	height: 100vh;
	width: 100vw;
	overflow: hidden;
	background: radial-gradient(72.19% 72.19% at 47.68% 20.46%, #2B0781 0%, #22093C 100%);
	z-index: 9999;
	opacity: 1;
	transition: opacity .5s;
	display: flex;
	justify-content: center;
	align-items: center;
	.fullpage-loader__logo {
		position: relative;
		&:after {
			// this is the sliding white part
			content: '';
			height: 100%;
			width: 100%;
			position: absolute;
			top: 0;
			left: 0;
			animation: shine 2.5s infinite cubic-bezier(0.42, 0, 0.58, 1);
						
			// opaque white slide
			background: rgba(255,255,255,.8);
			// gradient shine scroll
			background: -moz-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 50%, rgba(255,255,255,0) 100%); /* FF3.6-15 */
			background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 50%,rgba(255,255,255,0) 100%); /* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to right, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 50%,rgba(255,255,255,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#00ffffff',GradientType=1 ); /* IE6-9 */
			
		}
	}
}

@keyframes shine {
	0% {
		transform: translateX(-100%) skew(-30deg);
	}
	100% {
		transform: translateX(200%) skew(-30deg);
	}
}

.fullpage-loader--invisible {
	opacity: 0;
}

        svg{
            height: 30px;
        }
        #main-header{ color: #fff; }
        .svg{ color: #fff; } 
        #videoPlayer{
        width:100%;
       height: 100%;
        margin: 20px auto;
    }
        .media h6{
           /* font-family: Chivo;
    font-style: normal;
    font-weight: normal;*/
    font-size: 18px;
    line-height: 29px;
        }
    i.fas.fa-child{
    font-size: 35px;
    color: white;
    }
    span.kids {
    color: #f7dc59;
   }  
      span.family{
         color: #f7dc59;
      }
      i.fa.fa-eercast{
    font-size: 35px;
    color: white;
      }
      a.navbar-brand.iconss {
         font-size: 19px;
         font-style: italic;
         font-family: ui-rounded;
      }
        .switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 20px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderk {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ddd;
  -webkit-transition: .4s;
  transition: .4s;
}

.sliderk:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 15px;
  left: 5px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .sliderk {
  background-color: #2196F3;
}

input:focus + .sliderk {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .sliderk:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.sliderk.round {
  border-radius: 34px;
}

.sliderk.round:before {
  border-radius: 50%;
}
        .dropdown-toggle::after{
            display: none!important;
        }
/* Dark mode and light Mode */
      body.light-theme {
	     background: <?php echo GetLightBg(); ?>!important;
        
      } 
        body.light-theme #menu {
	     background: <?php echo GetLightBg(); ?>!important;
        
      }
 body.light-theme #menuToggle input:checked ~ span{
	   background: #000!important;
        
      }
        body.light-theme #menuToggle span{
             background: #000!important;
        }
        body.light-theme li.list-group-item a{
             color: <?php echo GetLightText(); ?>;
        }  
        body.light-theme .icn1{
             color: <?php echo GetLightText(); ?>!important;
        }
      body.light-theme h4, body.light-theme p {
         color: <?php echo GetLightText(); ?>;
      }
        body.light-theme header#main-header{
           background: <?php echo GetLightBg(); ?>!important;  
            color: <?php echo GetLightText(); ?>;
             box-shadow: 0 0 50px #ccc;
        }
        body.light-theme footer{
            background-color: <?php echo GetLightBg(); ?>!important;  
            color: <?php echo GetLightText(); ?>;
                     box-shadow: 0 0 50px #ccc;

        }
        body.light-theme .copyright{
             background-color: <?php echo GetLightBg(); ?>;
            color: <?php echo GetLightText(); ?>;
        }
        body.light-theme .dropdown-item.cont-item{
             color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme .s-icon{
           background-color: <?php echo GetLightBg(); ?>; 
             box-shadow: 0 0 50px #ccc;
        }
        body.light-theme .search-toggle:hover, header .navbar ul li.menu-item a:hover{
            color: cornflowerblue!important;
        }
    body.light-theme .dropdown-menu.categ-head{
             background-color: <?php echo GetLightBg(); ?>!important;  
            color: <?php echo GetLightText(); ?>!important;
        }
         body.light-theme .navbar-right .iq-sub-dropdown{
           background-color: <?php echo GetLightBg(); ?>;  
        }
        body.light-theme .media-body h6{
             color: <?php echo GetLightText(); ?>;
        }
        body.light-theme  header .navbar ul li{
            font-weight: 400;
        }
        body.light-theme .slick-nav i{
             color: <?php echo GetLightText(); ?>!important;
        }
         body.light-theme  .block-description h6{
             color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme footer ul li{
            color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme h6{
             color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme .movie-time i{
            color: <?php echo GetLightText(); ?>!important;
        }
        body.light-theme span{
            color: <?php echo GetLightText(); ?>!important;
        }
        #menuToggle
{
  display: block;
  position: relative;
 top:5px;
  
  z-index: 1;
  
  -webkit-user-select: none;
  user-select: none;
}

#menuToggle a
{
  text-decoration: none;
  color: #232323;
  
  transition: color 0.3s ease;
}

#menuToggle a:hover
{
  color: tomato;
}


#menuToggle input
{
  display: block;
  width: 40px;
  height: 32px;
  position: absolute;
  top: -7px;
  left: -15px;
  
  cursor: pointer;
  
  opacity: 0; /* hide this */
  z-index: 2; /* and place it over the hamburger */
  
  -webkit-touch-callout: none;
}

/*
 * Just a quick hamburger
 */
#menuToggle span
{
  display: block;
  width: 33px;
  height: 4px;
  margin-bottom: 5px;
  position: relative;
  margin-left: -20px;
  background: #cdcdcd;
  border-radius: 3px;
  
  z-index: 1;
  
  transform-origin: 4px 0px;
  
  transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              opacity 0.55s ease;
}
#menuToggle span1
{
  display: block;
  width: 20px;
  height: 4px;
  margin-bottom: 5px;
  position: relative;
  
  background: #cdcdcd;
  border-radius: 3px;
  
  z-index: 1;
  
  transform-origin: 4px 0px;
  
  transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              opacity 0.55s ease;
}
#menuToggle span:first-child
{
  transform-origin: 0% 0%;
    width: 13px;
}

#menuToggle span:nth-last-child(2)
{
  transform-origin: 0% 100%;
}

/* 
 * Transform all the slices of hamburger
 * into a crossmark.
 */
#menuToggle input:checked ~ span
{
  opacity: 1;
  transform: rotate(45deg) translate(-2px, -1px);
  background: #fff;
}

/*
 * But let's hide the middle one.
 */
#menuToggle input:checked ~ span:nth-last-child(3)
{
  opacity: 0;
  transform: rotate(0deg) scale(0.2, 0.2);
}

/*
 * Ohyeah and the last one should go the other direction
 */
#menuToggle input:checked ~ span:nth-last-child(2)
{
  transform: rotate(-45deg) translate(0, -1px);
}

/*
 * Make this absolute positioned
 * at the top left of the screen
 */
#menu
{
  position: absolute;
  width: 300px;
  margin: -100px 0 0 -50px;
  padding: 20px;
  padding-top: 125px;
  text-align: left;
  background: #100033;
  list-style-type: none;
  -webkit-font-smoothing: antialiased;
  /* to stop flickering of text in safari */
  
  transform-origin: 0% 0%;
  transform: translate(-100%, 0);
  
  transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0);
}

#menu li
{
  padding: 0;
  font-size: 22px;
    font-family: 'Gilroy';
    font-weight: 300;
}

/*
 * And let's slide it in from the left
 */
#menuToggle input:checked ~ ul
{
  transform: none;
}
        
    </style>
     
   <body>
         <div class="fullpage-loader">
	<div class="fullpage-loader__logo">
		
		<img src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>">
	</div>
</div>
      <!-- loader Start -->
     <!-- <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
      <!-- loader END -->
     <!-- Header -->
       
