<a href="<?php if ( !empty($link) ) echo $link ?>" class="btn 
  <?php if ( !empty($size)) echo 'btn--'.$size ?> 
  <?php if ( !empty($text_size)) echo 'btn--'.$text_size ?> 
  <?php if ( !empty($class) ) echo $class ?>" 
  <?php if ( !empty($id) ) echo 'id="'.$id.'"' ?> 
  <?php if ( !empty( $newtab ) ) echo 'target="_blank"'; ?>>
	<?php if ( !empty($content) ) {
		echo $this->get_clean_content( $content );
	} ?>
</a>