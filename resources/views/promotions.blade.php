
  @include('header')  
  
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
            .container {
    color: #fff!important;
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
      
      

  @extends('footer')  

  


