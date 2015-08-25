(function($) {

    $(document).on('shortcode_Slider_open', '.details_content.active', function(){

        $('.param-slider').tabs({
            active: 0,
            hide: 300,
            show: 300,
            beforeActivate: function( event, ui ) {
                var index = $(ui.newTab).data('index');
                if ( index === 0 ) { // create a new tab
                    event.preventDefault();
                    var new_index = 1;

                    // get the biggest id
                    $(this).find('.slider-heads li').each(function(i,e){
                        var this_index = $(this).data('index');
                        if ( this_index > new_index ) new_index = this_index;
                    });

                    new_index = new_index + 1;

                    // add new tab head
                    $(ui.newTab).before('<li data-index="'+new_index+'" class="tab-head-'+new_index+'"><a href="#t'+new_index+'">Slide '+new_index+'</a></li>');

                    // add new tab content

                    var content = '<div id="t'+new_index+'" class="slide" data-tab="'+new_index+'">'+
                        '<textarea class="slide_content" placeholder="Content" rows="10"></textarea>'+
                        '</div>';
                    $(ui.newPanel).before(content);

                    $(this).tabs( "refresh" );
                }
            }
        }).addClass( "ui-slider-vertical ui-helper-clearfix" );
        $( ".param-slider li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

        /*Quit the classic way to add the shortcode and create it manually here */

        $('.details_content.active').find('#wpgrade_shortcodes_form').attr('id', 'wpgrade_shortcodes_form_modified'); // the most stupid thing i ever done...must change later
        $(document).one('submit', '#wpgrade_shortcodes_form_modified', function(e){
            e.preventDefault();
            var params = $(this).next('#data_params').data('params'),
                form_params =  $(this).serializeArray(),
                mainParamsString = '';

	        $.each(form_params, function(i,e){

		        if ( e.value !== '' ) { // don't include the empty params and the content param
			        if ( e.name == 'bg_color' ) {
				        e.value = e.value.replace(  '#', '');
			        }
			        mainParamsString += ' '+ e.name + '="'+ e.value +'"';
		        }
	        });

            output = '<p>[slider'+ mainParamsString +']</p>';
            $(this).find('.param-slider .ui-tabs-panel').each(function(i,el){

                var content = $(el).find('textarea.slide_content').val();
                if ( typeof content !== 'undefined' ) {
                    output += '<p>[slide]</p>';
                    if ( typeof content !== 'undefined' ) {
                        output += '<p>'+ content.replace(/\n/ig,"<br>") +'</p>' + '<p>[/slide]</p>';
                    } else {
                        output += '<p>[/slide]</p>';
                    }
                }
            });

            output += '<p>[/slider]</p>';
            editor.selection.setContent(output);

            // ensure the editor is on visual
            switchEditors.go( editor.id, 'tmce' );

            $('#pixelgrade_shortcodes_modal').trigger('reveal:close');
        });
    });
})(jQuery);