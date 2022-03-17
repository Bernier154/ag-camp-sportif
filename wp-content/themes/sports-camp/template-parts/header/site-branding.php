<div class="header-branding">
    <?php
    $isFrontPage = is_front_page();
    $title = $isFrontPage ? get_bloginfo('name', 'display') : single_post_title('', false); ?>
    <h1 class="header-title"><?php if ($isFrontPage) : ?><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php endif; ?><?= $title ?><?php if ($isFrontPage): ?></a><?php endif; ?></h1>
    <?php
    $description = get_bloginfo('description', 'display');
    if ($isFrontPage && ($description || is_customize_preview())) : ?>
        <p class="header-subtitle"><?php echo $description; ?></p>
    <?php endif; ?>
</div>
