<?php

function sports_camp_database_query_activity_featured() {
    $query = [
        'post_type' => 'activity',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'flags',
                'compare' => 'LIKE',
                'value' => 'featured',
            ]
        ]
    ];

    return new WP_Query($query);
}
