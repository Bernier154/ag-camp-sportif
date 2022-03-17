<?php

function sports_camp_get_content_types() {
    global $sportsCampPostTypes;
    return array_keys($sportsCampPostTypes);
}

function sports_camp_get_content_types_data() {
    global $sportsCampPostTypes;
    return $sportsCampPostTypes;
}

function sports_camp_get_content_type_data($contentType) {
    $data = sports_camp_get_content_types_data();
    return array_key_exists($contentType, $data) ? $data[$contentType] : [];
}

function sports_camp_register_fields($post_type, $fields, $conditions = []) {
    if (function_exists('register_field_group')) {
        foreach ($fields as &$field) {
            $field['key'] = $field['name'];
            $field['type'] = array_key_exists('type', $field) ? $field['type'] : 'text';
            $field['label'] = __(array_key_exists('label', $field) ? $field['label'] : ucfirst(str_replace('_', ' ', $field['name'])));
            $field['required'] = !array_key_exists('required', $field) || $field['required'];
        }

        register_field_group([
            'group' => 'field_group_' . uniqid(),
            'title' => $post_type,
            'fields' => $fields,
            'location' => [array_merge([[
                'param' => 'post_type',
                'operator' => '==',
                'value' => $post_type
            ]], $conditions)]
        ]);
    }
}

function sports_camp_get_media_page_id() {
    return get_theme_mod(sports_camp_get_media_page_id_key());
}

function sports_camp_set_media_page_id($id) {
    set_theme_mod(sports_camp_get_media_page_id_key(), $id);
}

function sports_camp_get_media_page_id_key() {
    return 'sports_camp_media_page_id';
}