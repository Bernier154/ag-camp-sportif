<?php get_header();
while (have_posts()) : the_post();
    if (locate_template(['template-parts/page/' . get_post()->post_name . '/index.php']) != '') {
        get_template_part('template-parts/page/' . get_post()->post_name . '/index');
    } else {
        get_template_part('template-parts/page/content', 'page');
    }
endwhile;

get_footer();
