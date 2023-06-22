/*
Author       : Dreamguys
Template Name: Truelysell - Service Marketplace
Version      : 1.0
*/

(function ($) {
	"use strict";

	var $slimScrolls = $('.slimscroll');
	var $wrapper = $('.main-wrapper');

	// Sidebar

	if ($(window).width() <= 991) {
		var Sidemenu = function () {
			this.$menuItem = $('.main-nav a');
		};

		function init() {
			var $this = Sidemenu;
			$('.main-nav a').on('click', function (e) {
				if ($(this).parent().hasClass('has-submenu')) {
					e.preventDefault();
				}
				if (!$(this).hasClass('submenu')) {
					$('ul', $(this).parents('ul:first')).slideUp(350);
					$('a', $(this).parents('ul:first')).removeClass('submenu');
					$(this).next('ul').slideDown(350);
					$(this).addClass('submenu');
				} else if ($(this).hasClass('submenu')) {
					$(this).removeClass('submenu');
					$(this).next('ul').slideUp(350);
				}
			});
		}

		// Sidebar Initiate
		init();
	}

	// Sticky Header
	$(window).scroll(function () {
		var sticky = $('.header'),
			scroll = $(window).scrollTop();
		if (scroll >= 50) sticky.addClass('fixed');
		else sticky.removeClass('fixed');
	});

	// Mobile menu sidebar overlay
	$('.header-fixed').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btn', function () {
		$('main-wrapper').toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').addClass('menu-opened');
		return false;
	});


	$(document).on('click', '.sidebar-overlay', function () {
		$('html').removeClass('menu-opened');
		$(this).removeClass('opened');
		$('main-wrapper').removeClass('slide-nav');
		$('#task_window').removeClass('opened');
	});

	$(document).on('click', '#menu_close', function () {
		$('html').removeClass('menu-opened');
		$('.sidebar-overlay').removeClass('opened');
		$('main-wrapper').removeClass('slide-nav');
	});

	// Select 2
	if ($('.select').length > 0) {
		$('.select').select2({
			minimumResultsForSearch: -1,
			width: '100%'
		});
	}

	// Select Favourite

	$('.fav-icon').on('click', function () {
		$(this).toggleClass('selected');
		//$(this).children().toggleClass("feather-heart fa-solid fa-heart");
	});

	// Select Rating

	$('.rating-select a i').on('click', function () {
		$(this).toggleClass('filled');
	});

	// Small Sidebar

	$(document).on('click', '#toggle_btn', function () {
		if ($('body').hasClass('mini-sidebar')) {
			$('body').removeClass('mini-sidebar');
			$('.subdrop + ul').slideDown();
		} else {
			$('body').addClass('mini-sidebar');
			$('.subdrop + ul').slideUp();
		}
		return false;
	});


	$(document).on('mouseover', function (e) {
		e.stopPropagation();
		if ($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
			var targ = $(e.target).closest('.sidebar').length;
			if (targ) {
				$('body').addClass('expand-menu');
				$('.subdrop + ul').slideDown();
			} else {
				$('body').removeClass('expand-menu');
				$('.subdrop + ul').slideUp();
			}
			return false;
		}
	});

	// fade in scroll

	if ($('.main-wrapper .aos').length > 0) {
		AOS.init({
			duration: 1200,
			once: true
		});
	}

	// Mobile menu sidebar overlay

	$('body').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btns', function () {
		$wrapper.toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').toggleClass('menu-opened');
		return false;
	});

	// Sidebar

	var Sidemenu = function () {
		this.$menuItem = $('#sidebar-menu a');
	};

	function initi() {
		var $this = Sidemenu;
		$('#sidebar-menu a').on('click', function (e) {
			if ($(this).parent().hasClass('submenu')) {
				e.preventDefault();
			}
			if (!$(this).hasClass('subdrop')) {
				$('ul', $(this).parents('ul:first')).slideUp(350);
				$('a', $(this).parents('ul:first')).removeClass('subdrop');
				$(this).next('ul').slideDown(350);
				$(this).addClass('subdrop');
			} else if ($(this).hasClass('subdrop')) {
				$(this).removeClass('subdrop');
				$(this).next('ul').slideUp(350);
			}
		});
		$('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
	}

	// Sidebar Initiate
	initi();


	// Sidebar Slimscroll

	if ($slimScrolls.length > 0) {
		$slimScrolls.slimScroll({
			height: 'auto',
			width: '100%',
			position: 'right',
			size: '7px',
			color: '#ccc',
			allowPageScroll: false,
			wheelStep: 10,
			touchScrollStep: 100
		});
		var wHeight = $(window).height() - 76;
		$slimScrolls.height(wHeight);
		$('.sidebar .slimScrollDiv').height(wHeight);
		$(window).resize(function () {
			var rHeight = $(window).height() - 76;
			$slimScrolls.height(rHeight);
			$('.sidebar .slimScrollDiv').height(rHeight);
		});
	}

	if ($('#data-table').length > 0) {
		$('#data-table').DataTable({
			"language": {
				search: ' ',
				searchPlaceholder: "Search...",
				info: "_START_ - _END_ of _TOTAL_",
				paginate: {
					next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
					previous: '<i class="fas fa-chevron-left me-2"></i> Previous'

				}
			},
			"bFilter": false,
			initComplete: (settings, json) => {
				$('.dataTables_length').appendTo('#tablelength');
				$('.dataTables_paginate').appendTo('#tablepagination');
				$('.dataTables_info').appendTo('#tableinfo');
			},

		});
	}

	// catering slider
	if ($('.owl-carousel.catering-slider').length > 0) {
		$('.owl-carousel.catering-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// Catering Feature slider
	if ($('.owl-carousel.features-four-slider').length > 0) {
		$('.owl-carousel.features-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	//for slider
	$(window).on('load resize', function () {
		var window_width = $(window).outerWidth();
		var container_width = $('.container').outerWidth();
		var full_width = window_width - container_width
		var right_position_value = full_width / 2
		$('.slider-service').css('padding-left', right_position_value);

	});

	// Catering Feature slider
	if ($('.owl-carousel.client-four-slider').length > 0) {
		$('.owl-carousel.client-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	if ($('#company-slider').length > 0) {
		$('#company-slider').owlCarousel({
			items: 8,
			margin: 30,
			dots: false,
			nav: false,
			autoplay: true,
			smartSpeed: 2000,
			navText: [
				'<i class="fas fa-chevron-left"></i>',
				'<i class="fas fa-chevron-right"></i>'
			],
			loop: true,
			responsiveClass: true,
			responsive: {
				0: {
					items: 2
				},
				768: {
					items: 3
				},
				1170: {
					items: 6
				}
			}
		});
	}

	// Interesting & Useful Blogs
	if ($('.owl-carousel.useful-four-slider').length > 0) {
		$('.owl-carousel.useful-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Top Caterers Around the World slider
	if ($('.owl-carousel.world-four-slider').length > 0) {
		$('.owl-carousel.world-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.car-blog-slider').length > 0) {
		$('.owl-carousel.car-blog-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.top-providers-five').length > 0) {
		$('.owl-carousel.top-providers-five').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.provider-nine-slider').length > 0) {
		$('.owl-carousel.provider-nine-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}


	// Service slider
	if ($('.owl-carousel.categories-slider-seven').length > 0) {
		$('.owl-carousel.categories-slider-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}


	// Service slider
	if ($('.owl-carousel.top-projects-seven').length > 0) {
		$('.owl-carousel.top-projects-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-seven-three',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.blogs-nine-slider').length > 0) {
		$('.owl-carousel.blogs-nine-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-seven-three',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Quote-slider
	if ($('.owl-carousel.quote-slider').length > 0) {
		$('.owl-carousel.quote-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
			smartSpeed: 2000,
			autoplay:true,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.recent-projects-seven').length > 0) {
		$('.owl-carousel.recent-projects-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-seven-two',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// JQuery counterUp

    if($('.counter').length > 0) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
          });
        $('.counter').addClass('animated fadeInDownBig');
    }

	// Service slider
	if ($('.owl-carousel.customer-review-slider').length > 0) {
		$('.owl-carousel.customer-review-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.popular-service-seven').length > 0) {
		$('.owl-carousel.popular-service-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.service-slider').length > 0) {
		$('.owl-carousel.service-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			navContainer: '.mynav',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.our-recent-blog').length > 0) {
		$('.owl-carousel.our-recent-blog').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.car-testimonials-five-slider').length > 0) {
		$('.owl-carousel.car-testimonials-five-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.testimonals-seven-slider').length > 0) {
		$('.owl-carousel.testimonals-seven-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-test',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.testimonals-eight-slider').length > 0) {
		$('.owl-carousel.testimonals-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.category-eight-slider').length > 0) {
		$('.owl-carousel.category-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 6
				},
				1400: {
					items: 6
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.blog-eight-slider').length > 0) {
		$('.owl-carousel.blog-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.professional-eight-slider').length > 0) {
		$('.owl-carousel.professional-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.service-nine-slider').length > 0) {
		$('.owl-carousel.service-nine-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.feature-service-five-slider').length > 0) {
		$('.owl-carousel.feature-service-five-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.partners-slider').length > 0) {
		$('.owl-carousel.partners-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.partners-slider-seven').length > 0) {
		$('.owl-carousel.partners-slider-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
			smartSpeed: 2000,
			autoplay: true,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.partners-five-slider').length > 0) {
		$('.owl-carousel.partners-five-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
			autoplay: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}

	// services-slider
	if ($('.owl-carousel.services-slider').length > 0) {
		$('.owl-carousel.services-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// latest-slider
	if ($('.owl-carousel.latest-slider').length > 0) {
		$('.owl-carousel.latest-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// services-slider
	if ($('.owl-carousel.stylists-slider').length > 0) {
		$('.owl-carousel.stylists-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// Related slider
	if ($('.owl-carousel.related-slider').length > 0) {
		$('.owl-carousel.related-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			navContainer: '.mynav',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 2
				}
			}
		})
	}

	// Gallery slider
	if ($('.owl-carousel.gallery-slider').length > 0) {
		$('.owl-carousel.gallery-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			dots: false,
			navContainer: '.mynav3',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}


	// Popular Service slider
	if ($('.owl-carousel.popular-slider').length > 0) {
		$('.owl-carousel.popular-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			navContainer: '.mynav1',
			responsive: {
				0: {
					items: 1
				},
				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Testimonial slider
	if ($('.owl-carousel.testimonial-slider').length > 0) {
		$('.owl-carousel.testimonial-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},
				700: {
					items: 2
				},
				1000: {
					items: 2
				}
			}
		})
	}

	// Testimonial slider
	if ($('.owl-carousel.client-slider').length > 0) {
		$('.owl-carousel.client-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	//Home slider
	if ($('.banner-slider').length > 0) {
		$('.banner-slider').slick({
			dots: false,
			autoplay: false,
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 800,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 776,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 567,
				settings: {
					slidesToShow: 1
				}
			}]
		});
	}
	// Slick testimonial two

	if ($('.say-about.slider-for').length > 0) {
		$('.say-about.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.client-img.slider-nav'
		});
	}

	if ($('.client-img.slider-nav').length > 0) {
		$('.client-img.slider-nav').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '.say-about.slider-for',
			dots: false,
			arrows: false,
			centerMode: true,
			focusOnSelect: true

		});
	}

	// Payment Method

	$('.payment-card').on('click', function () {
		$('.card-payment').each(function () {
			$(this).closest('.payment-card').removeClass('payment-bg');
		});
		$(this).closest('.payment-card').addClass('payment-bg');
		$(this).find(".card-payment").prop("checked", true);

		if ($(this).find(".credit-card-option").length > 0) {
			$(".payment-list").css('display', 'block');
		} else {
			$(".payment-list").css('display', 'none');
		}
	});

	// Datetimepicker Date

	if ($('.datetimepicker').length > 0) {
		$('.datetimepicker').datetimepicker({
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
	}


	//Custom Country Code Selector

	// if ($('#phone').length > 0) {
	// 	var input = document.querySelector("#phone");
	// 	window.intlTelInput(input, {
	// 		utilsScript: "/assets/plugins/intltelinput/js/utils.js",
	// 	});
	// }

	if ($('#phone1').length > 0) {
		var input = document.querySelector("#phone1");
		window.intlTelInput(input, {
			utilsScript: "/assets/plugins/intltelinput/js/utils.js",
		});
	}

	//Otp verfication

	$('.digit-group').find('input').each(function () {
		$(this).attr('maxlength', 1);
		$(this).on('keyup', function (e) {
			var parent = $($(this).parent());

			if (e.keyCode === 8 || e.keyCode === 37) {
				var prev = parent.find('input#' + $(this).data('previous'));

				if (prev.length) {
					$(prev).select();
				}
			} else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
				var next = parent.find('input#' + $(this).data('next'));

				if (next.length) {
					$(next).select();
				} else {
					if (parent.data('autosubmit')) {
						parent.submit();
					}
				}
			}
		});
	});

	$('.digit-group input').on('keyup', function () {
		var self = $(this);
		if (self.val() != '') {
			self.addClass('active');
		} else {
			self.removeClass('active');
		}
	});

	// Toggle Password

	if ($('#time-slot').length > 0) {
		$('#time-slot').on('click', function () {
			$(".timeslot-sec").show();
			$(".timepicker-sec").hide();
		});
		$('#time-picker').on('click', function () {
			$(".timepicker-sec").show();
			$(".timeslot-sec").hide();
		});
	}


	// Counters
	if ($('.counters').length > 0) {
		$('.counters').each(function () {
			var $this = $(this),
				countTo = $this.attr('data-count');
			$({ countNum: $this.text() }).animate({
				countNum: countTo
			},
				{
					duration: 3000,
					easing: 'linear',
					step: function () {
						$this.text(Math.floor(this.countNum));
					},
					complete: function () {
						$this.text(this.countNum);
					}

				});
		});
	}

	// CURSOR

	function mim_tm_cursor() {

		var myCursor = jQuery('.mouse-cursor');

		if (myCursor.length) {
			if ($("body")) {

				const e = document.querySelector(".cursor-inner"),
					t = document.querySelector(".cursor-outer");
				let n, i = 0,
					o = !1;
				window.onmousemove = function (s) {
					o || (t.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)"), e.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)", n = s.clientY, i = s.clientX
				}, $("body").on("mouseenter", "a, .cursor-pointer", function () {
					e.classList.add("cursor-hover"), t.classList.add("cursor-hover")
				}), $("body").on("mouseleave", "a, .cursor-pointer", function () {
					$(this).is("a") && $(this).closest(".cursor-pointer").length || (e.classList.remove("cursor-hover"), t.classList.remove("cursor-hover"))
				}), e.style.visibility = "visible", t.style.visibility = "visible"
			}
		}
	};
	mim_tm_cursor()

	// MultiStep Form Script

	$(document).ready(function () {
		/*---------------------------------------------------------*/
		$(".next_btn").on('click', function () { // Function Runs On NEXT Button Click
			$(this).closest('fieldset').next().fadeIn('slow');
			$(this).closest('fieldset').css({
				'display': 'none'
			});
			// Adding Class Active To Show Steps Forward;
			$('#progressbar .active').next().addClass('active');
			//$('#progressbar .active').removeClass('active').addClass('activated').next().addClass('active');

		});
	});

	// Timing Type

	if ($('.toggle-password').length > 0) {
		$(document).on('click', '.toggle-password', function () {
			$(this).toggleClass("feather-eye feather-eye-off");
			var input = $(".pass-input");
			if (input.attr("type") == "password") {
				input.attr("type", "text");
			} else {
				input.attr("type", "password");
			}
		});
	}

	// payment active

	$('.card-payments').on('click', function () {
		$('.card-payments').removeClass('active');
		$(this).addClass('active');
	});

	// Reply Comment

	$('.reply-box').on('click', function () {
		$(this).closest('.review-box').find('.reply-com').toggle();
	});

	$(".top-close").on('click', function () {
		$(this).closest('.top-bar').slideUp(500);
		return false;
	});

	// Ck Editor

	if ($('.ck-editor').length > 0) {
		ClassicEditor
			.create(document.querySelector('.ck-editor'), {
				toolbar: {
					items: [
						'heading', '|',
						'fontfamily', 'fontsize', '|',
						'alignment', '|',
						'fontColor', 'fontBackgroundColor', '|',
						'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
						'link', '|',
						'outdent', 'indent', '|',
						'bulletedList', 'numberedList', 'todoList', '|',
						'code', 'codeBlock', '|',
						'insertTable', '|',
						'uploadImage', 'blockQuote', '|',
						'undo', 'redo'
					],
					shouldNotGroupWhenFull: true
				}
			})
			.then(editor => {
				window.editor = editor;
			})
			.catch(err => {
				console.error(err.stack);
			});
	}

	// Datetimepicker time

	if ($('.timepicker').length > 0) {
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
	}

	// Add Service Information

	$(".addservice-info").on('click', '.trash', function () {
		$(this).closest('.service-cont').remove();
		return false;
	});

	$(".add-extra").on('click', function () {

		var servicecontent = '<div class="row service-cont">' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">Item</label>' +
			'<input type="text" class="form-control" placeholder="Enter  Service Item">' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">Price</label>' +
			'<input type="text" class="form-control" placeholder="Enter Services Price">' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="d-flex">' +
			'<div class="form-group w-100">' +
			'<label class="col-form-label">Duration</label>' +
			'<input type="text" class="form-control" placeholder="Enter Service Duration">' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';

		$(".addservice-info").append(servicecontent);
		return false;
	});

	// Add Hours

	$(".hours-info").on('click', '.trash', function () {
		$(this).closest('.hours-cont').remove();
		return false;
	});

	$(".add-hours").on('click', function () {

		var hourscontent = '<div class="row hours-cont">' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">From</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">To</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="d-flex">' +
			'<div class="form-group w-100">' +
			'<label class="col-form-label">Slots</label>' +
			'<input type="text" class="form-control" placeholder="Enter Slot">' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';

		$(this).parent().find(".hours-info").append(hourscontent);
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
		return false;
	});

	// Add Timepicker Hours

	$(".hrs-info").on('click', '.trash', function () {
		$(this).closest('.hrs-cont').remove();
		return false;
	});

	$(".add-hrs").on('click', function () {

		var hrscontent = '<div class="row hrs-cont">' +
			'<div class="col-md-6">' +
			'<div class="form-group form-info">' +
			'<label class="col-form-label">From</label>' +
			'<div class="input-group input-icon">' +
			'<input type="text" class="form-control timepicker"  placeholder="Select Time">' +
			'<span class="input-group-addon">' +
			'<i class="feather-clock"></i>' +
			'</span>' +
			'</div>' +
			'</div>' +
			'</div> ' +
			'<div class="col-md-6">' +
			'<div class="d-flex">' +
			'<div class="form-group form-info">' +
			'<label class="col-form-label">To</label>' +
			'<div class="input-group input-icon">' +
			'<input type="text" class="form-control timepicker"  placeholder="Select Time">' +
			'<span class="input-group-addon">' +
			'<i class="feather-clock"></i>' +
			'</span>' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';
		'</div>';

		$(this).parent().find(".hrs-info").append(hrscontent);
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
		return false;
	});

	// Add Timepicker Hours

	$(".day-info").on('click', '.trash', function () {
		$(this).closest('.day-cont').remove();
		return false;
	});

	$(".add-day").on('click', function () {

		var daycontent = '<div class="row day-cont">' +
			'<div class="col-md-6">' +
			'<div class="form-group">' +
			'<label class="col-form-label">From</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="col-md-6">' +
			'<div class="d-flex">' +
			'<div class="form-group w-100">' +
			'<label class="col-form-label">To</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';

		$(this).parent().parent().find(".day-info").append(daycontent);
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
		return false;
	});

	// Timer countdown

	if ($('.countdown-container').length > 0) {
		const daysEl = document.getElementById("days");
		const hoursEl = document.getElementById("hours");
		const minsEl = document.getElementById("mins");

		const newYears = "1 Jan 2023";

		function countdown() {
			const newYearsDate = new Date(newYears);
			const currentDate = new Date();

			const totalSeconds = (newYearsDate - currentDate) / 1000;

			const days = Math.floor(totalSeconds / 3600 / 24);
			const hours = Math.floor(totalSeconds / 3600) % 24;
			const mins = Math.floor(totalSeconds / 60) % 60;

			daysEl.innerHTML = days;
			hoursEl.innerHTML = formatTime(hours);
			minsEl.innerHTML = formatTime(mins);
		}

		function formatTime(time) {
			return time < 10 ? '0${time}' : time;
		}

		// initial call
		countdown();

		setInterval(countdown, 1000);
	}

	if ($('#more').length > 0) {
		const button = document.getElementById('more');
		const container = document.getElementById('fill-more');

		let isLess = true;

		function showMoreLess() {
			if (isLess) {
				isLess = false;
				container.style.height = 'auto';
				button.innerHTML = "Show less <i class='feather-arrow-up-circle ms-1'>";
			} else {
				isLess = true;
				container.style.height = '180px';
				button.innerHTML = "Show more <i class='feather-arrow-down-circle ms-1'></i>";
			}
		}

		button.addEventListener('click', showMoreLess);
	}


	// Calendar

	if ($('#calendar').length > 0) {
		document.addEventListener('DOMContentLoaded', function () {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				themeSystem: 'bootstrap5',

				headerToolbar: {
					left: 'title, prev,today next',
					//center: '',
					right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
				},
				initialDate: '2022-11-12',
				navLinks: true, // can click day/week names to navigate views
				// businessHours: true, // display business hours
				editable: true,
				selectable: true,
				events: [
					{
						title: 'Leave',
						start: '2022-11-16',
						end: '2022-11-16',
						color: '#E8E8E8',
						textColor: '#585757'
					},
					{
						title: 'Leave',
						start: '2022-11-03',
						end: '2022-11-03',
						color: '#E8E8E8',
						textColor: '#585757'
					},
					{
						title: 'Weekly Holiday',
						start: '2022-11-06',
						end: '2022-11-06',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
					{
						title: 'Weekly Holiday',
						start: '2022-11-13',
						end: '2022-11-13',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
					{
						title: 'Weekly Holiday',
						start: '2022-11-20',
						end: '2022-11-20',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
					{
						title: 'Weekly Holiday',
						start: '2022-11-27',
						end: '2022-11-27',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
				]
			});

			calendar.render();
		});
	}

	// Calendar Booking

	if ($('#calendar-book').length > 0) {
		document.addEventListener('DOMContentLoaded', function () {
			var calendarEl = document.getElementById('calendar-book');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				themeSystem: 'bootstrap5',

				headerToolbar: {
					left: 'title, prev,today next',
					//center: '',
					right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
				},
				initialDate: '2022-11-12',
				navLinks: true, // can click day/week names to navigate views
				// businessHours: true, // display business hours
				editable: true,
				selectable: true,
				events: [
					{
						title: '12:30am Laptop serv...',
						start: '2022-11-02',
						end: '2022-11-02',
						color: '#4c40ed1a',
						textColor: '#4C40ED',
						"className": "popup-toggle",
					},
					{
						title: '10:00am House Clean..',
						start: '2022-11-04',
						end: '2022-11-04',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '11:00am Washing ...',
						start: '2022-11-05',
						end: '2022-11-05',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '02:00pm Toughened...',
						start: '2022-11-10',
						end: '2022-11-10',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '05:00pm Interior ...',
						start: '2022-11-16',
						end: '2022-11-16',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '01:00pm Building....',
						start: '2022-11-18',
						end: '2022-11-18',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
				],
				eventClick: function (event, calEvent, jsEvent, view) {
					$(".fc-event-title").on("click", function () {
						$('.toggle-sidebar').addClass('sidebar-popup');
					});
					$(".sidebar-close").on("click", function () {
						$('.toggle-sidebar').removeClass('sidebar-popup');
					});
				}
			});

			calendar.render();
		});
	}

	// Checkbox Select

	$('.select-set').on("click", function () {
		$(this).parent().find('#dropboxes').fadeToggle();
		$(this).parent().parent().siblings().find('#dropboxes').fadeOut();
	});

	// Maximize

	if ($('.win-maximize').length > 0) {
		$('.win-maximize').on('click', function (e) {
			if (!document.fullscreenElement) {
				document.documentElement.requestFullscreen();
			} else {
				if (document.exitFullscreen) {
					document.exitFullscreen();
				}
			}
		})
	}

	// Chat

	var chatAppTarget = $('.chat-window');
	(function () {
		if ($(window).width() > 991)
			chatAppTarget.removeClass('chat-slide');

		$(document).on("click", ".chat-window .chat-users-list a.media", function () {
			if ($(window).width() <= 991) {
				chatAppTarget.addClass('chat-slide');
			}
			return false;
		});
		$(document).on("click", "#back_user_list", function () {
			if ($(window).width() <= 991) {
				chatAppTarget.removeClass('chat-slide');
			}
			return false;
		});
	})();

	if ($('#datetimepickershow').length > 0) {
		$('#datetimepickershow').datetimepicker({

			inline: true,
			sideBySide: true,
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}

		});
	}

	// Chat sidebar overlay

	if ($(window).width() <= 1199) {
		if ($('#task_chat').length > 0) {
			$(document).on('click', '#task_chat', function () {
				$('.sidebar-overlay').toggleClass('opened');
				$('#task_window').addClass('opened');
				return false;
			});
		}
	}

	// if ($(window).width() > 767) {
	// 	if ($('.theiaStickySidebar').length > 0) {
	// 		$('.theiaStickySidebar').theiaStickySidebar({
	// 			// Settings
	// 			additionalMarginTop: 125
	// 		});
	// 	}
	// }
})(jQuery);
