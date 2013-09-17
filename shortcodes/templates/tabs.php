<div class="row">
	<div class="span6">
		<div class="tabs-content">
			<?php
			// make all tabs unique
			$ui_tabs_keys = array();

			if ( !empty( $contents ) && isset($contents[1]) ) {
				foreach ( $contents[1] as $key => $value ) {
					$ui_tabs_keys[$key] = uniqid( 'ui-tab-'.$key ); ?>
					<div class="tabs-content-pane <?php if ( $key == 0 ) { ?>active<?php } ?>" id="<?php echo $ui_tabs_keys[$key]; ?>">
						<div class="block-inner block-text">
							<?php echo $this->get_clean_content($value) ?>
						</div>
					</div>
				<?php }
			} ?>
		</div>
	</div>
	<div class="span6">
		<div class="block-inner block-inner_last block-text">
			<ul class="nav nav-tabs tab-titles-list">
				<?php preg_match_all( '#<title>(.*?)</title>#', $this->get_clean_content( $content ), $titles );
				if ( !empty( $titles ) && isset($titles[1]) ) {
					foreach ( $titles[1] as $key => $title ) {
						//remove the prefix the fast way - faster than preg_match
						$prefix = 'icon-';
						if (substr($icons[$key], 0, strlen($prefix)) == $prefix) {
							$icons[$key] = substr($icons[$key], strlen($prefix));
						}
						?>
						<li class="tab-titles-list-item <?php if ( $key == 0 ) { ?>active<?php } ?>">
							<a href="#<?php echo $ui_tabs_keys[$key]; ?>">
								<?php if ( isset( $icons[$key] ) && !empty($icons[$key] ) ) { ?>
									<i class="icon-<?php echo $icons[$key]; ?>"></i>
								<?php }
								echo $title ?>
							</a>
						</li>
					<?php }
				} ?>
			</ul>
		</div>
	</div>
</div>