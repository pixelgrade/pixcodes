(function($) {

    $(document).one('shortcode_Icon_open', '.details_content.active', function(){
        $(document).on("click", '.pxg_icon_list .icon', function(){

            // on each click on the list we clear all old active icons
            $('.pxg_icon_list .icon').removeClass('active');

            // set this one to active
            $(this).addClass("active");

            // prepare this value to be inserted in content
            $(".pxg_icon_list .selected_icon").val($(this).data("icon"));
        });
    });

})(jQuery);