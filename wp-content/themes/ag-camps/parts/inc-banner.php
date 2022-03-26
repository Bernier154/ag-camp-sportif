<section class="banner <?php echo get_field('small')?'is-small':''; ?>">
    <figure>
        <?php 
            $image = get_field('image_heros');
            $size = 'full'; // (thumbnail, medium, large, full or custom size)
            if( $image ) {
                echo wp_get_attachment_image( $image, $size );
            }
        ?>
    </figure>
    <div class="content-on-image content">
        <?php if(get_field('titre_formate')):  ?>
            <?php the_field('titre_formate'); ?>
        <?php else: ?>
            <h1><?php the_title() ?></h1>
        <?php endif; ?>
    </div>
</section>