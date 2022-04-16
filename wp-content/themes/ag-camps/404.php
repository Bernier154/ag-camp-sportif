<?php get_header(); ?>



<main id="main" class="site-main-wrapper ">
    <?php get_template_part('parts/inc','banner') ?>
    <div class="content page-404">
        <h2>Cette page est introuvable.</h2>
        <!-- <h2>Page introuvable.</h2> -->
        <div class="wp-block-buttons">
            <div class="wp-block-button">
                <a class="wp-block-button__link" href="<?php echo home_url('/') ?>">Retourner à l'accueil</a>
            </div>
        </div>
    </div>  
</main
 


<?php  get_footer(); ?>



