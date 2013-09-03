<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_PortfolioFuse extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = true;
        $this->direct = false;
        $this->name = "Portfolio";
        $this->code = "portfolio";
        $this->icon = "icon-qrcode";

	    // prepare categories
	    $opts_cats = get_terms('portfolio_cat', array( 'fields' => 'all' ) );
	    $all_categories = array();
	    foreach( $opts_cats as $key => $opt_cat ) {
		    $all_categories[$key] = $opt_cat->slug;
	    }

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
                'value' => 'If you want specific projects, include bellow posts IDs separated by comma.'
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
	        'category' => array(
		        'type' => 'tags',
		        'name' => 'Category',
		        'admin_class' => 'span12',
		        'options' => $all_categories,
		        'value' => array( '' )
	        ),
        );

        add_shortcode('portfolio', array( $this, 'add_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
        // $this->frontend_assets["js"] = array(
        //     'columns' => array(
        //         'name' => 'frontend_portfolio',
        //         'path' => 'js/shortcodes/frontend_portfolio.js',
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
	         'class' => '',
	         'category' => ''
         ), $atts ) );

        ob_start();

        $query_args = array(
            'post_type' => 'portfolio',
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

	    if ( !empty($category) ) {

		    $category = strtolower($category);
		    if ( strpos($category, ',') !== false ) {
			    $category = explode( ',', $category);
		    }

		    $query_args['tax_query'] = array(
			    'relation' => 'OR',
			    array(
				    'taxonomy' => 'portfolio_cat',
				    'field' => 'slug',
				    'terms' => $category
			    ),
		    );
	    }

        $query = new WP_Query($query_args);

	    if ( !empty( $query ) ) :
		    echo '<div class="unwrap">';
			    while ( $query->have_posts() ) : $query->the_post();
			    global $post; ?>

			    <div class="portfolio-row row" >
				    <?php
				    $rows = get_post_meta( $post->ID, WPGRADE_PREFIX .'portfolio_rows', true);
				    $rows = json_decode($rows, true);

				    if ( !empty($rows) ) {
					    // get only the first row
					    wpgrade_get_portfolio_row( (array)$rows[0], true);
				    } ?>
			    </div>

			    <?php endwhile;
		    echo '</div>';
	    endif;wp_reset_query();
        return ob_get_clean();
    }
}