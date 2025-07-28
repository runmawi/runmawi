<footer class="mb-0">
         <div class="container-fluid">
            <div class="block-space">
               <div class="row justify-content-between">
                   <div class="col-lg-4 col-md-4 col-sm-12 r-mt-15">
                       <!-- <a aria-label="apps" class="navbar-brand" href="<?php //echo URL::to('home') ?>"> <img alt="apps-logo" src="<?php // URL::to('/').'/public/uploads/settings/'. $settings->logo ; ?>" class="" alt="Flicknexs"> </a> -->
                       <?php if($theme_mode == "light" && !empty(@$theme->light_mode_logo)){  ?>
                     <a class="navbar-brand mb-0" href="<?php echo URL::to('home') ?>"> <img alt="logo" src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->light_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                     <?php }elseif($theme_mode != "light" && !empty(@$theme->dark_mode_logo)){ ?> 
                     <a class="navbar-brand mb-0" href="<?php echo URL::to('home') ?>"> <img alt="logo" src="<?php echo URL::to('/').'/public/uploads/settings/'. $theme->dark_mode_logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                     <?php }else { ?> 
                     <a class="navbar-brand mb-0" href="<?php echo URL::to('home') ?>"> <img alt="logo" src="<?php echo URL::to('/').'/public/uploads/settings/'. $settings->logo; ?>" class="c-logo" alt="<?php echo $settings->website_name ; ?>"> </a>
                     <?php } ?>
                     <div class="d-flex mt-2">

                      <?php if(!empty($settings->facebook_page_id)){?>
                        <a aria-label="facebook" href="https://www.facebook.com/<?php echo FacebookId();?>" target="_blank"  class="s-icon">
                          <i class="ri-facebook-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->skype_page_id)){?>
                        <a aria-label="skype" href="https://www.skype.com/en/<?php echo SkypeId();?>" target="_blank"  class="s-icon">
                          <i class="ri-skype-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->twitter_page_id)){?>
                        <a aria-label="tw" href="https://twitter.com/<?php echo TwiterId();?>" target="_blank"  class="s-icon">
                          <i class="ri-twitter-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->instagram_page_id)){?>
                        <a aria-label="ins" href="https://www.instagram.com/<?php echo InstagramId();?>" target="_blank"  class="s-icon">
                          <i class="ri-instagram-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->linkedin_page_id)){?>
                        <a aria-label="link" href="https://www.linkedin.com/<?php echo linkedinId();?>" target="_blank"  class="s-icon">
                          <i class="ri-linkedin-fill"></i>
                          </a>
                      <?php } ?>


                      <?php if(!empty($settings->whatsapp_page_id)){?>
                        <a aria-label="whatsapp" href="https://www.whatsapp.com/<?php echo YoutubeId();?>" target="_blank"  class="s-icon">
                          <i class="ri-whatsapp-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->youtube_page_id)){?>
                        <a aria-label="youtube" href="https://www.youtube.com/<?php echo YoutubeId();?>" target="_blank"  class="s-icon">
                          <i class="ri-youtube-fill"></i>
                          </a>
                      <?php } ?>

                      <?php if(!empty($settings->google_page_id)){?>
                        <a aria-label="google" href="https://www.google.com/<?php echo GoogleId();?>" target="_blank" class="s-icon">
                          <i class="fa fa-google-plus"></i>
                          </a>
                      <?php } ?>

                     </div>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-12 p-0">
                     <ul class="f-link list-unstyled mb-0">

                        <?php
                        if(1 == 2){
                            $language = App\Language::get();
                            foreach($language as $key => $lan){
                              $language_href = 'language/'.$lan->id.'/'.$lan->name;
                        ?>
                        <li><a href="<?php echo URL::to($language_href) ?>"><?php echo $lan->name; ?> </a></li>

                        <?php }}?>

                        <?php $column2_footer = App\FooterLink::where('column_position',2)->orderBy('order')->get();  
                          foreach ($column2_footer as $key => $footer_link){ ?>

                            <li><a href="<?php echo URL::to('/'.$footer_link->link) ?>">
                                    <?php echo  $footer_link->name ; ?>
                                </a>
                            </li>
                        
                        <?php  } ?>


                     <!--   <li><a href="<?php echo URL::to('/contact-us/') ;?>">Contact us</a></li> -->
                     </ul>


                  </div>                  
                 
                      
                    
				<!-- </div> -->
                  <div class="col-lg-2 col-md-4 p-0">
                      <ul class="f-link list-unstyled mb-0">

                        <?php 

                        if( Auth::user() != null && Auth::user()->package == "Business" ):

                           $column3_footer = App\FooterLink::where('column_position',3)->orderBy('order')->get(); 

                        else:
                        
                          $column3_footer = App\FooterLink::where('column_position',3)->whereNotIn('link', ['/cpp/signup','/advertiser/register','/channel/register'])
                                            ->orderBy('order')->get();  
                        endif;

                        foreach ($column3_footer as $key => $footer_link){ ?>
                          <li><a href="<?php echo URL::to('/'.$footer_link->link) ?>">
                                  <?php echo  $footer_link->name ; ?>
                              </a>
                          </li>
                        <?php  } ?>
                         
				              </ul>
			            </div>
                          
                  <?php $app_settings = App\AppSetting::where('id','=',1)->first();  ?>     
                         
                   <div class="col-lg-3 col-md-2 p-0">
                       <div >
                       <?php if(!empty($app_settings->android_url)){ ?> 
                       <img alt="apps-logo" class="" height="80" width="140" src="<?php echo  URL::to('/assets/img/apps1.png')?>" style="margin-top:-20px;">
                        <?php } ?>
                       <?php if(!empty($app_settings->ios_url)){ ?> 
                       <img alt="apps-logo" class="" height="80" width="140" src="<?php echo  URL::to('/assets/img/apps.png')?>" style="margin-top:-20px;">
                        <?php } ?>
                       <?php if(!empty($app_settings->android_tv)){ ?> 
                       <img alt="apps-logo" class="" height="100" width="150" src="<?php echo  URL::to('/assets/img/and.png')?>" style="margin-top:-20px;">
                        <?php } ?>
                   </div></div>
                  
                   </div>
               </div>
              <p class="mb-0  font-size-14 text-body bb p-2"><?php echo $settings->website_name ; ?> - <?php echo Carbon::now()->year ; ?> All Rights Reserved</p>
            </div>
         
      </footer>