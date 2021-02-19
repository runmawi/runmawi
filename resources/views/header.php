<!DOCTYPE html>
<html lang="<?php echo Session::get('locale');?>" >  
  <head>
    <meta charset="utf-8">
            <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/fl-logo.png" />
    <?php include('head.php'); ?>
    <style>
      .list-group-item:hover{
        background-color: #dedede;
      }

      html {
        direction:ltr;
        font-family: "Droid Sans", sans-serif/*rtl:prepend:"Droid Arabic Kufi",*/;
        font-size:16px/*rtl:14px*/;
      }
    </style>
      <meta name="csrf-token" content="<?php echo csrf_token();?>">

    <style>
        .dark{ 
            background-color: #000; 
            color: #fff; 
        } 
        
        .light{ 
            background-color: #fff; 
            color: #000; 
        } 
             /*Simple css to style it like a toggle switch*/
        .theme-switch-wrapper {
          display: flex;
          align-items: center;

          em {
            margin-left: 10px;
            font-size: 1rem;
          }
        }
        .theme-switch {
                display: inline-block;
                height: 24px;
                position: relative;
                width: 50px;
        }
        .theme-switch input {
          display:none;
        }
        .sliderss {
          background-color: #ccc;
          bottom: 0;
          cursor: pointer;
          left: 0;
          position: absolute;
          right: 0;
          top: 0;
          transition: .4s;
        }
        .sliderss:before {
          background-color: #fff;
          bottom: 4px;
          content: "";
          height: 16px;
          left: 4px;
          position: absolute;
          transition: .4s;
          width: 16px;
        }
        input:checked + .sliderss {
          background-color: #f15f09;
        }
        input:checked + .sliderss:before {
          transform: translateX(26px);
        }
        .sliderss.round {
          border-radius: 34px;
        }
        .sliderss.round:before {
          border-radius: 50%;
        }
        .sticky {
                  position: fixed;
                  top: 0;
                  width: 100%;
                  z-index: 1;
                }
    </style> 
      <script>
         /* $(document).ready(function() {  
              var mylink = localStorage.getItem('theme');

              if (mylink=="dark") {
                 $(".theme_color").attr("checked", "checked");
                 $(".theme_color").val(1);
                 $( "body" ).css( "background" ,'<=GetDarkBg();?>'); 
                 $( "footer" ).css( "background" ,'<=GetDarkBg();?>'); 
                 $( ".navbar-default" ).css( "background" ,'<=GetDarkBg();?>'); 
                 $( "body" ).css( "color" ,"#fff");
                 $( "h4" ).css( "color" ,"#fff");
                //$(".theme_color").val(1);
              } else {

                $( "body" ).css( "background" ,'<=GetLightBg();?>');
                $( ".navbar-default" ).css( "background" ,'<=GetLightBg();?>');
                $( "footer" ).css( "background" ,'<=GetLightBg();?>');
                $( "body" ).css( "color" ,"#000");
                $( "h4" ).css( "color" ,"#000");
                 $(".theme_color").val(0);
                $(".theme_color").removeAttr("checked");
              }
          });*/
      </script>
       <meta name="csrf-token" content="<?php echo csrf_token();?>">

  </head>
    <div class="header" id="myHeader">
  

 
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm navbar-default navbar-static-top" role="navigation" >
    <div class="container">
      <div class="navbar-header" 
           <?php if ( Session::get('locale') == 'arabic') { echo "style='float:right;'"; }?>>
      <a id="nav-toggle" href="#" class="">
        <span>
        </span>
      </a>
      <a class="navbar-brand" href="<?php echo URL::to('/');?>">
        <?php $settings = App\Setting::find(1); ?>
        <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
      </a>
    </div>
    <div class="collapse navbar-collapse right" id="bs-example-navbar-collapse-1" >
      <a class="visible-xs" href="<?php echo URL::to('/');?>" style="padding: 10px 5px;border-bottom: 1px solid #e0e0e0;">
        <?php $settings = App\Setting::find(1); ?>
        <img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
      </a>
      <li class="visible-xs">
        <div id="navbar-search-form">
          <form role="search" action="<?php echo URL::to('/').'/searchResult';?>" method="POST">
            <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
            <div>
              <i class="fa fa-search">
              </i>
              <input type="text"  name="search" class="searches" id="searches" autocomplete="off" placeholder="Search">
            </div>
          </form>
        </div>
        <div id="search_list" class="search_list" style="position: absolute;">
        </div> 
      </li>
      <!-- Left Side Of Navbar -->
      <?php include('menu.php');?>
      <ul class="nav navbar-nav navbar-right">
        <li class="hidden-xs">
          <div id="navbar-search-form">
            <form role="search" action="<?php echo URL::to('/').'/searchResult';?>" method="POST">
              <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
              <div>
                <i class="fa fa-search">
                </i>
                <input type="text" name="search" class="searches" id="searches" autocomplete="off" placeholder="Search">
              </div>
            </form>
          </div>
          <div id="search_list" class="search_list" style="position: absolute;">
          </div> 
        </li>

