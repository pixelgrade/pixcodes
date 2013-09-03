<?php $class= "span12";

if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];?>

<span class="<?php echo $class; ?>" >
    <label for="<?php echo $param['param_key'] ?>"><?php echo $param['name'] ?></label>
    <input type="text" name="<?php echo $param['param_key'] ?>" class="wpgrade-colorpicker"/>
</span>