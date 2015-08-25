(function($) {

    $(document).on('shortcode_Tabs_open', '.details_content.active', function(){

        $('.param-tabs').tabs({
            active: 0,
            hide: 300,
            show: 300,
            beforeActivate: function( event, ui ) {
                var index = $(ui.newTab).data('index');
                if ( index === 0 ) { // create a new tab
                    event.preventDefault();
                    var new_index = 1;

                    // get the biggest id
                    $(this).find('.tabs-heads li').each(function(i,e){
                        var this_index = $(this).data('index');
                        if ( this_index > new_index ) new_index = this_index;
                    });

                    new_index = new_index + 1;

                    // add new tab head
                    $(ui.newTab).before('<li data-index="'+new_index+'" class="tab-head-'+new_index+'"><a href="#t'+new_index+'">Tab '+new_index+'</a></li>');

                    // add new tab content

                    var content = '<div id="t'+new_index+'" class="tab" data-tab="'+new_index+'">'+
                        '<input type="text" class="tab_title" placeholder="Title"/>'+
                        '<input type="text" class="tab_icon" placeholder="Font Awesome Icon Class" /><a class="tip_icon" title="See the list with all icons classes" href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank"><i class="icon-external-link"></i></a>'+
                        '<textarea class="tab_content" placeholder="Content" rows="10"></textarea>'+
                        '</div>';
                    $(ui.newPanel).before(content);

                    $(this).tabs( "refresh" );
                }
            }
        }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        $( ".param-tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

        /*Quit the classic way to add the shortcode and create it manually here */

        $('.details_content.active').find('#wpgrade_shortcodes_form').attr('id', 'wpgrade_shortcodes_form_modified'); // the most stupid thing i ever done...must change later
        $(document).one('submit', '#wpgrade_shortcodes_form_modified', function(e){
            e.preventDefault();
            var params = $(this).next('#data_params').data('params'),
                form_params =  $(this).serializeArray(),
                params_String = '';

            output = '<p>[tabs]</p>';
            $(this).find('.param-tabs .ui-tabs-panel').each(function(i,el){

                var params_string = false,
                    title = $(el).find('input.tab_title').val(),
                    icon = $(el).find('input.tab_icon').val(),
                    content = $(el).find('textarea.tab_content').val();


                if ( typeof title !== 'undefined' ) {
                    params_string = ' title="'+ title +'"';
                }

                if ( typeof icon !== 'undefined' && icon != '' ) {
                    params_string += ' icon="'+ icon +'"';
                }

                if ( params_string && typeof content !== 'undefined' ) {

                    output += '<p>[tab';
                    if ( params_string ) {
                        output += params_string + ']</p>';
                    } else {
                        output += ']</p>';
                    }

                    if ( typeof content !== 'undefined' ) {
                        output += '<p>'+ content.replace(/\n/ig,"<br>") +'</p>' + '<p>[/tab]</p>';
                    } else {
                        output += '<p>[/tab]</p>';
                    }
                }
            });

            output += '<p>[/tabs]</p>';
            editor.selection.setContent(output);

            // ensure the editor is on visual
            switchEditors.go( editor.id, 'tmce' );

            $('#pixelgrade_shortcodes_modal').trigger('reveal:close');
        });
    });
})(jQuery);