<?php
if(agcsi_is_edit_page('new')): ?>
    <h3><strong>Enregistrer le camps pour une première fois avant d'éditer l'horaire. Sauvegarder en tant que brouillon pour éviter qu'il s'affiche pour les utilisateur.</strong></h3>
<?php else :
    $is_published = 'publish' === get_post_status( $post->ID );
    $camp = \Agcsi\CPT\Camp::get($post->ID);
    $nb_places = get_field('disponibilite',$post);
    $participations = [];
    foreach($camp->get_valid_days() as $date){
        $participations[$date] = $camp->get_participants_for_day($date);
    }
?>
<table>
    <?php foreach($participations as $date=>$participant): ?>
        <th><?php echo $date ?></th>
    <?php endforeach; ?>
    <?php for($i = 0;$i<$nb_places ;$i++ ): ?>
        <tr>
            <?php foreach($participations as $date=>$participants_date): ?>
                <td><?php echo isset($participants_date[$i])?$participants_date[$i]->prenom:'disponible' ?></td>
            <?php endforeach; ?> 
        </tr>
    <?php endfor; ?>
</table>
<?php endif;?>