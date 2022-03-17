<?php get_header(); ?>

<h2 class="home-activities-title activity-single">Les informations de cette actitivité</h2>
<?php
while (have_posts()) : the_post();
    $postType = get_post_type();
    if (in_array($postType, sports_camp_get_content_types())) {
        get_template_part('template-parts/' . $postType . '/detail');
    } else {
        get_template_part('template-parts/post/content', get_post_format());
    }
    //the_post_navigation([
       // 'prev_text' => '%title',
        //'next_text' => '%title',
    //]);
endwhile;
?>
<section class="section-info">
    <ul class="list-wrapper">
        <li class="list-element">
            <p class="list-field"><?php the_field('info1')?></p>
        </li>
        <li class="list-element">
            <p class="list-field"><?php the_field('info2')?></p>
        </li>
        <li class="list-element">
            <p class="list-field"><?php the_field('info3')?></p>
        </li>
        <li class="list-element">
            <p class="list-field"><?php the_field('info4')?></p>
        </li>
    </ul>
</section>


<?php get_footer();
