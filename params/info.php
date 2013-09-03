<?php
$class= "span12";
if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

<span class="<?php echo $class; ?>"  >
    <div class="info" >
        <?php echo $param["value"]; ?>
    </div>
</span>