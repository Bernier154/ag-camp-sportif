<?php

add_action('customize_register', 'sports_camp_customize_register_home_layers', 11);

function sports_camp_customize_register_home_layers(WP_Customize_Manager $wp_customize) {
    for($i = 0; $i < 4; $i++) {
        $wp_customize->add_setting("home_layers[$i]", [
            'transport' => 'postMessage',
            'default' => $wp_customize->get_setting("home_layers[$i]")
        ]);

        $wp_customize->add_control("home_layers[$i]", [
            'label' => __('Layer ' . ($i + 1), 'sports_camp'),
            'section' => 'static_front_page',
            'type' => 'dropdown-pages',
        ]);
    }
}