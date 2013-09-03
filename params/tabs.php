<?php
$class= "span12";

if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

<div class="<?php echo $class; ?> param-tabs" >
    <ul class="tabs-heads">
        <li data-index="1"><a href="#t1">Tab 1</a></li>
        <li data-index="0"><a href="#t-last">New Tab</a></li>
    </ul>

    <div id="t1" class="tab" data-tab="1">
        <input type="text" class="tab_title" placeholder="Title"/>
        <input type="text" class="tab_icon"placeholder="Font Awesome Icon Class" /><a class="tip_icon"  title="See the list with all icons classes" href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank"><i class="icon-external-link"></i></a>
        <textarea class="tab_content" placeholder="Content" rows="10"></textarea>
    </div>

    <div id="t-last" class="tab" data-tab="0">
        <p>Plast</p>
    </div>

</div>
<input type="hidden" name="<?php echo $param['param_key'] ?>" />