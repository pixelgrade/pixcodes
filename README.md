[![Build Status](https://travis-ci.org/pixelgrade/pixcodes.svg?branch=development)](https://travis-ci.org/pixelgrade/pixcodes)

***PixCodes*** Is a WordPress plugin which offers you a nice "Add shortcode" button in your editor which opens a modal with a list of shortcodes to add in editor.

PixCodes is build to be controlled by the theme, we needed a plugin which allows the themes to select which shortcodes they support and provide style for.

So beside having an awesome shortcodes insert interface, PixCodes offers you a way for theme developers to: 
- Select which shortcodes you want.[>>>](#select_shortcodes)
- Edit the HTML markup of each shortcode.[>>>](#overwrite_templates)
- Add/remove attributes.[>>>](#edit_params)

**Filter shortcodes<a name="select_shortcodes"></a>**

The shortcodes list is kept in the database as a Wordpress option under the `wpgrade_shortcodes_list`.

So if you want to edit the shortcode list you will need to add this to your functions.php or somewhere in your theme:

```
function edit_pixcodes_shortcodes_list() {
  if ( ! is_admin() ) { //only admins should do this
    return; 
  }
  
  // create an array with the names of the shortcodes you want
  $shortcodes = array(
    'Button',
    'Quote',
    'Icon',
    'Columns',
    'Slider',
    'Tabs'
  );
  update_option( 'wpgrade_shortcodes_list', $shortcodes );
}
add_action( 'admin_head', 'edit_pixcodes_shortcodes_list' );
```

Now check again the PixCodes modal.

**Shortcode Templates<a name="overwrite_templates"></a>**

Each shortcode has his own template in the plugin's folder `shortcodes/templates` the awesome part of this is that you can overwrite them inside your theme.

So if you don't like the html template of the button just copy your shortcode file from `pixcodes/shortcodes/templates/button.php` into your theme at `theme/templates/shortcodes/button.php`.

Now anything you put in your theme's file button.php will be outputted when in the editor there will be an `[button]` shortcode.

**Edit shortcode parameters<a name="edit_params"></a>**

Each shortcode has(or not) a set of parameters which they will be parsed as attributes in the WordPress editor.

You may want the add or remove some of these params so we offer a way to do it.

Let's say that for the button shortcode you want a new attribute named "Title".

In this case you should use the `pixcodes_filter_params_for_{shortcode}` filter.

For the button shortcode, you should add this filter to your theme (maybe functions.php)
```
add_filter('pixcodes_filter_params_for_button', 'pixcodes_edit_button_params', 10, 1);

function pixcodes_edit_button_params( $params ){
  $params['title'] = array(
		'type'        => 'text',
		'name'        => 'Title'
	);
			
	return $params;
}
```
