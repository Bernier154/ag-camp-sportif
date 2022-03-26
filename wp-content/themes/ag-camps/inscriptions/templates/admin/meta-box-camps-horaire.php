<?php
if(agcsi_is_edit_page('new')): ?>
    <h3><strong>Enregistrer le camps pour une première fois avant d'éditer l'horaire. Sauvegarder en tant que brouillon pour éviter qu'il s'affiche pour les utilisateur.</strong></h3>
<?php else :
    $is_published = 'publish' === get_post_status( $post->ID );
    $nb_places = get_field('disponibilite',$post);
?>
<table>
    <?php foreach(agcsi_is_get_valid_days_for_camp($post) as $date): ?>
        <th><?php echo $date ?></th>
    <?php endforeach; ?>
    <?php for($i = 0;$i<$nb_places;$i++ ): ?>
        <tr>
            <?php foreach(agcsi_is_get_valid_days_for_camp($post) as $date): ?>
                <td><?php echo 'diponible' ?></td>
            <?php endforeach; ?> 
        </tr>
    <?php endfor; ?>
</table>
<?php endif;?>