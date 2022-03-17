<?php if (has_nav_menu('top')) : ?>
    <nav class="footer-main-menu" role="navigation"
         aria-label="<?php esc_attr_e('Footer Main Menu', 'sports_camp'); ?>">
        <?php
        wp_nav_menu([
            'theme_location' => 'top',
            'menu_class' => 'main-menu-menu',
            'depth' => 1,
        ]);
        ?>
    </nav>
<?php endif;
