<?php
$class= "span12";

if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

<div class="<?php echo $class; ?> param-slider" >
    <ul class="slider-heads">
        <li data-index="1"><a href="#t1">Slide 1</a></li>
        <li data-index="0"><a href="#t-last">New Slide</a></li>
    </ul>

    <div id="t1" class="slide" data-tab="1">
        <textarea class="slide_content" placeholder="Content" rows="10"></textarea>
    </div>

    <div id="t-last" class="slide" data-tab="0">
        <p>Plast</p>
    </div>

</div>
<input type="hidden" name="<?php echo $param['param_key'] ?>" />