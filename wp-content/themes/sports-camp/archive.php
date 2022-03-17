<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <meta class="foundation-mq">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="site-wrapper">
    <header class="header" role="banner" style="background-image:url(<?= sports_camp_get_header_image_url() ?>">
        <?php get_template_part('template-parts/header/main', 'menu'); ?>
        <div class="header-branding">
            <h1 class="header-title">Des activités variées</h1>

        </div>
    </header>
    <div class="site-content">
        <section class="section section-activities">
<?php

global $wp_query;
$queryObjectName = $wp_query->get_queried_object()->name;
if (in_array($queryObjectName, sports_camp_get_content_types())) :
    $plural = sports_camp_str_pluralize($queryObjectName);
    $$plural = $wp_query;

    include(locate_template('template-parts/' . $queryObjectName . '/list.php'));
else : ?>

        </section>




    <div class="wrap">

        <?php if (have_posts()) : ?>
            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="taxonomy-description">', '</div>');
                ?>
            </header><!-- .page-header -->
        <?php endif; ?>

        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php
                if (have_posts()) : ?>
                    <?php
                    /* Start the Loop */
                    while (have_posts()) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part('template-parts/post/content', get_post_format());

                    endwhile;

                    the_posts_pagination(array(
                        'prev_text' => twentyseventeen_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous page', 'twentyseventeen') . '</span>',
                        'next_text' => '<span class="screen-reader-text">' . __('Next page', 'twentyseventeen') . '</span>' . twentyseventeen_get_svg(array('icon' => 'arrow-right')),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentyseventeen') . ' </span>',
                    ));

                else :

                    get_template_part('template-parts/post/content', 'none');

                endif; ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->
<?php endif; ?>
<?php get_footer(); ?>
