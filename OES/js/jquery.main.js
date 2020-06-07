$(document).ready(function() {

	"use strict";

	$("#contactForm").validator().on("submit", function (event) {

		"use strict";

		if (event.isDefaultPrevented()) {
			// handle the invalid form...
			formError();
			submitMSG(false, "Please Follow Error Messages and Complete as Required");
		} else {
			// everything looks good!
			event.preventDefault();
			submitForm();
		}
	});


	function submitForm(){
		
		"use strict";

		// Initiate Variables With Form Content
		var name = $("#name").val();
		var email = $("#email").val();
		var phone = $("#phone").val();

		$.ajax({
			type: "POST",
			url: "php/form-process.php",
			data: "name=" + name + "&email=" + email + "&phone=" + phone,
			success : function(text){
				if (text == "success"){
					formSuccess();
				} else {
					formError();
					submitMSG(false,text);
				}
			}
		});
	}

	function formSuccess(){
		
		"use strict";

		$("#contactForm")[0].reset();
		submitMSG(true, "Thank you for your submission :)")
	}

	function formError(){
		
		"use strict";

		$("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass();
		});
	}

	function submitMSG(valid, msg){
		
		"use strict";

		if(valid){
			var msgClasses = "success form-message";
		} else {
			var msgClasses = "error form-message";
		}
		$("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
	}

	$("#contactForm2").validator().on("submit", function (event) {
		
		"use strict";

		if (event.isDefaultPrevented()) {
			// handle the invalid form...
			formError2();
			submitMSG2(false, "Please Follow Error Messages and Complete as Required");
		} else {
			// everything looks good!
			event.preventDefault();
			submitForm2();
		}
	});

	function submitForm2(){
		
		"use strict";

		// Initiate Variables With Form Content
		var name = $("#name2").val();
		var email = $("#email2").val();
		var phone = $("#phone2").val();
		var plan = $("#choose_plan").val();

		$.ajax({
			type: "POST",
			url: "php/form-process2.php",
			data: "name=" + name + "&email=" + email + "&phone=" + phone + "&plan=" + plan,
			success : function(text){
				if (text == "success"){
					formSuccess2();
				} else {
					formError2();
					submitMSG2(false,text);
				}
			}
		});
	}

	function formSuccess2(){
		
		"use strict";

		$("#contactForm2")[0].reset();
		submitMSG2(true, "Thank you for your submission :)")
	}

	function formError2(){
		
		"use strict";

		$("#contactForm2").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass();
		});
	}

	function submitMSG2(valid, msg){
		
		"use strict";

		if(valid){
			var msgClasses = "success form-message";
		} else {
			var msgClasses = "error form-message";
		}
		$("#msgSubmit2").removeClass().addClass(msgClasses).text(msg);
	}

	initbackTop();
	function initbackTop() {
		
		"use strict";

		var jQuerybackToTop = jQuery("#back-top");
		jQuery(window).on('scroll', function() {
			if (jQuery(this).scrollTop() > 100) {
				jQuerybackToTop.addClass('show');
			} else {
				jQuerybackToTop.removeClass('show');
			}
		});
		jQuerybackToTop.on('click', function(e) {
			jQuery("html, body").stop().animate({scrollTop: 0}, 1500, 'easeInOutExpo');
		});
	}

	initStickyHeader();
	function initStickyHeader() {
		
		"use strict";

		var win = jQuery(window),
			stickyClass = 'sticky';

		jQuery('#header').each(function() {
			var header = jQuery(this);
			var headerOffset = header.offset().top || 0;
			var flag = true;

			jQuery(this).css('height' , jQuery(this).innerHeight());

			function scrollHandler() {
				if (win.scrollTop() > headerOffset) {
					if (flag){
						flag = false;
						header.addClass(stickyClass);
					}
				} else {
					if (!flag) {
						flag = true;
						header.removeClass(stickyClass);
					}
				}
			}

			scrollHandler();
			win.on('scroll resize orientationchange', scrollHandler);
		});
	}
	initAddClass();
	function initAddClass() {
		
		"use strict";

		jQuery('.nav-opener').on( "click", function(e){
			e.preventDefault();
			jQuery("body").toggleClass("nav-active");
		});
		jQuery('#nav .smooth').on( "click", function(){
			if (jQuery("body").hasClass("nav-active")) {
				setTimeout(function() { 
				jQuery("body").removeClass("nav-active");}, 800);
			}
		});
	}
	
	$.scrollIt({
		topOffset: -75,
		scrollTime: 1500,
		easing: 'easeInOutExpo'
	});

	initSlickSlider();
	// Slick Slider init
	function initSlickSlider() {

		jQuery('.main-slider').slick({
			dots: true,
			speed: 800,
			arrows: true,
			infinite: true,
			autoplay: true,
			slidesToShow: 1,
			autoplaySpeed: 2000,
			adaptiveHeight: true
		});
	}

	initLightbox();
	// modal popup init
	function initLightbox() {
		
		"use strict";

		jQuery('a.lightbox, a[rel*="lightbox"]').fancybox({
			padding: 0
		});
	}

	initMarquee();
	// running line init
	function initMarquee() {
		"use strict";

		jQuery('.line-box').marquee({
			line: '.line',
			animSpeed: 50
		});
	}

	initStyleChanger();
	// style changer
	function initStyleChanger() {
		"use strict";

		var element = jQuery('#style-changer');

		if(element) {
			$.ajax({
				url: element.attr('data-src'),
				type: 'get',
				dataType: 'text',
				success: function(data) {
					var newContent = jQuery('<div>', {
						html: data
					});

					newContent.appendTo(element);
				}
			});
		}
	}

	initResponsiveClasses();
	// *** Responsive Classes *** //
	function initResponsiveClasses() {
		"use strict";

		var $body = $( "body" );
		var jRes = jRespond([
			{
				label: "smallest",
				enter: 0,
				exit: 479
			},{
				label: "handheld",
				enter: 480,
				exit: 767
			},{
				label: "tablet",
				enter: 768,
				exit: 991
			},{
				label: "laptop",
				enter: 992,
				exit: 1199
			},{
				label: "desktop",
				enter: 1200,
				exit: 10000
			}
		]);
		jRes.addFunc([
			{
				breakpoint: "desktop",
				enter: function() { $body.addClass( "device-lg" ); },
				exit: function() { $body.removeClass( "device-lg" ); }
			},{
				breakpoint: "laptop",
				enter: function() { $body.addClass( "device-md" ); },
				exit: function() { $body.removeClass( "device-md" ); }
			},{
				breakpoint: "tablet",
				enter: function() { $body.addClass( "device-sm" ); },
				exit: function() { $body.removeClass( "device-sm" ); }
			},{
				breakpoint: "handheld",
				enter: function() { $body.addClass( "device-xs" ); },
				exit: function() { $body.removeClass( "device-xs" ); }
			},{
				breakpoint: "smallest",
				enter: function() { $body.addClass( "device-xxs" ); },
				exit: function() { $body.removeClass( "device-xxs" ); }
			}
		]);
	}

	initParallaxStellar();
	function initParallaxStellar() {
		"use strict";

		var $body = $( "body" );
		if ( $body.hasClass( "device-lg" ) || $body.hasClass( "device-md" )) {
			$.stellar({
				horizontalScrolling: false, // don't change this option
				// verticalScrolling: false,
				verticalOffset: 0,
		    	responsive: true, // false
			});
		}
	}

}); 
$( window ).on( "load" , function() {
	"use strict";

	$( "#loader" ).delay( 600 ).fadeOut( 300 );
});
$( window ).on( "resize" , function() {

	initParallaxStellar();
	function initParallaxStellar() {
		"use strict";

		var $body = $( "body" );
		if ( $body.hasClass( "device-lg" ) || $body.hasClass( "device-md" )) {
			$.stellar({
				horizontalScrolling: false, // don't change this option
				// verticalScrolling: false,
				verticalOffset: 0,
		    	responsive: true, // false
			});
		}
	}

	initResponsiveClasses();
	// *** Responsive Classes *** //
	function initResponsiveClasses() {
		"use strict";

		var $body = $( "body" );
		var jRes = jRespond([
			{
				label: "smallest",
				enter: 0,
				exit: 479
			},{
				label: "handheld",
				enter: 480,
				exit: 767
			},{
				label: "tablet",
				enter: 768,
				exit: 991
			},{
				label: "laptop",
				enter: 992,
				exit: 1199
			},{
				label: "desktop",
				enter: 1200,
				exit: 10000
			}
		]);
		jRes.addFunc([
			{
				breakpoint: "desktop",
				enter: function() { $body.addClass( "device-lg" ); },
				exit: function() { $body.removeClass( "device-lg" ); }
			},{
				breakpoint: "laptop",
				enter: function() { $body.addClass( "device-md" ); },
				exit: function() { $body.removeClass( "device-md" ); }
			},{
				breakpoint: "tablet",
				enter: function() { $body.addClass( "device-sm" ); },
				exit: function() { $body.removeClass( "device-sm" ); }
			},{
				breakpoint: "handheld",
				enter: function() { $body.addClass( "device-xs" ); },
				exit: function() { $body.removeClass( "device-xs" ); }
			},{
				breakpoint: "smallest",
				enter: function() { $body.addClass( "device-xxs" ); },
				exit: function() { $body.removeClass( "device-xxs" ); }
			}
		]);
	}
});