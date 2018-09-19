(function($){
	var ladybirdsTheme = {
		slideNavigation : function(){
			var openBtn = $('.lb-mobile-menu-icon');
			var closeBtn = $('.lb-mobile-menu-close');
			var slideableMenuContainer = $('.header-menu');

			var previousScroll = 0;
			$(window).scroll(function(){
				console.log($(this).scrollTop());
				if ($(this).scrollTop() < previousScroll) {
					openBtn.addClass('test');
				}else{
					openBtn.removeClass('test');
				}

				previousScroll ++;
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
