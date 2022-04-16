<?php 
    $title = '';
    if(is_404()){
        $title = '<h1>404</h1>';
        add_filter('banner_size','__return_true');
    }else if(get_field('titre_formate')){
        $title = get_field('titre_formate');
    }else{
        $title = '<h1>'.get_the_title().'</h1>';
    }

?>
<section class="banner <?php echo apply_filters('banner_size',get_field('small'))?'is-small':''; ?>">
    <figure>
        <?php 
            $image = apply_filters('banner_image',get_field('image_heros'));
            $size = 'full'; // (thumbnail, medium, large, full or custom size)
            if( $image ) {
                echo wp_get_attachment_image( $image, $size );
            }
        ?>
    </figure>
    <div class="content-on-image content">
        <?php echo $title; ?>
    </div>
</section>

