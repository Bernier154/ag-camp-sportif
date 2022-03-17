<?php

add_action('widgets_init', 'sports_camp_widgets_widget_contact', 11);

function sports_camp_widgets_widget_contact() {
    register_sidebar([
        'name' => __("Contact us", 'sports_camp'),
        'id' => "contact-us",
        'description' => __('Add widgets here to fill the "contact us" section', 'sports_camp'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ]);
}
