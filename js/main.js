(function($){
	var ladybirdsTheme = {
		slideNavigation : function(){
			var openBtn = $('.lb-mobile-menu-icon');
			var closeBtn = $('.lb-mobile-menu-close');
			var slideableMenuContainer = $('.header-menu');

			var previousScroll = 0;
			openBtn.addClass('show');
			$(window).scroll(function(){
				var currentScroll = $(this).scrollTop();
				if (currentScroll < previousScroll) {
					openBtn.addClass('show');
				}else{
					openBtn.removeClass('show');
				}

				previousScroll = currentScroll;
			});

			openBtn.on('click', function(){
				slideableMenuContainer.toggleClass('open');
			});

			closeBtn.on('click', function(){
				slideableMenuContainer.removeClass('open');
			});
		},

		lazyImages: function(){
			var imgAttr = $('[data-lbimg]');
			imgAttr.each(function(){
				var bigImage = $(this).attr('data-lbimg');
				$(this).attr('src', bigImage);
			});
		},

		showAllCat: function(){
			$('.widget_categories > ul').after('<button class="lb-view-all-cat-btn lb-badge-primary">All</button>');

			$('.lb-view-all-cat-btn').on('click', function(){
				$('.widget_categories > ul > li').show();
				$(this).hide();
			});
		},

		postSlider: function(){
			$('.lb-post-slider, .gallery').slick({
			  infinite: true,
				prevArrow:'<span class="lb-post-slider-arrow lb-arrow-prev"><i class="fa fa-angle-left"></i></span>',
				nextArrow:'<span class="lb-post-slider-arrow lb-arrow-next"><i class="fa fa-angle-right"></i></span>',
			  slidesToShow: 3,
			  slidesToScroll: 1 ,
				responsive: [
			    {
			      breakpoint: 768,
			      settings: {
			        arrows: false,
			        slidesToShow: 1,
							slidesToScroll: 1,
			      }
			    }
			  ]
			});
		}
	};

	$(document).ready(function(){
		ladybirdsTheme.slideNavigation();
		ladybirdsTheme.showAllCat();
		ladybirdsTheme.postSlider();

		$(window).load(function(){
			$('.lb-post-slider').css('visibility', 'visible');
			ladybirdsTheme.lazyImages();
		});
	});
})(jQuery)
