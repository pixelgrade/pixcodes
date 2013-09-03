<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_ProgressBar extends WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Progress Bar";
        $this->code = "bar";
        $this->icon = "icon-tasks";
        $this->direct = false;

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
                'admin_class' => 'span8'
            ),
	        'markers' => array(
		        'type' => 'switch',
		        'name' => 'Markers',
		        'admin_class' => 'span2 push1'
	        ),
            'progress' => array(
                'type' => 'text',
                'name' => 'Progress',
                'admin_class' => 'span3'
            ),
	        array(
		        'type' => 'info',
		        'value' => 'You can use a simple number to represent the length in pixels or a percentage value (like 96%).',
		        'admin_class' => 'span8 push1'
	        )
        );

        add_shortcode('bar', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
            'title' => '',
			'progress' => '50%',
			'markers' => true,
        ), $atts ) );
        ob_start(); ?>
        <div class="progressbar">
            <?php if ($title): ?>
                <div class="progressbar-title"><?php echo $title; ?></div>
            <?php endif; ?>
            <div class="progressbar-bar">
                <div class="progressbar-progress" data-value="<?php echo $progress ?>">
                    <div class="progressbar-tooltip"><?php echo $progress ?></div>
                </div>
                <?php if ($markers == 'on') for ($i = 1; $i<=4; $i++): ?>
                    <div class="progressbar-marker" style="width:<?php echo $i*20 ?>%"></div>
                <?php endfor; ?>
            </div>
        </div>
        <?php return ob_get_clean();
    }
}
