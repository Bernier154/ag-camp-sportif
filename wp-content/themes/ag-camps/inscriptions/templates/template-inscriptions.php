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
        <div id="calendrier_camps"></div>
        <p class="note-calendrier"><?php echo get_option( 'note_sous_calendrier' )?></p>
    </div>

</main>
<?php  get_footer(); ?>