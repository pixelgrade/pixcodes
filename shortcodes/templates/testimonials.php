<?php

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