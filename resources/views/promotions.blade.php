
  @include('header')  
   <head>
      <!-- Required meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/fl-logo.png" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
       <style>
           .h-100 {
    height: 540px !important;
}
           .blink_me {
    animation: blinker 2s linear infinite;
  }
  @keyframes blinker {
    50% {
      opacity: 0;
    }
  }
           .container{
        height: 540px !important;
    }
    .item{
        margin-top: 60px;
    }
            a {
    color: var(--iq-body-text) !important;
}
            /*.navbar-right.menu-right {
    margin-right: -150px !important;
}*/
             li.list-group-item {
              background-color: transparent !important;
               padding-right: unset !important;
}
           li.list-group-item a{
              background: transparent !important;
               color: var(--iq-body-text) !important;
               font-size: 12px !important;
               padding-left: 10px !important;
               
}
            li.list-group-item a:hover{
             color: var(--iq-primary) !important;
         }
           /* scroller */
.scroller { overflow-y: auto; scrollbar-color: var(--iq-primary) var(--iq-light-primary); scrollbar-width: thin; }
.scroller::-webkit-scrollbar-thumb { background-color: var(--iq-primary); }
.scroller::-webkit-scrollbar-track { background-color: var(--iq-light-primary); }
#sidebar-scrollbar { overflow-y: auto; scrollbar-color: var(--iq-primary) var(--iq-light-primary); scrollbar-width: thin; }
#sidebar-scrollbar::-webkit-scrollbar-thumb { background-color: var(--iq-primary); }
/*#sidebar-scrollbar { height: calc(100vh - 153px) !important; }*/
#sidebar-scrollbar::-webkit-scrollbar-track { background-color: var(--iq-light-primary); }
::-webkit-scrollbar { width: 8px; height: 8px; border-radius: 5px; }
           .search_content{
                           top: 85px !important;
                           width: 400px !important;
                           margin-right: -15px !important;
                           
                          }
                           ul.list-group {
                    text-align: left !important;
                               max-height: 450px !important;
                }
           li.list-group-item {
    width: 375px;
}
           h3 {
    font-size: 24px !important;
}


       </style>
   </head>
 
             
   <body>
<!-- Header -->
     
      <!-- Header End -->

      <section class="homeslide">
   
   <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
  <!-- Wrapper for slides -->
  <div class="carousel-inner">

	               <div class="item <?php if($promotion->banner != ''){echo 'active';}?> header-image" style="background-image: url(<?php echo URL::to('/').'/public/uploads/settings/'.$promotion->banner;  ?>);background-size: contain;"></div>
    </div>
    
  </div>
</section>
<div style="clear:both;height: 15px;"></div>

    <div class="container">

        <?php
                echo $promotion->body;
        ?>
    </div>
         <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>
      <!-- back-to-top End -->
      <!-- jQuery, Popper JS -->
      <script src= "<?= URL::to('/'). '/assets/js/jquery-3.4.1.min.js';?>"></script>
      <script src="<?= URL::to('/'). '/assets/js/popper.min.js';?>"></script>
      <!-- Bootstrap JS -->
      <script src="<?= URL::to('/'). '/assets/js/bootstrap.min.js';?>"></script>
      <!-- Slick JS -->
      <script src="<?= URL::to('/'). '/assets/js/slick.min.js';?>"></script>
      <!-- owl carousel Js -->
      <script src="<?= URL::to('/'). '/assets/js/owl.carousel.min.js';?>"></script>
      <!-- select2 Js -->
      <script src="<?= URL::to('/'). '/assets/js/select2.min.js';?>"></script>
      <!-- Magnific Popup-->
      <scriptsrc="<?= URL::to('/'). '/assets/js/jquery.magnific-popup.min.js';?>"></script>
      <!-- Slick Animation-->
      <script src="<?= URL::to('/'). '/assets/js/slick-animation.min.js';?>"></script>
      <!-- Custom JS-->
      <script src="<?= URL::to('/'). '/assets/js/custom.js';?>"></script>
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
    
<script>
  // Prevent closing from click inside dropdown
  $(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });
    
  // make it as accordion for smaller screens
  if ($(window).width() < 960) {
    $('.dropdown-menu a').click(function(e){
      e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.submenu').hide();
      }
                       )
    }
                               );
  }
</script>
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
       


 </body>

  @extends('footer')  

  


