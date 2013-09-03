<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Testimonials extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = true;
        $this->direct = false;
		$this->meta_prefix = get_option('wpgrade_metaboxes_prefix');
        $this->name = "Testimonials";
        $this->code = "testimonials";
        $this->icon = "icon-group";

        $this->params = array(
            'number' => array(
                'type' => 'text',
                'name' => 'Number of Items',
                'admin_class' => 'span6'
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span5 push1'
            ),
	        'orderby' => array(
		        'type' => 'select',
		        'name' => 'Order By',
		        'options' => array('' => '-- Default --', 'date' => 'Date', 'title' => 'Title', 'rand' => 'Random'),
		        'admin_class' => 'span6'
	        ),
	        'order' => array(
		        'type' => 'select',
		        'name' => 'Order',
		        'options' => array('' => '-- Select order --', 'ASC' => 'Ascending', 'DESC' => 'Descending'),
		        'admin_class' => 'span5 push1'
	        ),
            array(
                'type' => 'info',
                'value' => 'If you want specific testimonials, include bellow posts IDs separated by comma.'
            ),
            'include' => array(
            'type' => 'text',
            'name' => 'Include IDs',
            'admin_class' => 'span6'
            ),
                'exclude' => array(
                'type' => 'text',
                'name' => 'Exclude IDs',
                'admin_class' => 'span5 push1'
            ),
        );

        add_shortcode('testimonials', array( $this, 'add_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
        $this->frontend_assets["js"] = array(
            'columns' => array(
                'name' => 'frontend_testimonials',
                'path' => 'js/shortcodes/frontend_testimonials.js',
                'deps'=> array( 'jquery' )
            )
        );
        add_action('wp_footer', array($this, 'load_frontend_assets'));
    }

    public function add_shortcode($atts){

        $this->load_frontend_scripts = true;

        // init vars
        $number = -1;
        $orderby = 'menu_order';
        $order = 'ASC';

        // extract( shortcode_atts( array(
        //     'number' => '-1',
        //     'order' => 'DESC',
        //     'orderby' => 'date',
        //     'include' => '',
        //     'exclude' => '',
        // ), $atts ) );

        ob_start();

        $query_args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => -1,
            'orderby' => $orderby,
            'order' => $order
        );

        // if ( !empty( $include ) ) {
        //     $include_array = explode( ',', $include );
        //     $query_args['posts__in'] = $include_array;
        // }
        // if ( !empty( $exclude ) ) {
        //     $exclude_array = explode( ',', $exclude );
        //     $query_args['post__not_in'] = $exclude_array;
        // }

        $query = new WP_Query($query_args);

        if ( $query-> have_posts() ) : ?>
            <div class="testimonials_slide">
                <ul class="slides">
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <li class="slide">
                            <?php
                            $author_name = get_post_meta(get_the_ID(), WPGRADE_PREFIX. 'author_name', true);
                            $author_function = get_post_meta(get_the_ID(), WPGRADE_PREFIX. 'author_function', true);
                            $author_link = get_post_meta(get_the_ID(), WPGRADE_PREFIX. 'author_link', true);
                            ?>
                            <blockquote>
                                <div class="testimonial_content"><?php the_content(); ?></div>
                                <div class="testimonial_author">

                                <?php if(!empty($author_link)) { ?>
                                    <a href="<?php echo $author_link; ?>" target="_blank">
                                <?php }
                                    if ( !empty($author_name)) { ?>
                                    <span class="author_name"><?php echo $author_name; ?></span>
                                <?php }
                                    if ( !empty($author_function) ) {?>
                                     , <span class="author_function"><?php echo $author_function; ?></span>
                                <?php }
                                    if(!empty($author_link)) { ?>
                                   </a>
                                <?php } ?>

                                </div>
                            </blockquote>
                        </li>
                    <?php endwhile;?>
                </ul>
            </div>
        <?php endif; wp_reset_query();
        return ob_get_clean();
    }
}