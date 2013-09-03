<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Arrow extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->direct = true;
        $this->name = "Arrow";
        $this->code = "arrow";
        $this->icon = "icon-arrow-right";

        add_shortcode('arrow', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
			'align' => '',
            'size' => '',
            'color' => '',
        ), $atts ) );
        ob_start(); ?>
           <span class="shc-arrow"></span>
        <?php return ob_get_clean();
    }
}
