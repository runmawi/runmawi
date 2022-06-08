/*
Template: Flicknexs - Responsive Bootstrap 4 Template
Author: iqonicthemes.in
Design and Developed by: iqonicthemes.in
NOTE: This file contains the styling for responsive Template.
*/

/*----------------------------------------------
Index Of Script
------------------------------------------------

:: Sticky Header Animation & Height
:: Back to Top
:: Header Menu Dropdown
:: Slick Slider
:: Owl Carousel
:: Page Loader
:: Mobile Menu Overlay
:: Equal Height of Tab Pane
:: Active Class for Pricing Table
:: Select 2 Dropdown
:: Video Popup
:: Flatpicker
:: Custom File Uploader

------------------------------------------------
Index Of Script
----------------------------------------------*/

(function (jQuery) {
	"use strict";
	jQuery(document).ready(function() {

		function activaTab(pill) {
			jQuery(pill).addClass('active show');
		}

		/*---------------------------------------------------------------------
			Sticky Header Animation & Height
		----------------------------------------------------------------------- */
		function headerHeight() {
			var height = jQuery("#main-header").height();
			jQuery('.iq-height').css('height', height + 'px');
		}
		jQuery(function() {
			var header = jQuery("#main-header"),
				yOffset = 0,
				triggerPoint = 80;

			headerHeight();

			jQuery(window).resize(headerHeight);
			jQuery(window).on('scroll', function() {

				yOffset = jQuery(window).scrollTop();

				if (yOffset >= triggerPoint) {
					header.addClass("menu-sticky animated slideInDown");
				} else {
					header.removeClass("menu-sticky animated slideInDown");
				}

			});
		});
		
		/*---------------------------------------------------------------------
			Back to Top
		---------------------------------------------------------------------*/
		var btn = $('#back-to-top');
		$(window).scroll(function () {
			if ($(window).scrollTop() > 50) {
				btn.addClass('show');
			} else {
				btn.removeClass('show');
			}
		});
		btn.on('click', function (e) {
			e.preventDefault();
			$('html, body').animate({ scrollTop: 0 }, '300');
		});

		/*---------------------------------------------------------------------
			Header Menu Dropdown
		---------------------------------------------------------------------*/
		jQuery('[data-toggle=more-toggle]').on('click', function() {
			jQuery(this).next().toggleClass('show');
		});

		jQuery(document).on('click', function(e) {
			let myTargetElement = e.target;
			let selector, mainElement;
			if (jQuery(myTargetElement).hasClass('search-toggle') || jQuery(myTargetElement).parent().hasClass('search-toggle') || jQuery(myTargetElement).parent().parent().hasClass('search-toggle')) {
				if (jQuery(myTargetElement).hasClass('search-toggle')) {
					selector = jQuery(myTargetElement).parent();
					mainElement = jQuery(myTargetElement);
				} else if (jQuery(myTargetElement).parent().hasClass('search-toggle')) {
					selector = jQuery(myTargetElement).parent().parent();
					mainElement = jQuery(myTargetElement).parent();
				} else if (jQuery(myTargetElement).parent().parent().hasClass('search-toggle')) {
					selector = jQuery(myTargetElement).parent().parent().parent();
					mainElement = jQuery(myTargetElement).parent().parent();
				}
				if (!mainElement.hasClass('active') && jQuery(".navbar-list li").find('.active')) {
					jQuery('.navbar-right li').removeClass('iq-show');
					jQuery('.navbar-right li .search-toggle').removeClass('active');
				}

				selector.toggleClass('iq-show');
				mainElement.toggleClass('active');

				e.preventDefault();
			} else if (jQuery(myTargetElement).is('.search-input')) {} else {
				jQuery('.navbar-right li').removeClass('iq-show');
				jQuery('.navbar-right li .search-toggle').removeClass('active');
			}
		});

		/*---------------------------------------------------------------------
			Slick Slider
		----------------------------------------------------------------------- */
		$('#home-slider').slick({
			autoplay: false,
			speed: 800,
			lazyLoad: 'progressive',
			arrows: true,
			dots: true,
			prevArrow: '<div class="slick-nav prev-arrow"><i></i><svg><use xlink:href="#circle"></svg></div>',
			nextArrow: '<div class="slick-nav next-arrow"><i></i><svg><use xlink:href="#circle"></svg></div>',
			responsive: [
				{
					breakpoint: 992,
					settings: {
						dots: true,
						arrows: false,
					}
				},
                
                
			]
		}).slickAnimation();
		$('.slick-nav').on('click touch', function (e) {

			e.preventDefault();

			var arrow = $(this);

			if (!arrow.hasClass('animate')) {
				arrow.addClass('animate');
				setTimeout(() => {
					arrow.removeClass('animate');
				}, 1600);
			}

		});
		jQuery('.favorites-slider').slick({
			dots: false,
			arrows: true,
			infinite: true,
			speed: 300,
			autoplay: false,
			slidesToShow: 5,
			slidesToScroll: 1,		
			// appendArrows: $('#sm-slick-arrow'),
			
			nextArrow: '<a href="#" class="slick-arrow slick-next"><i class= "fa fa-chevron-right"></i></a>',
			prevArrow: '<a href="#" class="slick-arrow slick-prev"><i class= "fa fa-chevron-left"></i></a>',
			responsive: [
			{
				breakpoint: 1200,
				settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				dots: true
				}
			},
			{
				breakpoint: 768,
				settings: {
				slidesToShow: 2,
				slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
				// arrows: false,
				slidesToShow: 1,
				slidesToScroll: 1
				}
			}
			]
		});

		jQuery('#top-ten-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '#top-ten-slider-nav',
			responsive: [
			{
				breakpoint: 992,
				settings: {
				asNavFor: false,
				arrows: true,
				nextArrow: '<button class="NextArrow"><i class="ri-arrow-right-s-line"></i></button>',
				prevArrow: '<button class="PreArrow"><i class="ri-arrow-left-s-line"></i></button>',
				}
			}
			]
		});
		jQuery('#top-ten-slider-nav').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '#top-ten-slider',
			dots: false,
			arrows: true,
			infinite: true,
			vertical:true,
			verticalSwiping: true,
			centerMode: false,
			nextArrow:'<button class="NextArrow"><i class="ri-arrow-down-s-line"></i></button>',
			prevArrow:'<button class="PreArrow"><i class="ri-arrow-up-s-line"></i></button>',
			focusOnSelect: true,
			responsive: [		    
				{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2,
				}
				},
				{
					breakpoint: 600,
					settings: {
						asNavFor: false,
					}
				},
			]
		});

		jQuery('#episodes-slider2').slick({
			dots: false,
			arrows: true,
			infinite: true,
			speed: 300,
			autoplay: false,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
			{
				breakpoint: 1024,
				settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				}
			},
			{
				breakpoint: 600,
				settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				}
			},
			{
				breakpoint: 480,
				settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				}
			}
			]
		});

		jQuery('#episodes-slider3').slick({
			dots: false,
			arrows: true,
			infinite: true,
			speed: 300,
			autoplay: false,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
			{
				breakpoint: 1024,
				settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				}
			},
			{
				breakpoint: 600,
				settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				}
			},
			{
				breakpoint: 480,
				settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				}
			}
			]
		});

		jQuery('#trending-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,		 
			arrows: false,
			fade: true,
			draggable:false,
			asNavFor: '#trending-slider-nav',	
		});
		jQuery('#trending-slider-nav').slick({
			slidesToShow: 5,
			slidesToScroll: 1,
			asNavFor: '#trending-slider',
			dots: false,
			arrows: true,
			nextArrow: '<a href="#" class="slick-arrow slick-next"><i class= "fa fa-chevron-right"></i></a>',
			prevArrow: '<a href="#" class="slick-arrow slick-prev"><i class= "fa fa-chevron-left"></i></a>',
			infinite: true,
			centerMode: true,
			centerPadding:0,
			focusOnSelect: true,
			responsive: [
			{
				breakpoint: 1024,
				settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				}
			},
			{
				breakpoint: 600,
				settings: {
				slidesToShow: 1,
				slidesToScroll: 1
				}
			}
			]
		});
		
		jQuery('#tvshows-slider').slick({
			centerMode: true,
			centerPadding: '200px',
			slidesToShow: 1,
			nextArrow: '<button class="NextArrow"><i class="ri-arrow-right-s-line"></i></button>',
			prevArrow: '<button class="PreArrow"><i class="ri-arrow-left-s-line"></i></button>',
			arrows:true,
			dots:false,
			responsive: [
				{
					breakpoint: 991,
					settings: {
						arrows: false,
						centerMode: true,
						centerPadding: '20px',
						slidesToShow: 1
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						centerMode: true,
						centerPadding: '20px',
						slidesToShow: 1
					}
				}
			]
		});

		/*---------------------------------------------------------------------
			Owl Carousel
		----------------------------------------------------------------------- */
		jQuery('.episodes-slider1').owlCarousel({
			loop:true,
			margin:20,
			nav:true,
			navText: ["<i class='ri-arrow-left-s-line'></i>", "<i class='ri-arrow-right-s-line'></i>"],
			dots:false,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:4
				}
			}
		});
		
		/*---------------------------------------------------------------------
			Page Loader
		----------------------------------------------------------------------- */
		jQuery("#load").fadeOut();
		jQuery("#loading").delay(0).fadeOut("slow");
		
		jQuery('.widget .fa.fa-angle-down, #main .fa.fa-angle-down').on('click', function () {
			jQuery(this).next('.children, .sub-menu').slideToggle();
		});

		/*---------------------------------------------------------------------
		Mobile Menu Overlay
		----------------------------------------------------------------------- */
		jQuery(document).on("click", function(event){
	    var $trigger = jQuery(".main-header .navbar");
	    if($trigger !== event.target && !$trigger.has(event.target).length){
			jQuery(".main-header .navbar-collapse").collapse('hide');
			jQuery('body').removeClass('nav-open');
	    }            
		});
		jQuery('.c-toggler').on("click", function(){
			jQuery('body').addClass('nav-open');
		}); 

		/*---------------------------------------------------------------------
		  Equal Height of Tab Pane
		-----------------------------------------------------------------------*/		
		jQuery('.trending-content').each(function () {			
			var highestBox = 0;			
			jQuery('.tab-pane', this).each(function () {				
				if (jQuery(this).height() > highestBox) {
					highestBox = jQuery(this).height();
				}
			});			 
			jQuery('.tab-pane', this).height(highestBox);
		}); 

		/*---------------------------------------------------------------------
	 		Active Class for Pricing Table
  	 	-----------------------------------------------------------------------*/
		jQuery("#my-table tr th").on("click", function (){
			jQuery('#my-table tr th').children().removeClass('active');
			jQuery(this).children().addClass('active');
			jQuery("#my-table td").each(function () {
				if (jQuery(this).hasClass('active')) {
					jQuery(this).removeClass('active')
				}
			});
			var col = jQuery(this).index();
			jQuery("#my-table tr td:nth-child(" + parseInt(col + 1) + ")").addClass('active');
		});
		
		/*---------------------------------------------------------------------
			Select 2 Dropdown
		-----------------------------------------------------------------------*/
		if (jQuery('select').hasClass('season-select')){
			jQuery('select').select2({
				theme: 'bootstrap4',
				allowClear: false,
				width: 'resolve'
			});
		}
		if (jQuery('select').hasClass('pro-dropdown')) {			
			jQuery('.pro-dropdown').select2({
				theme: 'bootstrap4',			
				minimumResultsForSearch: Infinity,			
				width: 'resolve'
			});	
			jQuery('#lang').select2({
				theme: 'bootstrap4',
				placeholder: 'Language Preference',
				allowClear: true,
				width: 'resolve'
			});
		}

		/*---------------------------------------------------------------------
			Video popup
		-----------------------------------------------------------------------*/
		jQuery('.video-open').magnificPopup({
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false,
			iframe: {
				markup: '<div class="mfp-iframe-scaler">' +
					'<div class="mfp-close"></div>' +
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
					'</div>',

				srcAction: 'iframe_src',
			}
		});

		/*---------------------------------------------------------------------
			Flatpicker
		-----------------------------------------------------------------------*/
		if (jQuery('.date-input').hasClass('basicFlatpickr')) {
			jQuery('.basicFlatpickr').flatpickr();
		}
		/*---------------------------------------------------------------------
			Custom File Uploader
		-----------------------------------------------------------------------*/
		jQuery(".file-upload").on("change", function () {
			! function (e) {
				if (e.files && e.files[0]) {
					var t = new FileReader;
					t.onload = function (e) {
						jQuery(".profile-pic").attr("src", e.target.result)
					}, t.readAsDataURL(e.files[0])
				}
			}(this)
		}), jQuery(".upload-button").on("click", function () {
			jQuery(".file-upload").click();
		});
		// new WOW().init();
		// var swiper = new Swiper('.swiper-container', {
		// 	effect: 'fade',
		// 	grabCursor: true,
		// 	centeredSlides: false,
		// 	slidesPerView: 'auto',
		// 	freeMode: true,
		// 	loop: true,
		// 	parallax: true,
		// 	on: {
		// 		slideChangeTransitionEnd: function () {
		// 			$('.aos-slide').show(0);
		// 			AOS.init();
		// 		},
		// 		slideChangeTransitionStart: function () {
		// 			$('.aos-slide').hide(0);
		// 			$('.aos-slide').removeClass('aos-init').removeClass('aos-animate');
					
		// 		},
		// 	},
		// 	pagination: {
		// 		el: '.swiper-pagination',
		// 	},
		// 	navigation: {
		// 		nextEl: '.swiper-button-next',
		// 		prevEl: '.swiper-button-prev',
		// 	},
		// });
	
		// AOS.init();	

	});
})(jQuery);
//lazzy loader//
(function($, window, document, undefined) {
    var $window = $(window);

    $.fn.lazyload = function(options) {
        var elements = this;
        var $container;
        var settings = {
            threshold       : 0,
            failure_limit   : 0,
            event           : "scroll",
            effect          : "show",
            container       : window,
            data_attribute  : "original",
            skip_invisible  : true,
            appear          : null,
            load            : null,
            placeholder     : "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
        };

        function update() {
            var counter = 0;

            elements.each(function() {
                var $this = $(this);
                if (settings.skip_invisible && !$this.is(":visible")) {
                    return;
                }
                if ($.abovethetop(this, settings) ||
                    $.leftofbegin(this, settings)) {
                        /* Nothing. */
                } else if (!$.belowthefold(this, settings) &&
                    !$.rightoffold(this, settings)) {
                        $this.trigger("appear");
                        /* if we found an image we'll load, reset the counter */
                        counter = 0;
                } else {
                    if (++counter > settings.failure_limit) {
                        return false;
                    }
                }
            });

        }

        if(options) {
            /* Maintain BC for a couple of versions. */
            if (undefined !== options.failurelimit) {
                options.failure_limit = options.failurelimit;
                delete options.failurelimit;
            }
            if (undefined !== options.effectspeed) {
                options.effect_speed = options.effectspeed;
                delete options.effectspeed;
            }

            $.extend(settings, options);
        }

        /* Cache container as jQuery as object. */
        $container = (settings.container === undefined ||
                      settings.container === window) ? $window : $(settings.container);

        /* Fire one scroll event per scroll. Not one scroll event per image. */
        if (0 === settings.event.indexOf("scroll")) {
            $container.bind(settings.event, function() {
                return update();
            });
        }

        this.each(function() {
            var self = this;
            var $self = $(self);

            self.loaded = false;

            /* If no src attribute given use data:uri. */
            if ($self.attr("src") === undefined || $self.attr("src") === false) {
                if ($self.is("img")) {
                    $self.attr("src", settings.placeholder);
                }
            }

            /* When appear is triggered load original image. */
            $self.one("appear", function() {
                if (!this.loaded) {
                    if (settings.appear) {
                        var elements_left = elements.length;
                        settings.appear.call(self, elements_left, settings);
                    }
                    $("<img />")
                        .bind("load", function() {

                            var original = $self.attr("data-" + settings.data_attribute);
                            $self.hide();
                            if ($self.is("img")) {
                                $self.attr("src", original);
                            } else {
                                $self.css("background-image", "url('" + original + "')");
                            }
                            $self[settings.effect](settings.effect_speed);

                            self.loaded = true;

                            /* Remove image from array so it is not looped next time. */
                            var temp = $.grep(elements, function(element) {
                                return !element.loaded;
                            });
                            elements = $(temp);

                            if (settings.load) {
                                var elements_left = elements.length;
                                settings.load.call(self, elements_left, settings);
                            }
                        })
                        .attr("src", $self.attr("data-" + settings.data_attribute));
                }
            });

            /* When wanted event is triggered load original image */
            /* by triggering appear.                              */
            if (0 !== settings.event.indexOf("scroll")) {
                $self.bind(settings.event, function() {
                    if (!self.loaded) {
                        $self.trigger("appear");
                    }
                });
            }
        });

        /* Check if something appears when window is resized. */
        $window.bind("resize", function() {
            update();
        });

        /* With IOS5 force loading images when navigating with back button. */
        /* Non optimal workaround. */
        if ((/(?:iphone|ipod|ipad).*os 5/gi).test(navigator.appVersion)) {
            $window.bind("pageshow", function(event) {
                if (event.originalEvent && event.originalEvent.persisted) {
                    elements.each(function() {
                        $(this).trigger("appear");
                    });
                }
            });
        }

        /* Force initial check if images should appear. */
        $(document).ready(function() {
            update();
        });

        return this;
    };

    /* Convenience methods in jQuery namespace.           */
    /* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

    $.belowthefold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = (window.innerHeight ? window.innerHeight : $window.height()) + $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top + $(settings.container).height();
        }

        return fold <= $(element).offset().top - settings.threshold;
    };

    $.rightoffold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left + $(settings.container).width();
        }

        return fold <= $(element).offset().left - settings.threshold;
    };

    $.abovethetop = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top;
        }

        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };

    $.leftofbegin = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left;
        }

        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.inviewport = function(element, settings) {
         return !$.rightoffold(element, settings) && !$.leftofbegin(element, settings) &&
                !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
     };

    /* Custom selectors for your convenience.   */
    /* Use as $("img:below-the-fold").something() or */
    /* $("img").filter(":below-the-fold").something() which is faster */

    $.extend($.expr[":"], {
        "below-the-fold" : function(a) { return $.belowthefold(a, {threshold : 0}); },
        "above-the-top"  : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-screen": function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-screen" : function(a) { return !$.rightoffold(a, {threshold : 0}); },
        "in-viewport"    : function(a) { return $.inviewport(a, {threshold : 0}); },
        /* Maintain BC for couple of versions. */
        "above-the-fold" : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-fold"  : function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-fold"   : function(a) { return !$.rightoffold(a, {threshold : 0}); }
    });

})(jQuery, window, document);

document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages;    

  if ("IntersectionObserver" in window) {
    lazyloadImages = document.querySelectorAll(".lazy");
    var imageObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          var image = entry.target;
          image.src = image.dataset.src;
          image.classList.remove("lazy");
          imageObserver.unobserve(image);
        }
      });
    });

    lazyloadImages.forEach(function(image) {
      imageObserver.observe(image);
    });
  } else {  
    var lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll(".lazy");
    
    function lazyload () {
      if(lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }    

      lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
      }, 20);
    }

    document.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationChange", lazyload);
  }
})
