<article <?php post_class('media-list'); ?>>
    <?php
    $attachments = sports_camp_database_query_media_with_date();
    $willSeparate = true;
    while ($attachments->have_posts()): $attachments->the_post(); ?>
        <?php if ($willSeparate): ?>
            <section class="media-separator">
            <div class="media-separator-title"><?= ucfirst(mb_convert_case($attachments->getSeparatorLabel(), MB_CASE_TITLE, 'UTF-8')) ?></div>
        <?php endif; ?>
        <article class="media-item">
            <?= wp_get_attachment_image(get_the_ID(),'full'); ?>
        </article>
        <?php if ($willSeparate = $attachments->willSeparate()): ?>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>
</article>