<?php
$class= "span12";
if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

<span class="<?php echo $class; ?>" >
    <label for="<?php echo $param['param_key'] ?>"><?php echo $param['name'] ?></label>
    <select name="<?php echo $param['param_key'] ?>" multiple="multiple">
        <?php
        $options = $param['options'];
        foreach ( $options as $i => $opt ) { ?>
            <option value="<?php echo $i ?>"><?php echo $opt ?></option>
        <?php } ?>
    </select>
</span>