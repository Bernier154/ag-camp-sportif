<?php
/**
 * Template Name: dispo
 *
 */


get_header(); ?>

<main id="main" class="site-main-wrapper dispo-template">

    <?php get_template_part('parts/inc','banner') ?>
    <?php the_content() ?> 

    <div class="main-content">

        <?php 
        $terms = get_terms( array(
            'taxonomy' => 'semaine',
            'hide_empty' => false,
            'parent' => 0
        ) );  ?>

        <?php foreach($terms as $term): ?>

            <h2><?= $term->name ?></h2>
            <?php $childTerm = get_term_children($term->term_id,'semaine'); ?>

            <?php foreach($childTerm as $child): ?> 

            <?php 
                $term = get_term_by( 'id', $child, 'semaine' );
                
                $args = array(
                    'post_type'	=>	'booking',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'semaine',
                            'field'    => 'slug',
                            'terms'    => $term->slug
                        ),
                    ),
                );

                $query = new WP_Query($args); ?>
                <h3><?= $term->name ?></h3>
                <div class="grid content">
                    <?php $count = 21 ?>
                    <?php while($query->have_posts()) : $query->the_post(); ?>
                        <div class="child-wrapper">
                            <h4><?php the_title() ?></h4>
                            <?php $count -=1 ?>
                        </div>
                    <?php endwhile; ?>
                    <?php 
                        for ($i = $count; $i >= 0; $i--) {
                            echo '<div class="child-wrapper">';
                                echo '<h4>Disponible</h4>';
                            echo '</div>';
                        } 
                    ?>
                </div>

                <?php wp_reset_postdata(); ?>
            
            <?php endforeach; ?>

        <?php endforeach; ?>
    </div>


</main>
<?php  get_footer(); ?>