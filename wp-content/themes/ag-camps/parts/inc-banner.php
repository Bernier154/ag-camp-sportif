<section class="banner">
    <figure>
        <?php 
        $image = get_field('image_heros');
        $size = 'full'; // (thumbnail, medium, large, full or custom size)
        if( $image ) {
            echo wp_get_attachment_image( $image, $size );
        }?>
    </figure>
    <div class="content-on-image content">
        <?php the_field('titre_formate')?>
    </div>
</section>