<?php

add_action('widgets_init', 'sports_camp_widgets_default', 11);

function sports_camp_widgets_default() {
    for ($i = 1; $i <= 3; $i++) {
        unregister_sidebar("sidebar-$i");
    }
}
