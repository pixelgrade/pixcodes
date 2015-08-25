(function($) {

    $.fn.disableSelection = function() {
        return this
            .attr('unselectable', 'on')
            .css('user-select', 'none')
            .on('selectstart', false);
    };

    /*
     * Create teh slider
     */

    $(document).on('shortcode_Columns_open', '.details_content.active', function(){
        // var modalLocation = $(this).attr('data-reveal-id');

        $('.details_content.active .grid_cols_slider').disableSelection();

        var getValues = function() {
            values = [];
            $('.details_content.active .grid_cols_content').children().each(function(idx, el){
                values[idx] = parseInt($(this).attr('class').split("span")[1]);
            });
            return values;
        };

        var columnsNo = parseInt($('[name="cols_nr"]').val());
        var sliderWidth = $('.details_content.active .grid_cols_slider').width();
        var colWidth = sliderWidth/12;
        var values = [];

        var initializeSlider = function() {
            columnsNo = parseInt($('[name="cols_nr"]').val());
            var spanWidth = 12/columnsNo,
                columnSpan = spanWidth;

            $('.grid_cols_slider .handle').remove();
            $('<li class="handle read-only" data-offset="0">0</li>').appendTo('.grid_cols_slider');
            $('.grid_cols_dimensions li').remove();
            $('.grid_cols_content li').remove();

            for (var i = 0; i < columnsNo; i++) {
                $('<li class="handle" data-offset="'+columnSpan+'">'+columnSpan+'</li>').appendTo('.details_content.active .grid_cols_slider');
                $('<li class="span'+spanWidth+'"><span>'+spanWidth+'x</span></li>').appendTo('.grid_cols_dimensions');
                $('<li class="span'+spanWidth+'"><span>Content goes here..</span></li>').appendTo('.grid_cols_content');
                columnSpan += spanWidth;
            }

            $('.details_content.active .grid_cols_slider .handle').last().addClass('read-only');

            $('.details_content.active .grid_cols_slider .handle').each(function() {
                var self = $(this),
                    offset = self.data('offset');
                self.css({'left': offset * colWidth})
            });

//            getValues();
        };

        initializeSlider();
        $(document).on('change', '[name="cols_nr"]', initializeSlider);

        var dragging = false,
            xStart, xDiff,
            handle = false;

        var growColumn = function(index) {
            var self = $('.grid_cols_content li').get(index);
            var dim = $('.grid_cols_dimensions li').get(index);
            var span = parseInt($(self).attr('class').split("span")[1]);
            $(self).attr('class', 'span' + (span+1));
            $(dim).attr('class', 'span' + (span+1));
            $(dim).children('span').text((span+1)+'x');
        };

        var shrinkColumn = function(index) {
            var self = $('.grid_cols_content li').get(index);
            var dim = $('.grid_cols_dimensions li').get(index);
            var span = parseInt($(self).attr('class').split("span")[1]);
            $(self).attr('class', 'span' + (span-1));
            $(dim).attr('class', 'span' + (span-1));
            $(dim).children('span').text((span-1)+'x');
        };

        $('.l_pxg_modal').on('touchstart mousedown', '.details_content.active .grid_cols_slider .handle:not(.read-only)', function(e) {
            var event = e.originalEvent,
                touch = event.targetTouches ? event.targetTouches[0] : e;

            dragging = true;
            handle = $(this).addClass('active');
            e.preventDefault();
            xStart = touch.pageX;
        });

        $(document).on("touchmove mousemove", '.l_pxg_modal', function(e) {
            var event = e.originalEvent,
                touch = event.changedTouches ? event.changedTouches[0] : e;

            if (dragging) {
                e.preventDefault();

                xDiff = touch.pageX - xStart;

                if (Math.abs(xDiff) > colWidth/2) {
                    var push = parseInt(handle.css('left'));
                    var index = handle.index();
                    if (xDiff > 0) {
                        if (parseInt(handle.text()) + 1 < parseInt(handle.next().text())){
                            handle.css('left', push + colWidth);
                            handle.text(parseInt(handle.text()) + 1);
                            xStart = xStart + colWidth;
                            shrinkColumn(index);
                            growColumn(index - 1);
                            getValues();
                        }
                    } else {
                        if (parseInt(handle.prev().text()) + 1 < parseInt(handle.text())){
                            handle.css('left', push - colWidth);
                            handle.text(parseInt(handle.text()) - 1);
                            xStart = xStart - colWidth;
                            shrinkColumn(index - 1);
                            growColumn(index);
                            getValues();
                        }
                    }
                }
            }
        });

        $('body').on('touchend mouseup', function(e) {
            var event = e.originalEvent,
                touch = event.changedTouches ? event.changedTouches[0] : e;

            if (dragging) {
                dragging = false;
                handle.removeClass('active');
                handle = false;
                e.preventDefault();
            }
        });

        /*Quit the classic way to add the shortcode and create it manually here */

        $('.details_content.active').find('#wpgrade_shortcodes_form').attr('id', 'wpgrade_shortcodes_form_modified'); // the most stupid thing i ever done...must change later
        $(document).one('submit', '#wpgrade_shortcodes_form_modified', function(e){
            e.preventDefault();
            var params = $(this).next('#data_params').data('params'),
                form_params =  $(this).serializeArray(),
                params_String = '',
	            extend_shortcode = '';

            $.each(form_params, function(i,e){

	            if ( e.name == 'inner' ) { // for inner param, we create a second level shortcode like row_inner
		            extend_shortcode = '_inner';
		            return;
	            }

                if ( e.value !== '' ) { // don't include the empty params and the content param
                    if ( e.name == 'bg_color' ) {
	                    e.value = e.value.replace(  '#', '');
                    }
                    params_String += ' '+ e.name + '="'+ e.value +'"';
                }
            });

            var output = '<p>[row'+ extend_shortcode +' '+ params_String +']</p>';

            $.each(getValues(), function(i,e){ // get each column and their params
                output += '<p>[col'+ extend_shortcode +' size="'+e+'"]</p><p>Content goes here</p><p>[/col'+ extend_shortcode +']</p>';
            });
            output += '<p>[/row'+ extend_shortcode +']</p>';
            editor.selection.setContent(output);

            // ensure the editor is on visual
            switchEditors.go( editor.id, 'tmce' );

            $('#pixelgrade_shortcodes_modal').trigger('reveal:close');
        });
    });
})(jQuery);