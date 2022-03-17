<?php

function sports_camp_database_query_home_layers() {
    return new WP_Query([
        'post_type' => 'any',
        'post__in' => get_theme_mod('home_layers'),
        'orderby' => 'post__in'
    ]);
}
