<?php

function sports_camp_get_header_image_url() {
    if ((is_single() || (is_page() && !twentyseventeen_is_frontpage())) && has_post_thumbnail(get_queried_object_id())) {
        return get_the_post_thumbnail_url(get_post(get_queried_object_id()));
    }

    return get_header_image();
}
