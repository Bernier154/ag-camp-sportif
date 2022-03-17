<?php

add_action('admin_menu', 'sports_camp_remove_normal_excerpt');

function sports_camp_remove_normal_excerpt() {
    foreach (sports_camp_get_content_types() as $postType) {
        remove_meta_box('postexcerpt', $postType, 'normal');
    }
}


add_action('add_meta_boxes', 'sports_camp_add_excerpt_meta_box');

function sports_camp_add_excerpt_meta_box($post_type) {
    if (in_array($post_type, array_merge(['post', 'page'], sports_camp_get_content_types()))) {
        add_meta_box(
            'sports_camp_postexcerpt',
            __('Excerpt', 'thetab-theme'),
            'post_excerpt_meta_box',
            $post_type,
            'after_title',
            'high'
        );
    }
}


add_action('edit_form_after_title', 'sports_camp_run_after_title_meta_boxes');

function sports_camp_run_after_title_meta_boxes() {
    global $post;
    do_meta_boxes(get_current_screen(), 'after_title', $post);
}


add_action('init', 'sports_camp_allow_attachment_to_use_categories');

function sports_camp_allow_attachment_to_use_categories() {
    register_taxonomy_for_object_type('category', 'attachment');
}


add_action('init', 'sports_camp_set_attachment_custom_date');

function sports_camp_set_attachment_custom_date() {
    sports_camp_register_fields('attachment', [
        [
            'name' => 'date',
            'type' => 'date_picker',
            'required' => false
        ]
    ]);
}


add_action('init', 'sports_camp_set_videos_and_photos_page_field');

function sports_camp_set_videos_and_photos_page_field() {
    sports_camp_register_fields('page', [
        [
            'name' => 'separation',
            'type' => 'select',
            'required' => false,
            'choices' => [
                'day' => 'Day',
                'week' => 'Week',
                'month' => 'Month',
                'season' => 'Season',
                'year' => 'Year'
            ]
        ]
    ], [
        [
            'param' => 'post',
            'operator' => '==',
            'value' => sports_camp_get_media_page_id()
        ]
    ]);
}
