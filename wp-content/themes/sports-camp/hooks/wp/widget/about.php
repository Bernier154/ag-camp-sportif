<?php

add_action('widgets_init', 'sports_camp_widgets_widget_about', 11);

function sports_camp_widgets_widget_about() {
    register_sidebar([
        'name' => __("About us", 'sports_camp'),
        'id' => "about-us",
        'description' => __('Add widgets here to fill the "about us" section', 'sports_camp'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ]);
}
