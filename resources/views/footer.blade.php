	<footer>
		<div class="container">

			<div class="row">
                
				<div class="col-md-2 col-xs-12 text-center-m padding-top-20">
					<a href="https://www.facebook.com/<?php echo FacebookId();?>" target="_blank" class="facebook social-link"><i class="fa fa-facebook"></i></a>
					<a href="https://twitter.com/<?php echo TwiterId();?>" target="_blank" class="twitter social-link"><i class="fa fa-twitter"></i></a>
<!--                    <a href="<php echo FacebookId();?>" target="_blank" class="linkedin social-link"><i class="fa fa-linkedin"></i></a>-->
					<a href="<?php echo GoogleId();?>" target="_blank" class="google social-link"><i class="fa fa-google-plus"></i></a>
<!--					<a href="http://youtube.com/" target="_blank" class="youtube social-link"><i class="fa fa-youtube"></i></a>-->
					<div class="clear"></div>   
				</div>

		
				<div class="col-md-10 col-xs-6 footer-links-height  padding-top-40">
					<!--<h4>Links</h4>-->
					<ul>
                        
						<?php 
                        
                        $pages = App\Page::all();
                        
                        foreach($pages as $page): ?>
                        <?php if ( $page->slug != 'promotion' ){ ?>
							<li><a href="<?php echo URL::to('page'); ?><?= '/' . $page->slug ?>"><?= __($page->title) ?></a></li>
                        <?php } ?>
						<?php endforeach; ?>
					</ul>
				</div>
                	
			</div>
              <div class="row">
                  <div class="col-md-3 col-xs-12 padding-top-20" >
                      <p class="copyright text-left">Copyright ©  <?= date('Y'); ?> by Flicknexs</p>
              </div>
                  </div>
		<!--	<hr />  -->
		

		</div>
	</footer>
    <script src="<?= THEME_URL . '/assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?= THEME_URL . '/assets/js/moment.min.js'; ?>"></script>
	<script type="text/javascript" src="<?= THEME_URL . '/assets/js/noty/jquery.noty.js'; ?>"></script>
	<script type="text/javascript" src="<?= THEME_URL . '/assets/js/noty/themes/default.js'; ?>"></script>
	<script type="text/javascript" src="<?= THEME_URL . '/assets/js/noty/layouts/top.js'; ?>"></script>

	<script type="text/javascript">
	  
	  $('document').ready(function(){

		    $('.dropdown').hover(function(){
		        $(this).addClass('open');
		    }, function(){
		        $(this).removeClass('open');
		    });

	    <?php if(Session::get('note') != '' && Session::get('note_type') != ''): ?>
	        var n = noty({text: '<?= str_replace("'", "\\'", Session::get("note")) ?>', layout: 'top', type: '<?= Session::get("note_type") ?>', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:1600 });
	        <?php Session::forget('note');
	              Session::forget('note_type');
	        ?>
	    <?php endif; ?>

	    $('#nav-toggle').click(function(){
	    	$(this).toggleClass('active');
	    	$('.navbar-collapse').toggle();
	    	$('body').toggleClass('nav-open');
	    });

	    $('#mobile-subnav').click(function(){
	    	if($('.second-nav .navbar-left').css('display') == 'block'){
	    		$('.second-nav .navbar-left').slideUp(function(){
	    			$(this).addClass('not-visible');
	    		});
	    		$(this).html('<i class="fa fa-bars"></i> Open Submenu');
	    	} else {
	    		$('.second-nav .navbar-left').slideDown(function(){
	    			$(this).removeClass('not-visible');
	    		});
	    		$(this).html('<i class="fa fa-close"></i> Close Submenu');
	    	}
	    	
	    });

	  });


	  /********** LOGIN MODAL FUNCTIONALITY **********/

	  var loginSignupModal = $('<div class="modal fade" id="loginSignupModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="myModalLabel">Login Below</h4></div><div class="modal-body"></div></div></div></div>');

		$(document).ready(function(){
			
			// Load the Modal Window for login signup when they are clicked
			$('.login-desktop a').click(function(e){
				e.preventDefault();
				$('body').prepend(loginSignupModal);
				$('#loginSignupModal .modal-body').load($(this).attr('href') + '?redirect=' + document.URL + ' .form-signin', function(){
					$('#loginSignupModal').show(200, function(){
						setTimeout(function() { $('#email').focus() }, 300);						
					});
					$('#loginSignupModal').modal();					
				});
				// Be sure to remove the modal from the DOM after it is closed
				$('#loginSignupModal').on('hidden.bs.modal', function (e) {
			    	$('#loginSignupModal').remove();
				});
			});
		});
		/********** END LOGIN MODAL FUNCTIONALITY **********/
	</script>

	<?php if(isset($settings->google_tracking_id) && $settings->google_tracking_id != ''): ?>
	<?php endif; ?>

<!--	<script><= ThemeHelper::getThemeSetting(@$theme_settings->custom_js, '') ?></script>-->

<script>
  $('.vjs-default-skin').bind("contextmenu",function(e){
            return false;
    });
</script>
 <script> 
 $(document).ready(function() { 
            $(".play-video").hover(function() { 
                $(this).css("display", "block"); 
            }, function() { 
             //$(this).css("display", "none"); 
                 $(".play-video").load(); 
            }); 
            
          $( ".play-video" ).mouseleave(function() {
            $(this).load(); 
        });
        }); 
  

       
     
        $( ".theme_color" ).on("click", function() { 
         if($(this).is(":checked")) {
            $(this).val(1);
            $( "body" ).addClass( "dark" );
            $( "body" ).css( "background" ,"#000"); 
            $( "h4" ).css( "color" ,"#fff"); 
            $( "body" ).css( "color" ,"#fff"); 
            $( ".change" ).text( "ON" ); 
            sessionStorage.setItem("theme","dark");
         } else {
			 $(this).val(0);
             $( "body" ).removeClass( "dark" );
             $( "body" ).addClass( "light" );
             $( "body" ).css( "background" ,"#fff"); 
             $( "h4" ).css( "color" ,"#000"); 
             $( "body" ).css( "color" ,"#000"); 
             sessionStorage.setItem("theme","light");
          }

        });
     
        $( ".theme_color" ).on("click", function() { 
         if($(this).is(":checked")) {
            $(this).val(1);
            $( "body" ).addClass( "dark" );
            $( "body" ).css( "background" ,'<?=GetDarkBg();?>'); 
            $( "footer" ).css( "background" ,'<?=GetDarkBg();?>'); 
            $( ".navbar-default" ).css( "background" ,'<?=GetDarkBg();?>'); 
            $( "h4" ).css( "color" ,"#fff"); 
            $( "body" ).css( "color" ,"#fff"); 
            $( ".change" ).text( "ON" ); 
            localStorage.setItem("theme","dark");
         } else {
			 $(this).val(0);
             $( "body" ).removeClass( "dark" );
             $( "body" ).addClass( "light" );
             $( "body" ).css( "background" ,'<?=GetLightBg();?>'); 
             $( "footer" ).css( "background" ,'<?=GetLightBg();?>'); 
             $( ".navbar-default" ).css( "background" ,'<?=GetLightBg();?>'); 
             $( "h4" ).css( "color" ,"#000"); 
             $( "body" ).css( "color" ,"#000"); 
              localStorage.setItem("theme","light");
          }

        });
     
    
     
    </script> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>