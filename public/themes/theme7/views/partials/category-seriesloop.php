<style>
   .playvid {
      display: block;
      width: 280%;
      height: auto !important;
      margin-left: -410px
   }

   .btn.btn-primary.close {
      margin-right: -17px;
      background-color: #4895d1 !important
   }

   button.close {
      padding: 9px 30px !important;
      border: 0;
      -webkit-appearance: none
   }

   .close {
      margin-right: -429px !important;
      margin-top: -1461px !important
   }

   .modal-footer {
      border-bottom: 0 !important;
      border-top: 0 !important
   }
</style>
<div class="">
   <div class="row">
      <div class="col-sm-12 overflow-hidden">
         <div class="iq-main-header d-flex align-items-center justify-content-between">
            <a href="<?php echo URL::to('/play_series') . '/' . $category->id; ?>" class="category-heading"
               style="text-decoration:none;color:#fff">
               <h4 class="movie-title">
                  <?php echo __($category->name); ?>
               </h4>
            </a>
         </div>
         <div class="favorites-contens">
            <ul class="favorites-slider list-inline  row p-0 mb-0">
               <?php if (isset($series)):
                  foreach ($series as $category_series): ?>
                     <li class="slide-item">
                        <a href="<?php echo URL::to('home') ?>">
                           <div class="block-images position-relative">
                              <div class="img-box">
                                 <a href="<?php echo URL::to('/play_series') . '/' . $category->id; ?>">
                                       <img  src="<?php echo URL::to('/') . '/public/uploads/images/' . $category_series->image; ?>" class="img-fluid w-100" alt="">
                                 </a>
                              </div>
                        </a>
                     </li>
                  <?php endforeach;
               endif; ?>
            </ul>
         </div>
      </div>
   </div>
</div>