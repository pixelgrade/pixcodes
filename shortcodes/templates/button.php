<a href="<?php if ( !empty($link) ) echo $link ?>" class="btn <?php if ( !empty($size) && ($size == 'small' || $size == 'large') ) echo 'btn-'.$size ?> <?php if ( !empty($class) ) echo $class ?>" <?php if ( !empty($id) ) echo 'id="'.$id.'"' ?> <?php if ( !empty( $newtab ) ) echo 'target="_blank"'; ?>>
	<?php if ( !empty($content) ) {
		echo $this->get_clean_content( $content );
	} ?>
</a>