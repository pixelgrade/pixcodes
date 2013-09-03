<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_PortfolioSenna extends  WpGradeShortcode {

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

	    global $wpGrade_Options,$post,$paged;

	    $boxedwrapper_start = '';
	    $boxedwrapper_end = '';
	    $boxedwrapper_plus = '';
	    $portfolio_class = '';
	    if ( $wpGrade_Options->get('portfolio_hover_style') == 'boxed_color' ) {
		    $boxedwrapper_start = '<div class="wrapper">';
		    $boxedwrapper_end = '</div>';
		    $boxedwrapper_plus = '<div class="title title-plus"><div>+</div></div>';
		    $portfolio_class .= 'portfolio_archive_boxed_color';
	    } elseif ( $wpGrade_Options->get('portfolio_hover_style') == 'classic' ) {
		    $portfolio_class .= 'portfolio_archive_classic';
	    }

	    //the width/height ratio of the sizes
	    $portfolio_ratios =
		    array(
			    'long' => 2.592,
			    'tall' => 0.649,
			    'small' => 1.299,
		    );

	    //the patterns for 6 portfolio items, 3 per row, with 9 columns grid
	    $portfolio_patterns =
		    array(
			    array('small','long','big','tall'),
			    array('big','tall','small','long'),
			    array('long','small','small','big', 'small'),
			    array('long','small','tall','big'),
			    array('small','big','small','long','small'),
			    array('long','small','tall','big'),
		    );



	    /* Start the Loop */
	    $counter = 0;
        $query = new WP_Query($query_args);
	    echo '<div class="row portfolio_archive portfolio_items '. $portfolio_class.'" data-maxpages="'.$query->max_num_pages.'">';

	    if ( !empty( $query ) ) :
		   // echo '<div class="wrapper">';
			    while ( $query->have_posts() ) : $query->the_post();
				    //Get Project Categories
				    $project_categories = '';
				    $terms = get_the_terms(get_the_ID(), 'portfolio_cat');
				    if (!empty($terms))
				    {
					    foreach ($terms as $term) {
						    $project_categories .= 'cat-'.str_replace(' ','-',$term->name).' ';
					    }
				    }

				    //add another selector class
				    $project_categories .= 'portfolio-item';
				    ?><article id="post-<?php the_ID(); ?>" <?php post_class($project_categories); ?>>
				    <ul>
					    <?php
					    // get the big image
					    $video_markup = (get_post_format() == 'video') ? '<div class="video_icon"><span></span></div>' : '';
					    $video_class = (get_post_format() == 'video') ? 'video_type' : '';
					    $video_poster = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'video_poster', true);
					    if (!empty($video_poster))
					    {
						    global $wpdb;
						    $uploads_dir_info = wp_upload_dir();
						    $temp_poster = str_replace($uploads_dir_info['baseurl'].'/', '', $video_poster);
						    $featured_image_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $temp_poster));

						    if (!empty($featured_image_id))
						    {
							    //get the rest of the gallery without the featured image
							    $attachments = get_posts( array(
								    'post_type' => 'attachment',
								    'post_mime_type' => 'image',
								    'posts_per_page' => -1,
								    'post_parent' => get_the_ID(),
								    'exclude'     => $featured_image_id
							    ) );
						    }
						    else
						    {
							    //get the rest of the gallery without the featured image
							    $attachments = get_posts( array(
								    'post_type' => 'attachment',
								    'post_mime_type' => 'image',
								    'posts_per_page' => -1,
								    'post_parent' => get_the_ID(),
							    ) );
						    }

					    }
					    elseif (has_post_thumbnail( get_the_ID() ))
					    {
						    $featured_image_id = get_post_thumbnail_id(get_the_ID());

						    //get the rest of the gallery without the featured image
						    $attachments = get_posts( array(
							    'post_type' => 'attachment',
							    'post_mime_type' => 'image',
							    'posts_per_page' => -1,
							    'post_parent' => get_the_ID(),
							    'exclude'     => $featured_image_id
						    ) );
					    }
					    else
					    {
						    //get all the images in the gallery
						    $attachments = get_posts( array(
							    'post_type' => 'attachment',
							    'post_mime_type' => 'image',
							    'posts_per_page' => -1,
							    'post_parent' => get_the_ID()
						    ) );

						    //we use the first image in the gallery for the big one
						    if (!empty($attachments[0]))
						    {
							    $featured_image_id = $attachments[0]->ID;
							    //delete the first image from the array
							    array_shift($attachments);
						    }
					    }

					    if ( !empty($attachments) )
					    {
						    //make an array with images url, width, height and ratio of width/height
						    $attachment_images = array();
						    foreach ( $attachments as $attachment )
						    {
							    $attachment_images[$attachment->ID] = wp_get_attachment_image_src($attachment->ID, 'full');
							    $attachment_images[$attachment->ID]['ratio'] = $attachment_images[$attachment->ID][1] / $attachment_images[$attachment->ID][2];
						    }

						    //lets go through the pattern and find the right images for each position
						    foreach ($portfolio_patterns[$counter%6] as $pattern )
						    {
							    //if it's not the big one, we've found that earlier
							    if ($pattern != 'big')
							    {
								    //if we still have images
								    if (!empty($attachment_images))
								    {
									    //find the best image for this size
									    $image_ID = find_closest_number($portfolio_ratios[$pattern], $attachment_images, "ratio");
									    //delete the image from the array
									    unset($attachment_images[$image_ID]);
									    $image_src = wp_get_attachment_image_src($image_ID, $pattern );
									    echo '<li class="'.$pattern.'" style="background-image:url('.$image_src[0].')">
									<a href="'.get_permalink(get_the_ID()).'">
										'.$boxedwrapper_start.$boxedwrapper_plus.'
										<div class="border"><span></span></div>
										'.$boxedwrapper_end.'</a>
									</li>';
								    }
								    else
								    {
									    echo '<li class="'.$pattern.' empty">
										<a href="'.get_permalink(get_the_ID()).'">
											'.$boxedwrapper_start.$boxedwrapper_plus.'
											<div class="border"><span></span></div>
											'.$boxedwrapper_end.'</a>
									</li>';
								    }
							    }
							    else
							    {
								    if (!empty($featured_image_id))
								    {
									    $image_src = wp_get_attachment_image_src($featured_image_id, $pattern );
									    echo '<li class="big '.$video_class.'" style="background-image:url('.$image_src[0].')">
									<a href="'.get_permalink(get_the_ID()).'">'.
										    $video_markup
										    .$boxedwrapper_start.'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
										'.$boxedwrapper_end.'
									</a>
									</li>';
								    }
								    else if (!empty($video_poster))
								    {
									    echo '<li class="big '.$video_class.'" style="background-image:url('.$video_poster.')">
									<a href="'.get_permalink(get_the_ID()).'">'.
										    $video_markup
										    .$boxedwrapper_start.'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
										'.$boxedwrapper_end.'
									</a>
									</li>';
								    }
								    else
								    {
									    echo '<li class="'.$pattern.' empty '.$video_class.'">
										<a href="'.get_permalink(get_the_ID()).'">'.
										    $video_markup
										    .$boxedwrapper_start.'<div class="title"><div><hr>'.get_the_title().'</div></div>
										<div class="border"><span></span></div>
										'.$boxedwrapper_end.'
									</a>
									</li>';
								    }
							    }
						    }
					    }
					    else
					    {
						    //we don't have any attachments except the featured image
						    if (!empty($featured_image_id))
						    {
							    $image_src = wp_get_attachment_image_src($featured_image_id, 'large' );
							    echo '<li class="xbig '.$video_class.'" style="background-image:url('.$image_src[0].')">
							<a href="'.get_permalink(get_the_ID()).'">'.
								    $video_markup
								    .$boxedwrapper_start.'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
								'.$boxedwrapper_end.'
							</a>
							</li>';
						    }
						    else if (!empty($video_poster))
						    {
							    echo '<li class="xbig '.$video_class.'" style="background-image:url('.$video_poster.')">
							<a href="'.get_permalink(get_the_ID()).'">'.
								    $video_markup
								    .$boxedwrapper_start.'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
								'.$boxedwrapper_end.'
							</a>
							</li>';
						    }
						    else
						    {
							    echo '<li class="xbig empty '.$video_class.'">
								<a href="'.get_permalink(get_the_ID()).'">'.
								    $video_markup
								    .$boxedwrapper_start.'<div class="title"><div><hr>'.get_the_title().'</div></div>
								<div class="border"><span></span></div>
								'.$boxedwrapper_end.'
							</a>
							</li>';
						    }
					    }
					    ?>
				    </ul>
				    </article><?php $counter++;
			    endwhile;
		    //echo '</div>';
	    endif;wp_reset_query();
		echo '</div>';
        return ob_get_clean();
    }
}