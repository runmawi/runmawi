<?php include('header.php'); ?>
<div class="bg-movie mt-5 pt-3">
    <div class="container">
        <div class="row mt- pt-5 align-items-center">
            <div class="col-md-6 h-100">
                <h2 class="mb-3">Movie name</h2>
                <p class="text-white">Rating:	R (Sexuality|Horror|Violence)</p>
                <p class="text-white">Language:	English</p>
                <p class="text-white">Director:	Francis Ford Coppola</p>
                <p class="text-white">Producer:	Francis Ford Coppola</p>
                <p class="text-white">Release Date (Theaters):	Nov 13, 1992  Wide</p>
                 <div class="mb-3">
                            <span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span></div>
            </div>
            <div class="col-md-6">
                <div class="d-flex bg-dark1 pu">
                    <div>
                     <p class="text-white cri">Cast</p></div>
                    <div>
                    <p class="text-white cri">Crew</p></div>
                    <div>
                    <p class="text-white cri">Review</p></div>
                </div>
                <div class="bg-mov">
                    <div class="content">
                            
          <div class="content-overlay"></div>
           <img class="w-100" src="<?php echo URL::to('/').'/assets/img/bg.png';  ?>"> 
          <div class="content-details fadeIn-bottom">
              <h1 class="mb-5 text-center">DARCULA</h1>
             <a href="" class="btn bd "><i class="fa fa-play mr-2" aria-hidden="true"></i> Watch Now</a>
                             <a href="" class="btn bd ml-2"><i class="fa fa-play ml-2" aria-hidden="true"></i> Watch Trailer</a>
          </div>
        
      </div>
                  
                </div>
                <div class="row mt-2 mb-3 align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between p-0">
                            <div>
                        <p class="text-white cri1">Horror</p></div>
                         <div><p class="text-white cri1">Drama</p></div>
                        <div> <p class="text-white cri1">Fanasty</p></div></div>
                        <p class="text-white mt-2 mb-2">The centuries old vampire Count Dracula comes to
England to seduce his barrister Jonathan Harker's
fiancée Mina Murray and inflict havoc in the foreign</p>
                        <p class="text-white mt-2 mb-2">Rating:	R (Sexuality|Horror|Violence)</p>
                        <p class="text-white mt-2 mb-2">Language:	English</p>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="mb-4">
                                            <a class="big1 text-white">
                                             Watchon Flicknexs  
                                            </a>
                                        </div>
                        <div class="mt-5 pt-2">
                                            <a class="big1 text-white">+ Add to Watchlist</a></div>
                                                <div >
                                                    <div class="d-flex mt-4 justify-content-between dm">
                                                        <p>813 User reviews</p>
                                                        <p>202 Critic reviews</p>
                                                        <p>57 Meta source</p>
                                                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


    <?php if($home_settings->latest_videos == 1){ ?>
      <section id="iq-favorites">
         <div class="fluid">
            <div class="row">
               <div class="col-sm-12 overflow-hidden">
                  <?php include('partials/home/latest-videos.php'); ?>
               </div>
            </div>
         </div>
      </section>
   <?php } ?>

   <div class="main-content">
    <section id="iq-continue">
        <div class="fluid">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                  <?php include('partials/home/continue-watching.php'); ?>
              </div>
           </div>
        </div>
    </section>

    
    
<?php include('footer.blade.php');?>
