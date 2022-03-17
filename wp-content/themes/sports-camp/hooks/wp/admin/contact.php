<?php

function sports_camp_get_contact_info_options_data() {
    return [
        'prefix' => 'contact_',
        'section' => [
            'name' => 'Contact info',
            'id' => 'info'
        ],
        'data' => [
            'name' => 'Name',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'phone' => 'Phone',
            'email' => 'Email'
        ]
    ];
}

add_action('customize_register', 'sports_camp_customize_register_contact', 11);

function sports_camp_customize_register_contact(WP_Customize_Manager $wp_customize) {
    $data = sports_camp_get_contact_info_options_data();
    $contactData = $data['data'];

    $contactPrefix = $data['prefix'];
    $contactSectionId = $data['section']['id'];
    $contactSectionName = $data['section']['name'];

    $wp_customize->add_section($contactSectionId, [
        'title' => __($contactSectionName, 'sports_camp'),
        'priority' => 30
    ]);

    foreach ($contactData as $key => $label) {
        $wp_customize->add_setting("$contactPrefix$key", [
            'transport' => 'postMessage',
            'default' => $wp_customize->get_setting("$contactPrefix$key")
        ]);

        $wp_customize->add_control("$contactPrefix$key", [
            'label' => __($label, 'sports_camp'),
            'section' => $contactSectionId,
            'type' => 'text'
        ]);

        $wp_customize->selective_refresh->add_partial("$contactPrefix$key", [
            'selector' => '.contact-info'
        ]);
    }
}


function sports_camp_get_contact_info() {
    $data = sports_camp_get_contact_info_options_data();
    $prefix = $data['prefix'];
    array_walk($data['data'], function (&$value, $key) use ($prefix) {
        $value = get_theme_mod("$prefix$key", '');
    });

    return $data['data'];
}
