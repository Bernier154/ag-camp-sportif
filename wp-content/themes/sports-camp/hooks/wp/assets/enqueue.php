<?php

add_action('wp_enqueue_scripts', 'sports_camp_enqueue_styles');

/**
 * Enqueue parent style and its own style and script.
 */
function sports_camp_enqueue_styles() {
    wp_deregister_script('jquery');
    wp_enqueue_style('parent-base-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('sports-camp-style', get_stylesheet_directory_uri() . sports_camp_mix('/css/app.css'));
    wp_enqueue_script('jquery', get_stylesheet_directory_uri() . sports_camp_mix('/js/jquery.js'));
    wp_enqueue_script('sports-camp-script', get_stylesheet_directory_uri() . sports_camp_mix('/js/app.js'), ['jquery']);
}
