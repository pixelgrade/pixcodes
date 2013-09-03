<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_ColumnsFuse extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->backend_assets["js"] = array(
            'columns' => array(
                'name' => 'columns',
                'path' => 'js/shortcodes/backend_columnsFuse.js',
                'deps'=> array( 'jquery' )
            )
        );

        // load backend assets only when an editor is present
        add_action( 'mce_buttons_2', array( $this, 'load_backend_assets' ) );

        $this->self_closed = false;
        $this->name = "Grid";
        $this->code = "grid";
        $this->icon = "icon-th";
        $this->direct = false;

        $this->params = array(
            'cols_nr' => array(
                'type' => 'select',
                'name' => 'No. of columns:',
                'options' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '6' => '6'),
                'admin_class' => 'span3 strong'
            ),
//             'bg_color' => array(
//                'type' => 'color',
//                'name' => 'Background Color',
//                'admin_class' => 'span7 push1'
//            ),
//            'full_width' => array(
//                'type' => 'switch',
//                'name' => 'Full Width Background ?',
//                'admin_class' => 'span5 inline full_width_bg'
//            ),
            'cols_slider' =>array(
                'type' => 'slider',
                'name' => 'Drag handlers to change the columns width.'
            ),
            'class' => array(
                'type' => 'tags',
                'name' => 'Custom CSS Class',
                'admin_class' => 'span12',
                'options' => array( 'narrow', 'inverse'),
                'value' => array( '' )
            ),
        );

        add_shortcode('cell', array( $this, 'add_cell_shortcode'));
        add_shortcode('grid', array( $this, 'add_grid_shortcode'));
    }

    public function add_grid_shortcode($atts, $content){
        $class = '';
        $bg_color = '';

        extract( shortcode_atts( array(
            'bg_color' => '#fff',
            'full_width' => '',
            'class' => ''
        ), $atts ) );

        if ( !empty($bg_color) ) {
            if ( substr($bg_color, 0, 1 ) != '#' ) {
                $bg_color = '#'. $bg_color;
            }
        }

        ob_start(); ?>
            <div class="unwrap">
                <div class="row row-shortcode <?php echo $class; ?>">
                    <?php echo $this->get_clean_content($content); ?>
                </div>
            </div>
        <?php return ob_get_clean();
    }

    public function add_cell_shortcode($atts, $content){
        $size = '';
        $class = '';
		$col_color = '';

        extract( shortcode_atts( array(
            'size' => '12',
            'class' => '',
	        'col_color' => ''
        ), $atts ) );

        ob_start(); ?>
            <div class="span<?php echo $size ?> block <?php echo $class ?>" <?php if ( !empty($col_color) ) { echo 'style="background-color:'.'#'.$col_color.'"'; } ?> >
				 <div class="block-inner"><?php echo $this->get_clean_content( $content ); ?></div>
            </div>
        <?php return ob_get_clean();
    }
}