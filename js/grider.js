(function() {
	tinymce.PluginManager.add( 'pixcodes_grider', function( editor, url ) {

		function replaceShortcodes( content ) {

			var mceDefaultAtts = '',
				mceDefaultClasses = 'mceItem';

			var new_content = wp.shortcode.replace('row', content, function (args) {
				// console.log(args);
				var rowSh = wp.template( "pixcodes-grider-row" );

				return rowSh({
						content: unAutoP(args.content),
						classes: mceDefaultClasses
					});
				 //'<div class="row ' + mceDefaultClasses + '" data-sh-tag="row" data-sh-attr-cols_nr="" ' + mceDefaultAtts + '>' + args.content + '</div>';
			});


			new_content = wp.shortcode.replace('col', new_content, function (args) {
				// console.log(args);
				var colSh = wp.template( "pixcodes-grider-col" );

				return colSh({
					content: args.content,
					classes: mceDefaultClasses
				});
				//return '<div class="col ' + mceDefaultClasses + '" data-sh-tag="col" data-sh-attr-size="" ' + mceDefaultAtts + '>' + args.content + '</div>';
			});

			return new_content;
		}

		function restoreShortcodes( content ) {
			// function getAttr( str, name ) {
			// 	name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str );
			// 	return name ? window.decodeURIComponent( name[1] ) : '';
			// }
			// content = content.replace( /<div\s+class="col">[\S\s]*?<\/div>/g, function( match, cont, x ) {
			// 	return '<p>[col]' + match + '[/col]</p>';
			// });

			// console.log( content );

			var div = document.createElement('div');

			div.innerHTML = content;

			var rows = div.querySelectorAll('.row.mceItem');

			var to_replaceR = '';

			for( var indexR = 0; indexR < rows.length; indexR++ ) {
				to_replaceR = '<p>[row]</p>' +  rows[indexR].innerHTML + '<p>[/row]</p>';
				content = content.replace( rows[indexR].outerHTML, to_replaceR );
			}


			var cols = div.querySelectorAll('.col.mceItem');

			var to_replaceC = '';
			for( var indexC = 0; indexC < cols.length; indexC++ ) {
				to_replaceC = '<p>[col]</p>' +  cols[indexC].innerHTML + '<p>[/col]</p>';
				content = content.replace( cols[indexC].outerHTML, to_replaceC );
			}


			return content; //'<p>[row]</p>' +  parsedContent.innerHTML + '<p>[/row]</p>';

		}

		// function renderGrider( content ) {
		// 	var col, frame, data;
		//
		// 	// Check if the `wp.media` API exists.
		// 	if ( typeof wp === 'undefined' || ! wp.media ) {
		// 		return;
		// 	}
		//
		// 	data = window.decodeURIComponent( editor.dom.getAttrib( content, 'data-wp-media' ) );
		//
		// 	console.log(data);
		//
		// 	// Make sure we've selected a col content.
		// 	if ( editor.dom.hasClass( content, 'wp-col' ) && wp.media.col ) {
		// 		col = wp.media.col;
		// 		frame = col.edit( data );
		//
		// 		frame.state('col-edit').on( 'update', function( selection ) {
		// 			var shortcode = col.shortcode( selection ).string();
		// 			editor.dom.setAttrib( content, 'data-wp-media', window.encodeURIComponent( shortcode ) );
		// 			frame.detach();
		// 		});
		// 	}
		// }
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('...');
		// editor.addCommand( 'WP_Grider', function() {
		// 	renderGrider( editor.getContent() );
		// });
		//
		// editor.on( 'mouseup', function( event ) {
		// 	var dom = editor.dom,
		// 		node = event.target;
		//
		// 	function unselect() {
		// 		dom.removeClass( dom.select( 'img.wp-media-selected' ), 'wp-media-selected' );
		// 	}
		//
		// 	if ( node.nodeName === 'IMG' && dom.getAttrib( node, 'data-wp-media' ) ) {
		// 		// Don't trigger on right-click
		// 		if ( event.button !== 2 ) {
		// 			if ( dom.hasClass( node, 'wp-media-selected' ) ) {
		// 				editMedia( node );
		// 			} else {
		// 				unselect();
		// 				dom.addClass( node, 'wp-media-selected' );
		// 			}
		// 		}
		// 	} else {
		// 		unselect();
		// 	}
		// });
		// Display col, audio or video instead of img in the element path
		// editor.on( 'ResolveName', function( event ) {
		// 	var dom = editor.dom,
		// 		node = event.target;
		//
		// 	if ( node.nodeName === 'IMG' && dom.getAttrib( node, 'data-wp-media' ) ) {
		// 		if ( dom.hasClass( node, 'wp-col' ) ) {
		// 			event.name = 'col';
		// 		}
		// 	}
		// });

		editor.on( 'BeforeSetContent', function( event ) {
			// console.log(event.content);
			event.content = unAutoP(event.content);
			// console.log(event.content);
			event.content = replaceShortcodes( event.content );
			// console.log(event.content);
		});

		editor.on( 'PostProcess', function( event ) {
			// console.log( event.content );
			if ( event.content ) {
				var restored = event.content = restoreShortcodes( event.content );
				// console.log( restored );
			}
		});

		//helper functions
		function getAttr(s, n) {
			n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
			return n ?  window.decodeURIComponent(n[1]) : '';
		};

		/**
		 * Strip 'p' and 'br' tags, replace with line breaks.
		 *
		 * Reverses the effect of the WP editor autop functionality.
		 *
		 * @param {string} content Content with `<p>` and `<br>` tags inserted
		 * @return {string}
		 */
		var unAutoP = function ( content ) {
			if ( switchEditors && switchEditors.pre_wpautop ) {
				content = switchEditors.pre_wpautop( content );
			}

			return content;
		};
	});
})();