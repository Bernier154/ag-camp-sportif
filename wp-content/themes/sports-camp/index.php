<?php get_header();


if (have_posts()) {
    while (have_posts()) : the_post();
        get_template_part('template-parts/post/content', get_post_format());
    endwhile;
    the_post_navigation([
        'prev_text' => '%title',
        'next_text' => '%title',
    ]);
} else {
    get_template_part('template-parts/post/content', 'none');
}
get_footer();
