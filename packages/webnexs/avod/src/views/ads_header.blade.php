<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Advertiser Panel</title>
    <meta name="description" content="" />
    <meta name="author" content="webnexs" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= getFavicon() ?>" type="image/gif" sizes="16x16">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/admin/dashassets/css/bootstrap.min.css' ?>" />

    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/admin/dashassets/css/responsive.css' ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!--datatable CSS -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/admin/dashassets/css/dataTables.bootstrap4.min.css' ?>" />
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/admin/dashassets/css/typography.css' ?>" />
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/admin/dashassets/css/style.css' ?>" />
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/admin/dashassets/css/vod.css' ?>" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?= URL::to('/') . '/assets/admin/dashassets/css/responsive.css' ?>" />

    <!--[if lt IE 9]><script src="<?= THEME_URL . '/assets/admin/admin/js/ie8-responsive-file-warning.js' ?>"></script><![endif]-->

    <!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js') }}/1.4.2/respond.min.js') }}"></script>
  <![endif]-->

   <style>
       body.dark {background-color: #1d1d1d;} /* #9b59b6 */
 body.dark .iq-card1{background-color: #1d1d1d;} /* #9b59b6 */
 body.dark .iq-card0{background-color: #222428;} /* #9b59b6 */
 body.dark .card-title{background-color: #222428;} /* #9b59b6 */
    body.dark .iq-sidebar-menu .iq-menu li ul li a:hover {
    background-color: #222428;
    color: #ffffffe6;
} /* #9b59b6 */
    body.dark .content-page{background-color: #1d1d1d;} /* #9b59b6 */
    body.dark .bg-white{background-color: #1d1d1d!important;} /* #9b59b6 */
    body.dark #video{background-color: transparent;} /* #9b59b6 */
    body.dark .form-control{background: #141414!important;color: #fff!important;} /* #9b59b6 */
    body.dark .form-control option{background: #141414!important;color: #fff!important;} /* #9b59b6 */
    body.dark .select2-selection__rendered{background: #141414!important;} /* #9b59b6 */
    body.dark .r1{background-color:  #222428;color: #ffffffe6;} /* #9b59b6 */
    body.dark .file{background-color: #292c35;} /* #9b59b6 */
    body.dark #sidebar-wrapper .list-group{background-color: #292c35;} /* #9b59b6 */
    body.dark .card-title.upload-ui{background-color: #222428;color: #ffffffe6;} /* #9b59b6 */
    body.dark .dropzone{background-color: #000;color: #ffffffe6;} /* #9b59b6 */
    body.dark .list-group-flush .list-group-item{background-color: #292c35;color: #fff;} /* #9b59b6 */
    body.dark .black{background-color: #222428!important;color: #ffffffe6!important;} /* #9b59b6 */
    body.dark .movie_table tbody td{background-color: #222428;color: #ffffffe6;} /* #9b59b6 */
    body.dark .table-striped tbody tr:nth-of-type(odd){background-color:  #222428;color: #fff;} /* #9b59b6 */
    body.dark .movie_table thead th{background-color: #292c35;color: #ffffffe6!important;} /* #9b59b6 */
    body.dark #msform fieldset{background-color: #292c35;} /* #9b59b6 */
    body.dark .iq-footer{background-color: #1d1d1d;border-top: 1px solid #000;} /* #9b59b6 */
   /* #9b59b6 */
   
    body.dark table.dataTable tbody tr{background-color: #222428;color: #ffffffe6;} /* #9b59b6 */
    body.dark .tab-content{background-color:  #222428;} /* #9b59b6 */
    body.dark .iq-card{background-color: #222428;} /* #9b59b6 */
    body.dark .iq-top-navbar {background-color: #1d1d1d;border-bottom: 1px solid #000;} /* #9b59b6 */
    body.dark .iq-sidebar {background-color: #1d1d1d;border-right: 1px solid #000;} /* #9b59b6 */
    body.dark .iq-menu li a span{color: #ffffffe6;} /* #9b59b6 */
    /*body.dark h1,h2,h3,h4,h5,h6{color: #fff;}*/
    body.dark label{color: #ffffffe6;}
    body.dark li.active a span{color: #ffffffe6!important;}
    body.dark .iq-submenu li>a{color: #ffffffe6;}
    body.dark #optionradio{color: #fff;}
    body.dark .dropzone .dz-message .dz-button{color: #fff;}
    body.dark th{color: #ffffffe6;}
    body.dark .table-bordered td, .table-bordered th {color: #ffffffe6;}
    body.dark .tags-input-wrapper input{color: #ffffffe6;}
    body.dark h2{color: #ffffffe6;}
    body.dark h3{color: #ffffffe6;}
    body.dark h4{color: #ffffffe6;}
    body.dark h5{color: #ffffffe6;}
    body.dark .theme_name{color: #ffffffe6;}
    body.dark h6{color: #ffffffe6;}
    body.dark .upload-ui{color: #000;}
    body.dark div.dataTables_wrapper div.dataTables_info{color: #ffffffe6!important;}
    body.dark .line{color: #fff;}
    body.dark .dataTables_info{color: #ffffffe6;}
    body.dark .list-inline-item a{color: #ffffffe6;}
    body.dark .val{color: #fff;}
    body.dark .main-circle i{color: #ffffffe6;}
    body.dark .text-right{color: #ffffffe6;}
    body.dark .iq-arrow-right{color: #ffffffe6;}
    body.dark .form-group{color: #ffffffe6;}
    body.dark p{color: #ffffffe6!important;}
body.dark h1, body.dark .support a {color: #ffffffe6;}
       .checkbox-label {
  background-color: #111;
  width: 50px;
  height: 26px;
  border-radius: 50px;
  position: relative;
  padding: 5px;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.fa-moon {color: #f1c40f;}

.fa-sun {color: #f39c12;}

.checkbox-label .ball {
  background-color: #fff;
  width: 22px;
  height: 22px;
  position: absolute;
  left: 2px;
  top: 2px;
  border-radius: 50%;
  transition: transform 0.2s linear;
}

.checkbox:checked + .checkbox-label .ball {
  transform: translateX(24px);
}
 .checkbox {
  opacity: 0;
  
}
    .list-user-action{
        display: flex;
    }
        label {
            font-size: 15px;
        }

        .top-left-logo img {
            opacity: .9;
            overflow: hidden
        }

        span {
            font-weight: 400 !important
        }

        .header-logo {
            padding-left: 25px
        }

        hr {
            border-top: 1px solid #e2e2e22e !important
        }

        * {
            margin: 0;
            padding: 0
        }

        html {
            height: 100%
        }

        #grad1 {
            background-color: :#9c27b0;
            background-image: linear-gradient(120deg, #ff4081, #81d4fa)
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }

        #msform fieldset .form-card {
            border: 0 none;
            border-radius: 0;
            /*box-shadow:0 2px 2px 2px rgba(0,0,0,.2);*/
            padding: 10px;
            box-sizing: border-box;
            margin: 0 5% 20px;
            position: relative
        }

        #msform fieldset {
            background: #fff;
            border: 0 none;
            border-radius: .5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform fieldset .form-card {
            text-align: left;
            color: #9e9e9e
        }

        #msform input,
        #msform textarea {
            border: none;
            border-radius: 0;
            margin-bottom: 25px;
            margin-top: 2px;
            box-sizing: border-box;
            color: #2c3e50;
            font-size: 16px;
            letter-spacing: 1px;
            background: ;
        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: none;
            font-weight: 700;
            border-bottom: 2px solid skyblue;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: skyblue;
            font-weight: 700;
            color: #fff;
            border: 0 none;
            border-radius: 0;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px skyblue
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: 700;
            color: #fff;
            border: 0 none;
            border-radius: 0;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px #616161
        }

        select.list-dt {
            border: none;
            outline: 0;
            border-bottom: 1px solid #ccc;
            padding: 2px 5px 3px;
            margin: 2px
        }

        select.list-dt:focus {
            border-bottom: 2px solid skyblue
        }

        .card {
            z-index: 0;
            border: none;
            border-radius: .5rem;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
            text-align: left
        }

        #progressbar {
            overflow: hidden;
            color: #d3d3d3
        }

        #progressbar .active {
            color: #000
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 500;
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f023";
            display: none;
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007";
            display: none;
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f09d";
            display: none;
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c";
            display: none;
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 18px;
            color: #fff;
            background: #d3d3d3;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: #d3d3d3;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: skyblue
        }

        .radio-group {
            position: relative;
            margin-bottom: 25px
        }

        .radio {
            display: inline-block;
            width: 204;
            height: 104;
            border-radius: 0;
            background: #add8e6;
            box-shadow: 0 2px 2px 2px rgba(0, 0, 0, .2);
            box-sizing: border-box;
            cursor: pointer;
            margin: 8px 2px
        }

        .radio:hover {
            box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, .3)
        }

        .radio.selected {
            box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, .1)
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }

        .pay,
        .razorpay-payment-button {
            width: 100px;
            background: skyblue !important;
            font-weight: 700;
            color: #fff !important;
            border: 0 none;
            border-radius: 0;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px
        }

        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before,
        table.dataTable thead .sorting_desc_disabled:after {
            position: absolute;
            bottom: 1.4em !important;
            display: block;
            opacity: 0.3;
        }

        .checkbox input,
        .checkbox label {
            display: inline-block;
            vertical-align: middle;
        }

        .ages {
            margin: 10px;
        }

        .household_Income {
            margin: 10px;
        }

        #progressbar li img {
            width: 80px;
            display: block;
            margin: 0 auto;
        }

        .ads {
            padding: 10px;
            margin-left: 10px;
            margin-bottom: 0;
            font-weight: 600;
        }

        .wrapper-menu {
            align-items: center
        }

        #msform .action-button {
            width: 100px;
            background: #0993D2;
            font-weight: 500;
            color: white;
            border: 0 none;
            border-radius: 4px;
            cursor: pointer;
            padding: 7px 5px;

            float: right;
        }

        #Advertiser {
            padding-left: 50px;
        }

        li.active a span {
            color: #000 !important;
        }

        #Ads {
            padding-left: 50px;
        }

        #his {
            padding-left: 50px;
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: 500;
            color: white;
            border: 0 none;
            border-radius: 4px;
            cursor: pointer;
            padding: 7px 5px;
            margin: 10px 5px 10px 0px;
            float: right;
        }

        .iq-sidebar-menu .iq-menu li a span {

            padding: 5px 12px 6px 5px;
        }
    </style>

</head>

<body>
    <?php $settings = App\Setting::first(); 
    $theme_mode = App\SiteTheme::pluck('Ads_theme_mode')->first();
    $theme = App\SiteTheme::first();
    ?>
    <div class="page-container sidebar-collapsed">

      <!-- Sidebar-->
        <div class="iq-sidebar">
            <div class="iq-sidebar- d-flex justify-content-between align-items-center mt-2">
                <a href="{{ URL::to('home') }}" class="header-logo">
                    <img src="{{ URL::to('public/uploads/settings/'. $settings->logo) }}" class="c-logo" alt="">
                    <div class="logo-title">
                        <span class="text-primary text-uppercase"></span>
                    </div>
                </a>

                <div class="iq-menu-bt-sidebar">
                    <div class="iq-menu-bt align-self-center">
                        <div class="wrapper-menu">
                            <div class="main-circle"><i class="las la-bars"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sidebar-scrollbar">
               <nav class="iq-sidebar-menu">
                  <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="views"><a href="{{ URL::to('home') }}"><img height="40" width="40" src="{{ URL::to('/assets/img/icon/visit.svg') }}  "><span>Visit site</span></a></li>
                        <li>  
                           <a href="{{  URL::to('advertiser') }}" class="iq-waves-effect"> <img height="40"width="40" src="{{  URL::to('/assets/img/icon/home.svg') }} "><span>Dashboard</span></a></li><li>
                           <a href="#Advertiser" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="{{ URL::to('/assets/img/icon/user.svg') }} " height="40" width="40"><span>Advertisements </span> <i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="Advertiser" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li><a href="{{ URL::to('advertiser/ads-list') }}" class="iq-waves-effect"><span>All advertisement</span></a></li>
                                <li><a href="{{ URL::to('advertiser/upload_ads') }}" class="iq-waves-effect"><span> Add New Advertisement</span></a></li>
                                {{-- <li><a href="{{ URL::to('advertiser/upload_featured_ad') }}" class="iq-waves-effect"><span>Upload Payperview Ads</span></a></li>
                                <li><a href="{{ URL::to('advertiser/featured_ads') }}" class="iq-waves-effect"><span>View PPV Ads</span></a></li> --}}
                                <li><a href="{{ URL::to('advertiser/Ads_Scheduled') }}" class="iq-waves-effect"><span>Schedule Advertisement</span></a></li>
                                {{-- <li><a href="{{ URL::to('advertiser/ads_campaign') }}" class="iq-waves-effect"><span>Ads campaign</span></a></li> --}}
                            </ul>
                        </li>

                        <li>
                            <a href="#Ads" class="iq-waves-effect collapsed" data-toggle="collapse"  aria-expanded="false"><img class="" src="{{  URL::to('/assets/img/icon/anay.svg') }}" height="40" width="40"><span>Ads Analytics </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                           
                            <ul id="Ads" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                              <li><a href="{{ route('Advertisement.Cost_Per_Click_Analysis') }}" class="iq-waves-effect"><span>CPC</span></a></li>
                              <li><a href="{{ route('Advertisement.Cost_Per_View_Analysis') }}" class="iq-waves-effect"><span>CPV</span></a></li>
                            </ul>
                        </li>


                        <li>
                           <a href="#his" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><img class="" src="{{ URL::to('/assets/img/icon/his.svg') }}" height="40" width="40"><span>History </span>
                              <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                           </a>

                            <ul id="his" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li><a href="{{ URL::to('advertiser/featured_ad_history') }}" class="iq-waves-effect"><span>Featured Ad History</span></a></li>
                                <li><a href="{{ URL::to('advertiser/plan_history') }}" class="iq-waves-effect"><span> Plans History</span></a></li>
                            </ul>
                        </li>

                        <div class="bod"></div>
                        <li><a href=" {{ route('ads_logout') }}" class="iq-waves-effect"><img  src=" {{ URL::to('/assets/img/icon/logout.svg') }}" height="40" width="40"><span> Logout</span></a></li>

                        <?php $activeplan = App\Advertiserplanhistory::where('advertiser_id', session('advertiser_id'))->where('status', 'active')->count();
                           ($activeplan != 0)
                        ?>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="main-content">

            <div class="row">

                <!-- TOP Nav Bar -->
                <div class="iq-top-navbar">
                    <div class="iq-navbar-custom">
                        <nav class="navbar navbar-expand-lg navbar-light p-0">
                            <div class="iq-menu-bt d-flex align-items-center">
                                <div class="wrapper-menu">
                                    <div class="main-circle"><i class="las la-bars"></i></div>
                                </div>
                                
                                <div class="iq-navbar-logo d-flex justify-content-between">
                                    <a href="<?php echo URL::to('home'); ?>" class="header-logo">
                                       <div class="logo-title">  <span class="text-primary text-uppercase"></span></div>
                                    </a>
                                </div>
                            </div>
                            
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                                <i class="ri-menu-3-line"></i>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto navbar-list">
                                    <li class="nav-item nav-icon search-content">
                                       <a href="#" class="search-toggle iq-waves-effect text-gray rounded"> <i class="ri-search-line"></i></a>
                                        
                                       {{-- Search  --}}
                                       <form action="#" class="search-box p-0">
                                          <input type="text" class="text search-input" placeholder="Type here to search...">
                                          <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                       </form>
                                    </li>

                                    <li class="line-height pt-3">

                                        <a href="#"  class="search-toggle iq-waves-effect d-flex align-items-center">
                                          <img src="{{ URL::to('public/uploads/avatars/' . (Auth::check() ? Auth::user()->avatar : 'default.png')) }}" class="img-fluid avatar-40 rounded-circle" alt="user">  
                                        </a>

                                        <div class="iq-sub-dropdown iq-user-dropdown">
                                            <div class="iq-card shadow-none m-0">
                                                <div class="iq-card-body p-0 ">
                                                    <div class="bg-primary p-3 d-flex justify-content-between align-items-center">
                                                        <h5 class="mb-0 text-white line-height">Hello </h5>
                                                       <div>
            <input type="checkbox" class="checkbox" id="checkbox" value=<?php echo $theme_mode;  ?>  <?php if($theme_mode == "light") { echo 'checked' ; } ?> />
               <label for="checkbox" class="checkbox-label">
                  <i class="fas fa-moon"></i>
                  <i class="fas fa-sun"></i>
                  <span class="ball"></span>
               </label>
                                         </div>
                                                    </div>

                                                    <a href="{{ URL::to('admin/users') }}" class="iq-sub-card iq-bg-primary-hover">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon iq-bg-primary"> <i class="ri-file-user-line"></i></div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">My Profile</h6>
                                                                <p class="mb-0 font-size-12">View personal profile details.</p>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <a href="{{ URL::to('/myprofile') }}" class="iq-sub-card iq-bg-primary-hover">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon iq-bg-primary"> <i class="ri-profile-line"></i> </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Edit Profile</h6>
                                                                <p class="mb-0 font-size-12">Modify your personal details.</p>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <div class="d-inline-block w-100 text-center p-3">
                                                        <a class="bg-primary iq-sign-btn" href="{{ URL::to('advertiser/logout') }}" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            
  <script>
         $("#checkbox").click(function(){
         
            var theme_mode = $("#checkbox").prop("checked");
        //  alert(theme_mode);
            $.ajax({
            url: '<?php echo URL::to("ads-theme-mode") ;?>',
            method: 'post',
            data: 
               {
                  "_token": "<?php echo csrf_token(); ?>",
                  mode: theme_mode 
               },
               success: (response) => {
                  console.log(response);
               },
            })
         });
         
      </script>

        <!-- Dark Mode & Light Mode  -->
        <script>
         let theme_modes = $("#checkbox").val();
         
         $(document).ready(function(){
         
            if( theme_modes == 'dark' ){
               document.body.classList.toggle("dark")
            }
         });
      </script>
            <script>
    const checkbox = document.getElementById("checkbox")
checkbox.addEventListener("change", () => {
  document.body.classList.toggle("dark")
})
          </script>  
@yield('content')