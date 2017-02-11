<?php
$class= "span12";

if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];
$is_content = '';
if ( isset($param['is_content'] ) ) $is_content = 'class="is_shortcode_content"'; ?>

    <span class="<?php echo $class; ?> input-tags" >
        <label for="<?php echo $param['param_key'] ?>"><?php echo $param['name'] ?></label>
        <select type="<?php echo $param['type'] ?>" name="<?php echo $param['param_key'] ?>" <?php echo $is_content ?> value="<?php echo implode(',', $param['value'] ); ?>" data-options='<?php echo json_encode($param['options']); ?>'></select>
    </span>