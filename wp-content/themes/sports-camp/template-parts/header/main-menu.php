<?php if (has_nav_menu('top')) : ?>
    <div class="header-menu-wrapper">
        <nav class="header-menu" role="navigation" aria-label="<?php esc_attr_e('Top Menu', 'twentyseventeen'); ?>">
            <div class="header-menu-left">
                <?php the_custom_logo(); ?>
            </div>
            <div class="header-menu-right">
                <span class="burger-menu"></span>
                <?php wp_nav_menu([
                    'theme_location' => 'top',
                    'menu_id' => 'top-menu',
                    'class' => 'burger-close'
                ]); ?>
            </div>
        </nav>
    </div>
<?php endif; ?>