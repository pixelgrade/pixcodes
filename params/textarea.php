<?php
$class= "span12";
if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];
$is_content = '';
if ( isset($param['is_content'] ) ) $is_content = 'class="is_shortcode_content"';
$rows = 3;
if ( isset($param['rows'] ) ) $rows = $param['rows'];
?>

    <span class="<?php echo $class; ?>" >
        <?php if (!empty($param['name'])) :?>
	    <label for="<?php echo $param['param_key'] ?>"><?php echo $param['name'] ?></label>
	    <?php endif; ?>
        <textarea type="<?php echo $param['type'] ?>" name="<?php echo $param['param_key'] ?>" rows="<?php echo $rows ?>" <?php echo $is_content ?> ><?php if ( isset($param['predefined'] ) ) echo $param['predefined'] ?></textarea>
    </span>