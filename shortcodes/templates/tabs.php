<?php $fade = 'fade '; ?>
<div class="pixcode  pixcode--tabs">
    <ul class="pixcode--tabs__nav  nav  nav-tabs">
        <?php
        preg_match_all( '#<title>(.*?)</title>#', $this->get_clean_content( $content ), $titles );
        $ui_tabs_keys = array();
        if ( !empty($titles) && isset($titles[1]) ) {
            foreach ( $titles[1] as $key => $title ) {
                $ui_tabs_keys[$key] = uniqid( 'ui-tab-'.$key ); ?>
                <li class="<?php if ($key == 0) { echo 'active'; } ?>">
	                <?php echo '<a href="#'.$ui_tabs_keys[$key].'" data-toggle="tab">';
	                    if (!empty($icons[$key]) ) {
		                    echo '<i class="pixcode pixcode--icon '. $icons[$key] .'"></i>';
	                    }
	                    echo $title;
	                echo '</a>'; ?>
                </li>
            <?php }
        } ?>
    </ul>
    <div class="pixcode--tabs__content  tab-content">
        <?php
        if (!empty($contents) && isset($contents[1])) {
            foreach ($contents[1] as $key => $value) { ?>
                <div class="tab-pane <?php if ($key == 0) { echo 'active'; } ?>" id="<?php echo $ui_tabs_keys[$key]; ?>">
                    <?php echo $this->get_clean_content($value) ?>
                </div>
            <?php }
        } ?>
    </div>
    <hr class="separator  separator--striped">
</div>