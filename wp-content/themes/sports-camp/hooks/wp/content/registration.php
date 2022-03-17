<?php

add_action('init', 'sports_camp_create_post_type');

function sports_camp_create_post_type() {
    $postTypesData = sports_camp_get_content_types_data();

    add_theme_support( 'post-thumbnails' );

    foreach ($postTypesData as $type => $data) {
        $definition = $data['definition'] ?? [];
        $definition['supports'] = $data['supports'] ?? [];
        $definition['taxonomies'] = $data['taxonomies'] ?? [];

        $fields = $data['fields'] ?? [];

        $definition['labels'] = array_key_exists('labels', $definition) ? $definition['labels'] : (function () use ($type) {
            $humanReadable = ucfirst(implode(' ', explode('-', str_replace('_', '-', $type))));
            return [
                'name' => __(ucfirst(sports_camp_str_pluralize($humanReadable))),
                'singular_name' => __(ucfirst(sports_camp_str_singularize($humanReadable))),
                'add_new_item' => __('Add New ' . sports_camp_str_singularize($humanReadable)),
                'edit_item' => __('Edit ' . sports_camp_str_singularize($humanReadable)),
                'new_item' => __('New ' . sports_camp_str_singularize($humanReadable)),
                'view_item' => __('View ' . sports_camp_str_singularize($humanReadable)),
                'view_items' => __('View ' . sports_camp_str_pluralize($humanReadable)),
                'search_items' => __('Search ' . sports_camp_str_pluralize($humanReadable)),
                'not_found' => __('No ' . sports_camp_str_pluralize($humanReadable) . ' found.'),
                'not_found_in_trash' => __('No ' . sports_camp_str_pluralize($humanReadable) . ' found in Trash.'),
                'all_items' => __('All ' . sports_camp_str_pluralize($humanReadable)),
                'archives' => __(ucfirst(sports_camp_str_singularize($humanReadable)) . ' Archives'),
                'attributes' => __(ucfirst(sports_camp_str_singularize($humanReadable)) . ' Attributes'),
                'insert_into_item' => __('Insert into ' . sports_camp_str_singularize($humanReadable)),
                'uploaded_to_this_item' => __('Uploaded to this ' . sports_camp_str_singularize($humanReadable)),
                'filter_items_list' => __('Filter ' . sports_camp_str_pluralize($humanReadable) . ' list'),
                'items_list_navigation' => __(ucfirst(sports_camp_str_pluralize($humanReadable)) . ' list navigation'),
                'items_list' => __(ucfirst(sports_camp_str_pluralize($humanReadable)) . ' list'),
            ];
        })();

        register_post_type($type, $definition);

        add_post_type_support($type, $definition['supports']);

        sports_camp_register_fields($type, $fields);
    }
}
