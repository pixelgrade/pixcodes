<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_DividerCityHub extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Divider";
        $this->code = "hr";
        $this->icon = "icon-fire";
        $this->direct = false;

        $this->params = array(
            'align' => array(
                'type' => 'select',
                'name' => 'Alignment',
                'options' => array('center' => 'Center', 'left' => 'Left', 'right' => 'Right'),
                'admin_class' => 'span6'
            ),
            // 'size' => array(
            //     'type' => 'select',
            //     'name' => 'Size',
            //     'options' => array('' => 'Regular', 'double' => 'Double'),
            //     'admin_class' => 'span6'
            // ),
            'color' => array(
                'type' => 'select',
                'name' => 'Color',
                'options' => array('' => 'Dark', 'light' => 'Light', 'color' => 'Color'),
                'admin_class' => 'span5 push1'
            )
        );

        add_shortcode('hr', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
			'align' => '',
            'size' => '',
            'weight' => '',
            'color' => '',
        ), $atts ) );
        ob_start(); ?><hr class="separator <?php echo $align.' '.$color;?>"><?php 
		return ob_get_clean();
    }
}
