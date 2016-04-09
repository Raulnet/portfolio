$(document).ready(function() {

	/* ----- Vaariables and user agent check ----- */
	isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
	isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);


	/* ----- Function to prevent Default Events ----- */
	function pde(e){
		if(e.preventDefault)
			e.preventDefault();
		else
			e.returnValue = false;
	}


	/* ----- Safari class if is Safari ----- */
	if (isSafari) {
		$('html').addClass('is-safari');
	} else {
		$('html').removeClass('is-safari');
	};


	/* ----- Darken the revealed menu on mobile ----- */
	$('.navbar-toggle').on('click', function(){
		if (!$('.navbar-collapse').hasClass("in")) {
			$('.navbar').addClass('darken-menu');
		} else if ($('.navbar-collapse').hasClass("in")) {
			$('.navbar').removeClass('darken-menu');
		}
	});


	/* ----- Parallax effect on welcome screen ----- */
	$(document).scroll(function () {
		var position = $(document).scrollTop();

		if (!isMobile) {
			$(".welcome-section .content-wrapper").css({
				opacity : (1 - position/500)
			});
		};
	});


	/* ----- Collapse navigation on click (Bootstrap 3 is missing it) ----- */
	$('.nav a').on('click', function () {
		$('#my-nav').removeClass('in').addClass('collapse');
	});


	/* ----- Scroll down from Welcome screen ----- */
	$('.welcome-section .scroll-more').click(function(evt) {
		var place = $('body').children('section').eq(1);
		// var offsetTop = $('.navbar').outerHeight();
		$('html, body').animate({scrollTop: $(place).offset().top}, 1200, 'easeInOutCubic');
		pde(evt);
	});


	/* ----- Nice scroll to Sections ----- */
	$('.navbar-nav li a').click(function(evt){
		var place = $(this).attr('href');
		var off = $(place).offset().top;
		$('html, body').animate({
			scrollTop: off
		}, 1200, 'easeInOutCubic');
		pde(evt);
	});

	
	/* ----- Minimize and darken the Menu Bar ----- */
	$('body').waypoint(function(direction) {
		$('.navbar').toggleClass('minified dark-menu');
	}, { offset: '-200px' });


	/* ----- Testimonials rotator ----- */
	$( '#testimonials-rotator' ).cbpQTRotator();


	/* ----- Text Rotator ----- */
	$(".rotating-words").textrotator({
		animation: "dissolve",
		separator: ",",
		speed: 3000
	});


	/* ----- Clients Carousel ----- */
	$('.carousel').slick({
		infinite: true,
		slidesToShow: 4,
		slidesToScroll: 1,
		slide: 'div',
		dots: true,
		easing: 'easeInOutQuart',
		speed: 800,
		responsive: [{
			breakpoint: 1200,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				easing: 'easeInOutQuart',
				speed: 800,
			}
		},{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				easing: 'easeInOutQuart',
				speed: 800,
			}
		},{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: true,
				easing: 'easeInOutQuart',
				speed: 800,
			}
		}]
	});


	/* ----- Show "Back to Top" button ----- */
	$(document).scroll(function () {
		var position = $(document).scrollTop();
		var headerHeight = $('#welcome').outerHeight();
		if (position >= headerHeight - 100){
			$('.scrolltotop').addClass('show-to-top');
		} else {
			$('.scrolltotop').removeClass('show-to-top');
		}
	});

	// Scroll on Top
	$('.scrolltotop, .navbar-brand').click(function(e) {
		$('html, body').animate({scrollTop: '0'}, 1200, 'easeInOutCubic');
		pde(e);
	});


	/* ----- Filterable Portfolio effect ----- */
	$('ul.og-grid li').append('<div class="hidden-overlay"></div>');
	$('ul.filter-list li').click(function() {
		$(this).css('outline','none');

		$('ul.filter-list .active').removeClass('active');
		$(this).addClass('active');
		
		var filterVal = $(this).attr('data-id');
				
		if(filterVal == 'all') {
			$('ul.og-grid li.hidden-item').addClass('visible-item');
			$('ul.og-grid li.hidden-item').removeClass('hidden-item').animate({opacity: 1}, 600);
		} else {
			
			$('ul.og-grid li').each(function() {

				var attrArr = $(this).attr('data-id').split(' ');
				var found = $.inArray(filterVal, attrArr);

				if(found == -1) {
					$(this).animate({opacity: 0.2}, 600, function(){
						$(this).removeClass('visible-item').addClass('hidden-item');
					});
				} else {
					$(this).addClass('visible-item');
					$(this).removeClass('hidden-item').animate({opacity: 1}, 600);
				}
			});
		}
		
		return false;
	});



	

	/* ----- Initialize Portfolio Grid ----- */
	initializeGrid();


	/* ----- Initializa Parallax effect ----- */
	parallaxed('.parallax');


});



/* ----- Functions ----- */

function initializeGrid() {
	Grid.init();
}

function parallaxed(obj) {

	$(window).bind("load resize scroll",function() {
		$(obj).each(function(){
			var windowHeight = $(window).height();
			var windowWidth = $(window).width();
			var scrollPos = $(window).scrollTop();
			var objectPos = $(this).offset().top;
			var position = objectPos - scrollPos;

			if (!isMobile && windowWidth >= 768) {
				$(this).css('background-position', '50% ' + parseInt(position*0.2) + 'px');
			} else {
				$(this).css({
					backgroundPosition: '50% 0px',
					backgroundSize: 'cover'
				});
			}
		});
	});

}



