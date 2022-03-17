<?php if (has_nav_menu('social')) : ?>
    <nav class="footer-social-menu" role="navigation"
         aria-label="<?php esc_attr_e('Footer Social Links Menu', 'sports_camp'); ?>">
        <?php
        wp_nav_menu([
            'theme_location' => 'social',
            'menu_class' => 'social-links-menu',
            'depth' => 1,
            'link_before' => '<span class="screen-reader-text">',
            'link_after' => '</span>' . twentyseventeen_get_svg(array('icon' => 'chain')),
        ]);
        ?>
    </nav>
<?php endif;
