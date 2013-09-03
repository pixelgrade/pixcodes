;(function($){

    $(document).ready(function(){
        $(".twitter-shortcode-tweets_container").flexslider({
        	controlNav: false,
        	keyboard: false,
        	animation: 'fadecss',
            prevText: "",   
            nextText: "",
            slideshow: true,
            pauseOnHover: true,
            pauseOnAction: true,            
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