<article class="activity activity-excerpt">
    <figure class="activity-icon-wrapper">
        <?= wp_get_attachment_image(get_field('icon', false)) ?>
        <figcaption class="activity-title"><?php the_title() ?></figcaption>
    </figure>
    <section class="activity-content-wrapper">
        <?php the_excerpt(); ?>
    </section>
    <nav class="activity-link-wrapper">
        <a class="activity-link" href="<?= get_permalink() ?>"><?= __('En savoir plus', 'sports-camp') ?></a>
    </nav>
</article>