<!--
          
            <li class="hidden-xs">  
            <div class="theme-switch-wrapper">
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" class="theme_color"  checked="checked" value="1" />
                    <div class="sliderss round"></div>
                </label>
              <em>Enable Dark Mode!</em>
            </div> 
          </li>
-->

        <?php if(Auth::guest()): ?>
        <?php 
$language = App\Language::all();
?>
        <li class="dropdown my_account">
            
<!--
          <div id="google_translate_element">
          </div>
-->
        </li>
        <?php
            $current_url = Request::url();
            $restricted_url_2 = URL::to('/register2');
            $restricted_url_3 = URL::to('/register3');
          
          ?>
        <?php if ( ($current_url != $restricted_url_2) && ($current_url != $restricted_url_3)) { ?>
            <li class="btn signup-desktop">
              <a href="<?= URL::to('/login')?>"> 
                <?php echo _('Sign In');?>
              </a>
            </li>
          <?php } ?>
        <?php else:
$img_file = URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar;
?>
        <?php 
        $language = App\Language::all();
        ?>
    <li class="dropdown my_account">
<!--
        <div id="google_translate_element">
          </div>
-->
          </li>
        <li class="dropdown my_account hidden-xs">
          <a href="#_" class="user-link-desktop dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-circle" /> 
            <?= ucwords(Auth::user()->name) ?> 
            <i class="fa fa-chevron-down">
            </i>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li>
              <a href="<?php echo  URL::to('myprofile') ?>">My Profile
              </a>
            </li>
            <li>
              <a href="<?php echo URL::to('watchlaters') ?>">Watch Later
              </a>
            </li>
<!--
            <li>
              <a href="<?php echo URL::to('mywishlists') ?>">My Wishist 
              </a>
-->
            </li>
              <li><a href="<?php echo URL::to('showPayperview') ?>"><?php echo __('Rented Movies');?></a></li>
            <?php if(Auth::user()->role == 'admin' || Auth::user()->role == 'demo' || Auth::user()->role == 'subadmin'): ?>
            <li class="divider">
            </li>
            <li>
              <a href="<?php echo URL::to('admin') ?>"> Admin
              </a>
            </li>
            <?php endif; ?>
            <li class="divider">
            </li>
            <li>
              <a href="<?php echo URL::to('logout') ?>" id="user_logout_mobile">
                <i class="fa fa-power-off">
                </i> Logout
              </a>
            </li>
          </ul>
        </li>
        <div class="visible-xs nav navbar-nav navbar-left">
          <li>
            <a href="<?php echo  URL::to('myprofile') ?>">My Profile
            </a>
          </li>
          <li>
            <a href="<?php echo URL::to('watchlaters') ?>">Watch Later
            </a>
          </li>
          <li>
            <a href="<?php echo URL::to('mywishlists') ?>">My Wishist 
            </a>
          </li>
          <li><a href="<?php echo URL::to('showPayperview') ?>"><?php echo __('Rented Movies');?></a></li>
          <?php if(Auth::user()->role == 'admin' || Auth::user()->role == 'demo' || Auth::user()->role == 'subadmin'): ?>
          <li class="divider">
          </li>
          <li>
            <a href="<?php echo URL::to('admin') ?>"> Admin
            </a>
          </li>
          <?php endif; ?>
          <li class="divider">
          </li>
          <li>
            <a href="<?php echo URL::to('logout') ?>" id="user_logout_mobile">
              <i class="fa fa-power-off">
              </i> Logout
            </a>
          </li>
        </div>
        <?php endif; ?>
      </ul>
    </div>
    </div>
  </nav>
