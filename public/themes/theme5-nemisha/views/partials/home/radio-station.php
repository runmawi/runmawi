<?php if (count($radiostations) > 0): ?>

<div class="iq-main-header d-flex align-items-center justify-content-between">

   <h5 class="main-title"><a href="<?php if ($order_settings_list[42]->header_name) {echo URL::to('/') . '/' . $order_settings_list[42]->url;} else {echo "";}?>">
      <?php if ($order_settings_list[42]->header_name) {echo $order_settings_list[42]->header_name;} else {echo "";}?>
      </a>
   </h5>

   <a class="see" href="<?php echo !empty($order_settings_list[42]->header_name) ? URL::to('/') . '/' . $order_settings_list[42]->url : ""; ?>"> See All </a>
</div>
<div class="favorites-contens">
   <div class="radio-station home-sec list-inline row p-0 mb-0">
                   <?php if (isset($radiostations)):
    foreach ($radiostations as $radiostation): ?>
	                 <div class="items">
	                    <a href="<?=URL::to('radio-station')?><?='/' . $radiostation->slug?>">

	                       <div class="block-images position-relative">
	                          <div class="img-box">
	                          <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $radiostation->image; ?>" class="img-fluid w-100 h-50" alt="<?php echo $radiostation->title; ?>">
	                          </div> </div>
	                          <div class="block-description" > </div>

	                             <div class="hover-buttons">
	                             <a href="<?=URL::to('audio')?><?='/' . $radiostation->slug?>" alt="<?php echo $radiostation->title; ?>">
	            <h5 style="font-size:1.0em; font-weight:500;" class="epi-name text-white mb-0"><?php echo $radiostation->title; ?></h5>
	         </a>

	                             </div>




	                    </a>
	                 </div>

	                  <?php endforeach;
endif;?>
              </div>
           </div>

<?php endif;?>


<script>
var elem = document.querySelector('.radio-station');
var flkty = new Flickity(elem, {
  cellAlign: 'left',
  contain: true,
  groupCells: true,
  pageDots: false,
  draggable: true,
  freeScroll: true,
  imagesLoaded: true,
  lazyload:true,
});
</script>