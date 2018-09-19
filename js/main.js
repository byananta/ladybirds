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
		}
	};

	$(document).ready(function(){
		ladybirdsTheme.slideNavigation();
	});
})(jQuery)
