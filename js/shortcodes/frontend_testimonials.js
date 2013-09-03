;(function($){

    $(document).ready(function(){
        $(".testimonials_slide").flexslider({
        	controlNav: false,
        	keyboard: false,
        	animation: 'slide',
            prevText: "",   
            nextText: "",
        	slideshow: false,
        	before: function(slider){ 
	            // slider.slides.removeClass('s-hidden');
	        },
	        after: function(slider) {
	        	// slider.slides.not(':eq('+slider.currentSlide+')').addClass('s-hidden');
	        },
	        start: function(slider) {
	        	// slider.slides.not(':eq(' + slider.currentSlide + ')').addClass('s-hidden');
	        }
        });
    });

})(jQuery);