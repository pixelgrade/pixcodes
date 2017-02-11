editor = '';
(function($) {

	$( document ).ready( function() {

		$( 'body' ).append( '<div id="pixelgrade_shortcodes_modal"  class="reveal-modal l_pxg_modal">' );

		var modal_selector = $( '#pixelgrade_shortcodes_modal' ),
			plugin_url;

		$.ajax( {
			url: ajaxurl,
			data: {action: 'wpgrade_get_shortcodes_modal', post_id: $( '#post_ID' ).val()},
			success: function( data ) {
				content = JSON.parse( data );
				modal_selector.html( content );
				//Variables
				var details = $( '.details_container .details_content' );
				var modal_title = $( '.l_pxg_modal .l_modal_title' );
				var default_title = modal_title.html();
				var triggered_woman = '';

				// fix on close
				$( document ).on( 'reveal:close', '#pixelgrade_shortcodes_modal', function() {
//					disable_details(); //we will do this before the open click
					clean_details();
//					$('.l_modal_header button .back').hide(); //we will show it on the open click
					toggle_submit_btn();
					change_title( default_title );
					window.send_to_editor = window.send_to_editor_clone;
					$( '.l_pxg_modal .btn_primary' ).removeClass( 'disabled' );
					var this_btn = $( '.btn.back' );
					this_btn.removeClass( 'active' );
					$('body').removeClass('pixcodes_select_tags_opened');
				} );

				//Back Button Click
				$( document ).on( 'click', '.l_modal_header button.back', function() {
					toggle_details();
					toggle_back_btn();
					toggle_submit_btn();
					change_title( default_title );
					clean_details();
				} );

				//Choose an item
				$( document ).on( 'click', '.l_three_col li.shortcode a.details', function() {

					if ( $( this ).hasClass( 'insert-direct-shortcode' ) ) {
						return false;
					}
					// get the current selection and set it as content
					var current_editor = get_current_editor_selected_content(),
						content_field = $( this ).next().find( '.is_shortcode_content' );

					if ( content_field.attr( 'type' ) === 'text' ) {
						content_field.attr( 'value', current_editor.selection.getContent() );
					} else if ( content_field.attr( 'type' ) === 'textarea' && current_editor.selection.getContent().length > 0 ) {
						content_field.text( current_editor.selection.getContent() );
					}

					var html_container = $( this ).next().html(),
						item_title = $( this ).find( '.title' ).html();

					fill_details( html_container );
					toggle_details();
					toggle_back_btn();
					toggle_submit_btn();
					change_title( '<span>Insert</span> ' + item_title + ' <span>Shortcode:</span>' );

					triggered_woman = details.find( 'button[type="submit"]' );

					details.trigger( $( this ).data( 'trigger-open' ) );

					/*
					 * Each colorpicker needs to be processed.
					 * Until wordpress will give us an update method on wpcolorpicker i'll keep removing and adding elements like in high school.
					 */
					$( '.wpgrade-colorpicker' ).each( function() {
						// if the colorpicker is already called is probably ruined already. We will remove it and create another one.
						if ( $( this ).hasClass( 'wp-color-picker' ) ) {

							var $root = $( this ).parents( '.wp-picker-container' ), // get the root of the colorpicker
								this_el = $( this ).removeClass( 'wp-color-picker' ).detach(); // save our element
							var this_span = $root.parent( 'span' );
							$root.remove(); // remove the root
							this_span.append( this_el ); // get back our element
							// create the colorpicker ... again
							this_span.children( '.wpgrade-colorpicker' ).wpColorPicker( {
								palettes: ['#46bcb7', '#fafafa', '#373737', '#01a279', '#45d59c', '#7abd58'],
								change: function( event, ui ) {
									$( '.full_width_bg' ).addClass( 's-visible' );
								}
							} );

						} else {
							$( this ).wpColorPicker( {
								palettes: ['#46bcb7', '#fafafa', '#373737', '#01a279', '#45d59c', '#7abd58'],
								change: function( event, ui ) {
									$( '.full_width_bg' ).addClass( 's-visible' );
								}
							} );
						}
					} );

					$( '.details_container .input-tags select' ).each( function() {

						var options = $( this ).data( 'options' );
						if ( $( this ).hasClass( 'select2-offscreen' ) ) {
							$( this ).select2( "destroy" );
							$( this ).select2( {tags: options} );
						} else {
							$( this ).select2( {tags: options} );
						}
					} );
				} );

				//Trigger Submit Button (need few improvements :)
				$( document ).on( 'click', ".l_pxg_modal a.btn_primary", function() {
					trigger_submit_btn( triggered_woman );
				} );

				//Show the .details_container - display:block
				var toggle_details = function() {
					$( '.l_pxg_modal' ).toggleClass( 's_active' );
				};

				//Show the .details_container - display:block
				var disable_details = function() {
					$( '.l_pxg_modal' ).removeClass( 's_active' );
				};

				//Add html content from chosen shortcode into $details container
				var fill_details = function( $content ) {
					clean_details();
					details.html( $content ).addClass( 'active' );
				};

				//Change modal title
				var change_title = function( $title ) {
					modal_title.html( $title );
				};

				//Empty details content
				var clean_details = function() {
					details.html( '' ).removeClass( 'active' );
				};

				//Toggle Back button visibility
				var toggle_back_btn = function() {
					$( 'button.back' ).toggleClass( 'active' );
				};

				//Toggle Submit button
				var toggle_submit_btn = function() {
					$( '.l_pxg_modal .btn_primary' ).toggleClass( 'disabled' );
				};

				//Trigger Submit button
				var trigger_submit_btn = function( $button ) {
					$button.trigger( 'click' );
				};

				$( document ).trigger( 'shortcodes_modal:ready' );

			} // end of ajax success
		} );

		tinymce.create( 'tinymce.plugins.wpgrade', {
			init: function( ed, url ) {
				plugin_url = url;
				ed.addButton( 'wpgrade', {
					title: 'Add a shortcode',
					// text : 'PixCodes',
					classes: 'btn pixelgrade_shortcodes',
					onclick: function() {
						$( '.l_pxg_modal .btn_primary' ).addClass( 'disabled' );
						$( 'body' ).addClass( 'pixcodes_select_tags_opened' );
						//let's clean up some more first
						$( '.l_pxg_modal' ).removeClass( 's_active' );

						modal_selector.reveal( {
							animation: 'fadeAndPop',                   //fade, fadeAndPop, none
							animationspeed: 400,                       //how fast animtions are
							closeonbackgroundclick: true,              //if you click background will modal close?
							dismissmodalclass: 'close'    //the class of a button or element that will close an open modal
						} );
						editor = ed;
						get_current_editor_selected_content = function() {
							return editor;
						};

						window.send_to_editor_clone = window.send_to_editor;
					}
				} );
			}
		} );
		tinymce.PluginManager.add( 'wpgrade', tinymce.plugins.wpgrade );

		// if the shortcode doesn't have params it needs to be inserted directly
		modal_selector.on( 'click', '.insert-direct-shortcode', function() {

			var params = $( this ).data( 'params' );
			if ( params.self_closed ) {
				editor.selection.setContent( '[' + params.code + ']' );
			} else {
				editor.selection.setContent( '<p>[' + params.code + ' ]</p><p>' + editor.selection.getContent() + '</p><p>[/' + params.code + ']</p>' );
			}
			// close the modal whenever a shortcode is inserted
			modal_selector.trigger( 'reveal:close' );
		} );

		// when submiting a panel of params
		$( document ).on( 'submit', '#wpgrade_shortcodes_form', function( e ) {
			e.preventDefault();

			var params = $( this ).next( '#data_params' ).data( 'params' ),
				form_params = $( this ).serializeShortcodeParams(),
				user_params_string = '',
				user_params = {},
				shortcode_content = '';

			$.each( form_params, function( i, e ) {

				if ( e.class == 'is_shortcode_content' ) {

					shortcode_content = e.value;

				} else if ( e.value !== '' ) { // don't include the empty params and the content param

					user_params_string += ' ' + e.name + '="' + e.value + '"';
					user_params[e.name] = e.value;
				}

			} );

			//a little bit of cleanup to make sure we keep new lines when adding to TinyMce
			shortcode_content = shortcode_content.replace( /(?:\r\n|\r|\n)/g, "<br />" );

			if ( params.self_closed ) {
				editor.selection.setContent( '[' + params.code + user_params_string + ']' );
			} else if ( params.one_line ) {
				editor.selection.setContent( '[' + params.code + user_params_string + ']' + shortcode_content + '[/' + params.code + ']' );
			} else {
				editor.selection.setContent( '<p>[' + params.code + user_params_string + ']</p><p>' + shortcode_content + '</p><p>[/' + params.code + ']</p>' );
			}

			// ensure the editor is on visual
			switchEditors.go( editor.id, 'tmce' );

			modal_selector.trigger( 'reveal:close' );
		} ); // end of submit form

		$( document ).on( 'click', '.media_image_holder', function() {
			var $self = $( this );

			tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
			formfield = $( '#upload_image' ).attr( 'name' );

			window.send_to_editor = function( html ) {
				imgurl = $( 'img', html ).attr( 'src' );
				$self.find( '.media_image_input' ).val( imgurl );
				$self.find( '.upload_preview' ).attr( 'src', imgurl ).show().next().toggleClass( 'active' );
				tb_remove();
			};

			return false;
		} );

	} );

	$.fn.serializeShortcodeParams = function() {
		var return_els = {},
			elements = $( this ).find( '[name]' );

		$.each( elements, function( i, el ) {
			return_els[i] = {};
			return_els[i].name = this.name;

			if ( $( this ).attr( 'type' ) === 'checkbox' ) {

				if ( $( this ).is( ':checked' ) ) {
					return_els[i].value = 'on';
				} else {
					return_els[i].value = ''; // keep it empty to not show in params string
				}

			} else {
				return_els[i].value = $( this ).val();
			}

			// init the class as false
			return_els[i].class = false;
			if ( $( this ).attr( 'class' ) ) return_els[i].class = $( this ).attr( 'class' );

			// init type as text
			return_els[i].type = 'text';
			if ( $( this ).attr( 'type' ) ) return_els[i].type = $( this ).attr( 'type' );
		} );

		return return_els;
	};

	/*
	 * jQuery Reveal Plugin 1.0
	 * www.ZURB.com
	 * Copyright 2010, ZURB
	 * Free to use under the MIT license.
	 * http://www.opensource.org/licenses/mit-license.php
	 */
	$.fn.reveal=function(e){var t={animation:"fadeAndPop",animationspeed:300,closeonbackgroundclick:true,dismissmodalclass:"close-reveal-modal"};var e=$.extend({},t,e);return this.each(function(){function u(){i=false}function a(){i=true}var t=$(this),n=parseInt(t.css("top")),r=t.height()+n,i=false,s=$(".reveal-modal-bg");if(s.length==0){s=$('<div class="reveal-modal-bg" />').insertAfter(t)}t.bind("reveal:open",function(){s.unbind("click.modalEvent");$("."+e.dismissmodalclass).unbind("click.modalEvent");if(!i){a();if(e.animation=="fadeAndPop"){t.css({top:$(document).scrollTop()-r,opacity:0,visibility:"visible"});s.fadeIn(e.animationspeed/2);t.delay(e.animationspeed/2).animate({top:$(document).scrollTop()+n+"px",opacity:1},e.animationspeed,u())}if(e.animation=="fade"){t.css({opacity:0,visibility:"visible",top:$(document).scrollTop()+n});s.fadeIn(e.animationspeed/2);t.delay(e.animationspeed/2).animate({opacity:1},e.animationspeed,u())}if(e.animation=="none"){t.css({visibility:"visible",top:$(document).scrollTop()+n});s.css({display:"block"});u()}}t.unbind("reveal:open")});t.bind("reveal:close",function(){if(!i){a();if(e.animation=="fadeAndPop"){s.delay(e.animationspeed).fadeOut(e.animationspeed);t.animate({top:$(document).scrollTop()-r+"px",opacity:0},e.animationspeed/2,function(){t.css({top:n,opacity:1,visibility:"hidden"});u()})}if(e.animation=="fade"){s.delay(e.animationspeed).fadeOut(e.animationspeed);t.animate({opacity:0},e.animationspeed,function(){t.css({opacity:1,visibility:"hidden",top:n});u()})}if(e.animation=="none"){t.css({visibility:"hidden",top:n});s.css({display:"none"})}}t.unbind("reveal:close")});t.trigger("reveal:open");var o=$("."+e.dismissmodalclass).bind("click.modalEvent",function(){t.trigger("reveal:close")});if(e.closeonbackgroundclick){s.css({cursor:"pointer"});s.bind("click.modalEvent",function(){t.trigger("reveal:close")})}$("body").keyup(function(e){if(e.which===27){t.trigger("reveal:close")}})})}

})(jQuery);