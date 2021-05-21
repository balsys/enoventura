<?php /** @global $PAGE */ ?>

<div id="site-header">

    <?php
        $themerenderer = $PAGE->get_renderer('theme_enoventura');
        $hasguestlangmenu = (!isset($PAGE->layout_options['langmenu']) || $PAGE->layout_options['langmenu'] );
        echo $themerenderer->render_site_header($hasguestlangmenu);
    ?>

</div>