</div>
<!-- 
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
<div class="container">
<a class="navbar-brand" href="<?php echo URL::to('/');?>">
<?php
$settings = App\Setting::find(1);
?>
<img src="<?php echo URL::to('/').'/public/uploads/settings/' . $settings->logo; ?>">
</a>
<!--
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<php echo  __('Toggle navigation');?>">
<span class="navbar-toggler-icon"></span>
</button>
--
<!--
<h1><php echo __('messages.welcome');?> </h1>
--
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<!-- Left Side Of Navbar --
<?php include('menu.php');?>
<ul class="nav navbar-nav navbar-right">
<li>
<div id="navbar-search-form">
<form role="search" action="<?php echo URL::to('/').'/searchResult';?>" method="POST">
<input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
<div>
<i class="fa fa-search"></i>
<input type="text"  name="search" id="searches" autocomplete="off" placeholder="Search">
</div>
</form>
</div>
<div id="search_list" style="position: absolute;"></div> 
</li>
<?php if(Auth::guest()): ?>
<li class="btn signup-desktop"><a href="<?= URL::to('/login')?>"> <?php echo __('Sign In');?></a>
</li>
<?php else:
$img_file = URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar;
?>
<li class="dropdown my_account">
<a href="#_" class="user-link-desktop dropdown-toggle" data-toggle="dropdown"><img src="<?php echo URL::to('/').'/public/uploads/avatars/' . Auth::user()->avatar ?>" class="img-circle" /> <?= ucwords(Auth::user()->name) ?> <i class="fa fa-chevron-down"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="<?php echo  URL::to('myprofile') ?>"> <?php echo __('My Profile');?></a></li>
<li><a href="<?php echo URL::to('watchlaters') ?>"><?php echo __('Watchlater');?></a></li>
<li><a href="<?php echo URL::to('mywishlists') ?>"><?php echo __('My Wishlist');?></a></li>
<li><a href="<?php echo URL::to('showPayperview') ?>"><?php echo __('Rented Movies');?></a></li>
<?php if ( Auth::user()->subscribed('elitelub') ) { ?>
<li><a href="<?php echo URL::to('refferal') ?>"><?php echo __('Referral');?></a></li>
<?php } ?>
<?php if(Auth::user()->role == 'admin' || Auth::user()->role == 'demo' || Auth::user()->role == 'subadmin'): ?>
<li class="divider"></li>
<li><a href="<?php echo URL::to('admin') ?>"> Admin</a></li>
<?php endif; ?>
<li class="divider"></li>
<li><a href="<?php echo URL::to('logout') ?>" id="user_logout_mobile"><i class="fa fa-power-off"></i> <?php echo __('messages.logout');?></a></li>
</ul>
</li>
<?php endif; ?>
</ul>
</div>
</div>
</nav> -->
<script type="text/javascript">
  $(document).ready(function () {
    $('.searches').on('keyup',function() {
      var query = $(this).val();
      //alert(query);
      // alert(query);
       if (query !=''){
      $.ajax({
        url:"<?php echo URL::to('/search');?>",
        type:"GET",
        data:{
          'country':query}
        ,
        success:function (data) {
          $('.search_list').html(data);
        }
      }
            )
       } else {
            $('.search_list').html("");
       }
    }
                     );
    $(document).on('click', 'li', function(){
      var value = $(this).text();
      $('.search').val(value);
      $('.search_list').html("");
    }
                  );
  }
                   );
</script>
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
    
