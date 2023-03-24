
<section id="iq-favorites">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 overflow-hidden">
                <div class="favorites-contens">
                    <ul class="favorites-slider list-inline row p-0 mb-0">
                        <?php 
                        if(isset($Related_videos)) :
                        foreach($Related_videos as $related_video): ?>
                            <li class="slide-item">
                              <a href="<?php echo URL::to('live/'.$related_video->slug ) ?>">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img src="<?php echo URL::to('/').'/public/uploads/images/'.$related_video->image;  ?>" class="img-fluid" alt="">
                                        </div>
                                    </div>

                                    <div class="block-description"></div>
                                       <!-- <div class="hover-buttons">
                                            <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                                            <span class="btn btn-hover">
                                                <i class="fa fa-play mr-1" aria-hidden="true"></i>Play Now
                                            </span>
                                           </a>
                                        </div>-->
                                    <div>

                                  
                                </div>

                                  <div class="mt-2">
                                      <h6><?php echo __($related_video->title); ?></h6>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $related_video->duration); ?></span>
                                       </div>
                                 </div>
                              </a>
                            </li>
                        <?php endforeach; endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    overflow-hidden {
        margin-top: 70px;
        overflow: hidden;
                   min-height: 450px !important;
    }
         li.slide-item .block-images{
             margin-bottom: 2rem !important;
         }
        /* .navbar-right.menu-right {
        margin-right: -150px !important;
    }*/
          .nav-tabs {
        border: 0;
        margin-top: 15px;
        text-align: center;
        width: 60%;
    }
       
         .thumb-cont{
             position: fixed;
        z-index: 1040;
        height: 521px !important;
        width: 100% !important;
        margin-top: 80px !important;
        opacity: none;
    }
         .modal-backdrop.show {
        opacity: 0 !important;
        visibility: hidden;
    }
         .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        background-color: #000;
    }
         .img-black-back:before {
        content: "";
        position: absolute;
        /* z-index: 10; */
        background-image: linear-gradient(
    90deg
    ,#000,transparent);
        width: 90%;
        height: 521px !important;
    }
        .btn.btn-danger.closewin {
        margin-right: -17px;
            background-color: #4895d1 !important;
    }
         .tab-pane {
        color: #ffff;
        display: none;
        padding: 50px;
        text-align: left;
        height: 410px !important;
    }
          li.list-group-item a:hover{
                 color: var(--iq-primary) !important;
             }
         
          .playvid {
        display: block;
        width: 280%;
        height: auto !important;
        margin-left: -410px;
    }
                .btn.btn-primary.close {
        margin-right: -17px;
            background-color: #4895d1 !important;
    }
               button.close {
                padding: 9px 30px !important;   
                border: 0;
               -webkit-appearance: none;
    }
               .close{
                   margin-right: -429px !important;
        margin-top: -1132px !important;
               }
               .modal-footer {
        border-bottom: 0px !important;
                    border-top: 0px !important;
       
    }
           </style>


