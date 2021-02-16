@include('header')
<style>
 
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

@extends('footer')