<?php
$class= "span12";

if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];?>

<span class="<?php echo $class; ?>" >
    <label for="<?php echo $param['param_key'] ?>"><?php echo $param['name'] ?></label>
    <ul class="pxg_icon_list">
        <input type="hidden" name="<?php echo $param['param_key'] ?>" class="selected_icon"/>
        <?php foreach ($param["icons"] as $icon) { ?>
            <li class="icon" data-icon="<?php echo $icon; ?>"><i class="icon-<?php echo $icon; ?>"></i></li>
        <?php } ?>
    </ul>
</span>
