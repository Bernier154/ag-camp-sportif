<?php get_header(); ?>
<?php foreach (['activities', 'layers', 'about-us'] as $section): ?>
    <section class="section section-<?= $section ?>">
        <?php get_template_part("template-parts/home/$section") ?>
    </section>
<?php endforeach; ?>
<?php get_footer(); ?>
