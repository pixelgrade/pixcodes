<?php
// get the root
$plug_path = dirname( dirname( __FILE__ ) );
include_once( $plug_path . "/shortcodes.php" );
global $wpgrade_shortcodes;
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

global $post;

if ( $_GET['post_id'] ) {
	$post = get_post( $_GET['post_id'] );
} elseif ( $post === null ) {
	$post = get_post(1);
} ?>
<div id="wpgrade_shortcodes">
	<div class="l_modal_header">
		<button type="button" class="btn back"><i class="icon-reply"></i><span><?php _e( 'Back', 'pixcodes_txtd' ); ?></span></button>
		<div class="l_modal_title"><?php _e( 'Choose shortcode:', 'pixcodes_txtd' ); ?></div>
		<button type="button" class="btn close close-reveal-modal"><i class="icon-remove"></i></button>
	</div>
	<div class="l_modal_body three_col">
		<div class="details_container ">
			<div class="details_content"></div>
		</div>
		<ul class="l_three_col">
			<?php
			$shortcoces_array = $wpgrade_shortcodes->get_shortcodes();
			/**
			 * In case someone has something to say about this list
			 * here is the only place where it can be filtered
			 */
			$shortcoces_array = apply_filters( 'filter_shortcodes', $shortcoces_array, $post );

			foreach ( $shortcoces_array as $key => $shortcode ) {
				$class             = 'shortcode_' . $shortcode["name"] . '_open';
				$data_trigger_open = 'shortcode_' . $shortcode["name"] . '_open';
				$shortcode_js      = json_encode( (object) $shortcode );
				if ( $shortcode["direct"] ) {
					$class .= ' insert-direct-shortcode';
				} ?>
				<li class="shortcode">
					<a class="details <?php echo $class; ?>" data-params='<?php echo $shortcode_js; ?>' data-trigger-open="<?php echo $data_trigger_open ?>">
						<i class="icon <?php echo $shortcode["icon"]; ?>"></i>
						<span class="title"><?php echo $shortcode["name"] ?></span>
					</a>
					<?php if ( ! $shortcode['direct'] && ! empty( $shortcode['params'] ) ) { ?>
						<div class="shortcode_params details_content">
							<form id="wpgrade_shortcodes_form">
								<fieldset>
									<div class="row">
										<?php
										foreach ( $shortcode['params'] as $k => $param ) {

											// inject the key in param ... since i was too lazy to do that before
											$param['param_key'] = $k;
											echo $wpgrade_shortcodes->render_param( $param );
										} ?>

										<button type="submit" class="btn hidden"><?php _e( 'Submit', 'pixcodes_txtd' ); ?></button>
									</div>
								</fieldset>
							</form>
							<div id="data_params" type="hidden" data-params='<?php echo $shortcode_js; ?>'></div>
						</div>
					<?php } ?>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="l_modal_footer">
		<a class="btn btn_secondary close"><?php _e( 'Cancel', 'pixcodes_txtd' ); ?></a>
		<span><?php _e( 'or', 'pixcodes_txtd' ); ?></span>
		<a class="btn btn_primary disabled"><?php _e( 'Insert', 'pixcodes_txtd' ); ?></a>
	</div>
</div>