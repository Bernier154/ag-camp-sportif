<?php
/**
 * Template Name: Inscriptions
 *
 */
get_header(); ?>
<main id="main" class="site-main-wrapper inscriptions-template">
    <?php get_template_part('parts/inc','banner') ?>
    <div class="content">
        <h2>Camps à venir</h2>
        <div class="container-flex-inscription">
            <div class="vue-liste">
                <p class="list-toggle">Fermer la vue liste <i class="fa-solid fa-xmark"></i></p>
                <ul>
                    <?php foreach(\Agcsi\CPT\Camp::all_not_past() as $camp): ?>
                        <li style="background-color:<?php echo get_field('couleur',$camp->post) ?>;">
                            <h4><?php echo esc_html($camp->post->post_title) ?> | <small><?php echo $camp->get_valid_days()[0] ?></small> </h4>
                            <p><?php echo $camp->get_highest_disponibility() ?> places disponible <a href="<?php echo esc_url(get_the_permalink($camp->ID)) ?>">Inscription</a></p>
                            
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="vue-calendar">
                <p class="list-toggle">Ouvrir la vue liste <i class="fa-solid fa-list"></i></p>
                <div id="calendrier_camps"></div>
                <p class="note-calendrier"><?php echo get_option( 'note_sous_calendrier' )?></p>
            </div>
        </div>
    </div>
</main>
<?php  get_footer(); ?>