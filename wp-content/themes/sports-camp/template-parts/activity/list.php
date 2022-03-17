
<h2 class="home-activities-title">Les activités du camp</h2>
<?php while (isset($activities) && $activities->have_posts()) : $activities->the_post(); ?>
    <div class="activities-col">
        <?php get_template_part('template-parts/activity/excerpt'); ?>
    </div>
<?php endwhile; ?>
</section>
