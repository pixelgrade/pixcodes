<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Quote extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Quote";
        $this->code = "quote";
        $this->icon = "icon-quote-right";
        $this->direct = false;

        $this->params = array(
            'content_text' => array(
                'type' => 'textarea',
                'name' => 'Text',
                'admin_class' => 'span12',
                'is_content' => true
            ),
            'author' => array(
                'type' => 'text',
                'name' => 'Author',
                'admin_class' => 'span6',
            ),
            'link' => array(
                'type' => 'text',
                'name' => 'Link',
                'admin_class' => 'span5 push1'
            ),
        );

        add_shortcode('quote', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
			'content_text' => '',
			'author' => '',
			'link' => '',
        ), $atts ) );
        ob_start(); 
		?><div class="testimonial shc">
            <blockquote>
                <?php echo $this->get_clean_content($content);
                if(!empty($author)) {
					echo '<div class="testimonial_author">'; 
					if(!empty($link)) {
						echo '<a href="'.$link.'">';
					}
					echo '<span class="author_name">'.$author.'</span>';
                    if(!empty($link)) {
						echo '</a>';
                    }
					echo '</div>';
				} ?>
			</blockquote>
		</div><?php 
		return ob_get_clean();
    }
}
