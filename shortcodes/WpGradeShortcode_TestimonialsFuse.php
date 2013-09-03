<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_TestimonialsFuse extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = true;
        $this->direct = false;
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
        // $this->frontend_assets["js"] = array(
        //     'columns' => array(
        //         'name' => 'frontend_testimonials',
        //         'path' => 'js/shortcodes/frontend_testimonials.js',
        //         'deps'=> array( 'jquery' )
        //     )
        // );
        // add_action('wp_footer', array($this, 'load_frontend_assets'));
    }

    public function add_shortcode($atts){

        $this->load_frontend_scripts = true;

        // init vars
        $number = -1;
        $orderby = 'menu_order';
        $order = 'ASC';
	    $class = '';
         extract( shortcode_atts( array(
             'number' => '-1',
             'order' => 'ASC',
             'orderby' => 'menu_order',
             'include' => '',
             'exclude' => '',
	         'class' => ''
         ), $atts ) );

        ob_start();

        $query_args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => $number,
            'orderby' => $orderby,
            'order' => $order
        );

         if ( !empty( $include ) ) {
             $include_array = explode( ',', $include );
             $query_args['post__in'] = $include_array;
         }

         if ( !empty( $exclude ) ) {
             $exclude_array = explode( ',', $exclude );
             $query_args['post__not_in'] = $exclude_array;
         }

        $query = new WP_Query($query_args);

        if ( $query-> have_posts() ) : ?>
            <div class="unwrap <?php echo $class; ?>">
                <div class="testimonials-slider">
                <ul class="testimonials-list slides">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li class="testimonials-list-item row slide">
                        <?php
                            $author_name = get_post_meta(get_the_ID(), WPGRADE_PREFIX. 'author_name', true);
                            $author_function = get_post_meta(get_the_ID(), WPGRADE_PREFIX. 'author_function', true);
                            $author_link = get_post_meta(get_the_ID(), WPGRADE_PREFIX. 'author_link', true);
                        ?>
                        <div class="main main-testimonial">
                            <div class="block-inner block-inner_first">
                                <div class="testimonial-content">
                                    <b class="testimonial-quotemark">&#8220;</b>
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                        <?php if(!empty($author_link)) { ?>
                            <a class="side side-testimonial" href="<?php echo $author_link; ?>" target="_blank">
                        <?php } else { ?>
                        <div class="side side-testimonial">
	                        <?php }
	                            if ( has_post_thumbnail() ) {
	                                $thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>
	                                <span class="testimonial-avatar"><img src="<?php echo $thumb_url; ?>" alt="<?php echo !empty($author_name) ? $author_name : ""; ?>" /></span>
	                            <?php } ?>
	                            <div class="testimonial-author">
	                                <?php if ( !empty($author_name)) { ?>
	                                    <div class="testimonial-author_name"><?php echo $author_name; ?></div>
	                                <?php } if ( !empty($author_function) ) {?>
	                                    <div class="testimonial-author_position"><?php echo $author_function; ?></div>
	                                <?php } ?>
	                            </div>
	                        <?php if(!empty($author_link)) { ?>
	                        </a>
	                        <?php } else { ?>
                        </div>
                        <?php } ?>
                    </li>
                <?php endwhile;?>
                </ul>
                </div>
            </div>
        <?php endif; wp_reset_query();
        return ob_get_clean();
    }
}