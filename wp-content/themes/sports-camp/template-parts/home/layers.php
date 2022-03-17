<?php
$layers = sports_camp_database_query_home_layers();
if ($layers->have_posts()): ?>
    <section class="home-layers">
        <?php while ($layers->have_posts()): $layers->the_post(); ?>
            <article class="home-layer">
                <div class="home-layer-image-wrapper"><?php the_post_thumbnail() ?></div>
                <div class="home-layer-content-wrapper">
                    <h2 class="home-layer-title"><?php the_title() ?></h2>
                    <p class="home-layer-content"><?php the_excerpt() ?></p>
                    <a class="home-layer-see-more-link" href="<?= get_permalink() ?>"><?= __('En savoir plus', 'sports_camp') ?></a>
                </div>
            </article>
        <?php endwhile; ?>
    </section>
<?php endif; ?>