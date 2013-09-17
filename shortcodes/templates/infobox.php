<div class="shc shc-infobox <?php
            switch ($align){
                case 'align-left':{
                    echo 'align-left border-left';
                    break;
                }
                case 'align-right':{
                    echo 'align-right border-right';
                    break;
                }
                case 'align-center':{
                    echo 'align-center border-left-right';
                    break;
                }

                default: break;
            };
        ?>">
	<h2 class="infobox-title"><?php echo $title; ?></h2>
	<span class="infobox-subtitle"><?php echo $subtitle; ?></span>
	<span class="infobox-content"><?php echo $this->get_clean_content($content); ?></span>
</div>