<section id="iq-favorites">
    <div class="">
        <div class="row">
            <div class="col-sm-12">
                <div class="favorites-contens">
                <ul class="favorites-slider list-inline row p-0 mb-0">
                        <?php 
                        if(isset($Related_videos)) :
                            foreach($Related_videos as $related_video): ?>

                            <li class="slide-item">
                                <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">	
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$related_video->image;  ?>" class="img-fluid w-100" alt="">
                                        </div>
                                        <div class="block-description">
                                            <div class="hover-buttons">
                                                <a  href="<?php echo URL::to('live/'.$related_video->slug ) ?>">		
                                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/play.svg';  ?>"> 
                                                </a>
                                            </div>
                                            </div>
                                    </div>

                                    

                                     <div class="">
                                        <div class="movie-time  align-items-center d-flex justify-content-between">
                                                <div>  <h6><?php  echo (strlen($related_video->title) > 15) ? substr($related_video->title,0,15).'...' : $related_video->title; ?></h6>
                                                <div class="badge badge-secondary p-1 mr-2"><?php echo $related_video->age_restrict.' '.'+' ?></div>
                                        </div>
                                           <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $related_video->duration); ?></span>
                                     </div>
                              </a>
                            </li>
                            <?php endforeach;  endif; ?>
                        </ul>
                    </div>
                  </div>
               </div>
            </div>

            <style>
                .favorites-slider .slick-arrow, #trending-slider-nav .slick-arrow {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 30px;
                text-align: center;
                opacity: 1;
                z-index: 9;
                top: -28px;
               
                margin: 0 0 0 20px;
                line-height: 5px;
                box-shadow: 0px 9px 19px #01041b0d;
                font-size: 0;
                transform: none;
                color: var(--iq-white);
                -webkit-transition: all 0.4s ease-in-out 0s;
                -moz-transition: all 0.4s ease-in-out 0s;
                transition: all 0.4s ease-in-out 0s;
            }
            overflow-hidden {
                margin-top: 70px;
                overflow: hidden;
                           min-height: 450px !important;
            }

            li.slide-item .block-images{
                margin-bottom: 2rem !important;
            }
            
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